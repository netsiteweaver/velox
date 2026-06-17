<div class="modal fade" id="modalAddCustomer" tabindex="-1" role="dialog" aria-labelledby="modalAddCustomerTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddCustomerTitle"><i class="fa fa-user"></i> Add Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalAddCustomerForm">
                <div class="form-group">
                    <label>Company Name *</label>
                    <input type="text" class="form-control" name="company_name" placeholder="Enter company name" required>
                </div>
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" class="form-control" name="email" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" class="form-control" name="phone_number1" placeholder="Enter phone number">
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <input type="text" class="form-control" name="address" placeholder="Enter address">
                </div>
                <div class="form-group">
                    <label>Remarks</label>
                    <textarea class="form-control" name="remarks" rows="3" placeholder=""></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                <button type="button" id="quick_save_customer" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
            </div>
        </div>
    </div>
</div>
