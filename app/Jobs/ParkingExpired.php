<?php

namespace App\Jobs;

use App\Parking;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Notifications\ParkingExpired as ParkingExpiredNotification;

class ParkingExpired implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $parking;

    public function __construct(Parking $parking)
    {
        $this->parking = $parking;
    }

    public function handle()
    {
        $parking = $this->parking;

        if($parking->status) {
            $time_end = Carbon::parse($parking->time_end);
            $user = $parking->user;

            if(now()->greaterThanOrEqualTo($time_end->addMinutes(5))) {
                $user->update([
                    'wallet' => $user->wallet - 5000,
                ]);
            }

            $user->notify(new ParkingExpiredNotification($parking));
        }
    }
}
