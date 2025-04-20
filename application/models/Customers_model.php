<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Customers_model extends CI_Model
{

    public function get($uuid="",$page="",$rows_per_page="",$search_text="")
    {
        if(empty($uuid)){
            $this->db->select("c.*,u.name agent");
            $this->db->from("customers c");
            $this->db->join("users u","u.id=c.created_by","left");
            
            $page = (empty($page))?1:$page;
            if(!empty($search_text)){
                $this->db->group_start();
                $this->db->like("company_name",$search_text);
                // $this->db->or_like("full_name",$search_text);
                $this->db->or_like("phone_number1",$search_text);
                // $this->db->or_like("phone_number2",$search_text);
                $this->db->or_like("address",$search_text);
                $this->db->or_like("city",$search_text);
                $this->db->group_end();
                // $page = 1;
            }else{
                // $page = (empty($page))?1:$page;
            }
            $offset = ($page-1) * $rows_per_page;
            $this->db->where(array("c.status"=>'1'));
            $this->db->order_by("company_name");
            $this->db->limit($rows_per_page,$offset);
            $query = $this->db->get();
            return $query->result();
        }else{
            $this->db->select("c.*,u.name agent");
            $this->db->from("customers c");
            $this->db->join("users u","u.id=c.created_by","left");
            $this->db->where(array("c.uuid"=>$uuid,"c.status"=>'1'));
            $query = $this->db->get();
            return $query->row();
        }

    }

    public function total_records($search_text="")
    {
        $this->db->select("count(customer_id) as ct")
                ->from("customers")
                ->where("status","1");
        if(!empty($search_text)){
            $this->db->group_start();
            $this->db->like("company_name",$search_text);
            // $this->db->or_like("full_name",$search_text);
            $this->db->or_like("phone_number1",$search_text);
            // $this->db->or_like("phone_number2",$search_text);
            $this->db->or_like("address",$search_text);
            $this->db->or_like("city",$search_text);
            $this->db->group_end();
        }
        return $this->db->get()->row("ct");
    }

    public function update_portal_access()
    {
        $password = $this->input->post("password");
        $email = $this->input->post("email");
        $this->db->set("password",md5($password),true);
        $this->db->where("uuid",$this->input->post("uuid"));
        $this->db->update("customers");

        if(isset($_POST['send_password'])){

            // $email = $this->input->post("email");
            $this->load->model("Email_model3");
            $this->load->model("system_model");
            $emailData = [
                'password'          =>  $password,
                'logo'              =>  $this->system_model->getParam("logo"),
                'link'              =>  base_url('portal/customers/signin?email='.$email),
                'link_label'        =>  "Access Customer's Portal",
                'show_lifecycle'    =>  false
            ];
            $content = $this->load->view("_email/header",$emailData, true);
            $content .= $this->load->view("_email/emailPasswordToCustomer",$emailData, true);
            $content .= $this->load->view("_email/footer",[], true);
            // $path = realpath(".");
            // $h = fopen($path . "/data/taskListSent_".date('YmdHis').".html",'w');
            // if($h){
            //     fwrite($h,$content);
            //     fclose($h);    
            // }else{
            //     die('cannot create file');
            // }
            $this->Email_model3->save($email,"Your Password Has Been Updated",$content);

            flashSuccess("Email has been queued to customer with updated password");
            
        }
        
    }

    public function save()
    {
        $valid = true;
        $error_message = "";
        if(empty($this->input->post("company_name"))) {
            $error_message .= "Company Name is Mandatory<br>";
            $valid = false;
        }
        // if(empty($this->input->post("full_name"))) {
        //     $error_message .= "Customer Name is Mandatory<br>";
        //     $valid = false;
        // }
        // if(empty($this->input->post("phone_number1"))) {
        //     $error_message .= "Phone Number is Mandatory<br>";
        //     $valid = false;
        // }
        if(empty($this->input->post("email"))) {
            $error_message .= "Email is Mandatory<br>";
            $valid = false;
        }
        if( !$valid ) {
            return array("result"=>false,"reason"=>$error_message);
        }
        $this->db->set("company_name",$this->input->post("company_name"));
        // $this->db->set("full_name",$this->input->post("full_name"));
        $this->db->set("address",$this->input->post("address"));
        $this->db->set("email",$this->input->post("email"));
        $this->db->set("phone_number1",$_POST['phone_number1']);
        // $this->db->set("phone_number2",$_POST['phone_number2']);
        // $this->db->set("vat",$_POST['vat']);
        // $this->db->set("brn",$_POST['brn']);
        $this->db->set("remarks",$this->input->post("remarks"));
        $this->db->set("status","1");

        $db_debug = $this->db->db_debug;
        $this->db->db_debug = FALSE;
        
        if(empty($this->input->post("uuid"))){
            $uuid = gen_uuid();
            $this->db->set("uuid",gen_uuid());
            $this->db->set("created_by",$_SESSION['user_id']);
            $this->db->set("created_date","NOW()",FALSE);
            $this->db->insert("customers");

            $check = $this->db->error();
            if($check['code']>0){
                return array("result"=>false,"reason"=>$check['message']);
            }
            $_POST['uuid'] = $uuid;
        }else{
            $this->db->where("uuid",$this->input->post("uuid"));
            $this->db->update("customers");
            $check = $this->db->error();
            if($check['code']>0){
                return array("result"=>false,"reason"=>$check['message']);
            }
            $_POST['uuid'] = $this->input->post("uuid");
        }

        $this->db->db_debug = $db_debug;
        return array("result"=>true,"uuid"=>$_POST['uuid']);
    }

    public function fetch($uuid="",$searchTerm="")
    {
        $this->db->select("c.*,u.name agent");
        $this->db->from("customers c");
        $this->db->join("users u","u.id=c.created_by","left");
        if(!empty($uuid)) $this->db->where("c.uuid",$uuid);
        if(!empty($searchTerm)){
            $this->db->group_start();
            $this->db->like("c.company_name",$searchTerm);
            // $this->db->or_like("c.full_name",$searchTerm);
            $this->db->or_like("c.phone_number1",$searchTerm);
            // $this->db->or_like("c.phone_number2",$searchTerm);
            $this->db->or_like("c.email",$searchTerm);
            // $this->db->or_like("c.vat",$searchTerm);
            // $this->db->or_like("c.brn",$searchTerm);
            $this->db->or_like("c.address",$searchTerm);
            $this->db->or_like("c.city",$searchTerm);
            $this->db->group_end();
        }
        $this->db->where("c.status","1");
        $this->db->order_by("company_name");
        return $this->db->get()->result();
    }

    public function lookup()
    {
        return $this->db->select("customer_id,uuid,company_name")->from("customers")->order_by('company_name')->where("status","1")->get()->result();
    }

}
