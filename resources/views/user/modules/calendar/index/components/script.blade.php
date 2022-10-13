<script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/fullcalendar/locales-all-min.js') }}"></script>

<script>

    $(document).ready(function () {
        $('#loader').hide();
    });

    var CreateNoteButton = $('#CreateNoteButton');
    var UpdateNoteButton = $('#UpdateNoteButton');
    var DeleteNoteButton = $('#DeleteNoteButton');

    function deleteNote() {
        $('#DeleteNoteModal').modal('show');
    }

    const element = document.getElementById("calendar");

    var todayDate = moment().startOf("day");
    var YM = todayDate.format("YYYY-MM");
    var YESTERDAY = todayDate.clone().subtract(1, "day").format("YYYY-MM-DD");
    var TODAY = todayDate.format("YYYY-MM-DD");
    var TOMORROW = todayDate.clone().add(1, "day").format("YYYY-MM-DD");

    var calendarEl = document.getElementById("calendar");
    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'tr',
        themeSystem: 'bootstrap5',
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth"
        },

        nowIndicator: true,
        now: TODAY + "T{{ date('H:i:s') }}",

        initialView: "dayGridMonth",
        initialDate: TODAY,

        editable: false,
        dayMaxEvents: true,
        navLinks: true,

        dateClick: function (info) {
            $('#create_note_date').val(info.dateStr);
            $('#create_note_title').val('');
            $('#create_note_note').val('');
            $('#CreateNoteModal').modal('show');
        },

        eventClick: function (info) {
            $('#loader').show();
            $('.fc-popover-close').click();
            $.ajax({
                type: 'get',
                url: '{{ route('user.api.note.getById') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: {
                    id: info.event.id
                },
                success: function (response) {
                    $('#update_note_id').val(response.response.id);
                    $('#update_note_date').val(response.response.date);
                    $('#update_note_title').val(response.response.title);
                    $('#update_note_note').val(response.response.note);
                    $('#UpdateNoteModal').modal('show');
                    $('#loader').hide();
                },
                error: function (error) {
                    console.log(error);
                    toastr.error('Not Verisi Alınırken Serviste Bir Sorun Oluştu!');
                    $('#loader').hide();
                }
            });
        },

        events: function (info, successCallback) {
            $('#loader').show();
            $.ajax({
                url: '{{ route('user.api.note.getByDateBetween') }}',
                dataType: 'json',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: {
                    startDate: info.startStr.valueOf(),
                    endDate: info.endStr.valueOf(),
                },
                success: function (response) {
                    var events = [];
                    $.each(response.response, function (i, note) {
                        events.push({
                            _id: note.id,
                            id: note.id,
                            title: `${note.title}`,
                            start: reformatDateForCalendar(note.date),
                            end: reformatDateForCalendar(note.date),
                            type: 'note',
                            classNames: `bg-primary text-white cursor-pointer ms-1 me-1`,
                            backgroundColor: 'white',
                            note_id: `${note.id}`
                        });
                    });
                    successCallback(events);
                    $('#loader').hide();
                },
                error: function (error) {
                    console.log(error);
                    toastr.error('Notlar Alınırken Serviste Bir sorun Oluştu!');
                    $('#loader').hide();
                }
            });
        },
    });

    calendar.render();

    CreateNoteButton.click(function () {
        var date = $('#create_note_date').val();
        var title = $('#create_note_title').val();
        var note = $('#create_note_note').val();

        if (!date) {
            toastr.warning('Not Tarihi Boş Olamaz!');
        } else {
            CreateNoteButton.attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            $.ajax({
                type: 'post',
                url: '{{ route('user.api.note.create') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: {
                    date: date,
                    title: title,
                    note: note,
                },
                success: function () {
                    toastr.success('Not Başarıyla Oluşturuldu!');
                    $('#CreateNoteModal').modal('hide');
                    calendar.refetchEvents();
                    CreateNoteButton.attr('disabled', false).html('Oluştur');
                },
                error: function (error) {
                    console.log(error);
                    CreateNoteButton.attr('disabled', false).html('Oluştur');
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

    UpdateNoteButton.click(function () {
        var id = $('#update_note_id').val();
        var date = $('#update_note_date').val();
        var title = $('#update_note_title').val();
        var note = $('#update_note_note').val();

        if (!date) {
            toastr.warning('Not Tarihi Boş Olamaz!');
        } else {
            UpdateNoteButton.attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            $.ajax({
                type: 'put',
                url: '{{ route('user.api.note.update') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: {
                    id: id,
                    date: date,
                    title: title,
                    note: note,
                },
                success: function () {
                    toastr.success('Not Başarıyla Güncellendi!');
                    $('#UpdateNoteModal').modal('hide');
                    calendar.refetchEvents();
                    UpdateNoteButton.attr('disabled', false).html('Güncelle');
                },
                error: function (error) {
                    console.log(error);
                    UpdateNoteButton.attr('disabled', false).html('Güncelle');
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

    DeleteNoteButton.click(function () {
        var id = $('#update_note_id').val();
        DeleteNoteButton.attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
        $.ajax({
            type: 'delete',
            url: '{{ route('user.api.note.delete') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: id,
            },
            success: function () {
                toastr.success('Not Başarıyla Silindi!');
                $('#UpdateNoteModal').modal('hide');
                $('#DeleteNoteModal').modal('hide');
                calendar.refetchEvents();
                DeleteNoteButton.attr('disabled', false).html('Sil');
            },
            error: function (error) {
                console.log(error);
                DeleteNoteButton.attr('disabled', false).html('Sil');
                toastr.error(error.responseJSON.message);
            }
        });
    });

</script>
