<?php

namespace Framework;

use Illuminate\Database\Migrations\Migration as BaseMigration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

abstract class Migration extends BaseMigration
{
    /**
     * Run the migrations.
     */
    abstract public function up(): void;

    /**
     * Reverse the migrations.
     */
    abstract public function down(): void;

    /**
     * Get the schema builder instance.
     */
    protected function schema()
    {
        return Capsule::schema();
    }

    /**
     * Create a new table.
     */
    protected function create(string $table, callable $callback): void
    {
        $this->schema()->create($table, $callback);
    }

    /**
     * Drop a table.
     */
    protected function drop(string $table): void
    {
        $this->schema()->dropIfExists($table);
    }

    /**
     * Modify an existing table.
     */
    protected function table(string $table, callable $callback): void
    {
        $this->schema()->table($table, $callback);
    }

    /**
     * Check if a table exists.
     */
    protected function hasTable(string $table): bool
    {
        return $this->schema()->hasTable($table);
    }

    /**
     * Check if a column exists.
     */
    protected function hasColumn(string $table, string $column): bool
    {
        return $this->schema()->hasColumn($table, $column);
    }
}
