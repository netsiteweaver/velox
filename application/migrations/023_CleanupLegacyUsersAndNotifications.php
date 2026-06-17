<?php

class Migration_CleanupLegacyUsersAndNotifications extends CI_Migration
{
    private $legacy_notification_params = array(
        'notification_create_project',
        'notification_update_project',
        'notification_delete_project',
        'notification_create_sprint',
        'notification_update_sprint',
        'notification_delete_sprint',
        'notification_create_task',
        'notification_update_task',
        'notification_delete_task',
    );

    function up()
    {
        $this->cleanupUserReferences();

        $this->db->query("DELETE FROM users WHERE user_type != 'regular'");

        $this->db->where_in('title', $this->legacy_notification_params);
        $this->db->delete('params');
    }

    function down()
    {
        foreach ($this->legacy_notification_params as $title) {
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

    private function cleanupUserReferences()
    {
        $database = $this->db->database;
        $references = $this->db->query("
            SELECT TABLE_NAME, COLUMN_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE REFERENCED_TABLE_NAME = 'users'
              AND TABLE_SCHEMA = " . $this->db->escape($database) . "
        ")->result();

        foreach ($references as $reference) {
            if (!$this->db->table_exists($reference->TABLE_NAME)) {
                continue;
            }

            $this->db->query("
                DELETE t FROM `{$reference->TABLE_NAME}` t
                INNER JOIN users u ON u.id = t.`{$reference->COLUMN_NAME}`
                WHERE u.user_type != 'regular'
            ");
        }

        $nullable_columns = array(
            array('accounts', 'created_by'),
            array('customers', 'created_by'),
        );

        foreach ($nullable_columns as $column) {
            if (!$this->db->table_exists($column[0])) {
                continue;
            }

            $this->db->query("
                UPDATE `{$column[0]}` t
                INNER JOIN users u ON u.id = t.`{$column[1]}`
                SET t.`{$column[1]}` = NULL
                WHERE u.user_type != 'regular'
            ");
        }
    }
}
