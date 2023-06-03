<script src="{{ asset('assets/js/custom/authentication/sign-in/general.js') }}"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<script>

    var authUserId = localStorage.getItem('authUserId');
    var authUserToken = localStorage.getItem('authUserToken');
    var authUserSelectedCompanyId = localStorage.getItem('authUserSelectedCompanyId');

    function checkLogin() {
        if (
            authUserId &&
            authUserToken &&
            authUserSelectedCompanyId
        ) {
            window.location.href = '{{ route('user.web.dashboard.index') }}';
        } else {
            $('#loader').hide();
        }
    }

    checkLogin();

    console.log('{{ getLogoPath(url('/')) }}');
    console.log('{{ url('/') }}');

    var usernameInput = $('#username');
    var passwordInput = $('#password');
    var LoginButton = $('#LoginButton');

    function login() {
        var username = usernameInput.val();
        var password = passwordInput.val();
        var remember = $('#remember').is(':checked') ? 1 : 0;

        if (!username || !password) {
            toastr.warning('Lütfen Bilgilerinizi Girin.');
        } else {
            LoginButton.attr('disabled', true);
            $.ajax({
                type: 'post',
                url: '{{ route('user.api.login') }}',
                headers: {
                    'Accept': 'application/json',
                },
                data: {
                    username: username,
                    password: password,
                },
                success: function (response) {
                    $.ajax({
                        type: 'get',
                        url: '{{ route('user.api.getProfile') }}',
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': `Bearer ${response.response.token}`
                        },
                        data: {},
                        success: function (profileResponse) {
                            localStorage.setItem('authUserId', profileResponse.response.ID);
                            localStorage.setItem('authUserName', `${profileResponse.response.AD} ${profileResponse.response.SOYAD}`);
                            localStorage.setItem('authUserEmail', profileResponse.response.MAIL);
                            localStorage.setItem('authUserUsername', profileResponse.response.KULLANICIADI);
                            localStorage.setItem('authUserToken', `Bearer ${response.response.token}`);
                            localStorage.setItem('authUserSelectedCompanyId', profileResponse.response.selected_company_id);
                            localStorage.setItem('authUserType', profileResponse.response.KULLANICITIPI);

                            window.location.href = '{{ route('user.web.dashboard.index') }}';
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
                    {{--window.location.href = `{{ route('user.web.authentication.oAuth') }}?token=${response.response.token}&remember=${remember}`;--}}
                },
                error: function (error) {
                    console.log(error);
                    LoginButton.attr('disabled', false);
                    var errors = error.responseJSON.response;
                    if (error.status === 422) {
                        if (errors.email) {
                            toastr.error(errors.email[0]);
                        } else if (errors.password) {
                            toastr.error(errors.password[0]);
                        }
                    } else if (error.status === 404) {
                        toastr.error('Kullanıcı Bulunamadı.');
                    } else if (error.status === 401) {
                        toastr.error('Şifreniz Hatalı!');
                    } else {
                        toastr.error('Serviste Bilinmeyen Bir Hata Oluştu.');
                    }
                }
            });
        }
    }

    passwordInput.on('keydown', function (e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            login();
        }
    });

    LoginButton.click(function () {
        login();
    });

</script>
