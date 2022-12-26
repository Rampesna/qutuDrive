@extends('user.layouts.master')
@section('title', __('sidebar.workFollow') . ' | ')

@section('subheader')
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-5 my-1">{{ __('sidebar.workFollow') }}</h1>
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">

        </div>
    </div>
@endsection

@section('content')

    @include('user.modules.workFollow.index.modals.createProject')

    <div class="row">
        <div class="col-xl-8 mb-5">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-9 mb-5">
                            <div class="form-group">
                                <label for="keyword">{{ __('user/modules/workFollow.index.searching.projectName') }}</label>
                                <input id="keyword" type="text" class="form-control form-control-solid filterInput" placeholder="{{ __('user/modules/workFollow.index.searching.projectName') }}">
                            </div>
                        </div>
                        <div class="col-xl-3 mb-5">
                            <div class="form-group">
                                <label for="statusIds">{{ __('user/modules/workFollow.index.searching.projectStatus') }}</label>
                                <select id="statusIds" class="form-select form-select-solid select2Input" data-control="select2" data-placeholder="{{ __('user/modules/workFollow.index.searching.projectStatus') }}" multiple></select>
                            </div>
                        </div>
                        <div class="col-xl-6 mb-5">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group d-grid">
                                        <button class="btn btn-primary mt-6" id="FilterButton">{{ __('user/modules/workFollow.index.searching.searchButton') }}</button>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group d-grid">
                                        <button class="btn btn-secondary mt-6" id="ClearFilterButton">{{ __('user/modules/workFollow.index.searching.clearButton') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 mb-5 text-end">
            <div class="row">
                <div class="col-xl-12 d-grid">
                    <button class="btn btn-primary" onclick="createProject()">{{ __('user/modules/workFollow.index.searching.createNewProjectButton') }}</button>
                </div>
            </div>
        </div>
    </div>
    <hr class="text-muted">
    <div class="row" id="projects"></div>

@endsection

@section('customStyles')
    @include('user.modules.workFollow.index.components.style')
@endsection

@section('customScripts')
    @include('user.modules.workFollow.index.components.script')
@endsection
