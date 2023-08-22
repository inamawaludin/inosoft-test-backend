<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarFactory extends Factory
{

    protected $model = Car::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
                'stok' => $this->faker->randomDigit(),
                'mesin' => $this->faker->randomElement(['1000cc', '1500cc', '2000cc','2500cc']),
                'kapasitas_penumpang' => $this->faker->numberBetween($min = 2, $max = 8),
                'tipe' => $this->faker->randomElement(['Matic', 'Manual', 'Kopling']),
                'kendaraan' => [
                    'tahun' => $this->faker->year($max = now()),
                    'warna' => $this->faker->colorName(),
                    'harga' => $this->faker->numberBetween($min = 150000000, $max = 600000000)
                ]
            ];
    }
}
