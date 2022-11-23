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

    var companyId = parseInt(base64regex.test(`{{ $id }}`) ? atob(`{{ $id }}`) : 0);

    var usersDiv = $('#users');

    var CancelConnectionButton = $('#CancelConnectionButton');

    $(document).ready(function () {
        var source = {
            localdata: [],
            datatype: "array",
            datafields: [
                {name: 'ID', type: 'integer'},
                {name: 'KULLANICIADI', type: 'string'},
                {name: 'APIKEY', type: 'string'},
                {name: 'AD', type: 'string'},
                {name: 'SOYAD', type: 'string'},
                {name: 'TELEFON', type: 'string'},
                {name: 'MAIL', type: 'string'},
                {name: 'TCNO', type: 'string'},
                {name: 'KULLANICITIPI', type: 'string'},
                {name: 'KAYITTARIHI', type: 'string'},
                {name: 'DURUM', type: 'string'},
            ]
        };
        var dataAdapter = new $.jqx.dataAdapter(source);
        usersDiv.on('contextmenu', function (e) {
            var top = e.pageY - 10;
            var left = e.pageX - 10;
            $("#contextMenu").css({
                display: "block",
                top: top,
                left: left
            });
            return false;
        });
        usersDiv.on('rowclick', function (event) {
            if (event.args.rightclick) {
                usersDiv.jqxGrid('selectrow', event.args.rowindex);
                var rowindex = usersDiv.jqxGrid('getselectedrowindex');
                $('#selected_user_row_index').val(rowindex);
                var dataRecord = usersDiv.jqxGrid('getrowdata', rowindex);
                $('#selected_user_id').val(dataRecord.ID);
                return false;
            } else {
                $("#contextMenu").hide();
            }

            return false;
        });
        usersDiv.jqxGrid({
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
                    text: 'Kullanıcı Adı',
                    dataField: 'KULLANICIADI',
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
                    text: 'TC No',
                    dataField: 'TCNO',
                    columntype: 'textbox',
                    width: '8%',
                },
                {
                    text: 'Kullanıcı Tipi',
                    dataField: 'KULLANICITIPI',
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
        usersDiv.jqxGrid('sortby', 'id', 'desc');
        $('#loader').hide();
    });

    function cancelConnection() {
        $('#CancelConnectionModal').modal('show');
    }

    function getCompanyUsers() {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.userCompanyConnection.getCompanyUsers') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                companyId: companyId,
            },
            success: function (response) {
                var source = {
                    localdata: response.response.map(function (user) {
                        return {
                            ID: user.ID,
                            KULLANICIADI: user.KULLANICIADI,
                            APIKEY: user.APIKEY,
                            AD: user.AD,
                            SOYAD: user.SOYAD,
                            TELEFON: user.TELEFON,
                            MAIL: user.MAIL,
                            TCNO: user.TCNO,
                            KULLANICITIPI: parseInt(user.KULLANICITIPI) === 1 ? '<span class="badge badge-light-primary">KULLANICI</span>' : '<span class="badge badge-light-info">ADMİN</span>',
                            KAYITTARIHI: user.KAYITTARIHI ? reformatDatetimeToDatetimeForHuman(user.KAYITTARIHI) : '',
                            DURUM: parseInt(user.DURUM) === 1 ? `<span class="badge badge-light-success">AKTİF</span>` : `<span class="badge badge-light-warning">PASİF</span>`,
                        }
                    }),
                    datatype: "array",
                    datafields: [
                        {name: 'ID', type: 'integer'},
                        {name: 'KULLANICIADI', type: 'string'},
                        {name: 'APIKEY', type: 'string'},
                        {name: 'AD', type: 'string'},
                        {name: 'SOYAD', type: 'string'},
                        {name: 'TELEFON', type: 'string'},
                        {name: 'MAIL', type: 'string'},
                        {name: 'TCNO', type: 'string'},
                        {name: 'KULLANICITIPI', type: 'string'},
                        {name: 'KAYITTARIHI', type: 'string'},
                        {name: 'DURUM', type: 'string'},
                    ]
                };
                var dataAdapter = new $.jqx.dataAdapter(source);
                usersDiv.on('contextmenu', function (e) {
                    var top = e.pageY - 10;
                    var left = e.pageX - 10;
                    $("#contextMenu").css({
                        display: "block",
                        top: top,
                        left: left
                    });
                    return false;
                });
                usersDiv.on('rowclick', function (event) {
                    if (event.args.rightclick) {
                        usersDiv.jqxGrid('selectrow', event.args.rowindex);
                        var rowindex = usersDiv.jqxGrid('getselectedrowindex');
                        $('#selected_user_row_index').val(rowindex);
                        var dataRecord = usersDiv.jqxGrid('getrowdata', rowindex);
                        $('#selected_user_id').val(dataRecord.ID);
                        return false;
                    } else {
                        $("#contextMenu").hide();
                    }

                    return false;
                });
                usersDiv.jqxGrid({
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
                            text: 'Kullanıcı Adı',
                            dataField: 'KULLANICIADI',
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
                            text: 'TC No',
                            dataField: 'TCNO',
                            columntype: 'textbox',
                            width: '8%',
                        },
                        {
                            text: 'Kullanıcı Tipi',
                            dataField: 'KULLANICITIPI',
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
                usersDiv.jqxGrid('sortby', 'id', 'desc');
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

    getCompanyUsers();

    $('body').click(function () {
        $('#contextMenu').hide();
    });

    CancelConnectionButton.click(function () {
        var userId = $('#selected_user_id').val();
        CancelConnectionButton.attr('disabled', true).html(`<i class="fa fa-spinner fa-spin"></i>`);
        $.ajax({
            type: 'post',
            url: '{{ route('user.api.userCompanyConnection.detachCompanyUser') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                companyId: companyId,
                userId: userId,
            },
            success: function () {
                CancelConnectionButton.attr('disabled', false).html(`Evet`);
                $('#CancelConnectionModal').modal('hide');
            },
            error: function (error) {
                console.log(error);
                CancelConnectionButton.attr('disabled', false).html(`Evet`);
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
