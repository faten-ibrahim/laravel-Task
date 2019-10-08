<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'main_title', 'secondary_title', 'type', 'author', 'content'
    ];

    /**
     * Get the post's image.
     */
    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }

      /**
     * Get the post's image.
     */
    public function files()
    {
        return $this->morphOne('App\File', 'fileable');
    }

    public function staffMember()
    {
        return $this->belongsTo(StaffMember::class);
    }

}