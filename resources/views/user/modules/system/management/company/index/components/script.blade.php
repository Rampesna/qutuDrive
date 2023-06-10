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
            datatype: "json",
            datafields: [
                {name: 'ID', type: 'integer'},
                {name: 'DURUM', type: 'string'},
                {name: 'FIRMAUNVAN', type: 'string'},
                {name: 'APIKEY', type: 'string'},
                {name: 'AD', type: 'string'},
                {name: 'SOYAD', type: 'string'},
                {name: 'TELEFON', type: 'string'},
                {name: 'MAIL', type: 'string'},
                {name: 'VKNTCKN', type: 'string'},
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
                console.log(data);
                source.totalrecords = data[0].TotalRows;
            },
            root: 'Rows',
            filter: function () {
                companiesDiv.jqxGrid('updatebounddata', 'filter');
            }
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
                }
            ],
        });
        $('#loader').hide();
    });

    function refreshCompanies() {
        companiesDiv.jqxGrid('updatebounddata');
    }

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

        if (!companyType) {
            toastr.warning('Lütfen firma tipini seçiniz.');
            return false;
        } else {
            if (parseInt(companyType) === 1) {
                if (!companyTitle) {
                    toastr.warning('Firma ünvanı alanı boş bırakılamaz.');
                    return false;
                }
            } else if (parseInt(companyType) === 2) {
                if (!name) {
                    toastr.warning('Ad alanı boş bırakılamaz.');
                    return false;
                } else if (!surname) {
                    toastr.warning('Soyad alanı boş bırakılamaz.');
                    return false;
                }
            } else {

            }
        }

        if (!companyTaxNumber) {
            toastr.warning('Vergi numarası alanı boş bırakılamaz.');
            return false;
        }

        if (!companyTaxOffice) {
            toastr.warning('Vergi dairesi alanı boş bırakılamaz.');
            return false;
        }

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
                refreshCompanies();
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
                refreshCompanies();
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
