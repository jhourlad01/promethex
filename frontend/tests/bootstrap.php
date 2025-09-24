<?php

/**
 * PHPUnit Test Bootstrap
 * Sets up the testing environment
 */

// Load Composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Load framework helpers
require_once __DIR__ . '/../core/helpers.php';

// Load environment variables for testing
use Framework\Env;
Env::load('.env');

// Load configuration
use Framework\Config;
Config::load(require __DIR__ . '/../config/app.php');

// Configure database for testing
use Framework\Database;
Database::configure(config('database'));

// Register migrations for testing
use Framework\MigrationRegistry;
require_once __DIR__ . '/../database/migrations/CreateUsersTable.php';
require_once __DIR__ . '/../database/migrations/CreateProductsTable.php';
MigrationRegistry::registerMigration('create_users_table', \Database\Migrations\CreateUsersTable::class);
MigrationRegistry::registerMigration('create_products_table', \Database\Migrations\CreateProductsTable::class);
MigrationRegistry::registerMigrationsWithRunner();

// Set up test environment
if (!defined('TESTING')) {
    define('TESTING', true);
}

// Start session for testing
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load the base TestCase
require_once __DIR__ . '/../core/TestCase.php';
