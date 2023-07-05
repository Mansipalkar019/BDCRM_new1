<?php
class Login extends CI_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library("session");
        $this->load->model("Login_model");
       
        // $this->session->session_start();
    }

    public function index()
    {
        $data['title'] = "Login";
        $this->load->view("main/login", $data);
    }

    public function login()
    {
        if ($this->input->server("REQUEST_METHOD") == "POST") {
            $this->form_validation->set_rules("username", "username", "trim|required|max_length[100]|xss_clean");
            $this->form_validation->set_rules("password", "password", "trim|required|max_length[100]|xss_clean");

            if ($this->form_validation->run()) {
                $username  = strtolower($this->security->xss_clean($this->input->post("username")));
                $password = sha1($this->security->xss_clean($this->input->post("password")));

                if ($username == "" && $password == "") {
                    $this->session->set_flashdata("error", "Username or password can't be blank");
                    redirect(base_url("login"));
                } else {
                    $userChk = $this->Login_model->usercheck($username, $password);

                    if ($userChk) {
                        
                        $setUserSession = array(
                           
                            "id" => $userChk[0]['id'],
                            "user_name" => $userChk[0]['username'],
                            "first_name" => $userChk[0]['first_name'],
                            "last_name" => $userChk[0]['last_name'],
                            "designation_name"=>$userChk[0]['designation_name'],
                            "designation_id"=>$userChk[0]['designation_id']
                        );

                       
                        $session = $this->session->set_userdata($setUserSession);
                        // echo "<pre>";
                        // print_r($this->session->userdata());
                        // die;
                        
                        
                        if ($this->session->userdata('id') != "") {
                            $this->session->set_flashdata("success", "Login Successfull..!!");
                            redirect(base_url("dashboard"));
                        } else {
                            $data = array(
                                "error" => "Oops!! Some Error Occurred"
                            );
                            $this->session->set_flashdata("error", $data['error']);
                            redirect(base_url("login"));
                        }
                    } else {
                        $data = array(
                            "error" => "Invalid Login."
                        );
                        $this->session->set_flashdata("error", $data['error']);
                        redirect(base_url("login"));
                    }
                }
            } else {
                $data = array(
                    "error" => validation_errors()
                );
                $this->session->set_flashdata("error", $data['error']);
                redirect(base_url("login"));
            }
        } else {
            redirect('');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('id');
        $this->session->sess_destroy();
        redirect(base_url("login"));
    }
}
