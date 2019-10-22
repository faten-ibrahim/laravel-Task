<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Event extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'main_title', 'secondary_title', 'content', 'start_date', 'end_date', 'location', 'location_lat', 'location_lang','cover_image'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'start_date',
        'end_date'
    ];
    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] =  Carbon::parse($value);
    }
    public function setEndDateAttribute($value)
    {
        $this->attributes['end_date'] =  Carbon::parse($value);
    }

    // public function getStartDateAttribute($value)
    // {
    //     return $this->attributes['start_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('Y-m-d H:i:s');
    // }
    // public function getEndDateAttribute($value)
    // {
    //     return $this->attributes['end_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('Y-m-d H:i:s');
    // }

    /**
     * Get the event's images.
     */
    public function files()
    {
        return $this->morphMany('App\File', 'fileable');
    }

    public function visitors()
    {
        return $this->belongsToMany(Visitor::class, 'event_visitor', 'event_id', 'visitor_id');
    }

    public function scopeToday($query)
    {
        return $query
            ->whereDate('start_date', '=', Carbon::today());
    }

    public function scopeNotToday($query)
    {
        return $query
            ->whereDate('end_date', '!=', Carbon::today());
    }
}
