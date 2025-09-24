<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../core/helpers.php';

use Framework\{Database, MigrationRunner, SeederRunner, Config, Env};

// Load environment variables
Env::load('.env');

// Load configuration
Config::load(require __DIR__ . '/../config/app.php');

// Configure database
Database::configure(config('database'));

// Register migrations
require_once __DIR__ . '/migrations/CreateUsersTable.php';
require_once __DIR__ . '/migrations/CreateProductsTable.php';
MigrationRunner::register('create_users_table', \Database\Migrations\CreateUsersTable::class);
MigrationRunner::register('create_products_table', \Database\Migrations\CreateProductsTable::class);

// Register seeders
require_once __DIR__ . '/seeders/UserSeeder.php';
require_once __DIR__ . '/seeders/ProductSeeder.php';
require_once __DIR__ . '/seeders/DatabaseSeeder.php';
SeederRunner::register('user_seeder', \Database\Seeders\UserSeeder::class);
SeederRunner::register('product_seeder', \Database\Seeders\ProductSeeder::class);
SeederRunner::register('database_seeder', \Database\Seeders\DatabaseSeeder::class);

// Get command from CLI arguments
$command = $argv[1] ?? 'help';

switch ($command) {
    case 'migrate':
        echo "Running migrations...\n";
        MigrationRunner::run();
        break;
        
    case 'rollback':
        echo "Rolling back migrations...\n";
        MigrationRunner::rollback();
        break;
        
    case 'migrate:status':
        MigrationRunner::status();
        break;
        
    case 'seed':
        echo "Running seeders...\n";
        SeederRunner::run();
        break;
        
            case 'seed:user':
                echo "Running user seeder...\n";
                SeederRunner::runSpecificSeeder('user_seeder');
                break;
                
            case 'seed:product':
                echo "Running product seeder...\n";
                SeederRunner::runSpecificSeeder('product_seeder');
                break;
        
    case 'seed:fresh':
        echo "Running fresh seeders...\n";
        SeederRunner::fresh();
        break;
        
    case 'seed:status':
        SeederRunner::status();
        break;
        
    case 'seed:reset':
        SeederRunner::reset();
        break;
        
    case 'fresh':
        echo "Running fresh migration and seed...\n";
        MigrationRunner::run();
        SeederRunner::fresh();
        break;
        
    case 'help':
    default:
        echo "Available commands:\n";
        echo "==================\n";
        echo "migrate          - Run all pending migrations\n";
        echo "rollback         - Rollback the last batch of migrations\n";
        echo "migrate:status   - Show migration status\n";
        echo "seed             - Run all seeders\n";
        echo "seed:fresh       - Run fresh seeders (truncate tables first)\n";
        echo "seed:status      - Show seeder status\n";
        echo "seed:reset       - Reset seeder tracking\n";
        echo "fresh            - Run migrations and fresh seeders\n";
        echo "help             - Show this help message\n";
        break;
}
