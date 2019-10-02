<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model 
{
    protected $table = "users";
    
    public function city()
    {
        return $this->belongsTo(City::class)->select(array('id', 'name','country_id'));
    }

}
