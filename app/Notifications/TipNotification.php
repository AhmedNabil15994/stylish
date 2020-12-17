<?php

namespace App\Notifications;

use DouglasResende\FCM\Messages\FirebaseMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class TipNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $tip;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($tip)
    {
        $this->tip = $tip;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast','fcm'];
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
            'notify'=>$this->tip
        ];
    }

    public function toFcm($notifiable)
    {

        return (new FirebaseMessage())->setMeta([
            'notify'=>$this->tip
        ])->setContent($this->tip['ar']['title'], $this->tip['ar']['desc']);

    }

    public function broadcastOn()
    {
        return ['notifyChannel'];
    }
}
