<script>

    $(document).ready(function () {
        $('#loader').hide();
    });

    var videosRow = $('#videosRow');
    var TransactionsModal = $('#TransactionsModal');

    function getAllVideos() {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.video.getAll') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {},
            success: function (response) {
                videosRow.empty();
                $.each(response.response, function (i, video) {
                    videosRow.append(`
                     <div class="col-xl-3 col-12 videoCard">
                        <div class="card mb-5 mb-xl-8">
                            <div class="card-body">
                                 <div class="mb-5 text-center">
                                     <div class="embed-responsive embed-responsive-21by9">
                                         <iframe width="380" height="315" src="${video.url}"> </iframe>
                                     </div>
                                     <br>
                                     <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bolder mb-1">${video.name}</a>
                                     </div>
                                  </div>
                             </div>
                        </div>
                    `)
                });
            },
            error: function (error) {
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

