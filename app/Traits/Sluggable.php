<?php
namespace App\Traits;

use Illuminate\Support\Str;

trait Sluggable
{
    public static function bootSluggable(): void
    {
        static::saving(function ($model) {
            if (empty($model->slug) && ! empty($model->nama)) {
                $base = Str::slug($model->nama);
                $slug = $base;
                $i = 1;
                while (static::where('slug', $slug)->where('id', '!=', $model->id ?? 0)->exists()) {
                    $slug = $base . '-' . $i++;
                }
                $model->slug = $slug;
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
