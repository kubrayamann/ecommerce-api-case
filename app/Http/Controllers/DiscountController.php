<?php

namespace App\Http\Controllers;

use App\Services\Discounts\DiscountCalculator;
use App\Http\Responses\SystemResponse;
use App\Models\Order;
use App\Services\DiscountService;
use Exception;

/**
 * DiscountController
 * İndirim hesaplama işlemlerini yöneten controller
 */

class DiscountController extends Controller
{
    protected $discountService;
    
    public function __construct(DiscountService $discountService)
    {
        $this->discountService = $discountService;
    }

    public function calculateDiscounts($id)
    {
        try {
            $result = $this->discountService->calculateDiscounts($id);
            return SystemResponse::success($result);
        } catch (Exception $e) {
            return SystemResponse::error( $e->getMessage(), 500);
        }        
    }
}
