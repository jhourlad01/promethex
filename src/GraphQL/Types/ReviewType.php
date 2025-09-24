<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ReviewType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Review',
            'description' => 'A product review',
            'fields' => [
                'id' => [
                    'type' => Type::nonNull(Type::id()),
                    'description' => 'The review ID',
                ],
                'rating' => [
                    'type' => Type::nonNull(Type::int()),
                    'description' => 'The review rating (1-5)',
                ],
                'title' => [
                    'type' => Type::string(),
                    'description' => 'The review title',
                ],
                'comment' => [
                    'type' => Type::string(),
                    'description' => 'The review comment',
                ],
                'is_approved' => [
                    'type' => Type::boolean(),
                    'description' => 'Whether the review is approved',
                ],
                'is_featured' => [
                    'type' => Type::boolean(),
                    'description' => 'Whether the review is featured',
                ],
                'is_verified_purchase' => [
                    'type' => Type::boolean(),
                    'description' => 'Whether this is a verified purchase',
                ],
                'helpful_votes' => [
                    'type' => Type::int(),
                    'description' => 'Number of helpful votes',
                ],
                'helpful_count' => [
                    'type' => Type::int(),
                    'description' => 'Number of helpful votes',
                ],
                'product' => [
                    'type' => TypeRegistry::product(),
                    'description' => 'The reviewed product',
                ],
                'user' => [
                    'type' => TypeRegistry::user(),
                    'description' => 'The review author',
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
