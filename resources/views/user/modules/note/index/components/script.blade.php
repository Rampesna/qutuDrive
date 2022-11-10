<script>

    $(document).ready(function () {
        $('#loader').hide();
    });

    var generalNotes = $('#generalNotes');

    var page = $('#page');
    var pageUpButton = $('#pageUp');
    var pageDownButton = $('#pageDown');
    var pageSizeSelector = $('#pageSize');
    var FilterButton = $('#FilterButton');
    var ClearFilterButton = $('#ClearFilterButton');

    var keywordFilter = $('#keyword');

    var CreateGeneralNoteButton = $('#CreateGeneralNoteButton');
    var UpdateGeneralNoteButton = $('#UpdateGeneralNoteButton');
    var DeleteGeneralNoteButton = $('#DeleteGeneralNoteButton');

    function createGeneralNote() {
        $('#create_general_note_title').val('');
        $('#create_general_note_note').val('');
        $('#CreateGeneralNoteModal').modal('show');
    }

    function updateGeneralNote(id) {
        $('#loader').show();
        $('#update_general_note_id').val(id);
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.generalNote.getById') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: id,
            },
            success: function (response) {
                $('#update_general_note_title').val(response.response.title);
                $('#update_general_note_note').val(response.response.note);
                $('#UpdateGeneralNoteModal').modal('show');
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

    function deleteGeneralNote(id) {
        $('#delete_general_note_id').val(id);
        $('#DeleteGeneralNoteModal').modal('show');
    }

    function getGeneralNotes() {
        generalNotes.html(`<tr><td colspan="2" class="text-center fw-bolder"><i class="fa fa-lg fa-spinner fa-spin"></i></td></tr>`);
        var companyId = SelectedCompany.val();
        var pageIndex = parseInt(page.html()) - 1;
        var pageSize = pageSizeSelector.val();
        var keyword = keywordFilter.val();

        $.ajax({
            type: 'get',
            url: '{{ route('user.api.generalNote.index') }}',
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
                generalNotes.empty();
                $('#totalCountSpan').text(response.response.totalCount);
                $('#startCountSpan').text(parseInt(((pageIndex) * pageSize)) + 1);
                $('#endCountSpan').text(parseInt(parseInt(((pageIndex) * pageSize)) + 1) + parseInt(pageSize) > response.response.totalCount ? response.response.totalCount : parseInt(((pageIndex) * pageSize)) + 1 + parseInt(pageSize));
                $.each(response.response.generalNotes, function (i, generalNote) {
                    generalNotes.append(`
                    <tr>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary btn-icon btn-sm" type="button" id="${generalNote.id}_Dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-th"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="${generalNote.id}_Dropdown" style="width: 175px">
                                    <a class="dropdown-item cursor-pointer mb-2 py-3 ps-6" onclick="updateGeneralNote(${generalNote.id})" title="Düzenle"><i class="fas fa-edit me-2 text-primary"></i> <span class="text-dark">Düzenle</span></a>
                                    <hr class="text-muted">
                                    <a class="dropdown-item cursor-pointer py-3 ps-6" onclick="deleteGeneralNote(${generalNote.id})" title="Sil"><i class="fas fa-trash-alt me-3 text-danger"></i> <span class="text-dark">Sil</span></a>
                                </div>
                            </div>
                        </td>
                        <td>
                            ${generalNote.title ?? ''}
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

    getGeneralNotes();

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
        getGeneralNotes();
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

    CreateGeneralNoteButton.click(function () {
        var title = $('#create_general_note_title').val();
        var note = $('#create_general_note_note').val();

        if (!title) {
            toastr.warning('Lütfen not başlığı giriniz.');
        } else {
            CreateGeneralNoteButton.attr('disabled', true).html(`<i class="fa fa-spinner fa-spin"></i>`);
            $.ajax({
                type: 'post',
                url: '{{ route('user.api.generalNote.create') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: {
                    companyId: SelectedCompany.val(),
                    title: title,
                    note: note,
                },
                success: function () {
                    CreateGeneralNoteButton.attr('disabled', false).html(`Oluştur`);
                    $('#CreateGeneralNoteModal').modal('hide');
                    toastr.success('Not başarıyla eklendi.');
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

    UpdateGeneralNoteButton.click(function () {
        var id = $('#update_general_note_id').val();
        var title = $('#update_general_note_title').val();
        var note = $('#update_general_note_note').val();

        if (!title) {
            toastr.warning('Lütfen not başlığı giriniz.');
        } else {
            UpdateGeneralNoteButton.attr('disabled', true).html(`<i class="fa fa-spinner fa-spin"></i>`);
            $.ajax({
                type: 'put',
                url: '{{ route('user.api.generalNote.update') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: {
                    id: id,
                    title: title,
                    note: note,
                },
                success: function () {
                    UpdateGeneralNoteButton.attr('disabled', false).html(`Güncelle`);
                    $('#UpdateGeneralNoteModal').modal('hide');
                    toastr.success('Not başarıyla güncellendi.');
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

    DeleteGeneralNoteButton.click(function () {
        var id = $('#delete_general_note_id').val();
        DeleteGeneralNoteButton.attr('disabled', true).html(`<i class="fa fa-spinner fa-spin"></i>`);
        $.ajax({
            type: 'delete',
            url: '{{ route('user.api.generalNote.delete') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: id,
            },
            success: function () {
                DeleteGeneralNoteButton.attr('disabled', false).html(`Sil`);
                $('#DeleteGeneralNoteModal').modal('hide');
                toastr.success('Not başarıyla silindi.');
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
