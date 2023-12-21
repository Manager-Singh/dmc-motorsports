<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable=['wps_id','item_id','sku','ca_warehouse','ga_warehouse','id_warehouse','in_warehouse','pa_warehouse','pa2_warehouse','tx_warehouse','total'];
    
    public static function createRecord($data)
    {
       
        $record = self::updateOrCreate(
            ['wps_id' => $data['id']],
            [
                'wps_id' => $data['id'],
                'item_id' => $data['item_id'],
                'sku' => $data['sku'],
                'ca_warehouse' => $data['ca_warehouse'],
                'ga_warehouse' => $data['ga_warehouse'],
                'id_warehouse' => $data['id_warehouse'],
                'in_warehouse' => $data['in_warehouse'],
                'pa_warehouse' => $data['pa_warehouse'],
                'pa2_warehouse' => $data['pa2_warehouse'],
                'tx_warehouse' => $data['tx_warehouse'],
                'total' => $data['total'],
                // ... other fields
            ]
        );

        return $record;
    }
}
