<div id="updateTaskDrawer"
     class=""
     data-kt-drawer="true"
     data-kt-drawer-activate="true"
     data-kt-drawer-toggle="#updateTaskDrawerButton"
     data-kt-drawer-close="#updateTaskDrawerCloseButton"
     data-kt-drawer-width="90%">

    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="row mt-6">
                    <div class="col-xl-12">
                        <div class="input-group mb-5">
                            <input type="text" class="form-control form-control-solid" id="update_task_name" aria-label="Görev Başlığı" style="border: none">
                            <button class="btn btn-icon btn-danger" onclick="deleteTask()">
                                <i class="fa fa-sm fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <hr class="text-muted mt-n2">
                <div class="row mt-3">
                    <div class="col-xl-3 mt-3">
                        <span class="font-weight-bold">Başlangıç / Bitiş Tarihi</span>
                    </div>
                    <div class="col-xl-9">
                        <div class="row">
                            <div class="col-xl-6">
                                <input type="date" class="form-control form-control-solid" id="update_task_start_date" aria-label="Başlangıç Tarihi">
                            </div>
                            <div class="col-xl-6">
                                <input type="date" class="form-control form-control-solid" id="update_task_end_date" aria-label="Bitiş Tarihi">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-xl-3 mt-3">
                        <span class="font-weight-bold">Öncelik Durumu</span>
                    </div>
                    <div class="col-xl-9">
                        <div class="form-group">
                            <select id="update_task_priority_id" class="form-select form-select-solid select2Input" data-control="select2" data-placeholder="Öncelik Durumu" aria-label="Öncelik Durumu"></select>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-xl-3 mt-3">
                        <span class="font-weight-bold">Talep Sahibi</span>
                    </div>
                    <div class="col-xl-9">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="form-group">
                                    <select id="update_task_requester_id" class="form-select form-select-solid select2Input" data-control="select2" data-placeholder="Talep Sahibi" aria-label="Talep Sahibi"></select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-xl-3">
                        <span class="font-weight-bold">Açıklama</span>
                    </div>
                    <div class="col-xl-9">
                        <textarea class="form-control form-control-solid" id="update_task_description" rows="3" aria-label="Açıklama" style="border: none"></textarea>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-xl-12 text-end">
                        <button class="btn btn-primary btn-sm" onclick="taskFiles()">Dosyalar</button>
                    </div>
                </div>
                <hr>
                <div class="row mt-5">
                    <div class="col-xl-12">
                        <div class="input-group mb-5">
                            <input id="CreateSubTaskSelectedTaskInput" type="text" class="form-control form-control-solid" placeholder="Yeni Alt Görev Ekleyin" aria-label="Yeni Alt Görev Ekleyin">
                            <button class="btn btn-icon btn-success" id="CreateSubTaskSelectedTaskButton">
                                <i class="fa fa-plus-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row" id="selectedTaskSubTasksRow">

                </div>
                <hr>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="form-group">
                            <textarea id="create_comment_comment" class="form-control form-control-lg form-control-solid" rows="3" placeholder="Yorumunuz..." aria-label="Yorumunuz"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-xl-12 text-end">
                        <button type="button" id="CreateCommentButton" class="btn btn-light-success font-weight-bold">Yanıtla</button>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xl-12">
                        <h6 class="font-size-h6-sm">Yorumlar</h6>
                    </div>
                </div>
                <br>
                <div class="row" id="selectedTaskCommentsRow">

                </div>
            </div>
        </div>
    </div>

</div>
