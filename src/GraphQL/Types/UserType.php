<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class UserType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'User',
            'description' => 'A user account',
            'fields' => [
                'id' => [
                    'type' => Type::nonNull(Type::id()),
                    'description' => 'The user ID',
                ],
                'name' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'The user name',
                ],
                'email' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'The user email',
                ],
                'email_verified_at' => [
                    'type' => Type::string(),
                    'description' => 'Email verification date',
                ],
                'reviews' => [
                    'type' => Type::listOf(TypeRegistry::review()),
                    'description' => 'User reviews',
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
