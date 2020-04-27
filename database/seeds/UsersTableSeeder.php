<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([

            'first_name' => 'yasser',
            'last_name' => 'AbdElghany',
            'email' => 'yasser22269@yahoo.com',
            'password' => bcrypt('123456'),
            ]);


            $user->attachRole('super_admin');
    }
}
