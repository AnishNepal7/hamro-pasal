<?php
namespace App\Helpers;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsHelper
{
    public static function get(string $key, $default = null)
    {
        // Cache settings for 60 minutes for high performance
        return Cache::remember('settings.' . $key, 3600, function () use ($key, $default) {
            return Setting::where('key', $key)->first()->value ?? $default;
        });
    }
}