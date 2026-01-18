<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Slider extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'button_text',
        'button_link',
        'image_path',
        'display_order',
        'is_active',
        'bg_color',
        'accent_color',
        'title_color',
        'description_color',
        'price_color',
        'social_color',
        'nav_color',
        'line_color',
        'ui_theme',
        'price',
        'top_notes',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];
}
