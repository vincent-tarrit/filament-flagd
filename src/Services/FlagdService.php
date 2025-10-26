<?php

namespace Vincenttarrit\FilamentFlagd\Services;

use Vincenttarrit\FilamentFlagd\Models\FilamentFlagdEvaluator;
use Vincenttarrit\FilamentFlagd\Models\FilamentFlagdFlag;

class FlagdService
{
    public function json()
    {
        $flags = FilamentFlagdFlag::with(['targetingRule.conditions'])->get();

        $output = [
            '$schema' => 'https://flagd.dev/schema/v0/flags.json',
            'flags' => [],
        ];

        foreach ($flags as $flag) {
            $rule = $flag->targetingRule;

            $ifArray = [];
            $orConditions = [];
            $fractionalConditions = [];

            foreach ($rule->conditions as $c) {
                if ($c->type === 'fractional') {
                    $fractionalConditions[] = [
                        'fractional' => [
                            ['var' => $c->attribute],
                            ['on', (int)$c->percent],
                            ['off', 100 - (int)$c->percent],
                        ],
                    ];
                } else {
                    $orConditions[] = $c->toFlagdStructure();
                }
            }

            // Add OR conditions + result at the beginning if exist
            if (!empty($orConditions)) {
                $ifArray[] = ['or' => $orConditions];

                $resultVariant = $rule->result_variant ? 'on' : 'off';

                $ifArray[] = $resultVariant;

                // If there are fractional conditions, keep true placeholder; otherwise null
                $ifArray[] = !empty($fractionalConditions) ? true : null;
            }

            // Append all fractional conditions at the end
            foreach ($fractionalConditions as $fractional) {
                $ifArray[] = $fractional;
            }

            $output['flags'][$flag->key] = [
                'variants' => [
                    'on' => true,
                    'off' => false,
                ],
                'defaultVariant' => $flag->default_variant ? 'on' : 'off',
                'state' => $flag->state,
                'targeting' => [
                    'if' => $ifArray,
                ],
            ];
        }

        $evaluators = FilamentFlagdEvaluator::with('conditions')->get();

        foreach ($evaluators as $eval) {
            $output['$evaluators'][$eval->key] = [
                $eval->conditions->first()->type => [
                    ['var' => $eval->conditions->first()->attribute],
                    $eval->conditions->first()->value,
                ],
            ];
        }

        return json_encode($output, JSON_PRETTY_PRINT);
    }
}
