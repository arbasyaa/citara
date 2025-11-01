<!--
Guidance file for AI coding agents working on this repository.
Keep this file short and prescriptive. Reference key files and workflows.
<!--
Short guidance for AI coding agents working on citara-dev.
Keep edits small, low-risk and consistent with existing patterns.
-->

# Copilot / AI agent instructions for citara-dev

This repository is a Laravel 12 application (PHP 8.2) using Vite + Tailwind for the frontend.
The app contains a public site and two admin surfaces: a full `/admin` (guarded by Laravel Auth) and a lightweight `/panel` (session/password-based).

Key facts (quick)
- Laravel 12, PHP ^8.2 (see `composer.json`).
- Frontend: Vite + Tailwind (see `package.json`).
- DB: supports sqlite (default config) but `.env` in repo uses MySQL (`DB_CONNECTION=mysql`).

Where to look first
- Routes: `routes/web.php` (notice `/admin` vs `/panel` and `wilayah` routes).
- Main models: `app/Models` (models often set `protected $table` to singular names).
- Public controllers: `app/Http/Controllers/Public/*` (homepage logic in `HomeController@index`).
- Admin panel: `app/Http/Controllers/Admin/*` and `app/Http/Controllers/AdminController.php` (panel actions live here).

Project-specific conventions
- Table naming: models commonly use singular table names (e.g., `Wilayah` => `protected $table = 'wilayah'`). Use the model's `$table` instead of assuming Eloquent pluralization.
- Slug generation: several models implement slug creation in `booted()` (see `app/Models/Wilayah.php` and `app/Models/Destinasi.php`). Preserve this pattern when adding similar models.
- Dual admin surfaces: do not replace `/panel` with `/admin` logic. The `/panel` routes use `App\Http\Middleware\AdminAuth` and a password from `.env`.
- Defensive checks: controllers may call `Schema::hasTable(...)` and return empty paginators if migrations aren't run. Keep those guards.
- File uploads: controllers store images using the `public` disk and `uploads` path (e.g., `$request->file('image')->store('uploads', 'public')`). Reuse that disk/path.
- Localization: this app uses Laravel's native localization (no packages). All UI strings use `__('site.key')` helper. Translation files are in `resources/lang/en/site.php` and `resources/lang/id/site.php`. Default locale is Indonesian (`APP_LOCALE=id`). Language switching via `/lang/{locale}` route + `SetLocale` middleware. See `docs/LOCALIZATION.md` for full guide.

Developer workflows (commands)
- Install and setup (creates .env, migrates, builds assets):
	composer run-script setup
- Dev (server, queue listener, pail, vite):
	composer run-script dev
- Run tests:
	composer test
- Clear caches (useful when debugging missing data on views):
	php artisan cache:clear
	php artisan config:clear
	php artisan view:clear
	php artisan route:clear

Common pitfalls & debugging tips
- Missing records on homepage: check `HomeController@index` — the code filters wilayah with `withCount('destinasi')->having('destinasi_count', '>', 0)`. If new wilayah have zero destinasi they won't appear.
- Table mismatch: always verify `protected $table` in models. Eloquent pluralization is NOT relied on here.
- Slug collisions: slug logic in `booted()` checks for existing slugs using `self::where('slug', $slug)->exists()` — follow the same approach if adding slugs.
- Caching and config: after changing `.env` or config, run `php artisan config:clear` and `php artisan cache:clear`.

Quick safety checklist before PR
1. Preserve existing routes, method signatures, and middleware.
2. Keep controller defensive Schema checks.
3. When adding DB changes, include reversible migrations and update model `$fillable`.
4. Run `composer test` and `npm run build` if you modify PHP or frontend assets.

Reference files to cite in PRs or comments
- `routes/web.php` (route splits)
- `app/Models/Wilayah.php` (slug + table naming example)
- `app/Http/Controllers/Public/HomeController.php` (how homepage collects wilayah/destinasi)
- `composer.json` scripts (setup/dev/test flows)

If anything is unclear, ask the repo owner which DB to target (sqlite or MySQL) and whether to run migrations automatically in CI.

End of guidance.
