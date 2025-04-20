<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Accounts extends MY_Controller
{

    public $data;

    public function __construct()
    {
        parent::__construct();
        $this->data['controller']   = str_replace("-", "", $this->uri->segment(1, "dashboard"));
        $this->data['method']       = $this->uri->segment(2, "index");
        $this->mybreadcrumb->add('Accounts', base_url('accounts/listing'));
        
        $this->load->model("accesscontrol_model");
        $this->data['perms']['add'] = $this->accesscontrol_model->authorised("accounts", "add");
        $this->data['perms']['edit'] = $this->accesscontrol_model->authorised("accounts", "edit");
        $this->data['perms']['view'] = $this->accesscontrol_model->authorised("accounts", "view");
        $this->data['perms']['delete'] = $this->accesscontrol_model->authorised("accounts", "delete");

        $this->load->model("accounts_model");
    }

    public function index()
    {
        redirect(base_url('accounts/listing'));
    }

    private function setFields($values=[])
    {
        $this->data['fields'] = array(
            ['field_name'=>'uuid','type'=>'hidden','label'=>'','value'=>isset($values['uuid'])?$values['uuid']:'','autofocus'=>false,'required'=>false,'placeholder'=>''],
            ['field_name'=>'company_name','type'=>'text','label'=>'Company Name','value'=>isset($values['company_name'])?$values['company_name']:'','autofocus'=>false,'required'=>true,'placeholder'=>'Enter Company Name'],
            ['field_name'=>'address','type'=>'text','label'=>'Address','value'=>isset($values['address'])?$values['address']:'','autofocus'=>false,'required'=>false,'placeholder'=>'Enter Address'],
            ['field_name'=>'phone_number1','type'=>'text','label'=>'Phone 1','value'=>isset($values['phone_number1'])?$values['phone_number1']:'','autofocus'=>false,'required'=>false,'placeholder'=>'Enter Phone NUmber'],
            ['field_name'=>'email','type'=>'email','label'=>'Email','value'=>isset($values['email'])?$values['email']:'','autofocus'=>false,'required'=>true,'placeholder'=>'Enter Email'],
            ['field_name'=>'remarks','type'=>'textarea','label'=>'Remarks','value'=>isset($values['remarks'])?$values['remarks']:'','autofocus'=>false,'required'=>false,'placeholder'=>'']
        );
    }

    public function add()
    {
        //Access Control
        if (!isAuthorised(get_class(), "add")) return false;

        //Breadcrumbs
        $this->mybreadcrumb->add('Add', base_url('accounts/add'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['page_title'] = "Add Account";

        // $this->setFields();
        $this->load->model("customers_model");
        $this->data['customers'] = $this->customers_model->lookup();
        $this->data['token'] = bin2hex(random_bytes(16));//randomName(32);

        $this->data["content"] = $this->load->view("/accounts/add", $this->data, true);
        $this->load->view("/layouts/default",$this->data);
    }

    public function save()
    {
        //Access Control
        if (!isAuthorised(get_class(), "add")) return false;

        $referer = $this->input->post("referer");
        $result = $this->accounts_model->save();

        if($result['result']) {
            flashSuccess("Accounts saved successfully..");
            redirect(base_url(empty($referer)?"accounts/listing":$referer));
        }else{
            flashDanger("Error saving record. Reason:" . $result['reason']);
            redirect(base_url(empty($referer)?"accounts/listing":$referer));
        }


    }

    public function edit()
    {
        //Access Control 
        if (!isAuthorised(get_class(), "edit")) return false;

        $uuid = $this->uri->segment(3);
        $this->data['account'] = $this->accounts_model->get($uuid);

        if(empty($this->data['account'])){
            flashDanger("Account not found");
            redirect(base_url("accounts/listing"));
        }

        //Breadcrumbs
        $this->mybreadcrumb->add('Edit', base_url('accounts/edit'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->load->model("customers_model");
        $this->data['customers'] = $this->customers_model->lookup();

        $this->data["content"] = $this->load->view("/accounts/edit", $this->data, true);
        $this->load->view("/layouts/default",$this->data);
    }

    public function view()
    {
        //Access Control 
        if (!isAuthorised(get_class(), "view")) return false;

        $uuid = $this->uri->segment(3);
        $this->data['account'] = $this->accounts_model->get($uuid);
        
        //Breadcrumbs
        $this->mybreadcrumb->add('View', base_url('accounts/view'));
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();

        $this->data["content"] = $this->load->view("/accounts/view", $this->data, true);
        $this->load->view("/layouts/default",$this->data);
    }

    public function update()
    {
        //Access Control        
        if (!isAuthorised(get_class(), "edit")) return false;

        $postedData = $this->input->post();


        $this->load->model('accounts_model');
        $result = $this->accounts_model->save($postedData);

        if ($result['result']) {
                flashSuccess("Accounts has been successfully updated");
                redirect(base_url('accounts/listing'));
        } else {

            flashSuccess("Error updating Account. ".$result['reason']);
            redirect(base_url('accounts/edit/'.$this->input->post("uuid")));
        }
    }

    public function listing()
    {
        //Access Control        
        if (!isAuthorised(get_class(), "listing")) return false;

        $this->load->model("system_model");
        $this->data['rows_per_page'] = empty($this->input->get("display"))?$this->system_model->getParam("rows_per_page"):$this->input->get("display");
        $page = $this->uri->segment(3, '1');

        $this->data['accounts'] = $this->accounts_model->get(null,$page,$this->data['rows_per_page'],$this->input->get('search_text'));
        $total_records = $this->accounts_model->total_records($this->input->get('search_text'));

        //Breadcrumbs
        $this->data['breadcrumbs'] = $this->mybreadcrumb->render();
        $this->data['page_title'] = "Accounts";

        $this->data['pagination'] = getPagination("accounts/listing",$total_records,$this->data['rows_per_page']);

        $this->data["content"] = $this->load->view("/accounts/listing", $this->data, true);
        $this->load->view("/layouts/default",$this->data);
    }

}
