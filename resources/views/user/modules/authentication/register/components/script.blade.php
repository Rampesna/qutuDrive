<script src="{{ asset('assets/js/custom/authentication/sign-in/general.js') }}"></script>

<script>

    $(document).ready(function () {
        $('#loader').hide();
    });

    var RegisterButton = $('#RegisterButton');

    var nameInput = $('#register_name');
    var surnameInput = $('#register_surname');
    var companyTypeInput = $('#register_company_type');
    var companyTaxNumberInput = $('#register_company_tax_number');
    var companyTaxOfficeInput = $('#register_company_tax_office');
    var companyTitleInput = $('#register_company_title');
    var companyPhoneInput = $('#register_company_phone');
    var companyEmailInput = $('#register_company_email');
    var companyAddressInput = $('#register_company_address');
    var companyPasswordInput = $('#register_company_password');

    function register() {
        var name = nameInput.val();
        var surname = surnameInput.val();
        var companyType = companyTypeInput.val();
        var companyTaxNumber = companyTaxNumberInput.val();
        var companyTaxOffice = companyTaxOfficeInput.val();
        var companyTitle = companyTitleInput.val();
        var companyPhone = companyPhoneInput.val();
        var companyEmail = companyEmailInput.val();
        var companyAddress = companyAddressInput.val();
        var companyPassword = companyPasswordInput.val();

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

        if (!companyPhone) {
            toastr.warning('Lütfen telefon numaranızı giriniz.');
            return false;
        }

        if (!companyEmail) {
            toastr.warning('Lütfen mail adresinizi giriniz.');
            return false;
        }

        if (!companyAddress) {
            toastr.warning('Lütfen adresinizi giriniz.');
            return false;
        }

        if (!companyPassword) {
            toastr.warning('Lütfen parolanızı giriniz.');
            return false;
        }

        RegisterButton.attr('disabled', true).html(`<i class="fa fa-spinner fa-spin"></i>`);
        $.ajax({
            type: 'post',
            url: '{{ route('user.api.register') }}',
            headers: {
                'Accept': 'application/json',
            },
            data: {
                name: name,
                surname: surname,
                companyType: companyType,
                taxNumber: companyTaxNumber,
                taxOffice: companyTaxOffice,
                title: companyTitle,
                phone: companyPhone,
                email: companyEmail,
                address: companyAddress,
                password: companyPassword
            },
            success: function () {
                toastr.success('Kaydınız başarıyla oluşturuldu, yönlendiriliyorsunuz...');
                setTimeout(function () {
                    window.location.href = `{{ route('user.web.authentication.login.index') }}`;
                }, 2000);
            },
            error: function (error) {
                console.log(error);
                RegisterButton.attr('disabled', false).html('KAYIT OL');
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

    RegisterButton.click(function () {
        register();
    });


</script>
