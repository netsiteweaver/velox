jQuery(function(){
    
    $('.view-email').on('click', function(){
        let emailId = $(this).closest("tr").data("email-id");
        $.ajax({
            url: base_url + "dashboard/viewEmail",
            data: {emailId:emailId},
            method: "POST",
            dataType: "JSON",
            success: function(response) {
                if(response.result) {
                    $('#emailViewModal .date_created').text(response.email.date_created);
                    $('#emailViewModal .date_sent').text(response.email.date_sent);
                    $('#emailViewModal .subject').text(response.email.subject);
                    $('#emailViewModal .recipients').text(response.email.recipients);
                    $('#emailViewModal .sender_name').text(response.email.sender_name);
                    $('#emailViewModal .content').html(response.email.content);
                }
                $('#emailViewModal').modal("show")
            }
        })
    })
})

