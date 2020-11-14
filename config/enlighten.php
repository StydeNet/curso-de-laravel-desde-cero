<?php

//use Styde\Enlighten\Section;

return [
    'enabled' => true,

    'hide' => [
//        Section::SESSION,
//        Section::EXCEPTION,
//        Section::QUERIES,
    ],

    'tests' => [
        // Add expressions to ignore test class names and test method names.
        // i.e. Tests\Unit\* will ignore all tests in the Tests\Unit\ suite,
        // validates_* will ignore all the tests that start with validates_.
        'ignore' => [],
    ],

     'request' => [
        'headers' => [
            'ignore' => [],
            'overwrite' => [],
        ],
        'query' => [
            'ignore' => [],
            'overwrite' => [],
        ],
        'input' => [
            'ignore' => [],
            'overwrite' => [],
        ],
     ],

    'response' => [
        'headers' => [
            'ignore' => ['set-cookie'],
            'overwrite' => [],
        ]
    ],

    // Configure a default view for the panel. Options: features, modules and endpoints.
    'area_view' => 'endpoints',

    // Customise the name and view template of each area that will be shown in the panel.
    // By default, each area slug will represent a "test suite" in the tests directory.
    // Each area can have a different view style, ex: features, modules or endpoints.
    'areas' => [
        [
            'slug' => 'api',
            'name' => 'API',
            'view' => 'endpoints',
        ],
        [
            'slug' => 'feature',
            'name' => 'Features',
            'view' => 'endpoints',
        ],
        [
            'slug' => 'unit',
            'name' => 'Unit',
            'view' => 'features',
        ],
    ],

    'modules' => [
        [
            'name' => 'Users',
            'classes' => ['*Users*'],
            'routes' => ['user*', '*profile*'],
        ],
        [
            'name' => 'Professions',
            'classes' => ['*Professions*'],
            'routes' => ['profession*'],
        ],
        [
            'name' => 'Other Modules',
            'classes' => ['*'],
            'routes' => ['*'],
        ],
    ]
];
