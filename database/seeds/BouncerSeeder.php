<?php

use Illuminate\Database\Seeder;
use Silber\Bouncer\BouncerFacade as Bouncer;
use App\ParkingLot;
use App\User;
use App\Booking;
use App\Parking;
use App\Slot;

class BouncerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bouncer::allow('superadministrator')->toManage(User::class);
        Bouncer::allow('superadministrator')->toManage(ParkingLot::class);
        Bouncer::allow('superadministrator')->toManage(Slot::class);
        Bouncer::allow('superadministrator')->to('change-profile');
        Bouncer::allow('administrator')->toManage(User::class);
        Bouncer::allow('administrator')->toManage(ParkingLot::class);
        Bouncer::allow('administrator')->toManage(Slot::class);
        Bouncer::allow('administrator')->to('change-profile');
        Bouncer::allow('user')->to('booking');
        Bouncer::allow('user')->to('parking');
        Bouncer::allow('user')->to('topup');
        Bouncer::allow('user')->to('change-profile');
    }
}
