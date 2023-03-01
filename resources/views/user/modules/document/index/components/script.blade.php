<script>

    $(document).ready(function () {
        $('#loader').hide();
    });

    var videosRow = $('#videosRow');
    var TransactionsModal = $('#TransactionsModal');

    function getAllVideos() {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.document.getAll') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {},
            success: function (response) {
                var baseurl = window.location.origin+ '/'

                videosRow.empty();
                $.each(response.response, function (i, video) {
                    videosRow.append(`
                     <div class="col-xl-3 col-12 videoCard">
                        <div class="card mb-5 mb-xl-8">
                            <div class="card-body">
                                <a href="${baseurl+video.path}">
                                    <div class="card h-100 flex-center text-center py-4 px-0 cursor-pointer border border-secondary bg-hover-light-dark fileSelector fileTooltip" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-file-id="1" data-file-name="Backup.sql" id="file_1" style="border-radius: 10px" data-bs-original-title="${video.name}">
                                    <i class="fas fa-file fa-lg mt-2 mb-5"></i>
                                    <span class="font-weight-bolder text-dark-75 mb-1">${video.name}</span>
                                    <span class="fs-7 fw-bold text-gray-600 mt-auto mb-1">${moment(new Date(video.created_at)).format('DD/MM/YYYY')}</span>
                                </div>
                                </a>
                           </div>
                        </div>
                    </div>
                    `)
                });
            },
            error: function () {
                if (parseInt(error.status) === 404) {
                    toastr.error('Video Bulunamadı!');
                } else {
                    toastr.error('Video Getirilemedi!');
                }
            }
        });
    }

    getAllVideos();


    $('body').on('contextmenu', function () {
        TransactionsModal.modal('show');
        return false;
    });
</script>
