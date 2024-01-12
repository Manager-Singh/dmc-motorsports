<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attributekey extends Model
{
    protected $fillable=['wps_id','name'];
    protected $primaryKey = 'wps_id';

    public function attributevalues(){
        return $this->hasMany('App\Models\Attributevalue','childattributekey_id_cat_id','wps_id');
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
       
        $record = self::create($ndata);

     

        return $record;
    }
}
