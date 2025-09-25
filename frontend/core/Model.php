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

    // Remove all method overrides that might conflict with Eloquent
    // Let Eloquent handle all the standard methods with their original signatures
    
    protected static function boot()
    {
        parent::boot();
        
        // Add any global model events here
    }
}