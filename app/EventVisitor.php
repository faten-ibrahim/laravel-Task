<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class EventVisitor extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'event_id','visitor_id'
    ];

    
}
