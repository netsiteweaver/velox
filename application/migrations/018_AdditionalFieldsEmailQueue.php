<?php


class Migration_AdditionalFieldsEmailQueue extends CI_Migration
{
    function up()
    {
        $this->db->query("ALTER TABLE `email_queue` ADD COLUMN `failed_reason` TEXT NULL AFTER `stage`");
        $this->db->query("ALTER TABLE `email_queue` ADD COLUMN `opened_date` DATETIME NULL AFTER `opened`");
        $this->db->query("ALTER TABLE `email_queue` ADD COLUMN `opened_device` TEXT NULL AFTER `opened_date`");
        $this->db->query("ALTER TABLE `email_queue` ADD COLUMN `opened_ip` VARCHAR(20) NULL AFTER `opened_device`");
        
    }

    function down()
    {
        $this->db->query("ALTER TABLE `email_queue` DROP `opened_ip`");
        $this->db->query("ALTER TABLE `email_queue` DROP `opened_device`");
        $this->db->query("ALTER TABLE `email_queue` DROP `opened_date`");
        $this->db->query("ALTER TABLE `email_queue` DROP `failed_reason`");
    }
}