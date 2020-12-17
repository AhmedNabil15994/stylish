<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use DouglasResende\FCM\Messages\FirebaseMessage;

class StatusNotification extends Notification
{
    use Queueable;

    public $data;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast','fcm'];
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
            'notify'=>$this->data
        ];
    }

    public function toFcm($notifiable)
    {

        return (new FirebaseMessage())->setMeta([
            'notify'=>$this->data
        ])->setContent('Status Notification', $this->data['ar']['title']);

    }

    public function broadcastOn()
    {
        return ["statusChannel,{$this->data['user_id']}"];
    }
}
