<?php

class Migration_AccountExpiryReminderStages extends CI_Migration
{
    function up()
    {
        $this->db->query("ALTER TABLE `accounts` CHANGE `expiry_reminder_sent_at` `expiry_reminder_7_sent_at` DATETIME NULL");
        $this->db->query("ALTER TABLE `accounts` ADD COLUMN `expiry_reminder_1_sent_at` DATETIME NULL AFTER `expiry_reminder_7_sent_at`");
        $this->db->where('title', 'account_expiry_reminder_days')->delete('params');
    }

    function down()
    {
        $this->db->query("ALTER TABLE `accounts` DROP `expiry_reminder_1_sent_at`");
        $this->db->query("ALTER TABLE `accounts` CHANGE `expiry_reminder_7_sent_at` `expiry_reminder_sent_at` DATETIME NULL");

        $exists = $this->db->select('count(id) as ct')->from('params')->where('title', 'account_expiry_reminder_days')->get()->row('ct');
        if ($exists == "0") {
            $this->db->insert('params', array(
                'title' => 'account_expiry_reminder_days',
                'value' => '7',
            ));
        }
    }
}
