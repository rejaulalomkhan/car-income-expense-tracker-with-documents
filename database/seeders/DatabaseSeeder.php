<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
        ]);

        // Call other seeders
        $this->call([
            CarSeeder::class,
            CarDocumentSeeder::class,
            DocumentTypeSeeder::class,
            IncomeSeeder::class,
            ExpenseSeeder::class,
        ]);
    }
}
