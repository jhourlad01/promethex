<?php

namespace Framework;

use Illuminate\Database\Seeder as BaseSeeder;
use Illuminate\Database\Capsule\Manager as Capsule;

abstract class Seeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     */
    abstract public function run(): void;

    /**
     * Get the database connection.
     */
    protected function db()
    {
        return Capsule::connection();
    }

    /**
     * Insert data into a table.
     */
    protected function insert(string $table, array $data): int
    {
        return Capsule::table($table)->insertGetId($data);
    }

    /**
     * Insert multiple records into a table.
     */
    protected function insertMany(string $table, array $data): void
    {
        Capsule::table($table)->insert($data);
    }

    /**
     * Update records in a table.
     */
    protected function update(string $table, array $data, string $where, array $whereParams = []): int
    {
        return Capsule::table($table)->whereRaw($where, $whereParams)->update($data);
    }

    /**
     * Delete records from a table.
     */
    protected function delete(string $table, string $where, array $whereParams = []): int
    {
        return Capsule::table($table)->whereRaw($where, $whereParams)->delete();
    }

    /**
     * Truncate a table.
     */
    protected function truncate(string $table): void
    {
        Capsule::table($table)->truncate();
    }

    /**
     * Run another seeder.
     */
    public function call($class, $silent = false, array $parameters = []): void
    {
        $seederClass = new $class();
        $seederClass->run();
    }

    /**
     * Run multiple seeders.
     */
    protected function callMany(array $seeders): void
    {
        foreach ($seeders as $seeder) {
            $this->call($seeder);
        }
    }

    /**
     * Get a query builder for a table.
     */
    protected function table(string $table)
    {
        return Capsule::table($table);
    }

    /**
     * Execute raw SQL.
     */
    protected function query(string $sql, array $params = []): \PDOStatement
    {
        return Capsule::getConnection()->getPdo()->prepare($sql);
    }

    /**
     * Run a database transaction.
     */
    protected function transaction(callable $callback): mixed
    {
        return Capsule::connection()->transaction($callback);
    }
}
