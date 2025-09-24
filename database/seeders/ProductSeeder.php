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
        $this->clearTable('products');
        
        // Get main category IDs
        $electronicsCategoryId = $this->getCategoryId('Electronics');
        $audioVideoCategoryId = $this->getCategoryId('Audio & Video');
        $gamingCategoryId = $this->getCategoryId('Gaming');
        $computerAccessoriesCategoryId = $this->getCategoryId('Computer Accessories');
        $wearablesCategoryId = $this->getCategoryId('Wearables');
        
        // Insert sample products organized by categories
        $products = [
            // Audio & Video Category
            [
                'name' => 'Premium Wireless Headphones',
                'slug' => 'premium-wireless-headphones',
                'description' => 'High-quality wireless headphones with active noise cancellation technology. Perfect for music lovers and professionals who need crystal clear audio.',
                'short_description' => 'Wireless headphones with noise cancellation',
                'price' => 199.99,
                'sale_price' => 149.99,
                'sku' => 'PWH-001',
                'category_id' => $audioVideoCategoryId,
                'stock_quantity' => 50,
                'manage_stock' => true,
                'in_stock' => true,
                'status' => 'active',
                'featured' => true,
                'images' => json_encode([
                    'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=300&fit=crop',
                    'https://images.unsplash.com/photo-1583394838336-acd977736f90?w=400&h=300&fit=crop'
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
                'name' => 'Bluetooth Speaker Pro',
                'slug' => 'bluetooth-speaker-pro',
                'description' => 'Portable Bluetooth speaker with exceptional sound quality and long-lasting battery. Perfect for outdoor adventures and parties.',
                'short_description' => 'Portable speaker with great sound quality',
                'price' => 149.99,
                'sale_price' => 119.99,
                'sku' => 'BSP-002',
                'category_id' => $audioVideoCategoryId,
                'stock_quantity' => 75,
                'manage_stock' => true,
                'in_stock' => true,
                'status' => 'active',
                'featured' => false,
                'images' => json_encode([
                    'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=400&h=300&fit=crop',
                    'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=400&h=300&fit=crop'
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
                'name' => 'Studio Monitor Headphones',
                'slug' => 'studio-monitor-headphones',
                'description' => 'Professional studio monitor headphones with flat frequency response for accurate audio mixing and mastering.',
                'short_description' => 'Professional studio headphones',
                'price' => 299.99,
                'sale_price' => null,
                'sku' => 'SMH-003',
                'category_id' => $audioVideoCategoryId,
                'stock_quantity' => 25,
                'manage_stock' => true,
                'in_stock' => true,
                'status' => 'active',
                'featured' => true,
                'images' => json_encode([
                    'https://images.unsplash.com/photo-1583394838336-acd977736f90?w=400&h=300&fit=crop',
                    'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=300&fit=crop'
                ]),
                'attributes' => json_encode([
                    'color' => 'Black',
                    'type' => 'Over-ear',
                    'impedance' => '32 ohms',
                    'frequency_response' => '20Hz - 20kHz'
                ]),
                'weight' => 0.3,
                'length' => 22.0,
                'width' => 20.0,
                'height' => 9.0,
                'meta_title' => 'Studio Monitor Headphones - Professional Audio',
                'meta_description' => 'Professional studio headphones with flat frequency response for accurate audio production.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Wireless Earbuds Pro',
                'slug' => 'wireless-earbuds-pro',
                'description' => 'True wireless earbuds with active noise cancellation, transparency mode, and spatial audio for immersive listening experience.',
                'short_description' => 'True wireless earbuds with ANC',
                'price' => 179.99,
                'sale_price' => 149.99,
                'sku' => 'WEB-004',
                'category_id' => $audioVideoCategoryId,
                'stock_quantity' => 60,
                'manage_stock' => true,
                'in_stock' => true,
                'status' => 'active',
                'featured' => false,
                'images' => json_encode([
                    'https://images.unsplash.com/photo-1606220945770-b5b6c2c55bf1?w=400&h=300&fit=crop',
                    'https://images.unsplash.com/photo-1606220945770-b5b6c2c55bf1?w=400&h=300&fit=crop'
                ]),
                'attributes' => json_encode([
                    'color' => 'White',
                    'connectivity' => 'Bluetooth 5.2',
                    'battery_life' => '6 hours + 18 hours case',
                    'water_resistance' => 'IPX4'
                ]),
                'weight' => 0.05,
                'length' => 3.0,
                'width' => 2.0,
                'height' => 2.0,
                'meta_title' => 'Wireless Earbuds Pro - True Wireless',
                'meta_description' => 'Experience true wireless freedom with these premium earbuds featuring active noise cancellation.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Home Theater Soundbar',
                'slug' => 'home-theater-soundbar',
                'description' => 'Premium soundbar with Dolby Atmos support, wireless subwoofer, and voice control for immersive home theater experience.',
                'short_description' => 'Dolby Atmos soundbar system',
                'price' => 399.99,
                'sale_price' => 349.99,
                'sku' => 'HTS-005',
                'category_id' => $audioVideoCategoryId,
                'stock_quantity' => 20,
                'manage_stock' => true,
                'in_stock' => true,
                'status' => 'active',
                'featured' => true,
                'images' => json_encode([
                    'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=400&h=300&fit=crop',
                    'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=400&h=300&fit=crop'
                ]),
                'attributes' => json_encode([
                    'color' => 'Black',
                    'channels' => '5.1.2',
                    'connectivity' => 'HDMI ARC, Bluetooth, WiFi',
                    'power' => '400W'
                ]),
                'weight' => 3.5,
                'length' => 90.0,
                'width' => 8.0,
                'height' => 6.0,
                'meta_title' => 'Home Theater Soundbar - Dolby Atmos',
                'meta_description' => 'Transform your TV experience with this Dolby Atmos soundbar featuring wireless subwoofer.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Gaming Headset RGB',
                'slug' => 'gaming-headset-rgb',
                'description' => 'RGB gaming headset with 7.1 surround sound, noise-canceling microphone, and customizable lighting effects.',
                'short_description' => 'RGB gaming headset with 7.1 sound',
                'price' => 129.99,
                'sale_price' => null,
                'sku' => 'GHR-006',
                'category_id' => $audioVideoCategoryId,
                'stock_quantity' => 40,
                'manage_stock' => true,
                'in_stock' => true,
                'status' => 'active',
                'featured' => false,
                'images' => json_encode([
                    'https://images.unsplash.com/photo-1583394838336-acd977736f90?w=400&h=300&fit=crop',
                    'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=300&fit=crop'
                ]),
                'attributes' => json_encode([
                    'color' => 'Black/Red',
                    'connectivity' => 'USB',
                    'microphone' => 'Noise-canceling',
                    'surround_sound' => '7.1 Virtual'
                ]),
                'weight' => 0.35,
                'length' => 25.0,
                'width' => 22.0,
                'height' => 10.0,
                'meta_title' => 'Gaming Headset RGB - 7.1 Surround',
                'meta_description' => 'Dominate your games with this RGB gaming headset featuring 7.1 surround sound and noise-canceling mic.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Portable Bluetooth Speaker Mini',
                'slug' => 'portable-bluetooth-speaker-mini',
                'description' => 'Compact portable speaker with 360-degree sound, waterproof design, and 12-hour battery life. Perfect for travel.',
                'short_description' => 'Compact waterproof speaker',
                'price' => 79.99,
                'sale_price' => 59.99,
                'sku' => 'PBS-007',
                'category_id' => $audioVideoCategoryId,
                'stock_quantity' => 80,
                'manage_stock' => true,
                'in_stock' => true,
                'status' => 'active',
                'featured' => false,
                'images' => json_encode([
                    'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=400&h=300&fit=crop',
                    'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=400&h=300&fit=crop'
                ]),
                'attributes' => json_encode([
                    'color' => 'Red',
                    'connectivity' => 'Bluetooth 5.0',
                    'battery_life' => '12 hours',
                    'water_resistance' => 'IPX7'
                ]),
                'weight' => 0.3,
                'length' => 8.0,
                'width' => 8.0,
                'height' => 8.0,
                'meta_title' => 'Portable Bluetooth Speaker Mini - 360° Sound',
                'meta_description' => 'Take your music anywhere with this compact waterproof speaker featuring 360-degree sound.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'High-End Audiophile Headphones',
                'slug' => 'high-end-audiophile-headphones',
                'description' => 'Premium audiophile headphones with planar magnetic drivers, open-back design, and reference-grade sound quality.',
                'short_description' => 'Planar magnetic audiophile headphones',
                'price' => 899.99,
                'sale_price' => null,
                'sku' => 'HAH-008',
                'category_id' => $audioVideoCategoryId,
                'stock_quantity' => 10,
                'manage_stock' => true,
                'in_stock' => true,
                'status' => 'active',
                'featured' => true,
                'images' => json_encode([
                    'https://images.unsplash.com/photo-1583394838336-acd977736f90?w=400&h=300&fit=crop',
                    'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=300&fit=crop'
                ]),
                'attributes' => json_encode([
                    'color' => 'Silver',
                    'driver_type' => 'Planar Magnetic',
                    'impedance' => '50 ohms',
                    'frequency_response' => '10Hz - 50kHz'
                ]),
                'weight' => 0.45,
                'length' => 28.0,
                'width' => 25.0,
                'height' => 12.0,
                'meta_title' => 'High-End Audiophile Headphones - Planar Magnetic',
                'meta_description' => 'Experience reference-grade audio with these premium planar magnetic headphones.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            
            // Wearables Category
            [
                'name' => 'Smart Fitness Watch',
                'slug' => 'smart-fitness-watch',
                'description' => 'Track your fitness goals with this advanced smartwatch. Monitor heart rate, steps, sleep, and receive notifications on your wrist.',
                'short_description' => 'Advanced fitness tracking smartwatch',
                'price' => 299.99,
                'sale_price' => null,
                'sku' => 'SFW-009',
                'category_id' => $wearablesCategoryId,
                'stock_quantity' => 30,
                'manage_stock' => true,
                'in_stock' => true,
                'status' => 'active',
                'featured' => true,
                'images' => json_encode([
                    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=300&fit=crop',
                    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=300&fit=crop'
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
                'name' => 'Premium Smart Watch Pro',
                'slug' => 'premium-smart-watch-pro',
                'description' => 'Luxury smartwatch with titanium case, sapphire crystal, and advanced health monitoring features.',
                'short_description' => 'Luxury titanium smartwatch',
                'price' => 599.99,
                'sale_price' => 499.99,
                'sku' => 'PSW-010',
                'category_id' => $wearablesCategoryId,
                'stock_quantity' => 15,
                'manage_stock' => true,
                'in_stock' => true,
                'status' => 'active',
                'featured' => true,
                'images' => json_encode([
                    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=300&fit=crop',
                    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=300&fit=crop'
                ]),
                'attributes' => json_encode([
                    'color' => 'Titanium',
                    'display' => 'OLED',
                    'water_resistance' => '100m',
                    'battery_life' => '5 days'
                ]),
                'weight' => 0.08,
                'length' => 4.5,
                'width' => 4.5,
                'height' => 1.5,
                'meta_title' => 'Premium Smart Watch Pro - Titanium',
                'meta_description' => 'Luxury smartwatch with titanium case and advanced health monitoring.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Fitness Tracker Band',
                'slug' => 'fitness-tracker-band',
                'description' => 'Lightweight fitness tracker with heart rate monitoring, sleep tracking, and 7-day battery life.',
                'short_description' => 'Lightweight fitness tracker',
                'price' => 89.99,
                'sale_price' => null,
                'sku' => 'FTB-011',
                'category_id' => $wearablesCategoryId,
                'stock_quantity' => 50,
                'manage_stock' => true,
                'in_stock' => true,
                'status' => 'active',
                'featured' => false,
                'images' => json_encode([
                    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=300&fit=crop',
                    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=300&fit=crop'
                ]),
                'attributes' => json_encode([
                    'color' => 'Black',
                    'display' => 'OLED',
                    'water_resistance' => '50m',
                    'battery_life' => '7 days'
                ]),
                'weight' => 0.02,
                'length' => 2.5,
                'width' => 1.5,
                'height' => 0.8,
                'meta_title' => 'Fitness Tracker Band - Heart Rate Monitor',
                'meta_description' => 'Track your fitness with this lightweight band featuring heart rate monitoring.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Smart Ring Health Monitor',
                'slug' => 'smart-ring-health-monitor',
                'description' => 'Discrete smart ring that tracks heart rate, sleep, and activity without being noticed.',
                'short_description' => 'Discrete health monitoring ring',
                'price' => 199.99,
                'sale_price' => 179.99,
                'sku' => 'SRH-012',
                'category_id' => $wearablesCategoryId,
                'stock_quantity' => 25,
                'manage_stock' => true,
                'in_stock' => true,
                'status' => 'active',
                'featured' => false,
                'images' => json_encode([
                    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=300&fit=crop',
                    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=300&fit=crop'
                ]),
                'attributes' => json_encode([
                    'color' => 'Gold',
                    'material' => 'Titanium',
                    'water_resistance' => '50m',
                    'battery_life' => '3 days'
                ]),
                'weight' => 0.01,
                'length' => 2.0,
                'width' => 2.0,
                'height' => 0.5,
                'meta_title' => 'Smart Ring Health Monitor - Discrete Tracking',
                'meta_description' => 'Monitor your health discretely with this smart ring.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'GPS Sports Watch',
                'slug' => 'gps-sports-watch',
                'description' => 'Rugged GPS sports watch with heart rate monitoring, GPS tracking, and 20-hour battery life.',
                'short_description' => 'GPS sports watch for athletes',
                'price' => 349.99,
                'sale_price' => null,
                'sku' => 'GSW-013',
                'category_id' => $wearablesCategoryId,
                'stock_quantity' => 20,
                'manage_stock' => true,
                'in_stock' => true,
                'status' => 'active',
                'featured' => true,
                'images' => json_encode([
                    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=300&fit=crop',
                    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=300&fit=crop'
                ]),
                'attributes' => json_encode([
                    'color' => 'Black/Orange',
                    'display' => 'MIP',
                    'water_resistance' => '100m',
                    'battery_life' => '20 hours GPS'
                ]),
                'weight' => 0.12,
                'length' => 5.0,
                'width' => 5.0,
                'height' => 1.8,
                'meta_title' => 'GPS Sports Watch - Athlete Tracking',
                'meta_description' => 'Track your athletic performance with this rugged GPS sports watch.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Sleep Tracking Headband',
                'slug' => 'sleep-tracking-headband',
                'description' => 'Comfortable headband that tracks sleep stages, brain waves, and provides sleep insights.',
                'short_description' => 'Sleep tracking headband',
                'price' => 149.99,
                'sale_price' => 129.99,
                'sku' => 'STH-014',
                'category_id' => $wearablesCategoryId,
                'stock_quantity' => 30,
                'manage_stock' => true,
                'in_stock' => true,
                'status' => 'active',
                'featured' => false,
                'images' => json_encode([
                    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=300&fit=crop',
                    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=300&fit=crop'
                ]),
                'attributes' => json_encode([
                    'color' => 'Gray',
                    'material' => 'Soft Fabric',
                    'battery_life' => '10 hours',
                    'tracking' => 'Sleep Stages'
                ]),
                'weight' => 0.05,
                'length' => 25.0,
                'width' => 5.0,
                'height' => 2.0,
                'meta_title' => 'Sleep Tracking Headband - Sleep Insights',
                'meta_description' => 'Get detailed sleep insights with this comfortable tracking headband.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Smart Glasses AR',
                'slug' => 'smart-glasses-ar',
                'description' => 'Augmented reality smart glasses with display overlay, voice control, and camera.',
                'short_description' => 'AR smart glasses with display',
                'price' => 799.99,
                'sale_price' => null,
                'sku' => 'SGA-015',
                'category_id' => $wearablesCategoryId,
                'stock_quantity' => 8,
                'manage_stock' => true,
                'in_stock' => true,
                'status' => 'active',
                'featured' => true,
                'images' => json_encode([
                    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=300&fit=crop',
                    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=300&fit=crop'
                ]),
                'attributes' => json_encode([
                    'color' => 'Black',
                    'display' => 'AR Overlay',
                    'battery_life' => '6 hours',
                    'camera' => '12MP'
                ]),
                'weight' => 0.08,
                'length' => 15.0,
                'width' => 5.0,
                'height' => 2.0,
                'meta_title' => 'Smart Glasses AR - Augmented Reality',
                'meta_description' => 'Experience augmented reality with these smart glasses.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Health Monitoring Patch',
                'slug' => 'health-monitoring-patch',
                'description' => 'Disposable health monitoring patch that tracks vital signs continuously for 7 days.',
                'short_description' => '7-day health monitoring patch',
                'price' => 49.99,
                'sale_price' => null,
                'sku' => 'HMP-016',
                'category_id' => $wearablesCategoryId,
                'stock_quantity' => 100,
                'manage_stock' => true,
                'in_stock' => true,
                'status' => 'active',
                'featured' => false,
                'images' => json_encode([
                    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=300&fit=crop',
                    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=300&fit=crop'
                ]),
                'attributes' => json_encode([
                    'color' => 'Skin Tone',
                    'material' => 'Medical Grade',
                    'duration' => '7 days',
                    'tracking' => 'Continuous'
                ]),
                'weight' => 0.001,
                'length' => 3.0,
                'width' => 2.0,
                'height' => 0.1,
                'meta_title' => 'Health Monitoring Patch - 7 Day Tracking',
                'meta_description' => 'Monitor your health continuously with this disposable patch.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Smart Scale Body Analyzer',
                'slug' => 'smart-scale-body-analyzer',
                'description' => 'Smart scale that measures weight, body fat, muscle mass, and syncs with fitness apps.',
                'short_description' => 'Smart body composition scale',
                'price' => 129.99,
                'sale_price' => 99.99,
                'sku' => 'SSB-017',
                'category_id' => $wearablesCategoryId,
                'stock_quantity' => 40,
                'manage_stock' => true,
                'in_stock' => true,
                'status' => 'active',
                'featured' => false,
                'images' => json_encode([
                    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=300&fit=crop',
                    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=300&fit=crop'
                ]),
                'attributes' => json_encode([
                    'color' => 'White',
                    'capacity' => '400 lbs',
                    'connectivity' => 'WiFi, Bluetooth',
                    'measurements' => 'Body Fat, Muscle Mass'
                ]),
                'weight' => 2.5,
                'length' => 12.0,
                'width' => 12.0,
                'height' => 1.0,
                'meta_title' => 'Smart Scale Body Analyzer - Body Composition',
                'meta_description' => 'Track your body composition with this smart scale.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Wireless Earbuds Sport',
                'slug' => 'wireless-earbuds-sport',
                'description' => 'Sweat-proof wireless earbuds designed for sports with secure fit and long battery life.',
                'short_description' => 'Sports wireless earbuds',
                'price' => 119.99,
                'sale_price' => null,
                'sku' => 'WES-018',
                'category_id' => $wearablesCategoryId,
                'stock_quantity' => 60,
                'manage_stock' => true,
                'in_stock' => true,
                'status' => 'active',
                'featured' => false,
                'images' => json_encode([
                    'https://images.unsplash.com/photo-1606220945770-b5b6c2c55bf1?w=400&h=300&fit=crop',
                    'https://images.unsplash.com/photo-1606220945770-b5b6c2c55bf1?w=400&h=300&fit=crop'
                ]),
                'attributes' => json_encode([
                    'color' => 'Black/Red',
                    'water_resistance' => 'IPX7',
                    'battery_life' => '8 hours + 24 hours case',
                    'fit' => 'Secure Sport Fit'
                ]),
                'weight' => 0.06,
                'length' => 3.5,
                'width' => 2.5,
                'height' => 2.5,
                'meta_title' => 'Wireless Earbuds Sport - Sweat Proof',
                'meta_description' => 'Stay active with these sweat-proof sports earbuds.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Smart Clothing Shirt',
                'slug' => 'smart-clothing-shirt',
                'description' => 'Smart shirt with built-in sensors to track heart rate, breathing, and posture throughout the day.',
                'short_description' => 'Smart shirt with health sensors',
                'price' => 199.99,
                'sale_price' => 179.99,
                'sku' => 'SCS-019',
                'category_id' => $wearablesCategoryId,
                'stock_quantity' => 25,
                'manage_stock' => true,
                'in_stock' => true,
                'status' => 'active',
                'featured' => true,
                'images' => json_encode([
                    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=300&fit=crop',
                    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=300&fit=crop'
                ]),
                'attributes' => json_encode([
                    'color' => 'Black',
                    'material' => 'Smart Fabric',
                    'washable' => 'Yes',
                    'tracking' => 'Heart Rate, Breathing'
                ]),
                'weight' => 0.2,
                'length' => 30.0,
                'width' => 25.0,
                'height' => 1.0,
                'meta_title' => 'Smart Clothing Shirt - Health Tracking',
                'meta_description' => 'Track your health with this smart shirt featuring built-in sensors.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'VR Fitness Headset',
                'slug' => 'vr-fitness-headset',
                'description' => 'Virtual reality headset designed for fitness with motion tracking and immersive workout experiences.',
                'short_description' => 'VR headset for fitness',
                'price' => 399.99,
                'sale_price' => null,
                'sku' => 'VRF-020',
                'category_id' => $wearablesCategoryId,
                'stock_quantity' => 15,
                'manage_stock' => true,
                'in_stock' => true,
                'status' => 'active',
                'featured' => true,
                'images' => json_encode([
                    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=300&fit=crop',
                    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=300&fit=crop'
                ]),
                'attributes' => json_encode([
                    'color' => 'Black/Blue',
                    'display' => 'OLED',
                    'tracking' => '6DOF',
                    'battery_life' => '2 hours'
                ]),
                'weight' => 0.5,
                'length' => 20.0,
                'width' => 15.0,
                'height' => 10.0,
                'meta_title' => 'VR Fitness Headset - Immersive Workouts',
                'meta_description' => 'Transform your fitness routine with this VR headset.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];
        
        $this->insertMany('products', $products);
        
        echo "Seeded " . count($products) . " products\n";
    }
    
    /**
     * Helper method to get category ID by name
     */
    private function getCategoryId(string $categoryName): ?int
    {
        $category = \Illuminate\Database\Capsule\Manager::table('categories')
            ->where('name', $categoryName)
            ->first();
        
        return $category ? $category->id : null;
    }
}
