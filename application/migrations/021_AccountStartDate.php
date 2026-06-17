<?php

class Migration_AccountStartDate extends CI_Migration
{
    function up()
    {
        $this->db->query("ALTER TABLE `accounts` ADD COLUMN `start_date` DATE NULL AFTER `valid_until`");
        $this->db->query("UPDATE `accounts` SET `start_date` = DATE(`created_on`) WHERE `start_date` IS NULL");
    }

    function down()
    {
        $this->db->query("ALTER TABLE `accounts` DROP `start_date`");
    }
}
