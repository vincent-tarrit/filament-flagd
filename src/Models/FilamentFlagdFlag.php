<?php

namespace Vincenttarrit\FilamentFlagd\Models;

use Illuminate\Database\Eloquent\Model;

class FilamentFlagdFlag extends Model
{
    protected $fillable = [
        'key', 'state', 'default_variant',
    ];

    public function targetingRule()
    {
        return $this->hasOne(FilamentFlagdTargetingRule::class);
    }
}
