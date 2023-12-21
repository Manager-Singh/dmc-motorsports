<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Endpoint extends Model
{
    protected $fillable=['endpoint','include','api_token','request_type','status','sync','prev','current','table_name','filter','filter_value'];
 
}
