<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'full_name' => $this->faker->name,
            'phone_number' => $this->faker->phoneNumber,
            'delivery_address' => $this->faker->address,
            'total_price' => 0,
            'status' => 'pending',
        ];
    }
}

