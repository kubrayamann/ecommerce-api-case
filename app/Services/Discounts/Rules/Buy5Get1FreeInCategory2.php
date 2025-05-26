<?php
namespace App\Services\Discounts\Rules;

use App\Services\Discounts\Contracts\DiscountRuleInterface;
use App\Constants\DiscountReasons;
use App\Models\Order;

class Buy5Get1FreeInCategory2 implements DiscountRuleInterface
{
    public function apply(Order $order): ?array
    {
        $discount = 0;

        foreach ($order->items as $item) {
            if ($item->product->category == 2 && $item->quantity >= 6) {
                $freeQty = intdiv($item->quantity, 6);
                $discount += $item->unit_price * $freeQty;
            }
        }

        $subtotal = $order->total - $discount;
        if ($subtotal < 0) {
            $subtotal = 0;
        }

        if ($discount > 0) {
            return [
                'discountReason' => DiscountReasons::BUY_5_GET_1,
                'discountAmount' => round($discount, 2),
                'subtotal' => round($subtotal, 2)
            ];
        }

        return null;
    }
}
