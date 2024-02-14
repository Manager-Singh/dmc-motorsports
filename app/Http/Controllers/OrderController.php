<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
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
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Stripe\Error\Card;
use Stripe\Exception\CardException;
use Stripe\StripeClient;
use Validator;
use Stripe\Token;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders=Order::orderBy('id','DESC')->paginate(10);
        return view('backend.order.index')->with('orders',$orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        if (auth()->guest()) {
            $this->validate($request,[
                'first_name'=>'string|required',
                'last_name'=>'string|required',
                'address1'=>'string|required',
                'address2'=>'string|nullable',
                'coupon'=>'nullable|numeric',
                'phone'=>'numeric|required',
                'post_code'=>'string|nullable',
                'email'=>'string|required',
                'password'=>'string|required|min:8',
            ]);
        }else{
            $this->validate($request,[
                'first_name'=>'string|required',
                'last_name'=>'string|required',
                'address1'=>'string|required',
                'address2'=>'string|nullable',
                'coupon'=>'nullable|numeric',
                'phone'=>'numeric|required',
                'post_code'=>'string|nullable',
                'email'=>'string|required',
                
            ]);
        }

        // if($request->payment_method=='online'){
        //     $this->validate($request,[
        //         'cardNumber'=>'required',
        //         'expmonth'=>'required',
        //         'expyear'=>'required',
        //         'cvv'=>'required',
                
        //     ]);
        // }

      
        // dd($request->all());
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

        // cardNumber
        // expmonth
        // expyear
        // cvv
          

        $order=new Order();
        $order_data=$request->all();
        $order_data['order_number']='ORD-'.strtoupper(Str::random(10));
        
       

        if (auth()->check()) {
            $order_data['user_id']= auth()->user()->id;
            }else{
                $order_data['guest_id']=$request->session()->get('guest_id');
            }
            if(Helper::totalCartPrice()<=150 || Helper::checkIfCartHasItemswithTires()>0){
                 $order_data['shipping_id']=1;
            }
        // return session('coupon')['value'];
        $order_data['sub_total']=Helper::totalCartPrice();
        $order_data['quantity']=Helper::cartCount();
        if(session('coupon')){
            $order_data['coupon']=session('coupon')['value'];
        }
        // if($request->shipping){
            if(Helper::totalCartPrice()<=150 || Helper::checkIfCartHasItemswithTires()>0){
                $shipping=Shipping::where('id',$order_data['shipping_id'])->pluck('price');
                $order_data['total_amount']=Helper::totalCartPrice()+$shipping[0];
                $order_data['shiping_amount']= $shipping;
                
            }
            else{
                $order_data['total_amount']=Helper::totalCartPrice()+0;
            }
        // }
        //else{
            // if(session('coupon')){
            //     $order_data['total_amount']=Helper::totalCartPrice()-session('coupon')['value'];
            // }
            // else{
            //     $order_data['total_amount']=Helper::totalCartPrice();
            // }
       // }
        // return $order_data['total_amount'];
        $order_data['status']="new";
        if($request->payment_method=='paypal'){
            $order_data['payment_method']='paypal';
            $order_data['payment_status']='unpaid';
        }
        else if($request->payment_method=='stripe'){
            $order_data['payment_method']='stripe';
            $order_data['payment_status']='unpaid';  
        }
        else{
            $order_data['payment_method']='cod';
            $order_data['payment_status']='Unpaid';
        }
        $order->fill($order_data);
        $status=$order->save();
        if($order)

        
       

        
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
        }
        else if($request->payment_method=='stripe'){
           
            if ($request->payment_method=='stripe') { 
            
                \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

           
                 
            
                if (!isset($request->stoken)) {
                return redirect()->back();
                }
                // if($request->shipping){
                    // $shipping=Shipping::where('id',$request->shipping)->pluck('price');
                    $shipping=Shipping::where('id',1)->pluck('price');
                    if(Helper::totalCartPrice()<=150 ||  Helper::checkIfCartHasItemswithTires()>0){
                        $ptotal=Helper::totalCartPrice()+$shipping[0];
                    }
                    else{
                        $ptotal=Helper::totalCartPrice()+0;
                    }
                // }
                // else{
                //     if(session('coupon')){
                //         $ptotal=Helper::totalCartPrice()-session('coupon')['value'];
                //     }
                //     else{
                //         $ptotal=Helper::totalCartPrice();
                //     }
                // }

                // print_r($ptotal);
                // die;
                try{
                    $charge = \Stripe\Charge::create([
                      'amount' => $ptotal*100,
                      'currency' => 'usd',
                      'source' => $request->stoken,
                      'description' => $order->order_number.' Order Created by '.$order->email,
                    ]);
                    if( $charge->id){
                        Order::where('id', $order->id)
                        ->update(['payment_status' => 'paid','transaction_id' => $charge->balance_transaction]);
                        // session()->forget('cart');
                        // session()->forget('coupon');
                    }


                } catch(\Stripe\Exception\CardException $e) {
                    return back()->with('message', $e->getError()->message);
                } catch (\Stripe\Exception\RateLimitException $e) {
                  return back()->with('message', $e->getError()->message);
                } catch (\Stripe\Exception\InvalidRequestException $e) {
                  return back()->with('message', $e->getError()->message);
                } catch (\Stripe\Exception\AuthenticationException $e) {
                 return back()->with('message', $e->getError()->message);
                } catch (\Stripe\Exception\ApiConnectionException $e) {
                 return back()->with('message', $e->getError()->message);
                } catch (\Stripe\Exception\ApiErrorException $e) {
                  return back()->with('message', $e->getError()->message);
                } catch (Exception $e) {
                  return back()->with('message', $e->getError()->message);
                }
               
              
            }
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
       
        // dd($users);
        
        $morder=Order::getAllOrder($order->id);

        $mail = new PHPMailer(true);     // Passing `true` enables exceptions
 


            // Email server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = env('MAIL_HOST');             //  smtp host
            $mail->SMTPAuth = true;
            $mail->Username = env('MAIL_USERNAME');   //  sender username
            $mail->Password = env('MAIL_PASSWORD');       // sender password
            $mail->SMTPSecure = env('MAIL_ENCRYPTION');                  // encryption - ssl/tls
            $mail->Port = env('MAIL_PORT');                          // port - 587/465

            $mail->setFrom(env('MAIL_FROM_ADDRESS'), 'DMC Motorsports');
            $mail->addAddress($morder->email);
        //  $mail->addBCC($request->emailBcc);

            // $mail->addReplyTo('sender@example.com', 'SenderReplyName');

            // if(isset($_FILES['emailAttachments'])) {
            //     for ($i=0; $i < count($_FILES['emailAttachments']['tmp_name']); $i++) {
            //         $mail->addAttachment($_FILES['emailAttachments']['tmp_name'][$i], $_FILES['emailAttachments']['name'][$i]);
            //     }
            // }
            $htmlContent = view('emails.pdf', compact('order'))->render();

            $mail->isHTML(true);                // Set email content format to HTML

            $mail->Subject = 'Order'. $morder->order_number;
            $mail->Body    = $htmlContent;
            $mail->send();
            // } catch (Exception $e) {
 //      return back()->with('error','Message could not be sent.');
 // }

     // $mail->AltBody = plain text version of email body;

     

 
        request()->session()->flash('success','Your product successfully placed in order');
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order=Order::find($id);
        // return $order;
        return view('backend.order.show')->with('order',$order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order=Order::find($id);
        return view('backend.order.edit')->with('order',$order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order=Order::find($id);
        $this->validate($request,[
            'status'=>'required|in:new,process,delivered,cancel'
        ]);
        if($request->status=="process"){
            $this->validate($request,[
                'tracking_number'=>'required',
                'tracking_url'=>'required'
               
            ]); 
        }
        $data=$request->all();
        // return $request->status;
        // if($request->status=='delivered'){
        //     foreach($order->cart as $cart){
        //         $product=$cart->product;
        //         // return $product;
        //         $product->stock -=$cart->quantity;
        //         $product->save();
        //     }
        // }
        $status=$order->fill($data)->save();
        if($status){
            request()->session()->flash('success','Successfully updated order');
        }
        else{
            request()->session()->flash('error','Error while updating order');
        }
        return redirect()->route('order.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $order=Order::find($id);
        if($order){
            Cart::where('order_id', $id)->delete();
            $status=$order->delete();
            if($status){
                request()->session()->flash('success','Order Successfully deleted');
            }
            else{
                request()->session()->flash('error','Order can not deleted');
            }
            return redirect()->route('order.index');
        }
        else{
            request()->session()->flash('error','Order can not found');
            return redirect()->back();
        }
    }

    public function orderTrack(){
        return view('frontend.pages.order-track');
    }

    public function productTrackOrder(Request $request){
        // return $request->all();
        //where('user_id',auth()->user()->id)->
        $order=Order::where('order_number',trim($request->order_number))->first();
        if($order){
            if($order->status=="new"){
            request()->session()->flash('success','Your order has been placed. please wait.');
           // return redirect()->route('home');

            }
            elseif($order->status=="process"){
                request()->session()->flash('success','Your order is under processing please wait.');
              //  return redirect()->route('home');
    
            }
            elseif($order->status=="delivered"){
                request()->session()->flash('success','Your order is successfully delivered.');
                //return redirect()->route('home');
    
            }
            else{
                request()->session()->flash('error','Your order canceled. please try again');
               // return redirect()->route('home');
    
            }
            return view('frontend.pages.order-track')->with('order',$order);
            
        }
        else{
            request()->session()->flash('error','Invalid order numer please try again');
            return back();
        }
    }

    // PDF generate
    public function pdf(Request $request){
        $order=Order::getAllOrder($request->id);
        
        // return $order;
        $file_name=$order->order_number.'-'.$order->first_name.'.pdf';
        // return $file_name;
        $pdf=PDF::loadview('backend.order.pdf',compact('order'));
        return $pdf->download($file_name);
    }
    // Income chart
    public function incomeChart(Request $request){
        $year=\Carbon\Carbon::now()->year;
        // dd($year);
        $items=Order::with(['cart_info'])->whereYear('created_at',$year)->where('status','delivered')->get()
            ->groupBy(function($d){
                return \Carbon\Carbon::parse($d->created_at)->format('m');
            });
            // dd($items);
        $result=[];
        foreach($items as $month=>$item_collections){
            foreach($item_collections as $item){
                $amount=$item->cart_info->sum('amount');
                // dd($amount);
                $m=intval($month);
                // return $m;
                isset($result[$m]) ? $result[$m] += $amount :$result[$m]=$amount;
            }
        }
        $data=[];
        for($i=1; $i <=12; $i++){
            $monthName=date('F', mktime(0,0,0,$i,1));
            $data[$monthName] = (!empty($result[$i]))? number_format((float)($result[$i]), 2, '.', '') : 0.0;
        }
        return $data;
    }
}
