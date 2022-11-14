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

        if (!name) {
            toastr.warning('Lütfen adınızı giriniz.');
        } else if (!surname) {
            toastr.warning('Lütfen soyadınızı giriniz.');
        } else if (!companyType) {
            toastr.warning('Lütfen firma tipini seçiniz.');
        } else if (!companyTaxNumber) {
            toastr.warning('Lütfen vergi kimlik numaranızı giriniz.');
        } else if (!companyTaxOffice) {
            toastr.warning('Lütfen vergi dairesini giriniz.');
        } else if (!companyTitle) {
            toastr.warning('Lütfen firma ünvanını giriniz.');
        } else if (!companyPhone) {
            toastr.warning('Lütfen telefon numaranızı giriniz.');
        } else if (!companyEmail) {
            toastr.warning('Lütfen mail adresinizi giriniz.');
        } else if (!companyAddress) {
            toastr.warning('Lütfen adresinizi giriniz.');
        } else if (!companyPassword) {
            toastr.warning('Lütfen parolanızı giriniz.');
        } else {
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
                success: function (response) {
                    toastr.success('Kaydınız başarıyla oluşturuldu, yönlendiriliyorsunuz...');
                    setTimeout(function () {
                        window.location.href = `{{ route('user.web.authentication.oAuth') }}?token=${response.response.token}&remember=0`;
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
    }

    RegisterButton.click(function () {
        register();
    });


</script>
