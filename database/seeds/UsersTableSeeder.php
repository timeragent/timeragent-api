<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->delete();
        factory(User::class)->create(
            [
                'first_name' => 'TimerAgent',
                'last_name'  => 'Admin',
                'email'      => 'serhii@digitalidea.studio',
                'password'   => Hash::make('TimerAgent1!'),
            ]
        );
        factory(User::class, 500)->create();
    }
}
