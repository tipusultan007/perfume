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
        'social_hover_color',
        'social_icon_color',
        'social_icon_hover_color',
        'nav_hover_color',
        'nav_icon_color',
        'nav_icon_hover_color',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('slider')
            ->singleFile();
    }
}
