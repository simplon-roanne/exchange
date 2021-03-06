<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use Benwilkins\FCM\FcmMessage;

class WebPushNotifications extends Notification
{
    use Queueable;

    private $numberQuestions;

    /**
     * Create a new notification instance.
     *
     * @param $numberQuestions
     */
    public function __construct($numberQuestions)
    {
        $this->numberQuestions = $numberQuestions;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via()
    {
        return ['fcm'];
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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

    public function toFcm() 
    {
        $message = new FcmMessage();
        $message->content([
            'title'        => "Nouveau message de Simplon-Exchange.help",
            'body'         => $this->numberQuestions . ' nouvelles questions ont été posés.',
            'sound'        => '', // Optional 
            'icon'         => '', // Optional
            'click_action' => '' // Optional
        ])->data([
            'param1' => 'baz' // Optional
        ])->priority(FcmMessage::PRIORITY_HIGH); // Optional - Default is 'normal'.

        return $message;
    }
}
