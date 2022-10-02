<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use DB;
use Carbon\Carbon;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index)  {
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->email,
                'cpf' => $faker->numberBetween($min = 10, $max = 10),
                'born_date' => Carbon::now()->format('Y-m-d'),
                'password'=> bcrypt('secret'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}
