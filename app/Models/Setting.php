<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

/**
 * Application settings (e.g. restaurant name). Supports cached access via getCached().
 *
 * @property int $id
 * @property string $name
 * @property string $receipt_mode
 * @property int $receipt_font_size
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class Setting extends Model
{
    protected $fillable = [
        'name',
        'receipt_mode',
        'receipt_font_size',
        'customer_printer',
        'kitchen_printer',
    ];

    /** Default receipt text size in pixels. */
    public const DEFAULT_RECEIPT_FONT_SIZE = 16;

    /** Two receipts: separate kitchen and customer copies. */
    public const RECEIPT_MODE_DUAL = 'dual';

    /** One general receipt for kitchen and customer. */
    public const RECEIPT_MODE_SINGLE = 'single';

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
        try {
            return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
                if (!Schema::hasTable((new static)->getTable())) {
                    return new static([
                        'name' => config('app.name', 'RMS'),
                        'receipt_mode' => self::RECEIPT_MODE_DUAL,
                    ]);
                }

                $setting = static::first();

                if ($setting instanceof self) {
                    return $setting;
                }

                return new static([
                    'name' => config('app.name', 'RMS'),
                    'receipt_mode' => self::RECEIPT_MODE_DUAL,
                ]);
            });
        } catch (\Throwable $e) {
            report($e);

            return new static([
                'name' => config('app.name', 'RMS'),
                'receipt_mode' => self::RECEIPT_MODE_DUAL,
            ]);
        }
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

    /**
     * Whether orders print separate kitchen and customer receipts.
     */
    public function usesDualReceipts(): bool
    {
        return ($this->receipt_mode ?? self::RECEIPT_MODE_DUAL) !== self::RECEIPT_MODE_SINGLE;
    }

    /**
     * Human-readable label for the current receipt mode.
     */
    public function receiptModeLabel(): string
    {
        return $this->usesDualReceipts()
            ? 'فاتورتان (مطبخ وعميل)'
            : 'فاتورة واحدة عامة';
    }
}
