<?php


class Migration_EmailQueueContentMediumText extends CI_Migration
{
    function up()
    {
        $this->db->query("ALTER TABLE `email_queue` MODIFY `content` MEDIUMTEXT NOT NULL");
    }

    function down()
    {
        $this->db->query("ALTER TABLE `email_queue` MODIFY `content` TEXT NOT NULL");
    }
}
