jQuery(function () {
    function setValidUntil() {
        var startDate = $('#start_date').val();
        var years = parseInt($('#validity_years').val(), 10);

        if (!startDate || !years) {
            return;
        }

        $('#valid_until').val(moment(startDate).add(years, 'years').format('YYYY-MM-DD'));
    }

    $('#validity_years, #start_date').on('change', setValidUntil);
});
