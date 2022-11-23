<div class="modal fade show" id="CreateCompanyModal" tabindex="-1" aria-modal="true" role="dialog" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered mw-800px">
        <div class="modal-content rounded">
            <div class="modal-header pb-0 border-0 justify-content-end">
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"></rect>
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"></rect>
                        </svg>
                    </span>
                </div>
            </div>
            <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                <div class="form fv-plugins-bootstrap5 fv-plugins-framework">
                    <div class="mb-13 text-center">
                        <h1 class="mb-3">Firma Oluştur</h1>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <div class="row mb-5">
                            <div class="col-xl-6 mb-5">
                                <label CLASS="ms-2" for="create_company_name">AD</label>
                                <input id="create_company_name" class="form-control form-control-solid" placeholder="AD">
                            </div>
                            <div class="col-xl-6 mb-5">
                                <label class="ms-2" for="create_company_surname">SOYAD</label>
                                <input id="create_company_surname" class="form-control form-control-solid" placeholder="SOYAD">
                            </div>
                            <div class="col-xl-12 mb-5">
                                <label CLASS="ms-2" for="create_company_type">FİRMA TİPİ</label>
                                <select id="create_company_type" class="form-select form-select-solid">
                                    <option value="1">Tüzel</option>
                                    <option value="2">Gerçek</option>
                                </select>
                            </div>
                            <div class="col-xl-12 mb-5">
                                <label CLASS="ms-2" for="create_company_tax_number">VERGİ KİMLİK NUMARASI</label>
                                <input id="create_company_tax_number" class="form-control form-control-solid onlyNumber" maxlength="11" placeholder="VKN | TCKN">
                            </div>
                            <div class="col-xl-12 mb-5">
                                <label CLASS="ms-2" for="create_company_tax_office">VERGİ DAİRESİ</label>
                                <input id="create_company_tax_office" class="form-control form-control-solid" placeholder="VERGİ DAİRESİ">
                            </div>
                            <div class="col-xl-12 mb-5">
                                <label CLASS="ms-2" for="create_company_title">FİRMA ÜNVAN</label>
                                <input id="create_company_title" class="form-control form-control-solid" placeholder="FİRMA ÜNVAN">
                            </div>
                            <div class="col-xl-12 mb-5">
                                <label CLASS="ms-2" for="create_company_phone">TELEFON</label>
                                <input id="create_company_phone" class="form-control form-control-solid phoneMask" placeholder="TELEFON">
                            </div>
                            <div class="col-xl-12 mb-5">
                                <label CLASS="ms-2" for="create_company_email">MAİL ADRESİ</label>
                                <input id="create_company_email" class="form-control form-control-solid emailMask" placeholder="MAİL ADRESİ">
                            </div>
                            <div class="col-xl-12 mb-5">
                                <label CLASS="ms-2" for="create_company_address">ADRES</label>
                                <input id="create_company_address" class="form-control form-control-solid" placeholder="ADRES">
                            </div>
                        </div>

                    </div>
                    <div class="text-center">
                        <button type="button" data-bs-dismiss="modal" class="btn btn-light me-3">Vazgeç</button>
                        <button type="button" class="btn btn-success" id="CreateCompanyButton">Oluştur</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
