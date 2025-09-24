<?php

namespace Database\Seeders;

use Framework\Seeder;
use App\Models\Review;
use App\Models\Product;
use App\Models\User;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing reviews
        $this->clearTable('reviews');
        
        // Get all products and users
        $products = Product::all();
        $users = User::all();
        
        if ($products->isEmpty() || $users->isEmpty()) {
            echo "No products or users found. Skipping review seeding.\n";
            return;
        }
        
        $reviews = [];
        $reviewTemplates = [
            [
                'ratings' => [5, 5, 4, 5, 4],
                'titles' => [
                    'Excellent product!',
                    'Great quality and fast delivery',
                    'Very satisfied with this purchase',
                    'Perfect for my needs',
                    'Highly recommended'
                ],
                'comments' => [
                    'This product exceeded my expectations. The quality is outstanding and it arrived quickly. I would definitely buy again!',
                    'Great product with excellent build quality. The features work exactly as described. Very happy with this purchase.',
                    'Good product overall. Minor issues but nothing major. Would recommend to others looking for this type of item.',
                    'Perfect product for what I needed. Easy to use and great value for money. Shipping was fast too.',
                    'Amazing quality and great customer service. The product arrived in perfect condition and works flawlessly.'
                ]
            ],
            [
                'ratings' => [4, 3, 4, 5, 3],
                'titles' => [
                    'Good product with minor issues',
                    'Decent quality for the price',
                    'Works as expected',
                    'Great value for money',
                    'Satisfactory purchase'
                ],
                'comments' => [
                    'Good product overall. There are a few minor issues but nothing that affects the main functionality. Would buy again.',
                    'Decent quality for the price point. Not perfect but gets the job done. Shipping was reasonable.',
                    'Product works as expected. No major complaints but could be improved in some areas. Overall satisfied.',
                    'Great value for the money spent. Quality is good and the product meets my requirements well.',
                    'Satisfactory purchase. The product does what it\'s supposed to do. Nothing extraordinary but reliable.'
                ]
            ],
            [
                'ratings' => [2, 3, 2, 1, 3],
                'titles' => [
                    'Not what I expected',
                    'Could be better',
                    'Disappointed with quality',
                    'Poor experience',
                    'Below expectations'
                ],
                'comments' => [
                    'The product didn\'t meet my expectations. Quality could be better and some features don\'t work as advertised.',
                    'Could be better for the price. The product works but has some issues that are frustrating to deal with.',
                    'Disappointed with the overall quality. Expected better based on the description and reviews.',
                    'Poor experience with this product. Multiple issues and customer service wasn\'t very helpful.',
                    'Below my expectations. The product functions but not as well as I hoped. Would not recommend.'
                ]
            ]
        ];
        
        // Create reviews for each product
        foreach ($products as $product) {
            // Randomly select 3-8 users to review this product
            $reviewCount = rand(3, min(8, $users->count()));
            $selectedUsers = $users->random($reviewCount);
            
            foreach ($selectedUsers as $user) {
                $template = $reviewTemplates[array_rand($reviewTemplates)];
                $rating = $template['ratings'][array_rand($template['ratings'])];
                $title = $template['titles'][array_rand($template['titles'])];
                $comment = $template['comments'][array_rand($template['comments'])];
                
                // Add some variation to comments
                $comment = $this->addVariationToComment($comment, $product->name);
                
                $reviews[] = [
                    'product_id' => $product->id,
                    'user_id' => $user->id,
                    'rating' => $rating,
                    'title' => $title,
                    'comment' => $comment,
                    'is_verified_purchase' => rand(0, 1) == 1, // 50% chance of verified purchase
                    'is_approved' => true, // All reviews are approved for seeding
                    'is_featured' => $rating >= 4 && rand(0, 2) == 0, // 33% chance for 4+ star reviews
                    'helpful_votes' => json_encode([]),
                    'helpful_count' => 0,
                    'created_at' => $this->getRandomDate(),
                    'updated_at' => $this->getRandomDate(),
                ];
            }
        }
        
        // Insert all reviews
        $this->insertMany('reviews', $reviews);
        
        echo "Seeded " . count($reviews) . " reviews\n";
    }
    
    /**
     * Add variation to review comments
     */
    private function addVariationToComment(string $comment, string $productName): string
    {
        $variations = [
            'The ' . strtolower($productName) . ' is ',
            'This ' . strtolower($productName) . ' has ',
            'I found the ' . strtolower($productName) . ' to be ',
            'The ' . strtolower($productName) . ' works ',
            'My experience with the ' . strtolower($productName) . ' was '
        ];
        
        // Sometimes add product name variation
        if (rand(0, 2) == 0) {
            $variation = $variations[array_rand($variations)];
            $comment = $variation . strtolower(substr($comment, 4));
        }
        
        return $comment;
    }
    
    /**
     * Get a random date within the last 6 months
     */
    private function getRandomDate(): string
    {
        $start = strtotime('-6 months');
        $end = time();
        $randomTimestamp = rand($start, $end);
        return date('Y-m-d H:i:s', $randomTimestamp);
    }
}
