<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes;
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
        return $this->belongsToMany(RelatedNews::class,'related_news', 'news_id', 'related_news_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', 1);
    }

    public function scopeOfId($query, $id)
    {
        return $query->where('id','!=', $id);
    }
}
