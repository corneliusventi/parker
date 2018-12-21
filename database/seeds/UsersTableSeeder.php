<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'fullname' => 'Cornelius Venti',
            'username' => 'corneliusventi',
            'email' => 'corneliusventi',
            'password' => bcrypt('cv234789'),
            'wallet' => 50000,
        ]);
    }
}
