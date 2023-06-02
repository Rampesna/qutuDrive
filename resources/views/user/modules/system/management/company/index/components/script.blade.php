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

    var CreateCompanyButton = $('#CreateCompanyButton');
    var DeleteCompanyButton = $('#DeleteCompanyButton');

    $(document).ready(function () {
        var source = {
            localdata: [],
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
        $('#loader').hide();
    });

    function createCompany() {
        $('#CreateCompanyModal').modal('show');
    }

    function deleteCompany() {
        $('#DeleteCompanyModal').modal('show');
    }

    function detailsCompany() {
        var id = $('#selected_company_id').val();
        window.open(`{{ route('user.web.system.management.company.detail.index') }}/${btoa(id)}`, '_blank');
    }

    function downloadCompanies() {
        toastr.info('Dosya indiriliyor lütfen bekleyin...');
        setTimeout(function () {
            $('#companies').jqxGrid('exportdata', 'xlsx', 'Firmalar');
        }, 1000);
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

    getAllCompanies();

    $('body').click(function () {
        $('#contextMenu').hide();
    });

    CreateCompanyButton.click(function () {
        var name = $('#create_company_name').val();
        var surname = $('#create_company_surname').val();
        var companyType = $('#create_company_type').val();
        var companyTaxNumber = $('#create_company_tax_number').val();
        var companyTaxOffice = $('#create_company_tax_office').val();
        var companyTitle = $('#create_company_title').val();
        var companyPhone = $('#create_company_phone').val();
        var companyEmail = $('#create_company_email').val();
        var companyAddress = $('#create_company_address').val();

        if (!name) {
            toastr.warning('Ad alanı boş bırakılamaz.');
        } else if (!surname) {
            toastr.warning('Soyad alanı boş bırakılamaz.');
        } else if (!companyType) {
            toastr.warning('Lütfen firma tipini seçiniz.');
        } else if (!companyTaxNumber) {
            toastr.warning('Vergi numarası alanı boş bırakılamaz.');
        } else if (!companyTaxOffice) {
            toastr.warning('Vergi dairesi alanı boş bırakılamaz.');
        } else if (!companyTitle) {
            toastr.warning('Firma ünvanı alanı boş bırakılamaz.');
        } else {
            CreateCompanyButton.attr('disabled', true).html(`<i class="fa fa-spinner fa-spin"></i>`);
            $.ajax({
                type: 'post',
                url: '{{ route('user.api.company.create') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken,
                },
                data: {
                    title: companyTitle,
                    taxNumber: companyTaxNumber,
                    name: name,
                    surname: surname,
                    taxOffice: companyTaxOffice,
                    address: companyAddress,
                    phone: companyPhone,
                    email: companyEmail,
                    eLedgerSourceType: companyType,
                },
                success: function () {
                    toastr.success('Firma başarıyla oluşturuldu.');
                    CreateCompanyButton.attr('disabled', false).html('Oluştur');
                    $('#CreateCompanyModal').modal('hide');
                    getAllCompanies();
                },
                error: function (error) {
                    console.log(error);
                    CreateCompanyButton.attr('disabled', false).html('Oluştur');
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

    DeleteCompanyButton.click(function () {
        var companyId = $('#selected_company_id').val();
        DeleteCompanyButton.attr('disabled', true).html(`<i class="fa fa-spinner fa-spin"></i>`);
        $.ajax({
            type: 'delete',
            url: '{{ route('user.api.company.delete') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: companyId,
            },
            success: function () {
                toastr.success('Firma başarıyla silindi.');
                DeleteCompanyButton.attr('disabled', false).html('Sil');
                $('#DeleteCompanyModal').modal('hide');
                getAllCompanies();
            },
            error: function (error) {
                console.log(error);
                DeleteCompanyButton.attr('disabled', false).html('Sil');
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
