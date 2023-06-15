<script>

    var yearSelector = $('#yearSelector');
    var monthSelector = $('#monthSelector');

    var filesRow = $('#filesRow');
    var filesRowBody = $('#filesRowBody');

    var uploadELedgerInput = $('#uploadELedgerInput');
    var singleELedgerUploadInputSelector = $('#singleELedgerUploadInput');
    var multipleELedgerUploadInputSelector = $('#multipleELedgerUploadInput');

    var SingleELedgerUploadButton = $('#SingleELedgerUploadButton');
    var MultipleELedgerUploadButton = $('#MultipleELedgerUploadButton');

    function transactions() {
        $('#TransactionsModal').modal('show');
    }

    function singleELedgerUpload() {
        $('#TransactionsModal').modal('hide');
        $('#SingleELedgerUploadModal').modal('show');
    }

    function multipleELedgerUpload() {
        $('#TransactionsModal').modal('hide');
        $('#MultipleELedgerUploadModal').modal('show');
    }

    $(document).ready(function () {
        $('#loader').hide();
        $.each(months, function (i, month) {
            monthSelector.append(`<option value="${month.id}">${month.name}</option>`);
        });
        monthSelector.val('');
    });

    var UploadELedgersButton = $('#UploadELedgersButton');

    UploadELedgersButton.click(function () {
        transactions();
    });

    $(document).delegate('.getEDefterDosyalar', 'click', function () {
        var selectedTab = $(this);
        var typeId = $(this).attr('data-type-id');
        var year = yearSelector.val();
        var month = monthSelector.val();

        if (!typeId) {
            toastr.warning('Defter Türü Seçiminde Hata Var!');
        } else if (!year) {
            toastr.warning('Lütfen Yıl Seçiniz!');
        } else if (!month) {
            toastr.warning('Lütfen Ay Seçiniz!');
        } else {
            $('.getEDefterDosyalar').removeClass('active');
            selectedTab.addClass('active');
            filesRow.empty().html(`
            <div class="col-xl-12 text-center mb-5">
                <i class="fa fa-spinner fa-spin"></i>
            </div>
            `);
            toastr.info('Veriler Alınırken Lütfen Bekleyin, Bu İşlem Biraz Uzun Sürebilir...');
            $.ajax({
                type: 'get',
                url: '{{ route('user.api.edefterdonemler.getEDefterDonem') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: {
                    companyId: SelectedCompany.val(),
                    year: year,
                    month: month,
                    typeIds: parseInt(typeId) === 0 ? [1, 2, 5, 6] : [typeId],
                },
                success: function (response) {
                    console.log('==================== getEDefterDonem Success =====================');
                    console.log(response);
                    console.log('==========================================================');
                    filesRowBody.show();
                    $.ajax({
                        type: 'get',
                        url: '{{ route('user.api.edefterdosyalar.getByDonemId') }}',
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': authUserToken
                        },
                        data: {
                            donemId: response.response.ID
                        },
                        success: function (response) {
                            console.log('==================== edefterdosyalar Success =====================');
                            console.log(response);
                            console.log('==========================================================');
                            console.log(response);
                            filesRow.empty();
                            $.each(response.response, function (i, edefterdosya) {
                                filesRow.append(`
                                <div class="col-xl-2 mb-5">
                                    <div class="card h-100 flex-center text-center py-4 px-0 cursor-pointer border border-secondary bg-hover-light-dark" style="border-radius: 10px">
                                        <i class="far fa-file-excel fa-2x mt-2 mb-5"></i>
                                        <span class="font-weight-bolder text-dark-75 mb-1">${edefterdosya.DOSYAADI}</span>
                                        <div class="fs-7 fw-bold text-gray-400 mt-auto mb-1">${edefterdosya.DOSYABOYUTU} MB</div>
                                        <span class="fs-7 fw-bold text-gray-600 mt-auto mb-1">${reformatDatetimeToDatetimeForHuman(edefterdosya.KAYITTARIHI)}</span>
                                        <span class="badge badge-${parseInt(edefterdosya.GIBDURUM) === 6 ? `success` : `warning`}">
                                            ${parseInt(edefterdosya.GIBDURUM) === 6 ? `GİB'e Başarıyla Gönderildi` : `Kuyrukta`}
                                        </span>
                                    </div>
                                </div>
                                `);
                            });
                        },
                        error: function (error) {
                            console.log('==================== edefterdosyalar Success =====================');
                            console.log(error);
                            console.log('==========================================================');
                            // console.log(error);
                            if (parseInt(error.status) === 422) {
                                $.each(error.responseJSON.response, function (i, error) {
                                    toastr.error(error[0]);
                                });
                            } else {
                                toastr.error(error.responseJSON.message);
                            }
                        }
                    });
                },
                error: function (error) {
                    console.log('==================== getEDefterDonem Error =====================');
                    console.log(error);
                    console.log('==========================================================');
                    filesRowBody.hide();
                    // console.log(error);
                    if (parseInt(error.status) === 422) {
                        $.each(error.responseJSON.response, function (i, error) {
                            toastr.error(error[0]);
                        });
                    } else if (parseInt(error.status) === 404) {
                        toastr.error('Bu Döneme Ait Defter Verisi Bulunamadı!');
                    } else {
                        toastr.error(error.responseJSON.message);
                    }
                }
            });
        }
    });


    SingleELedgerUploadButton.click(function () {
        var file = $('#single_file').prop('files')[0];
        var companyId = SelectedCompany.val();
        if (!file) {
            toastr.warning('Dosya Seçmediniz!');
        } else {
            SingleELedgerUploadButton.attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            var data = new FormData();
            data.append('file', file);
            data.append('companyId', companyId);
            $.ajax({
                contentType: false,
                processData: false,
                type: 'post',
                url: '{{ route('user.api.edefterdosyalar.singleELedgerUpload') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: data,
                success: function (response) {
                    console.log(response);
                },
                error: function (error) {
                    console.log(error);
                    SingleELedgerUploadButton.attr('disabled', false).html('Yükle');
                    if (parseInt(error.status) === 422) {
                        $.each(error.responseJSON.response, function (i, error) {
                            toastr.error(error[0]);
                        });
                    } else {
                        toastr.error(error.responseJSON.message);
                    }
                }
            });
        }
    });

</script>
