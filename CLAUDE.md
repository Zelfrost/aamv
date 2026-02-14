# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

AAMV (Association des Assistantes Maternelles de Villeneuve d'Ascq) is a Symfony 3.x PHP web application for managing a childminders' association. It handles member registration, availability scheduling, classified ads, news, events, and tool/resource sharing.

## Development Commands

The project runs in Docker (MySQL 5.6, PHP 7.1, Nginx). All commands go through the Makefile:

```bash
make start          # Full bootstrap: containers + composer install + DB reload
make up             # Start Docker containers only
make install        # Run composer install in the PHP container
make reload-db      # Drop, recreate DB, load schema + fixtures
make update-db      # Apply schema changes (doctrine:schema:update --force)
make mysql          # Connect to MySQL CLI (root/root, database: aamv)
make logs           # Tail container logs
make exec           # Shell into PHP container (default: bash as www-data)
make exec cmd="bin/console <command>"  # Run a Symfony console command
```

**Running tests:**
```bash
make exec cmd="bin/phpunit -c app/phpunit.xml.dist"
# Single test file:
make exec cmd="bin/phpunit -c app/phpunit.xml.dist tests/AppBundle/Path/To/TestFile.php"
```

The app is served at `http://localhost:8081` when containers are running.

## Architecture

### Directory Structure

- `app/config/` — Symfony configuration (routing, security, services, parameters)
- `src/AppBundle/` — All application code (single-bundle structure)
- `tests/AppBundle/` — PHPUnit tests (mirrors src structure)
- `web/` — Web root (`app.php` production, `app_dev.php` development front controllers)
- `docker/` — Nginx and PHP OPcache configuration

### Source Code Organization (`src/AppBundle/`)

- `Controller/` — Request handlers with annotation-based `@Route` routing
  - `Admin/` — Admin-only controllers (behind `ROLE_ADMIN`)
  - `Api/` — API endpoints (e.g., `CitiesApiController`)
- `Entity/` — Doctrine ORM entities with annotation mappings
- `Repository/` — Custom Doctrine repositories (registered as services via factory pattern)
- `Form/Type/` — Symfony form types (registered as services with tags)
- `Service/` — Business logic organized by concern:
  - `Mailer/` — Email services (registration, forgot password)
  - `Validator/` — Custom constraint validators
  - `Retriever/` — Data retrieval helpers (cities, roles, publishable items)
  - `Converter/` — Data format converters
  - `PasswordEncoder/` — Legacy password encoding support
  - `EventListener/` — Kernel event listeners

### Domain Model

**Person** is the base entity (name, email, phone, city). **User** extends Person using Doctrine JOINED inheritance and implements Symfony's `UserInterface`.

Roles: `ROLE_PARENT`, `ROLE_ASSISTANT`, `ROLE_MEMBER`, `ROLE_TRAINEE`, `ROLE_ADMIN`. Admin inherits all other roles. Access control is path-based in `security.yml`.

Other entities: News, Ad, Tool, Event, EventPicture, Disponibility (availability slots), City, Category.

### Key Patterns

- **Service wiring**: Defined in `src/AppBundle/Resources/config/services.yml` — repositories use factory pattern on the entity manager, forms are tagged `form.type`, validators tagged `validator.constraint_validator`
- **Authentication**: Form login with email, bcrypt encoding + legacy password encoder with automatic migration via `LegacyAuthenticationListener`
- **Frontend**: Bootstrap 3, jQuery, CKEditor, Select2 — managed via Bower (`bower.json`), assets installed with `bin/console assets:install`
- **Templates**: Twig, organized in `src/AppBundle/Resources/views/` by section
