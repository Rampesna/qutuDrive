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

    var base64regex = /^([0-9a-zA-Z+/]{4})*(([0-9a-zA-Z+/]{2}==)|([0-9a-zA-Z+/]{3}=))?$/;

    var userId = parseInt(base64regex.test(`{{ $id }}`) ? atob(`{{ $id }}`) : 0);

    var companiesDiv = $('#companies');

    var CancelConnectionButton = $('#CancelConnectionButton');

    $(document).ready(function () {
        var source = {
            localdata: [],
            datatype: "array",
            datafields:
                [
                    {name: 'ID', type: 'integer'},
                    {name: 'FIRMAUNVAN', type: 'string'},
                    {name: 'APIKEY', type: 'string'},
                    {name: 'AD', type: 'string'},
                    {name: 'SOYAD', type: 'string'},
                    {name: 'TELEFON', type: 'string'},
                    {name: 'MAIL', type: 'string'},
                    {name: 'VKNTCKN', type: 'string'},
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

    function cancelConnection() {
        $('#CancelConnectionModal').modal('show');
    }

    function getUserCompanies() {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.userCompanyConnection.getUserCompanies') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                userId: userId,
            },
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
                            KAYITTARIHI: company.KAYITTARIHI ? reformatDatetimeToDatetimeForHuman(company.KAYITTARIHI) : '',
                            DURUM: parseInt(company.DURUM) === 1 ? `<span class="badge badge-light-success">AKTİF</span>` : `<span class="badge badge-light-warning">PASİF</span>`,
                        }
                    }),
                    datatype: "array",
                    datafields:
                        [
                            {name: 'ID', type: 'integer'},
                            {name: 'FIRMAUNVAN', type: 'string'},
                            {name: 'APIKEY', type: 'string'},
                            {name: 'AD', type: 'string'},
                            {name: 'SOYAD', type: 'string'},
                            {name: 'TELEFON', type: 'string'},
                            {name: 'MAIL', type: 'string'},
                            {name: 'VKNTCKN', type: 'string'},
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

    getUserCompanies();

    CancelConnectionButton.click(function () {
        CancelConnectionButton.attr('disabled', true).html(`<i class="fa fa-spinner fa-spin"></i>`);
        var companyId = $('#selected_company_id').val();
        $.ajax({
            type: 'post',
            url: '{{ route('user.api.userCompanyConnection.detachUserCompany') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                userId: userId,
                companyId: companyId,
            },
            success: function () {
                $('#CancelConnectionModal').modal('hide');
                CancelConnectionButton.attr('disabled', false).html('Evet');
                toastr.success('Bağlantı başarıyla kaldırıldı.');
                getUserCompanies();
            },
            error: function (error) {
                console.log(error);
                CancelConnectionButton.attr('disabled', false).html('Evet');
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

    $('body').click(function () {
        $('#contextMenu').hide();
    });

</script>
