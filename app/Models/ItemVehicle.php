<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemVehicle extends Model
{
    protected $fillable=['item_id','vehicle_id'];

    public function item(){
      //  return $this->belongsTo(Post::class,'post_id','id');
        return $this->belongsTo('App\Models\Item', 'item_id', 'wps_id');
    }

}
