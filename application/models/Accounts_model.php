<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Accounts_model extends CI_Model
{

    public function get($uuid="",$page="",$rows_per_page="",$search_text="")
    {
        if(empty($uuid)){
            $this->db->select("a.*,c.company_name,u.name agent");
            $this->db->from("accounts a");
            $this->db->join("customers c","c.customer_id = a.customer_id");
            $this->db->join("users u","u.id=a.created_by","left");
            
            $page = (empty($page))?1:$page;
            if(!empty($search_text)){
                $this->db->group_start();
                $this->db->like("c.company_name",$search_text);
                $this->db->or_like("c.phone_number1",$search_text);
                $this->db->or_like("c.phone_number2",$search_text);
                $this->db->or_like("c.address",$search_text);
                $this->db->or_like("c.city",$search_text);
                $this->db->group_end();
                // $page = 1;
            }else{
                // $page = (empty($page))?1:$page;
            }
            $offset = ($page-1) * $rows_per_page;
            $this->db->where(array("a.status"=>'1'));
            $this->db->order_by("c.company_name");
            $this->db->limit($rows_per_page,$offset);
            $query = $this->db->get();
            return $query->result();
        }else{
            $this->db->select("a.*,u.name agent,c.company_name");
            $this->db->from("accounts a");
            $this->db->join("customers c","c.customer_id = a.customer_id");
            $this->db->join("users u","u.id=a.created_by","left");
            $this->db->where(array("a.uuid"=>$uuid,"a.status"=>'1'));
            $query = $this->db->get();
            return $query->row();
        }

    }

    public function total_records($search_text="")
    {
        $this->db->select("count(customer_id) as ct")
                ->from("accounts")
                ->where("status","1");
        if(!empty($search_text)){
            $this->db->group_start();
            $this->db->like("company_name",$search_text);
            $this->db->or_like("full_name",$search_text);
            $this->db->or_like("phone_number1",$search_text);
            $this->db->or_like("phone_number2",$search_text);
            $this->db->or_like("address",$search_text);
            $this->db->or_like("city",$search_text);
            $this->db->group_end();
        }
        return $this->db->get()->row("ct");
    }

    public function save()
    {
        $valid = true;
        $error_message = "";
        // debug($_POST);
        if(empty($this->input->post("customer_id"))) {
            $error_message .= "Customer is Mandatory<br>";
            $valid = false;
        }
        if( strlen($this->input->post("token")) != 32) {
            $error_message .= "Token must be 32 characters<br>";
            $valid = false;
        }
        if( !$valid ) {
            return array("result"=>false,"reason"=>$error_message);
        }
        $this->db->set("customer_id",$this->input->post("customer_id"));
        $this->db->set("token",$this->input->post("token"));
        $this->db->set("domain",$this->input->post("domain"));
        $this->db->set("valid_until",$this->input->post("valid_until"));
        $this->db->set("hostname",$_POST['hostname']);
        $this->db->set("username",$_POST['username']);
        $this->db->set("sender",$_POST['sender']);
        $this->db->set("display_name",$_POST['display_name']);
        $this->db->set("password",$this->input->post("password"));
        $this->db->set("port",$this->input->post("port"));

        $db_debug = $this->db->db_debug;
        $this->db->db_debug = FALSE;
        
        if(empty($this->input->post("uuid"))){
            $uuid = gen_uuid();
            $this->db->set("uuid",gen_uuid());
            $this->db->set("created_by",$_SESSION['user_id']);
            $this->db->set("created_on","NOW()",FALSE);
            $this->db->insert("accounts");

            $check = $this->db->error();
            if($check['code']>0){
                return array("result"=>false,"reason"=>$check['message']);
            }
            $_POST['uuid'] = $uuid;
        }else{
            $this->db->where("uuid",$this->input->post("uuid"));
            $this->db->update("accounts");
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
        $this->db->select("a.*,u.name agent");
        $this->db->from("accounts c");
        $this->db->join("users u","u.id=a.created_by","left");
        if(!empty($uuid)) $this->db->where("a.uuid",$uuid);
        if(!empty($searchTerm)){
            $this->db->group_start();
            $this->db->like("a.company_name",$searchTerm);
            $this->db->or_like("a.full_name",$searchTerm);
            $this->db->or_like("a.phone_number1",$searchTerm);
            $this->db->or_like("a.phone_number2",$searchTerm);
            $this->db->or_like("a.email",$searchTerm);
            $this->db->or_like("a.vat",$searchTerm);
            $this->db->or_like("a.brn",$searchTerm);
            $this->db->or_like("a.address",$searchTerm);
            $this->db->or_like("a.city",$searchTerm);
            $this->db->group_end();
        }
        $this->db->where("a.status","1");
        $this->db->order_by("company_name");
        return $this->db->get()->result();
    }

    public function lookup()
    {
        return $this->db->select("customer_id,uuid,company_name,full_name")->from("accounts")->order_by('company_name, full_name')->where("status","1")->get()->result();
    }

}
