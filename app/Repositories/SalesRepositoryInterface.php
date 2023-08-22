<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Requests\VehicleRequest;

interface SalesRepositoryInterface
{
    public function sell(VehicleRequest $request);
    public function getStocks();
    public function getSalesReport();


}