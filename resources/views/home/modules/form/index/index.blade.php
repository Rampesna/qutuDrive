@extends('home.layouts.master')
@section('title', 'Form | ')

@section('content')

    <div class="container">
        <div class="row mb-5">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-5">
                            <div class="col-xl-11">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-12 mb-5">
                                                <span class="fs-2qx" id="form_title_span">Form Başlığı</span>
                                            </div>
                                            <div class="col-xl-12">
                                                <span class="fs-5" id="form_description_span">Açıklamalar...</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-5" id="formQuestionsRow">

        </div>
        <hr class="text-muted">
        <div class="row">
            <div class="col-xl-12 text-end">
                <button class="btn btn-success" id="SubmitFormButton">
                    Gönder
                </button>
            </div>
        </div>
    </div>

@endsection

@section('customStyles')
    @include('home.modules.form.index.components.style')
@endsection

@section('customScripts')
    @include('home.modules.form.index.components.script')
@endsection
