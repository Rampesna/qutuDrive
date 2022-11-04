<script>

    $(document).ready(function () {
        $('#loader').hide();
    });

    var formId = parseInt(`{{ $id }}`);

    var SubmitFormButton = $('#SubmitFormButton');

    var formQuestionsRow = $('#formQuestionsRow');

    function getForm() {
        $.ajax({
            type: 'get',
            url: '{{ route('home.api.form.getById') }}',
            headers: {
                'Accept': 'application/json',
            },
            data: {
                id: formId,
            },
            success: function (response) {
                console.log(response);

                $('#form_title_span').text(response.response.title);
                $('#form_description_span').text(response.response.description);

                $.ajax({
                    type: 'get',
                    url: '{{ route('home.api.formQuestion.getByFormIdWithAnswers') }}',
                    headers: {
                        'Accept': 'application/json',
                    },
                    data: {
                        formId: formId,
                    },
                    success: function (response) {
                        $.each(response.response, function (i, question) {
                            var questionAnswerList = ``;
                            if (
                                (
                                    parseInt(question.type_id) === 3 ||
                                    parseInt(question.type_id) === 4 ||
                                    parseInt(question.type_id) === 5
                                ) && question.answers.length > 0
                            ) {
                                if (parseInt(question.type_id) === 3) {
                                    $.each(question.answers, function (j, answer) {
                                        questionAnswerList += `
                                        <div class="col-xl-12 questionAnswerOptionDiv">
                                            <div class="form-check form-check-custom form-check-solid mb-3">
                                                <input class="form-check-input" type="radio" id="answer_${answer.id}" value="${answer.name}" name="question_${question.id}_answer" />
                                                <label class="form-check-label" for="answer_${answer.id}">
                                                    ${answer.name}
                                                </label>
                                            </div>
                                        </div>
                                        `;
                                    });
                                } else if (parseInt(question.type_id) === 4) {
                                    $.each(question.answers, function (j, answer) {
                                        questionAnswerList += `
                                        <div class="col-xl-12 questionAnswerOptionDiv">
                                            <div class="form-check form-check-custom form-check-solid mb-3">
                                                <input class="form-check-input" type="checkbox" id="answer_${answer.id}" value="${answer.name}" name="question_${question.id}_answer" />
                                                <label class="form-check-label" for="answer_${answer.id}">
                                                    ${answer.name}
                                                </label>
                                            </div>
                                        </div>
                                        `;
                                    });
                                } else if (parseInt(question.type_id) === 5) {
                                    var options = ``;
                                    $.each(question.answers, function (j, answer) {
                                        options += `
                                        <option value="${answer.name}">${answer.name}</option>
                                        `;
                                    });
                                    questionAnswerList += `
                                        <div class="col-xl-12 questionAnswerOptionDiv">
                                            <select name="question_${question.id}_answer" class="form-control form-control-solid">
                                                ${options}
                                            </select>
                                        </div>
                                        `;
                                }
                            } else {
                                if (parseInt(question.type_id) === 1) {
                                    questionAnswerList += `
                                    <div class="col-xl-12 questionAnswerOptionDiv">
                                        <input type="text" class="form-control form-control-solid" name="question_${question.id}_answer">
                                    </div>
                                    `;
                                } else if (parseInt(question.type_id) === 2) {
                                    questionAnswerList += `
                                    <div class="col-xl-12 questionAnswerOptionDiv">
                                        <textarea class="form-control form-control-solid" name="question_${question.id}_answer"></textarea>
                                    </div>
                                    `;
                                }
                            }
                            formQuestionsRow.append(`
                            <div class="12 mb-5 questionColumn" data-question-id="${question.id}" data-question-type-id="${question.type_id}" data-required="${question.required}">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <span class="fw-bolder fs-5">${question.name}</span>
                                                ${question.required === 1 ? `<span class="fw-bolder fs-3 text-danger">*</span>` : ``}
                                            </div>
                                        </div>
                                        <div class="questionAnswerListDiv">
                                            <hr class="text-muted">
                                            <div class="row questionAnswerListRow">
                                                ${questionAnswerList}
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

    SubmitFormButton.click(function () {
        var formQuestions = $('.questionColumn');
        var formQuestionsData = [];
        $.each(formQuestions, function (i, question) {
            var questionId = $(question).data('question-id');
            var questionTypeId = $(question).data('question-type-id');
            var questionRequired = $(question).data('required');
            if (parseInt(questionTypeId) === 1) {
                questionAnswer = $(`input[name="question_${questionId}_answer"]`).val();
            } else if (parseInt(questionTypeId) === 2) {
                questionAnswer = $(`textarea[name="question_${questionId}_answer"]`).val();
            } else if (parseInt(questionTypeId) === 3) {
                questionAnswer = $(`input[name="question_${questionId}_answer"]:checked`).val();
            } else if (parseInt(questionTypeId) === 4) {
                questionAnswer = ``;
                $.each($(`input[name="question_${questionId}_answer"]:checked`), function (j, answer) {
                    questionAnswer += `${$(answer).val()},`;
                });
            } else if (parseInt(questionTypeId) === 5) {
                questionAnswer = $(`select[name="question_${questionId}_answer"]`).val();
            }

            if (questionRequired === 1 && questionAnswer === undefined) {
                toastr.error('Lütfen tüm soruları cevaplayınız.');
                return false;
            }

            formQuestionsData.push({
                questionId: questionId,
                questionTypeId: questionTypeId,
                answer: questionAnswer,
            });
        });

        $.ajax({
            type: 'post',
            url: '{{ route('home.api.formSubmit.submit') }}',
            headers: {
                'Accept': 'application/json',
            },
            data: {
                formId: formId,
                questionAnswers: formQuestionsData,
            },
            success: function () {
                toastr.success('Form başarıyla gönderildi.');
                setTimeout(function () {
                    location.reload();
                }, 2000);
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
