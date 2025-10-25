<?php

namespace Vincenttarrit\FilamentFlagd\Models;

use Illuminate\Database\Eloquent\Model;

class FilamentFlagdTargetingRule extends Model
{
    protected $fillable = [
        'flag_id', 'target_var', 'percent_rollout'
    ];

    protected $casts = [
        'percent_rollout' => 'array',
    ];
}
