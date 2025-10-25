<?php

namespace Vincenttarrit\FilamentFlagd\Models;

use Illuminate\Database\Eloquent\Model;

class FilamentFlagdTargetingRule extends Model
{
    protected $fillable = [
        'flag_id', 'result_variant'
    ];

    protected $casts = [
    ];

    public function conditions() {
        return $this->hasMany(FilamentFlagdTargetingCondition::class);
    }

    public function flag() {
        return $this->belongsTo(FilamentFlagdFlag::class);
    }
}
