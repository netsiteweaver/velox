<style>
    .table.table-lg tr th, .table.table-lg tr td {
        padding: 10px 20px;
    }
</style>
<div class="row">
    <div class="col-lg-6 col-md-12 table-responsive">
        <table class="table table-lg table-expanded table-bordered">
            <tbody>
                <tr>
                    <th style='width:150px;'>Customer</th>
                    <td><?php echo $account->company_name;?></td>
                </tr>
                <tr>
                    <th>Domain</th>
                    <td><?php echo $account->domain;?></td>
                </tr>
                <tr>
                    <th>Token</th>
                    <td><?php echo $account->token;?></td>
                </tr>
                <tr>
                    <th>Valid Until</th>
                    <td><?php echo date_format(date_create($account->valid_until),'Y-m-d');?></td>
                </tr>
                <tr>
                    <th>Hostname</th>
                    <td><?php echo $account->hostname;?></td>
                </tr>
                <tr>
                    <th>Username</th>
                    <td><?php echo $account->username;?></td>
                </tr>
                <tr>
                    <th>Sender</th>
                    <td><?php echo $account->sender;?></td>
                </tr>
                <tr>
                    <th>Display Name</th>
                    <td><?php echo $account->display_name;?></td>
                </tr>
                <tr>
                    <th>Password</th>
                    <td><?php echo $account->password;?></td>
                </tr>
                <tr>
                    <th>Port</th>
                    <td><?php echo $account->port;?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <a href="<?php echo base_url("accounts/listing");?>">
            <div class="btn btn-warning"><i class="fa fa-chevron-left"></i> Back</div>
        </a>
    </div>
</div>