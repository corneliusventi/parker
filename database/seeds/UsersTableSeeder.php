<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Silber\Bouncer\BouncerFacade as Bouncer;

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
            [
                'fullname' => 'Superadministrator',
                'username' => 'superadministrator',
                'email' => 'superadministrator@gmail.com',
                'password' => bcrypt('cv234789'),
                'wallet' => 0,
            ],
            [
                'fullname' => 'Administrator',
                'username' => 'administrator',
                'email' => 'administrator@gmail.com',
                'password' => bcrypt('cv234789'),
                'wallet' => 0,
            ],
            [
                'fullname' => 'Operator',
                'username' => 'operator',
                'email' => 'operator@gmail.com',
                'password' => bcrypt('cv234789'),
                'wallet' => 0,
            ],
            [
                'fullname' => 'Cornelius Venti',
                'username' => 'corneliusventi',
                'email' => 'corneliusventi@gmail.com',
                'password' => bcrypt('cv234789'),
                'wallet' => 50000,
            ],
        ]);

        $superadministrator = User::where('username', 'superadministrator')->first();
        $superadministrator->assign('superadministrator');
        $administrator = User::where('username', 'administrator')->first();
        $administrator->assign('administrator');
        $operator = User::where('username', 'operator')->first();
        $operator->assign('operator');
        $corneliusventi = User::where('username', 'corneliusventi')->first();
        $corneliusventi->assign('user');

    }
}
