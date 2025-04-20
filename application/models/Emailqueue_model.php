<?php

/**
 * Description of Email
 *
 * @author Reeaz Ramoly <reeaz@netsiteweaver.com>
 */
class Emailqueue_model extends CI_Model{

    public function __construct() {
        parent::__construct();
    }

    public function getRecent($qty=10)
    {
        return $this->db->select("e.*, c.company_name, a.domain")
                        ->from("email_queue e")
                        ->join("accounts a","a.id = e.account_id")
                        ->join("customers c","c.customer_id = a.customer_id","left")
                        ->order_by("date_created",'desc')
                        ->limit($qty)
                        ->get()
                        ->result();
    }

    public function getById($emailId)
    {
        return $this->db->select("e.date_created, e.date_sent, e.sender_name, e.recipients, e.subject, e.content")
                        ->from("email_queue e")
                        ->where("id",$emailId)
                        ->get()
                        ->row();
    }

}