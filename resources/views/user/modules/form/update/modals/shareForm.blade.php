<div class="modal fade show" id="ShareFormModal" tabindex="-1" aria-modal="true" role="dialog" data-bs-backdrop="static">
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
                        <h1 class="mb-3">{{ __('user/modules/form.modals.shareForm.modalTitle') }}</h1>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <div class="row mb-5">
                            <div class="col-xl-12 mb-5">
                                <label for="share_form_link" class="font-weight-bolder">{{ __('user/modules/form.modals.shareForm.shareLinkTitle') }}</label>
                                <div class="input-group">
                                    <input id="share_form_link" type="text" class="form-control form-control-solid" placeholder="{{ __('user/modules/form.modals.shareForm.shareLinkTitle') }}" disabled>
                                    <button class="btn btn-icon btn-secondary" id="CopyShareLinkButton">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="form-check form-switch form-check-success form-check-solid">
                                    <input class="form-check-input" type="checkbox" id="form_accessibility_switcher" />
                                    <label class="form-check-label" for="form_accessibility_switcher">
                                        {{ __('user/modules/form.modals.shareForm.accessability') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="button" data-bs-dismiss="modal" class="btn btn-light me-3">{{ __('user/modules/form.modals.shareForm.closeButton') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
