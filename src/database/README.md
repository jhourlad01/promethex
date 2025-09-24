# Database Migration System

The migration system has been refactored with clean separation of concerns.

## Architecture

### Core Framework (`core/`)
- **`MigrationCommand.php`** - Handles all migration/seeder commands and bootstrap
- **`MigrationRegistry.php`** - Manages registration of migrations and seeders
- **`MigrationRunner.php`** - Executes migrations
- **`SeederRunner.php`** - Executes seeders

### Application (`src/database/`)
- **`migrate.php`** - Clean registration-only script (29 lines)

## Usage

### Available Commands

```bash
# Migration commands
composer migrate              # Run all pending migrations
composer migrate:rollback     # Rollback last batch of migrations
composer migrate:status       # Show migration status

# Seeder commands
composer seed                 # Run all seeders
composer seed:user            # Run user seeder only
composer seed:product         # Run product seeder only
composer seed:fresh           # Run fresh seeders (truncate tables first)
composer seed:status          # Show seeder status
composer seed:reset           # Reset seeder tracking

# Combined commands
composer fresh                # Run migrations and fresh seeders
```

### Adding New Migrations/Seeders

1. **Create migration file** in `database/migrations/`
2. **Create seeder file** in `database/seeders/`
3. **Register in** `src/database/migrate.php`:

```php
// Register migrations
require_once __DIR__ . '/../../database/migrations/YourMigration.php';
MigrationRegistry::registerMigration('your_migration_name', \Database\Migrations\YourMigration::class);

// Register seeders
require_once __DIR__ . '/../../database/seeders/YourSeeder.php';
MigrationRegistry::registerSeeder('your_seeder_name', \Database\Seeders\YourSeeder::class);
```

4. **Add composer script** (optional):

```json
"seed:your-seeder": "php src/database/migrate.php seed:your-seeder"
```

## Benefits of Clean Structure

1. **🎯 Single Responsibility** - `migrate.php` only handles registration
2. **🔧 Framework Bootstrap** - All setup logic moved to core framework
3. **📦 Minimal Application Code** - Only 29 lines in application script
4. **♻️ Reusable Core** - Framework classes handle all complexity
5. **🛠️ Easy Maintenance** - Clear separation makes changes simple
6. **📁 Clean Architecture** - Application code is minimal and focused

## File Structure

```
core/
├── MigrationCommand.php      # Command handler + bootstrap
├── MigrationRegistry.php     # Registration manager
├── MigrationRunner.php       # Migration execution
└── SeederRunner.php         # Seeder execution

src/database/
├── migrate.php              # Registration-only script (29 lines)
└── README.md               # This documentation

database/
├── migrations/              # Migration files
└── seeders/               # Seeder files
```

## Migration Files

- **Location**: `database/migrations/`
- **Naming**: `CreateTableNameTable.php`
- **Class**: `class CreateTableNameTable extends Migration`

## Seeder Files

- **Location**: `database/seeders/`
- **Naming**: `TableNameSeeder.php`
- **Class**: `class TableNameSeeder extends Seeder`
