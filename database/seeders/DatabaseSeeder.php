<?php

namespace Database\Seeders;

use Framework\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "Running database seeders...\n";
        
        $this->callMany([
            UserSeeder::class,
            // Add more seeders here as needed
        ]);
        
        echo "All seeders completed!\n";
    }
}
