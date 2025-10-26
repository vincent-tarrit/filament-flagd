<?php

namespace Vincenttarrit\FilamentFlagd\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FilamentFlagdEvaluator extends Model
{
    protected $fillable = ['key', 'description'];

    public function conditions(): HasMany
    {
        return $this->hasMany(FilamentFlagdEvaluatorCondition::class);
    }
}
