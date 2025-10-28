# Laravel Localization Guide for Citara Project

This project uses **Laravel's built-in localization system** for bilingual support (Indonesian and English).

## Architecture Overview

### 1. Language Files
Translation strings are stored in PHP arrays under `resources/lang/`:
```
resources/lang/
├── en/
│   └── site.php    # English translations
└── id/
    └── site.php    # Indonesian translations
```

Each file returns an associative array where keys map to translated strings:
```php
// resources/lang/en/site.php
return [
    'home' => 'Home',
    'destinations' => 'Destinations',
    // ...
];

// resources/lang/id/site.php
return [
    'home' => 'Beranda',
    'destinations' => 'Destinasi',
    // ...
];
```

### 2. Configuration
Default locale is set in `.env`:
```env
APP_LOCALE=id              # Default language (Indonesian)
APP_FALLBACK_LOCALE=id     # Fallback if translation missing
```

### 3. Middleware (SetLocale)
`App\Http\Middleware\SetLocale` automatically sets the application locale based on:
- User's session preference (from language switcher)
- Falls back to default locale ('id')

Applied to public routes in `routes/web.php`:
```php
Route::middleware([SetLocale::class])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    // ...
});
```

### 4. Language Switcher Route
Users can switch languages via `/lang/{locale}`:
```php
Route::get('/lang/{locale}', function ($locale) {
    $available = ['en', 'id'];
    if (! in_array($locale, $available)) {
        abort(400);
    }
    session(['locale' => $locale]);
    return redirect()->back();
})->name('lang.switch');
```

## Usage in Views

### Basic Translation
Use the `__()` helper or `@lang` directive:
```blade
{{-- Short helper syntax --}}
<h1>{{ __('site.hero_title') }}</h1>

{{-- Blade directive --}}
@lang('site.destinations')
```

### Translation with Parameters
Pass variables to translations:
```php
// Language file
'welcome_user' => 'Welcome, :name!',

// View
{{ __('site.welcome_user', ['name' => $user->name]) }}
```

### Pluralization
Laravel supports smart pluralization:
```php
// Language file
'destinations_count' => '{0} No destinations|{1} :count Destination|[2,*] :count Destinations',

// View
{{ trans_choice('site.destinations_count', $count) }}
```

## Model Localization Pattern

For database content with multiple language versions, use accessor methods:

```php
class Destinasi extends Model
{
    protected $fillable = ['nama', 'deskripsi', 'deskripsi_en'];
    
    /**
     * Get description in current locale
     */
    public function getLocalizedDescriptionAttribute()
    {
        if (app()->getLocale() === 'en' && !empty($this->deskripsi_en)) {
            return $this->deskripsi_en;
        }
        return $this->deskripsi;
    }
}

// Usage in views
{{ $destinasi->localized_description }}
```

## Adding New Translations

### 1. Add keys to language files
```php
// resources/lang/en/site.php
'new_feature' => 'New Feature',

// resources/lang/id/site.php
'new_feature' => 'Fitur Baru',
```

### 2. Use in views
```blade
{{ __('site.new_feature') }}
```

## UI Language Switcher

Current implementation in `resources/views/layouts/public.blade.php`:
```blade
<div class="flex items-center gap-2">
    <a href="{{ route('lang.switch', 'en') }}"
       class="text-white font-medium px-2 py-1 rounded transition 
              {{ app()->getLocale() === 'en' ? 'bg-white/20' : 'hover:bg-white/10' }}">
        EN
    </a>
    <span class="text-white/50">|</span>
    <a href="{{ route('lang.switch', 'id') }}"
       class="text-white font-medium px-2 py-1 rounded transition 
              {{ app()->getLocale() === 'id' ? 'bg-white/20' : 'hover:bg-white/10' }}">
        ID
    </a>
</div>
```

## Best Practices

### ✅ DO
- Keep all UI strings in language files
- Use descriptive, hierarchical keys (e.g., `site.hero_title`, `site.footer.copyright`)
- Provide translations for both languages before deploying
- Use `app()->getLocale()` to check current language in code
- Store user's language preference in session

### ❌ DON'T
- Hardcode text strings in views
- Mix languages in the same file
- Use translation keys as sentences
- Forget to add keys to both `en/` and `id/` files

## Testing Localization

### Manual Testing
1. Visit `/lang/en` to switch to English
2. Visit `/lang/id` to switch to Indonesian
3. Verify all text changes correctly

### Automated Testing
```php
public function test_language_switch()
{
    // Test Indonesian (default)
    $response = $this->get('/');
    $response->assertSee('Beranda');
    
    // Switch to English
    $this->get('/lang/en');
    $response = $this->get('/');
    $response->assertSee('Home');
}
```

## Adding a New Language

To add another language (e.g., Japanese):

1. Create language directory:
   ```bash
   mkdir resources/lang/ja
   ```

2. Copy and translate site.php:
   ```bash
   cp resources/lang/id/site.php resources/lang/ja/site.php
   # Edit and translate to Japanese
   ```

3. Update middleware available locales:
   ```php
   // app/Http/Middleware/SetLocale.php
   $availableLocales = ['en', 'id', 'ja'];
   ```

4. Add language switcher link in layout

## Resources

- [Laravel Localization Documentation](https://laravel.com/docs/11.x/localization)
- [PHP gettext vs Laravel Lang Files](https://laravel.com/docs/11.x/localization#introduction)
- [Localization Package for Laravel](https://github.com/mcamara/laravel-localization)

## Summary

This project implements Laravel's localization professionally:
- ✅ Separation of concerns (language files separate from logic)
- ✅ Session-based language persistence
- ✅ Middleware-driven automatic locale setting
- ✅ RESTful language switching endpoint
- ✅ Fallback mechanism for missing translations
- ✅ Clean, maintainable architecture

**No additional packages or complex setup required** — everything uses Laravel's native features.
