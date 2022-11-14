<script>

    $(document).ready(function () {
        $('#loader').hide();
    });

    var users = $('#users');

    var CreateUserButton = $('#CreateUserButton');
    var UpdateUserButton = $('#UpdateUserButton');
    var DeleteUserButton = $('#DeleteUserButton');

    function createUser() {
        $('#create_user_email').val('');
        $('#create_user_name').val('');
        $('#create_user_surname').val('');
        $('#create_user_phone').val('');
        $('#create_user_password').val('');
        $('#CreateUserModal').modal('show');
    }

    function updateUser(id) {
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

    function deleteUser(id) {
        $('#delete_user_id').val(id);
        $('#DeleteUserModal').modal('show');
    }

    function getUsersByCompanyId() {
        var companyId = SelectedCompany.val();
        var pageIndex = 0;
        var pageSize = -1;
        var keyword = "";

        $.ajax({
            type: 'get',
            url: '{{ route('user.api.user.getByCompanyId') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                companyId: companyId,
                pageIndex: pageIndex,
                pageSize: pageSize,
                keyword: keyword
            },
            success: function (response) {
                console.log(response);

                users.empty();
                $('#totalCountSpan').text(response.response.totalCount);
                $('#startCountSpan').text(parseInt(((pageIndex) * pageSize)) + 1);
                $('#endCountSpan').text(parseInt(parseInt(((pageIndex) * pageSize)) + 1) + parseInt(pageSize) > response.response.totalCount ? response.response.totalCount : parseInt(((pageIndex) * pageSize)) + 1 + parseInt(pageSize));
                $.each(response.response.users, function (i, user) {
                    users.append(`
                    <tr>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary btn-icon btn-sm" type="button" id="${user.ID}_Dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-th"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="${user.ID}_Dropdown" style="width: 175px">
                                    <a class="dropdown-item cursor-pointer mb-2 py-3 ps-6" onclick="updateUser(${user.ID})" title="Düzenle"><i class="fas fa-edit me-2 text-primary"></i> <span class="text-dark">Düzenle</span></a>
                                    <hr class="text-muted">
                                    <a class="dropdown-item cursor-pointer py-3 ps-6" onclick="deleteUser(${user.ID})" title="Sil"><i class="fas fa-trash-alt me-3 text-danger"></i> <span class="text-dark">Sil</span></a>
                                </div>
                            </div>
                        </td>
                        <td>
                            ${user.KULLANICIADI ?? ''}
                        </td>
                        <td>
                            ${user.MAIL ?? ''}
                        </td>
                        <td>
                            ${user.AD ?? ''}
                        </td>
                        <td>
                            ${user.SOYAD ?? ''}
                        </td>
                        <td>
                            ${user.TELEFON ?? ''}
                        </td>
                        <td>
                            ${parseInt(user.DURUM) === 1 ? `<span class="badge badge-light-success">Aktif</span>` : `<span class="badge badge-light-danger">Pasif</span>`}
                        </td>
                    </tr>
                    `);
                });

                checkScreen();

                if (response.response.totalCount <= (pageIndex + 1) * pageSize) {
                    pageUpButton.attr('disabled', true);
                } else {
                    pageUpButton.attr('disabled', false);
                }
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

    getUsersByCompanyId();

    CreateUserButton.click(function () {
        var companyId = SelectedCompany.val();
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
                                            companyId: companyId
                                        },
                                        success: function (response) {
                                            $.ajax({
                                                type: 'post',
                                                url: '{{ route('user.api.userCompanyConnection.attachUserCompany') }}',
                                                headers: {
                                                    'Accept': 'application/json',
                                                    'Authorization': authUserToken
                                                },
                                                data: {
                                                    userId: response.response.ID,
                                                    companyId: companyId
                                                },
                                                success: function () {
                                                    toastr.success('Kullanıcı başarıyla oluşturuldu.');
                                                    $('#CreateUserModal').modal('hide');
                                                    CreateUserButton.attr('disabled', false).html('Oluştur');
                                                    getUsersByCompanyId();
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
        }if (!email) {
            toastr.warning('Lütfen e-posta adresi giriniz.');
        }if (!name) {
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
                                            getUsersByCompanyId();
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
        var id = $('#delete_user_id').val();
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
                getUsersByCompanyId();
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

</script>
