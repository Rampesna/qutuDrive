@extends('user.layouts.master')
@section('title', __('sidebar.eLedgerBackup') . ' | ')

@section('subheader')
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-5 my-1">{{ __('sidebar.eLedgerBackup') }}</h1>
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">

        </div>
    </div>
@endsection

@section('content')

    @include('user.modules.eLedgerBackup.index.modals.transactions')
    @include('user.modules.eLedgerBackup.index.modals.singleELedgerUpload')
    @include('user.modules.eLedgerBackup.index.modals.multipleELedgerUpload')

    <div class="row">
        <div class="col-xl-12 mb-5">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-3 mb-5">
                            <div class="form-group">
                                <label
                                    for="yearSelector">{{ __('user/modules/eLedgerBackup.index.yearSelection') }}</label>
                                <select class="form-select form-select-solid select2Input" data-control="select2"
                                        id="yearSelector"
                                        data-placeholder="{{ __('user/modules/eLedgerBackup.index.yearSelection') }}">
                                    <option value="" selected hidden disabled></option>
                                    @for($yearCounter = intval(date('Y')); $yearCounter >= 2015; $yearCounter--)
                                        <option value="{{ $yearCounter }}">{{ $yearCounter }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-3 mb-5">
                            <div class="form-group">
                                <label
                                    for="monthSelector">{{ __('user/modules/eLedgerBackup.index.monthSelection') }}</label>
                                <select class="form-select form-select-solid select2Input" data-control="select2"
                                        id="monthSelector"
                                        data-placeholder="{{ __('user/modules/eLedgerBackup.index.monthSelection') }}"></select>
                            </div>
                        </div>
                        <div class="col-xl-4 mb-5"></div>
                        <div class="col-xl-2 mb-5">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="form-group d-grid">
                                        <button class="btn btn-success mt-6" id="UploadELedgersButton">
                                            <span class="svg-icon svg-icon-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3"
                                                          d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM14.5 12L12.7 9.3C12.3 8.9 11.7 8.9 11.3 9.3L10 12H11.5V17C11.5 17.6 11.4 18 12 18C12.6 18 12.5 17.6 12.5 17V12H14.5Z"
                                                          fill="black"/>
                                                    <path
                                                        d="M13 11.5V17.9355C13 18.2742 12.6 19 12 19C11.4 19 11 18.2742 11 17.9355V11.5H13Z"
                                                        fill="black"/>
                                                    <path
                                                        d="M8.2575 11.4411C7.82942 11.8015 8.08434 12.5 8.64398 12.5H15.356C15.9157 12.5 16.1706 11.8015 15.7425 11.4411L12.4375 8.65789C12.1875 8.44737 11.8125 8.44737 11.5625 8.65789L8.2575 11.4411Z"
                                                        fill="black"/>
                                                    <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="black"/>
                                                </svg>
                                            </span>
                                            {{ __('user/modules/eLedgerBackup.index.uploadFileButton') }}
                                        </button>
                                        <input type="file" hidden="hidden" id="uploadELedgerInput">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <ul class="d-flex nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder">
                        <li class="nav-item">
                            <a class="nav-link text-active-primary py-5 me-6 cursor-pointer getEDefterDosyalar"
                               data-type-id="1">{{ __('user/modules/eLedgerBackup.index.kebirDefteri') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary py-5 me-6 cursor-pointer getEDefterDosyalar"
                               data-type-id="2">{{ __('user/modules/eLedgerBackup.index.yevmiyeDefteri') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary py-5 me-6 cursor-pointer getEDefterDosyalar"
                               data-type-id="3">{{ __('user/modules/eLedgerBackup.index.kebirDefteriBeratı') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary py-5 me-6 cursor-pointer getEDefterDosyalar"
                               data-type-id="4">{{ __('user/modules/eLedgerBackup.index.yevmiyeDefteriBeratı') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary py-5 me-6 cursor-pointer getEDefterDosyalar"
                               data-type-id="5">{{ __('user/modules/eLedgerBackup.index.kebirOnayDefteriBeratı') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary py-5 me-6 cursor-pointer getEDefterDosyalar"
                               data-type-id="6">{{ __('user/modules/eLedgerBackup.index.YevmiyeOnayDefteriBeratı') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary py-5 me-6 cursor-pointer getEDefterDosyalar"
                               data-type-id="7">{{ __('user/modules/eLedgerBackup.index.defterRaporu') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary py-5 me-6 cursor-pointer getEDefterDosyalar"
                               data-type-id="0">{{ __('user/modules/eLedgerBackup.index.ikincilSaklama') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="filesRowBody" style="display: none">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row" id="filesRow">

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('customStyles')
    @include('user.modules.eLedgerBackup.index.components.style')
@endsection

@section('customScripts')
    @include('user.modules.eLedgerBackup.index.components.script')
@endsection
