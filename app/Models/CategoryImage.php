<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryImage extends Model
{
    protected $fillable=['category_id','image_id'];
    public function image(){
        return $this->belongsTo('App\Models\Image','image_id','wps_id');        
     }
}
