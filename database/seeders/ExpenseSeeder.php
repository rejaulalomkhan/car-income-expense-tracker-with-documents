<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Expense;
use App\Models\Car;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cars = Car::all();

        foreach ($cars as $car) {
            Expense::create([
                'car_id' => $car->id,
                'amount' => 500.00,
                'category' => 'Maintenance',
                'date' => '2024-01-10',
                'description' => 'Regular maintenance service',
            ]);

            Expense::create([
                'car_id' => $car->id,
                'amount' => 200.00,
                'category' => 'Fuel',
                'date' => '2024-01-12',
                'description' => 'Fuel refill',
            ]);
        }
    }
}
