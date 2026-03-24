<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderType;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'total_price' => $this->faker->randomFloat(2, 10, 500),
            'total_items' => $this->faker->numberBetween(1, 10),
            'order_type_id' => OrderType::firstOrCreate(['name' => 'Test'], ['name' => 'Test'])->id,
            'payment_id' => Payment::firstOrCreate(['method' => 'Cash'], ['method' => 'Cash'])->id,
            'returned' => 0,
            'status' => 0,
        ];
    }

    public function returned(): static
    {
        return $this->state(fn (array $attributes) => ['returned' => 1]);
    }
}
