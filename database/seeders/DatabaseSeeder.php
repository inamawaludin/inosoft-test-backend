<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\MotorBike;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Car::factory()
        ->count(5)
        ->create();
        MotorBike::factory()
        ->count(5)
        ->create();
    }
}
