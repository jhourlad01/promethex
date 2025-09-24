<?php

namespace Framework;

use Illuminate\Database\Eloquent\Model as EloquentModel;

abstract class Model extends EloquentModel
{
    protected $connection = 'default';

    public function __construct(array $attributes = [])
    {
        $app = app();
        if (!$app || !$app->hasFeature('database')) {
            throw new \RuntimeException('Database feature is not enabled');
        }

        parent::__construct($attributes);
    }

    public static function find($id)
    {
        return static::where('id', $id)->first();
    }

    public static function all()
    {
        return static::get();
    }

    public static function create(array $attributes)
    {
        return static::query()->create($attributes);
    }

    public function update(array $attributes = [])
    {
        return parent::update($attributes);
    }

    public function delete()
    {
        return parent::delete();
    }

    public function save(array $options = [])
    {
        return parent::save($options);
    }

    protected static function boot()
    {
        parent::boot();
        
        // Add any global model events here
    }
}
