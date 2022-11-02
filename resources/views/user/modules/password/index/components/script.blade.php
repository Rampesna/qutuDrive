<script>

    $(document).ready(function () {
        $('#loader').hide();
    });

    var passwords = $('#passwords');

    var page = $('#page');
    var pageUpButton = $('#pageUp');
    var pageDownButton = $('#pageDown');
    var pageSizeSelector = $('#pageSize');
    var FilterButton = $('#FilterButton');
    var ClearFilterButton = $('#ClearFilterButton');

    var keywordFilter = $('#keyword');

    var createPasswordPasswordShowButton = $('#createPasswordPasswordShowButton');
    var updatePasswordPasswordShowButton = $('#updatePasswordPasswordShowButton');

    var CreatePasswordButton = $('#CreatePasswordButton');
    var CheckPasswordForUpdatePasswordButton = $('#CheckPasswordForUpdatePasswordButton');
    var UpdatePasswordButton = $('#UpdatePasswordButton');
    var DeletePasswordButton = $('#DeletePasswordButton');

    function createPassword() {
        $('#create_password_name').val('');
        $('#create_password_link').val('');
        $('#create_password_username').val('');
        $('#create_password_password').val('');
        $('#create_password_description').val('');
        $('#CreatePasswordModal').modal('show');
    }

    function checkPasswordForUpdatePassword(id) {
        $('#check_password_for_update_password_password_id').val(id);
        $('#check_password_for_update_password_password').val('');
        $('#CheckPasswordForUpdatePasswordModal').modal('show');
    }

    function updatePassword(id) {
        $('#loader').show();
        $('#update_password_id').val(id);
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.password.getById') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: id,
            },
            success: function (response) {
                $('#update_password_name').val(response.response.name);
                $('#update_password_link').val(response.response.link);
                $('#update_password_username').val(response.response.username);
                $('#update_password_password').val(response.response.password);
                $('#update_password_description').val(response.response.description);
                $('#UpdatePasswordModal').modal('show');
                $('#loader').hide();
            },
            error: function (error) {
                $('#loader').hide();
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

    function deletePassword(id) {
        $('#delete_password_id').val(id);
        $('#DeletePasswordModal').modal('show');
    }

    function getPasswords() {
        passwords.html(`<tr><td colspan="4" class="text-center fw-bolder"><i class="fa fa-lg fa-spinner fa-spin"></i></td></tr>`);
        var companyId = SelectedCompany.val();
        var pageIndex = parseInt(page.html()) - 1;
        var pageSize = pageSizeSelector.val();
        var keyword = keywordFilter.val();

        $.ajax({
            type: 'get',
            url: '{{ route('user.api.password.index') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                companyId: companyId,
                pageIndex: pageIndex,
                pageSize: pageSize,
                keyword: keyword,
            },
            success: function (response) {
                passwords.empty();
                $('#totalCountSpan').text(response.response.totalCount);
                $('#startCountSpan').text(parseInt(((pageIndex) * pageSize)) + 1);
                $('#endCountSpan').text(parseInt(parseInt(((pageIndex) * pageSize)) + 1) + parseInt(pageSize) > response.response.totalCount ? response.response.totalCount : parseInt(((pageIndex) * pageSize)) + 1 + parseInt(pageSize));
                $.each(response.response.passwords, function (i, password) {
                    passwords.append(`
                    <tr>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary btn-icon btn-sm" type="button" id="${password.id}_Dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-th"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="${password.id}_Dropdown" style="width: 175px">
                                    <a class="dropdown-item cursor-pointer mb-2 py-3 ps-6" onclick="checkPasswordForUpdatePassword(${password.id})" title="Düzenle"><i class="fas fa-edit me-2 text-primary"></i> <span class="text-dark">Düzenle</span></a>
                                    <hr class="text-muted">
                                    <a class="dropdown-item cursor-pointer py-3 ps-6" onclick="deletePassword(${password.id})" title="Sil"><i class="fas fa-trash-alt me-3 text-danger"></i> <span class="text-dark">Sil</span></a>
                                </div>
                            </div>
                        </td>
                        <td>
                            ${password.name ?? ''}
                        </td>
                        <td>
                            ${password.username ?? ''}
                        </td>
                        <td>
                            <button class="btn btn-sm btn-icon btn-secondary passwordViewer" data-password-id="${password.id}" data-password="${password.password}" data-status="hide"><i class="fa fa-eye-slash"></i></button>
                            <span id="hiddenPassword_${password.id}">*********</span>
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
                $('#loader').hide();
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

    getPasswords();

    keywordFilter.on('keypress', function (e) {
        if (e.which === 13) {
            changePage(1);
        }
    });

    function changePage(newPage) {
        if (newPage === 1) {
            pageDownButton.attr('disabled', true);
        } else {
            pageDownButton.attr('disabled', false);
        }

        page.html(newPage);
        getPasswords();
    }

    pageUpButton.click(function () {
        changePage(parseInt(page.html()) + 1);
    });

    pageDownButton.click(function () {
        changePage(parseInt(page.html()) - 1);
    });

    pageSizeSelector.change(function () {
        changePage(1);
    });

    FilterButton.click(function () {
        changePage(1);
    });

    ClearFilterButton.click(function () {
        keywordFilter.val('');
        changePage(1);
    });

    $(document).delegate('.passwordViewer', 'click', function () {
        var status = $(this).attr('data-status');
        if (status === 'hide') {
            $(this).attr('data-status', 'show');
            $(this).html('<i class="fa fa-eye"></i>');
            $('#hiddenPassword_' + $(this).attr('data-password-id')).text($(this).attr('data-password'));
        } else {
            $(this).attr('data-status', 'hide');
            $(this).html('<i class="fa fa-eye-slash"></i>');
            $('#hiddenPassword_' + $(this).attr('data-password-id')).text('*********');
        }
    });

    createPasswordPasswordShowButton.click(function () {
        var status = $(this).attr('data-status');
        if (status === 'hide') {
            $(this).attr('data-status', 'show');
            $(this).html('<i class="fa fa-eye"></i>');
            $('#create_password_password').attr('type', 'text');
        } else {
            $(this).attr('data-status', 'hide');
            $(this).html('<i class="fa fa-eye-slash"></i>');
            $('#create_password_password').attr('type', 'password');
        }
    });

    updatePasswordPasswordShowButton.click(function () {
        var status = $(this).attr('data-status');
        if (status === 'hide') {
            $(this).attr('data-status', 'show');
            $(this).html('<i class="fa fa-eye"></i>');
            $('#update_password_password').attr('type', 'text');
        } else {
            $(this).attr('data-status', 'hide');
            $(this).html('<i class="fa fa-eye-slash"></i>');
            $('#update_password_password').attr('type', 'password');
        }
    });

    CreatePasswordButton.click(function () {
        var name = $('#create_password_name').val();
        var link = $('#create_password_link').val();
        var username = $('#create_password_username').val();
        var password = $('#create_password_password').val();
        var description = $('#create_password_description').val();

        if (!name) {
            toastr.warning('Lütfen Başlık Girin!');
        } else if (!link) {
            toastr.warning('Lütfen Link Girin!');
        } else if (!username) {
            toastr.warning('Lütfen Kullanıcı Adınızı Girin!');
        } else if (!password) {
            toastr.warning('Lütfen Şifrenizi Girin!');
        } else {
            CreatePasswordButton.attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            $.ajax({
                type: 'post',
                url: '{{ route('user.api.password.create') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: {
                    companyId: SelectedCompany.val(),
                    name: name,
                    link: link,
                    username: username,
                    password: password,
                    description: description
                },
                success: function () {
                    toastr.success('Şifreniz Başarıyla Kaydedildi!');
                    $('#CreatePasswordModal').modal('hide');
                    CreatePasswordButton.attr('disabled', false).html('Oluştur');
                    changePage(1);
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

    CheckPasswordForUpdatePasswordButton.click(function () {
        var passwordId = $('#check_password_for_update_password_password_id').val();
        var password = $('#check_password_for_update_password_password').val();

        if (!password) {
            toastr.warning('Lütfen Şifrenizi Girin!');
        } else {
            CheckPasswordForUpdatePasswordButton.attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            $.ajax({
                type: 'post',
                url: '{{ route('user.api.checkPassword') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: {
                    password: password,
                },
                success: function () {
                    CheckPasswordForUpdatePasswordButton.attr('disabled', false).html('Kontrol Et');
                    $('#CheckPasswordForUpdatePasswordModal').modal('hide');
                    updatePassword(passwordId);
                },
                error: function (error) {
                    CheckPasswordForUpdatePasswordButton.attr('disabled', false).html('Kontrol Et');
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

    UpdatePasswordButton.click(function () {
        var id = $('#update_password_id').val();
        var name = $('#update_password_name').val();
        var link = $('#update_password_link').val();
        var username = $('#update_password_username').val();
        var password = $('#update_password_password').val();
        var description = $('#update_password_description').val();

        if (!name) {
            toastr.warning('Lütfen Başlık Girin!');
        } else if (!link) {
            toastr.warning('Lütfen Link Girin!');
        } else if (!username) {
            toastr.warning('Lütfen Kullanıcı Adınızı Girin!');
        } else if (!password) {
            toastr.warning('Lütfen Şifrenizi Girin!');
        } else {
            UpdatePasswordButton.attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            $.ajax({
                type: 'put',
                url: '{{ route('user.api.password.update') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: {
                    id: id,
                    name: name,
                    link: link,
                    username: username,
                    password: password,
                    description: description
                },
                success: function () {
                    toastr.success('Şifreniz Başarıyla Güncellendi!');
                    $('#UpdatePasswordModal').modal('hide');
                    UpdatePasswordButton.attr('disabled', false).html('Güncelle');
                    changePage(page.html());
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

    DeletePasswordButton.click(function () {
        var id = $('#delete_password_id').val();
        DeletePasswordButton.attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
        $.ajax({
            type: 'delete',
            url: '{{ route('user.api.password.delete') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: id
            },
            success: function () {
                toastr.success('Şifreniz Başarıyla Silindi!');
                $('#DeletePasswordModal').modal('hide');
                DeletePasswordButton.attr('disabled', false).html('Sil');
                changePage(page.html());
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
    });

</script>
