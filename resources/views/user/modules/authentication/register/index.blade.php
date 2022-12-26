@extends('user.layouts.auth')
@section('title', 'Kayıt Ol | ')

@section('content')

    <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
        <div class="w-lg-700px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
            <div class="text-center mb-10">
                <h1 class="text-dark mb-3">{{ __('user/modules/authentication.register.title') }}</h1>
                <div class="text-gray-400 fw-bold fs-4">{{ __('user/modules/authentication.register.alreadyRegistered') }}
                    <a href="{{ route('user.web.authentication.login.index') }}" class="link-primary fw-bolder">{{ __('user/modules/authentication.register.loginPageLink') }}</a>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6 mb-5">
                    <label CLASS="ms-2" for="register_name">{{ __('user/modules/authentication.register.name') }}</label>
                    <input id="register_name" class="form-control form-control-solid" placeholder="{{ __('user/modules/authentication.register.name') }}">
                </div>
                <div class="col-xl-6 mb-5">
                    <label class="ms-2" for="register_surname">{{ __('user/modules/authentication.register.surname') }}</label>
                    <input id="register_surname" class="form-control form-control-solid" placeholder="{{ __('user/modules/authentication.register.surname') }}">
                </div>
                <div class="col-xl-12 mb-5">
                    <label CLASS="ms-2" for="register_company_type">{{ __('user/modules/authentication.register.companyType.title') }}</label>
                    <select id="register_company_type" class="form-select form-select-solid">
                        <option value="1">{{ __('user/modules/authentication.register.companyType.options.corporate') }}</option>
                        <option value="2">{{ __('user/modules/authentication.register.companyType.options.individual') }}</option>
                    </select>
                </div>
                <div class="col-xl-12 mb-5">
                    <label CLASS="ms-2" for="register_company_tax_number">{{ __('user/modules/authentication.register.taxNumber') }}</label>
                    <input id="register_company_tax_number" class="form-control form-control-solid onlyNumber" maxlength="11" placeholder="VKN | TCKN">
                </div>
                <div class="col-xl-12 mb-5">
                    <label CLASS="ms-2" for="register_company_tax_office">{{ __('user/modules/authentication.register.taxOffice') }}</label>
                    <input id="register_company_tax_office" class="form-control form-control-solid" placeholder="{{ __('user/modules/authentication.register.taxOffice') }}">
                </div>
                <div class="col-xl-12 mb-5">
                    <label CLASS="ms-2" for="register_company_title">{{ __('user/modules/authentication.register.companyTitle') }}</label>
                    <input id="register_company_title" class="form-control form-control-solid" placeholder="{{ __('user/modules/authentication.register.companyTitle') }}">
                </div>
                <div class="col-xl-12 mb-5">
                    <label CLASS="ms-2" for="register_company_phone">{{ __('user/modules/authentication.register.phone') }}</label>
                    <input id="register_company_phone" class="form-control form-control-solid phoneMask" placeholder="{{ __('user/modules/authentication.register.phone') }}">
                </div>
                <div class="col-xl-12 mb-5">
                    <label CLASS="ms-2" for="register_company_email">{{ __('user/modules/authentication.register.email') }}</label>
                    <input id="register_company_email" class="form-control form-control-solid emailMask" placeholder="{{ __('user/modules/authentication.register.email') }}">
                </div>
                <div class="col-xl-12 mb-5">
                    <label CLASS="ms-2" for="register_company_address">{{ __('user/modules/authentication.register.address') }}</label>
                    <input id="register_company_address" class="form-control form-control-solid" placeholder="{{ __('user/modules/authentication.register.address') }}">
                </div>
                <div class="col-xl-12 mb-5">
                    <label CLASS="ms-2" for="register_company_password">{{ __('user/modules/authentication.register.password') }}</label>
                    <input id="register_company_password" type="password" class="form-control form-control-solid" placeholder="{{ __('user/modules/authentication.register.password') }}">
                </div>
            </div>
            <div class="text-center">
                <button type="button" id="RegisterButton" class="btn btn-lg btn-primary w-100 mb-5">{{ __('user/modules/authentication.register.registerButton') }}</button>
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
