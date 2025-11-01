# Single Language Content Migration

## Overview
This document tracks the migration from bilingual database content (Indonesian + English columns) to single-language content (Indonesian only) while maintaining Laravel's translation system for UI elements.

## Rationale
- Admin panel is Indonesian-only for internal staff
- Database content (descriptions) can remain in Indonesian
- Laravel translation system handles UI text (buttons, labels, menus)
- Simplifies CRUD operations - only need one description field
- Common pattern for tourism sites - content in local language, UI translated

## Changes Made

### 1. Database Schema
**Migration:** `2025_10_27_000001_remove_english_content_columns.php`

Dropped the following columns:
- `destinasi.deskripsi_en`
- `wilayah.deskripsi_en`
- `akomodasi.deskripsi_en`
- `transportasi.deskripsi_en`

**Status:** ✅ Ran successfully (2025-01-XX)

### 2. Model Updates

#### Destinasi Model (`app/Models/Destinasi.php`)
- Removed `deskripsi_en` from `$fillable` array
- Removed `getTranslatedDescription()` method

#### Wilayah Model (`app/Models/Wilayah.php`)
- Removed `deskripsi_en` from `$fillable` array
- Removed `getTranslatedDescription()` method

#### Akomodasi Model (`app/Models/Akomodasi.php`)
- Removed `deskripsi_en` from `$fillable` array
- Removed `getTranslatedDescription()` method

#### Transportasi Model (`app/Models/Transportasi.php`)
- Removed `deskripsi_en` from `$fillable` array
- Removed `getTranslatedDescription()` method

### 3. View Updates

Updated all views to access `deskripsi` directly instead of `getTranslatedDescription()`:

**Files modified:**
- `resources/views/public/home.blade.php` (2 occurrences)
- `resources/views/public/destinasi/index.blade.php` (1 occurrence)
- `resources/views/public/destinasi/show.blade.php` (2 occurrences)
- `resources/views/public/destinasi/by-wilayah.blade.php` (2 occurrences)

**Pattern changed:**
```php
// Before
{{ $destinasi->getTranslatedDescription() }}
{{ Str::limit($area->getTranslatedDescription(), 100) }}

// After
{{ $destinasi->deskripsi }}
{{ Str::limit($area->deskripsi, 100) }}
```

## What Remains Bilingual

### UI Translation (Laravel Localization System)
- Navigation menus
- Buttons and labels
- Hero section text
- Footer content
- Form labels
- Error messages

**Translation files:**
- `resources/lang/en/site.php`
- `resources/lang/id/site.php`

**Usage in views:**
```php
{{ __('site.hero_title') }}
{{ __('site.about_title') }}
{{ __('site.services_cta') }}
```

### Language Switcher
Still functional at `/lang/{locale}` - switches UI language only:
- Indonesian UI with Indonesian content
- English UI with Indonesian content

## Admin Panel
- Remains Indonesian-only
- CRUD forms have single description field (`deskripsi`)
- No need for translation helpers in admin views
- Intended for internal staff usage

## Testing Recommendations

1. **Public Site:**
   - Test home page with both English and Indonesian UI
   - Verify destination descriptions display correctly
   - Check wilayah pages show Indonesian descriptions
   - Confirm language switcher works for UI elements

2. **Admin Panel:**
   - Test CRUD operations for Destinasi
   - Verify Wilayah CRUD works with single field
   - Check Akomodasi and Transportasi forms
   - Confirm no errors related to missing `deskripsi_en`

3. **Database Verification:**
   ```bash
   # Check columns no longer exist
   mysql citara -e "SHOW COLUMNS FROM destinasi LIKE '%deskripsi%';"
   mysql citara -e "SHOW COLUMNS FROM wilayah LIKE '%deskripsi%';"
   mysql citara -e "SHOW COLUMNS FROM akomodasi LIKE '%deskripsi%';"
   mysql citara -e "SHOW COLUMNS FROM transportasi LIKE '%deskripsi%';"
   ```

## Rollback Plan

If needed, the migration can be rolled back:

```bash
php artisan migrate:rollback --step=1
```

This will:
1. Re-add `deskripsi_en` columns to all 4 tables
2. Set existing values to NULL
3. Require manual data entry if English content is needed again

## Related Documentation
- [LOCALIZATION.md](./LOCALIZATION.md) - Laravel localization system guide
- [.github/copilot-instructions.md](../.github/copilot-instructions.md) - Project conventions

## Migration History

| Date | Action | Status |
|------|--------|--------|
| 2025-01-XX | Created cleanup migration | ✅ Complete |
| 2025-01-XX | Updated 4 models | ✅ Complete |
| 2025-01-XX | Updated 5 view files (7 occurrences) | ✅ Complete |
| 2025-01-XX | Ran migration to drop columns | ✅ Complete |
| 2025-01-XX | Verified no errors | ✅ Complete |
