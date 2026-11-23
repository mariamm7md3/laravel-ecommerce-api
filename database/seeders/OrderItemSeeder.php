<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = Order::all();

        foreach ($orders as $order) {
            OrderItem::factory(rand(1, 4))->create([
                'order_id'           => $order->id,
                'product_variant_id' => ProductVariant::query()->inRandomOrder()->first()->id,
                'price'              => ProductVariant::query()->inRandomOrder()->first()->price,
            ]);
        }
    }
}
