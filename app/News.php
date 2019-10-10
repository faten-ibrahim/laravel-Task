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
        'main_title', 'secondary_title', 'type', 'staff_member_id', 'content'
    ];

    /**
     * Get the post's image.
     */
    // public function images()
    // {
    //     return $this->morphMany('App\Image', 'imageable');
    // }

      /**
     * Get the post's image.
     */
    public function files()
    {
        return $this->morphMany('App\File', 'fileable');
    }

    public function staffMember()
    {
        return $this->belongsTo(StaffMember::class);
    }

    public function relatedNews()
    {
        return $this->hasMany(RelatedNews::class);
    }

}
