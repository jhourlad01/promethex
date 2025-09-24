<?php

namespace Framework;

use Illuminate\Database\Capsule\Manager as Capsule;

class MigrationRunner
{
    private static array $migrations = [];
    private static string $migrationsTable = 'migrations';

    /**
     * Register a migration.
     */
    public static function register(string $name, string $class): void
    {
        self::$migrations[$name] = $class;
    }

    /**
     * Run all pending migrations.
     */
    public static function run(): void
    {
        self::createMigrationsTable();
        
        $ranMigrations = self::getRanMigrations();
        
        foreach (self::$migrations as $name => $class) {
            if (!in_array($name, $ranMigrations)) {
                self::runMigration($name, $class);
            }
        }
    }

    /**
     * Rollback the last batch of migrations.
     */
    public static function rollback(): void
    {
        $lastBatch = self::getLastBatch();
        
        if ($lastBatch) {
            $migrations = self::getMigrationsByBatch($lastBatch);
            
            foreach (array_reverse($migrations) as $migration) {
                self::rollbackMigration($migration['migration'], $migration['class']);
            }
        }
    }

    /**
     * Create the migrations table.
     */
    private static function createMigrationsTable(): void
    {
        if (!Capsule::schema()->hasTable(self::$migrationsTable)) {
            Capsule::schema()->create(self::$migrationsTable, function ($table) {
                $table->increments('id');
                $table->string('migration');
                $table->integer('batch');
            });
        }
    }

    /**
     * Run a single migration.
     */
    private static function runMigration(string $name, string $class): void
    {
        echo "Running migration: {$name}\n";
        
        $migration = new $class();
        $migration->up();
        
        $batch = self::getNextBatchNumber();
        Capsule::table(self::$migrationsTable)->insert([
            'migration' => $name,
            'batch' => $batch
        ]);
        
        echo "Migration {$name} completed\n";
    }

    /**
     * Rollback a single migration.
     */
    private static function rollbackMigration(string $name, string $class): void
    {
        echo "Rolling back migration: {$name}\n";
        
        $migration = new $class();
        $migration->down();
        
        Capsule::table(self::$migrationsTable)
            ->where('migration', $name)
            ->delete();
        
        echo "Migration {$name} rolled back\n";
    }

    /**
     * Get migrations that have been run.
     */
    private static function getRanMigrations(): array
    {
        return Capsule::table(self::$migrationsTable)
            ->pluck('migration')
            ->toArray();
    }

    /**
     * Get the last batch number.
     */
    private static function getLastBatch(): ?int
    {
        return Capsule::table(self::$migrationsTable)
            ->max('batch');
    }

    /**
     * Get migrations by batch number.
     */
    private static function getMigrationsByBatch(int $batch): array
    {
        return Capsule::table(self::$migrationsTable)
            ->where('batch', $batch)
            ->get()
            ->map(function ($migration) {
                return [
                    'migration' => $migration->migration,
                    'class' => self::$migrations[$migration->migration] ?? null
                ];
            })
            ->filter(function ($migration) {
                return $migration['class'] !== null;
            })
            ->toArray();
    }

    /**
     * Get the next batch number.
     */
    private static function getNextBatchNumber(): int
    {
        $lastBatch = self::getLastBatch();
        return $lastBatch ? $lastBatch + 1 : 1;
    }

    /**
     * Get migration status.
     */
    public static function status(): void
    {
        echo "Migration Status:\n";
        echo "================\n";
        
        $ranMigrations = self::getRanMigrations();
        
        foreach (self::$migrations as $name => $class) {
            $status = in_array($name, $ranMigrations) ? '✓' : '✗';
            echo "{$status} {$name}\n";
        }
    }
}
