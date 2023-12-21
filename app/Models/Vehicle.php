<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable=['wps_id','vehiclemodel_id','vehicleyear_id'];
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
        $ndata['vehiclemodel_id']= $data['vehiclemodel_id'];
        $ndata['vehicleyear_id']= $data['vehicleyear_id'];
        $record = self::create($ndata);

        return $record;
    }
    public function vehicleyear(){
        return $this->belongsTo('App\Models\Vehicleyear','vehicleyear_id','wps_id');
    }
    public function vehiclemodel(){
        return $this->belongsTo('App\Models\Vehiclemodel','vehiclemodel_id','wps_id');
    }
    public function items()
    {
        return $this->belongsToMany('App\Models\Item', 'item_vehicles', 'vehicle_id', 'item_id'); // Specify a different alias for the pivot table
    }

}