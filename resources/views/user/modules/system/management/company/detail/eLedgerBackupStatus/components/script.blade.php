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
        $.each(months, function (i, month) {
            monthSelector.append(`<option value="${month.id}">${month.name}</option>`);
        });
        monthSelector.val('');
    });

    var yearSelector = $('#yearSelector');
    var monthSelector = $('#monthSelector');

    var eLedgerBackupsDiv = $('#eLedgerBackups');

    var GetELedgerBackupsButton = $('#GetELedgerBackupsButton');

    var base64regex = /^([0-9a-zA-Z+/]{4})*(([0-9a-zA-Z+/]{2}==)|([0-9a-zA-Z+/]{3}=))?$/;

    var companyId = parseInt(base64regex.test(`{{ $id }}`) ? atob(`{{ $id }}`) : 0);

    function getELedgerBackupStatus() {
        var typeId = 0;
        var year = yearSelector.val();
        var month = monthSelector.val();

        if (!year) {
            toastr.warning('Lütfen Yıl Seçiniz!');
        } else if (!month) {
            toastr.warning('Lütfen Ay Seçiniz!');
        } else {
            toastr.info('Defter Verileriniz Kontrol Ediliyor, Lütfen Bekleyin...');
            $.ajax({
                type: 'get',
                url: '{{ route('user.api.edefterdonemler.getEDefterDonem') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: {
                    companyId: companyId,
                    year: year,
                    month: month,
                    typeIds: parseInt(typeId) === 0 ? [1, 2, 5, 6] : [typeId],
                },
                success: function (response) {
                    $.ajax({
                        type: 'get',
                        url: '{{ route('user.api.edefterdosyalar.getByDonemId') }}',
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': authUserToken
                        },
                        data: {
                            donemId: response.response.ID
                        },
                        success: function (response) {
                            console.log(response);

                            var source = {
                                localdata: response.response.map(function (edefterdosyalar) {
                                    return {
                                        ID: edefterdosyalar.ID,
                                        DOSYAADI: edefterdosyalar.DOSYAADI,
                                        DOSYABOYUTU: `${edefterdosyalar.DOSYABOYUTU} MB`,
                                        KAYITTARIHI: edefterdosyalar.KAYITTARIHI ? reformatDatetimeToDatetimeForHuman(edefterdosyalar.KAYITTARIHI) : ``,
                                        DURUM: edefterdosyalar.DURUM,
                                        GIBDURUM: parseInt(edefterdosyalar.GIBDURUM) === 0 ?
                                            `<span class="badge badge-warning">BEKLEMEDE</span>` : (
                                                parseInt(edefterdosyalar.GIBDURUM) === 1 ?
                                                    `<span class="badge badge-info">İŞLENİYOR</span>` : (
                                                        parseInt(edefterdosyalar.GIBDURUM) === 6 ? `<span class="badge badge-success">BAŞARILI</span>` : ``
                                                    )
                                            ),
                                        GIBGONDERIMTARIHI: edefterdosyalar.GIBGONDERIMTARIHI ? reformatDatetimeToDatetimeForHuman(edefterdosyalar.GIBGONDERIMTARIHI) : ``,
                                        GIBKUYRUKDURUM: edefterdosyalar.GIBKUYRUKDURUM,
                                        GIBKUYRUKTARIHI: edefterdosyalar.GIBKUYRUKTARIHI ? reformatDatetimeToDatetimeForHuman(edefterdosyalar.GIBKUYRUKTARIHI) : ``,
                                        DOSYAIMZA: edefterdosyalar.DOSYAIMZA,
                                        SERVISDURUMU: edefterdosyalar.SERVISDURUMU,
                                    }
                                }),
                                datatype: "array",
                                datafields: [
                                    {name: 'ID', type: 'string'},
                                    {name: 'DOSYAADI', type: 'string'},
                                    {name: 'DOSYABOYUTU', type: 'string'},
                                    {name: 'KAYITTARIHI', type: 'string'},
                                    {name: 'GIBDURUM', type: 'string'},
                                    {name: 'GIBGONDERIMTARIHI', type: 'string'},
                                ]
                            };
                            var dataAdapter = new $.jqx.dataAdapter(source);
                            eLedgerBackupsDiv.on('contextmenu', function (e) {
                                var top = e.pageY - 10;
                                var left = e.pageX - 10;
                                $("#contextMenu").css({
                                    display: "block",
                                    top: top,
                                    left: left
                                });
                                return false;
                            });
                            eLedgerBackupsDiv.on('rowclick', function (event) {
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
                            eLedgerBackupsDiv.jqxGrid({
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
                                        width: '16%',
                                    },
                                    {
                                        text: 'Dosya Adı',
                                        dataField: 'DOSYAADI',
                                        columntype: 'textbox',
                                        width: '58%',
                                    },
                                    {
                                        text: 'Dosya Boyutu',
                                        dataField: 'DOSYABOYUTU',
                                        columntype: 'textbox',
                                        width: '6%',
                                    },
                                    {
                                        text: 'Kayıt Tarihi',
                                        dataField: 'KAYITTARIHI',
                                        columntype: 'textbox',
                                        width: '10%',
                                    },
                                    {
                                        text: 'GİB Durumu',
                                        dataField: 'GIBDURUM',
                                        columntype: 'textbox',
                                        width: '10%',
                                    },
                                ],
                            });
                            eLedgerBackupsDiv.jqxLoader('open');
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
                },
                error: function (error) {
                    console.log(error);
                    if (parseInt(error.status) === 422) {
                        $.each(error.responseJSON.response, function (i, error) {
                            toastr.error(error[0]);
                        });
                    } else if (parseInt(error.status) === 404) {
                        toastr.error('Bu Döneme Ait Defter Verisi Bulunamadı!');
                    } else {
                        toastr.error(error.responseJSON.message);
                    }
                }
            });
        }
    }

    GetELedgerBackupsButton.click(function () {
        getELedgerBackupStatus();
    });

</script>
