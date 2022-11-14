@extends('user.layouts.master')
@section('title', __('sidebar.management.users') . ' | ')

@section('subheader')
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-5 my-1">{{ __('sidebar.management.users') }} / Detay / Firmalar</h1>
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">

        </div>
    </div>
@endsection

@section('content')

    @include('user.modules.system.management.user.detail.layouts.overview')

    @include('user.modules.system.management.user.detail.company.modals.cancelConnection')

    @include('user.modules.system.management.user.detail.company.components.contextMenu')

    <input type="hidden" id="selected_company_row_index">
    <input type="hidden" id="selected_company_id">
    <div class="row">
        <div class="col-xl-12">
            <div id="companies"></div>
        </div>
    </div>

@endsection

@section('customStyles')
    @include('user.modules.system.management.user.detail.company.components.style')
@endsection

@section('customScripts')
    @include('user.modules.system.management.user.detail.company.components.script')
@endsection
