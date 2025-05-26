<?php

namespace App\Services\Discounts\Contracts;

use App\Models\Order;

interface DiscountRuleInterface
{
    public function apply(Order $order): ?array;
}