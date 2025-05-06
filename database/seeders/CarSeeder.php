<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cars = [
            [
                'name' => 'Toyota Corolla',
                'plate_number' => 'ABC-123',
                'model' => 'Corolla',
                'year' => 2020,
                'color' => 'White',
                'status' => 'active'
            ],
            [
                'name' => 'Honda Civic',
                'plate_number' => 'XYZ-789',
                'model' => 'Civic',
                'year' => 2021,
                'color' => 'Black',
                'status' => 'active'
            ],
            [
                'name' => 'Suzuki Swift',
                'plate_number' => 'DEF-456',
                'model' => 'Swift',
                'year' => 2019,
                'color' => 'Red',
                'status' => 'active'
            ],
            [
                'name' => 'Mitsubishi Lancer',
                'plate_number' => 'GHI-789',
                'model' => 'Lancer',
                'year' => 2018,
                'color' => 'Blue',
                'status' => 'inactive'
            ]
        ];

        foreach ($cars as $car) {
            Car::create($car);
        }
    }
}
