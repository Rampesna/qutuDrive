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

    var companiesDiv = $('#companies');

    var AddNewPackageButton = $('#AddNewPackageButton');

    var addNewPackagePackageId = $('#add_new_package_package_id');

    $(document).ready(function () {
        var source = {
            datatype: "json",
            datafields: [
                {name: 'ID', type: 'integer'},
                {name: 'DURUM', type: 'string'},
                {name: 'VKNTCKN', type: 'string'},
                {name: 'FIRMAUNVAN', type: 'string'},
                {name: 'APIKEY', type: 'string'},
                {name: 'AD', type: 'string'},
                {name: 'SOYAD', type: 'string'},
                {name: 'TELEFON', type: 'string'},
                {name: 'MAIL', type: 'string'},
                {name: 'EDEFTERKAYNAKTURU', type: 'string'},
                {name: 'KAYITTARIHI', type: 'string'},
            ],
            cache: false,
            url: '{{ route('user.api.company.jqxGrid') }}',
            beforeSend: function(xhr) {
                xhr.setRequestHeader('Authorization', authUserToken);
                xhr.setRequestHeader('Accept', 'application/json');
            },
            beforeprocessing: function (data) {
                source.totalrecords = data[0].TotalRows;
            },
            root: 'Rows',
            filter: function () {
                companiesDiv.jqxGrid('updatebounddata', 'filter');
            },
            sort: function () {
                companiesDiv.jqxGrid('updatebounddata');
            }
        };
        var dataAdapter = new $.jqx.dataAdapter(source);
        companiesDiv.on('contextmenu', function (e) {
            var top = e.pageY - 10;
            var left = e.pageX - 10;

            var selectedCompanyId = $('#selected_company_id').val();
            if (!selectedCompanyId) {
                return false;
            }

            $("#contextMenu").css({
                display: "block",
                top: top,
                left: left
            });

            return false;
        });
        companiesDiv.on('rowclick', function (event) {
            if (event.args.rightclick) {
                companiesDiv.jqxGrid('selectrow', event.args.rowindex);
                var rowindex = companiesDiv.jqxGrid('getselectedrowindex');
                $('#selected_company_row_index').val(rowindex);
                var dataRecord = companiesDiv.jqxGrid('getrowdata', rowindex);
                $('#selected_company_id').val(dataRecord.ID);
                return false;
            } else {
                $("#contextMenu").hide();
            }

            return false;
        });
        companiesDiv.jqxGrid({
            width: '100%',
            autoheight: true,
            source: dataAdapter,
            columnsresize: true,
            groupable: true,
            theme: jqxGridGlobalTheme,
            filterable: true,
            showfilterrow: true,
            pageable: true,
            sortable: true,
            virtualmode: true,
            rendergridrows: function (params) {
                return params.data;
            },
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
                    text: 'Durum',
                    dataField: 'DURUM',
                    columntype: 'textbox',
                    width: '8%',
                },
                {
                    text: 'Vergi No',
                    dataField: 'VKNTCKN',
                    columntype: 'textbox',
                    width: '8%',
                },
                {
                    text: 'Firma Ünvan',
                    dataField: 'FIRMAUNVAN',
                    columntype: 'textbox',
                    width: '15%',
                },
                {
                    text: 'API Key',
                    dataField: 'APIKEY',
                    columntype: 'textbox',
                    width: '18%',
                },
                {
                    text: 'Ad',
                    dataField: 'AD',
                    columntype: 'textbox',
                    width: '15%',
                },
                {
                    text: 'Soyad',
                    dataField: 'SOYAD',
                    columntype: 'textbox',
                    width: '15%',
                },
                {
                    text: 'Telefon',
                    dataField: 'TELEFON',
                    columntype: 'textbox',
                    width: '10%',
                },
                {
                    text: 'E-posta',
                    dataField: 'MAIL',
                    columntype: 'textbox',
                    width: '15%',
                },
                {
                    text: 'e-Defter Kaynağı',
                    dataField: 'EDEFTERKAYNAKTURU',
                    columntype: 'textbox',
                    width: '8%',
                },
                {
                    text: 'Kayıt Tarihi',
                    dataField: 'KAYITTARIHI',
                    columntype: 'textbox',
                    width: '10%',
                }
            ],
        });
        $('#loader').hide();
    });

    function addNewPackage() {
        $('#AddNewPackageModal').modal('show');
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
                console.log(response);
                addNewPackagePackageId.empty();
                $.each(response.response, function (i, packageData) {
                    addNewPackagePackageId.append(`<option value="${packageData.ID}">${packageData.PAKETADI}</option>`);
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

    function getAllCompanies() {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.company.getAll') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {},
            success: function (response) {
                var source = {
                    localdata: response.response.map(function (company) {
                        return {
                            ID: company.ID,
                            FIRMAUNVAN: company.FIRMAUNVAN,
                            APIKEY: company.APIKEY,
                            AD: company.AD,
                            SOYAD: company.SOYAD,
                            TELEFON: company.TELEFON,
                            MAIL: company.MAIL,
                            VKNTCKN: company.VKNTCKN,
                            EDEFTERKAYNAKTURU: `<span class="badge badge-light-primary">${company.EDEFTERKAYNAKTURU ? parseInt(company.EDEFTERKAYNAKTURU) === 1 ? `KLASÖR` : (parseInt(company.EDEFTERKAYNAKTURU) === 2 ? `PORTAL` : parseInt(company.EDEFTERKAYNAKTURU)) : ``}</span>`,
                            KAYITTARIHI: company.KAYITTARIHI ? reformatDatetimeToDatetimeForHuman(company.KAYITTARIHI) : '',
                            DURUM: parseInt(company.DURUM) === 1 ? `<span class="badge badge-light-success">AKTİF</span>` : `<span class="badge badge-light-warning">PASİF</span>`,
                        }
                    }),
                    datatype: "array",
                    datafields: [
                        {name: 'ID', type: 'integer'},
                        {name: 'FIRMAUNVAN', type: 'string'},
                        {name: 'APIKEY', type: 'string'},
                        {name: 'AD', type: 'string'},
                        {name: 'SOYAD', type: 'string'},
                        {name: 'TELEFON', type: 'string'},
                        {name: 'MAIL', type: 'string'},
                        {name: 'VKNTCKN', type: 'string'},
                        {name: 'EDEFTERKAYNAKTURU', type: 'string'},
                        {name: 'KAYITTARIHI', type: 'string'},
                        {name: 'DURUM', type: 'string'},
                    ]
                };
                var dataAdapter = new $.jqx.dataAdapter(source);
                companiesDiv.on('contextmenu', function (e) {
                    var top = e.pageY - 10;
                    var left = e.pageX - 10;
                    $("#contextMenu").css({
                        display: "block",
                        top: top,
                        left: left
                    });
                    return false;
                });
                companiesDiv.on('rowclick', function (event) {
                    if (event.args.rightclick) {
                        companiesDiv.jqxGrid('selectrow', event.args.rowindex);
                        var rowindex = companiesDiv.jqxGrid('getselectedrowindex');
                        $('#selected_company_row_index').val(rowindex);
                        var dataRecord = companiesDiv.jqxGrid('getrowdata', rowindex);
                        $('#selected_company_id').val(dataRecord.ID);
                        return false;
                    } else {
                        $("#contextMenu").hide();
                    }

                    return false;
                });
                companiesDiv.jqxGrid({
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
                            text: 'Firma Ünvan',
                            dataField: 'FIRMAUNVAN',
                            columntype: 'textbox',
                            width: '15%',
                        },
                        {
                            text: 'API Key',
                            dataField: 'APIKEY',
                            columntype: 'textbox',
                            width: '18%',
                        },
                        {
                            text: 'Ad',
                            dataField: 'AD',
                            columntype: 'textbox',
                            width: '15%',
                        },
                        {
                            text: 'Soyad',
                            dataField: 'SOYAD',
                            columntype: 'textbox',
                            width: '15%',
                        },
                        {
                            text: 'Telefon',
                            dataField: 'TELEFON',
                            columntype: 'textbox',
                            width: '10%',
                        },
                        {
                            text: 'E-posta',
                            dataField: 'MAIL',
                            columntype: 'textbox',
                            width: '15%',
                        },
                        {
                            text: 'Vergi No',
                            dataField: 'VKNTCKN',
                            columntype: 'textbox',
                            width: '8%',
                        },
                        {
                            text: 'e-Defter Kaynağı',
                            dataField: 'EDEFTERKAYNAKTURU',
                            columntype: 'textbox',
                            width: '8%',
                        },
                        {
                            text: 'Kayıt Tarihi',
                            dataField: 'KAYITTARIHI',
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
                companiesDiv.jqxGrid('sortby', 'id', 'desc');
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
    // getAllCompanies();

    $('body').click(function () {
        $('#contextMenu').hide();
    });

    AddNewPackageButton.click(function () {
        var companyId = $('#selected_company_id').val();
        var packageId = $('#add_new_package_package_id').val();
        var packagePrice = $('#add_new_package_price').val();
        var startDate = $('#add_new_package_start_date').val();
        var endDate = $('#add_new_package_end_date').val();
        var status = 1;
        var paymentType = 1;

        if (!companyId) {
            toastr.warning('Lütfen bir firma seçiniz.');
        } else if (!packageId) {
            toastr.warning('Lütfen paket seçiniz.');
        } else if (!packagePrice) {
            toastr.warning('Lütfen paket fiyatını giriniz.');
        } else if (!startDate) {
            toastr.warning('Lütfen başlangıç tarihini giriniz.');
        } else if (!endDate) {
            toastr.warning('Lütfen bitiş tarihini giriniz.');
        } else {
            AddNewPackageButton.attr('disabled', true).html(`<i class="fa fa-spinner fa-spin"></i>`);
            $.ajax({
                type: 'post',
                url: '{{ route('user.api.firmapaketleri.create') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: {
                    companyId: companyId,
                    packageId: packageId,
                    packagePrice: packagePrice,
                    startDate: startDate,
                    endDate: endDate,
                    status: status,
                    paymentType: paymentType
                },
                success: function () {
                    toastr.success('Paket başarıyla eklendi.');
                    $('#AddNewPackageModal').modal('hide');
                    AddNewPackageButton.attr('disabled', false).html('Ekle');
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
    });

</script>
