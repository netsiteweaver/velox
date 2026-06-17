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

    if ($('#validity_years').length) {
        setValidUntil();
    }

    $('#quick_save_customer').on('click', function () {
        var $modal = $('#modalAddCustomerForm');
        var data = {
            company_name: $.trim($modal.find('[name=company_name]').val()),
            email: $.trim($modal.find('[name=email]').val()),
            phone_number1: $.trim($modal.find('[name=phone_number1]').val()),
            address: $.trim($modal.find('[name=address]').val()),
            remarks: $.trim($modal.find('[name=remarks]').val())
        };

        var valid = true;
        $modal.find('.form-group').removeClass('has-error');

        if (!data.company_name) {
            $modal.find('[name=company_name]').closest('.form-group').addClass('has-error');
            valid = false;
        }
        if (!data.email) {
            $modal.find('[name=email]').closest('.form-group').addClass('has-error');
            valid = false;
        }

        if (!valid) {
            toastr.error('Please enter company name and email.');
            return;
        }

        var $btn = $(this).prop('disabled', true);

        $.ajax({
            url: base_url + 'customers/quick_save',
            method: 'POST',
            data: data,
            dataType: 'json',
            success: function (response) {
                if (response.result) {
                    var $select = $('#customer_id');
                    if ($select.find('option[value="' + response.customer_id + '"]').length === 0) {
                        $select.append($('<option>', {
                            value: response.customer_id,
                            text: response.company_name
                        }));
                    }
                    $select.val(response.customer_id);
                    $modal.find('input, textarea').val('');
                    $('#modalAddCustomer').modal('hide');
                    toastr.success('Customer created');
                } else {
                    toastr.error(response.reason || 'Failed to create customer');
                }
            },
            error: function () {
                toastr.error('Failed to create customer');
            },
            complete: function () {
                $btn.prop('disabled', false);
            }
        });
    });

    $('#modalAddCustomer').on('hidden.bs.modal', function () {
        $(this).find('.form-group').removeClass('has-error');
    });
});
