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
    var historyRow = $('#historyRow');

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
                        <div class="d-flex align-items-center bg-hover-light-dark border border-secondary rounded p-3 mb-7 directorySelector" data-selected="false" data-directory-name="${directory.name}" data-directory-id="${directory.id}" id="directory_${directory.id}">
                            <span class="svg-icon svg-icon-warning me-5">
                                <span class="svg-icon svg-icon-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path opacity="0.3" d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z" fill="black"/>
                                        <path d="M9.2 3H3C2.4 3 2 3.4 2 4V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V7C22 6.4 21.6 6 21 6H12L10.4 3.60001C10.2 3.20001 9.7 3 9.2 3Z" fill="black"/>
                                    </svg>
                                </span>
                            </span>
                            <div class="flex-grow-1 me-2">
                                <span class="fw-bolder text-gray-800 fs-6 disable-select">${directory.name.length > 15 ? `${directory.name.substring(0, 12)}...` : directory.name}</span>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-icon bg-transparent btn-secondary fw-bolder text-warning p-0" data-bs-toggle="dropdown" id="dropdownMenuButton1" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-item">
                                        <i class="fas fa-folder-open"></i>
                                        <span>Aç</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    `);
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
                        <div class="card h-100 flex-center text-center py-4 px-0 cursor-pointer border border-secondary bg-hover-light-dark" style="border-radius: 10px">
                            <i class="fas fa-file fa-lg mt-2 mb-5"></i>
                            <span class="font-weight-bolder text-dark-75 mb-1">${file.name}</span>
                            <div class="fs-7 fw-bold text-gray-400 mt-auto mb-1">${formatBytes(file.file_size)}</div>
                            <span class="fs-7 fw-bold text-gray-600 mt-auto mb-1">${reformatDatetimeToDatetimeForHuman(file.created_at)}</span>
                        </div>
                    </div>
                    `);
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

    /*
    * Directory Transactions Start
    * */

    $(document).delegate('.directorySelector', 'click', function () {
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
                selectedDirectories.push($(directory).attr('data-directory-id'));
            }
        });
    });

    $(document).delegate('.directorySelector', 'dblclick', function () {
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

    directoriesRow.click(function () {
        if (!controlKeyPressStatus) {
            $('.directorySelector').attr('data-selected', 'false').removeClass('bg-light-dark');
        }
    });

    function openDirectory(directoryId) {
        console.log(directoryId);
    }

    function downloadDirectory(directoryId) {
        console.log(directoryId);
    }

    function cutDirectory(directoryId) {
        console.log(directoryId);
    }

    function copyDirectory(directoryId) {
        console.log(directoryId);
    }

    function pasteDirectory(directoryId) {
        console.log(directoryId);
    }

    function shareDirectory(directoryId) {
        console.log(directoryId);
    }

    function renameDirectory(directoryId) {
        console.log(directoryId);
    }

    function createShortcutDirectory(directoryId) {
        console.log(directoryId);
    }

    function directoryHistory(directoryId) {
        console.log(directoryId);
    }

    function deleteDirectory(directoryId) {
        console.log(directoryId);
    }

    function forceDeleteDirectory(directoryId) {
        console.log(directoryId);
    }

    function directoryInfo(directoryId) {
        console.log(directoryId);
    }

    // Directory Transactions End

    /**
     * File Transactions
     * */



    // File Transactions End

</script>
