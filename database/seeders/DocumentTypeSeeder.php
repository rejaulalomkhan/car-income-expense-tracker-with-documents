<?php

namespace Database\Seeders;

use App\Models\DocumentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'name' => 'Insurance',
                'description' => 'Vehicle insurance documents',
                'is_active' => true
            ],
            [
                'name' => 'Registration',
                'description' => 'Vehicle registration documents',
                'is_active' => true
            ],
            [
                'name' => 'Maintenance',
                'description' => 'Vehicle maintenance records',
                'is_active' => true
            ],
            [
                'name' => 'Purchase',
                'description' => 'Vehicle purchase documents',
                'is_active' => true
            ]
        ];

        foreach ($types as $type) {
            DocumentType::create($type);
        }
    }
}
