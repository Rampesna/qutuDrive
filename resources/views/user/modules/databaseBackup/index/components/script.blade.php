<script>

    $(document).ready(function () {
        $('#loader').hide();
    });

    var filesRow = $('#filesRow');
    var fileUploader = $('#fileUploadArea');
    var fileSelector = $('#fileSelector');
    var keywordInput = $('#keyword');

    var FilterButton = $('#FilterButton');

    function getBackupDosyalarByCompanyId() {
        var keyword = keywordInput.val();
        $.ajax({
            type: 'get',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            url: '{{ route('user.api.backupdosyalar.getByCompanyId') }}',
            data: {
                companyId: SelectedCompany.val(),
                keyword: keyword,
            },
            success: function (response) {
                var fileUploadSvg = `{{ asset('assets/media/svg/files/upload.svg') }}`;
                var fileSvg = `{{ asset('assets/media/icons/duotune/files/fil003.svg') }}`;

                var newFileTitle = '{{ __('user/modules/databaseBackup.index.newFile.title') }}';
                var newFileClickForUpload = '{{ __('user/modules/databaseBackup.index.newFile.clickForUpload') }}';

                filesRow.empty().append(`
                <div class="col-xl-2 mb-5">
                    <div class="card h-100 flex-center border-dashed p-8 cursor-pointer" id="fileUploadArea">
                        <img src="${fileUploadSvg}" class="mb-8" alt="" />
                        <a class="font-weight-bolder text-dark-75 mb-2">${newFileTitle}</a>
                        <div class="fs-7 fw-bold text-gray-400 mt-auto">${newFileClickForUpload}</div>
                    </div>
                </div>
                `);
                $.each(response.response, function (i, backupDosya) {
                    filesRow.append(`
                    <div class="col-xl-2 mb-5">
                        <div class="card h-100 flex-center text-center border-dashed p-8 cursor-pointer backupDosya" data-id="${backupDosya.ID}" id="backupDosya_${backupDosya.ID}">
                            <i class="fas fa-database fa-4x mb-12"></i>
                            <a class="font-weight-bolder text-dark-75 mb-1">${backupDosya.DOSYAADI.length > 21 ? `${backupDosya.DOSYAADI.substring(0,18)}...` : backupDosya.DOSYAADI}</a>
                            <div class="fs-7 fw-bold text-gray-400 mt-auto mb-1">${backupDosya.DOSYABOYUTU} MB</div>
                            <span class="fs-7 fw-bold text-gray-600 mt-auto mb-1">${reformatDatetimeToDatetimeForHuman(backupDosya.BACKUPOLUSMATARIHI)}</span>
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

    getBackupDosyalarByCompanyId();

    function uploadFile(data) {
        toastr.info('Dosya Yükleniyor...');
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
                toastr.success('Dosya Yüklendi');
                getBackupDosyalarByCompanyId();
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

    $(document).delegate('#fileUploadArea', 'click', function () {
        fileSelector.click();
    });

    fileSelector.change(function () {
        var data = new FormData();
        data.append('typeId', 2);
        data.append('file', fileSelector[0].files[0]);
        data.append('filePath', `qutuDrive/uploads/user/${authUserId}/files/`);
        uploadFile(data);
    });

    FilterButton.click(function () {
        getBackupDosyalarByCompanyId();
    });

    keywordInput.keyup(function (e) {
        if (parseInt(e.keyCode) === 13) {
            getBackupDosyalarByCompanyId();
        }
    });

</script>
