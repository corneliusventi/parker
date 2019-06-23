<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\TopUp;

class TopUpApproval extends Notification
{
    use Queueable;

    protected $topUp;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(TopUp $topUp)
    {
        $this->topUp = $topUp;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $approved = $this->topUp->approved;
        $status = $approved ? 'approved' : 'disapproved';
        return (new MailMessage)
                    ->greeting('Status of Top Up')
                    ->line('One of your top ups has been '.$status.'!')
                    ->action('Login', route('login'))
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
            'top_up_id' => $this->topUp->id,
            'amount' => $this->topUp->amount,
            'status' => $this->topUp->approved ? 'approved' : 'disapproved',
        ];
    }
}
