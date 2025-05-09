<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function queueEmail()
    {
        $this->load->helper('string');
        // Generate token
        $tracking_code = random_string('alnum', 48);

        $headers = $this->input->request_headers();
        $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : 
                      (isset($headers['authorization']) ? $headers['authorization'] : null);

        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $bearerToken = $matches[1];
            // Now you can use $bearerToken for validation
            $check = $this->check($bearerToken);
            if($check){
                $jsonData = file_get_contents('php://input');
                $var = json_decode($jsonData);
                $var->account_id = $check;
                $var->content = $var->content . $this->getBanner() . $this->addTracker($tracking_code);
                $var->date_created = date("Y-m-d H:i:s");
                $var->tracking_code = $tracking_code;
                $this->db->insert('email_queue', $var);

                header('Content-Type: application/json');
                http_response_code(200);
                echo json_encode(['status' => true, 'email_id' => $this->db->insert_id()]);
                exit;
            }else{
                header('Content-Type: application/json');
                http_response_code(401);
                echo json_encode(['status' => false, 'message' => 'Invalid Token']);
                exit;
            }
        } else {
            // No token found
            show_error('Unauthorized', 401);
        }
    }

    public function check($bearerToken)
    {
        $check = $this->db->select("a.*")
                        ->from("accounts a")
                        ->join("customers c","c.customer_id = a.customer_id","left")
                        ->where("a.token", $bearerToken)
                        ->where("valid_until >=", date("Y-m-d H:i:s"))
                        ->where("a.status", 1)
                        ->where("c.status", 1)
                        ->get()->row();
        return ($check) ? $check->id : null;
        // return $check->id;
    }

    private function getBanner()
    {
        $banner = '<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="max-width:800px;">
                        <tbody>
                            <tr>
                                <td style="direction:ltr;font-size:0px;text-align:center;">

                                    <div class="mj-column-per-100 mj-outlook-group-fix"
                                        style="font-size:24px;text-align:center;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                            style="vertical-align:top;" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td align="left" style="font-size:0px;word-break:break-word;">
                                                        <div
                                                            style="font-family:Helvetica, Arial, sans-serif;font-size:18px;font-weight:400;line-height:24px;text-align:left;color:#434245;">
                                                            <a href=\'https://github.com/netsiteweaver/velox\'>
                                                            <img src="'.base_url().'assets/images/veloxmail-logo-horizontal-banner-800px-2.png"
                                                                alt="" style="width:100%">
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </td>
                            </tr>
                        </tbody>
                    </table>';
        return $banner;
    }

    private function addTracker($tracking_code)
    {
        $tracker = '<img src="' . base_url("track/email?token=$tracking_code") . '" width="1" height="1" style="border:1px solid #ccc" alt="" />';
        return $tracker;
    }

}