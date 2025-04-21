<?php

class Migration_AllowAds extends CI_Migration
{
    function up()
    {
        $this->db->query("ALTER TABLE `accounts` ADD COLUMN `allow_ads` INT NOT NULL DEFAULT '1'");
    }

    function down()
    {
        $this->db->query("ALTER TABLE `accounts` DROP `allow_ads`");
    }
}