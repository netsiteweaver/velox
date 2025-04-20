<div class="row">
    <div class="col-md-2">
        <a href="<?php echo base_url("accounts/add");?>">
            <div class="btn btn-info"><i class="fa fa-plus"></i> Add</div>
        </a>
    </div>
</div>
<div class="row table-responsive">
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Domain</th>
                    <th>Created</th>
                    <th>Valid Until</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($accounts as $account):?>
                <tr>
                    <td><?php echo $account->company_name;?></td>
                    <td><?php echo $account->domain;?></td>
                    <td><?php echo date_format(date_create($account->created_on),'Y-m-d');?></td>
                    <td><?php echo date_format(date_create($account->valid_until),'Y-m-d');?></td>
                    <td>
                        <?php if($perms['view']):?>
                        <a href="<?php echo base_url("accounts/view/".$account->uuid);?>">
                            <div class="btn btn-default"><i class="fa fa-eye"></i> View</div>
                        </a>
                        <?php endif;?>
                        <?php if($perms['edit']):?>
                        <a href="<?php echo base_url("accounts/edit/".$account->uuid);?>">
                            <div class="btn btn-info"><i class="fa fa-edit"></i> Edit</div>
                        </a>
                        <?php endif;?>
                        <?php if($perms['delete']):?>
                        <a href="<?php echo base_url("accounts/delete/".$account->uuid);?>">
                            <div class="btn btn-danger"><i class="fa fa-trash"></i> Delete</div>
                        </a>
                        <?php endif;?>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>