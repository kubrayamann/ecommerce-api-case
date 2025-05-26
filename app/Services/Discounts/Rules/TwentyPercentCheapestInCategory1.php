<?php

namespace App\Services\Discounts\Rules;

use App\Services\Discounts\Contracts\DiscountRuleInterface;
use App\Constants\DiscountReasons;
use App\Models\Order;

class TwentyPercentCheapestInCategory1 implements DiscountRuleInterface
{
    public function apply(Order $order): ?array
    {
        $products = [];

        foreach ($order->items as $item) {
            if ($item->product->category == 1) {
                for ($i = 0; $i < $item->quantity; $i++) {
                    $products[] = $item->unit_price;
                }
            }
        }

        if (count($products) >= 2) {
            sort($products);
            $discount = $products[0] * 0.20;
            
            return [
                'discountReason' => DiscountReasons::TWENTY_PERCENT_CHEAPEST_IN_CATEGORY_1,
                'discountAmount' => round($discount, 2),
                'subtotal' => round($order->total - $discount, 2)
            ];
        }

        return null;
    }
}
