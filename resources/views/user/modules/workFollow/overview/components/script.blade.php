<script>

    const primary = '#6993FF';
    const success = '#1BC5BD';
    const info = '#8950FC';
    const warning = '#FFA800';
    const danger = '#F64E60';
    const aqua = '#00fffb';
    const brown = '#704300';
    const darkRed = '#b90000';

    var updateProjectCompanyId = $('#update_project_company_id');
    var updateProjectStatusId = $('#update_project_status_id');
    var updateProjectUserIds = $('#update_project_user_ids');

    function getCompanies() {
        updateProjectCompanyId.empty();
        $.each(userCompanies, function (i, company) {
            updateProjectCompanyId.append($('<option>', {
                value: company.ID,
                text: company.FIRMAUNVAN
            }));
        });
    }

    function getProjectStatuses() {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.projectStatus.getAll') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {},
            success: function (response) {
                updateProjectStatusId.empty();
                $.each(response.response, function (i, status) {
                    updateProjectStatusId.append($('<option>', {
                        value: status.id,
                        text: status.name
                    }));
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

    function getProject() {
        var id = parseInt('{{ $id }}');
        $('#loader').show();
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.project.getById') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: id,
            },
            success: function (response) {
                $('#projectNameSpan').text(response.response.name);
                $('#projectStatusBadge').text(response.response.status ? response.response.status.name : '--').addClass(`badge-light-${response.response.status ? response.response.status.color : 'info'}`);
                $('#projectDescription').html(response.response.description ?? '');
                $('#projectEndDateSpan').text(response.response.end_date ? reformatDatetimeToDateForHuman(response.response.end_date) : '--');
                $('#loader').hide();
            },
            error: function (error) {
                console.log(error);
                if (parseInt(error.status) === 404) {
                    toastr.error('Proje Bulunamadı!');
                } else {
                    toastr.error('Proje Bilgileri Alınırken Serviste Bir Sorun Oluştu!');
                }
                $('#loader').hide();
            }
        });
    }

    function getProjectSubTasks() {
        var projectId = parseInt('{{ $id }}');
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.project.getSubtasksByProjectId') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                projectId: projectId,
            },
            success: function (response) {
                var waitingSubTasks = 0;
                $.each(response.response, function (i, subTask) {
                    if (parseInt(subTask.checked) === 0) {
                        waitingSubTasks++;
                    }
                });
                $('#projectWaitingTasksSpan').text(waitingSubTasks);
            },
            error: function (error) {
                console.log(error);
                if (parseInt(error.status) === 404) {
                    toastr.error('Proje Bulunamadı!');
                } else {
                    toastr.error('Proje Bilgileri Alınırken Serviste Bir Sorun Oluştu!');
                }
            }
        });
    }

    getCompanies();
    getProjectStatuses();
    getProject();
    getProjectSubTasks();

</script>

<script>

    function updateProject() {
        var id = parseInt(`{{ $id }}`);
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.project.getById') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': token
            },
            data: {
                id: id,
            },
            success: function (response) {
                updateProjectCompanyId.val(response.response.company_id);
                updateProjectStatusId.val(response.response.status_id);
                $('#update_project_name').val(response.response.name);
                $('#update_project_code').val(response.response.code);
                $('#update_project_start_date').val(response.response.start_date);
                $('#update_project_end_date').val(response.response.end_date);
                $('#update_project_description').val(response.response.description);
                $.ajax({
                    type: 'get',
                    url: '{{ route('user.api.project.getUsersByProjectId') }}',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': token
                    },
                    data: {
                        projectId: id,
                    },
                    success: function (response) {
                        updateProjectUserIds.val(
                            $.map(response.response, function (user) {
                                return user.id;
                            })
                        );
                        $('#UpdateProjectModal').modal('show');
                    },
                    error: function (error) {
                        console.log(error);
                        toastr.error('Proje Kullanıcıları Alınırken Serviste Bir Sorun Oluştu!');
                    }
                });
            },
            error: function (error) {
                console.log(error);
                if (parseInt(error.status) === 404) {
                    toastr.error('Proje Bulunamadı!');
                } else {
                    toastr.error('Proje Bilgileri Alınırken Serviste Bir Sorun Oluştu!');
                }
            }
        });
    }

    var UpdateProjectButton = $('#UpdateProjectButton');

    UpdateProjectButton.click(function () {
        var id = parseInt(`{{ $id }}`);
        var companyId = updateProjectCompanyId.val();
        var statusId = updateProjectStatusId.val();
        var name = $('#update_project_name').val();
        var code = $('#update_project_code').val();
        var startDate = $('#update_project_start_date').val();
        var endDate = $('#update_project_end_date').val();
        var description = $('#update_project_description').val();

        if (!companyId) {
            toastr.warning('Firma Seçimi Yapılmamış!');
        } else if (!statusId) {
            toastr.warning('Proje Durumu Seçilmemiş!');
        } else if (!name) {
            toastr.warning('Proje Adı Girilmemiş!');
        } else {
            UpdateProjectButton.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            $.ajax({
                type: 'put',
                url: '{{ route('user.api.project.update') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': token
                },
                data: {
                    id: id,
                    companyId: companyId,
                    statusId: statusId,
                    name: name,
                    code: code,
                    startDate: startDate,
                    endDate: endDate,
                    description: description,
                },
                success: function () {
                    $.ajax({
                        type: 'post',
                        url: '{{ route('user.api.project.setUsersByProjectId') }}',
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': token
                        },
                        data: {
                            projectId: id,
                            userIds: updateProjectUserIds.val()
                        },
                        success: function () {
                            toastr.success('Proje Başarıyla Güncellendi!');
                            $('#UpdateProjectModal').modal('hide');
                            getProject();
                            UpdateProjectButton.prop('disabled', false).html('Güncelle');
                        },
                        error: function (error) {
                            console.log(error);
                            toastr.error('Proje Güncellendi Ancak Kullanıcılar Bağlanırken Serviste Bir Sorun Oluştu!');
                            UpdateProjectButton.prop('disabled', false).html('Güncelle');
                        }
                    });
                },
                error: function (error) {
                    console.log(error);
                    toastr.error('Proje Güncellenirken Serviste Bir Sorun Oluştu!');
                    UpdateProjectButton.prop('disabled', false).html('Güncelle');
                }
            });
        }
    });

</script>
