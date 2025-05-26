<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Product;

class OrderService
{
    public function listOrders(): Collection
    {
        return Order::with('items')->get();
    }

    public function createOrder(array $validatedData): Order
    {
        return DB::transaction(function () use ($validatedData) {
            $total = 0;

            $order = Order::create([
                'customer_id' => $validatedData['customerId'],
                'total' => 0,
            ]);

            foreach ($validatedData['items'] as $item) {
                $product = Product::find($item['productId']);

                if ($product->stock < $item['quantity']) {
                    throw new Exception( "Stok yetersiz: Ürün #{$product->id}");
                }

                $lineTotal = $item['quantity'] * $product->price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['productId'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'total' => $lineTotal
                ]);

                $product->decrement('stock', $item['quantity']);
                $total += $lineTotal;
            }

            $discountService = new DiscountService();
            $discountResult = $discountService->calculateDiscounts($order->id);

            if ($discountResult['totalDiscount'] > 0) {
                $total -= $discountResult['totalDiscount'];
            }

            $order->update(['total' => $total]);

            $discountService = new DiscountService();
            $discountResult = $discountService->calculateDiscounts($order->id);

            if ($discountResult['totalDiscount'] > 0) {
                $total -= $discountResult['totalDiscount'];
                $order->update(['total' => $total]);
            }

            return $order;
        });
    }

    public function deleteOrder(int $id): bool
    {
        $order = Order::find($id);
        if (!$order) {
            throw new Exception("Sipariş bulunamadı: #{$id}");
        }
        return DB::transaction(function () use ($order) {
            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                if (!$product) {
                    throw new Exception("Ürün bulunamadı: #{$item->product_id}");
                }
                $product->increment('stock', $item->quantity);
            }
            return $order->delete();
        });
    }
}
