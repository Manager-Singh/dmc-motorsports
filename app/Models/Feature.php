<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable=['wps_id','product_id','icon_id','name','sort'];
    protected $primaryKey = 'wps_id';
    public static function createRecord($data)
    {
     
        $existingRecord = self::where('wps_id', $data['id'])->first();
       
        // If the record already exists, return it
        if ($existingRecord) {
            return $existingRecord;
        }

        $ndata = [];
        $ndata['wps_id'] = $data['id'];
        $ndata['product_id'] = $data['product_id'];
        $ndata['icon_id'] = $data['icon_id'];
        $ndata['name'] = $data['name'];
        $ndata['sort'] = $data['sort'];
        $record = self::create($ndata);

        return $record;
    }
}
