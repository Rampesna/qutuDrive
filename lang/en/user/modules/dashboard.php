<?php

return [

    'index' => [

        'fileUploadButton' => 'Dosya Yükle',
        'directories' => 'Klasörler',
        'files' => 'Dosyalar',
        'directoryCount' => 'Klasör',
        'fileCount' => 'Dosya',

        'contextMenu' => [
            'title' => 'İşlemler',
            'transactions' => [
                'uploadFile' => 'Dosya Yükle',
                'createDirectory' => 'Klasör Oluştur',
                'download' => 'İndir',
                'cut' => 'Kes',
                'copy' => 'Kopyala',
                'paste' => 'Yapıştır',
                'rename' => 'Yeniden Adlandır',
                'delete' => 'Sil',
                'properties' => 'Özellikler',
            ],
        ],

        'modals' => [
            'createDirectory' => [
                'modalTitle' => 'Klasör Oluştur',
                'placeholder' => 'Klasör Adı',
                'cancelButton' => 'Vazgeç',
                'createButton' => 'Oluştur',
            ],

            'deleteDirectory' => [
                'modalTitle' => 'Klasör Sil',
                'modalText' => 'Seçili klasörleri silmek istediğinize emin misiniz?',
                'cancelButton' => 'Vazgeç',
                'deleteButton' => 'Sil',
            ],

            'deleteFile' => [
                'modalTitle' => 'Dosya Sil',
                'modalText' => 'Seçili dosyaları silmek istediğinize emin misiniz?',
                'cancelButton' => 'Vazgeç',
                'deleteButton' => 'Sil',
            ],

            'renameDirectory' => [
                'modalTitle' => 'Klasörü Yeniden Adlandır',
                'placeholder' => 'Klasör Adı',
                'cancelButton' => 'Vazgeç',
                'updateButton' => 'Güncelle',
            ],

            'renameFile' => [
                'modalTitle' => 'Dosyayı Yeniden Adlandır',
                'placeholder' => 'Dosya Adı',
                'cancelButton' => 'Vazgeç',
                'updateButton' => 'Güncelle',
            ],

            'uploadFile' => [
                'modalTitle' => 'Upload File',
                'uploadButton' => 'Upload',
                'cancelButton' => 'Cancel',
            ],
        ]
    ]

];
