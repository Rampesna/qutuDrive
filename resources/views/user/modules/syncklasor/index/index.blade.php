@extends('user.layouts.master')
@section('title', __('sidebar.syncklasor') . ' | ')

@section('subheader')
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-5 my-1">{{ __('sidebar.syncklasor') }}</h1>
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">

        </div>
    </div>
@endsection

@section('content')

    @include('user.modules.syncklasor.index.modals.transactions')

    <div id="driveMain" class="container-fluid" style="padding:0 10px;margin:10px 0">
        <div class="card">
            {{--            <div class="card-header">--}}
            {{--                <div class="card-title" style="margin:0;">--}}
            {{--                    <div class="btn-group">--}}
            {{--                        <button type="button" class="btn btn-light btn-sm" id="homeSyncklasorButton"><i class="fa fa-home"></i></button>--}}
            {{--                    </div>--}}
            {{--                    <div id="historyRow"></div>--}}
            {{--                </div>--}}
            {{--                <div class="card-toolbar">--}}
            {{--                    <button class="btn btn-sm btn-primary">--}}
            {{--                        <i class="fa fa-file-upload"></i> {{ __('user/modules/syncklasor.index.uploadFile') }}--}}
            {{--                    </button>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            <div class="card-body">
                <div id="devicesArea">
                    <div class="row mb-5">
                        <div class="col-xl-12">
                            <span
                                class="fw-bolder text-gray-700">{{ __('user/modules/syncklasor.index.myDevices') }}</span>
                        </div>
                    </div>
                    <div class="row" id="devicesRow">

                    </div>
                </div>
                <div id="filesArea" style="display: none">
                    <div class="row mb-5">
                        <div class="col-xl-12">
                            <span class="fw-bolder text-gray-700">{{ __('user/modules/syncklasor.index.files') }}</span>
                        </div>
                    </div>
                    <div class="row" id="filesRow">

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('customStyles')
    @include('user.modules.syncklasor.index.components.style')
@endsection

@section('customScripts')
    @include('user.modules.syncklasor.index.components.script')
@endsection
