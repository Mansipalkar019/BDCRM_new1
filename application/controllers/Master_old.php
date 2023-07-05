<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Master  extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("model");
    }

 public function add_departments($id = 0){
        $data['main_content'] = "main/add_department";
        $data['getAllDepartments'] = $this->model->getData('master_department', array('status' => '1'));
        if ($id != 0) {
            $data['getDepartment'] = $this->model->getData('master_department', array('status' => '1', 'id' => $id))[0];
        } else {
            $data['getDepartment'] = array();
        }
        $this->load->view("includes/template", $data);
    }

    public function submit_departments(){
        if (empty($_POST['id'])) {
            $this->form_validation->set_rules("department_name", "Department Name", "trim|is_unique[master_department.dept_name]|min_length[2]|max_length[100]|xss_clean", array("required" => "%s is required"));
            $this->form_validation->set_rules("sort_name", "Sort Name", "trim|is_unique[master_department.sort_name]|min_length[2]|max_length[100]|xss_clean", array("required" => "%s is required"));

            if ($this->form_validation->run() == true) {
                $departmentName = $this->security->xss_clean($this->input->post("department_name"));
                $sortName = $this->security->xss_clean($this->input->post("sort_name"));

                $data = array(
                    "dept_name" => $departmentName,
                    "sort_name" => $sortName
                );
                $addDept  = $this->model->insertData('master_department',$data);
                if ($addDept) {
                    $this->session->set_flashdata("success", "Departrment Added Successfully");
                    redirect(base_url("master/add_departments"));
                } else {
                    $this->session->set_flashdata("error", "Failed To Add Department");
                    redirect(base_url("master/add_departments"));
                }
            } else {
                $data = array(
                    'error' => validation_errors()
                );
                $this->session->set_flashdata("error", $data['error']);
                redirect(base_url("master/add_departments"));
            }
        } else {

            $form_data = $_POST;
            if (isset($form_data) && !empty($form_data)) {
                $id = $form_data['id'];
                $data['dept_name'] = $form_data['department_name'];
                $data['sort_name'] = $form_data['sort_name'];
                $updateDept = $this->model->updateData("master_department", $data, array('id' => $id));
                if ($updateDept) {
                    $this->session->set_flashdata("success", "Departrment Updated Successfully");
                    redirect(base_url("master/add_departments"));
                } else {
                    $this->session->set_flashdata("error", "Failed To Update Department...!!!");
                    redirect(base_url("master/add_departments"));
                }
            }
        }
    }


    public function delete_departments($id)
    {
        if (isset($id) && !empty($id)) {
            $this->model->updateData('master_department', array('status' => '0'), array('id ' => $id));
            $data['msg'] = 'child category has been deleted successfully.';
            $this->session->set_flashdata("success",$data['msg']);
            redirect(base_url("master/add_departments"));
        }
    }

   

     public function update_departments($id){
        $form_data = $_POST;
        if (isset($form_data) && !empty($form_data)) {
            $data['department_name'] = $form_data['department_name'];
            $data['sort_name'] = $form_data['sort_name'];
            $updateDept = $this->model->update_departments("master_departmentr", $form_data, array('id' => $id));
            if ($updateDept) {
                $this->session->set_flashdata("success", "Departrment Updated Successfully");
                redirect(base_url("master/add_departments"));
            } else {
                $this->session->set_flashdata("error", "Failed To Update Department...!!!");
                redirect(base_url("master/add_departments"));
            }
        }

    }

    public function add_designations($id=0){

        $data['main_content'] = "main/add_designation";
        if($id!=0){
           $data['getDesigValues'] = $this->model->getData('master_designation', array('status' => '1','id'=>$id))[0];
        }else{
               $data['getDesigValues'] = "";     
        }
        $data['getAllDesignations'] = $this->model->getData('master_designation', array('status' => '1'));
        $this->load->view("includes/template", $data);
    }

    public function submit_designations(){
      
        $this->form_validation->set_rules("designation_name","Designation Name","trim|required|min_length[2]|max_length[100]|xss_clean",array("required"=>"%s is required"));

        if($this->form_validation->run()==true){
            $designationName = $this->security->xss_clean($this->input->post("designation_name"));
            $data = array(
                "designation_name" => $designationName,
            );

            if(!empty($this->input->post("designation_name"))){
                $addDesig = $this->model->insertData('master_designation',$data);
                if($addDesig){
                    $this->session->set_flashdata("success","Designation has been added successfully");
                }
            }else{
                $desig_id = $this->input->post("designation_id");
                $updateDesig = $this->model->updateData("master_designation", $data, array('id' => $desig_id));
                if($updateDesig){
                    $this->session->set_flashdata("success","Designation has been Updated successfully");
                }
            }   
            
        }
        else{

            $data = array('error' => validation_errors());
            $this->session->set_flashdata("error",$data['error']);
        }
        redirect(base_url("master/add_designations"));

    }

    public function delete_designations($id=0){
        if($id!='' && $id!=0){
         $deleteDesign = $this->model->updateData("master_designation", array('status'=>0), array('id' => $id));
         if($deleteDesign){
             $this->session->set_flashdata("success","Designation has been successfully deleted");
         }
        }
        redirect(base_url("master/add_designations"));

    }


    

    public function submit_projects()
    {
        $this->form_validation->set_rules("project_name","Project Name","trim|required|min_length[2]|max_length[100]|xss_clean",array("required"=>"%s is required"));

        if($this->form_validation->run()==true){
            $project_name = $this->security->xss_clean($this->input->post("project_name"));
            $data = array(
                "project_name" => $project_name,
            );

            $addProjects = $this->model->insertData('master_project',$data);
            if($addProjects){
                $this->session->set_flashdata("success","");

            }
        }
        else
        {
            $data = array(
                'error' => validation_errors()
            );
            $this->session->set_flashdata("error",$data['error']);
        }
         redirect(base_url("master/add_projects"));

    }

    // Added By Raj Namdev

    public function add_projects(){
        $data['main_content'] = "main/add_project";
        $data['getAllProjects'] = $this->model->getData('master_project', array('status' => '1'));
        $this->load->view("includes/template", $data);

    }

    public function add_users($id=0){

        $data['main_content'] = "main/add_users";
        $data['getAllDesignations'] = $this->model->getData('master_designation', array('status' => '1'));
        if($id!=0 && $id!=''){
           $data['usersData'] = $this->model->getData('users', array('status' => '1','id'=>$id))[0];
        }
        $data['getAllUsers'] = $this->getUserWithDesig();
        $this->load->view("includes/template", $data);
    }


    public function getUserWithDesig(){
        $sql = "SELECT u.*,ds.designation_name FROM `users` as u 
                left join master_designation as ds on u.designation = ds.id where u.status=1";
        return $this->model->getSqlData($sql);
    }

    public function submit_users(){

        $this->form_validation->set_rules("firstname","First Name","trim|required|min_length[2]|max_length[100]|xss_clean",array("required"=>"%s is required"));
        $this->form_validation->set_rules("email","Email","trim|required|min_length[2]|max_length[100]|xss_clean",array("required"=>"%s is required"));
        $this->form_validation->set_rules("username","Username","trim|required|min_length[2]|max_length[100]|xss_clean",array("required"=>"%s is required"));
        $this->form_validation->set_rules("lastname","Lastname","trim|required|min_length[2]|max_length[100]|xss_clean",array("required"=>"%s is required"));
         $this->form_validation->set_rules("password","Password","trim|required|min_length[2]|max_length[100]|xss_clean",array("required"=>"%s is required"));

        if($this->form_validation->run()==true){
            $user_id = $this->security->xss_clean($this->input->post("user_id"));
            $firstname = $this->security->xss_clean($this->input->post("firstname"));
            $lastname = $this->security->xss_clean($this->input->post("lastname"));
            $designation = $this->security->xss_clean($this->input->post("designation"));
            $email = $this->security->xss_clean($this->input->post("email"));
            $username = $this->security->xss_clean($this->input->post("username"));
            $password = sha1($this->security->xss_clean($this->input->post("password")));
            
            $data = array(
                "username" => $username,
                "password" => $password,
                "first_name" =>$firstname,
                "last_name" => $lastname,
                "designation" => $designation,
                "email" => $email
            );
            if($user_id!=0 && $user_id!=''){
                unset($data['password']);
                $user_id = $this->input->post('user_id');
                $updateUsers = $this->model->updateData("users", $data, array('id' => $user_id));
                if($updateUsers){
                   $this->session->set_flashdata("success","User has been Successfully Updated");
                }

            }else{

             $addUsers = $this->model->insertData('users',$data);
             if($addUsers){
                 $this->session->set_flashdata("success","User has been Added Successfully");
                }
            }
        }
            
        else{
            $data = array(
                'error' => validation_errors()
            );

            $this->session->set_flashdata("error",$data['error']);
        }
        redirect(base_url("master/add_users"));

    }

    public function deleteUser($id){
        if(!empty($id)){
            $deleteUsers = $this->model->updateData("users", array('status'=>0), array('id' => $id));
            if($deleteUsers){
               $this->session->set_flashdata("success","User has been successfully deleted");
            }
        }else{
            $this->session->set_flashdata("success","Something went Wrong.");
        }
        redirect(base_url("master/add_users"));

    }

    public function permissons(){
         $data['main_content'] = "main/permissons";
         $this->load->view("includes/template", $data);
    }

    public function set_permissons(){
      if(!empty($_POST)){
        $designation_id = $this->input->post("designation_id");
        $designation_name = $this->input->post("designation_name");
        $menu = $this->input->post('menu');
        $submenu = $this->input->post('submenu');
        if(!empty($this->input->post('menu'))){

        $deleteXRecord = $this->model->deleteData("bdscrm_menu_access",
             array('designation' =>$designation_id));
        $deleteXSubRecord = $this->model->deleteData("bdscrm_submenu_access",
            array('designation_id' =>$designation_id));

        foreach ($menu as $k => $val) {
          $menu_id = $k;
          $data = array('designation'=>$designation_id,'menu_id'=>$k,'access'=>1);
          $setMenuRoles = $this->model->insertData('bdscrm_menu_access',$data);
        }

        foreach ($submenu as $key => $value) {
            $submenu_data = array('designation_id'=>$designation_id,'submenu_id'=>$key,'access'=>1);
            $setSubMenuRoles = $this->model->insertData('bdscrm_submenu_access',$submenu_data);

        }
          $this->session->set_flashdata("success","Successfully Roles Updated");
    }else{
        $this->session->set_flashdata("error","Something went wrong.");
    }
         $redirection = "master/permissons/".$designation_id.'/'.$designation_name;
         redirect(base_url($redirection));
      }
    }

    public function add_country($id=0){

         if($id!=0 && $id!=''){
            $data['getFormInfo'] = $this->model->getData('bdcrm_countries', array('status' => '1','id'=>$id))[0];
         }
         $data['main_content'] = "main/add_country";
         $data['getAllCountry'] = $this->model->getData('bdcrm_countries', array('status' => '1'));
         $this->load->view("includes/template", $data);
    }

    public function submit_country(){
        $this->form_validation->set_rules("country_name","Country Name","trim|required|min_length[2]|max_length[100]|xss_clean",array("required"=>"%s is required"));
        $this->form_validation->set_rules("sortname","Country Sort Name","trim|required|min_length[2]|max_length[100]|xss_clean",array("required"=>"%s is required"));
         $this->form_validation->set_rules("phone_code","Country Phone Code","trim|required|min_length[2]|max_length[100]|xss_clean",array("required"=>"%s is required"));

        if($this->form_validation->run()==true){
            $country_id = $this->security->xss_clean($this->input->post("country_id"));
            $country_name = $this->security->xss_clean($this->input->post("country_name"));
            $sort_name = $this->security->xss_clean($this->input->post("sortname"));
            $phone_code = $this->security->xss_clean($this->input->post("phone_code"));
            $data = array(
                "name" => $country_name,
                "sortname" => $sort_name,
                "phonecode" => $phone_code,
            );
            if(empty($country_id)){
                $addCountry = $this->model->insertData('bdcrm_countries',$data);
                if($addCountry){
                    $this->session->set_flashdata("success","Country has been successfully added.");
                }
            }else{
              $updateCountry = $this->model->updateData("bdcrm_countries", $data, array('id' => $country_id));
              if($updateCountry){
                  $this->session->set_flashdata("success","Country has been successfullly updated");
              }
            }
            
        }
        else
        {
            $data = array(
                'error' => validation_errors()
            );
            $this->session->set_flashdata("error",$data['error']);
        }
         redirect(base_url("master/add_country"));
    }

    public function delete_country($id){
        if(!empty($id)){
          $deleteCountry = $this->model->updateData("bdcrm_countries", array('status'=>0), array('id' => $id));
          if($deleteCountry){
             $this->session->set_flashdata("success","Country has been successfullly deleted");
          }
        }
        redirect(base_url("master/add_country"));
    }

    public function add_company_disposition($id=0){

         if($id!='' AND $id!=0){
            $data['getFormCompDispo'] = $this->model->getData('bdcrm_company_disposition', array('status' => '1','id'=>$id))[0];  
         }
         $data['getCompDispo'] = $this->model->getData('bdcrm_company_disposition', array('status' => '1'));  
         $data['main_content'] = "main/add_company_disposition";
         $this->load->view("includes/template", $data);
    }

    public function submit_company_dispositions(){
        $this->form_validation->set_rules("c_dispostions_name","Company Dispostions","trim|required|min_length[2]|max_length[100]|xss_clean",array("required"=>"%s is required"));
        if($this->form_validation->run()==true){
            $disposition_name = $this->security->xss_clean($this->input->post("c_dispostions_name"));
            $data = array(
                "company_dispostion" => $disposition_name,
            );

            $cid = $this->input->post("c_id");
            if(empty($cid)){
                $addDisposition = $this->model->insertData('bdcrm_company_disposition',$data);
                if($addDisposition){
                    $this->session->set_flashdata("success","Successfullly Company Disposition Added");
                }
            }else{
                $updateDept = $this->model->updateData("bdcrm_company_disposition", $data, array('id' => $cid));
                if($updateDept){
                    $this->session->set_flashdata("success","Successfullly Company Disposition Updated.");
                }

            }
            
        }
        else
        {
            $data = array(
                'error' => validation_errors()
            );
            $this->session->set_flashdata("error",$data['error']);
        }
         redirect(base_url("master/add_company_disposition"));

    }

    public function DeleteDisposition($id=0){
        if($id!='' && $id!=0){
         if(!empty($id)){
            $deleteCompDispostion = $this->model->updateData("bdcrm_company_disposition", array('status'=>0), array('id' => $id));
            if($deleteCompDispostion){
               $this->session->set_flashdata("success","Company Disposition has been successfullly deleted.");
            }
         }
        }
       redirect(base_url("master/add_company_disposition"));

    }
    public function add_web_disposition($id=0){

         if($id!='' AND $id!=0){
            $data['getFormWebDispo'] = $this->model->getData('bdcrm_web_disposition', array('status' => '1','id'=>$id))[0];  
         }
         $data['getWebDispo'] = $this->model->getData('bdcrm_web_disposition', array('status' => '1'));  
         $data['main_content'] = "main/add_web_disposition";
         $this->load->view("includes/template", $data);
    }

    public function submit_web_dispositions(){
        $this->form_validation->set_rules("web_dispostions_name","Web Dispostions","trim|required|min_length[2]|max_length[100]|xss_clean",array("required"=>"%s is required"));
        if($this->form_validation->run()==true){
            $web_disposition_name = $this->security->xss_clean($this->input->post("web_dispostions_name"));
            $data = array(
                "web_disposition_name" => $web_disposition_name,
            );

            $wid = $this->input->post("w_id");
            if(empty($wid)){
                $addWebDisposition = $this->model->insertData('bdcrm_web_disposition',$data);
                if($addWebDisposition){
                    $this->session->set_flashdata("success","Web Disposition Successfullly Added");
                }
            }else{
                $updateWebDis = $this->model->updateData("bdcrm_web_disposition", $data, array('id' => $wid));
                if($updateWebDis){
                    $this->session->set_flashdata("success","Web Disposition Successfullly Updated.");
                }

            }
            
        }
        else
        {
            $data = array(
                'error' => validation_errors()
            );
            $this->session->set_flashdata("error",$data['error']);
        }
         redirect(base_url("master/add_web_disposition"));

    }

    public function DeleteWebDisposition($id=0){
        if($id!='' && $id!=0){
         if(!empty($id)){
            $deleteWebDispostion = $this->model->updateData("bdcrm_web_disposition", array('status'=>0),
            array('id' => $id));
            if($deleteWebDispostion){
               $this->session->set_flashdata("success","Web disposition has been successfullly deleted.");
            }
         }
        }
       redirect(base_url("master/add_web_disposition"));
    }


    public function add_caller_disposition($id=0){

        if($id!='' AND $id!=0){
            $data['getFormCallDispo'] = $this->model->getData('bdcrm_caller_disposition', array('status' => '1','id'=>$id))[0];  
         }
         $data['getCallerDispo'] = $this->model->getData('bdcrm_caller_disposition', array('status' => '1'));  
         $data['main_content'] = "main/add_caller_disposition";
         $this->load->view("includes/template", $data);

    }


     public function submit_caller_dispositions(){

        $this->form_validation->set_rules("caller_disposition","Caller Dispostions","trim|required|min_length[2]|max_length[100]|xss_clean",array("required"=>"%s is required"));
        if($this->form_validation->run()==true){
            $caller_disposition = $this->security->xss_clean($this->input->post("caller_disposition"));
            $data = array(
                "caller_disposition" => $caller_disposition,
            );

            $caller_id = $this->input->post("caller_id");
            if(empty($caller_id)){
                $addCallerDisposition = $this->model->insertData('bdcrm_caller_disposition',$data);
                if($addCallerDisposition){
                    $this->session->set_flashdata("success","Caller Disposition Successfullly Added");
                }
            }else{
                $updateCallDis = $this->model->updateData("bdcrm_caller_disposition", $data, array('id' => $caller_id));
                if($updateCallDis){
                    $this->session->set_flashdata("success","Caller Disposition Successfullly Updated.");
                }

            }
            
        }
        else
        {
            $data = array(
                'error' => validation_errors()
            );
            $this->session->set_flashdata("error",$data['error']);
        }
         redirect(base_url("master/add_caller_disposition"));

    }

    public function DeleteCallerDisposition($id=0){
        if($id!='' && $id!=0){
         if(!empty($id)){
            $deleteCallerDispostion = $this->model->updateData("bdcrm_caller_disposition", array('status'=>0),
            array('id' => $id));
            if($deleteCallerDispostion){
               $this->session->set_flashdata("success","Caller disposition has been successfullly deleted.");
            }
         }
        }
       redirect(base_url("master/add_caller_disposition"));
    }



    public function add_project_type($id=0){

        if($id!='' AND $id!=0){
            $data['getFormProjects'] = $this->model->getData('bdcrm_project_type', array('status' => '1','id'=>$id))[0];  
         }
         $data['getProjectTypes'] = $this->model->getData('bdcrm_project_type', array('status' => '1'));  
         $data['main_content'] = "main/add_project_type";
         $this->load->view("includes/template", $data);
    }

    public function submit_project_type(){

        $this->form_validation->set_rules("project_type","Project Type","trim|required|min_length[2]|max_length[100]|xss_clean",array("required"=>"%s is required"));
        if($this->form_validation->run()==true){
            $project_type = $this->security->xss_clean($this->input->post("project_type"));
            $data = array(
                "project_type" => $project_type,
            );

            $project_type_id = $this->input->post("project_type_id");
            if(empty($project_type_id)){
                $addProjectType = $this->model->insertData('bdcrm_project_type',$data);
                if($addProjectType){
                    $this->session->set_flashdata("success","Successfullly Project Type Added");
                }
            }else{
                $updateProjectType = $this->model->updateData("bdcrm_project_type", $data, array('id' => $project_type_id));
                if($updateProjectType){
                    $this->session->set_flashdata("success","Project Type Successfullly Updated.");
                }

            }
            
        }
        else
        {
            $data = array(
                'error' => validation_errors()
            );
            $this->session->set_flashdata("error",$data['error']);
        }
         redirect(base_url("master/add_project_type"));

    }

    public function DeleteProjectType($id=0){
        if($id!='' && $id!=0){
         if(!empty($id)){
            $DeleteProjectType = $this->model->updateData("bdcrm_project_type", array('status'=>0),
            array('id' => $id));
            if($DeleteProjectType){
               $this->session->set_flashdata("success","Project Type has been successfullly deleted.");
            }
         }
        }
       redirect(base_url("master/add_project_type"));
    }



    

    public function add_currency($id=0){

        if($id!='' AND $id!=0){
            $data['getFormCurrency'] = $this->model->getData('bdcrm_currency', array('status' => '1','id'=>$id))[0];  
         }
         $data['getAllCurrency'] = $this->model->getData('bdcrm_currency', array('status' => '1'));  
         $data['main_content'] = "main/add_currency";
         $this->load->view("includes/template", $data);
    }



    public function submit_currency(){

        $this->form_validation->set_rules("currency_name","Currency Name","trim|required|min_length[2]|max_length[100]|xss_clean",array("required"=>"%s is required"));
        $this->form_validation->set_rules("currency_symbol","Currency Symbol","trim|required|min_length[1]|max_length[10]|xss_clean",array("required"=>"%s is required"));

        if($this->form_validation->run()==true){
            $currency_name = $this->security->xss_clean($this->input->post("currency_name"));
            $currency_symbol = $this->security->xss_clean($this->input->post("currency_symbol"));
            $data = array(
                "currency_name" => $currency_name,
                "currency_symbol" => $currency_symbol,
            );

            $currency_id = $this->input->post("currency_id");
            if(empty($currency_id)){
                $addCurrency = $this->model->insertData('bdcrm_currency',$data);
                if($addCurrency){
                    $this->session->set_flashdata("success","Successfullly Currency Added..!");
                }
            }else{
                $updateCurrency = $this->model->updateData("bdcrm_currency", $data, array('id' => $currency_id));
                if($updateCurrency){
                    $this->session->set_flashdata("success","Currency Successfullly Updated.");
                }

            }
            
        }
        else
        {
            $data = array(
                'error' => validation_errors()
            );
            $this->session->set_flashdata("error",$data['error']);
        }
         redirect(base_url("master/add_currency"));

    }

    public function DeleteCurrency($id){
         if(!empty($id)){
            $DeleteCurrency = $this->model->updateData("bdcrm_currency", array('status'=>0),
            array('id' => $id));
            if($DeleteCurrency){
               $this->session->set_flashdata("success","Currency has been successfullly deleted.");
            }
         }
        redirect(base_url("master/add_currency"));


    }


    public function add_name_prefix($id=0){
         if($id!='' AND $id!=0){
            $data['getFormPrefix'] = $this->model->getData('bdcrm_name_prefix', array('status' => '1','id'=>$id))[0];  
         }
         $data['getAllPrefix'] = $this->model->getData('bdcrm_name_prefix', array('status' => '1'));  
         $data['main_content'] = "main/add_name_prefix";
         $this->load->view("includes/template", $data);
    }


     public function submit_prefix(){

        $this->form_validation->set_rules("prefix_name","Prefix ","trim|required|min_length[2]|max_length[100]|xss_clean",array("required"=>"%s is required"));
        if($this->form_validation->run()==true){
            $prefix_name = $this->security->xss_clean($this->input->post("prefix_name"));
            $data = array(
                "prefix" => $prefix_name,
            );
            $prefix_id = $this->input->post("prefix_id");
            if(empty($prefix_id)){
                $addPrefix = $this->model->insertData('bdcrm_name_prefix',$data);
                if($addPrefix){
                    $this->session->set_flashdata("success","Successfullly Prefix Added.");
                }
            }else{
                $updatePrefix = $this->model->updateData("bdcrm_name_prefix", $data, array('id' => $prefix_id));
                if($updatePrefix){
                    $this->session->set_flashdata("success","Prefix Successfullly Updated.");
                }

            }
            
        }
        else
        {
            $data = array(
                'error' => validation_errors()
            );
            $this->session->set_flashdata("error",$data['error']);
        }
         redirect(base_url("master/add_name_prefix"));

    }



    public function DeletePrefix($id){
        if(!empty($id)){
            $DeletePrefix = $this->model->updateData("bdcrm_name_prefix", array('status'=>0),
            array('id' => $id));
            if($DeletePrefix){
               $this->session->set_flashdata("success","Prefix has been successfullly deleted.");
            }
         }
        redirect(base_url("master/add_name_prefix"));
    }


   

    public function setProjectHeaders($id){
      $data['getAllHeders'] = $this->model->getData('bdcrm_feilds', array('status' => '1'));
      $data['main_content'] = "main/set_project_headers";
      $this->load->view("includes/template", $data);

    }

    public function submitFeildsAccess(){
        $created_by = $this->session->userdata('id');
        if(!empty($this->input->post())){
        $feildData = $this->input->post('feild_access');
        $task_type = $this->input->post('task_type_id');
        $task_name = $this->input->post('task_name');
        if(!empty($feildData) ){
             $deleteXRecord = $this->model->deleteData("bdcrm_default_feilds_access",array('task_type_id' =>$task_type));
            foreach ($feildData as $key => $value) {
                $data = array('feild_id'=>$key,'task_type_id'=>$task_type,'access'=>1,'created_by'=>$created_by);
               $setFeildsAccess  = $this->model->insertData('bdcrm_default_feilds_access',$data);
            }
          $this->session->set_flashdata("success","Successfully Feilds Assigned");
        }else{
            $this->session->set_flashdata("error","Something went Wrong");
        }

         $redirection = "master/setProjectHeaders/".$task_type.'/'.$task_name;
         redirect(base_url($redirection));

       }
    }


    // Started By Raj Namdev

       public function add_staff_web_disposition($id=0){

         if($id!='' AND $id!=0){
            $data['getFormStaffWebDispo'] = $this->model->getData('bdcrm_staff_web_disposition', array('status' => '1','id'=>$id))[0];  
         }
         $data['getStaffWebDispo'] = $this->model->getData('bdcrm_staff_web_disposition', array('status' => '1'));  
         $data['main_content'] = "main/add_staff_web_disposition";
         $this->load->view("includes/template", $data);
    }

    public function submit_staff_web_dispositions(){
        $this->form_validation->set_rules("staff_web_dispostions_name","Staff Web Dispostions","trim|required|min_length[2]|max_length[100]|xss_clean",array("required"=>"%s is required"));
        if($this->form_validation->run()==true){
            $staff_web_disposition_name = $this->security->xss_clean($this->input->post("staff_web_dispostions_name"));
            $data = array(
                "dispositions" => $staff_web_disposition_name,
            );

            $wid = $this->input->post("w_id");
            if(empty($wid)){
                $addWebDisposition = $this->model->insertData('bdcrm_staff_web_disposition',$data);
                if($addWebDisposition){
                    $this->session->set_flashdata("success","Staff Web Disposition Successfullly Added");
                }
            }else{
                $updateWebDis = $this->model->updateData("bdcrm_staff_web_disposition", $data, array('id' => $wid));
                if($updateWebDis){
                    $this->session->set_flashdata("success","Staff Web Disposition Successfullly Updated.");
                }

            }
            
        }
        else
        {
            $data = array(
                'error' => validation_errors()
            );
            $this->session->set_flashdata("error",$data['error']);
        }
         redirect(base_url("master/add_staff_web_disposition"));

    }

    public function DeleteStaffWebDisposition($id=0){
        if($id!='' && $id!=0){
         if(!empty($id)){
            $deleteStaffWebDispostion = $this->model->updateData("bdcrm_staff_web_disposition", array('status'=>0),
            array('id' => $id));
            if($deleteStaffWebDispostion){
               $this->session->set_flashdata("success","Staff Web disposition has been successfullly deleted.");
            }
         }
        }
       redirect(base_url("master/add_staff_web_disposition"));
    }





    public function add_staff_voice_dispositions($id=0){

         if($id!='' AND $id!=0){
            $data['getFormStaffVoiceDispo'] = $this->model->getData('bdcrm_staff_voice_dispositions', array('status' => '1','id'=>$id))[0];  
         }
         $data['getStaffVoiceDispo'] = $this->model->getData('bdcrm_staff_voice_dispositions', array('status' => '1'));  
         $data['main_content'] = "main/add_staff_voice_disposition";
         $this->load->view("includes/template", $data);
    }

    public function submit_staff_voice_dispositions(){
        $this->form_validation->set_rules("staff_voice_dispostions_name","Staff Voice Dispostions","trim|required|min_length[2]|max_length[100]|xss_clean",array("required"=>"%s is required"));
        if($this->form_validation->run()==true){
            $staff_voice_disposition_name = $this->security->xss_clean($this->input->post("staff_voice_dispostions_name"));
            $data = array(
                "voice_dispositions" => $staff_voice_disposition_name,
            );

            $wid = $this->input->post("w_id");
            if(empty($wid)){
                $addWebDisposition = $this->model->insertData('bdcrm_staff_voice_dispositions',$data);
                if($addWebDisposition){
                    $this->session->set_flashdata("success","Staff Voice Disposition Successfullly Added");
                }
            }else{
                $updateWebDis = $this->model->updateData("bdcrm_staff_voice_dispositions", $data, array('id' => $wid));
                if($updateWebDis){
                    $this->session->set_flashdata("success","Staff Voice Disposition Successfullly Updated.");
                }

            }
            
        }
        else
        {
            $data = array(
                'error' => validation_errors()
            );
            $this->session->set_flashdata("error",$data['error']);
        }
         redirect(base_url("master/add_staff_voice_dispositions"));

    }

    public function DeleteStaffVoiceDisposition($id=0){
        if($id!='' && $id!=0){
         if(!empty($id)){
            $deleteStaffWebDispostion = $this->model->updateData("bdcrm_staff_voice_dispositions", array('status'=>0),
            array('id' => $id));
            if($deleteStaffWebDispostion){
               $this->session->set_flashdata("success","Staff Web disposition has been successfullly deleted.");
            }
         }
        }
       redirect(base_url("master/add_staff_voice_dispositions"));
    }

 public function submit_project_types(){

        $this->form_validation->set_rules("project_type","Project Type","trim|required|min_length[2]|max_length[100]|xss_clean",array("required"=>"%s is required"));
        if($this->form_validation->run()==true){
            $project_type = $this->security->xss_clean($this->input->post("project_type"));
            $activity_type = $this->security->xss_clean($this->input->post("activity_type"));
            $data = array(
                "project_type" => $project_type,
                "activity_type" => $activity_type,
            );

            $project_type_id = $this->input->post("project_type_id");
            if(empty($project_type_id)){
                $addProjectType = $this->model->insertData('bdcrm_project_types',$data);
                if($addProjectType){
                    $this->session->set_flashdata("success","Successfullly Project Type Added");
                }
            }else{
                $updateProjectType = $this->model->updateData("bdcrm_project_types", $data, array('id' => $project_type_id));
                if($updateProjectType){
                    $this->session->set_flashdata("success","Project Type Successfullly Updated.");
                }

            }
            
        }
        else
        {
            $data = array(
                'error' => validation_errors()
            );
            $this->session->set_flashdata("error",$data['error']);
        }
         redirect(base_url("master/add_project_types"));

    }


 public function add_project_types($id=0){

        if($id!='' AND $id!=0){
            $data['getFormProjects'] = $this->model->getData('bdcrm_project_types', array('status' => '1','id'=>$id))[0];  
         }
         $data['getProjectTypes'] = $this->model->getData('bdcrm_project_types', array('status' => '1'));  
         $data['main_content'] = "main/add_project_types";
         $this->load->view("includes/template", $data);
    }

    




}
