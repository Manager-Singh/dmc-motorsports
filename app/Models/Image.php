<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable=['wps_id','domain','path','filename','alt','mime','width','height','size','signature'];
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
        $ndata['domain'] = $data['domain'];
        $ndata['path'] = $data['path'];
        $ndata['filename'] = $data['filename'];
        $ndata['alt'] = $data['alt'];
        $ndata['mime'] = $data['mime'];
        $ndata['width'] = $data['width'];
        $ndata['height'] = $data['height'];
        $ndata['size'] = $data['size'];
        $ndata['signature'] = $data['signature'];
        $record = self::create($ndata);

        return $record;
    }
}
