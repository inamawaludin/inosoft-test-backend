<?php

namespace Tests\Unit;

use App\Models\Car;
use App\Models\MotorBike;
use Database\Seeders\DatabaseSeeder;
use Tests\TestCase;

class SalesTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    protected function getRandomItems() {
        $car = Car::where('stok','>',0)->get(['_id'])->toArray();
        $motorBike = MotorBike::where('stok','>',0)->get(['_id'])->toArray();
        
        $randCar = array_rand($car,2);
        $randMotor = array_rand($motorBike,2);

        return [
            "car" => [
                $car[$randCar[0]],
                $car[$randCar[1]]
            ],
            "motorBike" =>[
                $motorBike[$randMotor[0]],
                $motorBike[$randMotor[1]]
            ]
        ];
    }

    protected function getAuthToken() {
        $response = $this->postJson('/api/v1/login',[
            "email" => "awaludin@gmail.com",
            "password" => "adminadmin"
        ]);

        $token = $response->decodeResponseJson();

        return $token['access_token'];
    }


    public function test_transaction_with_valid_data()
    {
        $this->seed(DatabaseSeeder::class);

        $token = $this->getAuthToken();
        $randomVehicle = $this->getRandomItems();

        $response = $this->withHeaders([
            "Authorization"  => "Bearer ". $token
        ])->postJson('/api/v1/sales/record-sale',[
            "items" => [
                [
                    "id" => $randomVehicle['car'][0]['_id'],
                    "tipe" => "mobil",
                    "qty"  => 2
                ],
                [
                    "id" => $randomVehicle['motorBike'][0]['_id'],
                    "tipe" => "motor",
                    "qty"  => 1
                ],
                [
                    "id" => $randomVehicle['motorBike'][1]['_id'],
                    "tipe" => "motor",
                    "qty"  => 1
                ],
                [
                    "id" => $randomVehicle['car'][1]['_id'],
                    "tipe" => "mobil",
                    "qty"  => 1
                ]
            ]
        ]);


        $response->assertStatus(201)->assertJson([
            "status" => 201,
            "message" => "Transaction successfully created!"
        ]);
    }
    
    
    public function test_transaction_with_valid_data_and_without_token()
    {
        $randomVehicle = $this->getRandomItems();

        $response = $this->withHeaders([
            "Authorization"  => "Bearer "
        ])->postJson('/api/v1/sales/record-sale',[
            "items" => [
                [
                    "id" => $randomVehicle['car'][0]['_id'],
                    "tipe" => "mobil",
                    "qty"  => 2
                ],
                [
                    "id" => $randomVehicle['motorBike'][0]['_id'],
                    "tipe" => "motor",
                    "qty"  => 1
                ],
                [
                    "id" => $randomVehicle['motorBike'][1]['_id'],
                    "tipe" => "motor",
                    "qty"  => 1
                ],
                [
                    "id" => $randomVehicle['car'][1]['_id'],
                    "tipe" => "mobil",
                    "qty"  => 1
                ]
            ]
        ]);


        $response->assertStatus(401)->assertJson([
            "status" => "Authorization Token not found"
        ]);
    }

    public function test_transaction_with_valid_data_and_with_expired_token()
    {
        $token = $this->getAuthToken();
        $randomVehicle = $this->getRandomItems();

        $this->travel(1)->years();

        $response = $this->withHeaders([
            "Authorization"  => "Bearer ". $token
        ])->postJson('/api/v1/sales/record-sale',[
            "items" => [
                [
                    "id" => $randomVehicle['car'][0]['_id'],
                    "tipe" => "mobil",
                    "qty"  => 2
                ],
                [
                    "id" => $randomVehicle['motorBike'][0]['_id'],
                    "tipe" => "motor",
                    "qty"  => 1
                ],
                [
                    "id" => $randomVehicle['motorBike'][1]['_id'],
                    "tipe" => "motor",
                    "qty"  => 1
                ],
                [
                    "id" => $randomVehicle['car'][1]['_id'],
                    "tipe" => "mobil",
                    "qty"  => 1
                ]
            ]
        ]);


        $response->assertStatus(401)->assertJson([
            "status" => "Token is Expired"
        ]);
    }

    public function test_transaction_with_empty_items()
    {
        $token = $this->getAuthToken();

        $response = $this->withHeaders([
            "Authorization"  => "Bearer ". $token
        ])->postJson('/api/v1/sales/record-sale',[
            "items" => []
        ]);


        $response->assertStatus(422)->assertJson([
            "errors" => [
                "items" => [
                    "The items field is required."
                ]
            ]
        ]);
    }


    public function test_view_stocks_with_valid_token() {
        $token = $this->getAuthToken();

        $response = $this->withHeaders([
            "Authorization"  => "Bearer ". $token
        ])->getJson('/api/v1/sales/view-stocks');

        $response->assertStatus(200)->assertJsonStructure([
            "status",
            "data" => [
                "*" =>  [
                    "_id",
                    "stok",
                    "mesin",
                    "kendaraan" => [
                        "tahun",
                        "warna",
                        "harga"
                    ]
                ]
            ]
        ]);
    }
    
    
    public function test_generate_report_with_valid_token() {
        $token = $this->getAuthToken();

        $response = $this->withHeaders([
            "Authorization"  => "Bearer ". $token
        ])->getJson('/api/v1/sales/generate-sales-report');

        $response->assertStatus(200)->assertJsonStructure([
            "status",
            "data" => [
                "*" =>  [
                    "total_qty",
                    "total_price",
                    "mesin",
                    "tipe",
                    "tahun"
                ]
            ]
        ]);
    }
    

    
}
