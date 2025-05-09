<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Emailqueue extends MY_Controller
{

    public $data;

    public function __construct()
    {
        parent::__construct();
        $this->data['controller']   = str_replace("-", "", $this->uri->segment(1, "dashboard"));
        $this->data['method']       = $this->uri->segment(2, "index");
        $this->mybreadcrumb->add('Emails', base_url('emailqueue/listing'));
        
        $this->load->model("accesscontrol_model");
        // $this->data['perms']['add'] = $this->accesscontrol_model->authorised("emailqueue", "add");
        // $this->data['perms']['edit'] = $this->accesscontrol_model->authorised("emailqueue", "edit");
        $this->data['perms']['view'] = $this->accesscontrol_model->authorised("emailqueue", "view");
        $this->data['perms']['delete'] = $this->accesscontrol_model->authorised("emailqueue", "delete");

        $this->load->model("Emailqueue_model");
    }

    public function index()
    {
        redirect(base_url('emailqueue/listing'));
    }

    public function view()
    {
        //Access Control 
        if (!isAuthorised(get_class(), "view")) return false;

        $uuid = $this->uri->segment(3);
        $this->data['email'] = $this->Emailqueue_model->get($uuid);

        if(empty($this->data['email'])) {
            flashDanger("We are sorry. Failed to retrieve email");
            redirect(base_url("emailqueue/listing?customer={$this->input->get('customer')}&domain={$this->input->get('domain')}&start_date={$this->input->get('start_date')}&end_date={$this->input->get('end_date')}"));
        }
        
        //Breadcrumbs
        $this->mybreadcrumb->add('View', base_url('emailqueue/view'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data["content"] = $this->load->view("/emailqueue/view", $this->data, true);
        $this->load->view("/layouts/default",$this->data);
    }

    public function listing()
    {
        //Access Control        
        if (!isAuthorised(get_class(), "view")) return false;

        $this->load->model("system_model");
        $this->data['rows_per_page'] = empty($this->input->get("display"))?$this->system_model->getParam("rows_per_page"):$this->input->get("display");
        $page = $this->uri->segment(3, '1');

        $this->data['emailqueue'] = $this->Emailqueue_model->get(
                                        null,
                                        $page,
                                        $this->data['rows_per_page'],
                                        $this->input->get('customer'),
                                        $this->input->get('domain'),
                                        $this->input->get('recipients'),
                                        $this->input->get('start_date'),
                                        $this->input->get('end_date'),
                                        $this->input->get('search_text')
                                    );
        $total_records = $this->Emailqueue_model->total_records($this->input->get('customer'),
                                                                $this->input->get('domain'),
                                                                $this->input->get('recipients'),
                                                                $this->input->get('start_date'),
                                                                $this->input->get('end_date'),
                                                                $this->input->get('search_text'));



        $this->data['domains'] = $this->db->query("SELECT DISTINCT a.`domain`
                                                        FROM email_queue eq 
                                                        LEFT JOIN accounts a ON a.id = eq.account_id 
                                                        LEFT JOIN customers c ON c.customer_id = a.customer_id
                                                        WHERE a.domain IS NOT NULL AND a.domain <> ''")->result();
        $this->data['customers'] = $this->db->query("SELECT DISTINCT c.company_name
                                                        FROM email_queue eq 
                                                        LEFT JOIN accounts a ON a.id = eq.account_id 
                                                        LEFT JOIN customers c ON c.customer_id = a.customer_id")->result();
        $this->data['recipients'] = $this->db->query("SELECT DISTINCT eq.recipients
                                                        FROM email_queue eq 
                                                        LEFT JOIN accounts a ON a.id = eq.account_id 
                                                        LEFT JOIN customers c ON c.customer_id = a.customer_id")->result();                                                        

        //Breadcrumbs
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['page_title'] = "Emails";

        $this->data['pagination'] = getPagination("emailqueue/listing",$total_records,$this->data['rows_per_page']);

        $this->data["content"] = $this->load->view("/emailqueue/listing", $this->data, true);
        $this->load->view("/layouts/default",$this->data);
    }

}
