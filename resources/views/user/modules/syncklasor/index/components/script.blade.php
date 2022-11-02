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

    var backSyncklasorButton = $('#backSyncklasorButton');
    var homeSyncklasorButton = $('#homeSyncklasorButton');

    /**
     * Transaction Variables Start
     * */

    var parentSyncklasorId = null;

    var selectedSyncKlasorler = [];
    var selectedFiles = [];

    var copiedDirectories = [];
    var copiedFiles = [];

    var cutDirectories = [];
    var cutFiles = [];

    var historySyncklasorList = [];

    // Transaction Variables End

    var driveMain = $('#driveMain');
    var filesRow = $('#filesRow');
    var devicesRow = $('#devicesRow');
    var historyRow = $('#historyRow');

    var devicesArea = $('#devicesArea');
    var filesArea = $('#filesArea');

    function getFilesBySyncklasorId() {
        if (parentSyncklasorId != null) {
            devicesArea.hide();
            filesArea.show();
            filesRow.empty().html(`
            <div class="col-xl-12 text-center mb-5">
                <i class="fa fa-spinner fa-spin"></i>
            </div>
            `);
            $.ajax({
                type: 'get',
                url: '{{ route('user.api.syncdosyahareket.getBySunucuKlasorId') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: {
                    sunucuKlasorId: parentSyncklasorId,
                },
                success: function (response) {
                    console.log(response);
                    filesRow.empty();
                    $.each(response.response, function (i, syncDosyaHareket) {
                        filesRow.append(`
                        <div class="col-xl-2 mb-5">
                            <div class="card h-100 flex-center text-center py-4 px-0 cursor-pointer border border-secondary bg-hover-light-dark" style="border-radius: 10px">
                                <i class="fas fa-file fa-lg mt-2 mb-5"></i>
                                <span class="font-weight-bolder text-dark-75 mb-1 fileTooltip" data-bs-toggle="tooltip" data-bs-placement="bottom" title="${syncDosyaHareket.DOSYAADI}">${syncDosyaHareket.DOSYAADI.length > 24 ? `${syncDosyaHareket.DOSYAADI.substring(0,21)}...` : syncDosyaHareket.DOSYAADI}</span>
                                <span class="font-weight-bolder text-dark-75 mb-1 fileTooltip" data-bs-toggle="tooltip" data-bs-placement="bottom" title="${syncDosyaHareket.YERELDOSYAYOLU}">${syncDosyaHareket.YERELDOSYAYOLU.length > 24 ? `${syncDosyaHareket.YERELDOSYAYOLU.substring(0,21)}...` : syncDosyaHareket.YERELDOSYAYOLU}</span>
                                <div class="fs-7 fw-bold text-gray-400 mt-auto mb-1">${syncDosyaHareket.DOSYABOYUTU} MB</div>
                                <span class="fs-7 fw-bold text-gray-600 mt-auto mb-1">${reformatDatetimeToDatetimeForHuman(syncDosyaHareket.KAYITTARIHI)}</span>
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
    }

    function getSyncklasorlerByCompanyId() {
        devicesArea.show();
        filesArea.hide();
        devicesRow.empty().html(`
        <div class="col-xl-12 text-center mb-5">
            <i class="fa fa-spinner fa-spin"></i>
        </div>
        `);
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.syncklasorler.getByCompanyId') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                companyId: SelectedCompany.val()
            },
            success: function (response) {
                devicesRow.empty();
                $.each(response.response, function (i, syncklasor) {
                    devicesRow.append(`
                    <div class="col-xl-2">
                        <div class="d-flex align-items-center bg-hover-light-dark border border-secondary rounded p-3 mb-7 syncklasorSelector" data-selected="false" data-syncklasor-name="${syncklasor.KAYNAKBILGISAYARADI}" data-syncklasor-id="${syncklasor.ID}" id="syncklasor_${syncklasor.ID}">
                            <span class="svg-icon svg-icon-warning me-5">
                                <span class="svg-icon svg-icon-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path opacity="0.3" d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z" fill="black"/>
                                        <path d="M9.2 3H3C2.4 3 2 3.4 2 4V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V7C22 6.4 21.6 6 21 6H12L10.4 3.60001C10.2 3.20001 9.7 3 9.2 3Z" fill="black"/>
                                    </svg>
                                </span>
                            </span>
                            <div class="flex-grow-1 me-2">
                                <span class="fw-bolder text-gray-800 fs-6 disable-select">${syncklasor.KAYNAKBILGISAYARADI.length > 15 ? `${syncklasor.KAYNAKBILGISAYARADI.substring(0, 12)}...` : syncklasor.KAYNAKBILGISAYARADI}</span>
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

    function setHistoryRow() {

    }

    getSyncklasorlerByCompanyId();

    /*
    * Syncklasor Transactions Start
    * */

    $(document).delegate('.syncklasorSelector', 'click', function () {
        var selectedSyncklasor = $(this);
        if (controlKeyPressStatus === true) {
            if ($(this).attr('data-selected') === 'true') {
                $(this).attr('data-selected', 'false');
                $(this).removeClass('bg-light-dark');
            } else {
                $(this).attr('data-selected', 'true');
                $(this).addClass('bg-light-dark');
            }
        } else {
            $.each($('.syncklasorSelector'), function (i, directory) {
                if (selectedSyncklasor.attr('data-syncklasor-id') !== $(directory).attr('data-syncklasor-id')) {
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

        selectedSyncKlasorler = [];
        $.each($('.syncklasorSelector'), function (i, directory) {
            if ($(directory).attr('data-selected') === 'true') {
                selectedSyncKlasorler.push($(directory).attr('data-syncklasor-id'));
            }
        });
    });

    $(document).delegate('.syncklasorSelector', 'dblclick', function () {
        parentSyncklasorId = $(this).attr('data-syncklasor-id');
        deviceName = $(this).attr('data-syncklasor-name');
        historyRow.empty().append(`<span class="fw-bolder fs-5 ms-5">${deviceName}</span> >`);
        getFilesBySyncklasorId();
    });

    homeSyncklasorButton.click(function () {
        parentSyncklasorId = null;
        historySyncklasorList = [];
        historyRow.empty();
        getSyncklasorlerByCompanyId();
    });

    devicesRow.click(function () {
        if (!controlKeyPressStatus) {
            $('.syncklasorSelector').attr('data-selected', 'false').removeClass('bg-light-dark');
        }
    });

    function openSyncklasor(directoryId) {
        console.log(directoryId);
    }

    function downloadSyncklasor(directoryId) {
        console.log(directoryId);
    }

    function cutSyncklasor(directoryId) {
        console.log(directoryId);
    }

    function copySyncklasor(directoryId) {
        console.log(directoryId);
    }

    function pasteSyncklasor(directoryId) {
        console.log(directoryId);
    }

    function shareSyncklasor(directoryId) {
        console.log(directoryId);
    }

    function renameSyncklasor(directoryId) {
        console.log(directoryId);
    }

    function createShortcutSyncklasor(directoryId) {
        console.log(directoryId);
    }

    function directoryHistory(directoryId) {
        console.log(directoryId);
    }

    function deleteSyncklasor(directoryId) {
        console.log(directoryId);
    }

    function forceDeleteSyncklasor(directoryId) {
        console.log(directoryId);
    }

    function directoryInfo(directoryId) {
        console.log(directoryId);
    }

    // Syncklasor Transactions End

    /**
     * File Transactions
     * */



    // File Transactions End

</script>
