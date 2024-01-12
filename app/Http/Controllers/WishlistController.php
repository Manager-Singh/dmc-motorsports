<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Item;
use App\Models\Wishlist;
class WishlistController extends Controller
{
    protected $product=null;
    public function __construct(Product $product){
        $this->product=$product;
    }

    public function wishlist(Request $request){
        // dd($request->slug);
        if (empty($request->slug)) {
            request()->session()->flash('error','Invalid Products');
            return back();
        }        

        $product = Item::where('slug', $request->slug)->first();
        $stock = getInventory($product->wps_id);
        // return $product;
        if (empty($product)) {
            request()->session()->flash('error','Invalid Products');
            return back();
        }
        if (auth()->check()) {
            $already_wishlist = Wishlist::where('user_id', auth()->user()->id)->where('cart_id',null)->where('product_id', $product->wps_id)->first();
            }else{
                
            $already_wishlist = Wishlist::where('guest_id', $request->session()->get('guest_id'))->where('cart_id',null)->where('product_id', $product->wps_id)->first();

              
            }
        
        // return $already_wishlist;
        if($already_wishlist) {
            request()->session()->flash('error','You already placed in wishlist');
            return back();
        }else{
            
            $wishlist = new Wishlist;
           
            if (auth()->check()) {
                $wishlist->user_id = auth()->user()->id;
                }else{
                    $wishlist->guest_id = $request->session()->get('guest_id');   
                }
            $wishlist->product_id = $product->wps_id;
            $wishlist->price = ($product->list_price-($product->list_price*$product->discount)/100);
            $wishlist->quantity = 1;
            $wishlist->amount=$wishlist->price*$wishlist->quantity;
            if ($stock < $wishlist->quantity || $stock <= 0) return back()->with('error','Stock not sufficient!.');
            $wishlist->save();
        }
        request()->session()->flash('success','Product successfully added to wishlist');
        return back();       
    }  
    
    public function wishlistDelete(Request $request){
        $wishlist = Wishlist::find($request->id);
        if ($wishlist) {
            $wishlist->delete();
            request()->session()->flash('success','Wishlist successfully removed');
            return back();  
        }
        request()->session()->flash('error','Error please try again');
        return back();       
    }     
}
