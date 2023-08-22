<?php

declare(strict_types=1);

namespace App\Repositories;

interface SalesRepositoryInterface
{
    public function createTransaction(array $data);
    public function getStocks();
    public function getSalesReport();
    public function getCarDetail($_id);
    public function getBikeDetail($_id);
    


}