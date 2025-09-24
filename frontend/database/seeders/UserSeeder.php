<?php

namespace Database\Seeders;

use Framework\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing users
        $this->clearTable('users');
        
        // Insert sample users
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@promethex.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'phone' => '+1-555-0101',
                'address' => '123 Admin Street, Admin City, AC 12345',
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'phone' => '+1-555-0102',
                'address' => '456 Main Street, Anytown, AT 67890',
                'role' => 'user',
                'is_active' => true,
                'email_verified_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'phone' => '+1-555-0103',
                'address' => '789 Oak Avenue, Somewhere, SW 11111',
                'role' => 'user',
                'is_active' => true,
                'email_verified_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Moderator User',
                'email' => 'moderator@promethex.com',
                'password' => password_hash('mod123', PASSWORD_DEFAULT),
                'phone' => '+1-555-0104',
                'address' => '321 Moderator Lane, Mod City, MC 22222',
                'role' => 'moderator',
                'is_active' => true,
                'email_verified_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => password_hash('test123', PASSWORD_DEFAULT),
                'phone' => '+1-555-0105',
                'address' => '555 Test Road, Testville, TV 33333',
                'role' => 'user',
                'is_active' => false,
                'email_verified_at' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        
        $this->insertMany('users', $users);
        
        echo "Seeded " . count($users) . " users\n";
    }
}
