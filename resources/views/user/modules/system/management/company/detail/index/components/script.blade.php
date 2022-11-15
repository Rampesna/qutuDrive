<script>

    $(document).ready(function () {
        $('#loader').hide();
    });

    var base64regex = /^([0-9a-zA-Z+/]{4})*(([0-9a-zA-Z+/]{2}==)|([0-9a-zA-Z+/]{3}=))?$/;

    var companyId = parseInt(base64regex.test(`{{ $id }}`) ? atob(`{{ $id }}`) : 0);

    var UpdateCompanyButton = $('#UpdateCompanyButton');

    function getCompany() {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.company.getById') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: companyId,
            },
            success: function (response) {
                $('#title').val(response.response.FIRMAUNVAN);
                $('#tax_number').val(response.response.VKNTCKN);
                $('#tax_office').val(response.response.VERGIDAIRESI);
                $('#name').val(response.response.AD);
                $('#surname').val(response.response.SOYAD);
                $('#email').val(response.response.MAIL);
                $('#phone').val(response.response.TELEFON);
                $('#address').val(response.response.ADRES);
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

    getCompany();

    UpdateCompanyButton.click(function () {
        var title = $('#title').val();
        var taxNumber = $('#tax_number').val();
        var taxOffice = $('#tax_office').val();
        var name = $('#name').val();
        var surname = $('#surname').val();
        var email = $('#email').val();
        var phone = $('#phone').val();
        var address = $('#address').val();

        if (!title) {
            toastr.warning('Firma ünvanı boş olamaz!');
        } else if (!taxNumber) {
            toastr.warning('Vergi numarası boş olamaz!');
        } else if (!email) {
            toastr.warning('E-posta boş olamaz!');
        } else {
            UpdateCompanyButton.attr('disabled', true).html(`<i class="fa fa-spinner fa-spin"></i>`);
            $.ajax({
                type: 'get',
                url: '{{ route('user.api.company.getByTaxNumber') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: {
                    taxNumber: taxNumber,
                    exceptId: companyId,
                },
                success: function () {
                    toastr.error('Bu vergi numarası başka bir firmaya ait!');
                    UpdateCompanyButton.prop('disabled', false).html('Kaydet');
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
                            url: '{{ route('user.api.company.update') }}',
                            headers: {
                                'Accept': 'application/json',
                                'Authorization': authUserToken
                            },
                            data: {
                                id: companyId,
                                title: title,
                                taxNumber: taxNumber,
                                taxOffice: taxOffice,
                                name: name,
                                surname: surname,
                                email: email,
                                phone: phone,
                                address: address,
                            },
                            success: function () {
                                toastr.success('Firma başarıyla güncellendi!');
                                UpdateCompanyButton.attr('disabled', false).html('Kaydet');
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
        }
    });

</script>
