<div class="card mb-6 mb-xl-9">
    <div class="card-body pt-9 pb-0">
        <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
            <div class="d-flex flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
                <img class="mw-50px mw-lg-75px" src="{{ asset('assets/media/svg/brand-logos/xing-icon.svg') }}" alt="image">
            </div>
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center mb-1">
                            <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bolder me-3" id="projectNameSpan">
                                <i class="fa fa-spinner fa-spin"></i>
                            </a>
                            <span class="badge badge-light-primary me-auto" id="projectStatusBadge">
                                X
                            </span>
                        </div>
                        <div class="d-flex flex-wrap fw-bold mb-4 fs-5 text-gray-400" id="projectDescription">
                            <i class="fa fa-spinner fa-spin"></i>
                        </div>
                    </div>
                    <div class="d-flex mb-4">
                        @if(request()->segment(3) === 'overview')
                            <div class="me-0">
                                <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-three-dots fs-3"></i>
                                </button>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true" style="">
                                    <div class="menu-item px-3">
                                        <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">İşlemler</div>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a onclick="updateProject()" class="menu-link px-3 cursor-pointer">Projeyi Düzenle</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="d-flex flex-wrap justify-content-start">
                    <div class="d-flex flex-wrap">
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="fs-4 fw-bolder" id="projectEndDateSpan">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </div>
                            </div>
                            <div class="fw-bold fs-6 text-gray-400">Bitiş Tarihi</div>
                        </div>
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <div class="text-center">
                                <div class="fs-4 fw-bolder counted" id="projectWaitingTasksSpan">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </div>
                            </div>
                            <div class="fw-bold fs-6 text-gray-400">Bekleyen İşler</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="separator"></div>
        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder">

            <li class="nav-item">
                <a class="nav-link text-active-primary py-5 me-6 {{ request()->segment(3) === 'overview' ? 'active' : '' }}" href="{{ route('user.web.workFollow.overview', ['id' => $id]) }}">Önizleme</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-active-primary py-5 me-6 {{ request()->segment(3) === 'board' ? 'active' : '' }}" href="{{ route('user.web.workFollow.board', ['id' => $id]) }}">Görevler</a>
            </li>

        </ul>
    </div>
</div>
