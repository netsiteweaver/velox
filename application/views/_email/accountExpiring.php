<div style="margin:30px auto; max-width:600px;">
    <h3>Account Expiry Reminder</h3>
    <p>Hi <?php echo htmlspecialchars($account->company_name); ?>,</p>
    <p>
        This is a reminder that your VeloxMail account
        <strong><?php echo htmlspecialchars($account->domain); ?></strong>
        will expire on <strong><?php echo $valid_until; ?></strong>
        (<?php echo $days_remaining; ?> day<?php echo $days_remaining == 1 ? '' : 's'; ?> remaining).
    </p>
    <p>Please contact us before this date to renew your account and avoid any interruption to your email service.</p>
    <?php if (!empty($companyInfo->email)): ?>
    <p>You can reach us at <a href="mailto:<?php echo htmlspecialchars($companyInfo->email); ?>"><?php echo htmlspecialchars($companyInfo->email); ?></a>.</p>
    <?php endif; ?>
</div>
