<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use DB;
use Carbon\Carbon;

class UserAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $users = DB::table('users')->get();
        foreach ($users as $user)  {
            DB::table('user_addresses')->insert([
                'user_id' => $user->id,
                'city' => $faker->city,
                'country' => $faker->country,
                'state' => $faker->state,
                'street_name'=> $faker->streetAddress,
                'street_number' => $faker->randomNumber(2),
                'cep' => $faker->randomNumber(2),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}
