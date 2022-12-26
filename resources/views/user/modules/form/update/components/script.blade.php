<script>

    $(document).ready(function () {
        $('#loader').hide();
    });

    var answerTypesShortAnswer = '{{ __('user/modules/form.update.questionTypes.shortAnswer') }}';
    var answerTypesParagraph = '{{ __('user/modules/form.update.questionTypes.paragraph') }}';
    var answerTypesRadios = '{{ __('user/modules/form.update.questionTypes.radios') }}';
    var answerTypesCheckboxes = '{{ __('user/modules/form.update.questionTypes.checkboxes') }}';
    var answerTypesSelect = '{{ __('user/modules/form.update.questionTypes.select') }}';

    var requiredQuestion = '{{ __('user/modules/form.update.requiredQuestion') }}';
    var addNewOption = '{{ __('user/modules/form.update.addNewOption') }}';
    var newQuestionTitlePlaceholder = '{{ __('user/modules/form.update.newQuestionTitlePlaceholder') }}';
    var newOptionPlaceholder = '{{ __('user/modules/form.update.newOptionPlaceholder') }}';

    var SaveFormButton = $('#SaveFormButton');
    var AddNewQuestionButton = $('#AddNewQuestionButton');
    var ShareFormButton = $('#ShareFormButton');
    var CopyShareLinkButton = $('#CopyShareLinkButton');

    var formAccessibilitySwitcher = $('#form_accessibility_switcher');

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
                $('#update_form_name').val(response.response.name);
                $('#update_form_title').val(response.response.title);
                $('#update_form_description').val(response.response.description);
                formAccessibilitySwitcher.prop('checked', response.response.accessible === 1);
                $.ajax({
                    type: 'get',
                    url: '{{ route('user.api.formQuestion.getByFormIdWithAnswers') }}',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': authUserToken
                    },
                    data: {
                        formId: formId,
                    },
                    success: function (response) {
                        $.each(response.response, function (i, question) {
                            var oldQuestionAnswerList = ``;
                            var oldQuestionsVisibility = false;
                            if (
                                (
                                    parseInt(question.type_id) === 3 ||
                                    parseInt(question.type_id) === 4 ||
                                    parseInt(question.type_id) === 5
                                ) && question.answers.length > 0
                            ) {
                                oldQuestionsVisibility = true;
                                $.each(question.answers, function (j, answer) {
                                    oldQuestionAnswerList += `
                                    <div class="col-xl-12 oldQuestionAnswerOptionDiv">
                                        <div class="row">
                                            <div class="col-xl-7 mb-3">
                                                <input value="${answer.name}" type="text" class="form-control nonBorder" placeholder="Seçeneği Giriniz" aria-label="Seçeneği Giriniz" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    `;
                                });
                            }
                            formQuestionsRow.append(`
                            <div class="col-xl-11 mb-5 oldQuestionColumn">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-9">
                                                <input value="${question.name}" type="text" class="form-control nonBorder" placeholder="Soru Başlığı" aria-label="Soru Başlığı" disabled>
                                            </div>
                                            <div class="col-xl-3">
                                                <select class="form-select nonBorder select2Input oldQuestionTypeSelector" data-control="select2" data-minimum-results-for-search="Infinity" aria-label="Soru Türü" data-placeholder="Soru Türü" disabled>
                                                    <option ${parseInt(question.type_id) === 1 ? `selected` : ``} value="1" data-type="single">${answerTypesShortAnswer}</option>
                                                    <option ${parseInt(question.type_id) === 2 ? `selected` : ``} value="2" data-type="single">${answerTypesParagraph}</option>
                                                    <option ${parseInt(question.type_id) === 3 ? `selected` : ``} value="3" data-type="multi">${answerTypesRadios}</option>
                                                    <option ${parseInt(question.type_id) === 4 ? `selected` : ``} value="4" data-type="multi">${answerTypesCheckboxes}</option>
                                                    <option ${parseInt(question.type_id) === 5 ? `selected` : ``} value="5" data-type="multi">${answerTypesSelect}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="oldQuestionAnswerListDiv" ${oldQuestionsVisibility === false ? `style="display: none"` : ``}>
                                            <hr class="text-muted">
                                            <div class="row oldQuestionAnswerListRow">
                                                ${oldQuestionAnswerList}
                                            </div>
                                        </div>
                                        <hr class="text-muted">
                                        <div class="row">
                                            <div class="col-xl-2 mt-2 text-end">
                                                <div class="form-check form-switch form-check-custom form-check-solid">
                                                    <input ${question.required === 1 ? `checked` : ``} class="form-check-input" type="checkbox" value="" id="flexSwitchDefault" disabled />
                                                    <label class="form-check-label" for="flexSwitchDefault">
                                                        ${requiredQuestion}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `);
                        });
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
        <div class="col-xl-11 mb-5 questionColumn">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-9">
                            <input type="text" class="form-control nonBorder" placeholder="${newQuestionTitlePlaceholder}" aria-label="${newQuestionTitlePlaceholder}">
                        </div>
                        <div class="col-xl-3">
                            <select class="form-select nonBorder select2Input questionTypeSelector" data-control="select2" data-minimum-results-for-search="Infinity" aria-label="Soru Türü" data-placeholder="Soru Türü">
                                <option value="" disabled hidden selected></option>
                                    <option value="1" data-type="single">${answerTypesShortAnswer}</option>
                                    <option value="2" data-type="single">${answerTypesParagraph}</option>
                                    <option value="3" data-type="multi">${answerTypesRadios}</option>
                                    <option value="4" data-type="multi">${answerTypesCheckboxes}</option>
                                    <option value="5" data-type="multi">${answerTypesSelect}</option>
                            </select>
                        </div>
                    </div>
                    <div class="questionAnswerListDiv" style="display: none">
                        <hr class="text-muted">
                        <div class="row questionAnswerListRow">

                        </div>
                        <div class="row">
                            <div class="col-xl-12 mb-5">
                                <button class="btn btn-sm btn-secondary addNewQuestionAnswerButton">${addNewOption}</button>
                            </div>
                        </div>
                    </div>
                    <hr class="text-muted">
                    <div class="row">
                        <div class="col-xl-2 mt-2 text-end">
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="" id="flexSwitchDefault"/>
                                <label class="form-check-label" for="flexSwitchDefault">
                                    ${requiredQuestion}
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
        $("html, body").animate({scrollTop: $(document).height()}, "slow");
        $('.select2Input').select2();
    });

    $(document).delegate('.questionTypeSelector', 'change', function () {
        var type = $(this).find(':selected').attr('data-type');
        if (type === 'single') {
            $(this).closest('.card-body').find('.questionAnswerListDiv').hide();
            $(this).closest('.card-body').find('.questionAnswerListRow').empty();
        } else {
            $(this).closest('.card-body').find('.questionAnswerListDiv').show();
        }
    });

    $(document).delegate('.deleteFormQuestionIcon', 'click', function () {
        $(this).closest('.col-xl-11').remove();
    });

    $(document).delegate('.addNewQuestionAnswerButton', 'click', function () {
        $(this).closest('.card-body').find('.questionAnswerListRow').append(`
            <div class="col-xl-12 questionAnswerOptionDiv">
                <div class="row">
                    <div class="col-xl-7 mb-3">
                        <input type="text" class="form-control nonBorder" placeholder="${newOptionPlaceholder}" aria-label="${newOptionPlaceholder}">
                    </div>
                    <div class="col-xl-1 mb-3">
                        <i class="fa fa-times text-hover-danger cursor-pointer mt-6 questionAnswerDeleteIcon"></i>
                    </div>
                </div>
            </div>
        `);
    });

    $(document).delegate('.questionAnswerDeleteIcon', 'click', function () {
        $(this).closest('.questionAnswerOptionDiv').remove();
    });

    SaveFormButton.click(function () {
        var name = $('#update_form_name').val();
        var title = $('#update_form_title').val();
        var description = $('#update_form_description').val();

        SaveFormButton.attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

        $.ajax({
            type: 'put',
            url: '{{ route('user.api.form.update') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: formId,
                name: name,
                title: title,
                description: description
            },
            success: function () {
                var formQuestions = [];
                var formQuestionsRow = $('#formQuestionsRow');
                formQuestionsRow.find('.questionColumn').each(function () {
                    var question = $(this).find('input').val();
                    var questionType = $(this).find('.questionTypeSelector').val();
                    var questionRequired = $(this).find('input[type="checkbox"]').is(':checked');
                    var questionAnswers = [];
                    $(this).find('.questionAnswerOptionDiv').each(function () {
                        questionAnswers.push($(this).find('input').val());
                    });
                    formQuestions.push({
                        question: question,
                        questionType: questionType,
                        questionRequired: questionRequired,
                        questionAnswers: questionAnswers,
                    });
                });

                console.log(formQuestions);

                $.ajax({
                    type: 'post',
                    url: '{{ route('user.api.form.createFormQuestions') }}',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': authUserToken
                    },
                    data: {
                        formId: formId,
                        formQuestions: formQuestions,
                    },
                    success: function () {
                        toastr.success('Başarıyla Kaydedildi');
                        location.reload();
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

    ShareFormButton.click(function () {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.form.getShareLink') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: formId,
            },
            success: function (response) {
                console.log(response);
                $('#ShareFormModal').modal('show');
                $('#share_form_link').val(response.response);
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

    formAccessibilitySwitcher.change(function () {
        var accessible = $(this).is(':checked') ? 1 : 0;
        $.ajax({
            type: 'put',
            url: '{{ route('user.api.form.updateAccessible') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: formId,
                accessible: accessible,
            },
            success: function () {

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

    CopyShareLinkButton.click(function () {
        navigator.clipboard.writeText($('#share_form_link').val()).then(function () {
            toastr.success('Başarıyla Kopyalandı');
        }, function () {
            toastr.error('Kopyalanamadı');
        });
    });

</script>
