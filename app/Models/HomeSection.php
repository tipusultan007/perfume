<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSection extends Model
{
    protected $fillable = [
        'key',
        'title',
        'subtitle',
        'content',
        'button_text',
        'button_link',
        'image_path'
    ];
}
