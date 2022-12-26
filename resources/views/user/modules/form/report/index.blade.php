@extends('user.layouts.master')
@section('title', __('sidebar.form') . ' | ')

@section('subheader')
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-5 my-1">{{ __('sidebar.form') }}</h1>
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">

        </div>
    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-12">
            <div id="formSubmits"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 text-end">
            <button type="button" class="btn btn-sm btn-primary mt-6" id="DownloadExcelButton" style="display: none">{{ __('user/modules/form.report.downloadExcelButton') }}</button>
        </div>
    </div>

@endsection

@section('customStyles')
    @include('user.modules.form.report.components.style')
@endsection

@section('customScripts')
    @include('user.modules.form.report.components.script')
@endsection
