<script src="{{ asset('assets/plugins/custom/jkanban/jkanban.bundle.js') }}"></script>

<script>

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

    getProject();
    getProjectSubTasks();

</script>

<script>

    function controlMobile() {
        if (detectMobile()) {
            $('#updateTaskDrawer').attr('data-kt-drawer-width', '90%');
        } else {
            $('#updateTaskDrawer').attr('data-kt-drawer-width', '900px');
        }
    }

    controlMobile();

    var updateTaskDrawerButton = $('#updateTaskDrawerButton');
    var CreateSubTaskSelectedTaskButton = $('#CreateSubTaskSelectedTaskButton');
    var CreateSubTaskSelectedTaskInput = $('#CreateSubTaskSelectedTaskInput');
    var DeleteTaskButton = $('#DeleteTaskButton');
    var DeleteBoardButton = $('#DeleteBoardButton');
    var CreateCommentButton = $('#CreateCommentButton');
    var DeleteFileButton = $('#DeleteFileButton');

    var selectedTaskSubTasksRow = $('#selectedTaskSubTasksRow');
    var selectedTaskCommentsRow = $('#selectedTaskCommentsRow');
    var selectedTaskFilesRow = $('#selectedTaskFilesRow');

    $(document).delegate('.kanban-item', 'mouseover', function () {
        $(this).css({
            cursor: 'default'
        });
    });

    var updateTaskNameInput = $('#update_task_name');
    var updateTaskStartDateInput = $('#update_task_start_date');
    var updateTaskEndDateInput = $('#update_task_end_date');
    var updateTaskPriorityIdInput = $('#update_task_priority_id');
    var updateTaskRequesterIdInput = $('#update_task_requester_id');
    var updateTaskDescriptionInput = $('#update_task_description');

    var fileSelector = $('#fileSelector');

    // Kanban Definitions

    var kanban = new jKanban({
        element: '#boards',
        gutter: '0',
        widthBoard: '290px',
        dragBoards: true,
        click: function (el) {
            $('#selected_task_id').val(el.dataset.eid);
        },
        dragEl: function (el, source) {
            if (el.dataset.draggable === 'false') {
                kanban.drake.cancel();
            }
        },
        dropEl: function (el, source) {
            $.ajax({
                type: 'put',
                url: '{{ route('user.api.task.updateBoard') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: {
                    taskId: el.dataset.eid,
                    boardId: el.parentNode.parentNode.dataset.id
                }
            });
        },
        dragBoard: function (el, source) {
            if (el.dataset.id === '0') {
                board.drag.stop;
            } else {
                kanban.removeBoard('0');
            }
        },
        dragendBoard: function (el) {
            var allBoards = document.querySelectorAll('.kanban-board');
            if (allBoards.length > 0) {
                var boards = [];
                $.each(allBoards, function (i, board) {
                    boards.push({
                        id: parseInt(board.dataset.id),
                        order: parseInt(board.dataset.order)
                    });
                });
                $.ajax({
                    type: 'put',
                    url: '{{ route('user.api.board.updateOrder') }}',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': authUserToken
                    },
                    data: {
                        _token: '{{ csrf_token() }}',
                        boards: boards
                    },
                    success: function (response) {
                        var addBoard = kanban.findBoard('0');
                        if (addBoard == null) {
                            kanban.addBoards([
                                {
                                    id: '0',
                                    order: 99999,
                                    title: `
                                    <div class="row">
                                        <div id="CreateBoardButton" class="col-xl-12 bg-light-dark bg-hover-secondary text-center cursor-pointer" style="border-radius: 2rem">
                                            <span class="form-control mt-1 font-weight-bold text-dark-75" type="text" style="font-size: 12px; border: none; background: transparent">
                                                <i class="fa fa-plus fa-sm mr-2"></i>
                                                <span class="ms-2">Yeni Pano</span>
                                            </span>
                                        </div>
                                    </div>
                                    `,
                                    dragBoards: false,
                                    dragItems: false,
                                }
                            ]);
                        }
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }
        },
        dragendEl: function (el) {
            var allTasks = kanban.getBoardElements(el.parentNode.parentNode.dataset.id);
            var tasks = [];
            $.each(allTasks, function (i, task) {
                tasks.push({
                    id: parseInt(task.dataset.eid),
                    order: i + 1
                });
            });
            $.ajax({
                type: 'put',
                url: '{{ route('user.api.task.updateOrder') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: {
                    _token: '{{ csrf_token() }}',
                    tasks: tasks
                },
                success: function (response) {
                    fetchBoards();
                },
                error: function (error) {
                    console.log(error)
                }
            });
        },
        boards: []
    });

    function fetchBoards() {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.project.getBoardsByProjectId') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                projectId: parseInt('{{ $id }}'),
            },
            success: function (response) {
                console.log(response);
                $('.kanban-container').html('');

                var boardsList = [];
                $.each(response.response, function (i, board) {

                    var taskList = [];
                    $.each(board.tasks, function (j, task) {

                        var subTaskList = ``;
                        $.each(task.sub_tasks, function (k, subTask) {
                            var subTaskClass = subTask.checked === 1 ? 'fa fa-check-circle text-success' : 'fa fa-dot-circle text-warning';
                            subTaskList = subTaskList + `
                            <div class="col-xl-12 m-1" id="sub_task_id_${subTask.id}">
                                <i id="sub_task_icon_id_${subTask.id}" class="${subTaskClass}"></i>
                                <span class="ms-3" id="sub_task_name_id_${subTask.id}">${subTask.name}</span>
                            </div>
                            `;
                        });

                        taskList.push({
                            id: `${task.id}`,
                            class: task.priority ? ['border', `border-${task.priority.color}`] : [],
                            title: `
                                <div class="row">
                                    <div class="col-xl-10">
                                        <span data-id="${task.id}" class="taskTitle cursor-pointer ms-2">${task.name}</span>
                                    </div>
                                    <div class="col-xl-1 text-right">
                                        <i class="fas fa-sort-amount-down cursor-pointer sublistToggleIcon" data-id="${task.id}"></i>
                                    </div>
                                </div>
                                <div id="sublist_${task.id}" class="taskSublist" style="display: none">
                                    <hr>
                                    <div class="row" id="task_sublist_control_${task.id}">
                                        ${subTaskList}
                                    </div>
                                </div>
                                `,
                            order: '' + task.order + '',
                            draggable: true
                        });
                    });

                    taskList.push({
                        id: 'board_' + board.id + '_task_adder',
                        title: `
                                <div class="row mt-n3 mb-n3 taskAdderSelector">
                                    <div class="col-xl-12 pl-1 pr-0">
                                       <input data-board-id="${board.id}" type="text" class="form-control form-control-sm boardTaskAdder" placeholder="+ Görev Ekle" style="border: none">
                                    </div>
                                </div>
                                `,
                        order: '' + 99999 + '',
                        draggable: false,
                        class: ['opacity-60']
                    });

                    boardsList.push({
                        id: `${board.id}`,
                        title: `
                        <div class="row">
                            <div class="col-xl-1">
                               <i class="far fa-circle fa-sm mt-5 moveTaskIcon"></i>
                            </div>
                            <div class="col-xl-9">
                               <input data-id="${board.id}" class="form-control font-weight-bold moveTaskIcon updateBoardTitle" type="text" value="${board.name ?? ''}" style="color:gray; font-size: 15px; border: none; background: transparent">
                            </div>
                            <div class="col-xl-1 mt-2 text-right">
                                <div class="dropdown">
                                    <i class="fas fa-th cursor-pointer" id="${board.id}_Dropdown" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                    <div class="dropdown-menu" aria-labelledby="${board.id}_Dropdown" style="width: 175px">
                                        <a class="dropdown-item cursor-pointer py-3 ps-6" onclick="deleteBoard(${board.id})" title="Panoyu Sil"><i class="fas fa-trash-alt me-3 text-danger"></i> <span class="text-dark">Panoyu Sil</span></a>
                                    </div>
                                </div>
                           </div>
                        </div>
                        `,
                        item: taskList,
                        order: `${board.order}`
                    });
                });
                kanban.addBoards(boardsList);
                kanban.addBoards([
                    {
                        id: '0',
                        order: 99999,
                        title: `
                        <div class="row">
                            <div id="CreateBoardButton" class="col-xl-12 bg-light-dark bg-hover-secondary text-center cursor-pointer" style="border-radius: 2rem">
                                <span class="form-control mt-1 font-weight-bold text-dark-75" type="text" style="font-size: 12px; border: none; background: transparent">
                                    <i class="fa fa-plus fa-sm mr-2"></i>
                                    <span class="ms-2">Yeni Pano</span>
                                </span>
                            </div>
                        </div>
                        `,
                        dragBoards: false,
                        dragItems: false,
                    }
                ]);
            },
            error: function (error) {
                console.log(error)
            }
        });
    }

    fetchBoards();

    // General Functions

    function getTaskPriorities() {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.taskPriority.getAll') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {},
            success: function (response) {
                updateTaskPriorityIdInput.empty();
                $.each(response.response, function (i, taskPriority) {
                    updateTaskPriorityIdInput.append(`<option value="${taskPriority.id}">${taskPriority.name}</option>`);
                });
            },
            error: function (error) {
                console.log(error);
                toastr.error('Görev Öncelikleri Listesi Alınırken Serviste Bir Hata Oluştu.');
            }
        });
    }

    getTaskPriorities();

    // ------------------- Task Transactions Start -------------------

    $(document).delegate('.boardTaskAdder', 'keypress', function (e) {
        if (parseInt(e.which) === 13) {
            var boardId = $(this).data('board-id');
            var name = $(this).val();
            if (!name) {
                toastr.warning('Görev Adı Girmediniz!');
            } else {
                $.ajax({
                    type: 'post',
                    url: '{{ route('user.api.task.create') }}',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': authUserToken
                    },
                    data: {
                        boardId: boardId,
                        name: name
                    },
                    success: function () {
                        fetchBoards();
                    },
                    error: function (error) {
                        console.log(error);
                        toastr.error('Görev Oluşturulurken Serviste Bir Hata Oluştu.');
                    }
                });
            }
        }
    });

    // ------------------- Task Transactions End -------------------


    // ------------------- Board Transactions Start -------------------

    function deleteBoard(boardId) {
        $('#selected_board_id').val(boardId);
        $('#DeleteBoardModal').modal('show');
    }

    DeleteBoardButton.click(function () {
        var id = $('#selected_board_id').val();
        DeleteBoardButton.prop('disabled', true).html('<i class="fas fa-spinner fa-pulse"></i>');
        $.ajax({
            type: 'delete',
            url: '{{ route('user.api.board.delete') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: id,
            },
            success: function () {
                fetchBoards();
                toastr.success('Pano Başarıyla Silindi.');
                $('#DeleteBoardModal').modal('hide');
                DeleteBoardButton.prop('disabled', false).html('Panoyu Sil');
            },
            error: function (error) {
                console.log(error);
                toastr.error('Pano Silinirken Silerken Serviste Bir Hata Oluştu.');
                DeleteBoardButton.prop('disabled', false).html('Panoyu Sil');
            }
        });
    });

    $(document).delegate('#CreateBoardButton', 'click', function () {
        var button = $(this);
        button.attr('disabled', true).html(`
        <span class="form-control mt-1 font-weight-bold text-dark-75" type="text" style="font-size: 12px; border: none; background: transparent">
            <i class="fa fa-spinner fa-spin"></i>
        </span>
        `);

        var projectId = parseInt(`{{ $id }}`);
        var management = 0;

        $.ajax({
            type: 'post',
            url: '{{ route('user.api.board.create') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                projectId: projectId,
                management: management,
            },
            success: function () {
                fetchBoards();
            },
            error: function (error) {
                console.log(error);
                toastr.error('Pano Oluşturulurken Serviste Bir Hata Oluştu.');
                button.attr('disabled', false).html(`
                <span class="form-control mt-1 font-weight-bold text-dark-75" type="text" style="font-size: 12px; border: none; background: transparent">
                    <i class="fa fa-plus fa-sm mr-2"></i>
                    <span class="ms-2">Yeni Pano</span>
                </span>
                `);
            }
        });
    });

    $(document).delegate('.updateBoardTitle', 'focusout', function () {
        var id = $(this).data('id');
        var name = $(this).val();
        $.ajax({
            type: 'put',
            url: '{{ route('user.api.board.updateName') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: id,
                name: name,
            },
            error: function (error) {
                console.log(error);
                toastr.error('Pano Başlığı Güncellenirken Serviste Bir Hata Oluştu.');
            }
        });
    });

    // ------------------- Board Transactions End -------------------


    // ------------------- Selected Task Functions Start -------------------

    function getSelectedTask() {
        $('#loader').show();
        var id = $('#selected_task_id').val();
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.task.getById') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: id,
            },
            success: function (response) {
                updateTaskNameInput.val(response.response.name);
                updateTaskStartDateInput.val(response.response.start_date ? reformatDatetimeTo_YYYY_MM_DD(response.response.start_date) : '');
                updateTaskEndDateInput.val(response.response.end_date ? reformatDatetimeTo_YYYY_MM_DD(response.response.end_date) : '');
                updateTaskPriorityIdInput.val(response.response.priority_id).select2();
                updateTaskRequesterIdInput.val(response.response.requester_id);
                updateTaskDescriptionInput.val(response.response.description);
                $('#loader').hide();
            },
            error: function (error) {
                console.log(error);
                $('#loader').hide();
                toastr.error('Görev Verileri Alınırken Serviste Bir Sorun Olutşu!');
                updateTaskDrawerButton.trigger('click');
            }
        });
    }

    function getSelectedTaskFiles() {
        var id = $('#selected_task_id').val();
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.task.getFilesById') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: id,
            },
            success: function (response) {
                console.log(response);
            },
            error: function (error) {
                console.log(error);
                toastr.error('Görev Dosyaları Alınırken Serviste Bir Sorun Olutşu!');
            }
        });
    }

    function getSelectedTaskSubTasks() {
        var id = $('#selected_task_id').val();
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.task.getSubTasksById') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: id,
            },
            success: function (response) {
                selectedTaskSubTasksRow.empty();
                $.each(response.response, function (i, subTask) {
                    selectedTaskSubTasksRow.append(`
                    <div class="col-xl-12 mb-5">
                        <div class="input-group">
                            <button class="btn btn-icon btn-sm btn-${parseInt(subTask.checked) === 1 ? 'success' : 'warning'} setCheckedSubTaskButton" data-sub-task-id="${subTask.id}" data-sub-task-checked="${subTask.checked}">
                                <i class="fa fa-xs fa-check-circle"></i>
                            </button>
                            <input type="text" class="form-control form-control-sm form-control-solid selectedTaskSubTaskInput" data-sub-task-id="${subTask.id}" value="${subTask.name}" ${parseInt(subTask.checked) === 1 ? 'disabled' : ''} aria-label="Alt Görev Başlığı" style="border: none">
                            <button class="btn btn-icon btn-sm btn-danger deleteSubTaskButton" data-sub-task-id="${subTask.id}">
                                <i class="fa fa-sm fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                    `);
                });
            },
            error: function (error) {
                console.log(error);
                toastr.error('Göreve Ait Alt Görevler Alınırken Serviste Bir Sorun Olutşu!');
            }
        });
    }

    function getSelectedTaskComments() {
        var id = $('#selected_task_id').val();
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.task.getCommentsById') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: id,
            },
            success: function (response) {
                var avatar = `{{ asset('assets/media/logos/avatar.png') }}`;
                selectedTaskCommentsRow.empty();
                $.each(response.response, function (i, comment) {
                    selectedTaskCommentsRow.append(`
                    <div class="d-flex flex-wrap gap-2 flex-stack mb-10">
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-50 me-4">
                                <span class="symbol-label" style="background-image:url(${avatar});"></span>
                            </div>
                            <div class="pe-5">
                                <div class="d-flex align-items-center flex-wrap gap-1">
                                    <a href="#" class="fw-bolder text-dark text-hover-primary">${comment.creator ? comment.creator.name : '--'}</a>
                                    <span class="svg-icon svg-icon-7 svg-icon-success mx-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                            <circle fill="#000000" cx="12" cy="12" r="8"></circle>
                                        </svg>
                                    </span>
                                    <span class="text-muted fw-bolder me-5">${reformatDatetimeToDatetimeForHuman(comment.created_at)}</span>
                                </div>
                                <div class="text-muted fw-bold mw-450px" data-kt-inbox-message="preview">${comment.comment}</div>
                            </div>
                        </div>
                    </div>
                    `);
                });
            },
            error: function (error) {
                console.log(error);
                toastr.error('Göreve Ait Yorumlar Alınırken Serviste Bir Sorun Olutşu!');
            }
        });
    }

    function deleteTask() {
        $('#DeleteTaskModal').modal('show');
    }

    function taskFiles() {
        $('#TaskFilesModal').modal('show');
        var taskId = $('#selected_task_id').val();
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.file.getByRelation') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                relationId: taskId,
                relationType: 'App\\Models\\Eloquent\\Task'
            },
            success: function (response) {
                var fileUploadSvg = `{{ asset('assets/media/svg/files/upload.svg') }}`;
                var fileSvg = `{{ asset('assets/media/icons/duotune/files/fil003.svg') }}`;
                selectedTaskFilesRow.empty().append(`
                <div class="col-xl-3 mb-5">
                    <div class="card h-100 flex-center border-dashed p-8 cursor-pointer" id="fileUploadArea">
                        <img src="${fileUploadSvg}" class="mb-8" alt="" />
                        <a class="font-weight-bolder text-dark-75 mb-2">Yeni Dosya</a>
                        <div class="fs-7 fw-bold text-gray-400 mt-auto">Yüklemek İçin Tıklayın</div>
                    </div>
                </div>
                `);
                $.each(response.response, function (i, file) {
                    selectedTaskFilesRow.append(`
                    <div class="col-xl-3 mb-5">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card h-100 flex-center text-center border-dashed p-8" data-id="${file.id}" id="file_${file.id}">
                                    <img src="${fileSvg}" class="w-25 mb-8" alt="" />
                                    <a class="font-weight-bolder text-dark-75 mb-2">${file.name}</a>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <i class="fa fa-download text-primary me-3 cursor-pointer" onclick="downloadFile(${file.id})"></i>
                                            <i class="fa fa-trash text-danger cursor-pointer" onclick="deleteFile(${file.id})"></i>
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
    }

    // ------------------- Selected Task Functions End -------------------


    // ------------------- Selected Task Transactions Start -------------------

    $(document).delegate('.taskTitle', 'click', function () {
        var taskId = $(this).data('id');
        $('#selected_task_id').val(taskId);
        getSelectedTask();
        getSelectedTaskSubTasks();
        getSelectedTaskComments();
        updateTaskDrawerButton.trigger('click');
    });

    updateTaskNameInput.focusout(function () {
        var id = $('#selected_task_id').val();
        var name = $(this).val();

        if (!name) {
            toastr.warning('Görev Adı Boş Olamaz! Değişiklikler Kaydedilmedi');
        } else {
            var parameters = [{
                attribute: 'name',
                value: name
            }];

            updateTaskNameInput.attr('disabled', true);

            $.ajax({
                type: 'put',
                url: '{{ route('user.api.task.updateByParameters') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: {
                    id: id,
                    parameters: parameters
                },
                success: function () {
                    fetchBoards();
                    updateTaskNameInput.attr('disabled', false);
                },
                error: function (error) {
                    console.log(error);
                    toastr.error('Görev Başlığı Güncellenirken Serviste Bir Sorun Olutşu!');
                    updateTaskNameInput.attr('disabled', false);
                }
            });
        }
    });

    updateTaskNameInput.keypress(function (e) {
        if (e.which === 13) {
            updateTaskNameInput.attr('disabled', true);
        }
    });

    updateTaskStartDateInput.focusout(function () {
        var id = $('#selected_task_id').val();
        var startDate = $(this).val();
        var parameters = [{
            attribute: 'start_date',
            value: startDate
        }];

        updateTaskStartDateInput.attr('disabled', true);

        $.ajax({
            type: 'put',
            url: '{{ route('user.api.task.updateByParameters') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: id,
                parameters: parameters
            },
            success: function () {
                updateTaskStartDateInput.attr('disabled', false);
            },
            error: function (error) {
                console.log(error);
                toastr.error('Görev Başlangıç Tarihi Güncellenirken Serviste Bir Sorun Olutşu!');
                updateTaskStartDateInput.attr('disabled', false);
            }
        });
    });

    updateTaskStartDateInput.keypress(function (e) {
        if (e.which === 13) {
            updateTaskStartDateInput.attr('disabled', true);
        }
    });

    updateTaskEndDateInput.focusout(function () {
        var id = $('#selected_task_id').val();
        var startDate = $(this).val();
        var parameters = [{
            attribute: 'end_date',
            value: startDate
        }];

        updateTaskEndDateInput.attr('disabled', true);

        $.ajax({
            type: 'put',
            url: '{{ route('user.api.task.updateByParameters') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: id,
                parameters: parameters
            },
            success: function () {
                updateTaskEndDateInput.attr('disabled', false);
            },
            error: function (error) {
                console.log(error);
                toastr.error('Görev Bitiş Tarihi Güncellenirken Serviste Bir Sorun Olutşu!');
                updateTaskEndDateInput.attr('disabled', false);
            }
        });
    });

    updateTaskEndDateInput.keypress(function (e) {
        if (e.which === 13) {
            updateTaskEndDateInput.attr('disabled', true);
        }
    });

    updateTaskPriorityIdInput.change(function (e) {
        var id = $('#selected_task_id').val();
        var priorityId = $(this).val();
        var parameters = [{
            attribute: 'priority_id',
            value: priorityId
        }];

        updateTaskPriorityIdInput.attr('disabled', true);

        $.ajax({
            type: 'put',
            url: '{{ route('user.api.task.updateByParameters') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: id,
                parameters: parameters
            },
            success: function () {
                fetchBoards();
                updateTaskPriorityIdInput.attr('disabled', false);
            },
            error: function (error) {
                console.log(error);
                toastr.error('Görev Öncelik Durumu Güncellenirken Serviste Bir Sorun Olutşu!');
                updateTaskPriorityIdInput.attr('disabled', false);
            }
        });
    });

    updateTaskRequesterIdInput.change(function (e) {
        var id = $('#selected_task_id').val();
        var requesterId = $(this).val();
        var parameters = [{
            attribute: 'requester_id',
            value: requesterId
        }];

        updateTaskRequesterIdInput.attr('disabled', true);

        $.ajax({
            type: 'put',
            url: '{{ route('user.api.task.updateByParameters') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: id,
                parameters: parameters
            },
            success: function () {
                updateTaskRequesterIdInput.attr('disabled', false);
            },
            error: function (error) {
                console.log(error);
                toastr.error('Görev Talep Sahibi Güncellenirken Serviste Bir Sorun Olutşu!');
                updateTaskRequesterIdInput.attr('disabled', false);
            }
        });
    });

    updateTaskDescriptionInput.focusout(function () {
        var id = $('#selected_task_id').val();
        var description = $(this).val();
        var parameters = [{
            attribute: 'description',
            value: description
        }];

        updateTaskDescriptionInput.attr('disabled', true);

        $.ajax({
            type: 'put',
            url: '{{ route('user.api.task.updateByParameters') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: id,
                parameters: parameters
            },
            success: function () {
                updateTaskDescriptionInput.attr('disabled', false);
            },
            error: function (error) {
                console.log(error);
                toastr.error('Görev Açıklaması Güncellenirken Serviste Bir Sorun Olutşu!');
                updateTaskDescriptionInput.attr('disabled', false);
            }
        });
    });

    DeleteTaskButton.click(function () {
        var id = $('#selected_task_id').val();
        DeleteTaskButton.attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
        $.ajax({
            type: 'delete',
            url: '{{ route('user.api.task.delete') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: id,
            },
            success: function () {
                updateTaskDrawerButton.trigger('click');
                fetchBoards();
                toastr.success('Görev Başarıyla Silindi!');
                DeleteTaskButton.attr('disabled', false).html('Görevi Sil');
                $('#DeleteTaskModal').modal('hide');
            },
            error: function (error) {
                console.log(error);
                toastr.error('Görev Silinirken Serviste Bir Sorun Oluştu!');
                DeleteTaskButton.attr('disabled', false).html('Görevi Sil');
            }
        });
    });

    CreateCommentButton.click(function () {
        var relationType = 'App\\Models\\Eloquent\\Task';
        var relationId = $('#selected_task_id').val();
        var comment = $('#create_comment_comment').val();

        if (!comment) {
            toastr.warning('Yorumunuzu Girmediniz!');
        } else {
            CreateCommentButton.attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            $.ajax({
                type: 'post',
                url: '{{ route('user.api.comment.create') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: {
                    relationType: relationType,
                    relationId: relationId,
                    comment: comment
                },
                success: function () {
                    $('#create_comment_comment').val('');
                    toastr.success('Yorumunuz Başarıyla Eklendi!');
                    CreateCommentButton.attr('disabled', false).html('Yanıtla');
                    getSelectedTaskComments();
                },
                error: function (error) {
                    console.log(error);
                    toastr.error('Yorumunuz Eklenirken Serviste Bir Sorun Oluştu!');
                    CreateCommentButton.attr('disabled', false).html('Yanıtla');
                }
            });
        }
    });

    $(document).delegate(".sublistToggleIcon", "click", function () {
        $("#sublist_" + $(this).data('id')).slideToggle();
    });

    $(document).delegate('#fileUploadArea', 'click', function () {
        fileSelector.click();
    });

    fileSelector.change(function () {
        var taskId = $('#selected_task_id').val();
        var data = new FormData();
        data.append('relationType', 'App\\Models\\Eloquent\\Task');
        data.append('relationId', parseInt(taskId));
        data.append('file', fileSelector[0].files[0]);
        data.append('filePath', 'uploads/task/{{ $id }}/files/');
        uploadFile(data);
    });

    function uploadFile(data) {
        $.ajax({
            contentType: false,
            processData: false,
            type: 'post',
            url: '{{ route('user.api.file.upload') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: data,
            success: function () {
                toastr.success('Dosya Yüklendi');
                taskFiles();
            },
            error: function (error) {
                console.log(error);
                toastr.error('Dosya Yüklenirken Bir Sorun Oluştu.');
            }
        });
    }

    function downloadFile(id) {
        window.open(`{{ route('user.web.file.download') }}/${id}`, '_blank');
    }

    function deleteFile(id) {
        $('#delete_file_id').val(id);
        $('#DeleteFileModal').modal('show');
    }

    DeleteFileButton.click(function () {
        DeleteFileButton.attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
        var id = $('#delete_file_id').val();
        $.ajax({
            type: 'delete',
            url: '{{ route('user.api.file.delete') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: id,
            },
            success: function () {
                toastr.success('Dosya Silindi');
                DeleteFileButton.attr('disabled', false).html('Sil');
                $('#DeleteFileModal').modal('hide');
                taskFiles();
            },
            error: function (error) {
                console.log(error);
                DeleteFileButton.attr('disabled', false).html('Sil');
                toastr.error('Dosya Silinirken Bir Sorun Oluştu.');
            }
        });
    });

    // ------------------- Selected Task Transactions End -------------------


    // ------------------- Sub Task Transactions Start -------------------

    CreateSubTaskSelectedTaskButton.click(function () {
        var taskId = $('#selected_task_id').val();
        var name = CreateSubTaskSelectedTaskInput.val();

        if (!name) {
            toastr.warning('Alt Görev Adı Boş Olamaz!');
        } else {
            CreateSubTaskSelectedTaskInput.attr('disabled', true);
            $.ajax({
                type: 'post',
                url: '{{ route('user.api.subTask.create') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: {
                    taskId: taskId,
                    name: name,
                },
                success: function () {
                    CreateSubTaskSelectedTaskInput.val('');
                    CreateSubTaskSelectedTaskInput.attr('disabled', false);
                    fetchBoards();
                    getSelectedTaskSubTasks();
                },
                error: function (error) {
                    console.log(error);
                    CreateSubTaskSelectedTaskInput.attr('disabled', true);
                    toastr.error('Yeni Alt Görev Oluşturulurken Serviste Bir Sorun Olutşu!');
                }
            });
        }
    });

    $(document).delegate('.setCheckedSubTaskButton', 'click', function () {
        $(this).attr('disabled', true).html(`<i class="fa fa-spinner fa-spin"></i>`);
        var id = $(this).data('sub-task-id');
        var checked = $(this).data('sub-task-checked');
        $.ajax({
            type: 'put',
            url: '{{ route('user.api.subTask.setChecked') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: id,
                checked: parseInt(checked) === 1 ? 0 : 1,
            },
            success: function () {
                fetchBoards();
                getSelectedTaskSubTasks();
            },
            error: function (error) {
                console.log(error);
                toastr.error('Alt Görev Silinirken Serviste Bir Sorun Olutşu!');
            }
        });
    });

    $(document).delegate('.selectedTaskSubTaskInput', 'focusout', function () {
        var id = $(this).data('sub-task-id');
        var name = $(this).val();

        if (!name) {
            toastr.warning('Alt Görev Adı Boş Olamaz! Değişiklikler Kaydedilmedi!');
        } else {
            $(this).attr('disabled', true);
            $.ajax({
                type: 'put',
                url: '{{ route('user.api.subTask.update') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: {
                    id: id,
                    name: name,
                },
                success: function () {
                    fetchBoards();
                    getSelectedTaskSubTasks();
                },
                error: function (error) {
                    console.log(error);
                    toastr.error('Alt Görev Güncellenirken Serviste Bir Sorun Olutşu!');
                }
            });
        }
    });

    $(document).delegate('.selectedTaskSubTaskInput', 'keypress', function (e) {
        if (e.which === 13) {
            var id = $(this).data('sub-task-id');
            var name = $(this).val();

            if (!name) {
                toastr.warning('Alt Görev Adı Boş Olamaz! Değişiklikler Kaydedilmedi!');
            } else {
                $(this).attr('disabled', true);
                $.ajax({
                    type: 'put',
                    url: '{{ route('user.api.subTask.update') }}',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': authUserToken
                    },
                    data: {
                        id: id,
                        name: name,
                    },
                    success: function () {
                        fetchBoards();
                        getSelectedTaskSubTasks();
                    },
                    error: function (error) {
                        console.log(error);
                        toastr.error('Alt Görev Güncellenirken Serviste Bir Sorun Olutşu!');
                    }
                });
            }
        }
    });

    $(document).delegate('.deleteSubTaskButton', 'click', function () {
        $(this).attr('disabled', true).html(`<i class="fa fa-spinner fa-spin"></i>`);
        var id = $(this).data('sub-task-id');
        $.ajax({
            type: 'delete',
            url: '{{ route('user.api.subTask.delete') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: id,
            },
            success: function () {
                fetchBoards();
                getSelectedTaskSubTasks();
            },
            error: function (error) {
                console.log(error);
                toastr.error('Alt Görev Silinirken Serviste Bir Sorun Olutşu!');
            }
        });
    });

    CreateSubTaskSelectedTaskInput.on('keypress', function (e) {
        if (e.which === 13) {
            CreateSubTaskSelectedTaskButton.trigger('click');
        }
    });

    // ------------------- Sub Task Transactions End -------------------

</script>
