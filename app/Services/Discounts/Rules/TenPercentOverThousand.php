<?php
namespace App\Services\Discounts\Rules;

use App\Services\Discounts\Contracts\DiscountRuleInterface;
use App\Constants\DiscountReasons;
use App\Models\Order;

class TenPercentOverThousand implements DiscountRuleInterface
{
    public function apply(Order $order): ?array
    {
        if ($order->total >= 1000) {
            $discountAmount = round($order->total * 0.10, 2);
            $newSubtotal = $order->total - $discountAmount;
            
            if ($newSubtotal < 0) {
                $newSubtotal = 0;
            }

            return [
                'discountReason' => DiscountReasons::TEN_PERCENT_OVER_1000,
                'discountAmount' => round($discountAmount, 2),
                'subtotal' => round($newSubtotal, 2)
            ];
        }

        return null;
    }
}
