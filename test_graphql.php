<?php

require_once 'vendor/autoload.php';
require_once 'core/helpers.php';

use Framework\{Env, Config, Database};
use App\GraphQL\Schema as GraphQLSchema;
use GraphQL\GraphQL;

// Load environment and config
Env::load('.env');
Config::load('config/app.php');

// Initialize database
Database::configure(Config::get('database'));

try {
    echo "Testing GraphQL Schema...\n";
    
    // Build the schema
    $schema = GraphQLSchema::build();
    echo "✅ GraphQL Schema built successfully!\n";
    
    // Test a simple query
    $query = '
    {
        products(limit: 2) {
            id
            name
            price
            category {
                name
            }
        }
    }';
    
    echo "Testing query: Get 2 products with their categories...\n";
    
    $result = GraphQL::executeQuery($schema, $query);
    $data = $result->toArray();
    
    if (isset($data['data']['products'])) {
        echo "✅ Query executed successfully!\n";
        echo "Found " . count($data['data']['products']) . " products\n";
        
        foreach ($data['data']['products'] as $product) {
            echo "- {$product['name']} (${$product['price']}) - Category: {$product['category']['name']}\n";
        }
    } else {
        echo "❌ Query failed\n";
        if (isset($data['errors'])) {
            foreach ($data['errors'] as $error) {
                echo "Error: " . $error['message'] . "\n";
            }
        }
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
