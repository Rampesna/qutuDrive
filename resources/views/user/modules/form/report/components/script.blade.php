<script src="{{ asset('assets/jqwidgets/jqxcore.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxbuttons.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxscrollbar.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxlistbox.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxdropdownlist.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxmenu.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxgrid.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxgrid.selection.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxgrid.columnsreorder.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxgrid.columnsresize.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxgrid.filter.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxgrid.sort.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxdata.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxgrid.pager.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxnumberinput.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxwindow.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxdata.export.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxgrid.export.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxexport.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqxgrid.grouping.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/globalization/globalize.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jqgrid-localization.js') }}"></script>
<script src="{{ asset('assets/jqwidgets/jszip.min.js') }}"></script>

<script>

    $(document).ready(function () {
        $('#loader').hide();
    });

    var base64regex = /^([0-9a-zA-Z+/]{4})*(([0-9a-zA-Z+/]{2}==)|([0-9a-zA-Z+/]{3}=))?$/;

    var formId = parseInt(base64regex.test(`{{ $id }}`) ? atob(`{{ $id }}`) : 0);

    var formSubmitsDiv = $('#formSubmits');
    var DownloadExcelButton = $('#DownloadExcelButton');

    function getFormSubmits() {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.formSubmit.getByFormId') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                formId: formId,
            },
            success: function (response) {
                console.log(response);

                var dataFields = [];
                var columns = [];
                $.each(response.response.questions, function (i, question) {
                    dataFields.push({
                        name: question.name,
                        type: 'string'
                    });

                    columns.push({
                        text: question.name,
                        datafield: question.name,
                        columntype: 'textbox'
                    });
                });
                var source = {
                    localdata: response.response.answers,
                    datatype: "array",
                    datafields: dataFields
                };
                var dataAdapter = new $.jqx.dataAdapter(source);
                formSubmitsDiv.jqxGrid({
                    width: '100%',
                    height: '600',
                    source: dataAdapter,
                    columnsresize: true,
                    groupable: true,
                    theme: 'metro',
                    filterable: true,
                    showfilterrow: true,
                    pageable: false,
                    sortable: true,
                    pagesizeoptions: ['10', '20', '50', '1000'],
                    localization: getLocalization('tr'),
                    columns: columns,
                });
                formSubmitsDiv.on('rowclick', function (event) {
                    formSubmitsDiv.jqxGrid('selectrow', event.args.rowindex);
                    var rowindex = formSubmitsDiv.jqxGrid('getselectedrowindex');
                    $('#selected_survey_row_index').val(rowindex);
                    var dataRecord = formSubmitsDiv.jqxGrid('getrowdata', rowindex);
                    $('#selected_survey_id').val(dataRecord.id);
                    $('#selected_survey_code').val(dataRecord.kodu);
                    return false;
                });
                formSubmitsDiv.jqxGrid('sortby', 'id', 'desc');

                DownloadExcelButton.show();
            },
            error: function (error) {
                console.log(error);
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

    getFormSubmits();

    DownloadExcelButton.click(function () {
        formSubmitsDiv.jqxGrid('exportdata', 'xlsx', 'Form Sonuçları');
    });

</script>
