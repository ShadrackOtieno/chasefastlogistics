<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $guarded = [];

    public static function map(): array
    {
        return Cache::remember('site_settings', 3600, fn () => static::pluck('value', 'key')->all());
    }

    public static function get(string $key, $default = null)
    {
        return static::map()[$key] ?? $default;
    }

    public static function put(array $values): void
    {
        foreach ($values as $key => $value) {
            static::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        Cache::forget('site_settings');
    }
}
