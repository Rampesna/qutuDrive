@extends('user.layouts.auth')
@section('title', 'Kayıt Ol | ')

@section('content')

    <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
        <div class="w-lg-700px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
            <div class="text-center mb-10">
                <h1 class="text-dark mb-3">Kayıt Olun</h1>
                <div class="text-gray-400 fw-bold fs-4">Zaten üye misiniz?
                    <a href="{{ route('user.web.authentication.login.index') }}" class="link-primary fw-bolder">Giriş Yapın</a>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6 mb-5">
                    <label CLASS="ms-2" for="register_name">AD</label>
                    <input id="register_name" class="form-control form-control-solid" placeholder="AD">
                </div>
                <div class="col-xl-6 mb-5">
                    <label class="ms-2" for="register_surname">SOYAD</label>
                    <input id="register_surname" class="form-control form-control-solid" placeholder="SOYAD">
                </div>
                <div class="col-xl-12 mb-5">
                    <label CLASS="ms-2" for="register_company_type">FİRMA TİPİ</label>
                    <select id="register_company_type" class="form-select form-select-solid">
                        <option value="1">Tüzel</option>
                        <option value="2">Gerçek</option>
                    </select>
                </div>
                <div class="col-xl-12 mb-5">
                    <label CLASS="ms-2" for="register_company_tax_number">VERGİ KİMLİK NUMARASI</label>
                    <input id="register_company_tax_number" class="form-control form-control-solid onlyNumber" maxlength="11" placeholder="VKN | TCKN">
                </div>
                <div class="col-xl-12 mb-5">
                    <label CLASS="ms-2" for="register_company_tax_office">VERGİ DAİRESİ</label>
                    <input id="register_company_tax_office" class="form-control form-control-solid" placeholder="VERGİ DAİRESİ">
                </div>
                <div class="col-xl-12 mb-5">
                    <label CLASS="ms-2" for="register_company_title">FİRMA ÜNVAN</label>
                    <input id="register_company_title" class="form-control form-control-solid" placeholder="FİRMA ÜNVAN">
                </div>
                <div class="col-xl-12 mb-5">
                    <label CLASS="ms-2" for="register_company_phone">TELEFON</label>
                    <input id="register_company_phone" class="form-control form-control-solid phoneMask" placeholder="TELEFON">
                </div>
                <div class="col-xl-12 mb-5">
                    <label CLASS="ms-2" for="register_company_email">MAİL ADRESİ</label>
                    <input id="register_company_email" class="form-control form-control-solid emailMask" placeholder="MAİL ADRESİ">
                </div>
                <div class="col-xl-12 mb-5">
                    <label CLASS="ms-2" for="register_company_address">ADRES</label>
                    <input id="register_company_address" class="form-control form-control-solid" placeholder="ADRES">
                </div>
                <div class="col-xl-12 mb-5">
                    <label CLASS="ms-2" for="register_company_password">PAROLA</label>
                    <input id="register_company_password" type="password" class="form-control form-control-solid" placeholder="ŞİFRE">
                </div>
            </div>
            <div class="text-center">
                <button type="button" id="RegisterButton" class="btn btn-lg btn-primary w-100 mb-5">KAYIT OL</button>
            </div>
        </div>
    </div>

@endsection

@section('customStyles')
    @include('user.modules.authentication.register.components.style')
@endsection

@section('customScripts')
    @include('user.modules.authentication.register.components.script')
@endsection
