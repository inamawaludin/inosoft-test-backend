<?php

namespace Database\Factories;

use App\Models\MotorBike;
use Illuminate\Database\Eloquent\Factories\Factory;

class MotorBikeFactory extends Factory
{


    protected $model = MotorBike::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'stok' => $this->faker->numberBetween($min = 10, $max = 100),
            'mesin' => $this->faker->randomElement(['100cc', '125cc', '350cc']),
            'tipe_suspensi' => $this->faker->randomElement(['Mono Shock','Dual Shock']),
            'tipe_transmisi' => $this->faker->randomElement(['Matic', 'Manual', 'Kopling']),
            'kendaraan' => [
                'tahun' => $this->faker->year($max = now()),
                'warna' => $this->faker->colorName(),
                'harga' => $this->faker->numberBetween($min = 150000000, $max = 600000000)
            ]
        ];
    }
}
