<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Setting extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'key',
        'value',
        'group',
        'type',
    ];

    private static $requestCache = null;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('site_logo')->singleFile();
        $this->addMediaCollection('site_favicon')->singleFile();
        $this->addMediaCollection('og_image')->singleFile();
    }

    /**
     * Get a setting value by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        if (self::$requestCache === null) {
            self::$requestCache = \Illuminate\Support\Facades\Cache::rememberForever('settings_all', function () {
                return self::all();
            });
        }

        $setting = self::$requestCache->where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }

        switch ($setting->type) {
            case 'boolean':
                return (bool) $setting->value;
            case 'integer':
                return (int) $setting->value;
            case 'json':
                return json_decode($setting->value, true);
            case 'media':
                // Re-fetch to use InteractsWithMedia (static context workaround)
                $model = self::find($setting->id);
                return $model ? $model->getFirstMediaUrl($key) : $default;
            default:
                return $setting->value;
        }
    }

    /**
     * Set a setting value.
     *
     * @param string $key
     * @param mixed $value
     * @param string $group
     * @param string $type
     * @return Setting
     */
    public static function set($key, $value, $group = 'general', $type = 'string')
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'type' => $type
            ]
        );

        \Illuminate\Support\Facades\Cache::forget('settings_all');
        self::$requestCache = null;

        return $setting;
    }
}
