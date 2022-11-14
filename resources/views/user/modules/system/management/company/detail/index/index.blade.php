@extends('user.layouts.master')
@section('title', __('sidebar.management.companies') . ' | ')

@section('subheader')
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-5 my-1">{{ __('sidebar.management.companies') }} / Detay / Genel Bilgiler</h1>
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">

        </div>
    </div>
@endsection

@section('content')

    @include('user.modules.system.management.company.layouts.overview')

    <div class="row mb-5">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12 mb-5">
                            <label class="ms-2" for="title">Firma Ünvanı</label>
                            <input id="title" class="form-control form-control-solid" placeholder="Firma Ünvanı">
                        </div>
                        <div class="col-xl-6 mb-5">
                            <label class="ms-2" for="tax_number">Vergi Numarası</label>
                            <input id="tax_number" class="form-control form-control-solid onlyNumber" placeholder="Vergi Numarası" maxlength="11">
                        </div>
                        <div class="col-xl-6 mb-5">
                            <label class="ms-2" for="tax_office">Vergi Dairesi</label>
                            <input id="tax_office" class="form-control form-control-solid" placeholder="Vergi Dairesi">
                        </div>
                        <div class="col-xl-6 mb-5">
                            <label class="ms-2" for="name">Ad</label>
                            <input id="name" class="form-control form-control-solid" placeholder="Ad">
                        </div>
                        <div class="col-xl-6 mb-5">
                            <label class="ms-2" for="surname">Soyad</label>
                            <input id="surname" class="form-control form-control-solid" placeholder="Soyad">
                        </div>
                        <div class="col-xl-6 mb-5">
                            <label class="ms-2" for="email">E-posta Adresi</label>
                            <input id="email" class="form-control form-control-solid emailMask" placeholder="E-posta Adresi">
                        </div>
                        <div class="col-xl-6 mb-5">
                            <label class="ms-2" for="phone">Telefon</label>
                            <input id="phone" class="form-control form-control-solid phoneMask" placeholder="Telefon">
                        </div>
                        <div class="col-xl-12 mb-5">
                            <label class="ms-2" for="address">Adres</label>
                            <textarea id="address" class="form-control form-control-solid" placeholder="Adres"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 text-end">
            <button id="UpdateCompanyButton" class="btn btn-success">Kaydet</button>
        </div>
    </div>

@endsection

@section('customStyles')
    @include('user.modules.system.management.company.detail.index.components.style')
@endsection

@section('customScripts')
    @include('user.modules.system.management.company.detail.index.components.script')
@endsection
