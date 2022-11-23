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

    $(document).ready(function () {
        $('#loader').hide();
    });

    var packagesDiv = $('#packages');

    function getCompanyPackages() {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.firmapaketleri.getByCompanyId') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                companyId: SelectedCompany.val(),
            },
            success: function (response) {
                var source = {
                    localdata: response.response.map(function (companyPackage) {
                        return {
                            ID: companyPackage.ID,
                            PAKETKODU: companyPackage.PAKETKODU,
                            PAKETADI: companyPackage.PAKETADI,
                            PAKETBOYUTU: companyPackage.PAKETBOYUTU,
                            PAKETFIYATI: companyPackage.PAKETFIYATI,
                            BASLANGICTARIHI: companyPackage.BASLANGICTARIHI ? reformatDatetimeToDatetimeForHuman(companyPackage.BASLANGICTARIHI) : '',
                            BITISTARIHI: companyPackage.BITISTARIHI ? reformatDatetimeToDatetimeForHuman(companyPackage.BITISTARIHI) : '',
                            DURUM: parseInt(companyPackage.DURUM) === 1 ? `<span class="badge badge-light-success">AKTİF</span>` : `<span class="badge badge-light-warning">PASİF</span>`,
                        }
                    }),
                    datatype: "array",
                    datafields: [
                        {name: 'ID', type: 'integer'},
                        {name: 'PAKETKODU', type: 'string'},
                        {name: 'PAKETADI', type: 'string'},
                        {name: 'PAKETBOYUTU', type: 'string'},
                        {name: 'PAKETFIYATI', type: 'string'},
                        {name: 'BASLANGICTARIHI', type: 'string'},
                        {name: 'BITISTARIHI', type: 'string'},
                        {name: 'DURUM', type: 'string'},
                    ]
                };
                var dataAdapter = new $.jqx.dataAdapter(source);
                packagesDiv.on('contextmenu', function (e) {
                    var top = e.pageY - 10;
                    var left = e.pageX - 10;
                    $("#contextMenu").css({
                        display: "block",
                        top: top,
                        left: left
                    });
                    return false;
                });
                packagesDiv.on('rowclick', function (event) {
                    if (event.args.rightclick) {
                        packagesDiv.jqxGrid('selectrow', event.args.rowindex);
                        var rowindex = packagesDiv.jqxGrid('getselectedrowindex');
                        $('#selected_package_row_index').val(rowindex);
                        var dataRecord = packagesDiv.jqxGrid('getrowdata', rowindex);
                        $('#selected_package_id').val(dataRecord.ID);
                        return false;
                    } else {
                        $("#contextMenu").hide();
                    }

                    return false;
                });
                packagesDiv.jqxGrid({
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
                            text: 'Paket Kodu',
                            dataField: 'PAKETKODU',
                            columntype: 'textbox',
                            width: '15%',
                        },
                        {
                            text: 'Paket Adı',
                            dataField: 'PAKETADI',
                            columntype: 'textbox',
                            width: '18%',
                        },
                        {
                            text: 'Paket Boyutu',
                            dataField: 'PAKETBOYUTU',
                            columntype: 'textbox',
                            width: '15%',
                        },
                        {
                            text: 'Paket Fiyatı',
                            dataField: 'PAKETFIYATI',
                            columntype: 'textbox',
                            width: '10%',
                        },
                        {
                            text: 'Başlangıç Tarihi',
                            dataField: 'BASLANGICTARIHI',
                            columntype: 'textbox',
                            width: '12%',
                        },
                        {
                            text: 'Bitiş Tarihi',
                            dataField: 'BITISTARIHI',
                            columntype: 'textbox',
                            width: '12%',
                        },
                        {
                            text: 'Durum',
                            dataField: 'DURUM',
                            columntype: 'textbox',
                            width: '14%',
                        }
                    ],
                });
                packagesDiv.jqxGrid('sortby', 'id', 'desc');
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

    getCompanyPackages();

</script>
