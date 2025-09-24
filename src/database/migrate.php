<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../core/helpers.php';
require_once __DIR__ . '/../../database/migrations/CreateUsersTable.php';
require_once __DIR__ . '/../../database/migrations/CreateCategoriesTable.php';
require_once __DIR__ . '/../../database/migrations/CreateProductsTable.php';
require_once __DIR__ . '/../../database/migrations/CreateReviewsTable.php';
require_once __DIR__ . '/../../database/seeders/UserSeeder.php';
require_once __DIR__ . '/../../database/seeders/CategorySeeder.php';
require_once __DIR__ . '/../../database/seeders/ProductSeeder.php';
require_once __DIR__ . '/../../database/seeders/ReviewSeeder.php';
require_once __DIR__ . '/../../database/seeders/DatabaseSeeder.php';

use Framework\{MigrationCommand, MigrationRegistry};

$command = new MigrationCommand();
$command->bootstrap();

// Register migrations in order (categories before products, products before reviews)
MigrationRegistry::registerMigration('create_users_table', \Database\Migrations\CreateUsersTable::class);
MigrationRegistry::registerMigration('create_categories_table', \Database\Migrations\CreateCategoriesTable::class);
MigrationRegistry::registerMigration('create_products_table', \Database\Migrations\CreateProductsTable::class);
MigrationRegistry::registerMigration('create_reviews_table', \Database\Migrations\CreateReviewsTable::class);

// Register seeders in order (categories before products, products before reviews)
MigrationRegistry::registerSeeder('user_seeder', \Database\Seeders\UserSeeder::class);
MigrationRegistry::registerSeeder('category_seeder', \Database\Seeders\CategorySeeder::class);
MigrationRegistry::registerSeeder('product_seeder', \Database\Seeders\ProductSeeder::class);
MigrationRegistry::registerSeeder('review_seeder', \Database\Seeders\ReviewSeeder::class);
MigrationRegistry::registerSeeder('database_seeder', \Database\Seeders\DatabaseSeeder::class);

$command->registerWithRunners();
$command->execute($argv);
