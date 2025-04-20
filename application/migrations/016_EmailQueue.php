<?php

class Migration_EmailQueue extends CI_Migration
{
    function up()
    {
        $maxId = $this->db->select("MAX(id) as maxId")->from("menu")->get()->row()->maxId;
        $maxId = intval($maxId);
        $this->db->query("INSERT INTO `menu` (`id`, `type`, `nom`, `controller`, `action`, `color`, `url`, `class`, `display_order`, `parent_menu`, `visible`, `Normal`, `Admin`, `Root`, `module`, `status`, `backoffice`) VALUES
                                ($maxId+1, 'menu', 'Email Queue', 'emailqueue', '', '#FFFFFF', NULL, 'fa-at', 2, 0, 1, 1, 1, 1, 0, 1, 0),
                                ($maxId+2, 'menu', 'Listing', 'emailqueue', 'listing', '', NULL, 'fa-list-ul', 1, $maxId+1, 1, 1, 1, 1, 0, 1, 0),
                                ($maxId+3, 'menu', 'View', 'emailqueue', 'View', '', NULL, '', 999, 0, 0, 1, 1, 1, 0, 1, 0),
                                ($maxId+4, 'menu', 'Delete', 'emailqueue', 'delete', '', NULL, '', 999, 0, 0, 1, 1, 1, 0, 1, 0)");
    }

    function down()
    {
        $this->db->query("DELETE FROM menu WHERE controller = 'emailqueue");
    }
}