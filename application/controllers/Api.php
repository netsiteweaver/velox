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
                $var->content = $var->content . $this->getBanner();
                $var->date_created = date("Y-m-d H:i:s");
                $this->db->insert('email_queue', $var);
            }else{
                show_error('Unauthorized', 401);
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
        // return ($check) ? true : false;
        return $check->id;
    }

    private function getBanner()
    {
        $banner = '<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="max-width:800px;">
                        <tbody>
                            <tr>
                                <td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;">

                                    <div class="mj-column-per-100 mj-outlook-group-fix"
                                        style="font-size:24px;text-align:center;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                            style="vertical-align:top;" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
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