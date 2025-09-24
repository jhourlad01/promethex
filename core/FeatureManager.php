<?php

namespace Framework;

class FeatureManager
{
    private static array $features = [];
    private static array $dependencies = [];
    private static bool $initialized = false;

    public static function register(string $name, string $class, array $dependencies = []): void
    {
        self::$features[$name] = [
            'class' => $class,
            'enabled' => false,
            'dependencies' => $dependencies
        ];
        self::$dependencies[$name] = $dependencies;
    }

    public static function enable(string $name): void
    {
        if (!isset(self::$features[$name])) {
            throw new \InvalidArgumentException("Feature '{$name}' is not registered");
        }

        // Check dependencies
        foreach (self::$dependencies[$name] as $dependency) {
            if (!self::isEnabled($dependency)) {
                throw new \RuntimeException("Feature '{$name}' requires '{$dependency}' to be enabled first");
            }
        }

        self::$features[$name]['enabled'] = true;
    }

    public static function disable(string $name): void
    {
        if (isset(self::$features[$name])) {
            self::$features[$name]['enabled'] = false;
        }
    }

    public static function isEnabled(string $name): bool
    {
        return self::$features[$name]['enabled'] ?? false;
    }

    public static function getEnabledFeatures(): array
    {
        return array_filter(self::$features, fn($feature) => $feature['enabled']);
    }

    public static function initialize(array $enabledFeatures = []): void
    {
        if (self::$initialized) {
            return;
        }

        // Register core features
        self::registerCoreFeatures();

        // Enable requested features
        foreach ($enabledFeatures as $feature) {
            self::enable($feature);
        }

        self::$initialized = true;
    }

    private static function registerCoreFeatures(): void
    {
        // Database features
        self::register('database', 'Framework\\Database');
        self::register('eloquent', 'Framework\\Database', ['database']);
        
        // Validation features
        self::register('validation', 'Framework\\Validator');
        self::register('respect_validation', 'Framework\\Validator');
        
        // Logging features
        self::register('logging', 'Framework\\Logger');
        self::register('monolog', 'Framework\\Logger');
        
        // Authentication features
        self::register('auth', 'Framework\\Auth');
        self::register('jwt_auth', 'Framework\\Auth', ['auth']);
        
        // Caching features
        self::register('cache', 'Framework\\Cache');
        self::register('symfony_cache', 'Framework\\Cache');
        
        // Templating features (using existing View class)
        self::register('templates', 'Framework\\View');
        self::register('twig', 'Framework\\View');
        
        // File handling features (disabled until implemented)
        // self::register('files', 'Framework\\FileManager');
        // self::register('flysystem', 'Framework\\FileManager');
        
        // Email features (disabled until implemented)
        // self::register('mail', 'Framework\\Mailer');
        // self::register('phpmailer', 'Framework\\Mailer');
        
        // API features
        self::register('api', 'Framework\\ApiResponse');
        self::register('fractal', 'Framework\\ApiResponse', ['api']);
        
        // Session features
        self::register('session', 'Framework\\Session');
        
        // Middleware features
        self::register('middleware', 'Framework\\Middleware');
        self::register('cors', 'Framework\\Middleware');
        self::register('rate_limiting', 'Framework\\Middleware');
    }

    public static function getFeatureClass(string $name): ?string
    {
        return self::$features[$name]['class'] ?? null;
    }

    public static function getFeatureDependencies(string $name): array
    {
        return self::$dependencies[$name] ?? [];
    }

    public static function getAllFeatures(): array
    {
        return self::$features;
    }

    public static function reset(): void
    {
        self::$features = [];
        self::$dependencies = [];
        self::$initialized = false;
    }
}
