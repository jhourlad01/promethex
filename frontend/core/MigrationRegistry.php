<?php

namespace Framework;

class MigrationRegistry
{
    private static array $migrations = [];
    private static array $seeders = [];

    /**
     * Register a migration
     */
    public static function registerMigration(string $name, string $class): void
    {
        self::$migrations[$name] = $class;
    }

    /**
     * Register a seeder
     */
    public static function registerSeeder(string $name, string $class): void
    {
        self::$seeders[$name] = $class;
    }

    /**
     * Get all registered migrations
     */
    public static function getMigrations(): array
    {
        return self::$migrations;
    }

    /**
     * Get all registered seeders
     */
    public static function getSeeders(): array
    {
        return self::$seeders;
    }

    /**
     * Register migrations with MigrationRunner
     */
    public static function registerMigrationsWithRunner(): void
    {
        foreach (self::$migrations as $name => $class) {
            MigrationRunner::register($name, $class);
        }
    }

    /**
     * Register seeders with SeederRunner
     */
    public static function registerSeedersWithRunner(): void
    {
        foreach (self::$seeders as $name => $class) {
            SeederRunner::register($name, $class);
        }
    }

    /**
     * Clear all registrations
     */
    public static function clear(): void
    {
        self::$migrations = [];
        self::$seeders = [];
    }
}
