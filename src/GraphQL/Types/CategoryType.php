<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class CategoryType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Category',
            'description' => 'A product category',
            'fields' => [
                'id' => [
                    'type' => Type::nonNull(Type::id()),
                    'description' => 'The category ID',
                ],
                'name' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'The category name',
                ],
                'slug' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'The category slug',
                ],
                'description' => [
                    'type' => Type::string(),
                    'description' => 'The category description',
                ],
                'image_url' => [
                    'type' => Type::string(),
                    'description' => 'The category image URL',
                ],
                'products' => [
                    'type' => Type::listOf(TypeRegistry::product()),
                    'description' => 'Products in this category',
                ],
                'product_count' => [
                    'type' => Type::int(),
                    'description' => 'Number of products in this category',
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
