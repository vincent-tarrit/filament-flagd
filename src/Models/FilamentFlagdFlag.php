<?php

namespace Vincenttarrit\FilamentFlagd\Models;

use Illuminate\Database\Eloquent\Model;

class FilamentFlagdFlag extends Model
{
    protected $fillable = [
        'key', 'state', 'default_variant',
    ];

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    public function targetingRules()
    {
        return $this->hasOne(TargetingRule::class);
    }
}
