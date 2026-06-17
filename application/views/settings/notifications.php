<?php
$events = array(
    array(
        'key' => 'create_account',
        'title' => 'Account Created',
        'class' => 'bg-teal',
        'notes' => 'Notify selected admins when a new VeloxMail account is created.',
    ),
    array(
        'key' => 'update_account',
        'title' => 'Account Updated',
        'class' => 'bg-orange',
        'notes' => 'Notify selected admins when an account is updated or renewed.',
    ),
    array(
        'key' => 'delete_account',
        'title' => 'Account Deleted',
        'class' => 'bg-danger',
        'notes' => 'Notify selected admins when an account is deleted.',
    ),
    array(
        'key' => 'account_expiring',
        'title' => 'Account Expiring',
        'class' => 'bg-yellow',
        'notes' => 'Notify selected admins when customer expiry reminders are sent.',
    ),
    array(
        'key' => 'email_failed',
        'title' => 'Email Delivery Failed',
        'class' => 'bg-maroon',
        'notes' => 'Notify selected admins when a queued email fails to send.',
    ),
);
?>
<div class="row">
    <div class="col-md-12 text-center">
        <p>Choose which admin users should receive email notifications for VeloxMail events below. Customer expiry reminders are always sent to the customer; selections here receive an admin copy.</p>
    </div>
</div>

<?php foreach ($events as $event): ?>
<?php $recipients = isset($notifications[$event['key']]) ? $notifications[$event['key']] : array(); ?>
<div class="row">
    <div class="col-lg-8 col-md-10">
        <div class="card">
            <div class="card-header <?php echo $event['class']; ?>">
                <h3 class="card-title"><?php echo $event['title']; ?></h3>
            </div>
            <div class="card-body">
                <p class="notes"><?php echo $event['notes']; ?></p>
                <table id="<?php echo $event['key']; ?>" class="table table-bordered table-hover process">
                    <thead>
                        <tr>
                            <th style="width:60px;">Photo</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th style="width:80px;" class="text-center">Notify</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr data-user="<?php echo $user->id; ?>">
                            <td class="text-center">
                                <?php if (!empty($user->photo)): ?>
                                <img style="width:40px;height:40px;border-radius:50%;object-fit:cover;" src="<?php echo base_url('uploads/users/' . $user->photo); ?>" alt="">
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($user->name); ?></td>
                            <td><?php echo htmlspecialchars($user->email); ?></td>
                            <td class="text-center">
                                <input type="checkbox" name="<?php echo $user->id; ?>" <?php echo in_array($user->id, $recipients) ? 'checked' : ''; ?>>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <button type="button" class="btn <?php echo $event['class']; ?> updatenotifications" data-type="<?php echo $event['key']; ?>">
                    <i class="fa fa-save"></i> Save for <?php echo $event['title']; ?>
                </button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<div class="row">
    <div class="col-md-8 col-md-offset-2 col-lg-8">
        <button type="button" class="btn btn-block btn-outline-info" id="updateAll">
            <i class="fa fa-save"></i> Save All Notifications
        </button>
    </div>
</div>
