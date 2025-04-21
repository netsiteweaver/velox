<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function queueEmail()
    {
        $headers = $this->input->request_headers();
        $origin = $this->input->server('HTTP_ORIGIN');
        $origin = str_replace(['https://','http://'],'',$origin);
        $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : 
                      (isset($headers['authorization']) ? $headers['authorization'] : null);

        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $bearerToken = $matches[1];
            // Now you can use $bearerToken for validation
            $check = $this->check($bearerToken);
            if($check){
                if(!empty($check->domain)){
                    if($origin != $check->domain){
                        $this->output
                            ->set_status_header(401)
                            ->set_content_type('application/json')
                            ->set_output(json_encode(array("result"=>false,"reason"=>'Domain not allowed')))
                            ->_display();
                        exit;
                    }
                }
                $jsonData = file_get_contents('php://input');
                $var = json_decode($jsonData);
                $isValid = $this->validate($var);
                if($isValid['valid']){
                    $var->account_id = $check->id;
                    if($check->allow_ads) $var->content = $var->content . $this->getBanner();
                    $data = array(
                        "uuid"          =>  gen_uuid(),
                        "date_created"  =>  date("Y-m-d H:i:s"),
                        "sender_name"   =>  !isset($var->sender_name) ? $check->display_name : $var->sender_name,
                        "recipients"    =>  $var->recipients,
                        "subject"       =>  $var->subject,
                        "content"       =>  $var->content
                    );
                    $this->db->insert('email_queue', $data);
                    // echo $this->db->last_query();
                    echo json_encode(array(
                        "result"    =>  true,
                        "rows"      =>  $this->db->affected_rows()
                    ));
                }else{
                    // $this->output
                    //     ->set_status_header(401)
                    //     ->set_content_type('application/json')
                    //     ->set_output(json_encode($isValid))
                    //     ->_display();
                    // exit;
                }
                
            }else{
                $this->output
                        ->set_status_header(401)
                        ->set_content_type('application/json')
                        ->set_output(json_encode(array("reason"=>"Invalid Token")))
                        ->_display();
                    exit;
                // show_error('Unauthorized', 401);
            }
        } else {
            // No token found
            $this->output
                        ->set_status_header(401)
                        ->set_content_type('application/json')
                        ->set_output(json_encode(array(
                            "reason"    =>  "Missing Token"
                        )))
                        ->_display();
                    exit;
            // show_error('Unauthorized', 401);
        }
    }

    public function validate($var)
    {
        $valid = true;
        $errorMessage = "";
        if( (!isset($var->uuid)) || (empty($var->uuid)) ){
            $valid = false;
            $errorMessage .= "Missing UUID<br>";
        }
        if( (!isset($var->recipients)) || (empty($var->recipients)) ){
            $valid = false;
            $errorMessage .= "Missing Recipients<br>";
        }
        if( (!isset($var->subject)) || (empty($var->subject)) ){
            $valid = false;
            $errorMessage .= "Missing Subject<br>";
        }
        if( (!isset($var->content)) || (empty($var->content)) ){
            $valid = false;
            $errorMessage .= "Missing Content<br>";
        }

        return array(
            'valid'         =>  $valid,
            'errorMessage'  =>  $errorMessage
        );
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
        return $check;
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
                                                            <img src="'.base_url().'assets/images/veloxmail-logo-horizontal-banner-800px.png"
                                                                alt="" style="width:100%">
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

}