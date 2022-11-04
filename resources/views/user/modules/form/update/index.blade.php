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

    @include('user.modules.form.update.modals.shareForm')

    <div class="container">
        <div class="row mb-5">
            <div class="col-xl-11">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12 mb-5">
                                <input id="update_form_name" type="hidden">
                                <input id="update_form_title" type="text" class="form-control form-control-lg nonBorder fs-2qx" placeholder="Form Başlığı" aria-label="Form Başlığı">
                            </div>
                            <div class="col-xl-12">
                                <textarea id="update_form_description" class="form-control form-control-lg nonBorder" placeholder="Açıklama (İsteğe Bağlı)" aria-label="Açıklama (İsteğe Bağlı)"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-5" id="formQuestionsRow">

        </div>
        <div class="row">
            <div class="col-xl-11 text-end">
                <button id="AddNewQuestionButton" class="btn btn-icon btn-white me-3" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" data-bs-original-title="Soru Ekle">
                    <i class="fa fa-plus-circle"></i>
                </button>
                <button id="SaveFormButton" class="btn btn-icon btn-success me-3" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" data-bs-original-title="Kaydet">
                    <i class="fa fa-save"></i>
                </button>
                <button id="ShareFormButton" class="btn btn-icon btn-secondary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" data-bs-original-title="Paylaş">
                    <i class="fas fa-share-alt"></i>
                </button>
            </div>
        </div>
    </div>

@endsection

@section('customStyles')
    @include('user.modules.form.update.components.style')
@endsection

@section('customScripts')
    @include('user.modules.form.update.components.script')
@endsection
