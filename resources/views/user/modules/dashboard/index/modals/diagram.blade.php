<div class="modal fade show" id="DiagramModal" tabindex="-1" aria-modal="true" role="dialog" data-bs-backdrop="static">
    <div class="modal-dialog modal-fullscreen">
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
            <div class="modal-body scroll-y px-10 px-lg-15 pt-20 pb-15">
                <div class="form fv-plugins-bootstrap5 fv-plugins-framework">
                    <input type="hidden" id="update_diagram_id">
                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="cols-sample-area">
                                <div class="control_section">
                                    <div class="symPalette_section">
                                        <div id="symbolpalette">
                                        </div>
                                    </div>
                                    <div class="middle_section"></div>
                                    <div class="diagram_section">
                                        <div id="diagram"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="button" data-bs-dismiss="modal" class="btn btn-light me-3">Kapat</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
