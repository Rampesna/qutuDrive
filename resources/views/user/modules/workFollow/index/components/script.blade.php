<script>

    var projectsRow = $('#projects');
    var keywordFilter = $('#keyword');
    var statusIdsFilter = $('#statusIds');

    var FilterButton = $('#FilterButton');
    var ClearFilterButton = $('#ClearFilterButton');

    var CreateProjectButton = $('#CreateProjectButton');

    var createProjectCompanyId = $('#create_project_company_id');
    var createProjectUserIds = $('#create_project_user_ids');

    function createProject() {
        createProjectCompanyId.val('').trigger('change');
        createProjectUserIds.val([]).trigger('change');
        $('#create_project_name').val('');
        $('#create_project_code').val('');
        $('#create_project_start_date').val('');
        $('#create_project_end_date').val('');
        $('#create_project_description').val('');
        $('#CreateProjectModal').modal('show');
    }

    function getCompanies() {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.getCompanies') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {},
            success: function (response) {
                console.log(response);
                createProjectCompanyId.empty();
                $.each(response.response, function (i, company) {
                    createProjectCompanyId.append($('<option>', {
                        value: company.ID,
                        text: company.FIRMAUNVAN
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

    function getUsers() {

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
                statusIdsFilter.empty();
                $.each(response.response, function (i, projectStatus) {
                    statusIdsFilter.append(
                        $('<option>', {
                            value: projectStatus.id,
                            text: projectStatus.name
                        })
                    );
                });
                statusIdsFilter.trigger('change');
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

    getCompanies();
    getUsers();
    getProjectStatuses();

    function getProjects() {
        $('#loader').show();
        var companyId = SelectedCompany.val();
        var keyword = keywordFilter.val();
        var statusIds = statusIdsFilter.val();

        $.ajax({
            type: 'get',
            url: '{{ route('user.api.project.index') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                companyId: companyId,
                pageIndex: 0,
                pageSize: -1,
                orderBy: 'id',
                orderType: 'desc',
                keyword: keyword,
                statusIds: statusIds,
                with: ['status']
            },
            success: function (response) {
                console.log(response);
                var imageUrl = '{{ asset('assets/media/svg/brand-logos/xing-icon.svg') }}';
                projectsRow.empty();
                $.each(response.response.projects, function (i, project) {
                    var overviewRoute = `{{ route('user.web.workFollow.overview') }}/${project.id}`;
                    projectsRow.append(`
                    <div class="col-md-6 col-xl-4 mb-5">
                        <div class="card border-hover-primary">
                            <div class="card-header border-0 pt-9">
                                <div class="card-title m-0">
                                    <a href="${overviewRoute}" class="symbol symbol-50px w-50px bg-light">
                                        <img src="${imageUrl}" alt="image" class="p-3">
                                    </a>
                                </div>
                                <div class="card-toolbar">
                                    <span class="badge badge-light-${project.status ? project.status.color : 'info'} fw-bolder me-auto px-4 py-3">${project.status ? project.status.name : '--'}</span>
                                </div>
                            </div>
                            <div class="card-body p-9">
                                <a href="${overviewRoute}" class="fs-3 fw-bolder text-dark">${project.name}</a>
                                <p></p>
                                <div class="bg-primary rounded h-8px" role="progressbar" style="width: ${project.progress}%" aria-valuenow="${project.progress}" aria-valuemin="0" aria-valuemax="100"></div>
                                <div class="row">
                                    <div class="col-xl-12 mt-2 text-end">
                                        <span class="fw-bolder">${project.progress}%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    `);
                });

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

    getProjects();

    FilterButton.click(function () {
        getProjects();
    });

    ClearFilterButton.click(function () {
        keywordFilter.val('');
        statusIdsFilter.val([]).trigger('change');
        getProjects();
    });

    keywordFilter.on('keypress', function (e) {
        if (e.which === 13) {
            getProjects();
        }
    });

    CreateProjectButton.click(function () {
        var companyId = createProjectCompanyId.val();
        var name = $('#create_project_name').val();
        var startDate = $('#create_project_start_date').val();
        var endDate = $('#create_project_end_date').val();
        var description = $('#create_project_description').val();

        if (!companyId) {
            toastr.warning('Firma Seçimi Yapılmamış!');
        } else if (!name) {
            toastr.warning('Proje Adı Girilmemiş!');
        } else {
            CreateProjectButton.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            $.ajax({
                type: 'post',
                url: '{{ route('user.api.project.create') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: {
                    companyId: companyId,
                    name: name,
                    startDate: startDate,
                    endDate: endDate,
                    description: description,
                },
                success: function (response) {
                    console.log(response);
                    $.ajax({
                        type: 'post',
                        url: '{{ route('user.api.project.setUsersByProjectId') }}',
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': authUserToken
                        },
                        data: {
                            projectId: response.response.id,
                            userIds: createProjectUserIds.val()
                        },
                        success: function () {
                            toastr.success('Proje Başarıyla Oluşturuldu!');
                            $('#CreateProjectModal').modal('hide');
                            getProjects();
                            CreateProjectButton.prop('disabled', false).html('Oluştur');
                        },
                        error: function (error) {
                            console.log(error);
                            toastr.error('Proje Oluşturuldu Ancak Kullanıcılar Bağlanırken Serviste Bir Sorun Oluştu!');
                            CreateProjectButton.prop('disabled', false).html('Oluştur');
                        }
                    });
                },
                error: function (error) {
                    CreateProjectButton.prop('disabled', false).html('Oluştur');
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

</script>
