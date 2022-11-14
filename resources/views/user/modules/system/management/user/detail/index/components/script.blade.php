<script>

    $(document).ready(function () {
        $('#loader').hide();
    });

    var base64regex = /^([0-9a-zA-Z+/]{4})*(([0-9a-zA-Z+/]{2}==)|([0-9a-zA-Z+/]{3}=))?$/;

    var userId = parseInt(base64regex.test(`{{ $id }}`) ? atob(`{{ $id }}`) : 0);

    var UpdateUserButton = $('#UpdateUserButton');

    function getUserById() {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.user.getById') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: userId,
            },
            success: function (response) {
                $('#username').val(response.response.KULLANICIADI);
                $('#email').val(response.response.MAIL);
                $('#name').val(response.response.AD);
                $('#surname').val(response.response.SOYAD);
                $('#phone').val(response.response.TELEFON);
                $('#tax_number').val(response.response.TCNO);
                $('#status').val(response.response.DURUM);
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

    getUserById();

    UpdateUserButton.click(function () {
        var id = userId;
        var username = $('#username').val();
        var email = $('#email').val();
        var name = $('#name').val();
        var surname = $('#surname').val();
        var phone = $('#phone').val();
        var taxNumber = $('#tax_number').val();
        var status = $('#status').val();

        if (!username) {
            toastr.warning('Kullanıcı Adı Boş Olamaz!');
        } else if (!email) {
            toastr.warning('E-Posta Boş Olamaz!');
        } else if (!name) {
            toastr.warning('Ad Boş Olamaz!');
        } else if (!surname) {
            toastr.warning('Soyad Boş Olamaz!');
        } else {
            UpdateUserButton.attr('disabled', true).html(`<i class="fa fa-spinner fa-spin"></i>`);
            $.ajax({
                type: 'get',
                url: '{{ route('user.api.user.getByEmail') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: {
                    email: email,
                    exceptId: id,
                },
                success: function () {
                    toastr.error('Bu E-Posta Adresi Başka Bir Kullanıcıya Ait!');
                    UpdateUserButton.attr('disabled', false).html(`Kaydet`);
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
                                exceptId: id,
                            },
                            success: function () {
                                toastr.error('Bu Kullanıcı Adı Başka Bir Kullanıcıya Ait!');
                                UpdateUserButton.attr('disabled', false).html(`Kaydet`);
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
                                            status: status,
                                        },
                                        success: function () {
                                            toastr.success('Kullanıcı Başarıyla Güncellendi!');
                                            UpdateUserButton.attr('disabled', false).html(`Kaydet`);
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

</script>
