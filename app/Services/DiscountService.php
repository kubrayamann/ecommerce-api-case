<?php

namespace App\Services;

use App\Models\Order;
use Exception;
use App\Services\Discounts\DiscountCalculator;

class DiscountService
{
    public function calculateDiscounts(int $id): array
    {
        $order = Order::with('items')->find($id);
        if (!$order) {
            throw new Exception('Sipariş bulunamadı', 404);
        }
        $calculator = new DiscountCalculator();
        $result = $calculator->calculate($order);
        return $result;
    }
}
