<form action="<?php echo base_url("accounts/save");?>" method="post">
<input type="hidden" name="uuid" value="">
    <div class="row">
        <div class="col-md-4">
            <h5>Account Details</h5>
            <div class="form-group">
                <label for="customer_id">Customer</label>
                <div class="input-group">
                    <select name="customer_id" id="customer_id" class="form-control" required autofocus>
                        <option value="">Select Customer</option>
                        <?php foreach($customers as $customer):?>
                        <option value="<?php echo $customer->customer_id;?>"><?php echo $customer->company_name;?></option>
                        <?php endforeach;?>
                    </select>
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modalAddCustomer" title="Add new customer">
                            <i class="fa fa-plus"></i>
                        </button>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <label for="">Token</label>
                <input class="form-control" name="token" type="text" minlength='32' maxlength='32' placeholder="" value="<?php echo $token;?>" required>
                <p class="notes">Token must be 32 characters</p>
            </div>
            <div class="form-group">
                <label for="">Domain</label>
                <input class="form-control" name="domain" type="text" placeholder="" value="">
            </div>

            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input class="form-control" name="start_date" id="start_date" type="date"
                    value="<?php echo date('Y-m-d');?>" required>
            </div>
            <div class="form-group">
                <label for="validity_years">Validity</label>
                <select id="validity_years" class="form-control">
                    <option value="1" selected>1 Year</option>
                    <option value="2">2 Years</option>
                    <option value="3">3 Years</option>
                </select>
            </div>
            <div class="form-group">
                <label for="valid_until">Valid Until</label>
                <input class="form-control" name="valid_until" id="valid_until" type="date" placeholder=""
                    value="<?php echo date("Y-m-d", strtotime('+1 year'));?>" required readonly>
            </div>
        </div>
        <div class="col-md-4">
            <h5>SMTP Settings</h5>
            <div class="form-group">
                <label for="">Hostname</label>
                <input class="form-control" name="hostname" type="text" placeholder="" value="" required>
            </div>
            <div class="form-group">
                <label for="">Username</label>
                <input class="form-control" name="username" type="text" placeholder="" value="" required>
            </div>
            <div class="form-group">
                <label for="">Sender</label>
                <input class="form-control" name="sender" type="text" placeholder="" value="" required>
            </div>
            <div class="form-group">
                <label for="">Display Name</label>
                <input class="form-control" name="display_name" type="text" placeholder="" value="" required>
            </div>
            <div class="form-group">
                <label for="">Password</label>
                <input class="form-control" name="password" type="password" minlength='8' placeholder="" value=""
                    required>
                <p class="notes">Min 8 characters</p>
            </div>
            <div class="form-group">
                <label for="">Port</label>
                <input class="form-control" name="port" type="text" placeholder="" value="" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <a href="<?php echo base_url("accounts/listing");?>">
                <div class="btn btn-warning"><i class="fa fa-chevron-left"></i> Back</div>
            </a>
            <button class="btn btn-info"><i class="fa fa-save"></i> Save</button>
        </div>
    </div>
</form>
<?php $this->load->view('modals/modalAddCustomerSimple'); ?>