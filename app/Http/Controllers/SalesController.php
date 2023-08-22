<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalesRequest;
use App\Services\SalesService;

class SalesController extends Controller
{
    protected $salesService;

    public function __construct(SalesService $salesService) {
        $this->salesService = $salesService;
    }

    public function recordSale(SalesRequest $request) {
        $result = $this->salesService->addTransaction($request);

        return response()->json($result,$result['status']);
    }

    public function generateSalesReport() {
        return $this->salesService->getReportTransaction();
    }

    public function viewStocks(){
        return $this->salesService->getAllStocks();
    }
}
