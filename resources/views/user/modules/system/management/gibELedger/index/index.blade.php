@extends('user.layouts.master')
@section('title', __('sidebar.management.gibELedger') . ' | ')

@section('subheader')
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-5 my-1">{{ __('sidebar.management.gibELedger') }}</h1>
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">

        </div>
    </div>
@endsection

@section('content')

    @include('user.modules.system.management.gibELedger.index.modals.createGibSaklamaOzelListe')

    <input type="hidden" id="selected_gib_saklama_ozel_liste_row_index">
    <input type="hidden" id="selected_gib_saklama_ozel_liste_id">
    <div class="row mb-3">
        <div class="col-xl-12">
            <button class="btn btn-primary" onclick="createGibSaklamaOzelListe()">Yeni Firma</button>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="gibSaklamaOzelListe"></div>
        </div>
    </div>

@endsection

@section('customStyles')
    @include('user.modules.system.management.gibELedger.index.components.style')
@endsection

@section('customScripts')
    @include('user.modules.system.management.gibELedger.index.components.script')
@endsection
