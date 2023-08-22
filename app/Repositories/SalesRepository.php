<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Car;
use App\Models\MotorBike;
use App\Models\Transaction;

class SalesRepository implements SalesRepositoryInterface
{
    protected $car,$motorBike,$transaction;

    public function __construct(Car $car,MotorBike $motorBike, Transaction $transaction) {
        $this->car = $car;
        $this->motorBike = $motorBike;
        $this->transaction = $transaction;
    }

    public function createTransaction(array $data)
    {
        try {

            $transaction = new Transaction($data);

            $transaction->save();
            
            return [
                'status' => 201,
                'message' => 'Transaction successfully created!',
            ];
        } catch (\Exception $exception) {
            return [
                'status' => 500,
                'message' => $exception->getMessage(),
            ];
        }
    }

    public function getStocks()
    {
        $selected_field = ['kendaraan.warna','kendaraan.tahun','kendaraan.harga','mesin','stok'];

        $car = $this->car->get($selected_field)->toArray();
        $motorBike = $this->motorBike->get($selected_field)->toArray();
        
        return array_merge($car,$motorBike);
    }

    public function getSalesReport()
    {
        return $this->transaction->all();
    }

    public function getCarDetail($_id)
    {
        return $this->car->find($_id);
    }

    public function getBikeDetail($_id)
    {
        return $this->motorBike->find($_id);
    }

    function decreaseStock($_id,$tipe,$qty) {
        $instance = $tipe == 'mobil' ? $this->car : $this->motorBike;

        return $instance->where('_id',$_id)->decrement('stok',$qty); 
    }
}
