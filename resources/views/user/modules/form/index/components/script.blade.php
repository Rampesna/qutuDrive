<script>

    $(document).ready(function () {
        $('#loader').hide();
    });

    var forms = $('#forms');

    var page = $('#page');
    var pageUpButton = $('#pageUp');
    var pageDownButton = $('#pageDown');
    var pageSizeSelector = $('#pageSize');
    var FilterButton = $('#FilterButton');
    var ClearFilterButton = $('#ClearFilterButton');

    var keywordFilter = $('#keyword');

    var CreateFormButton = $('#CreateFormButton');
    var UpdateFormButton = $('#UpdateFormButton');
    var DeleteFormButton = $('#DeleteFormButton');

    function createForm() {
        $('#create_form_name').val('');
        $('#CreateFormModal').modal('show');
    }

    function openForm(id) {
        window.open(`{{ route('user.web.form.update') }}/${btoa(id)}`, '_blank');
    }

    function updateForm(id) {
        $('#loader').show();
        $('#update_form_id').val(id);
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.form.getById') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: id,
            },
            success: function (response) {
                $('#update_form_name').val(response.response.name);
                $('#UpdateFormModal').modal('show');
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

    function deleteForm(id) {
        $('#delete_form_id').val(id);
        $('#DeleteFormModal').modal('show');
    }

    function getForms() {
        forms.html(`<tr><td colspan="2" class="text-center fw-bolder"><i class="fa fa-lg fa-spinner fa-spin"></i></td></tr>`);
        var companyId = SelectedCompany.val();
        var pageIndex = parseInt(page.html()) - 1;
        var pageSize = pageSizeSelector.val();
        var keyword = keywordFilter.val();

        $.ajax({
            type: 'get',
            url: '{{ route('user.api.form.getByCompanyId') }}',
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
                forms.empty();
                $('#totalCountSpan').text(response.response.totalCount);
                $('#startCountSpan').text(parseInt(((pageIndex) * pageSize)) + 1);
                $('#endCountSpan').text(parseInt(parseInt(((pageIndex) * pageSize)) + 1) + parseInt(pageSize) > response.response.totalCount ? response.response.totalCount : parseInt(((pageIndex) * pageSize)) + 1 + parseInt(pageSize));
                $.each(response.response.forms, function (i, form) {
                    forms.append(`
                    <tr>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary btn-icon btn-sm" type="button" id="${form.id}_Dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-th"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="${form.id}_Dropdown" style="width: 175px">
                                    <a class="dropdown-item cursor-pointer mb-2 py-3 ps-6" onclick="openForm(${form.id})" title="Aç"><i class="fas fa-eye me-2 text-info"></i> <span class="text-dark">Aç</span></a>
                                    <a class="dropdown-item cursor-pointer mb-2 py-3 ps-6" onclick="updateForm(${form.id})" title="Yeniden Adlandır"><i class="fas fa-edit me-2 text-primary"></i> <span class="text-dark">Yeniden Adlandır</span></a>
                                    <hr class="text-muted">
                                    <a class="dropdown-item cursor-pointer py-3 ps-6" onclick="deleteForm(${form.id})" title="Sil"><i class="fas fa-trash-alt me-3 text-danger"></i> <span class="text-dark">Sil</span></a>
                                </div>
                            </div>
                        </td>
                        <td>
                            ${form.name ?? ''}
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

    getForms();

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
        getForms();
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

    CreateFormButton.click(function () {
        var name = $('#create_form_name').val();

        if (!name) {
            toastr.warning('Lütfen Başlık Girin!');
        } else {
            CreateFormButton.attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            $.ajax({
                type: 'post',
                url: '{{ route('user.api.form.create') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: {
                    companyId: SelectedCompany.val(),
                    name: name,
                },
                success: function () {
                    toastr.success('Form Başarıyla Kaydedildi!');
                    $('#CreateFormModal').modal('hide');
                    CreateFormButton.attr('disabled', false).html('Oluştur');
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

    UpdateFormButton.click(function () {
        var id = $('#update_form_id').val();
        var name = $('#update_form_name').val();

        if (!name) {
            toastr.warning('Lütfen Başlık Girin!');
        } else {
            UpdateFormButton.attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            $.ajax({
                type: 'put',
                url: '{{ route('user.api.form.update') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: {
                    id: id,
                    name: name,
                },
                success: function () {
                    toastr.success('Form Başarıyla Güncellendi!');
                    $('#UpdateFormModal').modal('hide');
                    UpdateFormButton.attr('disabled', false).html('Güncelle');
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

    DeleteFormButton.click(function () {
        var id = $('#delete_form_id').val();
        DeleteFormButton.attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
        $.ajax({
            type: 'delete',
            url: '{{ route('user.api.form.delete') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: id
            },
            success: function () {
                toastr.success('Form Başarıyla Silindi!');
                $('#DeleteFormModal').modal('hide');
                DeleteFormButton.attr('disabled', false).html('Sil');
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
