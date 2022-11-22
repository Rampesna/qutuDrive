@extends('user.layouts.master')
@section('title', __('sidebar.settings.packages') . ' | ')

@section('subheader')
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-5 my-1">{{ __('sidebar.settings.packages') }}</h1>
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">

        </div>
    </div>
@endsection

@section('content')

    <input type="hidden" id="selected_package_row_index">
    <input type="hidden" id="selected_package_id">
    <div class="row">
        <div class="col-xl-12">
            <div id="packages" class="text-center">
                <i class="fa fa-spinner fa-spin"></i>
            </div>
        </div>
    </div>

@endsection

@section('customStyles')
    @include('user.modules.system.settings.package.index.components.style')
@endsection

@section('customScripts')
    @include('user.modules.system.settings.package.index.components.script')
@endsection
