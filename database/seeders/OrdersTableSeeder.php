<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\Product;
use App\Models\Size;
use Carbon\Carbon;

class OrdersTableSeeder extends Seeder
{
    public function run()
{
    // Initialize Faker for random data
    $faker = Faker::create();
    $products = Product::where('is_active', true)->get();  // Only active products
    $sizes = Size::all();  // Get all sizes from the sizes table

    // Check if there are active products
    if ($products->isEmpty()) {
        $this->command->info('No active products found. Skipping seeding orders.');
        return;
    }

    // Check if there are available sizes
    if ($sizes->isEmpty()) {
        $this->command->info('No available sizes found. Skipping seeding orders.');
        return;
    }

    // Seed orders
    foreach (range(1, 5) as $i) {
        // Generate random customer details
        $fullName = $faker->name;
        $phoneNumber = '06' . rand(10000000, 99999999);
        $deliveryAddress = $faker->address;

        // Create the order and insert into the database
        $orderId = DB::table('orders')->insertGetId([
            'user_id'         => null,  // No user associated
            'full_name'       => $fullName,
            'phone_number'    => $phoneNumber,
            'delivery_address'=> $deliveryAddress,
            'total_price'     => 0,  // Will update after items are added
            'status' => collect(['pending', 'processing', 'shipped', 'delivered'])->random(),
            'notes'           => 'Test note for order #' . $i,
            'created_at'      => Carbon::now(),
            'updated_at'      => Carbon::now(),
        ]);

        $totalPrice = 0;

        // Seed order items for each order
        foreach (range(1, rand(1, 3)) as $j) {
            $product = $products->random();
            $quantity = rand(1, 3);  // Random quantity
            $price = $product->price;  // Get product price from the database

            // Get a random size from the sizes table
            $size = $sizes->random();

            // Insert order item with a specific size_id
            DB::table('order_items')->insert([
                'order_id'  => $orderId,
                'product_id'=> $product->id,
                'quantity'  => $quantity,
                'price'     => $price,
                'size_id'   => $size->id,  // Link to the size_id
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ]);

            // Calculate the total price of the order
            $totalPrice += $quantity * $price;
        }

        // Update the total price for the order
        DB::table('orders')->where('id', $orderId)->update(['total_price' => $totalPrice]);
    }
}

}
