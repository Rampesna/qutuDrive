<?php

return [

    'getAll' => [
        'success' => 'All companies',
    ],

    'getById' => [
        'exists' => 'Company',
        'notFound' => 'Company not found',
    ],

    'getCompanyUsers' => [
        'success' => 'Company users',
    ],

    'getByTaxNumber' => [
        'success' => 'Company',
        'notFound' => 'Company not found',
    ],

    'getByEmail' => [
        'success' => 'Company',
        'notFound' => 'Company not found',
    ],

    'create' => [
        'taxNumberExists' => 'Tax number already exists',
        'emailExists' => 'Email already exists',
        'success' => 'Company created',
    ],

    'update' => [
        'success' => 'Company updated',
    ],

    'detachCompanyUser' => [
        'success' => 'Company user detached',
    ],

    'delete' => [
        'success' => 'Company deleted',
    ],
];
