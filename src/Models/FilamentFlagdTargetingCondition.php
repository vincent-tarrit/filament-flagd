<?php

namespace Vincenttarrit\FilamentFlagd\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vincenttarrit\FilamentFlagd\Observers\TargetingConditionsObserver;

class FilamentFlagdTargetingCondition extends Model
{
    use HasFactory;

    protected $fillable = [
        'targeting_rule_id',
        'type',
        'ref',
        'attribute',
        'values',
        'value',
        'percent'
    ];

    protected $casts = [
        'values' => 'array', // for "in" or "fractional" conditions
    ];


    protected static function boot()
    {
        parent::boot();
        static::observe(TargetingConditionsObserver::class);

    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function targetingRule()
    {
        return $this->belongsTo(FilamentFlagdTargetingRule::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    /**
     * Transform the condition into the proper Flagd JSON structure.
     */
    public function toFlagdStructure(): array
    {
        switch ($this->type) {
            case 'ref':
                return [
                    '$ref' => $this->ref,
                ];

            case 'in':
                return [
                    'in' => [
                        ['var' => [$this->attribute]],
                        $this->values ?? [],
                    ],
                ];

            case 'ends_with':
                return [
                    'ends_with' => [
                        ['var' => [$this->attribute]],
                        $this->value,
                    ],
                ];

            case 'starts_with':
                return [
                    'starts_with' => [
                        ['var' => [$this->attribute]],
                        $this->value,
                    ],
                ];

            case 'equals':
                return [
                    'equals' => [
                        ['var' => [$this->attribute]],
                        $this->value,
                    ],
                ];

            case 'fractional':
                return [
                    'fractional' => array_merge(
                        [['var' => $this->attribute]],
                        collect($this->values ?? [])->map(fn ($percent, $variant) => [$variant, (int) $percent])->toArray()
                    ),
                ];

            default:
                return [];
        }
    }
}
