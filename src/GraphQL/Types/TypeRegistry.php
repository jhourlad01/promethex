<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;

class TypeRegistry
{
    private static $product;
    private static $category;
    private static $review;
    private static $user;

    public static function product(): ProductType
    {
        return self::$product ?: (self::$product = new ProductType());
    }

    public static function category(): CategoryType
    {
        return self::$category ?: (self::$category = new CategoryType());
    }

    public static function review(): ReviewType
    {
        return self::$review ?: (self::$review = new ReviewType());
    }

    public static function user(): UserType
    {
        return self::$user ?: (self::$user = new UserType());
    }
}
