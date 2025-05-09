jQuery(function(){
    $('.monitor').on("change blur", function(){
        let customer = $('select[name=customer]').val();
        let domain = $('select[name=domain]').val();
        let recipients = $('select[name=recipients]').val();
        let start_date = $('input[name=start_date]').val();
        let end_date = $('input[name=end_date]').val();

        let queryString = base_url + `emailqueue/listing?customer=${customer}&domain=${domain}&recipients=${recipients}&start_date=${start_date}&end_date=${end_date}`;
        window.location.href = queryString;
    })
})