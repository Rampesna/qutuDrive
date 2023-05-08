@extends('user.layouts.master')
@section('title', __('sidebar.document') . ' | ')

@section('subheader')
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-5 my-1">{{ __('sidebar.document') }}</h1>
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">

        </div>
    </div>
@endsection

@section('content')
    @include('user.modules.document.documentList.modals.transactions')
    @include('user.modules.document.documentList.modals.createDocument')
    @include('user.modules.document.documentList.modals.updateDocument')
    <div class="row">
        <div class="col-xl-12 mb-5">
            <div class="col-xl-5 float-end align-left">
                <div class="row">
                    <div class="col-xl-6"></div>
                    <div class="col-xl-6 mb-5">
                        <div class="form-group d-grid">
                            <button class="btn btn-success" id="addVideoBtn">Döküman Ekle</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="documentListDiv"></div>
        </div>
    </div>

@endsection

@section('customStyles')
    @include('user.modules.document.documentList.components.style')
@endsection

@section('customScripts')
    @include('user.modules.document.documentList.components.script')
@endsection
