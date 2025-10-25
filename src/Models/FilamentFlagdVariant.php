<?php

namespace Vincenttarrit\FilamentFlagd\Models;

use Illuminate\Database\Eloquent\Model;

class FilamentFlagdVariant extends Model
{
    protected $fillable = [
        'flag_id', 'name', 'value'
    ];

    protected $casts = [
        'value' => 'array',
    ];
}
