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
                    <button class="btn btn-sm btn-primary">
                        <i class="fa fa-file-upload"></i> Dosya Yükle
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-5">
                    <div class="col-xl-12">
                        <span class="fw-bolder text-gray-700">Klasörler</span>
                    </div>
                </div>
                <div class="row" id="directoriesRow">

                </div>
                <hr class="text-muted">
                <div class="row mb-5">
                    <div class="col-xl-12">
                        <span class="fw-bolder text-gray-700">Dosyalar</span>
                    </div>
                </div>
                <div class="row" id="filesRow">
                    <div class="col-xl-2 mb-5">
                        <div class="card h-100 flex-center text-center py-4 px-0 cursor-pointer border border-secondary bg-hover-light-dark" style="border-radius: 10px">
                            <i class="fas fa-file fa-lg mt-2 mb-5"></i>
                            <span class="font-weight-bolder text-dark-75 mb-1">Dosya 1</span>
                            <div class="fs-7 fw-bold text-gray-400 mt-auto mb-1">Dosya Boyutu</div>
                            <span class="fs-7 fw-bold text-gray-600 mt-auto mb-1">Yüklenme Tarihi</span>
                        </div>
                    </div>
                    <div class="col-xl-2 mb-5">
                        <div class="card h-100 flex-center text-center py-4 px-0 cursor-pointer border border-secondary bg-hover-light-dark" style="border-radius: 10px">
                            <i class="fas fa-file fa-lg mt-2 mb-5"></i>
                            <span class="font-weight-bolder text-dark-75 mb-1">Dosya 2</span>
                            <div class="fs-7 fw-bold text-gray-400 mt-auto mb-1">Dosya Boyutu</div>
                            <span class="fs-7 fw-bold text-gray-600 mt-auto mb-1">Yüklenme Tarihi</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer" id="panelPortletFooter">
                <span id="countOfDirectories" class="fw-bolder text-gray-700">0</span>
                <span class="fw-bolder text-gray-600">Klasör</span>,
                <span id="countOfFiles" class="fw-bolder text-gray-700">0</span>
                <span class="fw-bolder text-gray-600">Dosya</span>
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
