<?php

namespace App\GraphQL;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use App\Models\User;

class MutationType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Mutation',
            'description' => 'Root mutation type',
            'fields' => [
                'createReview' => [
                    'type' => TypeRegistry::review(),
                    'description' => 'Create a new review',
                    'args' => [
                        'product_id' => [
                            'type' => Type::nonNull(Type::id()),
                            'description' => 'Product ID',
                        ],
                        'user_id' => [
                            'type' => Type::nonNull(Type::id()),
                            'description' => 'User ID',
                        ],
                        'rating' => [
                            'type' => Type::nonNull(Type::int()),
                            'description' => 'Rating (1-5)',
                        ],
                        'title' => [
                            'type' => Type::string(),
                            'description' => 'Review title',
                        ],
                        'comment' => [
                            'type' => Type::string(),
                            'description' => 'Review comment',
                        ],
                        'is_verified_purchase' => [
                            'type' => Type::boolean(),
                            'description' => 'Is verified purchase',
                            'defaultValue' => false,
                        ],
                    ],
                    'resolve' => function ($root, $args) {
                        // Check if user already reviewed this product
                        $existingReview = Review::where('user_id', $args['user_id'])
                            ->where('product_id', $args['product_id'])
                            ->first();
                            
                        if ($existingReview) {
                            throw new \Exception('User has already reviewed this product');
                        }
                        
                        return Review::create([
                            'product_id' => $args['product_id'],
                            'user_id' => $args['user_id'],
                            'rating' => $args['rating'],
                            'title' => $args['title'] ?? null,
                            'comment' => $args['comment'] ?? null,
                            'is_verified_purchase' => $args['is_verified_purchase'] ?? false,
                            'is_approved' => false, // Default to not approved
                            'is_featured' => false,
                            'helpful_votes' => 0,
                            'helpful_count' => 0,
                        ]);
                    },
                ],
                'updateReview' => [
                    'type' => TypeRegistry::review(),
                    'description' => 'Update an existing review',
                    'args' => [
                        'id' => [
                            'type' => Type::nonNull(Type::id()),
                            'description' => 'Review ID',
                        ],
                        'rating' => [
                            'type' => Type::int(),
                            'description' => 'Rating (1-5)',
                        ],
                        'title' => [
                            'type' => Type::string(),
                            'description' => 'Review title',
                        ],
                        'comment' => [
                            'type' => Type::string(),
                            'description' => 'Review comment',
                        ],
                    ],
                    'resolve' => function ($root, $args) {
                        $review = Review::find($args['id']);
                        
                        if (!$review) {
                            throw new \Exception('Review not found');
                        }
                        
                        $review->update(array_filter([
                            'rating' => $args['rating'] ?? null,
                            'title' => $args['title'] ?? null,
                            'comment' => $args['comment'] ?? null,
                        ], function($value) {
                            return $value !== null;
                        }));
                        
                        return $review;
                    },
                ],
                'deleteReview' => [
                    'type' => Type::boolean(),
                    'description' => 'Delete a review',
                    'args' => [
                        'id' => [
                            'type' => Type::nonNull(Type::id()),
                            'description' => 'Review ID',
                        ],
                    ],
                    'resolve' => function ($root, $args) {
                        $review = Review::find($args['id']);
                        
                        if (!$review) {
                            throw new \Exception('Review not found');
                        }
                        
                        return $review->delete();
                    },
                ],
                'markReviewHelpful' => [
                    'type' => TypeRegistry::review(),
                    'description' => 'Mark a review as helpful',
                    'args' => [
                        'id' => [
                            'type' => Type::nonNull(Type::id()),
                            'description' => 'Review ID',
                        ],
                    ],
                    'resolve' => function ($root, $args) {
                        $review = Review::find($args['id']);
                        
                        if (!$review) {
                            throw new \Exception('Review not found');
                        }
                        
                        $review->increment('helpful_votes');
                        $review->increment('helpful_count');
                        
                        return $review;
                    },
                ],
            ],
        ]);
    }
}
