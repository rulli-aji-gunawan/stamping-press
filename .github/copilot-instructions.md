# Copilot Instructions for StampingPress (Laravel)

## Project Architecture
- **Monorepo Structure:**
  - Main app in root (`app/`, `routes/`, `config/`, etc.)
  - Secondary Laravel app in `stamping-press/` (mirrors main structure)
- **Domain Logic:**
  - Models in `app/Models/` (e.g., `TableProduction.php`, `User.php`)
  - Controllers in `app/Http/Controllers/`
  - Policies in `app/Policies/` (authorization logic)
  - Console commands in `app/Console/Commands/`
- **Exports/Imports:**
  - Custom export logic in `app/Exports/`
  - Stubs/templates for import/export in `stubs/`

## Data Flow & Integration
- **Database:**
  - Migrations in `database/migrations/`
  - Seeders in `database/seeders/`
  - Factories in `database/factories/`
- **External Services:**
  - Configured in `config/services.php`
  - Environment variables via `.env` (not in repo)

## Developer Workflows
- **Build:**
  - Frontend assets: `npm run build` (uses Vite or Webpack)
- **Test:**
  - Run tests: `php artisan test` or `vendor/bin/phpunit`
- **Debug:**
  - Use Laravel's built-in logging (`storage/logs/`)
  - Custom debug scripts in `public/test.php`
- **Database:**
  - Migrate: `php artisan migrate`
  - Seed: `php artisan db:seed`

## Conventions & Patterns
- **Naming:**
  - Models: singular (`User`, `TableProduction`)
  - Controllers: plural (`UsersController`)
- **Authorization:**
  - Policies for each model in `app/Policies/`
- **Exports/Imports:**
  - Use stubs in `stubs/` for code generation
- **Routes:**
  - API routes in `routes/api.php`
  - Web routes in `routes/web.php`
  - Console routes in `routes/console.php`

## Key Files & Directories
- `app/Models/`: Eloquent models
- `app/Http/Controllers/`: Request handling
- `app/Policies/`: Authorization
- `app/Exports/`: Data export logic
- `stubs/`: Code generation templates
- `public/test.php`: Debug entry point
- `config/`: App configuration
- `resources/views/`: Blade templates
- `routes/`: Route definitions

## Examples
- To add a new export type, create a stub in `stubs/` and an export class in `app/Exports/`.
- To add a new model, create it in `app/Models/`, add a migration, and update relevant policies/controllers.

---
For more details, see the main and `stamping-press/` `README.md` files.
