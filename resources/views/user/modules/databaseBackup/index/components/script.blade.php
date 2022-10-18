<script>

    $(document).ready(function () {
        $('#loader').hide();
    });

    var filesRow = $('#filesRow');
    var fileUploader = $('#fileUploadArea');
    var fileSelector = $('#fileSelector');

    function getFilesByRelation() {
        $.ajax({
            type: 'get',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            url: '{{ route('user.api.file.getDatabaseBackups') }}',
            data: {
                relationId: authUserId,
                relationType: 'App\\Models\\Eloquent\\User'
            },
            success: function (response) {
                var fileUploadSvg = `{{ asset('assets/media/svg/files/upload.svg') }}`;
                var fileSvg = `{{ asset('assets/media/icons/duotune/files/fil003.svg') }}`;
                filesRow.empty().append(`
                <div class="col-xl-2 mb-5">
                    <div class="card h-100 flex-center border-dashed p-8 cursor-pointer" id="fileUploadArea">
                        <img src="${fileUploadSvg}" class="mb-8" alt="" />
                        <a class="font-weight-bolder text-dark-75 mb-2">Yeni Dosya</a>
                        <div class="fs-7 fw-bold text-gray-400 mt-auto">Yüklemek İçin Tıklayın</div>
                    </div>
                </div>
                `);
                $.each(response.response, function (i, file) {
                    filesRow.append(`
                    <div class="col-xl-2 mb-5">
                        <div class="card h-100 flex-center text-center border-dashed p-8 cursor-pointer" onclick="showFile(${file.id})" data-id="${file.id}" id="file_${file.id}">
                            <i class="fas fa-database fa-4x mb-12"></i>
                            <a class="font-weight-bolder text-dark-75 mb-1">${file.name}</a>
                            <div class="fs-7 fw-bold text-gray-400 mt-auto mb-1">${formatBytes(file.file_size)}</div>
                            <span class="fs-7 fw-bold text-gray-600 mt-auto mb-1">${reformatDatetimeToDatetimeForHuman(file.created_at)}</span>
                        </div>
                    </div>
                    `);
                });
            },
            error: function (error) {
                console.log(error);
                toastr.error('Dosyalar Alınırken Serviste Bir Sorun Oluştu.');
            }
        });
    }

    getFilesByRelation();

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
                getFilesByRelation();
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

</script>
