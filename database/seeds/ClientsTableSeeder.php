<?php

use App\Client;
use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = ['Ahmed','Yasser','momo'];

        foreach($clients as $client) {

            Client::create([
                'name' => $client,
                'phone' => 12222222220,
                'address' =>"Egypt",
                ]);
        }
    }
}
