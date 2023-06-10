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
<script src="{{ asset('assets/jqwidgets/jqxloader.js') }}"></script>
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

    var usersDiv = $('#users');

    var CreateUserButton = $('#CreateUserButton');
    var UpdateUserButton = $('#UpdateUserButton');
    var DeleteUserButton = $('#DeleteUserButton');
    var ChangeEmailButton = $('#ChangeEmailButton');

    var DownloadExcelButton = $('#DownloadExcelButton');

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

    function createUser() {
        $('#create_user_username').val('');
        $('#create_user_email').val('');
        $('#create_user_name').val('');
        $('#create_user_surname').val('');
        $('#create_user_phone').val('');
        $('#create_user_password').val('');
        $('#CreateUserModal').modal('show');
    }

    function updateUser() {
        var id = $('#selected_user_id').val();
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.user.getById') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: id,
            },
            success: function (response) {
                $('#update_user_id').val(response.response.ID);
                $('#update_user_username').val(response.response.KULLANICIADI);
                $('#update_user_email').val(response.response.MAIL);
                $('#update_user_name').val(response.response.AD);
                $('#update_user_surname').val(response.response.SOYAD);
                $('#update_user_phone').val(response.response.TELEFON);
                $('#update_user_tax_number').val(response.response.TCNO);
                $('#update_user_password').val('');
                $('#UpdateUserModal').modal('show');
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

    function deleteUser() {
        $('#DeleteUserModal').modal('show');
    }

    function userDetail() {
        var id = $('#selected_user_id').val();
        window.open(`{{ route('user.web.system.management.user.detail.index') }}/${btoa(id)}`, '_blank');
    }

    function changeUserEmail() {
        $('#ChangeEmailModal').modal('show');
    }

    function downloadUsers() {
        usersDiv.jqxGrid('exportdata', 'xlsx', 'Kullanıcılar');
    }

    function getAllUsers() {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.user.getAll') }}',
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
                usersDiv.jqxLoader('open');
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

    getAllUsers();

    $('body').click(function () {
        $('#contextMenu').hide();
    });

    CreateUserButton.click(function () {
        var username = $('#create_user_username').val();
        var email = $('#create_user_email').val();
        var name = $('#create_user_name').val();
        var surname = $('#create_user_surname').val();
        var phone = $('#create_user_phone').val();
        var taxNumber = $('#create_user_tax_number').val();
        var password = $('#create_user_password').val();

        if (!username) {
            toastr.warning('Lütfen kullanıcı adı giriniz.');
        } else if (!email) {
            toastr.warning('Lütfen e-posta adresi giriniz.');
        } else if (!name) {
            toastr.warning('Lütfen ad giriniz.');
        } else if (!surname) {
            toastr.warning('Lütfen soyad giriniz.');
        } else if (!password) {
            toastr.warning('Lütfen şifre giriniz.');
        } else {
            CreateUserButton.attr('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
            $.ajax({
                type: 'get',
                url: '{{ route('user.api.user.getByEmail') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: {
                    email: email,
                },
                success: function () {
                    toastr.error('Bu e-posta adresi zaten kullanımda!');
                    CreateUserButton.attr('disabled', false).html('Oluştur');
                },
                error: function (error) {
                    console.log(error);
                    if (parseInt(error.status) === 422) {
                        $.each(error.responseJSON.response, function (i, error) {
                            toastr.error(error[0]);
                        });
                        CreateUserButton.attr('disabled', false).html('Oluştur');
                    } else if (parseInt(error.status) === 404) {
                        $.ajax({
                            type: 'get',
                            url: '{{ route('user.api.user.getByUsername') }}',
                            headers: {
                                'Accept': 'application/json',
                                'Authorization': authUserToken
                            },
                            data: {
                                username: username,
                            },
                            success: function () {
                                toastr.error('Bu kullanıcı adı zaten kullanımda!');
                                CreateUserButton.attr('disabled', false).html('Oluştur');
                            },
                            error: function (error) {
                                console.log(error);
                                if (parseInt(error.status) === 422) {
                                    $.each(error.responseJSON.response, function (i, error) {
                                        toastr.error(error[0]);
                                    });
                                } else if (parseInt(error.status) === 404) {
                                    $.ajax({
                                        type: 'post',
                                        url: '{{ route('user.api.user.create') }}',
                                        headers: {
                                            'Accept': 'application/json',
                                            'Authorization': authUserToken
                                        },
                                        data: {
                                            username: username,
                                            email: email,
                                            name: name,
                                            surname: surname,
                                            phone: phone,
                                            taxNumber: taxNumber,
                                            password: password,
                                        },
                                        success: function () {
                                            toastr.success('Kullanıcı başarıyla oluşturuldu.');
                                            CreateUserButton.attr('disabled', false).html('Oluştur');
                                            $('#CreateUserModal').modal('hide');
                                            getAllUsers();
                                        },
                                        error: function (error) {
                                            console.log(error);
                                            CreateUserButton.attr('disabled', false).html('Oluştur');
                                            if (parseInt(error.status) === 422) {
                                                $.each(error.responseJSON.response, function (i, error) {
                                                    toastr.error(error[0]);
                                                });
                                            } else {
                                                toastr.error(error.responseJSON.message);
                                            }
                                        }
                                    });
                                } else {
                                    toastr.error(error.responseJSON.message);
                                }
                            }
                        });
                    } else {
                        toastr.error(error.responseJSON.message);
                    }
                }
            });
        }
    });

    UpdateUserButton.click(function () {
        var id = $('#update_user_id').val();
        var username = $('#update_user_username').val();
        var email = $('#update_user_email').val();
        var name = $('#update_user_name').val();
        var surname = $('#update_user_surname').val();
        var phone = $('#update_user_phone').val();
        var taxNumber = $('#update_user_tax_number').val();
        var password = $('#update_user_password').val();
        var status = 1;

        if (!username) {
            toastr.warning('Lütfen kullanıcı adı giriniz.');
        }
        if (!email) {
            toastr.warning('Lütfen e-posta adresi giriniz.');
        }
        if (!name) {
            toastr.warning('Lütfen ad giriniz.');
        } else if (!surname) {
            toastr.warning('Lütfen soyad giriniz.');
        } else {
            UpdateUserButton.attr('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
            $.ajax({
                type: 'get',
                url: '{{ route('user.api.user.getByEmail') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: {
                    email: email,
                    exceptId: id
                },
                success: function () {
                    toastr.error('Bu e-posta adresi zaten kullanımda!');
                    UpdateUserButton.attr('disabled', false).html('Güncelle');
                },
                error: function (error) {
                    console.log(error);
                    if (parseInt(error.status) === 422) {
                        $.each(error.responseJSON.response, function (i, error) {
                            toastr.error(error[0]);
                        });
                    } else if (parseInt(error.status) === 404) {
                        $.ajax({
                            type: 'get',
                            url: '{{ route('user.api.user.getByUsername') }}',
                            headers: {
                                'Accept': 'application/json',
                                'Authorization': authUserToken
                            },
                            data: {
                                username: username,
                                exceptId: id
                            },
                            success: function () {
                                toastr.error('Bu kullanıcı adı zaten kullanımda!');
                                UpdateUserButton.attr('disabled', false).html('Güncelle');
                            },
                            error: function (error) {
                                console.log(error);
                                if (parseInt(error.status) === 422) {
                                    $.each(error.responseJSON.response, function (i, error) {
                                        toastr.error(error[0]);
                                    });
                                } else if (parseInt(error.status) === 404) {
                                    $.ajax({
                                        type: 'put',
                                        url: '{{ route('user.api.user.update') }}',
                                        headers: {
                                            'Accept': 'application/json',
                                            'Authorization': authUserToken
                                        },
                                        data: {
                                            id: id,
                                            username: username,
                                            email: email,
                                            name: name,
                                            surname: surname,
                                            phone: phone,
                                            taxNumber: taxNumber,
                                            password: password,
                                            status: status,
                                        },
                                        success: function () {
                                            toastr.success('Kullanıcı başarıyla güncellendi.');
                                            $('#UpdateUserModal').modal('hide');
                                            UpdateUserButton.attr('disabled', false).html('Güncelle');
                                            getAllUsers();
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
                                } else {
                                    toastr.error(error.responseJSON.message);
                                }
                            }
                        });
                    } else {
                        toastr.error(error.responseJSON.message);
                    }
                }
            });
        }
    });

    DeleteUserButton.click(function () {
        var id = $('#selected_user_id').val();
        DeleteUserButton.attr('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        $.ajax({
            type: 'delete',
            url: '{{ route('user.api.user.delete') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: id,
            },
            success: function () {
                DeleteUserButton.attr('disabled', false).html('Sil');
                toastr.success('Kullanıcı başarıyla silindi.');
                $('#DeleteUserModal').modal('hide');
                getAllUsers();
            },
            error: function (error) {
                console.log(error);
                DeleteUserButton.attr('disabled', false).html('Sil');
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

    ChangeEmailButton.click(function () {
        var id = $('#selected_user_id').val();
        var email = $('#change_email_new_email').val();
        var petitionFile = $('#change_email_petition').prop('files')[0];

        if (!email) {
            toastr.warning('Lütfen yeni e-posta adresi giriniz.');
        } else if (!petitionFile) {
            toastr.warning('Lütfen dilekçe yükleyiniz.');
        } else {
            ChangeEmailButton.attr('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
            var formData = new FormData();
            formData.append('userId', id);
            formData.append('email', email);
            formData.append('petition', petitionFile);
            $.ajax({
                type: 'get',
                url: '{{ route('user.api.user.getByEmail') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: {
                    email: email,
                    exceptId: id
                },
                success: function () {
                    toastr.error('Bu e-posta adresi başka bir hesaba ait!');
                    ChangeEmailButton.attr('disabled', false).html('Güncelle');
                },
                error: function (error) {
                    console.log(error);
                    if (parseInt(error.status) === 422) {
                        $.each(error.responseJSON.response, function (i, error) {
                            toastr.error(error[0]);
                        });
                        ChangeEmailButton.attr('disabled', false).html('Güncelle');
                    } else if (parseInt(error.status) === 404) {
                        $.ajax({
                            contentType: false,
                            processData: false,
                            type: 'post',
                            url: '{{ route('user.api.user.changeEmail') }}',
                            headers: {
                                'Accept': 'application/json',
                                'Authorization': authUserToken
                            },
                            data: formData,
                            success: function () {
                                toastr.success('E-posta adresi başarıyla güncellendi');
                                $('#ChangeEmailModal').modal('hide');
                                ChangeEmailButton.attr('disabled', false).html('Güncelle');
                            },
                            error: function (error) {
                                console.log(error);
                                ChangeEmailButton.attr('disabled', false).html('Güncelle');
                                if (parseInt(error.status) === 422) {
                                    $.each(error.responseJSON.response, function (i, error) {
                                        toastr.error(error[0]);
                                    });
                                } else {
                                    toastr.error(error.responseJSON.message);
                                }
                            }
                        });
                    } else {
                        toastr.error(error.responseJSON.message);
                        ChangeEmailButton.attr('disabled', false).html('Güncelle');
                    }
                }
            });
        }
    });

</script>
