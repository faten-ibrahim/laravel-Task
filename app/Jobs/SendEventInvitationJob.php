<?php

namespace App\Jobs;

use App\Event;
use App\Notifications\SendEventInvitationNotification;
use App\Services\EventService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEventInvitationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $event;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $service = new EventService;
        $visitors = $service->getEventVisitors($this->event);
        foreach ($visitors as $visitor) {
            if (env('MAIL_HOST', false) == 'smtp.mailtrap.io') {
                sleep(5);
            }
            $visitor->notify(new SendEventInvitationNotification($this->event));
        }
    }
}
