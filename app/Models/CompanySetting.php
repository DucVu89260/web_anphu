<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{   
    protected $guarded = [];

    protected $casts = [
        'social_links' => 'array',
        'google_map' => 'array',
        'google_map_2' => 'array',
        'certificates' => 'array',
        'certificates_public_ids' => 'array',
    ];

}
