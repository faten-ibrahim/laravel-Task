<?php

namespace App\Notifications;

use App\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendEventInvitationNotification extends Notification
{
    use Queueable;

    private $event;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Event Invitation')
            ->greeting('Hi '.$notifiable->first_name.',')
            ->line('You are invited to attend '.$this->event->main_title.' event')
            ->line(',that will start on '.$this->event->start_date.' ,and will be ended at '.$this->event->end_date)
            ->line('It will be at '.$this->event->location)
            ->line('Thank you for using our application!')
            ->salutation('Ibtikar Team');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
