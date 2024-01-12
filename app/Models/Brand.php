<?php

namespace App\Models;
use App\Models\Product;
use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model
{
    protected $fillable=['wps_id','title','slug','status'];

    // public static function getProductByBrand($id){
    //     return Product::where('brand_id',$id)->paginate(10);
    // }
    public function products(){
        return $this->hasMany('App\Models\Item','brand_id','wps_id');
    }
    public static function getProductByBrand($slug){
        // dd($slug);
        return Item::where('wps_id',$slug)->get();
        // return Product::where('cat_id',$id)->where('child_cat_id',null)->paginate(10);
    }
    public function items(){
        return $this->hasMany('App\Models\Item','brand_id','wps_id');
    }
    public static function createRecord($data)
    {
     
        $existingRecord = self::where('wps_id', $data['id'])->first();

      
       
        // If the record already exists, return it
        if ($existingRecord) {
            return $existingRecord;
        }
        $slug=Str::slug($data['name']);
        $count=self::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
     
        $ndata = [];
        $ndata['wps_id'] = $data['id'];
        $ndata['title']= $data['name'];
        $ndata['slug']= $slug;
        $ndata['status']= 'active';
        $record = self::create($ndata);

        return $record;
    }
}
