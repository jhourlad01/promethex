<?php

namespace App\GraphQL;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use App\Models\User;

class QueryType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Query',
            'description' => 'Root query type',
            'fields' => [
                'product' => [
                    'type' => TypeRegistry::product(),
                    'description' => 'Get a product by ID or slug',
                    'args' => [
                        'id' => [
                            'type' => Type::id(),
                            'description' => 'Product ID',
                        ],
                        'slug' => [
                            'type' => Type::string(),
                            'description' => 'Product slug',
                        ],
                    ],
                    'resolve' => function ($root, $args) {
                        if (isset($args['id'])) {
                            return Product::find($args['id']);
                        }
                        if (isset($args['slug'])) {
                            return Product::where('slug', $args['slug'])->first();
                        }
                        return null;
                    },
                ],
                'products' => [
                    'type' => Type::listOf(TypeRegistry::product()),
                    'description' => 'Get all products',
                    'args' => [
                        'featured' => [
                            'type' => Type::boolean(),
                            'description' => 'Filter by featured products',
                        ],
                        'category_id' => [
                            'type' => Type::id(),
                            'description' => 'Filter by category ID',
                        ],
                        'limit' => [
                            'type' => Type::int(),
                            'description' => 'Limit number of results',
                            'defaultValue' => 20,
                        ],
                    ],
                    'resolve' => function ($root, $args) {
                        $query = Product::query();
                        
                        if (isset($args['featured'])) {
                            $query->where('featured', $args['featured']);
                        }
                        
                        if (isset($args['category_id'])) {
                            $query->where('category_id', $args['category_id']);
                        }
                        
                        return $query->limit($args['limit'] ?? 20)->get();
                    },
                ],
                'category' => [
                    'type' => TypeRegistry::category(),
                    'description' => 'Get a category by ID or slug',
                    'args' => [
                        'id' => [
                            'type' => Type::id(),
                            'description' => 'Category ID',
                        ],
                        'slug' => [
                            'type' => Type::string(),
                            'description' => 'Category slug',
                        ],
                    ],
                    'resolve' => function ($root, $args) {
                        if (isset($args['id'])) {
                            return Category::find($args['id']);
                        }
                        if (isset($args['slug'])) {
                            return Category::where('slug', $args['slug'])->first();
                        }
                        return null;
                    },
                ],
                'categories' => [
                    'type' => Type::listOf(TypeRegistry::category()),
                    'description' => 'Get all categories',
                    'resolve' => function () {
                        return Category::all();
                    },
                ],
                'reviews' => [
                    'type' => Type::listOf(TypeRegistry::review()),
                    'description' => 'Get reviews',
                    'args' => [
                        'product_id' => [
                            'type' => Type::id(),
                            'description' => 'Filter by product ID',
                        ],
                        'approved' => [
                            'type' => Type::boolean(),
                            'description' => 'Filter by approval status',
                        ],
                        'limit' => [
                            'type' => Type::int(),
                            'description' => 'Limit number of results',
                            'defaultValue' => 20,
                        ],
                    ],
                    'resolve' => function ($root, $args) {
                        $query = Review::query();
                        
                        if (isset($args['product_id'])) {
                            $query->where('product_id', $args['product_id']);
                        }
                        
                        if (isset($args['approved'])) {
                            $query->where('is_approved', $args['approved']);
                        }
                        
                        return $query->limit($args['limit'] ?? 20)->get();
                    },
                ],
                'user' => [
                    'type' => TypeRegistry::user(),
                    'description' => 'Get a user by ID',
                    'args' => [
                        'id' => [
                            'type' => Type::nonNull(Type::id()),
                            'description' => 'User ID',
                        ],
                    ],
                    'resolve' => function ($root, $args) {
                        return User::find($args['id']);
                    },
                ],
            ],
        ]);
    }
}
