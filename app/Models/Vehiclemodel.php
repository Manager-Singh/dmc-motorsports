<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiclemodel extends Model
{
    protected $fillable=['wps_id','vehiclemake_id','db2_key','name'];

    public static function createRecord($data)
    {
     
        $existingRecord = self::where('wps_id', $data['id'])->first();
       
        // If the record already exists, return it
        if ($existingRecord) {
            return $existingRecord;
        }

     
        $ndata = [];
        $ndata['wps_id'] = $data['id'];
        $ndata['vehiclemake_id']= $data['vehiclemake_id'];
        $ndata['db2_key']= $data['db2_key'];
        $ndata['name']= $data['name'];
        $record = self::create($ndata);

        return $record;
    }
}
