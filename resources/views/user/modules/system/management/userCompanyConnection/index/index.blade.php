@extends('user.layouts.master')
@section('title', __('sidebar.management.userCompanyConnections') . ' | ')

@section('subheader')
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-5 my-1">{{ __('sidebar.management.userCompanyConnections') }}</h1>
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">

        </div>
    </div>
@endsection

@section('content')

    @include('user.modules.system.management.userCompanyConnection.index.modals.users')
    @include('user.modules.system.management.userCompanyConnection.index.modals.companies')
    @include('user.modules.system.management.userCompanyConnection.index.modals.confirmConnection')

    <input type="hidden" id="selected_user_row_index">
    <input type="hidden" id="selected_user_id">

    <input type="hidden" id="selected_company_row_index">
    <input type="hidden" id="selected_company_id">

    <div class="row mb-3">
        <div class="col-xl-6">
            <label class="ms-2 fs-3" for="userSelection">Kullanıcı Seçimi</label>
            <div class="input-group">
                <input id="userSelection" type="text" class="form-control" readonly>
                <button class="btn btn-icon btn-primary" onclick="usersModal()">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
        <div class="col-xl-6">
            <label class="ms-2 fs-3" for="companySelection">Firma Seçimi</label>
            <div class="input-group">
                <input id="companySelection" type="text" class="form-control" readonly>
                <button class="btn btn-icon btn-primary" onclick="companiesModal()">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-xl-12 text-end">
            <button class="btn btn-success" id="ConnectButton">Yeni Bağlantı Ekle</button>
        </div>
    </div>


@endsection

@section('customStyles')
    @include('user.modules.system.management.userCompanyConnection.index.components.style')
@endsection

@section('customScripts')
    @include('user.modules.system.management.userCompanyConnection.index.components.script')
@endsection
