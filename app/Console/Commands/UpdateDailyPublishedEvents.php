<?php

namespace App\Console\Commands;

use App\Event;
use App\Services\FirebaseService;
use Illuminate\Console\Command;

class UpdateDailyPublishedEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:publishedEvents';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command publish event if start date comes and unpublish when enddate comes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $service = new FirebaseService();
        $publishedEvents = Event::today();
        foreach ($publishedEvents->get() as $event) {
            $service->store($event);
        }
        $publishedEvents->update(['is_published' => true]);

        $unpublishedEvents = Event::notToday();
        foreach ($unpublishedEvents->get() as $event) {
            $service->destroy($event->id);
        }
        $unpublishedEvents->update(['is_published' => false]);
    }
}
