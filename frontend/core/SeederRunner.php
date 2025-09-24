<?php

namespace Framework;

use Illuminate\Database\Capsule\Manager as Capsule;

class SeederRunner
{
    private static array $seeders = [];
    private static string $seedersTable = 'seeders';

    /**
     * Register a seeder.
     */
    public static function register(string $name, string $class): void
    {
        self::$seeders[$name] = $class;
    }

    /**
     * Run all seeders.
     */
    public static function run(): void
    {
        self::createSeedersTable();
        
        foreach (self::$seeders as $name => $class) {
            self::runSeeder($name, $class);
        }
    }

    /**
     * Run a specific seeder.
     */
    public static function runSpecificSeeder(string $name): void
    {
        if (!isset(self::$seeders[$name])) {
            throw new \Exception("Seeder '{$name}' not found");
        }
        
        self::createSeedersTable();
        self::runSeeder($name, self::$seeders[$name]);
    }

    /**
     * Run seeders with fresh data (truncate tables first).
     */
    public static function fresh(): void
    {
        self::createSeedersTable();
        
        // Clear seeders table
        Capsule::table(self::$seedersTable)->truncate();
        
        foreach (self::$seeders as $name => $class) {
            self::runSeeder($name, $class);
        }
    }

    /**
     * Create the seeders table.
     */
    private static function createSeedersTable(): void
    {
        if (!Capsule::schema()->hasTable(self::$seedersTable)) {
            Capsule::schema()->create(self::$seedersTable, function ($table) {
                $table->increments('id');
                $table->string('seeder');
                $table->timestamp('run_at');
            });
        }
    }

    /**
     * Run a single seeder.
     */
    private static function runSeeder(string $name, string $class): void
    {
        // Check if seeder has already been run
        $alreadyRun = Capsule::table(self::$seedersTable)
            ->where('seeder', $name)
            ->exists();
        
        if ($alreadyRun) {
            echo "Seeder {$name} already run, skipping...\n";
            return;
        }
        
        echo "Running seeder: {$name}\n";
        
        $seeder = new $class();
        $seeder->run();
        
        Capsule::table(self::$seedersTable)->insert([
            'seeder' => $name,
            'run_at' => date('Y-m-d H:i:s')
        ]);
        
        echo "Seeder {$name} completed\n";
    }

    /**
     * Get seeder status.
     */
    public static function status(): void
    {
        echo "Seeder Status:\n";
        echo "==============\n";
        
        $runSeeders = Capsule::table(self::$seedersTable)
            ->pluck('seeder')
            ->toArray();
        
        foreach (self::$seeders as $name => $class) {
            $status = in_array($name, $runSeeders) ? '✓' : '✗';
            echo "{$status} {$name}\n";
        }
    }

    /**
     * Reset all seeders (mark as not run).
     */
    public static function reset(): void
    {
        Capsule::table(self::$seedersTable)->truncate();
        echo "All seeders reset\n";
    }
}
