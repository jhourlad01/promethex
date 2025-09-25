# Projedee Framework Core

A custom lightweight PHP framework with essential features for building web applications, featuring integrated monitoring via DataDog AI and a flexible setup system.

## PHP Requirements

### Required PHP Version
- **PHP 7.4+** (minimum)
- **PHP 8.1+** (recommended for full Illuminate Database support)

### Required PHP Extensions

The framework requires the following PHP extensions to function properly:

#### Core Database Extensions
- **`pdo`** - Required by Illuminate Database (composer dependency)
- **`pdo_sqlite`** - For SQLite database support (testing and development)
- **`pdo_mysql`** - For MySQL database support (production)

#### Essential Framework Extensions
- **`json`** - For JSON handling (API responses, configuration files)
- **`mbstring`** - For multibyte string handling
- **`openssl`** - For encryption/security (JWT tokens, password hashing)
- **`session`** - For session management (authentication)
- **`filter`** - For input filtering and validation
- **`hash`** - For password hashing and security functions
- **`fileinfo`** - For file type detection
- **`xml`** - For XML processing
- **`zip`** - For archive handling
- **`curl`** - For HTTP requests (external APIs, DataDog)

#### Optional Extensions (Recommended)
- **`bcmath`** - For precise mathematical calculations
- **`dom`** - For XML/DOM processing
- **`exif`** - For image metadata handling
- **`ftp`** - For file transfer operations
- **`iconv`** - For character encoding conversion
- **`libxml`** - For XML processing
- **`SimpleXML`** - For XML parsing
- **`xmlreader`** - For XML reading
- **`xmlwriter`** - For XML writing
- **`zlib`** - For compression support

### Extension Verification

Check if all required extensions are installed:

```bash
# Check all PHP extensions
php -m

# Check specific extensions
php -r "echo extension_loaded('pdo') ? 'PDO: OK' : 'PDO: MISSING';"
php -r "echo extension_loaded('pdo_sqlite') ? 'PDO SQLite: OK' : 'PDO SQLite: MISSING';"
php -r "echo extension_loaded('pdo_mysql') ? 'PDO MySQL: OK' : 'PDO MySQL: MISSING';"

# Check PDO drivers
php -r "echo 'Available PDO drivers: ' . implode(', ', PDO::getAvailableDrivers());"
```

### Installation Notes

#### Windows (XAMPP/WAMP)
Most Windows PHP distributions (XAMPP, WAMP) include all required extensions by default.

#### Linux/Ubuntu/Debian
```bash
sudo apt update
sudo apt install php8.3-sqlite3 php8.3-mysql php8.3-mbstring php8.3-curl php8.3-zip php8.3-xml php8.3-bcmath
```

#### macOS (Homebrew)
```bash
brew install php
# Extensions are usually included by default
```

#### Docker
```dockerfile
FROM php:8.3-fpm
RUN docker-php-ext-install pdo pdo_mysql pdo_sqlite mbstring curl zip xml bcmath
```

## Flexible Feature System

The framework uses a flexible feature system that allows you to enable/disable features based on your needs. This keeps the framework lightweight while providing powerful optional capabilities.

### Feature Configuration

Configure features in `config/features.php`:

```php
return [
    'optional' => [
        'database' => true,        // Enable database features
        'validation' => true,      // Enable validation
        'logging' => true,         // Enable logging
        'auth' => true,            // Enable authentication
        'templates' => false,      // Disable templating
        'cache' => false,          // Disable caching
        'mail' => false,           // Disable email
    ]
];
```

### Feature Groups

Use predefined groups for common setups:

```php
// Enable minimal features
$app->configure(['features' => ['minimal']]);

// Enable API features
$app->configure(['features' => ['api']]);

// Enable web features  
$app->configure(['features' => ['web']]);

// Enable all features
$app->configure(['features' => ['full']]);
```

### Runtime Feature Control

```php
// Enable/disable features at runtime
$app->enableFeature('cache');
$app->disableFeature('mail');

// Check if feature is enabled
if ($app->hasFeature('database')) {
    // Use database features
}

// Get all enabled features
$features = $app->getEnabledFeatures();
```

## Core Components

### App (`App.php`)
Main application class that orchestrates the entire framework.

```php
use Framework\App;

$app = new App();
$app->get('/', function($request) {
    return new Framework\Response('Hello World!');
});
$app->run();
```

### Router (`Router.php`)
Advanced routing system with caching, middleware support, and route groups.

**Features:**
- HTTP method routing (GET, POST, PUT, DELETE)
- Parameter matching with `{param}` syntax
- Route caching for performance
- Middleware support per route and groups
- Route grouping with shared middleware

```php
// Basic routes
$router->get('/users', 'UserController@index');
$router->post('/users', 'UserController@store');

// Route groups with middleware
$router->group(['middleware' => [Middleware::auth()]], function($router) {
    $router->get('/profile', 'UserController@profile');
    $router->put('/profile', 'UserController@update');
});
```

### Request (`Request.php`)
Enhanced request handling with security features and input sanitization.

**Methods:**
- `getMethod()` - HTTP method
- `getPath()` - Request path
- `getJson()` - Parse JSON request body
- `getInput($key)` - Get GET/POST data
- `getSanitizedInput($key)` - Get sanitized input (XSS protection)
- `hasFile($key)` - Check for file uploads
- `isAjax()` - Check if AJAX request
- `wantsJson()` - Check if client expects JSON

```php
// Security features
$name = $request->getSanitizedInput('name'); // XSS protected
$isAjax = $request->isAjax();
$data = $request->getJson(); // Parse JSON body
```

### Response (`Response.php`)
Flexible response handling with JSON support and status codes.

```php
// Basic response
return new Response('Hello World!');

// JSON response
return (new Response())->json(['message' => 'Success']);

// With status code
return (new Response())->json(['error' => 'Not found'], 404);
```

### Validator (`Validator.php`)
Comprehensive validation system with custom rules and error messages.

**Built-in Rules:**
- `required` - Field is required
- `email` - Valid email format
- `min:X` - Minimum length/value
- `max:X` - Maximum length/value
- `numeric` - Must be numeric
- `string` - Must be string
- `confirmed` - Must match confirmation field

```php
$validator = Validator::make($data, [
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users',
    'password' => 'required|min:6|confirmed'
]);

if ($validator->fails()) {
    $errors = $validator->errors();
}
```

### Auth (`Auth.php`)
Session-based authentication system with middleware support.

```php
// Login attempt
if (Auth::attempt(['email' => $email, 'password' => $password])) {
    // User authenticated
}

// Check authentication
if (Auth::check()) {
    $user = Auth::user();
    $userId = Auth::id();
}

// Logout
Auth::logout();
```

### Database (`Database.php`)
PDO-based database abstraction with caching and transaction support.

**Features:**
- Connection pooling
- Query caching
- Transaction support
- Prepared statements
- Multiple database support (SQLite, MySQL)

```php
// Configure database
Database::configure([
    'driver' => 'sqlite',
    'database' => 'app.sqlite'
]);

// Query operations
$users = Database::select('SELECT * FROM users WHERE active = ?', [1]);
$user = Database::selectOne('SELECT * FROM users WHERE id = ?', [$id]);

// Insert/Update/Delete
$id = Database::insert('users', ['name' => 'John', 'email' => 'john@example.com']);
Database::update('users', ['name' => 'Jane'], 'id = ?', [$id]);
Database::delete('users', 'id = ?', [$id]);

// Transactions
Database::transaction(function() {
    Database::insert('users', ['name' => 'John']);
    Database::insert('profiles', ['user_id' => 1]);
});
```

### Middleware (`Middleware.php`)
Pre-built middleware for common functionality.

**Available Middleware:**
- `cors()` - Cross-origin request handling
- `json()` - JSON content-type headers
- `rateLimit($max, $minutes)` - Rate limiting
- `auth()` - Authentication required
- `guest()` - Guest users only

```php
// Apply middleware to routes
$app->middleware([Middleware::cors(), Middleware::json()]);

// Rate limiting
$app->get('/api/data', function($request) {
    // Handle request
})->middleware([Middleware::rateLimit(10, 1)]); // 10 requests per minute
```

### Logger (`Logger.php`)
Structured logging system with multiple levels.

**Log Levels:**
- `debug` - Debug information
- `info` - General information
- `warning` - Warning messages
- `error` - Error messages
- `critical` - Critical errors

```php
// Configure logging
Logger::configure('/path/to/logs/app.log', 'info');

// Log messages
Logger::info('User logged in', ['user_id' => 1]);
Logger::error('Database error', ['error' => $exception->getMessage()]);
```

### DataDog (`DataDog.php`)
Integrated DataDog monitoring with metrics, events, and logs.

**Features:**
- Automatic request tracking
- Database query monitoring
- Error tracking and events
- Custom metrics and logging
- APM integration
- Environment-based configuration

```php
// Configure DataDog
DataDog::configure();

// Track custom metrics
DataDog::track('user.registrations', 1, ['source' => 'web']);

// Log events
DataDog::event('User Login', 'User successfully logged in', ['user_id' => 123]);

// Track application logs
DataDog::log('Payment processed', 'info', ['amount' => 99.99]);

// Automatic tracking (built-in)
// - Request duration and status codes
// - Database query performance
// - Framework errors and exceptions
```

**Environment Configuration:**
```bash
DATADOG_ENABLED=1
DD_API_KEY=your_api_key
DD_SITE=us5.datadoghq.com
DD_ENV=dev
DD_APM_INSTRUMENTATION_ENABLED=host
DD_PROFILING_ENABLED=auto
DD_DATA_STREAMS_ENABLED=true
```

### ExceptionHandler (`ExceptionHandler.php`)
Comprehensive error handling with debug/production modes.

```php
// Register exception handler
ExceptionHandler::register($debugMode);

// Automatic error handling for:
// - Uncaught exceptions
// - PHP errors
// - Fatal errors
```

### Config (`Config.php`)
Environment-based configuration management.

```php
// Load configuration
Config::load(require 'config/app.php');

// Get configuration values
$debug = Config::get('debug', false);
$dbHost = Config::get('database.host', 'localhost');

// Set configuration
Config::set('app.name', 'My App');
```

## Performance Features

### Route Caching
Routes are automatically cached after first match for improved performance.

### Database Optimization
- Persistent connections
- Query caching for SELECT operations
- Native prepared statements
- Connection pooling

### Memory Management
- Efficient array operations
- Smart cache invalidation
- Optimized regex compilation

## Security Features

### Input Sanitization
- XSS protection with `htmlspecialchars()`
- Input trimming and validation
- File upload security

### Authentication
- Session-based authentication
- Secure password handling
- Middleware protection

### Error Handling
- Sanitized error messages in production
- Debug information in development
- Structured error logging

## Setup and Installation

### Interactive Setup Wizard (`core/scripts/setup.php`)

The framework includes an automated setup wizard that guides you through initial configuration:

```bash
composer install  # Automatically runs setup wizard
```

**Setup includes:**
- Application name and URL configuration
- Database connection setup
- DataDog monitoring configuration
- Feature selection and enabling
- Environment file creation

### DataDog Installation Script (`core/scripts/install-datadog.php`)

Comprehensive DataDog setup with agent and library installation:

```bash
composer datadog  # Run DataDog installation
```

**Installation includes:**
- DataDog Agent installation (system monitoring)
- PHP DataDog library installation (application monitoring)
- Agent configuration with API key
- Service startup and verification
- Connection testing

### Manual Setup

If you prefer manual setup:

1. Copy `env.example` to `.env`
2. Configure your environment variables
3. Run `composer install` to install dependencies
4. Use `composer datadog` to set up monitoring (optional)

## Architecture

The framework follows a clean, layered architecture:

```
Request → Router → Middleware → Controller → Response
    ↓
Database ← Config ← Logger ← DataDog
    ↓
ExceptionHandler
```

Each component is designed to be:
- **Lightweight**: Minimal overhead
- **Flexible**: Easy to extend and customize
- **Secure**: Built-in security features
- **Performant**: Optimized for speed and memory usage
- **Observable**: Integrated monitoring and logging
