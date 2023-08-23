<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\SalesRequest;
use App\Repositories\SalesRepository;
use Carbon\Carbon;

class SalesService
{
    protected $salesRepository;

    public function __construct(SalesRepository $salesRepository)
    {
        $this->salesRepository = $salesRepository;
    }

    public function addTransaction(SalesRequest $request)
    {
        $itemResults = $this->getDetailItems($request->items);

        if (isset($itemResults['status']) && $itemResults['status'] == 404) {
            return $itemResults;
        }

        $transaction = [
            'name' => auth()->user()->name,
            'tanggal' => Carbon::now()->format('Y-m-d'),
            'total_item' => $itemResults['total_item'],
            'total_price' => $itemResults['total_price'],
            'items' => $itemResults['items']
        ];

        return $this->salesRepository->createTransaction($transaction);
    }

    protected function getDetailItems(array $items)
    {
        $result = [];
        $totalItem = 0;
        $totalPrice = 0;

        foreach ($items as $item) {
            $detail = $item['tipe'] === 'mobil'
                ? $this->salesRepository->getCarDetail($item['id'])
                : $this->salesRepository->getBikeDetail($item['id']);

            if (empty($detail) || ($detail['stok'] < $item['qty'])) {
                return [
                    'status' => 404,
                    'message' => 'Stock for this product is not available at this time.',
                    'product' => $detail['mesin'],
                ];
            }

            $this->salesRepository->decreaseStock($item['id'], $item['tipe'], $item['qty']);

            unset($detail['stok']);
            $detail['qty'] = $item['qty'];
            $detail['tipe'] = $item['tipe'];
            $totalItem += $item['qty'];
            $totalPrice += ($detail['kendaraan']['harga'] * $item['qty']);
            $result[] = $detail->toArray();
        }

        return [
            'status' => 200,
            'items' => $result,
            'total_item' => $totalItem,
            'total_price' => $totalPrice,
        ];
    }

    public function getReportTransaction()
    {
        // Implementation for reporting

        $allTransaction = $this->salesRepository->getSalesReport();

        $result = [];

        foreach ($allTransaction as $key => $value) {
            foreach ($value['items'] as $kVehicle => $vVehicle) {

                if (array_key_exists($vVehicle['_id'], $result)) {

                    $result[$vVehicle['_id']]['total_qty'] += $vVehicle['qty'];
                    $result[$vVehicle['_id']]['total_price'] += ($vVehicle['kendaraan']['harga'] * $vVehicle['qty']);
                } else {
                    $result[$vVehicle['_id']] = [
                        'total_qty' => $vVehicle['qty'],
                        'total_price' => ($vVehicle['kendaraan']['harga'] * $vVehicle['qty']),
                        'mesin' => $vVehicle['mesin'],
                        'tipe' => $vVehicle['tipe'],
                        'tahun' => $vVehicle['kendaraan']['tahun'],
                    ];
                }
            }
        }

        return count($result) > 0
            ? ['status' => 200, 'data' => array_values($result)]
            : ['status' => 404, 'message' => 'Data not found!'];
    }

    public function getAllStocks()
    {
        $stocks = $this->salesRepository->getStocks();

        return count($stocks) > 0
            ? ['status' => 200, 'data' => $stocks]
            : ['status' => 404, 'message' => 'Data not found!'];
    }
}
