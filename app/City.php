<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'country_id'
    ];


    public function country()
    {
        return $this->belongsTo(Country::class)->select(array('id', 'full_name'));
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function visitors()
    {
        return $this->hasMany(Visitor::class);
    }
}
