<script>

    $(document).ready(function () {
        $('#loader').hide();
    });

    var base64regex = /^([0-9a-zA-Z+/]{4})*(([0-9a-zA-Z+/]{2}==)|([0-9a-zA-Z+/]{3}=))?$/;

    var companyId = parseInt(base64regex.test(`{{ $id }}`) ? atob(`{{ $id }}`) : 0);

    function getCompanyPackages() {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.firmapaketleri.getByCompanyId') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                companyId: companyId,
            },
            success: function (response) {
                console.log(response);
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

    getCompanyPackages();

</script>
