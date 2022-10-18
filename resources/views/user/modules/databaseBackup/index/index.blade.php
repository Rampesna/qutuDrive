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

    <input type="file" id="fileSelector" style="display: none">

    <div class="row" id="filesRow"></div>

@endsection

@section('customStyles')
    @include('user.modules.databaseBackup.index.components.style')
@endsection

@section('customScripts')
    @include('user.modules.databaseBackup.index.components.script')
@endsection
