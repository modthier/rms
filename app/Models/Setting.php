<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Application settings (e.g. restaurant name). Supports cached access via getCached().
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class Setting extends Model
{
    /** Cache key for app settings. */
    public const CACHE_KEY = 'app_settings';

    /** Cache TTL: 24 hours. */
    public const CACHE_TTL = 86400;

    /**
     * Get the first setting (cached).
     *
     * @return \App\Models\Setting|null
     */
    public static function getCached(): ?self
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return static::first();
        });
    }

    /**
     * Clear the settings cache (call after update/save).
     *
     * @return void
     */
    public static function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
