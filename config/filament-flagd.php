<?php

// config for Vincenttarrit/FilamentFlagd
return [
    'path' => base_path('feature-flags/flags.json'),

    'navigation' => [
        'label' => 'Feature Flags',
    ],

    'variables' => [
        'user_id',
        'user_email',
        'user_name'
    ]
];
