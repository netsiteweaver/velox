<?php

class Migration_AccountExpiryReminder extends CI_Migration
{
    function up()
    {
        $this->db->query("ALTER TABLE `accounts` ADD COLUMN `expiry_reminder_sent_at` DATETIME NULL AFTER `valid_until`");

        $exists = $this->db->select('count(id) as ct')->from('params')->where('title', 'account_expiry_reminder_days')->get()->row('ct');
        if ($exists == "0") {
            $this->db->insert('params', array(
                'title' => 'account_expiry_reminder_days',
                'value' => '7',
            ));
        }
    }

    function down()
    {
        $this->db->query("ALTER TABLE `accounts` DROP `expiry_reminder_sent_at`");
        $this->db->where('title', 'account_expiry_reminder_days')->delete('params');
    }
}
