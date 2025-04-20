<form action="<?php echo base_url("accounts/update");?>" method="post">
<input type="hidden" name="uuid" value="<?php echo $account->uuid;?>">
    <div class="row">
        <div class="col-md-4">
            <h5>Account Details</h5>
            <div class="form-group">
                <label for="">Customer</label>
                <select name="customer_id" id="" class="form-control" required autofocus>
                    <option value="">Select Customer</option>
                    <?php foreach($customers as $customer):?>
                    <option value="<?php echo $customer->customer_id;?>" <?php echo ($customer->customer_id == $account->customer_id) ? 'selected' : '';?>><?php echo $customer->company_name;?></option>
                    <?php endforeach;?>
                </select>
                <p class="notes">&nbsp;</p>
            </div>
            <div class="form-group">
                <label for="">Token</label>
                <input class="form-control" name="token" type="text" minlength='32' maxlength='32' placeholder="" value="<?php echo $account->token;?>" required>
                <p class="notes">Token must be 32 characters</p>
            </div>
            <div class="form-group">
                <label for="">Domain</label>
                <input class="form-control" name="domain" type="text" placeholder="" value="<?php echo $account->domain;?>">
                <p class="notes">&nbsp;</p>
            </div>

            <div class="form-group">
                <label for="">Valid Until</label>
                <input class="form-control" name="valid_until" type="date" placeholder="" value="<?php echo substr($account->valid_until,0,10);?>" required>
                <p class="notes">&nbsp;</p>
            </div>
        </div>
        <div class="col-md-4">
            <h5>SMTP Settings</h5>
            <div class="form-group">
                <label for="">Hostname</label>
                <input class="form-control" name="hostname" type="text" placeholder="" value="<?php echo $account->hostname;?>" required>
                <p class="notes">&nbsp;</p>
            </div>
            <div class="form-group">
                <label for="">Username</label>
                <input class="form-control" name="username" type="text" placeholder="" value="<?php echo $account->username;?>" required>
                <p class="notes">&nbsp;</p>
            </div>
            <div class="form-group">
                <label for="">Sender</label>
                <input class="form-control" name="sender" type="text" placeholder="" value="<?php echo $account->sender;?>" required>
                <p class="notes">&nbsp;</p>
            </div>
            <div class="form-group">
                <label for="">Display Name</label>
                <input class="form-control" name="display_name" type="text" placeholder="" value="<?php echo $account->display_name;?>" required>
                <p class="notes">&nbsp;</p>
            </div>
            <div class="form-group">
                <label for="">Password</label>
                <input class="form-control" name="password" type="text" minlength='8' placeholder="" value="<?php echo $account->password;?>"
                    required>
                <p class="notes">Min 8 characters</p>
            </div>
            <div class="form-group">
                <label for="">Port</label>
                <input class="form-control" name="port" type="text" placeholder="" value="<?php echo $account->port;?>" required>
                <p class="notes">&nbsp;</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <a href="<?php echo base_url("accounts/listing");?>">
                <div class="btn btn-warning"><i class="fa fa-chevron-left"></i> Back</div>
            </a>
            <button class="btn btn-info"><i class="fa fa-save"></i> Update</button>
        </div>
    </div>
</form>
<?php //die;?>