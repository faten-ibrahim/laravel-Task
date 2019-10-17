<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'main_title', 'secondary_title', 'start_date', 'end_date', 'location', 'location_lat', 'location_lang'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'start_date',
        'end_date'
    ];
    /**
     * Get the event's images.
     */
    public function files()
    {
        return $this->morphMany('App\File', 'fileable');
    }

    public function visitors()
    {
        return $this->hasMany(Visitor::class);
    }
}
