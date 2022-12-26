<script>

    $(document).ready(function () {
        $('#loader').hide();
    });

    var controlKeyPressStatus = false;

    $(document).keydown(function (event) {
        if (parseInt(event.which) === 17) controlKeyPressStatus = true;
    });

    $(document).keyup(function () {
        controlKeyPressStatus = false;
    });

    var backDirectoryButton = $('#backDirectoryButton');
    var homeDirectoryButton = $('#homeDirectoryButton');

    var CreateDirectoryButton = $('#CreateDirectoryButton');
    var RenameDirectoryButton = $('#RenameDirectoryButton');
    var DeleteDirectoryButton = $('#DeleteDirectoryButton');
    var DeleteFileButton = $('#DeleteFileButton');
    var UploadFileButton = $('#UploadFileButton');

    var RenameFileButton = $('#RenameFileButton');

    /**
     * Transaction Variables Start
     * */

    var parentDirectoryId = null;

    var selectedDirectories = [];
    var selectedFiles = [];

    var copiedDirectories = [];
    var copiedFiles = [];

    var cutDirectories = [];
    var cutFiles = [];

    var historyDirectoryList = [];

    // Transaction Variables End

    var driveMain = $('#driveMain');
    var directoriesRow = $('#directoriesRow');
    var filesRow = $('#filesRow');
    var devicesRow = $('#devicesRow');
    var historyRow = $('#historyRow');

    var contextMenuSelector = $('#contextMenu');

    var uploadFileTransactionDiv = $('#uploadFileTransactionDiv');
    var createDirectoryTransactionDiv = $('#createDirectoryTransactionDiv');
    var downloadTransactionDiv = $('#downloadTransactionDiv');
    var cutTransactionDiv = $('#cutTransactionDiv');
    var copyTransactionDiv = $('#copyTransactionDiv');
    var pasteTransactionDiv = $('#pasteTransactionDiv');
    var renameTransactionDiv = $('#renameTransactionDiv');
    var deleteTransactionDiv = $('#deleteTransactionDiv');
    var propertiesTransactionDiv = $('#propertiesTransactionDiv');

    function getDirectoriesByParentId() {
        directoriesRow.empty().html(`
        <div class="col-xl-12 text-center mb-5">
            <i class="fa fa-spinner fa-spin"></i>
        </div>
        `);
        parentId = parentDirectoryId;
        backDirectoryButton.attr('disabled', parentDirectoryId === null);
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.directory.getByParentId') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                companyId: SelectedCompany.val(),
                parentId: parentId
            },
            success: function (response) {
                directoriesRow.empty();
                $.each(response.response, function (i, directory) {
                    directoriesRow.append(`
                    <div class="col-xl-2">
                        <div class="d-flex align-items-center bg-hover-light-dark border border-secondary rounded p-3 mb-7 directorySelector directoryTooltip" data-bs-toggle="tooltip" data-bs-placement="bottom" title="${directory.name}" data-selected="false" data-directory-name="${directory.name}" data-directory-id="${directory.id}" id="directory_${directory.id}">
                            <span class="svg-icon svg-icon-warning me-5">
                                <span class="svg-icon svg-icon-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path opacity="0.3" d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z" fill="black"/>
                                        <path d="M9.2 3H3C2.4 3 2 3.4 2 4V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V7C22 6.4 21.6 6 21 6H12L10.4 3.60001C10.2 3.20001 9.7 3 9.2 3Z" fill="black"/>
                                    </svg>
                                </span>
                            </span>
                            <div class="flex-grow-1 me-2">
                                <span class="fw-bolder text-gray-800 fs-6 disable-select">${directory.name.length > 17 ? `${directory.name.substring(0, 14)}...` : directory.name}</span>
                            </div>

                        </div>
                    </div>
                    `);
                });

                var directoryTooltips = $('.directoryTooltip');
                $.each(directoryTooltips, function () {
                    $(this).tooltip();
                });
            },
            error: function (error) {
                console.log(error);
                if (parseInt(error.status) === 422) {
                    $.each(error.responseJSON.response, function (i, error) {
                        toastr.error(error[0]);
                    });
                } else {
                    toastr.error(error.responseJSON.message);
                }
            }
        });
    }

    function getFilesByDirectoryId() {
        filesRow.empty().html(`
        <div class="col-xl-12 text-center mb-5">
            <i class="fa fa-spinner fa-spin"></i>
        </div>
        `);
        var directoryId = parentDirectoryId;
        var relationType = 'App\\Models\\Eloquent\\Firmalar';
        var relationId = SelectedCompany.val();
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.file.getByRelation') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                directoryId: directoryId,
                relationType: relationType,
                relationId: relationId
            },
            success: function (response) {
                filesRow.empty();
                $.each(response.response, function (i, file) {
                    filesRow.append(`
                    <div class="col-xl-2 mb-5">
                        <div class="card h-100 flex-center text-center py-4 px-0 cursor-pointer border border-secondary bg-hover-light-dark fileSelector fileTooltip" data-bs-toggle="tooltip" data-bs-placement="bottom" title="${file.name}" data-file-id="${file.id}" data-file-name="${file.name}" id="file_${file.id}" style="border-radius: 10px">
                            <i class="fas fa-file fa-lg mt-2 mb-5"></i>
                            <span class="font-weight-bolder text-dark-75 mb-1">${file.name.length > 19 ? `${file.name.substring(0,16)}...` : file.name}</span>
                            <div class="fs-7 fw-bold text-gray-400 mt-auto mb-1">${formatBytes(file.file_size)}</div>
                            <span class="fs-7 fw-bold text-gray-600 mt-auto mb-1">${reformatDatetimeToDatetimeForHuman(file.created_at)}</span>
                        </div>
                    </div>
                    `);
                });

                var fileTooltips = $('.fileTooltip');
                $.each(fileTooltips, function () {
                    $(this).tooltip();
                });
            },
            error: function (error) {
                console.log(error);
                if (parseInt(error.status) === 422) {
                    $.each(error.responseJSON.response, function (i, error) {
                        toastr.error(error[0]);
                    });
                } else {
                    toastr.error(error.responseJSON.message);
                }
            }
        });
    }

    function setHistoryRow() {

    }

    function initializeDrive() {
        getDirectoriesByParentId();
        getFilesByDirectoryId();
        setHistoryRow();
    }

    initializeDrive();

    // General Transactions End

    /*
    * Directory Transactions Start
    * */

    $(document).delegate('.directorySelector', 'click', function () {
        $('.fileSelector').attr('data-selected', false).removeClass('bg-light-dark');
        selectedFiles = [];
        var selectedDirectory = $(this);
        if (controlKeyPressStatus === true) {
            if ($(this).attr('data-selected') === 'true') {
                $(this).attr('data-selected', 'false');
                $(this).removeClass('bg-light-dark');
            } else {
                $(this).attr('data-selected', 'true');
                $(this).addClass('bg-light-dark');
            }
        } else {
            $.each($('.directorySelector'), function (i, directory) {
                if (selectedDirectory.attr('data-directory-id') !== $(directory).attr('data-directory-id')) {
                    $(directory).attr('data-selected', 'false');
                    $(directory).removeClass('bg-light-dark');
                }
            });
            if ($(this).attr('data-selected') === 'true') {
                $(this).attr('data-selected', 'false');
                $(this).removeClass('bg-light-dark');
            } else {
                $(this).attr('data-selected', 'true');
                $(this).addClass('bg-light-dark');
            }
        }

        selectedDirectories = [];
        $.each($('.directorySelector'), function (i, directory) {
            if ($(directory).attr('data-selected') === 'true') {
                selectedDirectories.push({
                    id: $(directory).attr('data-directory-id'),
                    name: $(directory).attr('data-directory-name')
                });
            }
        });
    });

    $(document).delegate('.directorySelector', 'dblclick', function () {
        $(".directoryTooltip").tooltip("hide");
        $(".fileTooltip").tooltip("hide");
        parentDirectoryId = $(this).attr('data-directory-id');
        directoryName = $(this).attr('data-directory-name');
        historyDirectoryList.push({
            id: parentDirectoryId,
            name: directoryName
        });
        initializeDrive();
    });

    homeDirectoryButton.click(function () {
        parentDirectoryId = null;
        historyDirectoryList = [];
        initializeDrive();
    });

    backDirectoryButton.click(function () {
        if (historyDirectoryList.length > 0) {
            historyDirectoryList.pop();
            parentDirectoryId = historyDirectoryList[historyDirectoryList.length - 1] ? historyDirectoryList[historyDirectoryList.length - 1].id : null;
            initializeDrive();
        }
    });

    // Directory Transactions End

    /**
     * File Transactions
     * */

    $(document).delegate('.fileSelector', 'click', function () {
        $('.directorySelector').attr('data-selected', false).removeClass('bg-light-dark');
        selectedDirectories = [];
        var selectedFile = $(this);
        if (controlKeyPressStatus === true) {
            if ($(this).attr('data-selected') === 'true') {
                $(this).attr('data-selected', 'false');
                $(this).removeClass('bg-light-dark');
            } else {
                $(this).attr('data-selected', 'true');
                $(this).addClass('bg-light-dark');
            }
        } else {
            $.each($('.fileSelector'), function (i, file) {
                if (selectedFile.attr('data-file-id') !== $(file).attr('data-file-id')) {
                    $(file).attr('data-selected', 'false');
                    $(file).removeClass('bg-light-dark');
                }
            });
            if ($(this).attr('data-selected') === 'true') {
                $(this).attr('data-selected', 'false');
                $(this).removeClass('bg-light-dark');
            } else {
                $(this).attr('data-selected', 'true');
                $(this).addClass('bg-light-dark');
            }
        }

        selectedFiles = [];
        $.each($('.fileSelector'), function (i, file) {
            if ($(file).attr('data-selected') === 'true') {
                selectedFiles.push({
                    id: $(file).attr('data-file-id'),
                    name: $(file).attr('data-file-name')
                });
            }
        });
    });

    // File Transactions End

    /**
     * Context Menu Transactions Start
     * */

    function uploadFileTransaction() {
        $('#UploadFileModal').modal('show');
    }

    function createDirectoryTransaction() {
        $('#create_directory_name').val('');
        $('#CreateDirectoryModal').modal('show');
    }

    function downloadTransaction() {
        toastr.info('İndirme İşlemi Henüz Yapılamamaktadır.');
    }

    function cutTransaction() {
        if (selectedDirectories.length > 0) {
            $('.fileSelector').attr('data-selected', false).removeClass('bg-light-dark').removeClass('bg-light-primary');
            cutFiles = [];
            cutDirectories = [];
            copiedFiles = [];
            copiedDirectories = [];
            $('.directorySelector').attr('data-selected', false).removeClass('bg-light-dark').removeClass('bg-light-primary');
            $.each(selectedDirectories, function (i, directory) {
                cutDirectories.push(directory);
                $(`#directory_${directory.id}`).addClass('bg-light-primary');
            });
            selectedDirectories = [];
            toastr.success(`Seçilen Klasör${cutDirectories.length > 1 ? `ler` : ``} Kesildi.`);
        } else if (selectedFiles.length > 0) {
            $('.directorySelector').attr('data-selected', false).removeClass('bg-light-dark').removeClass('bg-light-primary');
            cutFiles = [];
            cutDirectories = [];
            copiedFiles = [];
            copiedDirectories = [];
            $('.fileSelector').attr('data-selected', false).removeClass('bg-light-dark').removeClass('bg-light-primary');
            $.each(selectedFiles, function (i, file) {
                cutFiles.push(file);
                $(`#file_${file.id}`).addClass('bg-light-primary');
            });
            selectedFiles = [];
            toastr.success(`Seçilen Dosya${cutFiles.length > 1 ? `lar` : ``} Kesildi.`);
        } else {
            toastr.error('Kesilecek Dosya veya Klasör Seçiniz.');
        }
    }

    function copyTransaction() {
        if (selectedDirectories.length > 0) {
            toastr.warning('Klasör Kopyalama İşlemi Yapılmamaktadır!');
            // $('.fileSelector').attr('data-selected', false).removeClass('bg-light-dark').removeClass('bg-light-primary');
            // cutFiles = [];
            // cutDirectories = [];
            // copiedFiles = [];
            // copiedDirectories = [];
            // $('.directorySelector').attr('data-selected', false).removeClass('bg-light-dark').removeClass('bg-light-primary');
            // $.each(selectedDirectories, function (i, directory) {
            //     copiedDirectories.push(directory);
            //     $(`#directory_${directory.id}`).addClass('bg-light-primary');
            // });
            // selectedDirectories = [];
            // toastr.success(`Seçilen Klasör${copiedDirectories.length > 1 ? `ler` : ``} Kopyalandı.`);
        } else if (selectedFiles.length > 0) {
            $('.directorySelector').attr('data-selected', false).removeClass('bg-light-dark').removeClass('bg-light-primary');
            cutFiles = [];
            cutDirectories = [];
            copiedFiles = [];
            copiedDirectories = [];
            $('.fileSelector').attr('data-selected', false).removeClass('bg-light-dark').removeClass('bg-light-primary');
            $.each(selectedFiles, function (i, file) {
                copiedFiles.push(file);
                $(`#file_${file.id}`).addClass('bg-light-primary');
            });
            selectedFiles = [];
            toastr.success(`Seçilen Dosya${copiedFiles.length > 1 ? `lar` : ``} Kopyalandı.`);
        } else {
            toastr.error('Kopyalanacak Dosya veya Klasör Seçiniz.');
        }
    }

    function pasteTransaction() {
        if (cutDirectories.length > 0) {
            toastr.info('İşleminiz yapılıyor lütfen bekleyiniz...');
            $.ajax({
                type: 'put',
                url: '{{ route('user.api.directory.updateParentId') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: {
                    parentId: parentDirectoryId,
                    directoryIds: cutDirectories.map(directory => directory.id)
                },
                success: function () {
                    toastr.success('Klasör Taşıma İşleminiz Başarıyla Gerçekleştirildi.');
                    cutDirectories = [];
                    $('.directorySelector').removeClass('bg-light-primary');
                    getDirectoriesByParentId();
                },
                error: function (error) {
                    console.log(error);
                    if (parseInt(error.status) === 422) {
                        $.each(error.responseJSON.response, function (i, error) {
                            toastr.error(error[0]);
                        });
                    } else {
                        toastr.error(error.responseJSON.message);
                    }
                }
            });
        } else if (cutFiles.length  > 0) {
            toastr.info('İşleminiz yapılıyor lütfen bekleyiniz...');
            $.ajax({
                type: 'put',
                url: '{{ route('user.api.file.updateDirectoryId') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: {
                    directoryId: parentDirectoryId,
                    fileIds: cutFiles.map(file => file.id)
                },
                success: function () {
                    toastr.success('Dosya Taşıma İşleminiz Başarıyla Gerçekleştirildi.');
                    cutFiles = [];
                    $('.fileSelector').removeClass('bg-light-primary');
                    getFilesByDirectoryId();
                },
                error: function (error) {
                    console.log(error);
                    if (parseInt(error.status) === 422) {
                        $.each(error.responseJSON.response, function (i, error) {
                            toastr.error(error[0]);
                        });
                    } else {
                        toastr.error(error.responseJSON.message);
                    }
                }
            });
        } else {
            toastr.warning('Kopyalama Sistemi Henüz Aktif Değil ve Kesilmiş Dosya veya Klasör Bulunmamaktadır.');
        }
    }

    function renameTransaction() {
        if (selectedDirectories.length > 0) {
            $('#rename_directory_name').val($(`#directory_${selectedDirectories[0].id}`).attr('data-directory-name'));
            $('#RenameDirectoryModal').modal('show');
        } else if (selectedFiles.length > 0) {
            $('#rename_file_name').val($(`#file_${selectedFiles[0].id}`).attr('data-file-name'));
            $('#RenameFileModal').modal('show');
        } else {
            toastr.error('Yeniden Adlandırılacak Dosya veya Klasör Seçiniz.');
        }
    }

    function deleteTransaction() {
        if (selectedDirectories.length > 0) {
            $('#DeleteDirectoryModal').modal('show');
        } else if (selectedFiles.length > 0) {
            $('#DeleteFileModal').modal('show');
        } else {
            toastr.error('Silinicek Dosya veya Klasör Seçiniz.');
        }
    }

    function propertiesTransaction() {
        toastr.info('Özellikler İşlemi Henüz Yapılamamaktadır.');
    }

    CreateDirectoryButton.click(function () {
        var parentId = parentDirectoryId;
        var companyId = SelectedCompany.val();
        var name = $('#create_directory_name').val();

        if (!name) {
            toastr.warning('Klasör Adı Boş Olamaz.');
        } else {
            CreateDirectoryButton.attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            $.ajax({
                type: 'post',
                url: '{{ route('user.api.directory.create') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: {
                    parentId: parentId,
                    companyId: companyId,
                    name: name
                },
                success: function () {
                    CreateDirectoryButton.attr('disabled', false).html('Oluştur');
                    toastr.success('Klasör Oluşturuldu.');
                    $('#CreateDirectoryModal').modal('hide');
                    getDirectoriesByParentId();
                },
                error: function (error) {
                    console.log(error);
                    CreateDirectoryButton.attr('disabled', false).html('Oluştur');
                    if (parseInt(error.status) === 422) {
                        $.each(error.responseJSON.response, function (i, error) {
                            toastr.error(error[0]);
                        });
                    } else {
                        toastr.error(error.responseJSON.message);
                    }
                }
            });
        }
    });

    RenameDirectoryButton.click(function () {
        var id = selectedDirectories[0].id;
        var name = $('#rename_directory_name').val();

        if (!name) {
            toastr.warning('Klasör Adı Boş Olamaz.');
        } else {
            RenameDirectoryButton.attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            $.ajax({
                type: 'put',
                url: '{{ route('user.api.directory.rename') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: {
                    id: id,
                    name: name
                },
                success: function () {
                    $('#RenameDirectoryModal').modal('hide');
                    toastr.success('Klasör Başarıyla Yeniden Adlandırıldı.');
                    RenameDirectoryButton.attr('disabled', false).html('Güncelle');
                    getDirectoriesByParentId();
                },
                error: function (error) {
                    RenameDirectoryButton.attr('disabled', false).html('Güncelle');
                    console.log(error);
                    if (parseInt(error.status) === 422) {
                        $.each(error.responseJSON.response, function (i, error) {
                            toastr.error(error[0]);
                        });
                    } else {
                        toastr.error(error.responseJSON.message);
                    }
                }
            });
        }
    });

    DeleteDirectoryButton.click(function () {
        DeleteDirectoryButton.attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
        $.ajax({
            type: 'delete',
            url: '{{ route('user.api.directory.deleteBatch') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                directoryIds: selectedDirectories.map(directory => directory.id)
            },
            success: function () {
                DeleteDirectoryButton.attr('disabled', false).html('Sil');
                $('#DeleteDirectoryModal').modal('hide');
                toastr.success('Klasörler Başarıyla Silindi.');
                getDirectoriesByParentId();
            },
            error: function (error) {
                DeleteDirectoryButton.attr('disabled', false).html('Sil');
                console.log(error);
                if (parseInt(error.status) === 422) {
                    $.each(error.responseJSON.response, function (i, error) {
                        toastr.error(error[0]);
                    });
                } else {
                    toastr.error(error.responseJSON.message);
                }
            }
        });
    });

    DeleteFileButton.click(function () {
        DeleteFileButton.attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
        $.ajax({
            type: 'delete',
            url: '{{ route('user.api.file.deleteBatch') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                fileIds: selectedFiles.map(file => file.id)
            },
            success: function () {
                DeleteFileButton.attr('disabled', false).html('Sil');
                $('#DeleteFileModal').modal('hide');
                toastr.success('Dosyalar Başarıyla Silindi.');
                getFilesByDirectoryId();
            },
            error: function (error) {
                DeleteFileButton.attr('disabled', false).html('Sil');
                console.log(error);
                if (parseInt(error.status) === 422) {
                    $.each(error.responseJSON.response, function (i, error) {
                        toastr.error(error[0]);
                    });
                } else {
                    toastr.error(error.responseJSON.message);
                }
            }
        });
    });

    UploadFileButton.click(function () {
        var file = $('#upload_file').prop('files')[0];
        var filePath = 'directory_id_' + parentDirectoryId + '/';

        if (!file) {
            toastr.warning('Dosya Seçmediniz!');
        } else {
            UploadFileButton.attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            var data = new FormData();
            data.append('file', file);
            data.append('filePath', filePath);

            $.ajax({
                contentType: false,
                processData: false,
                type: 'post',
                url: '{{ route('user.api.file.upload') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: data,
                success: function () {
                    toastr.success('Dosya Başarıyla Yüklendi');
                    UploadFileButton.attr('disabled', false).html('Yükle');
                    $('#UploadFileModal').modal('hide');
                    getFilesByDirectoryId();
                },
                error: function (error) {
                    console.log(error);
                    UploadFileButton.attr('disabled', false).html('Yükle');
                    if (parseInt(error.status) === 422) {
                        $.each(error.responseJSON.response, function (i, error) {
                            toastr.error(error[0]);
                        });
                    } else {
                        toastr.error(error.responseJSON.message);
                    }
                }
            });
        }
    });

    // Context Menu Transactions End

    $('body').on('contextmenu', function (e) {
        if (detectMobile()) {
            return false;
        } else {
            var top = e.pageY - 10;
            var left = e.pageX - 10;

            if (selectedDirectories.length > 0 || selectedFiles.length > 0) {
                downloadTransactionDiv.show();
                cutTransactionDiv.show();
                copyTransactionDiv.show();
                deleteTransactionDiv.show();
                if (selectedDirectories.length > 1 || selectedFiles.length > 1) {
                    renameTransactionDiv.hide();
                    propertiesTransactionDiv.hide();
                } else {
                    renameTransactionDiv.show();
                    propertiesTransactionDiv.show();
                }
            } else {
                downloadTransactionDiv.hide();
                cutTransactionDiv.hide();
                copyTransactionDiv.hide();
                deleteTransactionDiv.hide();
                renameTransactionDiv.hide();
                propertiesTransactionDiv.hide();
            }

            if (
                copiedDirectories.length > 0 ||
                copiedFiles.length > 0 ||
                cutDirectories.length > 0 ||
                cutFiles.length > 0
            ) {
                pasteTransactionDiv.show();
            } else {
                pasteTransactionDiv.hide();
            }

            contextMenuSelector.css({
                display: "block",
                top: top,
                left: left
            });

            return false;
        }
    }).on("click", function () {
        contextMenuSelector.hide();
    }).on('focusout', function () {
        contextMenuSelector.hide();
    });

    driveMain.click(function () {
        if (!controlKeyPressStatus) {
            selectedDirectories = [];
            selectedFiles = [];
            $('.directorySelector').attr('data-selected', 'false').removeClass('bg-light-dark');
            $('.fileSelector').attr('data-selected', 'false').removeClass('bg-light-dark');
        }
    });

</script>
