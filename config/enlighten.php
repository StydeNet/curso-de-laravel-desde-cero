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

    // Configure the test suites that will be shown in the frontend.
     'test-suites' => ['Feature' => 'Feature'],

    'modules' => [
        [
            'name' => 'Users',
            'pattern' => ['*Users*'],
        ],
        [
            'name' => 'Professions',
            'pattern' => ['*Professions*']
        ],
        [
            'name' => 'Other Modules',
            'pattern' => ['*'],
        ],
    ]
];
