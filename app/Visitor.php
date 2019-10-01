<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Cog\Contracts\Ban\Bannable as BannableContract;
use Cog\Laravel\Ban\Traits\Bannable;
class Visitor extends Model implements BannableContract
{
    use Bannable;
    protected $table = "users";
    
    public function city()
    {
        return $this->belongsTo(City::class)->select(array('id', 'name','country_id'));
    }

}