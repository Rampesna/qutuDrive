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

    /**
     * Transaction Variables Start
     * */

    var selectedDirectories = [];
    var selectedFiles = [];

    // Transaction Variables End

    var driveMain = $('#driveMain');
    var directoriesRow = $('#directoriesRow');
    var filesRow = $('#filesRow');

    var RecoverDirectoryButton = $('#RecoverDirectoryButton');
    var RecoverFileButton = $('#RecoverFileButton');

    var contextMenuSelector = $('#contextMenu');

    var recoverTransactionDiv = $('#recoverTransactionDiv');

    function getTrashedDirectories() {
        directoriesRow.empty().html(`
        <div class="col-xl-12 text-center mb-5">
            <i class="fa fa-spinner fa-spin"></i>
        </div>
        `);
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.directory.getTrashed') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                companyId: SelectedCompany.val(),
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

    function getTrashedFiles() {
        filesRow.empty().html(`
        <div class="col-xl-12 text-center mb-5">
            <i class="fa fa-spinner fa-spin"></i>
        </div>
        `);
        var relationType = 'App\\Models\\Eloquent\\Firmalar';
        var relationId = SelectedCompany.val();
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.file.getTrashedByRelation') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                relationType: relationType,
                relationId: relationId
            },
            success: function (response) {
                console.log(response);
                filesRow.empty();
                $.each(response.response, function (i, file) {
                    filesRow.append(`
                    <div class="col-xl-2 mb-5">
                        <div class="card h-100 flex-center text-center py-4 px-0 cursor-pointer border border-secondary bg-hover-light-dark fileSelector fileTooltip" data-bs-toggle="tooltip" data-bs-placement="bottom" title="${file.name}" data-file-id="${file.id}" data-file-name="${file.name}" id="file_${file.id}" style="border-radius: 10px">
                            <i class="fas fa-file fa-lg mt-2 mb-5"></i>
                            <span class="font-weight-bolder text-dark-75 mb-1">${file.name.length > 19 ? `${file.name.substring(0, 16)}...` : file.name}</span>
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

    function initializeDrive() {
        getTrashedDirectories();
        getTrashedFiles();
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

    // Context Menu Transactions End

    $('body').on('contextmenu', function (e) {
        if (detectMobile()) {
            return false;
        } else {
            var top = e.pageY - 10;
            var left = e.pageX - 10;

            if (selectedDirectories.length > 0 || selectedFiles.length > 0) {
                contextMenuSelector.css({
                    display: "block",
                    top: top,
                    left: left
                });

                recoverTransactionDiv.show();
            } else {
                recoverTransactionDiv.hide();
            }

            return false;
        }
    }).on("click", function () {
        contextMenuSelector.hide();
    }).on('focusout', function () {
        contextMenuSelector.hide();
    });

    function recoverTransaction() {
        if (selectedDirectories.length > 0) {
            $('#RecoverDirectoryModal').modal('show');
        } else if (selectedFiles.length > 0) {
            $('#RecoverFileModal').modal('show');
        } else {
            toastr.warning('Hiç Dosya veya Klasör Seçmediniz!');
        }
    }

    driveMain.click(function () {
        if (!controlKeyPressStatus) {
            selectedDirectories = [];
            selectedFiles = [];
            $('.directorySelector').attr('data-selected', 'false').removeClass('bg-light-dark');
            $('.fileSelector').attr('data-selected', 'false').removeClass('bg-light-dark');
        }
    });

    RecoverDirectoryButton.click(function () {
        RecoverDirectoryButton.attr('disabled', true).html(`<i class="fa fa-spinner fa-spin"></i>`);
        $.ajax({
            type: 'post',
            url: '{{ route('user.api.directory.recover') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                directoryIds: selectedDirectories.map(directory => directory.id)
            },
            success: function () {
                toastr.success('Klasörler Başarıyla Kurtarıldı!');
                getTrashedDirectories();
                $('#RecoverDirectoryModal').modal('hide');
                RecoverDirectoryButton.attr('disabled', false).html('Kurtar');
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
    });

    RecoverFileButton.click(function () {
        RecoverFileButton.attr('disabled', true).html(`<i class="fa fa-spinner fa-spin"></i>`);
        $.ajax({
            type: 'post',
            url: '{{ route('user.api.file.recover') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                fileIds: selectedFiles.map(file => file.id)
            },
            success: function () {
                toastr.success('Dosyalar Başarıyla Kurtarıldı!');
                getTrashedFiles();
                $('#RecoverFileModal').modal('hide');
                RecoverFileButton.attr('disabled', false).html('Kurtar');
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
    });

</script>
