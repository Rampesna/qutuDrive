@extends('user.layouts.master')
@section('title', __('sidebar.databaseBackup') . ' | ')

@section('subheader')
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-5 my-1">{{ __('sidebar.databaseBackup') }}</h1>
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">

        </div>
    </div>
@endsection

@section('content')

    @include('user.modules.databaseBackup.index.modals.transactions')

    <input type="file" id="fileSelector" style="display: none">

    <div class="row">
        <div class="col-xl-12 mb-5">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-10 mb-5">
                            <div class="form-group">
                                <input id="keyword" type="text" class="form-control form-control-solid filterInput" placeholder="{{ __('user/modules/databaseBackup.index.search.placeholder') }}" aria-label="{{ __('user/modules/databaseBackup.index.search.placeholder') }}">
                            </div>
                        </div>
                        <div class="col-xl-2 mb-5">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="form-group d-grid">
                                        <button class="btn btn-primary" id="FilterButton">{{ __('user/modules/databaseBackup.index.search.button') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="filesRow"></div>

@endsection

@section('customStyles')
    @include('user.modules.databaseBackup.index.components.style')
@endsection

@section('customScripts')
    @include('user.modules.databaseBackup.index.components.script')
@endsection
