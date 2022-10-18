<script>
    var yearSelector = $('#yearSelector');
    var monthSelector = $('#monthSelector');

    $(document).ready(function () {
        $('#loader').hide();
        $.each(months, function (i, month) {
            monthSelector.append(`<option value="${month.id}">${month.name}</option>`);
        });
        monthSelector.val('');
    });



</script>
