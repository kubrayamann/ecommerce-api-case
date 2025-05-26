<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = json_decode(file_get_contents(database_path('data/orders.json')), true);
        foreach ($orders as $orderData) {
            $order = \App\Models\Order::create([
                'id' => $orderData['id'],
                'customer_id' => $orderData['customerId'],
                'total' => $orderData['total'],
            ]);

            foreach ($orderData['items'] as $item) {
                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['productId'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unitPrice'],
                    'total' => $item['total'],
                ]);
            }
        }
    }
}
