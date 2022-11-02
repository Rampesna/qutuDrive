<script>

    $(document).ready(function () {
        $('#loader').hide();
    });

    var SaveFormButton = $('#SaveFormButton');
    var AddNewQuestionButton = $('#AddNewQuestionButton');

    var formQuestionsRow = $('#formQuestionsRow');

    var base64regex = /^([0-9a-zA-Z+/]{4})*(([0-9a-zA-Z+/]{2}==)|([0-9a-zA-Z+/]{3}=))?$/;

    var formId = parseInt(base64regex.test(`{{ $id }}`) ? atob(`{{ $id }}`) : 0);

    function getForm() {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.form.getById') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: formId,
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

    getForm();

    AddNewQuestionButton.click(function () {
        formQuestionsRow.append(`
        <div class="col-xl-11 mb-5">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-9">
                            <input type="text" class="form-control nonBorder" placeholder="Soru Başlığı" aria-label="Soru Başlığı">
                        </div>
                        <div class="col-xl-3">
                            <select class="form-select nonBorder select2Input" data-control="select2" data-minimum-results-for-search="Infinity" aria-label="Soru Türü" data-placeholder="Soru Türü">
                                <option value="" disabled hidden selected></option>
                                <option value="1">Kısa Cevap</option>
                                <option value="2">Paragraf</option>
                                <option value="3">Çoktan Seçmeli</option>
                                <option value="4">Onay Kutuları</option>
                                <option value="5">Açılır Menü</option>
                            </select>
                        </div>
                    </div>
                    <hr class="text-muted">
                    <div class="row">
                        <div class="col-xl-2 mt-2 text-end">
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="" id="flexSwitchDefault"/>
                                <label class="form-check-label" for="flexSwitchDefault">
                                    Zorunlu Alan
                                </label>
                            </div>
                        </div>
                        <div class="col-xl-9"></div>
                        <div class="col-xl-1 text-end">
                            <i class="fa fa-trash-alt fa-lg cursor-pointer mt-4 deleteFormQuestionIcon" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" data-bs-original-title="Sil"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `);
        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
        $('.select2Input').select2();
    });

    $(document).delegate('.deleteFormQuestionIcon', 'click', function () {
        $(this).closest('.col-xl-11').remove();
    });

</script>
