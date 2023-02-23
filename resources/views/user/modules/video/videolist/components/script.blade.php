<script src="{{ asset('assets/jqwidgets/jqxcore.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxbuttons.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxscrollbar.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxlistbox.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxdropdownlist.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxmenu.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxgrid.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxgrid.selection.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxgrid.columnsreorder.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxgrid.columnsresize.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxgrid.filter.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxgrid.sort.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxdata.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxgrid.pager.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxnumberinput.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxwindow.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxdata.export.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxgrid.export.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxexport.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxgrid.grouping.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/globalization/globalize.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqgrid-localization.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jszip.min.js') }}"></script>

<script>


    var videoListDiv = $('#videoListDiv');
    var TransactionsModal = $('#TransactionsModal');
    var UpdateVideoModal = $('#updateVideoModal');
    var createVideoModal = $('#createVideoModal');
    var selectedVideoId;
    var addVideoBtn = $('#addVideoBtn');
    $(document).ready(function () {
        $('#loader').hide();
    });




    function getAllVideos() {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.video.getAll') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            success: function (response) {
                var videoList = [];
                $.each(response.response, function (i, video) {
                    videoList.push({
                        id: video.id,
                        name: video.name,
                        url:video.url
                    });
                });

                var source = {
                    localdata: videoList,
                    datatype: "array",
                    datafields: [
                        {name: 'id', type: 'integer'},
                        {name: 'name', type: 'string'},
                        {name: 'url', type: 'string'},
                    ]
                };
                var dataAdapter = new $.jqx.dataAdapter(source);
                videoListDiv.jqxGrid({
                    width: '100%',
                    height: '600',
                    source: dataAdapter,
                    columnsresize: true,
                    groupable: true,
                    theme: jqxGridGlobalTheme,
                    filterable: true,
                    showfilterrow: true,
                    pageable: false,
                    sortable: true,
                    pagesizeoptions: ['10', '20', '50', '1000'],
                    localization: getLocalization('tr'),
                    columns: [
                        {
                            text: '#',
                            dataField: 'id',
                            columntype: 'textbox',
                        },
                        {
                            text: 'Adı',
                            dataField: 'name',
                            columntype: 'textbox',
                        },
                        {
                            text: 'URL',
                            dataField: 'url',
                            columntype: 'textbox',
                        },
                    ],
                });
                videoListDiv.on('rowclick', function (event) {
                    videoListDiv.jqxGrid('selectrow', event.args.rowindex);
                    var rowindex = videoListDiv.jqxGrid('getselectedrowindex');
                    var dataRecord = videoListDiv.jqxGrid('getrowdata', rowindex);
                    selectedVideoId = dataRecord.id
                    return false;
                });
                videoListDiv.jqxGrid('sortby', 'id', 'desc');

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

    function editVideo(){
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.video.getById') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id:selectedVideoId
            },
            success: function (response) {
                $('#update_video_name').val(response.response.name);
                $('#update_video_url').val(response.response.url);
                TransactionsModal.modal('hide');
                UpdateVideoModal.modal('show');


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

    function deleteVideo(){
        $.ajax({
            type: 'delete',
            url: '{{ route('user.api.video.delete') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id:selectedVideoId
            },
            success: function (response) {
                TransactionsModal.modal('hide');
                toastr.success('Video silindi!')
                getAllVideos()
                selectedVideoId = null;

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


    function updateVideo(){
        $.ajax({
            type: 'put',
            url: '{{ route('user.api.video.update') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id:selectedVideoId,
                name: $('#update_video_name').val(),
                url: $('#update_video_url').val(),
            },
            success: function (response) {
                UpdateVideoModal.modal('hide');
              toastr.success('Video güncellendi!')
                $('#update_video_name').val('');
                $('#update_video_url').val('');
                selectedVideoId = null;
                getAllVideos();

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

    function createVideo(){
        var name = $('#video_name').val();
        var url = $('#video_url').val();

        if (!name) {
            toastr.warning('Lütfen video başlığı giriniz!');
        } else if (!url) {
            toastr.warning('Lütfen video url giriniz!');
        }  else {
            $.ajax({
                type: 'post',
                url: '{{ route('user.api.video.create') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: {
                    name: name,
                    url: url
                },
                success: function (response) {
                    createVideoModal.modal('hide');
                    toastr.success('Video eklendi!')
                    $('#video_name').val('');
                    $('#video_url').val('');
                    selectedVideoId = null;
                    getAllVideos();

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
    }



    addVideoBtn.click(function () {
        createVideoModal.modal('show')
    });


    $('body').on('contextmenu', function () {
       if(selectedVideoId == null){
           toastr.error('Lütfen video seçiniz');
       }else{
           TransactionsModal.modal('show');
       }
        return false;
    });



</script>
