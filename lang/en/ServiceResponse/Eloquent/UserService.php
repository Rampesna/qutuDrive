<?php

return [

    'getAll' => [
        'success' => 'All users',
    ],

    'getById' => [
        'exists' => 'User',
        'notFound' => 'User not found',
    ],

    'getByUsername' => [
        'success' => 'User',
        'notFound' => 'User not found',
    ],

    'getByEmail' => [
        'success' => 'User',
        'notFound' => 'User not found',
    ],

    'getProfile' => [
        'success' => 'User profile',
        'notFound' => 'User not found',
    ],

    'getCompanies' => [
        'success' => 'User companies',
    ],

    'checkUserCompany' => [
        'success' => 'User company',
    ],

    'attachUserCompany' => [
        'success' => 'User company attached',
        'companyNotFound' => 'Company not found',
    ],

    'detachUserCompany' => [
        'success' => 'User company detached',
        'companyNotFound' => 'Company not found',
    ],

    'checkPassword' => [
        'success' => 'Password correct',
        'incorrect' => 'Password incorrect',
    ],

    'setCompanies' => [
        'success' => 'User companies set',
    ],

    'create' => [
        'success' => 'User created',
    ],

    'generateSanctumToken' => [
        'success' => 'Token generated',
        'notFound' => 'User not found',
    ],

    'getByCompanyId' => [
        'success' => 'Users',
    ],

    'update' => [
        'success' => 'User updated',
    ],

    'updatePassword' => [
        'success' => 'Password updated',
    ],

    'delete' => [
        'success' => 'User deleted',
    ],

];
