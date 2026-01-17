<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsletterCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'content',
        'sent_at',
        'recipient_count',
        'status',
        'recipient_type',
        'target_recipients'
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'target_recipients' => 'array',
    ];
}
