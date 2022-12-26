@extends('user.layouts.master')
@section('title', __('sidebar.dashboard') . ' | ')

@section('subheader')
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-5 my-1">{{ __('sidebar.dashboard') }}</h1>
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">

        </div>
    </div>
@endsection

@section('content')

    @include('user.modules.dashboard.index.components.contextMenu')

    @include('user.modules.dashboard.index.modals.createDirectory')
    @include('user.modules.dashboard.index.modals.renameDirectory')
    @include('user.modules.dashboard.index.modals.deleteDirectory')
    @include('user.modules.dashboard.index.modals.deleteFile')
    @include('user.modules.dashboard.index.modals.uploadFile')

    @include('user.modules.dashboard.index.modals.renameFile')

    <div id="driveMain" class="container-fluid" style="padding:0 10px;margin:10px 0">
        <div class="card">
            <div class="card-header">
                <div class="card-title" style="margin:0;">
                    <div class="btn-group">
                        <button type="button" class="btn btn-light btn-sm" id="backDirectoryButton" disabled><i class="fa fa-arrow-left"></i></button>
                        <button type="button" class="btn btn-light btn-sm" id="homeDirectoryButton"><i class="fa fa-home"></i></button>
                    </div>
                    <div id="historyRow"></div>
                </div>
                <div class="card-toolbar">
                    <button onclick="uploadFileTransaction()" class="btn btn-sm btn-primary">
                        <i class="fa fa-file-upload"></i> {{ __('user/modules/dashboard.index.fileUploadButton') }}
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-5">
                    <div class="col-xl-12">
                        <span class="fw-bolder text-gray-700">{{ __('user/modules/dashboard.index.directories') }}</span>
                    </div>
                </div>
                <div class="row" id="directoriesRow">

                </div>
                <hr class="text-muted">
                <div class="row mb-5">
                    <div class="col-xl-12">
                        <span class="fw-bolder text-gray-700">{{ __('user/modules/dashboard.index.files') }}</span>
                    </div>
                </div>
                <div class="row" id="filesRow">

                </div>
            </div>
            <div class="card-footer" id="panelPortletFooter">
                <span id="countOfDirectories" class="fw-bolder text-gray-700">0</span>
                <span class="fw-bolder text-gray-600">{{ __('user/modules/dashboard.index.directoryCount') }}</span>,
                <span id="countOfFiles" class="fw-bolder text-gray-700">0</span>
                <span class="fw-bolder text-gray-600">{{ __('user/modules/dashboard.index.fileCount') }}</span>
            </div>
        </div>
    </div>

@endsection

@section('customStyles')
    @include('user.modules.dashboard.index.components.style')
@endsection

@section('customScripts')
    @include('user.modules.dashboard.index.components.script')
@endsection
