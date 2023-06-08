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

    var packagesDiv = $('#packages');

    var CreatePackageButton = $('#CreatePackageButton');
    var UpdatePackageButton = $('#UpdatePackageButton');
    var DeletePackageButton = $('#DeletePackageButton');

    var DownloadExcelButton = $('#DownloadExcelButton');

    $(document).ready(function () {
        var source = {
            localdata: [],
            datatype: "array",
            datafields: [
                {name: 'ID', type: 'integer'},
                {name: 'BAYIKODU', type: 'BAYIKODU'},
                {name: 'PAKETKODU', type: 'PAKETKODU'},
                {name: 'PAKETADI', type: 'PAKETADI'},
                {name: 'PAKETBOYUTU', type: 'PAKETBOYUTU'},
                {name: 'PAKETFIYATI', type: 'PAKETFIYATI'},
                {name: 'DURUM', type: 'DURUM'},
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
                    text: 'Bayi Kodu',
                    dataField: 'BAYIKODU',
                    columntype: 'textbox',
                    width: '15%',
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
                    width: '21%',
                },
                {
                    text: 'Paket Boyutu',
                    dataField: 'PAKETBOYUTU',
                    columntype: 'textbox',
                    width: '15%',
                },
                {
                    text: 'Fiyat',
                    dataField: 'PAKETFIYATI',
                    columntype: 'textbox',
                    width: '15%',
                },
                {
                    text: 'Durum',
                    dataField: 'DURUM',
                    columntype: 'textbox',
                    width: '15%',
                }
            ],
        });
        packagesDiv.jqxGrid('sortby', 'id', 'desc');
        $('#loader').hide();
    });


    function createPackage() {
        $('#create_package_dealer_code').val('');
        $('#create_package_code').val('');
        $('#create_package_name').val('');
        $('#create_package_size').val('');
        $('#create_package_price').val('');
        $('#create_package_status').val(1);
        $('#CreatePackageModal').modal('show');
    }

    function updatePackage() {
        var id = $('#selected_package_id').val();
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.paketbilgileri.getById') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: id,
            },
            success: function (response) {
                $('#update_package_id').val(response.response.ID);
                $('#update_package_dealer_code').val(response.response.BAYIKODU);
                $('#update_package_code').val(response.response.PAKETKODU);
                $('#update_package_name').val(response.response.PAKETADI);
                $('#update_package_size').val(response.response.PAKETBOYUTU);
                $('#update_package_price').val(response.response.PAKETFIYATI);
                $('#update_package_status').val(response.response.DURUM);
                $('#UpdatePackageModal').modal('show');
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

    function deletePackage() {
        $('#DeletePackageModal').modal('show');
    }

    function getAllPackages() {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.paketbilgileri.getAll') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {},
            success: function (response) {
                var source = {
                    localdata: response.response.map(function (user) {
                        return {
                            ID: user.ID,
                            BAYIKODU: user.BAYIKODU,
                            PAKETKODU: user.PAKETKODU,
                            PAKETADI: user.PAKETADI,
                            PAKETBOYUTU: `${user.PAKETBOYUTU} GB`,
                            PAKETFIYATI: `₺ ${user.PAKETFIYATI}`,
                            DURUM: parseInt(user.DURUM) === 1 ? `<span class="badge badge-success">Aktif</span>` : `<span class="badge badge-danger">Pasif</span>`,
                        }
                    }),
                    datatype: "array",
                    datafields: [
                        {name: 'ID', type: 'integer'},
                        {name: 'BAYIKODU', type: 'BAYIKODU'},
                        {name: 'PAKETKODU', type: 'PAKETKODU'},
                        {name: 'PAKETADI', type: 'PAKETADI'},
                        {name: 'PAKETBOYUTU', type: 'PAKETBOYUTU'},
                        {name: 'PAKETFIYATI', type: 'PAKETFIYATI'},
                        {name: 'DURUM', type: 'DURUM'},
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
                            text: 'Bayi Kodu',
                            dataField: 'BAYIKODU',
                            columntype: 'textbox',
                            width: '15%',
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
                            width: '21%',
                        },
                        {
                            text: 'Paket Boyutu',
                            dataField: 'PAKETBOYUTU',
                            columntype: 'textbox',
                            width: '15%',
                        },
                        {
                            text: 'Fiyat',
                            dataField: 'PAKETFIYATI',
                            columntype: 'textbox',
                            width: '15%',
                        },
                        {
                            text: 'Durum',
                            dataField: 'DURUM',
                            columntype: 'textbox',
                            width: '15%',
                        }
                    ],
                });
                packagesDiv.jqxGrid('sortby', 'id', 'desc');
                packagesDiv.jqxLoader('open');
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

    getAllPackages();

    $('body').click(function () {
        $('#contextMenu').hide();
    });

    CreatePackageButton.click(function () {
        var dealerCode = $('#create_package_dealer_code').val();
        var code = $('#create_package_code').val();
        var name = $('#create_package_name').val();
        var size = $('#create_package_size').val();
        var price = $('#create_package_price').val();
        var status = $('#create_package_status').val();

        CreatePackageButton.attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
        $.ajax({
            type: 'post',
            url: '{{ route('user.api.paketbilgileri.create') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                dealerCode: dealerCode,
                code: code,
                name: name,
                size: size,
                price: price,
                status: status,
            },
            success: function () {
                CreatePackageButton.attr('disabled', false).html('Oluştur');
                toastr.success('Paket başarıyla oluşturuldu.');
                $('#CreatePackageModal').modal('hide');
                getAllPackages();
            },
            error: function (error) {
                CreatePackageButton.attr('disabled', false).html('Oluştur');
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
    });

    UpdatePackageButton.click(function () {
        var id = $('#selected_package_id').val();
        var dealerCode = $('#update_package_dealer_code').val();
        var code = $('#update_package_code').val();
        var name = $('#update_package_name').val();
        var size = $('#update_package_size').val();
        var price = $('#update_package_price').val();
        var status = $('#update_package_status').val();

        UpdatePackageButton.attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
        $.ajax({
            type: 'put',
            url: '{{ route('user.api.paketbilgileri.update') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: id,
                dealerCode: dealerCode,
                code: code,
                name: name,
                size: size,
                price: price,
                status: status,
            },
            success: function () {
                UpdatePackageButton.attr('disabled', false).html('Güncelle');
                toastr.success('Paket başarıyla güncellendi.');
                $('#UpdatePackageModal').modal('hide');
                getAllPackages();
            },
            error: function (error) {
                UpdatePackageButton.attr('disabled', false).html('Güncelle');
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
    });

    DeletePackageButton.click(function () {
        var id = $('#selected_package_id').val();

        DeletePackageButton.attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
        $.ajax({
            type: 'delete',
            url: '{{ route('user.api.paketbilgileri.delete') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: id,
            },
            success: function () {
                DeletePackageButton.attr('disabled', false).html('Sil');
                toastr.success('Paket başarıyla silindi.');
                $('#DeletePackageModal').modal('hide');
                getAllPackages();
            },
            error: function (error) {
                DeletePackageButton.attr('disabled', false).html('Güncelle');
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
    });

</script>
