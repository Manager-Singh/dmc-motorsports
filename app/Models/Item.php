<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable=[
        'id',
        'wps_id',
        'brand_id',
        'country_id',
        'product_id',
        'name',
        'slug',
        'sku',
        'list_price',
        'standard_dealer_price',
        'supplier_product_id',
        'length',
        'width',
        'height',
        'weight',
        'upc',
        'superseded_sku',
        'status_id',
        'status',
        'unit_of_measurement_id',
        'has_map_policy',
        'sort',
        'product_type',
        'mapp_price',
        'carb',
        'propd1',
        'propd2',
        'prop_65_code',
        'prop_65_detail',
        'drop_ship_fee',
        'drop_ship_eligible',
    ];

    protected $primaryKey = 'wps_id';

     public static function getAllProduct(){
        return Item::with(['cat_info','sub_cat_info'])->orderBy('id','desc')->paginate(10);
    }
    public function images(){
        // return $this->hasMany('');
        //  return $this->belongsToMany('App\Models\Image', 'item_images');
        return $this->belongsToMany(Image::class, 'item_images', 'item_id', 'image_id');
     }
     public function brand(){
        // return $this->hasMany('');
        //  return $this->belongsToMany('App\Models\Image', 'item_images');
        return $this->belongsTo('App\Models\Brand', 'brand_id', 'wps_id');
     }
     public function country(){
        // return $this->hasMany('');
        //  return $this->belongsToMany('App\Models\Image', 'item_images');
        return $this->belongsTo('App\Models\Country', 'country_id', 'wps_id');
     }
     public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'item_categories', 'item_id', 'category_id');
    }
    public function attributevalues()
    {
        return $this->belongsToMany(Attributevalue::class, 'item_attributevalues', 'item_id', 'attributevalue_id');
    }
    public function vehicles()
    {
        return $this->belongsToMany('App\Models\Vehicle', 'item_vehicles', 'item_id', 'vehicle_id'); // Specify a different alias for the pivot table
    }
      public function getReview(){
        return $this->hasMany('App\Models\ProductReview','product_id','wps_id')->with('user_info')->where('status','active')->orderBy('id','DESC');
    }
     public static function getProductBySlug($slug){
        return Item::with(['inventory','product','product.features','images','brand','country','categories','vehicles'])->where('slug',$slug)->first();
    }
    public function product(){
        // return $this->hasMany('');
        //  return $this->belongsToMany('App\Models\Image', 'item_images');
        return $this->belongsTo('App\Models\Product', 'product_id', 'wps_id');
     }
     public function inventory(){
        return $this->hasOne('App\Models\Inventory', 'item_id', 'wps_id');
     }
     public function itemCategories()
        {
            return $this->hasMany(ItemCategory::class);
        }
     

     
}
