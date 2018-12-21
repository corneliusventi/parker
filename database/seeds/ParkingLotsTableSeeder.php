<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParkingLotsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('parking_lots')->insert([
            [
                'name' => 'Tengku Umar Parkiran 1',
                'address' => 'Jalan Teuku Umar Pontianak',
                'latitude' => '-0.033631',
                'longitude' => '109.332691',
            ],
            [
                'name' => 'Tengku Umar Parkiran 2',
                'address' => 'Jalan Teuku Umar Pontianak',
                'latitude' => '-0.033491',
                'longitude' => '109.332830',
            ],
            [
                'name' => 'Tengku Umar Parkiran 3',
                'address' => 'Jalan Teuku Umar Pontianak',
                'latitude' => '-0.033373',
                'longitude' => '109.332895',
            ],
            [
                'name' => 'Tengku Umar Parkiran 4',
                'address' => 'Jalan Teuku Umar Pontianak',
                'latitude' => '-0.033191',
                'longitude' => '109.333045',
            ],
            [
                'name' => 'Tengku Umar Parkiran 5',
                'address' => 'Jalan Teuku Umar Pontianak',
                'latitude' => '-0.033094',
                'longitude' => '109.333227',
            ],
            [
                'name' => 'Tengku Umar Parkiran 6',
                'address' => 'Jalan Teuku Umar Pontianak',
                'latitude' => '-0.032965',
                'longitude' => '109.333388',
            ],
            [
                'name' => 'Tengku Umar Parkiran 7',
                'address' => 'Jalan Teuku Umar Pontianak',
                'latitude' => '-0.032601',
                'longitude' => '109.333753',
            ],
            [
                'name' => 'Tengku Umar Parkiran 8',
                'address' => 'Jalan Teuku Umar Pontianak',
                'latitude' => '-0.032365',
                'longitude' => '109.334053',
            ],
            [
                'name' => 'Tengku Umar Parkiran 9',
                'address' => 'Jalan Teuku Umar Pontianak',
                'latitude' => '-0.031946',
                'longitude' => '109.334364',
            ],
            [
                'name' => 'Tengku Umar Parkiran 10',
                'address' => 'Jalan Teuku Umar Pontianak',
                'latitude' => '-0.031796',
                'longitude' => '109.334621',
            ],
        ]);
    }
}
