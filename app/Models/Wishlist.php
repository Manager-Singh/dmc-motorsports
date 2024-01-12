<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable=['user_id','guest_id','product_id','cart_id','price','amount','quantity'];

    public function product(){
        return $this->belongsTo(Item::class,'product_id');
    }
}
