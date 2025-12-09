# View Updates for Bilingual Content Support

## Quick Reference

Replace these patterns in your view files:

```blade
{{-- Destinasi --}}
{{ $destinasi->nama }} → {{ $destinasi->localized_name }}
{{ $destinasi->deskripsi }} → {{ $destinasi->localized_description }}

{{-- Akomodasi --}}
{{ $akomodasi->nama }} → {{ $akomodasi->localized_name }}
{{ $akomodasi->deskripsi }} → {{ $akomodasi->localized_description }}

{{-- Transportasi --}}
{{ $transportasi->nama }} → {{ $transportasi->localized_name }}
{{ $transportasi->deskripsi }} → {{ $transportasi->localized_description }}
{{ $transportasi->rute }} → {{ $transportasi->localized_route }}

{{-- Wilayah --}}
{{ $wilayah->nama }} → {{ $wilayah->localized_name }}
{{ $wilayah->deskripsi }} → {{ $wilayah->localized_description }}

{{-- CalendarEvent --}}
{{ $event->title }} → {{ $event->localized_title }}
{{ $event->judul }} → {{ $event->localized_title }}
{{ $event->description }} → {{ $event->localized_description }}
{{ $event->deskripsi }} → {{ $event->localized_description }}
{{ $event->location }} → {{ $event->localized_location }}
{{ $event->lokasi }} → {{ $event->localized_location }}
```

## Files That Need Updates

### High Priority (Content Display)

1. **resources/views/public/home.blade.php**
   - Featured destinations section
   - Tourism areas cards
   - Events preview cards

2. **resources/views/public/destinasi/show.blade.php**
   - Destination title
   - Destination description
   - Related destinations

3. **resources/views/public/destinasi/index.blade.php**
   - Destination cards
   - Search results

4. **resources/views/public/destinasi/by-wilayah.blade.php**
   - Wilayah name and description
   - Destination listings

5. **resources/views/public/akomodasi/show.blade.php**
   - Accommodation name
   - Accommodation description

6. **resources/views/public/akomodasi/index.blade.php**
   - Accommodation cards

7. **resources/views/public/transportasi/show.blade.php**
   - Transportation name
   - Transportation description
   - Route information

8. **resources/views/public/transportasi/index.blade.php**
   - Transportation cards

9. **resources/views/public/events/show.blade.php**
   - Event title
   - Event description
   - Event location

10. **resources/views/public/events/calendar.blade.php**
    - Event listings
    - Event cards

### Medium Priority (Admin Forms)

Update admin forms to include English fields:
- `resources/views/admin/destinasi/create.blade.php`
- `resources/views/admin/destinasi/edit.blade.php`
- `resources/views/admin/akomodasi/create.blade.php`
- `resources/views/admin/akomodasi/edit.blade.php`
- `resources/views/admin/transportasi/create.blade.php`
- `resources/views/admin/transportasi/edit.blade.php`
- `resources/views/admin/wilayah/create.blade.php`
- `resources/views/admin/wilayah/edit.blade.php`
- `resources/views/admin/calendar-events/create.blade.php`
- `resources/views/admin/calendar-events/edit.blade.php`

## Example: Before and After

### Destinasi Show Page

**BEFORE:**
```blade
<h1 class="text-5xl font-bold text-white">
    {{ $destinasi->nama }}
</h1>
<p class="text-xl text-white/90">
    {{ $destinasi->deskripsi }}
</p>
```

**AFTER:**
```blade
<h1 class="text-5xl font-bold text-white">
    {{ $destinasi->localized_name }}
</h1>
<p class="text-xl text-white/90">
    {{ $destinasi->localized_description }}
</p>
```

### Home Page Featured Section

**BEFORE:**
```blade
<h3 class="text-3xl font-bold text-white mb-3">
    {{ $featured->nama }}
</h3>
<p class="text-white/90 text-lg line-clamp-2">
    {{ Str::limit($featured->deskripsi, 150) }}
</p>
```

**AFTER:**
```blade
<h3 class="text-3xl font-bold text-white mb-3">
    {{ $featured->localized_name }}
</h3>
<p class="text-white/90 text-lg line-clamp-2">
    {{ Str::limit($featured->localized_description, 150) }}
</p>
```

### Events Calendar

**BEFORE:**
```blade
<h3 class="event-title">{{ $event['title'] }}</h3>
<p class="event-description">{{ $event['description'] }}</p>
<span class="event-location">{{ $event['location'] }}</span>
```

**AFTER:**
```blade
<h3 class="event-title">{{ $event->localized_title }}</h3>
<p class="event-description">{{ $event->localized_description }}</p>
<span class="event-location">{{ $event->localized_location }}</span>
```

### Transportasi Show

**BEFORE:**
```blade
<h1>{{ $transportasi->nama }}</h1>
<p>{{ $transportasi->deskripsi }}</p>
<p>Rute: {{ $transportasi->rute }}</p>
```

**AFTER:**
```blade
<h1>{{ $transportasi->localized_name }}</h1>
<p>{{ $transportasi->localized_description }}</p>
<p>{{ __('site.route_travel') }}: {{ $transportasi->localized_route }}</p>
```

## Admin Form Example

Add English fields to admin forms:

```blade
{{-- resources/views/admin/destinasi/edit.blade.php --}}

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">
        Nama Destinasi (Indonesian) <span class="text-red-500">*</span>
    </label>
    <input type="text" name="nama" value="{{ $destinasi->nama }}" 
           class="w-full rounded border-gray-300" required>
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">
        Destination Name (English)
    </label>
    <input type="text" name="nama_en" value="{{ $destinasi->nama_en }}" 
           class="w-full rounded border-gray-300"
           placeholder="English translation (optional)">
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">
        Deskripsi (Indonesian) <span class="text-red-500">*</span>
    </label>
    <textarea name="deskripsi" rows="4" 
              class="w-full rounded border-gray-300" required>{{ $destinasi->deskripsi }}</textarea>
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">
        Description (English)
    </label>
    <textarea name="deskripsi_en" rows="4" 
              class="w-full rounded border-gray-300"
              placeholder="English translation (optional)">{{ $destinasi->deskripsi_en }}</textarea>
</div>
```

## Search & Replace Commands

Use these patterns for bulk updates (be careful and test first!):

```bash
# For Destinasi
grep -rl '{{ $destinasi->nama }}' resources/views/public/ | xargs sed -i 's/{{ $destinasi->nama }}/{{ $destinasi->localized_name }}/g'
grep -rl '{{ $dest->nama }}' resources/views/public/ | xargs sed -i 's/{{ $dest->nama }}/{{ $dest->localized_name }}/g'

# For Wilayah
grep -rl '{{ $wilayah->nama }}' resources/views/public/ | xargs sed -i 's/{{ $wilayah->nama }}/{{ $wilayah->localized_name }}/g'
grep -rl '{{ $area->nama }}' resources/views/public/ | xargs sed -i 's/{{ $area->nama }}/{{ $area->localized_name }}/g'
```

**⚠️ Warning**: Always backup files before running bulk search & replace commands!

## Testing Checklist

After updating views:

- [ ] Homepage displays correctly in English
- [ ] Homepage displays correctly in Indonesian
- [ ] Destination detail pages show localized content
- [ ] Destination listings show localized names
- [ ] Wilayah pages show localized content
- [ ] Events calendar shows localized titles
- [ ] Event detail pages show localized descriptions
- [ ] Accommodation pages show localized content
- [ ] Transportation pages show localized content
- [ ] No errors in Laravel logs
- [ ] Admin forms save both Indonesian and English content
- [ ] Content falls back to Indonesian when English is empty

## Rollback Plan

If issues occur, you can temporarily revert models:

1. Comment out the `getLocalized*Attribute()` methods in models
2. Use `{{ $model->nama }}` etc directly in views
3. English content will still be in database, just not used yet
