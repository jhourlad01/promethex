<?php

namespace Database\Seeders;

use Framework\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing categories
        $this->clearTable('categories');
        
        // Insert main categories only (NO SUBCATEGORIES)
        $categories = [
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Electronic devices, gadgets, and accessories for modern living.',
                'image' => '/images/categories/electronics.jpg',
                'icon' => 'fas fa-microchip',
                'parent_id' => null,
                'sort_order' => 1,
                'is_active' => true,
                'is_featured' => true,
                'meta_title' => 'Electronics - Latest Tech Gadgets',
                'meta_description' => 'Discover the latest electronic devices and gadgets for your home and office.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Audio & Video',
                'slug' => 'audio-video',
                'description' => 'High-quality audio and video equipment for entertainment and professional use.',
                'image' => '/images/categories/audio-video.jpg',
                'icon' => 'fas fa-headphones',
                'parent_id' => null,
                'sort_order' => 2,
                'is_active' => true,
                'is_featured' => true,
                'meta_title' => 'Audio & Video Equipment',
                'meta_description' => 'Premium audio and video equipment for the best entertainment experience.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Gaming',
                'slug' => 'gaming',
                'description' => 'Gaming peripherals, accessories, and equipment for gamers.',
                'image' => '/images/categories/gaming.jpg',
                'icon' => 'fas fa-gamepad',
                'parent_id' => null,
                'sort_order' => 3,
                'is_active' => true,
                'is_featured' => true,
                'meta_title' => 'Gaming Equipment & Accessories',
                'meta_description' => 'Professional gaming equipment and accessories for competitive gaming.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Computer Accessories',
                'slug' => 'computer-accessories',
                'description' => 'Essential accessories and peripherals for computers and laptops.',
                'image' => '/images/categories/computer-accessories.jpg',
                'icon' => 'fas fa-laptop',
                'parent_id' => null,
                'sort_order' => 4,
                'is_active' => true,
                'is_featured' => false,
                'meta_title' => 'Computer Accessories & Peripherals',
                'meta_description' => 'Essential computer accessories and peripherals for productivity.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Wearables',
                'slug' => 'wearables',
                'description' => 'Smart watches, fitness trackers, and wearable technology.',
                'image' => '/images/categories/wearables.jpg',
                'icon' => 'fas fa-clock',
                'parent_id' => null,
                'sort_order' => 5,
                'is_active' => true,
                'is_featured' => false,
                'meta_title' => 'Smart Wearables & Fitness Trackers',
                'meta_description' => 'Smart watches and fitness trackers to monitor your health and lifestyle.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        
        // Insert categories
        $this->insertMany('categories', $categories);
        
        echo "Seeded " . count($categories) . " categories\n";
    }
}
