@extends('user.layouts.master')
@section('title', __('sidebar.management.companies') . ' | ')

@section('subheader')
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-5 my-1">{{ __('sidebar.management.companies') }} / Detay / e-Defter Yedek Durumu</h1>
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">

        </div>
    </div>
@endsection

@section('content')

    @include('user.modules.system.management.company.layouts.overview')

    <div class="row">
        <div class="col-xl-12 mb-5">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-3 mb-5">
                            <div class="form-group">
                                <label for="yearSelector">{{ __('user/modules/eLedgerBackup.index.yearSelection') }}</label>
                                <select class="form-select form-select-solid select2Input" data-control="select2" id="yearSelector" data-placeholder="{{ __('user/modules/eLedgerBackup.index.yearSelection') }}">
                                    <option value="" selected hidden disabled></option>
                                    @for($yearCounter = intval(date('Y')); $yearCounter >= 2015; $yearCounter--)
                                        <option value="{{ $yearCounter }}">{{ $yearCounter }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-3 mb-5">
                            <div class="form-group">
                                <label for="monthSelector">{{ __('user/modules/eLedgerBackup.index.monthSelection') }}</label>
                                <select class="form-select form-select-solid select2Input" data-control="select2" id="monthSelector" data-placeholder="{{ __('user/modules/eLedgerBackup.index.monthSelection') }}"></select>
                            </div>
                        </div>
                        <div class="col-xl-4 mb-5">
                            <button class="btn btn-primary mt-6" id="GetELedgerBackupsButton">Yedekleri Getir</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="row" id="eLedgerBackups">

            </div>
        </div>
    </div>

@endsection

@section('customStyles')
    @include('user.modules.system.management.company.detail.eLedgerBackupStatus.components.style')
@endsection

@section('customScripts')
    @include('user.modules.system.management.company.detail.eLedgerBackupStatus.components.script')
@endsection
