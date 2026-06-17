jQuery(function () {
    $('body').on('click', '.delete-account', function (e) {
        e.preventDefault();

        var $btn = $(this);
        var url = $btn.data('url');
        var uuid = $btn.data('uuid');
        var message = $btn.data('message') || 'Are you sure you want to delete this account?';

        bootbox.confirm({
            message: message,
            buttons: {
                confirm: {
                    label: 'Yes, delete',
                    className: 'btn-danger'
                },
                cancel: {
                    label: 'Cancel',
                    className: 'btn-default'
                }
            },
            callback: function (confirmed) {
                if (!confirmed) {
                    return;
                }

                $btn.prop('disabled', true);

                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: { uuid: uuid },
                    success: function (response) {
                        if (response.result) {
                            $btn.closest('tr').fadeOut(200, function () {
                                $(this).remove();
                            });
                            toastr.success('Account has been deleted.');
                        } else {
                            toastr.error(response.reason || 'Failed to delete account.');
                            $btn.prop('disabled', false);
                        }
                    },
                    error: function () {
                        toastr.error('Failed to delete account.');
                        $btn.prop('disabled', false);
                    }
                });
            }
        });
    });
});
