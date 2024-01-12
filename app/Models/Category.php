<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\CategoryImage;
use Helper;

class Category extends Model
{
    protected $fillable=['title','wps_id','vocabulary_id','slug','summary','photo','status','is_parent','parent_id','added_by'];
    protected $primaryKey = 'wps_id';
    public function parent_info(){
        return $this->hasOne('App\Models\Category','wps_id','parent_id');
    }
    public static function getAllCategory(){
        return  Category::orderBy('id','DESC')->with('parent_info')->paginate(10);
    }

    public static function shiftChild($cat_id){
        return Category::whereIn('id',$cat_id)->update(['is_parent'=>1]);
    }
    public static function getChildByParentID($id){
        return Category::where('parent_id',$id)->orderBy('wps_id','ASC')->pluck('title','wps_id');
    }

    public function child_cat(){
        return $this->hasMany('App\Models\Category','parent_id','wps_id')->where('status','active');
    }
    public static function getAllParentWithChild(){
        return Category::has('items')->with('child_cat')->where('is_parent',1)->where('status','active')->orderBy('title','ASC')->get();
    }
    public function products(){
        return $this->hasMany('App\Models\Product','cat_id','id')->where('status','active');
    }
   
    public function sub_products(){
        return $this->hasMany('App\Models\Product','child_cat_id','id')->where('status','active');
    }
    public static function getProductByCat($slug){
        dd($slug);
        // return Category::with('items')->where('wps_id',$slug)->first();
        // return Product::where('cat_id',$id)->where('child_cat_id',null)->paginate(10);
    }
    public static function getProductBySubCat($slug){
        // return $slug;
        return Category::with('sub_products')->where('wps_id',$slug)->first();
    }
    public static function countActiveCategory(){
        $data=Category::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }

    public function images(){
        return $this->hasOne('App\Models\CategoryImage','category_id','wps_id');        
     }
    //  public function items(){
    //     return $this->hasMany('App\Models\ItemCategory','category_id','wps_id');
    // }
    
    public function items()
    {
        return $this->belongsToMany('App\Models\Item', 'item_categories', 'category_id', 'item_id');
    }
    public static function createRecord($data)
    {
        // print_r($data['images']);
        // die;
       
        // $existingRecord = self::where('wps_id', $data['id'])->first();
       
        // // If the record already exists, return it
        // if ($existingRecord) {
        //     return $existingRecord;
        // }

        // $slug=Str::slug($data['name']);
        // $count=self::where('slug',$slug)->count();
        // if($count>0){
        //     $slug=$slug.'-'.date('ymdis').'-'.Helper::generateRandomString(4).'-'.$data['id'];
        // }nameary_id'] = $data['vocabulary_id'];
        // $ndata['title']= $data['name'];
        // $ndata['slug']= $slug;
        // $ndata['summary']= $data['description'];
        // if(isset($data['parent_id'])){
        //     $ndata['is_parent']= 0;
        // }else{
        //     $ndata['is_parent']= 1;
        // }
        // $ndata['parent_id']= $data['parent_id'];
        // $ndata['status']= 'active';
       
        // $record = self::create($ndata);
         if(isset($data['parent_id'])){
            $is_parent= 0;
        }else{
            $is_parent= 1;
        }

     

        // return $record;
        $product_item_item_taxonomyterm = self::updateOrCreate(
            ['wps_id' => $data['id']],
            [
                'wps_id' => $data['id'],
                'vocabulary_id' => $data['vocabulary_id'],
                'parent_id' => $data['parent_id'],
                'title' => $data['name'],
                'slug' => Str::uuid(),
                'description' => $data['description'],
                'link' => $data['link'],
                'link_target_blank' => $data['link_target_blank'],
                'left' => $data['left'],
                'right' => $data['right'],
                'depth' => $data['depth'],
                'status'=>'active',
                'is_parent' =>$is_parent
                // ... other fields
            ]
        );
        if(count($data['images']['data'])>0){
            CategoryImage::updateOrCreate(
                [
                    'category_id' => $product_item_item_taxonomyterm->wps_id,
                    'image_id' =>$data['images']['data'][0]['id']
                ],
                [
                    'category_id' => $product_item_item_taxonomyterm->wps_id,
                    'image_id' => $data['images']['data'][0]['id'],
                    // ... other fields
                ]
            );
        }
        return $product_item_item_taxonomyterm;
    }
}
