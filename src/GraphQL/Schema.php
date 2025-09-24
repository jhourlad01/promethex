<?php

namespace App\GraphQL;

use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;

class GraphQLSchema
{
    public static function build(): Schema
    {
        $config = SchemaConfig::create()
            ->setQuery(QueryType::getInstance())
            ->setMutation(MutationType::getInstance());

        return new Schema($config);
    }
}
