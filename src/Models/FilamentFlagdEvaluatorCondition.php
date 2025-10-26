<?php

namespace Vincenttarrit\FilamentFlagd\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FilamentFlagdEvaluatorCondition extends Model
{
    protected $fillable = ['evaluator_id', 'type', 'attribute', 'value'];

    public function evaluator(): BelongsTo
    {
        return $this->belongsTo(FilamentFlagdEvaluator::class);
    }

    public function toFlagdStructure(): array
    {
        return [
            $this->type => [
                ['var' => $this->attribute],
                $this->value,
            ],
        ];
    }
}
