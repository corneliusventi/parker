<?php

namespace App\Jobs;

Use App\Booking;
Use App\Notifications\BookingExpired as BookingExpiredNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BookingExpired implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function handle()
    {
        if($this->booking->status) {
            $user = $this->booking->user;
            $user->notify(new BookingExpiredNotification($this->booking));

            $this->booking->delete();
        }
    }
}
