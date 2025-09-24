<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\Models\Product;

class ProductType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Product',
            'description' => 'A product in the store',
            'fields' => [
                'id' => [
                    'type' => Type::nonNull(Type::id()),
                    'description' => 'The product ID',
                ],
                'name' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'The product name',
                ],
                'slug' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'The product slug',
                ],
                'description' => [
                    'type' => Type::string(),
                    'description' => 'The product description',
                ],
                'price' => [
                    'type' => Type::nonNull(Type::float()),
                    'description' => 'The product price',
                ],
                'sale_price' => [
                    'type' => Type::float(),
                    'description' => 'The product sale price',
                ],
                'sku' => [
                    'type' => Type::string(),
                    'description' => 'The product SKU',
                ],
                'stock_quantity' => [
                    'type' => Type::int(),
                    'description' => 'The stock quantity',
                ],
                'featured' => [
                    'type' => Type::boolean(),
                    'description' => 'Whether the product is featured',
                ],
                'status' => [
                    'type' => Type::string(),
                    'description' => 'The product status',
                ],
                'in_stock' => [
                    'type' => Type::boolean(),
                    'description' => 'Whether the product is in stock',
                ],
                'images' => [
                    'type' => Type::listOf(Type::string()),
                    'description' => 'Product images',
                ],
                'primary_image' => [
                    'type' => Type::string(),
                    'description' => 'Primary product image',
                ],
                'category' => [
                    'type' => TypeRegistry::category(),
                    'description' => 'The product category',
                ],
                'reviews' => [
                    'type' => Type::listOf(TypeRegistry::review()),
                    'description' => 'Product reviews',
                ],
                'average_rating' => [
                    'type' => Type::float(),
                    'description' => 'Average rating of the product',
                ],
                'total_reviews' => [
                    'type' => Type::int(),
                    'description' => 'Total number of reviews',
                ],
                'created_at' => [
                    'type' => Type::string(),
                    'description' => 'Creation date',
                ],
                'updated_at' => [
                    'type' => Type::string(),
                    'description' => 'Last update date',
                ],
            ],
        ]);
    }
}
