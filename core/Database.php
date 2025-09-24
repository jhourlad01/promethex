<?php

namespace Framework;

use Illuminate\Database\Capsule\Manager as Capsule;

class Database
{
    private static bool $initialized = false;
    private static array $queryCache = [];

    public static function configure(array $config): void
    {
        if (self::$initialized) {
            return;
        }

        $capsule = new Capsule;
        
        $capsule->addConnection([
            'driver' => $config['driver'] ?? 'sqlite',
            'host' => $config['host'] ?? 'localhost',
            'database' => $config['database'] ?? ':memory:',
            'username' => $config['username'] ?? '',
            'password' => $config['password'] ?? '',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        
        self::$initialized = true;
    }

    public static function select(string $sql, array $params = []): array
    {
        $cacheKey = md5($sql . serialize($params));
        
        if (isset(self::$queryCache[$cacheKey])) {
            return self::$queryCache[$cacheKey];
        }
        
        $result = Capsule::select($sql, $params);
        
        if (count($result) < 100) {
            self::$queryCache[$cacheKey] = $result;
        }
        
        return $result;
    }

    public static function selectOne(string $sql, array $params = []): ?array
    {
        $cacheKey = md5($sql . serialize($params));
        
        if (isset(self::$queryCache[$cacheKey])) {
            return self::$queryCache[$cacheKey][0] ?? null;
        }
        
        $result = Capsule::select($sql, $params);
        $data = $result[0] ?? null;
        
        if ($data !== null) {
            self::$queryCache[$cacheKey] = [$data];
        }
        
        return $data;
    }

    public static function insert(string $table, array $data): int
    {
        $id = Capsule::table($table)->insertGetId($data);
        self::clearCache();
        return (int) $id;
    }

    public static function update(string $table, array $data, string $where, array $whereParams = []): int
    {
        $result = Capsule::table($table)->whereRaw($where, $whereParams)->update($data);
        self::clearCache();
        return $result;
    }

    public static function delete(string $table, string $where, array $whereParams = []): int
    {
        $result = Capsule::table($table)->whereRaw($where, $whereParams)->delete();
        self::clearCache();
        return $result;
    }

    public static function query(string $sql, array $params = []): \PDOStatement
    {
        return Capsule::getConnection()->getPdo()->prepare($sql);
    }

    public static function clearCache(): void
    {
        self::$queryCache = [];
    }

    public static function transaction(callable $callback): mixed
    {
        return Capsule::connection()->transaction($callback);
    }

    // Eloquent ORM integration
    public static function model(string $model): \Illuminate\Database\Eloquent\Model
    {
        return new $model;
    }

    public static function table(string $table): \Illuminate\Database\Query\Builder
    {
        return Capsule::table($table);
    }
}
