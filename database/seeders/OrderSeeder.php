<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for ($i = 1; $i <= 20; $i++) {
            DB::table('orders')->insert([
                'order_increment_id' => 'ORD-' . Str::random(8),
                'user_id' => $faker->numberBetween(1, 50), 
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
                'address_2' => $faker->secondaryAddress,
                'city' => $faker->city,
                'state' => $faker->state,
                'country' => $faker->country,
                'pincode' => $faker->postcode,
                'coupon' => $faker->randomElement(['DISCOUNT10', 'SALE20', 'WELCOME', null]),
                'coupon_discount' => $faker->randomFloat(2, 0, 50),
                'total' => $faker->randomFloat(2, 100, 1000),
                'payment_method' => $faker->randomElement(['Credit Card', 'PayPal', 'Cash on Delivery']),
                'shipping_method' => $faker->randomElement(['Standard', 'Express', 'Overnight']),
                'shipping_cost' => $faker->randomFloat(2, 5, 50), 
                'sub_total' => $faker->randomFloat(2, 50, 950),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
