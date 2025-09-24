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
        
        // Insert sample categories
        $categories = [
            // Root categories
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
        
        // Insert root categories first
        $this->insertMany('categories', $categories);
        
        // Get the inserted category IDs for subcategories
        $electronicsId = $this->getLastInsertedId('categories', 'Electronics');
        $audioVideoId = $this->getLastInsertedId('categories', 'Audio & Video');
        $gamingId = $this->getLastInsertedId('categories', 'Gaming');
        $computerId = $this->getLastInsertedId('categories', 'Computer Accessories');
        $wearablesId = $this->getLastInsertedId('categories', 'Wearables');
        
        // Subcategories
        $subcategories = [
            // Electronics subcategories
            [
                'name' => 'Smartphones',
                'slug' => 'smartphones',
                'description' => 'Latest smartphones and mobile devices.',
                'image' => '/images/categories/smartphones.jpg',
                'icon' => 'fas fa-mobile-alt',
                'parent_id' => $electronicsId,
                'sort_order' => 1,
                'is_active' => true,
                'is_featured' => false,
                'meta_title' => 'Smartphones - Latest Mobile Devices',
                'meta_description' => 'Discover the latest smartphones with cutting-edge technology.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Tablets',
                'slug' => 'tablets',
                'description' => 'Tablets and portable computing devices.',
                'image' => '/images/categories/tablets.jpg',
                'icon' => 'fas fa-tablet-alt',
                'parent_id' => $electronicsId,
                'sort_order' => 2,
                'is_active' => true,
                'is_featured' => false,
                'meta_title' => 'Tablets - Portable Computing',
                'meta_description' => 'High-performance tablets for work and entertainment.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            
            // Audio & Video subcategories
            [
                'name' => 'Headphones',
                'slug' => 'headphones',
                'description' => 'Wireless and wired headphones for all occasions.',
                'image' => '/images/categories/headphones.jpg',
                'icon' => 'fas fa-headphones',
                'parent_id' => $audioVideoId,
                'sort_order' => 1,
                'is_active' => true,
                'is_featured' => true,
                'meta_title' => 'Headphones - Wireless & Wired',
                'meta_description' => 'Premium headphones for music lovers and professionals.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Speakers',
                'slug' => 'speakers',
                'description' => 'Bluetooth speakers and audio systems.',
                'image' => '/images/categories/speakers.jpg',
                'icon' => 'fas fa-volume-up',
                'parent_id' => $audioVideoId,
                'sort_order' => 2,
                'is_active' => true,
                'is_featured' => false,
                'meta_title' => 'Speakers - Bluetooth & Audio Systems',
                'meta_description' => 'High-quality speakers for home and outdoor use.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            
            // Gaming subcategories
            [
                'name' => 'Gaming Keyboards',
                'slug' => 'gaming-keyboards',
                'description' => 'Mechanical keyboards designed for gaming.',
                'image' => '/images/categories/gaming-keyboards.jpg',
                'icon' => 'fas fa-keyboard',
                'parent_id' => $gamingId,
                'sort_order' => 1,
                'is_active' => true,
                'is_featured' => true,
                'meta_title' => 'Gaming Keyboards - Mechanical & RGB',
                'meta_description' => 'Professional gaming keyboards with mechanical switches.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Gaming Mice',
                'slug' => 'gaming-mice',
                'description' => 'High-precision gaming mice and accessories.',
                'image' => '/images/categories/gaming-mice.jpg',
                'icon' => 'fas fa-mouse',
                'parent_id' => $gamingId,
                'sort_order' => 2,
                'is_active' => true,
                'is_featured' => false,
                'meta_title' => 'Gaming Mice - High Precision',
                'meta_description' => 'Professional gaming mice for competitive gaming.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            
            // Computer Accessories subcategories
            [
                'name' => 'USB Hubs',
                'slug' => 'usb-hubs',
                'description' => 'USB hubs and connectivity accessories.',
                'image' => '/images/categories/usb-hubs.jpg',
                'icon' => 'fas fa-usb',
                'parent_id' => $computerId,
                'sort_order' => 1,
                'is_active' => true,
                'is_featured' => false,
                'meta_title' => 'USB Hubs - Connectivity Solutions',
                'meta_description' => 'Expand your device connectivity with USB hubs.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            
            // Wearables subcategories
            [
                'name' => 'Smart Watches',
                'slug' => 'smart-watches',
                'description' => 'Smart watches and fitness trackers.',
                'image' => '/images/categories/smart-watches.jpg',
                'icon' => 'fas fa-clock',
                'parent_id' => $wearablesId,
                'sort_order' => 1,
                'is_active' => true,
                'is_featured' => true,
                'meta_title' => 'Smart Watches - Health & Fitness',
                'meta_description' => 'Track your health and fitness with smart watches.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        
        // Insert subcategories
        $this->insertMany('categories', $subcategories);
        
        echo "Seeded " . (count($categories) + count($subcategories)) . " categories\n";
    }
    
    /**
     * Helper method to get the ID of the last inserted category by name
     */
    private function getLastInsertedId(string $table, string $name): int
    {
        $result = \Illuminate\Database\Capsule\Manager::table($table)
            ->where('name', $name)
            ->first();
        
        return $result ? $result->id : 0;
    }
}
