<?php
namespace App\Services\Discounts;

use App\Models\Order;
use App\Services\Discounts\Rules\Buy5Get1FreeInCategory2;
use App\Services\Discounts\Rules\TenPercentOverThousand;
use App\Services\Discounts\Rules\TwentyPercentCheapestInCategory1;

class DiscountCalculator
{
    protected array $rules;

    public function __construct()
    {
        $this->rules = [
            new Buy5Get1FreeInCategory2(),
            new TenPercentOverThousand(),
            new TwentyPercentCheapestInCategory1(),
        ];
    }

    public function calculate(Order $order): array
    {
        $discounts = [];
        $totalDiscount = 0;
        $subtotal = $order->total;

        foreach ($this->rules as $rule) {
            $result = $rule->apply($order);
            if ($result) {
                $discounts[] = $result;
                $totalDiscount += $result['discountAmount'];
            }
        }

        return [
            'orderId' => $order->id,
            'discounts' => $discounts,
            'totalDiscount' => round($totalDiscount, 2),
            'discountedTotal' => round( $subtotal - $totalDiscount, 2),
        ];
    }
}
