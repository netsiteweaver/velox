<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Track extends CI_Controller {

    public function email_open()
    {
        $token = $this->input->get('token', TRUE); // sanitize input
        $timestamp = date('Y-m-d H:i:s');
        $ip = $this->input->ip_address();
        $userAgent = $this->input->user_agent();

        $log = "{$timestamp} - Token: {$token}, IP: {$ip}, UA: {$userAgent}\n";
        $s = APPPATH;
        // Save to a log file
        file_put_contents(APPPATH . 'logs/email_opens.log', $log, FILE_APPEND);
        $this->updateEmailQueue($token, $ip, $userAgent);

        // Output a transparent 1x1 PNG
        header('Content-Type: image/png');
        readfile(FCPATH . 'assets/images/transparent.png');
    }

    private function updateEmailQueue($token,$ip,$userAgent)
    {
        $this->db->set("opened_ip",$ip);
        $this->db->set("opened_date","NOW()",false);
        $this->db->set("opened_device",$userAgent);
        $this->db->set("opened",'1');
        $this->db->where(["tracking_code"=>$token,"opened"=>"0"])->update("email_queue");
    }
}
