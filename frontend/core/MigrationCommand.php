<?php

namespace Framework;

use Illuminate\Database\Capsule\Manager as Capsule;

class MigrationCommand
{
    private MigrationRunner $migrationRunner;
    private SeederRunner $seederRunner;

    public function __construct()
    {
        $this->migrationRunner = new MigrationRunner();
        $this->seederRunner = new SeederRunner();
    }

    /**
     * Run all pending migrations
     */
    public function migrate(): void
    {
        echo "Running migrations...\n";
        $this->migrationRunner->run();
    }

    /**
     * Rollback the last batch of migrations
     */
    public function rollback(): void
    {
        echo "Rolling back migrations...\n";
        $this->migrationRunner->rollback();
    }

    /**
     * Show migration status
     */
    public function migrateStatus(): void
    {
        $this->migrationRunner->status();
    }

    /**
     * Run all seeders
     */
    public function seed(): void
    {
        echo "Running seeders...\n";
        $this->seederRunner->run();
    }

    /**
     * Run a specific seeder
     */
    public function seedSpecific(string $seederName): void
    {
        echo "Running {$seederName} seeder...\n";
        $this->seederRunner->runSpecificSeeder($seederName);
    }

    /**
     * Run fresh seeders (truncate tables first)
     */
    public function seedFresh(): void
    {
        echo "Running fresh seeders...\n";
        $this->seederRunner->fresh();
    }

    /**
     * Show seeder status
     */
    public function seedStatus(): void
    {
        $this->seederRunner->status();
    }

    /**
     * Reset seeder tracking
     */
    public function seedReset(): void
    {
        echo "Resetting seeder tracking...\n";
        $this->seederRunner->reset();
    }

    /**
     * Refresh migrations and seeders (rollback + migrate + fresh seed)
     */
    public function migrateRefresh(): void
    {
        echo "Refreshing migrations and seeders...\n";
        $this->migrationRunner->rollback();
        $this->migrationRunner->run();
        $this->seederRunner->fresh();
    }

    /**
     * Show help information
     */
    public function help(): void
    {
        echo "Available commands:\n";
        echo "==================\n";
        echo "migrate          - Run all pending migrations\n";
        echo "rollback         - Rollback the last batch of migrations\n";
        echo "migrate:status   - Show migration status\n";
        echo "migrate:refresh  - Rollback + migrate + fresh seeders\n";
        echo "seed             - Run all seeders\n";
        echo "seed:fresh       - Run fresh seeders (truncate tables first)\n";
        echo "seed:status      - Show seeder status\n";
        echo "seed:reset       - Reset seeder tracking\n";
        echo "fresh            - Run migrations and fresh seeders\n";
        echo "help             - Show this help message\n";
    }

    /**
     * Bootstrap the migration system
     */
    public function bootstrap(): void
    {
        // Load environment variables
        Env::load('.env');

        // Load configuration
        Config::load(require __DIR__ . '/../config/app.php');

        // Configure database
        Database::configure(config('database'));
    }

    /**
     * Register migrations and seeders with runners
     */
    public function registerWithRunners(): void
    {
        MigrationRegistry::registerMigrationsWithRunner();
        MigrationRegistry::registerSeedersWithRunner();
    }
    public function execute(array $argv): void
    {
        $command = $argv[1] ?? 'help';

        // Handle specific seeder commands
        if (strpos($command, 'seed:') === 0) {
            $seederName = substr($command, 5); // Remove 'seed:' prefix
            
            // Handle special seeder commands first
            switch ($seederName) {
                case 'fresh':
                    $this->seedFresh();
                    return;
                case 'status':
                    $this->seedStatus();
                    return;
                case 'reset':
                    $this->seedReset();
                    return;
            }
            
            if ($seederName) {
                // Map short names to full seeder names
                $seederMap = [
                    'user' => 'user_seeder',
                    'product' => 'product_seeder',
                    'database' => 'database_seeder'
                ];
                
                $fullSeederName = $seederMap[$seederName] ?? $seederName;
                $this->seedSpecific($fullSeederName);
                return;
            }
        }

        switch ($command) {
            case 'migrate':
                $this->migrate();
                break;
                
            case 'rollback':
                $this->rollback();
                break;
                
            case 'migrate:status':
                $this->migrateStatus();
                break;
                
            case 'seed':
                $this->seed();
                break;
                
            case 'seed:fresh':
                $this->seedFresh();
                break;
                
            case 'seed:status':
                $this->seedStatus();
                break;
                
            case 'seed:reset':
                $this->seedReset();
                break;
                
            case 'migrate:refresh':
                $this->migrateRefresh();
                break;
                
            case 'fresh':
                $this->fresh();
                break;
                
            case 'help':
            default:
                $this->help();
                break;
        }
    }
}
