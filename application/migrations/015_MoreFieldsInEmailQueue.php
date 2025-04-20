<?php

class Migration_MoreFieldsInEmailQueue extends CI_Migration
{
    function up()
    {
        $this->db->query("ALTER TABLE `email_queue` ADD `cc` VARCHAR(300) NULL");        
        $this->db->query("ALTER TABLE `email_queue` ADD `sender_name` VARCHAR(200) NOT NULL AFTER `date_created`");
    }

    function down()
    {
        $this->db->query("ALTER TABLE `email_queue` DROP `cc`");
        $this->db->query("ALTER TABLE `email_queue` DROP `sender_name`");        
    }
}