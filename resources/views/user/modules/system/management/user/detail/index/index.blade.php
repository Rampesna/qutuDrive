@extends('user.layouts.master')
@section('title', __('sidebar.management.users') . ' | ')

@section('subheader')
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-5 my-1">{{ __('sidebar.management.users') }} / Detay / Genel Bilgiler</h1>
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">

        </div>
    </div>
@endsection

@section('content')

    @include('user.modules.system.management.user.detail.layouts.overview')

    <div class="row mb-5">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6 mb-5">
                            <label class="ms-2" for="username">Kullanıcı Adı</label>
                            <input id="username" type="text" class="form-control form-control-solid" placeholder="Kullanıcı Adı">
                        </div>
                        <div class="col-xl-6 mb-5">
                            <label class="ms-2" for="email">E-posta Adresi</label>
                            <input id="email" type="text" class="form-control form-control-solid emailMask" placeholder="E-posta Adresi">
                        </div>
                        <div class="col-xl-6 mb-5">
                            <label class="ms-2" for="name">Ad</label>
                            <input id="name" type="text" class="form-control form-control-solid" placeholder="Ad">
                        </div>
                        <div class="col-xl-6 mb-5">
                            <label class="ms-2" for="surname">Soyad</label>
                            <input id="surname" type="text" class="form-control form-control-solid" placeholder="Soyad">
                        </div>
                        <div class="col-xl-4 mb-5">
                            <label class="ms-2" for="phone">Telefon</label>
                            <input id="phone" type="text" class="form-control form-control-solid phoneMask" placeholder="Telefon">
                        </div>
                        <div class="col-xl-4 mb-5">
                            <label class="ms-2" for="tax_number">TC</label>
                            <input id="tax_number" type="text" class="form-control form-control-solid" placeholder="TC">
                        </div>
                        <div class="col-xl-4 mb-5">
                            <label class="ms-2" for="status">Durum</label>
                            <select id="status" class="form-select form-select-solid">
                                <option value="0">Pasif</option>
                                <option value="1">Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 text-end">
            <button id="UpdateUserButton" class="btn btn-success">Kaydet</button>
        </div>
    </div>

@endsection

@section('customStyles')
    @include('user.modules.system.management.user.detail.index.components.style')
@endsection

@section('customScripts')
    @include('user.modules.system.management.user.detail.index.components.script')
@endsection
