@extends('user.layouts.master')
@section('title', __('sidebar.panel') . ' | ')

@section('subheader')
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-5 my-1">{{ __('sidebar.panel') }}</h1>
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">

        </div>
    </div>
@endsection

@section('content')


    <div class="row">
        <div class="col-xl-6"></div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col border-right pb-4 pt-4">
                            <i class="fas fa-chart-pie fa-2x text-info"></i><br>
                            <label class="mb-0 mr-5 mt-2">Kalan Kullanım</label>
                            <h4 class="font-30 font-weight-bold text-col-blue" style="font-size: 30px" id="generalUsage">--</h4>
                        </div>
                        <div class="col pb-4 pt-4">
                            <i class="fas fa-credit-card fa-2x text-success"></i><br>
                            <label class="mb-0 mr-5 mt-2">Bakiye</label>
                            <h4 class="font-30 font-weight-bold text-col-blue" style="font-size: 30px" id="balanceSpan">--</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="text-muted">
    <div id="driveMain" class="container-fluid" style="padding:0 10px;margin:10px 0">
        <div class="card">
            <div class="card-body">
              <div class="col-md-12">
                  <div class="row">
                      <div class="col-md-4">
                          <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end bg-dark">
                              <div class="card-header pt-5 pb-5">
                                  <div class="card-title d-flex flex-column">
                                      <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2" id="backupdosyalarSpan">
                                          <i class="fa fa-sm fa-spinner fa-spin text-white"></i>
                                      </span>
                                      <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Veritabanı Yedek Kullanımı</span>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end bg-warning">
                              <div class="card-header pt-5 pb-5">
                                  <div class="card-title d-flex flex-column">
                                      <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2" id="syncdosyahareketSpan">
                                          <i class="fa fa-sm fa-spinner fa-spin text-white"></i>
                                      </span>
                                      <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Dosya Yedek Kullanımı</span>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end bg-primary">
                              <div class="card-header pt-5 pb-5">
                                  <div class="card-title d-flex flex-column">
                                      <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2" id="edefterdosyalarSpan">
                                          <i class="fa fa-sm fa-spinner fa-spin text-white"></i>
                                      </span>
                                      <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Edefter Yedek Kullanımı</span>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
            </div>

        </div>
    </div>

@endsection

@section('customStyles')
    @include('user.modules.panel.index.components.style')
@endsection

@section('customScripts')
    @include('user.modules.panel.index.components.script')
@endsection
