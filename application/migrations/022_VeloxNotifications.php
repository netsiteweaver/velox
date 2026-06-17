<?php

class Migration_VeloxNotifications extends CI_Migration
{
    private $notification_keys = array(
        'notification_create_account',
        'notification_update_account',
        'notification_delete_account',
        'notification_account_expiring',
        'notification_email_failed',
    );

    function up()
    {
        foreach ($this->notification_keys as $title) {
            $exists = $this->db->select('count(id) as ct')->from('params')->where('title', $title)->get()->row('ct');
            if ($exists == "0") {
                $this->db->insert('params', array(
                    'title' => $title,
                    'value' => '[]',
                    'status' => '1',
                ));
            }
        }
    }

    function down()
    {
        $this->db->where_in('title', $this->notification_keys)->delete('params');
    }
}
