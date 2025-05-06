<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Income;
use App\Models\Car;

class IncomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cars = Car::all();

        foreach ($cars as $car) {
            Income::create([
                'car_id' => $car->id,
                'amount' => 1500.00,
                'source' => 'Rental',
                'date' => '2024-01-15',
                'description' => 'Weekend rental income',
            ]);

            Income::create([
                'car_id' => $car->id,
                'amount' => 2000.00,
                'source' => 'Tour',
                'date' => '2024-01-20',
                'description' => 'Tour package income',
            ]);
        }
    }
}
