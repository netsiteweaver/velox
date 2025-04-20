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

    public function get($uuid="",$page="",$rows_per_page="",$customer="",$domain="",$start_date="",$end_date="",$search_text="")
    {
        if(empty($uuid)){
            $this->db->select("e.*,a.domain,c.company_name");
            $this->db->from("email_queue e");
            $this->db->join("accounts a","a.id = e.account_id");
            $this->db->join("customers c","c.customer_id = a.customer_id","left");
            if(!empty($customer)) $this->db->where('c.company_name',$customer);
            if(!empty($domain)) $this->db->where('a.domain',$domain);
            if(!empty($start_date)) $this->db->where('DATE(e.date_sent) >=',$start_date);
            if(!empty($end_date)) $this->db->where('DATE(e.date_sent) <=',$end_date);
            
            $page = (empty($page))?1:$page;
            $offset = ($page-1) * $rows_per_page;
            $this->db->where(array("a.status"=>'1'));
            $this->db->order_by("e.date_created","desc");
            $this->db->limit($rows_per_page,$offset);
            $query = $this->db->get();
            $result = $query->result();
            return $result;
        }else{
            $this->db->select("e.*,a.domain,c.company_name");
            $this->db->from("email_queue e");
            $this->db->join("accounts a","a.id = e.account_id");
            $this->db->join("customers c","c.customer_id = a.customer_id","left");
            $this->db->where(array("e.uuid"=>$uuid));
            $query = $this->db->get();
            return $query->row();
        }

    }

    public function total_records($customer="",$domain="",$start_date="",$end_date="",$search_text="")
    {

        $this->db->select("count(e.id) as ct");
        $this->db->from("email_queue e");
        $this->db->join("accounts a","a.id = e.account_id");
        $this->db->join("customers c","c.customer_id = a.customer_id","left");
        if(!empty($customer)) $this->db->where('c.company_name',$customer);
        if(!empty($domain)) $this->db->where('a.domain',$domain);
        if(!empty($start_date)) $this->db->where('DATE(e.date_sent) >=',$start_date);
        if(!empty($end_date)) $this->db->where('DATE(e.date_sent) <=',$end_date);

        // $this->db->select("count(customer_id) as ct")
                // ->from("accounts")
                // ->where("status","1");
        // if(!empty($search_text)){
        //     $this->db->group_start();
        //     $this->db->like("company_name",$search_text);
        //     $this->db->or_like("full_name",$search_text);
        //     $this->db->or_like("phone_number1",$search_text);
        //     $this->db->or_like("phone_number2",$search_text);
        //     $this->db->or_like("address",$search_text);
        //     $this->db->or_like("city",$search_text);
        //     $this->db->group_end();
        // }
        return $this->db->get()->row("ct");
    }

}