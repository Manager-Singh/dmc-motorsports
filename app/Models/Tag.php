<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    protected $fillable=['wps_id','name','slug'];
    public static function createRecord($data)
    {
       
        $existingRecord = self::where('wps_id', $data['id'])->first();
       
        // If the record already exists, return it
        if ($existingRecord) {
            return $existingRecord;
        }

        $slug=Str::slug($data['name']);
        $count=self::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.Helper::generateRandomString(4).'-'.$data['id'];
        }
        $ndata = [];
        $ndata['wps_id'] = $data['id'];
        $ndata['name']= $data['name'];
        $ndata['slug']= $slug;
       
        $record = self::create($ndata);

     

        return $record;
    }
}
