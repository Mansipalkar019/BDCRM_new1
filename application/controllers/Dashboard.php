<?php

class Dashboard extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        if(empty($this->session->userdata('id'))){
            redirect(base_url("login"));
        }
    }

    public function index()
    {
        $data['main_content'] = "main/dashboard";
        $this->load->view("includes/template",$data);
    }
}

?>