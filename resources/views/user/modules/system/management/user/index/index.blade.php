@extends('user.layouts.master')
@section('title', __('sidebar.management.users') . ' | ')

@section('subheader')
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-5 my-1">{{ __('sidebar.management.users') }}</h1>
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">

        </div>
    </div>
@endsection

@section('content')

    @include('user.modules.system.management.user.index.components.contextMenu')

    @include('user.modules.system.management.user.index.modals.createUser')
    @include('user.modules.system.management.user.index.modals.updateUser')
    @include('user.modules.system.management.user.index.modals.deleteUser')
    @include('user.modules.system.management.user.index.modals.changeEmail')

    <input type="hidden" id="selected_user_row_index">
    <input type="hidden" id="selected_user_id">
    <div class="row mb-3">
        <div class="col-xl-12">
            <button class="btn btn-primary" onclick="createUser()">Yeni Kullanıcı</button>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="jqxLoader"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="users" class="text-center">
                <i class="fa fa-spinner fa-spin"></i>
            </div>
        </div>
    </div>

@endsection

@section('customStyles')
    @include('user.modules.system.management.user.index.components.style')
@endsection

@section('customScripts')
    @include('user.modules.system.management.user.index.components.script')
@endsection
