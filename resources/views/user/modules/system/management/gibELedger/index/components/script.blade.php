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

    var gibSaklamaOzelListeDiv = $('#gibSaklamaOzelListe');

    $(document).ready(function () {
        var source = {
            localdata: [],
            datatype: "array",
            datafields: [
                {name: 'ID', type: 'integer'},
                {name: 'FIRMAAPIKEY', type: 'string'},
                {name: 'VKNTCKN', type: 'string'},
                {name: 'UNVAN', type: 'string'},
                {name: 'TARIH', type: 'string'},
                {name: 'DURUM', type: 'string'},
            ]
        };
        var dataAdapter = new $.jqx.dataAdapter(source);
        gibSaklamaOzelListeDiv.on('contextmenu', function (e) {
            var top = e.pageY - 10;
            var left = e.pageX - 10;
            $("#contextMenu").css({
                display: "block",
                top: top,
                left: left
            });
            return false;
        });
        gibSaklamaOzelListeDiv.on('rowclick', function (event) {
            if (event.args.rightclick) {
                gibSaklamaOzelListeDiv.jqxGrid('selectrow', event.args.rowindex);
                var rowindex = gibSaklamaOzelListeDiv.jqxGrid('getselectedrowindex');
                $('#selected_company_row_index').val(rowindex);
                var dataRecord = gibSaklamaOzelListeDiv.jqxGrid('getrowdata', rowindex);
                $('#selected_company_id').val(dataRecord.ID);
                return false;
            } else {
                $("#contextMenu").hide();
            }

            return false;
        });
        gibSaklamaOzelListeDiv.jqxGrid({
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
                    dataField: 'ID',
                    columntype: 'textbox',
                    width: '4%',
                },
                {
                    text: 'API Key',
                    dataField: 'FIRMAAPIKEY',
                    columntype: 'textbox',
                    width: '18%',
                },
                {
                    text: 'Vergi No',
                    dataField: 'VKNTCKN',
                    columntype: 'textbox',
                    width: '15%',
                },
                {
                    text: 'Ünvan',
                    dataField: 'UNVAN',
                    columntype: 'textbox',
                    width: '15%',
                },
                {
                    text: 'Tarih',
                    dataField: 'TARIH',
                    columntype: 'textbox',
                    width: '10%',
                },
                {
                    text: 'Durum',
                    dataField: 'DURUM',
                    columntype: 'textbox',
                    width: '8%',
                }
            ],
        });
        gibSaklamaOzelListeDiv.jqxGrid('sortby', 'id', 'desc');
        $('#loader').hide();
    });

    function getAllGibSaklamaOzelListe() {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.gibsaklamaozelliste.getAll') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {},
            success: function (response) {
                var source = {
                    localdata: response.response.map(function (gibsaklamaozelliste) {
                        return {
                            ID: gibsaklamaozelliste.ID,
                            FIRMAAPIKEY: gibsaklamaozelliste.FIRMAAPIKEY,
                            VKNTCKN: gibsaklamaozelliste.VKNTCKN,
                            UNVAN: gibsaklamaozelliste.UNVAN,
                            TARIH: gibsaklamaozelliste.TARIH ? reformatDatetimeToDateForHuman(gibsaklamaozelliste.TARIH) : '',
                            DURUM: parseInt(gibsaklamaozelliste.DURUM) === 1 ? `<span class="badge badge-light-success">KUYRUĞA ALINDI</span>` : `<span class="badge badge-light-warning">İPTAL EDİLDİ</span>`,
                        }
                    }),
                    datatype: "array",
                    datafields: [
                        {name: 'ID', type: 'integer'},
                        {name: 'FIRMAAPIKEY', type: 'string'},
                        {name: 'VKNTCKN', type: 'string'},
                        {name: 'UNVAN', type: 'string'},
                        {name: 'TARIH', type: 'string'},
                        {name: 'DURUM', type: 'string'},
                    ]
                };
                var dataAdapter = new $.jqx.dataAdapter(source);
                gibSaklamaOzelListeDiv.on('contextmenu', function (e) {
                    var top = e.pageY - 10;
                    var left = e.pageX - 10;
                    $("#contextMenu").css({
                        display: "block",
                        top: top,
                        left: left
                    });
                    return false;
                });
                gibSaklamaOzelListeDiv.on('rowclick', function (event) {
                    if (event.args.rightclick) {
                        gibSaklamaOzelListeDiv.jqxGrid('selectrow', event.args.rowindex);
                        var rowindex = gibSaklamaOzelListeDiv.jqxGrid('getselectedrowindex');
                        $('#selected_company_row_index').val(rowindex);
                        var dataRecord = gibSaklamaOzelListeDiv.jqxGrid('getrowdata', rowindex);
                        $('#selected_company_id').val(dataRecord.ID);
                        return false;
                    } else {
                        $("#contextMenu").hide();
                    }

                    return false;
                });
                gibSaklamaOzelListeDiv.jqxGrid({
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
                            dataField: 'ID',
                            columntype: 'textbox',
                            width: '4%',
                        },
                        {
                            text: 'API Key',
                            dataField: 'FIRMAAPIKEY',
                            columntype: 'textbox',
                            width: '18%',
                        },
                        {
                            text: 'Vergi No',
                            dataField: 'VKNTCKN',
                            columntype: 'textbox',
                            width: '15%',
                        },
                        {
                            text: 'Ünvan',
                            dataField: 'UNVAN',
                            columntype: 'textbox',
                            width: '15%',
                        },
                        {
                            text: 'Tarih',
                            dataField: 'TARIH',
                            columntype: 'textbox',
                            width: '10%',
                        },
                        {
                            text: 'Durum',
                            dataField: 'DURUM',
                            columntype: 'textbox',
                            width: '8%',
                        }
                    ],
                });
                gibSaklamaOzelListeDiv.jqxGrid('sortby', 'id', 'desc');
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

    getAllGibSaklamaOzelListe();

</script>
