@extends('user.layouts.master')
@section('title', __('sidebar.management.packageConnections') . ' | ')

@section('subheader')
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-5 my-1">{{ __('sidebar.management.packageConnections') }}</h1>
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">

        </div>
    </div>
@endsection

@section('content')



@endsection

@section('customStyles')
    @include('user.modules.system.management.packageConnection.index.components.style')
@endsection

@section('customScripts')
    @include('user.modules.system.management.packageConnection.index.components.script')
@endsection
