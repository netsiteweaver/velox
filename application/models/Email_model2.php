<?php

/**
 * Description of Email
 *
 * @author Reeaz Ramoly <reeaz@netsiteweaver.com>
 */
class Email_model2 extends CI_Model{
    var $data;

    public function __construct() {
        parent::__construct();
        $this->load->model("system_model");
        $this->smtp_settings = $this->system_model->getParam("smtp_settings",true);
    }

    public function save($recipient,$subject,$content)
    {
        $this->db->set("date_created",'NOW()',FALSE);
        $var = array(
            'uuid'          =>  gen_uuid(),
            'recipients'     =>  $recipient,
            'subject'       =>  $subject,
            'content'       =>  $content,
            'date_sent'     =>  NULL,
        );
        $this->db->insert("email_queue",$var);
    }

    public function sendFromQueue($to,$subject,$message,$account_id="",$cc="",$display_name="")
    {
        if(empty($account_id)){
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = (($this->smtp_settings->port=='465')?'ssl://':'') . $this->smtp_settings->hostname;
            $config['smtp_user'] = $this->smtp_settings->username;
            $config['smtp_pass'] = $this->smtp_settings->password;
            $config['smtp_port'] = $this->smtp_settings->port;
        }else{
            $account = $this->db->from("accounts")->where("id",$account_id)->get()->row();
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = (($account->port=='465')?'ssl://':'') . $account->hostname;
            $config['smtp_user'] = $account->username;
            $config['smtp_pass'] = $account->password;
            $config['smtp_port'] = $account->port;
        }

        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = "html";
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";

        try{
            $this->load->library('email');
            $this->email->initialize($config);
            if(empty($account_id)){
                $this->email->from($this->smtp_settings->from, ((!empty($display_name)) ? $display_name : $this->smtp_settings->display_name) );
            }else{
                $this->email->from($account->sender, ((!empty($display_name)) ? $display_name : $account->display_name) );
            }
            $this->email->to($to);
            if(!empty($cc)) $this->email->cc($cc);
            $this->email->subject($subject);
            $this->email->message($message);

            if($this->email->send(true)){
                return array(true);
            }else{
                // echo $this->email->print_debugger();
                return array(false,$this->email->print_debugger());
            }
        }catch(Exception $ex){
            debug($ex);
        }
            
    } 

}