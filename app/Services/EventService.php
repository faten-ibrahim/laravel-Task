<?php
namespace App\Services;

use App\Event;

class EventService
{
    public function getEventVisitors($event)
    {
        return $event->visitors()
                ->where('is_active',true)->select('visitor_id as id','first_name','last_name','email')->get();
    }


}