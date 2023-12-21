<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;
class Product extends Model
{
    // protected $fillable=['title','slug','summary','description','cat_id','child_cat_id','price','brand_id','discount','status','photo','size','stock','is_featured','condition'];
    protected $fillable=['wps_id','designation_id','name','slug','alternate_name','care_instructions','description','sort','status','image_360_id','image_360_preview_id','size_chart_id','is_featured'];
    protected $primaryKey = 'wps_id';
    // public function cat_info(){
    //     return $this->hasOne('App\Models\Category','id','cat_id');
    // }
    // public function sub_cat_info(){
    //     return $this->hasOne('App\Models\Category','id','child_cat_id');
    // }
    // public static function getAllProduct(){
    //     return Product::with(['cat_info','sub_cat_info'])->orderBy('id','desc')->paginate(10);
    // }
    // public function rel_prods(){
    //     return $this->hasMany('App\Models\Product','cat_id','cat_id')->where('status','active')->orderBy('id','DESC')->limit(8);
    // }
    // public function getReview(){
    //     return $this->hasMany('App\Models\ProductReview','product_id','id')->with('user_info')->where('status','active')->orderBy('id','DESC');
    // }
    // public static function getProductBySlug($slug){
    //     return Product::with(['cat_info','rel_prods','getReview'])->where('slug',$slug)->first();
    // }
    public static function countActiveProduct(){
        $data=Product::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }

    // public function carts(){
    //     return $this->hasMany(Cart::class)->whereNotNull('order_id');
    // }

    // public function wishlists(){
    //     return $this->hasMany(Wishlist::class)->whereNotNull('cart_id');
    // }

    // public function brand(){
    //     return $this->hasOne(Brand::class,'id','brand_id');
    // }
    public function items(){
        return $this->hasMany('App\Models\Item','product_id');
    }
    public function photo(){
       // return $this->hasMany('');
        return $this->belongsToMany('App\Models\Image', 'product_images', 'product_id', 'image_id');
    }
   
   
    public function resources(){
        return $this->belongsToMany('App\Models\Resource');
    }
    
    public function tags(){
        return $this->hasMany('App\Models\ProductTag','product_id','wps_id');
    }
    public function features(){
        return $this->hasMany('App\Models\Feature','product_id');
    }

}
