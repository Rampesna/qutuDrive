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


    var documentListDiv = $('#documentListDiv');
    var TransactionsModal = $('#TransactionsModal');
    var UpdateVideoModal = $('#updateVideoModal');
    var createVideoModal = $('#createVideoModal');
    var selectedDocumentId;
    var addVideoBtn = $('#addVideoBtn');
    $(document).ready(function () {
        $('#loader').hide();
    });


    function getAllDocument() {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.document.getAll') }}',
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
                        path: video.path
                    });
                });

                var source = {
                    localdata: videoList,
                    datatype: "array",
                    datafields: [
                        {name: 'id', type: 'integer'},
                        {name: 'name', type: 'string'},
                        {name: 'path', type: 'string'},
                    ]
                };
                var dataAdapter = new $.jqx.dataAdapter(source);
                documentListDiv.jqxGrid({
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
                            text: 'Dosya Yolu',
                            dataField: 'path',
                            columntype: 'textbox',
                        },
                    ],
                });
                documentListDiv.on('rowclick', function (event) {
                    documentListDiv.jqxGrid('selectrow', event.args.rowindex);
                    var rowindex = documentListDiv.jqxGrid('getselectedrowindex');
                    var dataRecord = documentListDiv.jqxGrid('getrowdata', rowindex);
                    selectedDocumentId = dataRecord.id
                    return false;
                });
                documentListDiv.jqxGrid('sortby', 'id', 'desc');

            },
            error: function (error) {
                if (parseInt(error.status) === 404) {
                    toastr.error('Döküman Bulunamadı!');
                } else {
                    toastr.error('Döküman Getirilemedi!');
                }
            }
        });
    }

    getAllDocument();

    function editDocument() {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.document.getById') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: selectedDocumentId
            },
            success: function (response) {
                $('#update_name').val(response.response.name);
                TransactionsModal.modal('hide');
                UpdateVideoModal.modal('show');


            },
            error: function () {
                if (parseInt(error.status) === 404) {
                    toastr.error('Döküman Bulunamadı!');
                } else {
                    toastr.error('Döküman Getirilemedi!');
                }
            }
        });
    }

    function deleteDocument() {
        $.ajax({
            type: 'delete',
            url: '{{ route('user.api.document.delete') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: selectedDocumentId
            },
            success: function (response) {
                TransactionsModal.modal('hide');
                toastr.success('Döküman silindi!')
                getAllDocument()
                selectedDocumentId = null;

            },
            error: function () {
                if (parseInt(error.status) === 404) {
                    toastr.error('Döküman Bulunamadı!');
                } else {
                    toastr.error('Döküman Getirilemedi!');
                }
            }
        });
    }


    function updateDocument() {
        var name = $('#update_name').val();
        var file = $('#update_file').prop('files')[0];
        var data = new FormData();
        if (file) {
            data.append('file', file);
        }
        data.append('name', name);
        data.append('id', selectedDocumentId);
        $.ajax({
            cache: false,
            contentType: false,
            processData: false,
            type: 'post',
            url: '{{ route('user.api.document.update') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: data,
            success: function (response) {
                UpdateVideoModal.modal('hide');
                toastr.success('Döküman güncellendi!')
                $('#update_name').val('');
                $('#update_file').val('');
                selectedDocumentId = null;
                getAllDocument();

            },
            error: function () {
                if (parseInt(error.status) === 404) {
                    toastr.error('Döküman Bulunamadı!');
                } else {
                    toastr.error('Döküman Getirilemedi!');
                }
            }
        });
    }

    function createDocument() {
        var name = $('#name').val();
        var file = $('#file').prop('files')[0];
        if (!file) {
            toastr.warning('Döküman Seçmediniz!');
            return false;
        }
        if (!name) {
            toastr.warning('Adı Boş Bırakmayınız!');
            return false;
        }

        var data = new FormData();
        data.append('file', file);
        data.append('name', name);

        $.ajax({
            contentType: false,
            processData: false,
            type: 'post',
            url: '{{ route('user.api.document.create') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },

            data: data,
            success: function (response) {
                console.log(response)
                createVideoModal.modal('hide');
                toastr.success('Döküman eklendi!')
                $('#name').val('');
                $('#file').val('');
                selectedDocumentId = null;
                getAllDocument();
            },
            error: function () {
                if (parseInt(error.status) === 404) {
                    toastr.error('Döküman Bulunamadı!');
                } else {
                    toastr.error('Döküman Getirilemedi!');
                }
            }
        });

    }


    addVideoBtn.click(function () {
        createVideoModal.modal('show')
    });


    $('body').on('contextmenu', function () {
        if (selectedDocumentId == null) {
            toastr.error('Lütfen döküman seçiniz');
        } else {
            TransactionsModal.modal('show');
        }
        return false;
    });


</script>
