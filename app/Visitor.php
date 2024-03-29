<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
class Visitor extends Model 
{
    use SoftDeletes,Notifiable;
    protected $table = "users";
    protected $fillable = [
        'first_name', 'last_name', 'phone', 'email', 'password', 'gender', 'country_id', 'city_id'
    ];

    public function city()
    {
        return $this->belongsTo(City::class)->select(array('id', 'name','country_id'));
    }

    public function file()
    {
        return $this->morphOne('App\File', 'fileable');
    }


    public function event()
    {
        return $this->belongsToMany(Event::class,'event_visitor','visitor_id','event_id');
    }


}
