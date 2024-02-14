<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attributevalue extends Model
{
    protected $fillable=['wps_id','attributekey_id','name'];
    protected $primaryKey = 'wps_id';
    public function items()
    {
        return $this->belongsToMany('App\Models\Item', 'item_attributevalues', 'attributevalue_id', 'item_id');
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
        $ndata['attributekey_id']= $data['attributekey_id'];
        
        $record = self::create($ndata);

     

        return $record;
    }
}
