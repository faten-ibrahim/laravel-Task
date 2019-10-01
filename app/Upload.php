<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','image_name','image_url'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
