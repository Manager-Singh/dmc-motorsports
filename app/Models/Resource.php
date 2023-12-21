<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{

  
    protected $fillable=['wps_id','name','type','reference'];

    public function products(){
        return $this->belongsToMany('App\Models\Product');
    }


    public static function createRecord($data)
    {
       
        $existingRecord = self::where('wps_id', $data['id'])->first();
       
        // If the record already exists, return it
        if ($existingRecord) {
            return $existingRecord;
        }

        
        $ndata = [];
        $ndata['wps_id'] = $data['id'];
        $ndata['name']= $data['name'];
        $ndata['type']= $data['type'];
        $ndata['reference']= $data['reference'];
       
        $record = self::create($ndata);

     

        return $record;
    }
}
