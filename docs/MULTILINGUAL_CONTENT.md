# Multilingual Content Guide

## Overview
This guide explains how to manage multilingual content for destinations, accommodations, transportation, regions, and events.

## Database Schema

New English fields have been added to support bilingual content:

### Destinasi Table
- `nama_en` - English name
- `deskripsi_en` - English description

### Akomodasi Table  
- `nama_en` - English name
- `deskripsi_en` - English description

### Transportasi Table
- `nama_en` - English name
- `deskripsi_en` - English description
- `rute_en` - English route description

### Wilayah Table
- `nama_en` - English name
- `deskripsi_en` - English description

### Calendar_events Table
- `title_en` - English title
- `description_en` - English description
- `location_en` - English location

## Usage in Views

Instead of using `{{ $model->nama }}` directly, use the localized attribute:

```blade
{{-- OLD WAY (Indonesian only) --}}
<h1>{{ $destinasi->nama }}</h1>
<p>{{ $destinasi->deskripsi }}</p>

{{-- NEW WAY (Bilingual support) --}}
<h1>{{ $destinasi->localized_name }}</h1>
<p>{{ $destinasi->localized_description }}</p>
```

### Available Localized Attributes

#### Destinasi Model
- `{{ $destinasi->localized_name }}` - Returns `nama_en` if locale is 'en' and field is not empty, otherwise `nama`
- `{{ $destinasi->localized_description }}` - Returns `deskripsi_en` if locale is 'en' and field is not empty, otherwise `deskripsi`

#### Akomodasi Model
- `{{ $akomodasi->localized_name }}`
- `{{ $akomodasi->localized_description }}`

#### Transportasi Model
- `{{ $transportasi->localized_name }}`
- `{{ $transportasi->localized_description }}`
- `{{ $transportasi->localized_route }}` - For route field

#### Wilayah Model
- `{{ $wilayah->localized_name }}`
- `{{ $wilayah->localized_description }}`

#### CalendarEvent Model
- `{{ $event->localized_title }}`
- `{{ $event->localized_description }}`
- `{{ $event->localized_location }}`

## Migration

Run the migration to add English fields:

```bash
php artisan migrate
```

## Adding English Content

### Via Admin Panel
When creating or editing content in the admin panel, fill in both Indonesian and English fields:
- Indonesian fields: `nama`, `deskripsi`, etc (required)
- English fields: `nama_en`, `deskripsi_en`, etc (optional)

If English fields are empty, the system will automatically fall back to Indonesian content.

### Example in Admin Forms

```blade
{{-- Indonesian Name (Required) --}}
<label>Nama (Indonesian)</label>
<input name="nama" value="{{ $destinasi->nama }}" required>

{{-- English Name (Optional) --}}
<label>Name (English)</label>
<input name="nama_en" value="{{ $destinasi->nama_en }}">

{{-- Indonesian Description (Required) --}}
<label>Deskripsi (Indonesian)</label>
<textarea name="deskripsi" required>{{ $destinasi->deskripsi }}</textarea>

{{-- English Description (Optional) --}}
<label>Description (English)</label>
<textarea name="deskripsi_en">{{ $destinasi->deskripsi_en }}</textarea>
```

## How It Works

1. **Locale Detection**: The system detects current locale using `app()->getLocale()`
2. **Field Selection**: 
   - If locale is 'en' AND English field (`*_en`) is not empty → Use English field
   - Otherwise → Use Indonesian field (fallback)
3. **Automatic**: No need to check locale in views, just use `localized_*` attributes

## Testing

### Switch Language
```bash
# Set to English
php artisan config:set app.locale en

# Set to Indonesian  
php artisan config:set app.locale id

# Or use language switcher in UI
# Visit: /lang/en or /lang/id
```

### Clear Caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## Benefits

✅ **Backward Compatible**: Existing Indonesian-only content works without changes
✅ **Optional English**: English fields are optional, system falls back to Indonesian
✅ **Clean Views**: No need for complex `@if(app()->getLocale() === 'en')` checks in views
✅ **Centralized Logic**: Translation logic in models, not scattered in views
✅ **Easy Migration**: Can gradually add English translations without breaking existing content

## Next Steps

1. Run migration: `php artisan migrate`
2. Update views to use `localized_*` attributes (see examples below)
3. Add English content via admin panel
4. Test by switching language using `/lang/en` and `/lang/id`

## View Update Examples

See `docs/VIEW_UPDATES_BILINGUAL.md` for complete view update guide.
