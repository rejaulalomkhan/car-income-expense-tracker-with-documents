<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarDocument;
use Illuminate\Database\Seeder;

class CarDocumentSeeder extends Seeder
{
    public function run(): void
    {
        $cars = Car::all();
        $documentTypes = [
            'Certificate of Registration',
            'Fitness',
            'Tax Token',
            'Insurance',
            'Route Permit',
            'Branding'
        ];

        foreach ($cars as $car) {
            foreach ($documentTypes as $type) {
                CarDocument::create([
                    'car_id' => $car->id,
                    'document_type' => $type,
                    'document_expiry_date' => now()->addMonths(rand(1, 12)),
                    'document_image' => null,
                    'document_comment' => "{$type} for {$car->name}"
                ]);
            }
        }
    }
} 