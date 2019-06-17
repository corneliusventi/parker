<?php

use Illuminate\Database\Seeder;
use Silber\Bouncer\BouncerFacade as Bouncer;
use App\ParkingLot;
use App\User;
use App\Booking;
use App\Parking;
use App\Slot;
use App\Car;
use App\TopUp;

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
        Bouncer::allow('administrator')->toManage(User::class);
        Bouncer::allow('administrator')->toManage(ParkingLot::class);
        Bouncer::allow('administrator')->toManage(Booking::class);
        Bouncer::allow('administrator')->toManage(Parking::class);
        Bouncer::allow('administrator')->toManage(TopUp::class);
        Bouncer::allow('administrator')->to('change-profile');
        Bouncer::allow('admin_operator')->toManage(Slot::class);
        Bouncer::allow('admin_operator')->toManage(Parking::class);
        Bouncer::allow('admin_operator')->toManage(Booking::class);
        Bouncer::allow('admin_operator')->to('change-profile');
        Bouncer::allow('operator')->toManage(Parking::class);
        Bouncer::allow('operator')->toManage(Booking::class);
        Bouncer::allow('operator')->to('change-profile');
        Bouncer::allow('user')->toManage(Car::class);
        Bouncer::allow('user')->to('booking');
        Bouncer::allow('user')->to('parking');
        Bouncer::allow('user')->to('topup');
        Bouncer::allow('user')->to('change-profile');
    }
}
