<?php

return [

    'getAll' => [
        'success' => 'Tüm firmalar',
    ],

    'getById' => [
        'exists' => 'Firma',
        'notFound' => 'Firma bulunamadı',
    ],

    'getCompanyUsers' => [
        'success' => 'Firma kullanıcıları',
    ],

    'getByTaxNumber' => [
        'success' => 'Firma',
        'notFound' => 'Firma bulunamadı',
    ],

    'getByEmail' => [
        'success' => 'Firma',
        'notFound' => 'Firma bulunamadı',
    ],

    'create' => [
        'taxNumberExists' => 'Vergi numarası zaten kayıtlı',
        'emailExists' => 'E-posta adresi zaten kayıtlı',
        'success' => 'Firma başarıyla oluşturuldu',
    ],

    'update' => [
        'success' => 'Firma başarıyla güncellendi',
    ],

    'detachCompanyUser' => [
        'success' => 'Firma kullanıcısı başarıyla kaldırıldı',
    ],

    'delete' => [
        'success' => 'Firma başarıyla silindi',
    ],
];
