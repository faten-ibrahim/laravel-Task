<?php

namespace App\Services;

use App\Event;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Database\RuleSet;

class FirebaseService
{
    private $eventsTable;
    private $database;
    public function __construct()
    {
        $factory = (new Factory())
            ->withServiceAccount(__DIR__ . '/ibtikar-bd261-firebase-adminsdk-nec93-b756139d70.json');
        $this->database = $factory->createDatabase();
        // $ruleSet = RuleSet::fromArray(['rules' => [
        //     '.read' => true,
        //     '.write' => true,
        //     'events' => [
        //         ".indexOn" => ["id"]
        //     ]
        // ]]);
        // $this->database->updateRules($ruleSet);
        $this->eventsTable = $this->database->getReference('events');
    }
    public function store(Event $event)
    {


        $this->eventsTable
            ->push([
                'id' => $event->id,
                'main_title' => $event->main_title,
                'secondary_title' => $event->secondary_title,
                'content' => $event->content,
                'start_date' => $event->start_date,
                'end_date' => $event->end_date,
                'location' => $event->location,
                'location_lat' => $event->location_lat,
                'location_lang' => $event->location_lang,
                'is_published' => true,
                'cover_image' => $event->cover_image,
            ]);
    }



    public function destroy($id)
    {
        // return $this->eventsTable->getChildKeys();
        $eventsIds = [];
        $events = $this->eventsTable->getChildKeys();
        if ($events) {
            foreach ($events as $key => $value) {
                $eventsIds[$value] = $key;
            }
        }
        $key = array_search($id, $eventsIds);
        // $this->database->getReference('events/' . $key)->remove();
        if($key)
        {
            $this->database->getReference($key)->remove();
        }
        
    }
}
