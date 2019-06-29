<?php

namespace App\Notifications;

use App\Parking;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ParkingExpired extends Notification
{
    use Queueable;

    protected $parking;

    public function __construct(Parking $parking)
    {
        $this->parking = $parking;
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
        $time_end = Carbon::parse($this->parking->time_end);
        return (new MailMessage)
                    ->greeting('Status of Parking')
                    ->line('Your parking at ' . $this->parking->parkingLot->name . ' expired in ' . $time_end->diffForHumans())
                    ->line('Please leave the parking lot.')
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
        $time_end = Carbon::parse($this->parking->time_end);
        return [
            'parking_id' => $this->parking->id,
            'parking_lot' => $this->parking->parkingLot->name,
            'diff' => $time_end->diffForHumans(),
        ];
    }
}
