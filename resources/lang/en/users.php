<?php

return [
    'title' => [
        'index' => 'Users',
        'trash' => 'Users Trash',
    ],

    'roles' => ['admin' => 'Admin', 'user' => 'User'],
    'states' => ['active' => 'Active', 'inactive' => 'Inactive'],

    'filters' => [
        'roles' => ['all' => 'Role', 'admin' => 'Admins', 'user' => 'Users'],
        'states' => ['all' => 'All', 'active' => 'Only active', 'inactive' => 'Only inactive'],
    ]
];
