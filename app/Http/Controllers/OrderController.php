<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Responses\SystemResponse;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Exception;

/**
 ** OrderController
 ** Sipariş işlemlerini yöneten controller
 */
class OrderController extends Controller
{
    protected $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    
    public function list(Request $request)
    {
        try 
        {
            $orders = $this->orderService->listOrders();
            return SystemResponse::success( OrderResource::collection($orders) );
        } catch (Exception $e) {
            return SystemResponse::error($e->getMessage(), 500);
        } 
    }

    public function create(CreateOrderRequest $request)
    {
        try 
        {
            $validatedData = $request->validated();
            $order = $this->orderService->createOrder($validatedData);
            return SystemResponse::success();
        } catch (Exception $e) {
            return SystemResponse::error($e->getMessage(), 500);
        }
    }

    public function delete($id)
    {
        try 
        {
            $this->orderService->deleteOrder($id);
            return SystemResponse::success();
        } catch (Exception $e) {
            return SystemResponse::error($e->getMessage(), 500);
        }
    }
}
