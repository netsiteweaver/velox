<style>
    .table.table-lg tr th, .table.table-lg tr td {
        padding: 10px 20px;
    }
    .account-param-value {
        word-break: break-all;
    }
</style>
<?php
$fields = [
    ['label' => 'Customer', 'value' => $account->company_name],
    ['label' => 'Domain', 'value' => $account->domain],
    ['label' => 'Token', 'value' => $account->token],
    ['label' => 'Start Date', 'value' => date_format(date_create(!empty($account->start_date) ? $account->start_date : $account->created_on), 'Y-m-d')],
    ['label' => 'Valid Until', 'value' => date_format(date_create($account->valid_until), 'Y-m-d')],
    ['label' => 'Hostname', 'value' => $account->hostname],
    ['label' => 'Username', 'value' => $account->username],
    ['label' => 'Sender', 'value' => $account->sender],
    ['label' => 'Display Name', 'value' => $account->display_name],
    ['label' => 'Password', 'value' => $account->password],
    ['label' => 'Port', 'value' => $account->port],
];
?>
<div class="row">
    <div class="col-lg-6 col-md-12 table-responsive">
        <table class="table table-lg table-expanded table-bordered">
            <tbody>
                <?php foreach ($fields as $field): ?>
                <tr>
                    <th style="width:150px;"><?php echo $field['label']; ?></th>
                    <td>
                        <span class="account-param-value"><?php echo htmlspecialchars($field['value']); ?></span>
                        <button type="button" class="btn btn-xs btn-default btn-copy-param float-right" data-copy="<?php echo htmlspecialchars($field['value'], ENT_QUOTES); ?>" title="Copy">
                            <i class="fa fa-copy"></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
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
