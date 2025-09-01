<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacebookPost extends Model
{
    protected $fillable = [
        'fb_post_id',
        'message',
        'permalink_url',
        'full_picture',
        'video_source',
        'name',
        'caption',
        'description',
        'posted_at',

        'related_type',
        'related_id',
    ];

    protected $dates = ['posted_at'];

    public function related()
    {
        return $this->morphTo(null, 'related_type', 'related_id');
    }
}
