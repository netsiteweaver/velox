<?php

/**
 * Description of Email
 *
 * @author Reeaz Ramoly <reeaz@netsiteweaver.com>
 */
class Email_model3 extends CI_Model{
    var $data;

    public function __construct() {
        parent::__construct();
        $this->load->model("system_model");
        $this->smtp_settings = $this->system_model->getParam("smtp_settings",true);
    }

    public function save($recipient,$subject,$content)
    {
        $var = array(
            'uuid'          =>  gen_uuid(),
            'date_created'  =>  date("Y-m-d H:i:s"),
            'recipients'    =>  $recipient,
            'subject'       =>  $subject,
            'content'       =>  $content,
            'date_sent'     =>  NULL,
        );
        $this->db->insert("email_queue",$var);
    }

}