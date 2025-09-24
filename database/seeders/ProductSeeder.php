<?php

namespace Database\Seeders;

use Framework\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing products
        $this->truncate('products');
        
        // Insert sample products
        $products = [
            [
                'name' => 'Premium Wireless Headphones',
                'slug' => 'premium-wireless-headphones',
                'description' => 'High-quality wireless headphones with active noise cancellation technology. Perfect for music lovers and professionals who need crystal clear audio.',
                'short_description' => 'Wireless headphones with noise cancellation',
                'price' => 199.99,
                'sale_price' => 149.99,
                'sku' => 'PWH-001',
                'stock_quantity' => 50,
                'manage_stock' => true,
                'in_stock' => true,
                'status' => 'active',
                'featured' => true,
                'images' => json_encode([
                    '/images/products/premium-headphones-1.jpg',
                    '/images/products/premium-headphones-2.jpg'
                ]),
                'attributes' => json_encode([
                    'color' => 'Black',
                    'connectivity' => 'Bluetooth 5.0',
                    'battery_life' => '30 hours',
                    'weight' => '250g'
                ]),
                'weight' => 0.25,
                'length' => 20.0,
                'width' => 18.0,
                'height' => 8.0,
                'meta_title' => 'Premium Wireless Headphones - Best Audio Quality',
                'meta_description' => 'Get the best audio experience with our premium wireless headphones featuring noise cancellation and 30-hour battery life.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Smart Fitness Watch',
                'slug' => 'smart-fitness-watch',
                'description' => 'Track your fitness goals with this advanced smartwatch. Monitor heart rate, steps, sleep, and receive notifications on your wrist.',
                'short_description' => 'Advanced fitness tracking smartwatch',
                'price' => 299.99,
                'sale_price' => null,
                'sku' => 'SFW-002',
                'stock_quantity' => 30,
                'manage_stock' => true,
                'in_stock' => true,
                'status' => 'active',
                'featured' => true,
                'images' => json_encode([
                    '/images/products/smart-watch-1.jpg',
                    '/images/products/smart-watch-2.jpg'
                ]),
                'attributes' => json_encode([
                    'color' => 'Silver',
                    'display' => 'AMOLED',
                    'water_resistance' => '50m',
                    'battery_life' => '7 days'
                ]),
                'weight' => 0.05,
                'length' => 4.0,
                'width' => 4.0,
                'height' => 1.2,
                'meta_title' => 'Smart Fitness Watch - Track Your Health',
                'meta_description' => 'Monitor your health and fitness with this advanced smartwatch featuring heart rate monitoring and 7-day battery life.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Bluetooth Speaker Pro',
                'slug' => 'bluetooth-speaker-pro',
                'description' => 'Portable Bluetooth speaker with exceptional sound quality and long-lasting battery. Perfect for outdoor adventures and parties.',
                'short_description' => 'Portable speaker with great sound quality',
                'price' => 149.99,
                'sale_price' => 119.99,
                'sku' => 'BSP-003',
                'stock_quantity' => 75,
                'manage_stock' => true,
                'in_stock' => true,
                'status' => 'active',
                'featured' => false,
                'images' => json_encode([
                    '/images/products/bluetooth-speaker-1.jpg',
                    '/images/products/bluetooth-speaker-2.jpg'
                ]),
                'attributes' => json_encode([
                    'color' => 'Blue',
                    'connectivity' => 'Bluetooth 5.0',
                    'battery_life' => '20 hours',
                    'water_resistance' => 'IPX7'
                ]),
                'weight' => 0.6,
                'length' => 18.0,
                'width' => 6.0,
                'height' => 6.0,
                'meta_title' => 'Bluetooth Speaker Pro - Portable Sound',
                'meta_description' => 'Take your music anywhere with this portable Bluetooth speaker featuring 20-hour battery life and waterproof design.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Gaming Mechanical Keyboard',
                'slug' => 'gaming-mechanical-keyboard',
                'description' => 'Professional gaming keyboard with mechanical switches, RGB lighting, and customizable macros. Built for competitive gaming.',
                'short_description' => 'Mechanical keyboard for gaming',
                'price' => 129.99,
                'sale_price' => null,
                'sku' => 'GMK-004',
                'stock_quantity' => 40,
                'manage_stock' => true,
                'in_stock' => true,
                'status' => 'active',
                'featured' => true,
                'images' => json_encode([
                    'https://images.unsplash.com/photo-1541140532154-b024d705b90a?w=400&h=300&fit=crop',
                    'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=400&h=300&fit=crop'
                ]),
                'attributes' => json_encode([
                    'color' => 'Black',
                    'switch_type' => 'Cherry MX Blue',
                    'backlight' => 'RGB',
                    'connectivity' => 'USB-C'
                ]),
                'weight' => 1.2,
                'length' => 45.0,
                'width' => 15.0,
                'height' => 3.0,
                'meta_title' => 'Gaming Mechanical Keyboard - RGB Lighting',
                'meta_description' => 'Enhance your gaming experience with this mechanical keyboard featuring RGB lighting and Cherry MX switches.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'USB-C Multi-Port Hub',
                'slug' => 'usb-c-multi-port-hub',
                'description' => 'Expand your laptop connectivity with this USB-C hub featuring multiple ports for all your devices and accessories.',
                'short_description' => 'Multi-port USB-C hub for laptops',
                'price' => 49.99,
                'sale_price' => 39.99,
                'sku' => 'UCM-005',
                'stock_quantity' => 100,
                'manage_stock' => true,
                'in_stock' => true,
                'status' => 'active',
                'featured' => false,
                'images' => json_encode([
                    'https://images.unsplash.com/photo-1583394838336-acd977736f90?w=400&h=300&fit=crop',
                    'https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?w=400&h=300&fit=crop'
                ]),
                'attributes' => json_encode([
                    'color' => 'Silver',
                    'ports' => '4x USB 3.0, 1x HDMI, 1x SD Card',
                    'power_delivery' => '100W',
                    'compatibility' => 'USB-C laptops'
                ]),
                'weight' => 0.15,
                'length' => 12.0,
                'width' => 4.0,
                'height' => 1.5,
                'meta_title' => 'USB-C Multi-Port Hub - Expand Connectivity',
                'meta_description' => 'Connect all your devices with this USB-C hub featuring multiple ports and 100W power delivery.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Wireless Gaming Mouse',
                'slug' => 'wireless-gaming-mouse',
                'description' => 'High-precision wireless gaming mouse with customizable DPI, RGB lighting, and ergonomic design for long gaming sessions.',
                'short_description' => 'Wireless mouse for gaming',
                'price' => 79.99,
                'sale_price' => null,
                'sku' => 'WGM-006',
                'stock_quantity' => 60,
                'manage_stock' => true,
                'in_stock' => true,
                'status' => 'active',
                'featured' => false,
                'images' => json_encode([
                    'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=400&h=300&fit=crop',
                    'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=400&h=300&fit=crop'
                ]),
                'attributes' => json_encode([
                    'color' => 'Black',
                    'dpi' => '16000',
                    'connectivity' => 'Wireless 2.4GHz',
                    'battery_life' => '70 hours'
                ]),
                'weight' => 0.1,
                'length' => 12.5,
                'width' => 6.5,
                'height' => 4.0,
                'meta_title' => 'Wireless Gaming Mouse - High Precision',
                'meta_description' => 'Dominate your games with this wireless gaming mouse featuring 16000 DPI and 70-hour battery life.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];
        
        $this->insertMany('products', $products);
        
        echo "Seeded " . count($products) . " products\n";
    }
};
