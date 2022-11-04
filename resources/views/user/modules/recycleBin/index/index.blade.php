@extends('user.layouts.master')
@section('title', __('sidebar.recycleBin') . ' | ')

@section('subheader')
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-5 my-1">{{ __('sidebar.recycleBin') }}</h1>
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">

        </div>
    </div>
@endsection

@section('content')

    <div id="driveMain" class="container-fluid" style="padding:0 10px;margin:10px 0">
        <div class="card">
            <div class="card-body">
                <div class="row mb-5">
                    <div class="col-xl-12">
                        <span class="fw-bolder text-gray-700">Silinen Klasörler</span>
                    </div>
                </div>
                <div class="row" id="directoriesRow">

                </div>
                <hr class="text-muted">
                <div class="row mb-5">
                    <div class="col-xl-12">
                        <span class="fw-bolder text-gray-700">Silinen Dosyalar</span>
                    </div>
                </div>
                <div class="row" id="filesRow">

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
    @include('user.modules.recycleBin.index.components.style')
@endsection

@section('customScripts')
    @include('user.modules.recycleBin.index.components.script')
@endsection
