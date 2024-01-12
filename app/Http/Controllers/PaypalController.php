<?php

namespace App\Http\Controllers;
// use Srmklive\PayPal\Services\ExpressCheckout;
use Illuminate\Http\Request;
use NunoMaduro\Collision\Provider;
use App\Models\Cart;
use App\Models\Item;
use App\Models\Product;
use DB;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use App\Models\Wishlist;
use Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Shipping;
use App\User;
use PDF;
use Notification;
use Helper;
use Illuminate\Support\Str;
use App\Notifications\StatusNotification;
use Illuminate\Support\Facades\Hash;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
class PaypalController extends Controller
{
    public function payment($id)
    {
        // print_r($id);
        // print_r('paypal');
        // dd($request->all());
        // $cart = Cart::where('user_id',auth()->user()->id)->where('order_id',null)->get()->toArray();
        if (auth()->check()) {
            $carts  = Cart::with(['product','product.images'])->where('user_id',auth()->user()->id)->where('order_id',null)->get()->toArray();
            }else{
               // Cart::where('', $request->session()->get('guest_id'))->where('order_id', null)->update(['order_id' => $order->id]);
                $carts  = Cart::with(['product','product.images'])->where('guest_id',request()->session()->get('guest_id'))->where('order_id',null)->get()->toArray();
               
            }
   
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();
            // print_r($paypalToken);
            // die;
            // Assume you have cart items in $request->items, which is an array of items.
           // $items = $request->items;
        
            $purchaseUnits = [];
        
            foreach ($carts as $cart) {
                $purchaseUnits[] = [
                    "amount" => [
                        "currency_code" => 'USD', // Add currency code for each item
                        "value" => $cart['price'], // Add price for each item
                    ],
                    // Add other item details as needed
                ];
            }
        
            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('payment.success'),
                    "cancel_url" => route('payment.cancel'),
                ],
                "purchase_units" => $purchaseUnits,
            ]);
            // print_r($response);
            // die;
            if (isset($response['id']) && $response['id'] != null) {
                // Redirect to approve href
                foreach ($response['links'] as $links) {
                    if ($links['rel'] == 'approve') {
                        return redirect()->away($links['href']);
                    }
                }
                return redirect()->route('payment.cancel')->with('error', 'Something went wrong.');
            } else {
                return redirect()->route('payment.cancel')->with('error', $response['message'] ?? 'Something went wrong.');
            }


     
    }

    public function payment_stripe(Request $request)
    {
        // print_r($order_id);
        // print_r('<br>');
       //dd($request->all());
        //  return $request->all();


        if (auth()->check()) {
            if(empty(Cart::where('user_id',auth()->user()->id)->where('order_id',null)->first())){
                request()->session()->flash('error','Cart is Empty !');
                return back();
            }
            }else{
                if(empty(Cart::where('guest_id',$request->session()->get('guest_id'))->where('order_id',null)->first())){
                    request()->session()->flash('error','Cart is Empty !');
                    return back();
                }
            }
        
       
        if (auth()->guest()) {
            $new_user = User::create([
                'name' => $request->first_name.' '.$request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            Auth::login($new_user);
            Cart::where('guest_id', '=', $request->session()->get('guest_id'))
            ->update([
                'user_id' => auth()->user()->id,
                // Add more columns as needed
            ]);
            Wishlist::where('guest_id', '=', $request->session()->get('guest_id'))
            ->update([
                'user_id' => auth()->user()->id,
                // Add more columns as needed
            ]);
            $request->session()->forget('guest_id');
            // Order::where('guest_id', '=', $request->session()->get('guest_id'))
            // ->update([
            //     'user_id' => auth()->user()->id,
            //     // Add more columns as needed
            // ]);
        }

        $order=new Order();
        $order_data=$request->all();
        $order_data['order_number']='ORD-'.strtoupper(Str::random(10));
        
       

        if (auth()->check()) {
            $order_data['user_id']= auth()->user()->id;
            }else{
                $order_data['guest_id']=$request->session()->get('guest_id');
            }
        $order_data['shipping_id']=$request->shipping;
        $shipping=Shipping::where('id',$order_data['shipping_id'])->pluck('price');
        // return session('coupon')['value'];
        $order_data['sub_total']=Helper::totalCartPrice();
        $order_data['quantity']=Helper::cartCount();
        if(session('coupon')){
            $order_data['coupon']=session('coupon')['value'];
        }
        if($request->shipping){
            if(session('coupon')){
                $order_data['total_amount']=Helper::totalCartPrice()+$shipping[0]-session('coupon')['value'];
            }
            else{
                $order_data['total_amount']=Helper::totalCartPrice()+$shipping[0];
            }
        }
        else{
            if(session('coupon')){
                $order_data['total_amount']=Helper::totalCartPrice()-session('coupon')['value'];
            }
            else{
                $order_data['total_amount']=Helper::totalCartPrice();
            }
        }
        // return $order_data['total_amount'];
        $order_data['status']="new";
        
            $order_data['payment_method']='stripe';
            $order_data['payment_status']='unpaid';
       
        $order->fill($order_data);
        
        if($order->save()){

        

        
       

        
        // dd($order->id);
        $users=User::where('role','admin')->first();
        $details=[
            'title'=>'New order created',
            'actionURL'=>route('order.show',$order->id),
            'fas'=>'fa-file-alt'
        ];
        
        Notification::send($users, new StatusNotification($details));
        if($request->payment_method=='paypal'){
            return redirect()->route('payment',$order->id);
        }else if($request->payment_method=='stripe'){
           
            return redirect()->route('payment.stripe.get',$order->id);
        }
        else{
            session()->forget('cart');
            session()->forget('coupon');
        }
        if (auth()->check()) {
            Cart::where('user_id', auth()->user()->id)->where('order_id', null)->update(['order_id' => $order->id]);
            }else{
                Cart::where('guest_id', $request->session()->get('guest_id'))->where('order_id', null)->update(['order_id' => $order->id]);
               
            }
            $order_items = Cart::where('order_id', $order->id)->get();
            foreach($order_items as $order_item){
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'item_id' => $order_item->product_id,
                ]);
            }
        header('Content-Type: application/json');
        Stripe::setApiKey(env('STRIPE_SECRET'));



        $checkout_session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [

                $this->lineItems()
            ],
            'mode' => 'payment',
            'success_url' => route('payment.success.stripe',$order->id),
            'cancel_url' => route('payment.cancel.stripe',$order->id),
        ]);
            // print_r( $checkout_session);
        //returns session id
        return response()->json(['id' => $checkout_session->id]);
    }

    }
    
    private function lineItems()
    {

        
        // $cartItems  = Cart::with(['product','product.images'])->where('user_id',auth()->user()->id)->where('order_id',null)->get();
        if (auth()->check()) {
            $cartItems  = Cart::with(['product','product.images'])->where('user_id',auth()->user()->id)->where('order_id',null)->get();
            }else{
               // Cart::where('', $request->session()->get('guest_id'))->where('order_id', null)->update(['order_id' => $order->id]);
                $cartItems  = Cart::with(['product','product.images'])->where('guest_id',request()->session()->get('guest_id'))->where('order_id',null)->get();
               
            }
        $lineItems = [];
        foreach ($cartItems as $cartItem) {
           $img =  'http://cdn.wpsstatic.com/images/full/'.$cartItem->product->images[0]->filename;
            $product['price_data'] = [
                'currency' => 'USD',
                'unit_amount' => $cartItem->price * 100,
                'product_data' => [
                    'name' => $cartItem->product->name,
                    'images' => [ $img ],
                ],
            ];
            $product['quantity'] = $cartItem->quantity;
            $lineItems[] = $product;
        }

        return $lineItems;
    }
   
    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel()
    {
        dd('Your payment is canceled. You can create cancel page here.');
    }
  
    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function success(Request $request)
    {
        dd($request->all());
        // $provider = new ExpressCheckout;
        // $response = $provider->getExpressCheckoutDetails($request->token);
        // // return $response;
  
        // if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
        //     request()->session()->flash('success','You payment done successfully! Thank You');
        //     session()->forget('cart');
        //     session()->forget('coupon');
        //     return redirect()->route('home');
        // }
  
        // request()->session()->flash('error','Something went wrong please try again!!!');
        return redirect()->back();
    }
    public function success_stripe(Request $request)
    {
        dd($request->all());
        // $provider = new ExpressCheckout;
        // $response = $provider->getExpressCheckoutDetails($request->token);
        // // return $response;
  
        // if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
        //     request()->session()->flash('success','You payment done successfully! Thank You');
        //     session()->forget('cart');
        //     session()->forget('coupon');
        //     return redirect()->route('home');
        // }
  
        // request()->session()->flash('error','Something went wrong please try again!!!');
        return redirect()->back();
    }
    public function cancel_stripe(Request $request)
    {
        dd('Your stripe payment is canceled. You can create cancel page here.');
    }
    
    public function payment_get_stripe(Request $request)
    {
    dd('get stripe');
    }
}
