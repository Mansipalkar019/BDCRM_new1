<?php

defined('BASEPATH') or exit('No direct script access allowed');
require FCPATH . 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Projects extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Projects_model'));
        if (empty($this->session->userdata('id'))) {
            redirect(base_url("login"));
        }
        date_default_timezone_set('Asia/Kolkata');
    }

    public function index()
    {
        $data['main_content'] = "main/dashboard";
        $this->load->view("includes/template", $data);
    }

    public function project_list()
    {
        $data['projects']=$this->Projects_model->getprojectrecord();
         foreach ($data['projects'] as $key => $value) {
            if(!empty($value['validation_status'])){
                $validation_status = $value['validation_status'];
                $split_status=explode(',',$validation_status);
                $count=0;
                foreach($split_status as $split_status_key => $split_status_val)
                {
                   if($split_status_val == 0)
                   {
                    $count= $count +1;
                   }
                }
                $data['projects'][$key]['validations']= $count; 
            }
        }
        $data['main_content'] = "projects/project_list";
        $this->load->view("includes/template", $data);
    }
    public function new_projects($id = 0)
    {
        $data['TaskType'] = $this->model->getData('bdcrm_project_type', array('status' => '1'));
        $data['country'] = $this->model->getData('bdcrm_countries', array('status' => '1'));
        $data['ProjType'] = $this->model->getData('bdcrm_project_types', array('status' => '1'));
        $data['main_content'] = "projects/add_new_project";
        $data['getAllCountry'] = $this->model->getData('bdcrm_countries', array('status' => '1'));
        $this->load->view("includes/template", $data);
    }
    public function spreadhseet_format_download()
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="hello_world.xlsx"');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'S.No');
        $sheet->setCellValue('B1', 'Product Name');
        $sheet->setCellValue('C1', 'Quantity');
        $sheet->setCellValue('D1', 'Price');

        $writer = new Xlsx($spreadsheet);
        $writer->save("php://output");
    }
   
     public function upload_project(){
        $this->form_validation->set_rules("project_name", "Project Name", "trim|min_length[5]|max_length[100]|xss_clean", array("required" => "%s is required"));
        $this->form_validation->set_rules("project_type", "Project Type", "trim|xss_clean", array("required" => "%s is required"));
        $this->form_validation->set_rules("task_type", "Task Type", "trim|xss_clean", array("required" => "%s is required"));
        $this->form_validation->set_rules("project_breif", "Project Breif", "trim|min_length[2]|xss_clean", array("required" => "%s is required"));
        if ($this->form_validation->run() == true) {



            // $this->Projects_model->DumpingTable();
            if (!empty($_FILES['uploaded_file']['name'])) {

                $config['upload_path'] = './uploads/projects/';
                $config['allowed_types'] = 'csv';
                $config['file_ext_tolower'] = TRUE;
                $config['max_size'] = '10000';
                $config['max_filename_increment'] = 11111;
                $config['remove_spaces'] = TRUE;
                $this->load->library('upload');
                $this->upload->initialize($config);
                $upload_file = $_FILES['uploaded_file']['name'];
                $filename = time() . $upload_file;
                $filepath = 'uploads/projects/' . $filename;
                $filepath1 = trim(FCPATH . $filepath);
                $extension = pathinfo($upload_file, PATHINFO_EXTENSION);
                if ($extension == 'csv') {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } else if ($extension == 'xls') {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                } else {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }
                $spreadsheet = $reader->load($_FILES['uploaded_file']['tmp_name']);
               
                //mansi
                $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
                $writer->save($filepath1);
                //mansi
                $file_data = $spreadsheet->getActiveSheet()->toArray();
                $project_name = $this->security->xss_clean($this->input->post("project_name"));
                $project_type = $this->security->xss_clean($this->input->post("project_type"));
                $task_type = $this->security->xss_clean($this->input->post("task_type"));
                $project_breif = $this->security->xss_clean($this->input->post("project_breif"));
                $created_by = $this->session->userdata('id');
                $valid = 1;
                
                $error = [];
              
                for ($i = 1; $i < count($file_data); $i++) {
                    $lower = trim(strtolower($file_data[$i][16]));
                    $check_country = $this->model->selectWhereData('bdcrm_countries', array('name' => $lower), array('name'));
                    $db_country_name = (!empty($check_country)) ? $check_country['name'] : '';
                    $check = strcmp(strtolower($db_country_name), $lower);
                    if ($check < '0') {
                        $valid = 0;
                        $line_number = $i + 1;
                        $comment = 'Invalid country on line' . ' ' . $line_number;
                        $data = array('error' => $comment, 'class' => 'danger');
                        $error[] = $data;
                    }
                }
                $data['error'] = $error;
                $new=[];
                $this->session->set_flashdata('error', $data);
               
               if($valid > 0) {
                for ($i = 1; $i < count($file_data); $i++) {
                    $fInfo = (!empty($file_data[$i][15])) ? $this->getCountryInfoByName($file_data[$i][15]) : '' ;
                    $suffix=$this->getSuffixInfoByName($file_data[$i][0]);
                    $suffix_id  = (!empty($suffix)) ? $suffix['id'] : ''; 
                    $file_datas[$i]['suffix'] = $suffix_id;
                    $file_datas[$i]['first_name'] =  $file_data[$i][0];
                    $file_datas[$i]['first_name'] =  $file_data[$i][1];
                    $file_datas[$i]['last_name'] = $file_data[$i][2];
                    $file_datas[$i]['provided_job_title'] = $file_data[$i][3];
                    $file_datas[$i]['updated_job_title'] = $file_data[$i][4];
                    $file_datas[$i]['staff_linkedin_con'] = $file_data[$i][5];
                    $file_datas[$i]['staff_url'] = $file_data[$i][6];
                    $file_datas[$i]['received_company_name'] = $file_data[$i][7];
                    $file_datas[$i]['company_name'] = $file_data[$i][8];
                    $file_datas[$i]['address1'] = $file_data[$i][9];
                    $file_datas[$i]['address2'] = $file_data[$i][10];
                    $file_datas[$i]['address3'] = $file_data[$i][11];
                    $file_datas[$i]['city'] = $file_data[$i][12];
                    $file_datas[$i]['state_county'] = $file_data[$i][13];
                    $file_datas[$i]['postal_code'] = $file_data[$i][14];
                    $file_datas[$i]['provided_country'] = $c_id = (!empty($fInfo)) ? $fInfo['id'] : '';
                    $file_datas[$i]['country_code'] = $phone_code = (!empty($fInfo)) ? $fInfo['phonecode'] : '';
                    $file_datas[$i]['country'] = $c_id = (!empty($fInfo)) ? $fInfo['id'] : '';
                    $file_datas[$i]['region'] = $c_id = (!empty($fInfo)) ? $fInfo['region'] : '';
                    $file_datas[$i]['provided_staff_email'] = $file_data[$i][18];
                    $file_datas[$i]['staff_email'] = $file_data[$i][19];
                    $file_datas[$i]['assumed_email'] = $file_data[$i][20];
                    $file_datas[$i]['staff_email_harvesting'] = $file_data[$i][21];
                    $file_datas[$i]['provided_direct_tel'] = $file_data[$i][22];
                    $file_datas[$i]['staff_direct_tel'] = $file_data[$i][23];
                    $file_datas[$i]['provided_comp_tel_number'] = $file_data[$i][24];
                    $file_datas[$i]['tel_number'] = $file_data[$i][25];
                    $file_datas[$i]['alternate_number'] = $file_data[$i][26];
                    $file_datas[$i]['extention'] = $file_data[$i][27];
                    $file_datas[$i]['staff_mobile'] = $file_data[$i][28];
                    $file_datas[$i]['website_url'] = $file_data[$i][29];
                    $file_datas[$i]['address_url'] = $file_data[$i][30];
                    $file_datas[$i]['remarks'] = $file_data[$i][31];
                    $file_datas[$i]['industry'] = $file_data[$i][32];
                    $file_datas[$i]['genaral_note'] = $file_data[$i][33];
                    $file_datas[$i]['ca1'] = $file_data[$i][34];
                    $file_datas[$i]['ca2'] = $file_data[$i][35];
                    $file_datas[$i]['ca3'] = $file_data[$i][36];
                    $file_datas[$i]['ca4'] = $file_data[$i][37];
                    $file_datas[$i]['ca5'] = $file_data[$i][38];
                    $file_datas[$i]['sa1'] = $file_data[$i][39];
                    $file_datas[$i]['sa2'] = $file_data[$i][40];
                    $file_datas[$i]['sa3'] = $file_data[$i][41];
                    $file_datas[$i]['sa4'] = $file_data[$i][42];
                    $file_datas[$i]['sa5'] = $file_data[$i][43];
                    $new[] = $file_datas[$i];
                   
                }
               
                    $projects_info = array('project_name' => $project_name, 'project_type' => $project_type, 'task_type' => $task_type, 'project_breif' => $project_breif, 'created_by' => $created_by, 'created_at' => date('Y-m-d H:i:s'), 'file_path' => $filepath, 'file_name' => $filename);
                    $addProjectInfo  = $this->model->insertData('bdcrm_master_projects', $projects_info);
                    if($addProjectInfo){
                      $referance = "ZDBCRM_".$addProjectInfo."_".date('YmdHi');
                      $UpdateInfo = $this->model->updateData("bdcrm_master_projects", array('referance'=>$referance), array('id' => $addProjectInfo));
                    }
                    if(!empty($_POST['feild_access']))
                    {
                        $field_accesses=$_POST['feild_access'];
                    }else{
                        $field_accesses= 1;
                    }
                    if ($field_accesses != 1) {
                        foreach ($field_accesses as $field_access => $filed_access_key) {
                            $projects_info = array(
                                'field_id' => $filed_access_key,
                                'project_id' => $addProjectInfo,
                                'created_on' => date('Y-m-d H:i:s'),

                            );
                            $addProjectinputfields = $this->model->insertData('bdcrm_master_projects_fields', $projects_info);
                        }
                            if($addProjectinputfields){
                                  $this->Projects_model->DumpingTable($referance);

                                  foreach ($new as $key => $val) {
                                    $val['project_id'] = $addProjectInfo;
                                    // $check_user = $this->model->selectWhereData('bdcrm_uploaded_feildss', array('first_name' => $val['first_name'],'provided_staff_email'=>$val['provided_staff_email']));
                                    // if(!empty($check_user))
                                    // {
                                    //     $errors[0]['error'] = "Staff Name already exist";
                                    //     $errors[0]['class']="Danger";
                                    //     $data['error'] = $errors;
                                    //     $this->session->set_flashdata("error", $data);
                                    // }else{
                                        $mid = $this->model->insertData('bdcrm_uploaded_feildss', $val);
                                        $val['reference_id'] = $mid;
                                        $this->model->insertData($referance, $val);
                                    //}
                                   
                                }
                                $this->session->set_flashdata("success", "Records Uploaded Successfully.");  
                                redirect(base_url("projects/project_list"), $data);
                            }
                        
                    } else {
                        $errors[0]['error'] = "Didn't Set Feilds Access for the Uploaded Project, Please Reupload & Set the feilds Access.";
                        $errors[0]['class']="Danger";
                        $data['error'] = $errors;
                        $this->session->set_flashdata("error", $data);
                       
                    }
                }
            }
           
            redirect(base_url("projects/new_projects"), $data);
        } else {
            $data = array(
                'error' => validation_errors()
            );
            // echo "<pre>";
            // print_r($data);die();
            $this->session->set_flashdata("error", $data['error']);
            redirect(base_url("projects/new_projects"));
        }
    }

    public function DeleteProjects($project_id){

        $deactivateProjects = $this->model->updateData("bdcrm_master_projects", array('status'=>0), array('id' => $project_id));
        if($deactivateProjects){

            $this->session->set_flashdata("success", "Project Successfully Deleted.");
            redirect(base_url("projects/project_list"));
        }else{
             $this->session->set_flashdata("error", "Something Went Wrong.");
             redirect(base_url("projects/project_list"));
        }
    }
   
    public function getCountryInfoByName($country){
            $country_name = strtolower($country);
            $sql = "SELECT id,phonecode,region FROM `bdcrm_countries` WHERE lower(name) = '$country_name' AND status='1'"; 
            $query = $this->db->query($sql);
            return $row = $query->row_array();
    }

    

    public function getSuffixInfoByName($suffix){
            $suffix = strtolower($suffix);
            $sql = "SELECT id FROM `bdcrm_name_prefix` WHERE lower(prefix) = '$suffix' AND status='1'"; 
            $query = $this->db->query($sql);
            $row = $query->row_array();
            return $row;
    }


    //mansi

    public function gettasktype()
    {
        $tasktypeid = $this->input->post('tasktypeid');
        $tasktypefields = $this->Projects_model->get_task_fields($tasktypeid);
        echo json_encode($tasktypefields);
    }

    public function exceldownload()
    {
        error_reporting(0);

        $fileName = "BDCRM_SAMPLE_FILE" . time() . 'bdcrm.xls';
        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();

        $styleArray = array(
            'font'  => array(
                'color' => array('rgb' => '7820ab'),
                'size' => '9',
                'name'  => 'Verdana'
            )
        );
       
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Salutation');
        $objPHPExcel->getActiveSheet()->getStyle("A1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'First Name');
        $objPHPExcel->getActiveSheet()->getStyle("B1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Last Name');
        $objPHPExcel->getActiveSheet()->getStyle("C1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Provided Job Title');
        $objPHPExcel->getActiveSheet()->getStyle("D1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Job Title');
        $objPHPExcel->getActiveSheet()->getStyle("E1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Linkedin Connection');
        $objPHPExcel->getActiveSheet()->getStyle("F1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Staff Url');
        $objPHPExcel->getActiveSheet()->getStyle("G1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Received Company Name');
        $objPHPExcel->getActiveSheet()->getStyle("H1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Company Name');
        $objPHPExcel->getActiveSheet()->getStyle("I1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Address1');
        $objPHPExcel->getActiveSheet()->getStyle("J1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Address2');
        $objPHPExcel->getActiveSheet()->getStyle("K1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Address3');
        $objPHPExcel->getActiveSheet()->getStyle("L1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'City');
        $objPHPExcel->getActiveSheet()->getStyle("M1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'State');
        $objPHPExcel->getActiveSheet()->getStyle("N1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Postalcode');
        $objPHPExcel->getActiveSheet()->getStyle("O1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Provided Country');
        $objPHPExcel->getActiveSheet()->getStyle("P1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Country');
        $objPHPExcel->getActiveSheet()->getStyle("Q1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Region');
        $objPHPExcel->getActiveSheet()->getStyle("R1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Provided Email');
        $objPHPExcel->getActiveSheet()->getStyle("S1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Email');
        $objPHPExcel->getActiveSheet()->getStyle("T1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Assumed Email');
        $objPHPExcel->getActiveSheet()->getStyle("U1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Email Harvesting');
        $objPHPExcel->getActiveSheet()->getStyle("V1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Provided Direct Tel');
        $objPHPExcel->getActiveSheet()->getStyle("W1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('X1', 'Direct Tel');
        $objPHPExcel->getActiveSheet()->getStyle("X1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'Provided Company Tel');
        $objPHPExcel->getActiveSheet()->getStyle("Y1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('Z1', 'Company Tel');
        $objPHPExcel->getActiveSheet()->getStyle("Z1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('AA1', 'Alternate Company Tel');
        $objPHPExcel->getActiveSheet()->getStyle("AA1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('AB1', 'Extension');
        $objPHPExcel->getActiveSheet()->getStyle("AB1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('AC1', 'Mobile');
        $objPHPExcel->getActiveSheet()->getStyle("AC1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('AD1', 'Website');
        $objPHPExcel->getActiveSheet()->getStyle("AD1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('AE1', 'Address');
        $objPHPExcel->getActiveSheet()->getStyle("AE1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('AF1', 'Remarks');
        $objPHPExcel->getActiveSheet()->getStyle("AF1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('AG1', 'Industry');
        $objPHPExcel->getActiveSheet()->getStyle("AG1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('AH1', 'General Notes');
        $objPHPExcel->getActiveSheet()->getStyle("AH1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('AI1', 'CA1');
        $objPHPExcel->getActiveSheet()->getStyle("AI1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('AJ1', 'CA2');
        $objPHPExcel->getActiveSheet()->getStyle("AJ1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('AK1', 'CA3');
        $objPHPExcel->getActiveSheet()->getStyle("AK1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('AL1', 'CA4');
        $objPHPExcel->getActiveSheet()->getStyle("AL1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('AM1', 'CA5');
        $objPHPExcel->getActiveSheet()->getStyle("AM1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('AN1', 'SA1');
        $objPHPExcel->getActiveSheet()->getStyle("AN1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('AO1', 'SA2');
        $objPHPExcel->getActiveSheet()->getStyle("AO1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('AP1', 'SA3');
        $objPHPExcel->getActiveSheet()->getStyle("AP1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('AQ1', 'SA4');
        $objPHPExcel->getActiveSheet()->getStyle("AQ1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->SetCellValue('AR1', 'SA5');
        $objPHPExcel->getActiveSheet()->getStyle("AR1")->applyFromArray($styleArray);
        // $objPHPExcel->getActiveSheet()->SetCellValue('AS1', 'Project Id');
        // $objPHPExcel->getActiveSheet()->getStyle("AS1")->applyFromArray($styleArray);
        $filename = FCPATH . "uploads/projects/" . $fileName;
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="01simple.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save(trim($filename));

        $data = "uploads/projects/" . $fileName;
        echo json_encode($data);
    }
    public function my_projects($pid,$rid,$cmp_name='')
    {
        $project_id=base64_decode($pid);
        $rowid=base64_decode($rid); 
        $cmp_name=base64_decode($cmp_name);
        $data['allInfo'] =  $this->Projects_model->getProjectInfoByStaffId($project_id,$rowid);
        $data['webDispo'] = $this->model->getData('bdcrm_web_disposition', array('status' => '1'));
        $data['compDispo'] = $this->model->getData('bdcrm_company_disposition', array('status' => '1'));
        $data['VoiceDispo'] = $this->model->getData('bdcrm_caller_disposition', array('status' => '1'));
        $data['StaffWebDispo'] = $this->model->getData('bdcrm_staff_web_disposition', array('status' => '1'));
        $data['StaffVoiceDispo'] = $this->model->getData('bdcrm_staff_voice_dispositions', array('status' => '1'));
        $data['country'] = $this->model->getData('bdcrm_countries', array('status' => '1'));
        $data['currency'] = $this->model->getData('bdcrm_currency', array('status' => '1'));
        //$data['webDispos'] = $this->model->getData('bdcrm_staff_web_disposition', array('status' => '1'));
        $data['webDispos']=$this->Projects_model->getstaffwebdisbytasktype($data['allInfo'][0]['task_type'],$data['allInfo'][0]['disposition_status'],$data['allInfo'][0]['main_staff_disposition'],$data['allInfo'][0]['first_name'],$data['allInfo'][0]['last_name'],$data['allInfo'][0]['web_staff_disposition']);
        //$data['VoiceDispos'] = $this->model->getData('bdcrm_staff_voice_dispositions', array('status' => '1'));
        $data['VoiceDispos'] = $this->Projects_model->getstaffvoicedisbytasktype($data['allInfo'][0]['id'],$data['allInfo'][0]['task_type'],$data['allInfo'][0]['disposition_status'],$data['allInfo'][0]['main_voice_staff_disposition'],$data['allInfo'][0]['caller_has_replaced']);
        $data['industry'] = $this->model->getData('bdcrm_industries', array('status' => '1'));
        $data['name_prefix'] = $this->model->getData('bdcrm_name_prefix', array('status' => '1'));
        $data['project_info']=$this->Projects_model->get_project_input_fields($project_id);
        $data['staff_list']=$this->Projects_model->getStaffInfoDetails($project_id,$data['allInfo'][0]['received_company_name']);
        $data['company_list']=$this->Projects_model->getCompanyInfoDetails($project_id,$cmp_name);
        $data['allstaffinfo'] = $this->Projects_model->getAllStaffInfoDetails($project_id,$cmp_name);
        $data['company_remark'] = $this->model->getData('bdcrm_company_remark', array('status' => '1'));
        $data['researcher_remark'] = $this->model->getData('bdcrm_researcher_remark', array('status' => '1'));
        $data['caller_remark'] = $this->model->getData('bdcrm_caller_remark', array('status' => '1'));
        
        $data['minmax'] =  $this->Projects_model->getPreLastInfo($project_id,$rowid,$cmp_name);          
        $data['minmax']['current'] = $this->getIndexInfo($data['allstaffinfo'],$rowid)['current'];
        $data['minmax']['prev'] = $this->getIndexInfo($data['allstaffinfo'],$rowid)['prev'];
        $data['minmax']['next'] = $this->getIndexInfo($data['allstaffinfo'],$rowid)['next'];
        $data['userinfo']=$this->session->userdata('designation_id');
        $data['ButtonInfo'] =  $this->Projects_model->getCurrentRecordStatus($rowid,strtolower($data['allInfo'][0]['task_type'])); 
        //echo "<pre>";print_r($data['allInfo']);die();
        $this->load->view("projects/add_info", $data);

    }
    public function getIndexInfo($staff,$rowid){
        foreach($staff as $k =>$val){
            if($val['id']==$rowid){                
                    $key = $k+1;                
            }
        }
        $next = (!empty($staff[$key]['id'])) ? $staff[$key]['id'] : $rowid ;
        $final = $key-2;
        $prev  = (!empty($staff[$final]['id'])) ? $staff[$final]['id'] : $rowid ;
        $data = array('current'=>$key,'prev'=>$prev,'next'=>$next);
       return $data;
    }

    
    public function display_all_company_staff(){
      
        $input_field=$this->input->post('input_field');
        $operator=$this->input->post('operator');
        $assignment=$this->input->post('assignment');
        $input_types=$this->input->post('input_types');
        $company_count=$this->input->post('company_count');
        $project_id=$this->input->post('id');
        $table_name=$this->input->post('table_name');


        foreach($input_field as $input_field_key => $input_field_row){
             $input_field=$input_field_row;
             $operators=$operator[$input_field_key];
             $assignments=$assignment[$input_field_key];
             $inputtypes=$input_types[$input_field_key];
             $table_names=$table_name[$input_field_key];
             $insert_record[] = array(
                 'input_field' =>$input_field_row,
                 'operator'=>$operators,
                 'inputtype'=>$inputtypes,
                 'table_name'=>$table_names,
                 'assignment'=>$assignments,
             );
        }
        $sql="";
        foreach($insert_record as $k =>$val){
             $feild_name = "bdcrm_uploaded_feildss.".$val['input_field']."";
             $operator = $val['operator'];
             $inputtype = "'".$val['inputtype']."'";
             $assignment = $val['assignment'];
             $sql .= $feild_name.' '.$operator.' '.$inputtype.' '.$assignment.' ';
        }
         $new_sql=$sql;
         $id= $this->input->post('id');
         $slot_count= $this->input->post('slot_count');
         $workalloc= $this->input->post('workalloc');
         $ProjectInfo = $this->Projects_model->getProjectInfo($new_sql,$id,$slot_count,$workalloc);


         if(!empty($ProjectInfo)){
             foreach ($ProjectInfo as $ProjectInfo_key => $ProjectInfo_row) {
                     $completed_status_count = $this->model->selectWhereData('bdcrm_uploaded_feildss',array('updated_status'=>'Updated','received_company_name'=>$ProjectInfo_row['received_company_name']),array('count(updated_status) as completed_updated_status'));
                         $total_count[]=$ProjectInfo_row['staff_count'];
                         $ProjectInfo[$ProjectInfo_key]['completed_updated_status']=$completed_status_count['completed_updated_status'];
                         $ProjectInfo[$ProjectInfo_key]['created_date']=date(('d-m-Y h:i A'),strtotime($ProjectInfo_row['created_date']));
             }    
         }

      

         $response['data']=$ProjectInfo;
         $response['total_staff_count'] = array_sum($total_count);
        
         echo json_encode($response);  
    }
    



    public function getcountrycode()
    {
        $country = $this->input->post('country');
        $country_info = $this->model->getData('bdcrm_countries', array('id' => $country,'status' => '1'))[0];
        echo json_encode($country_info);
    }

    public function getcountry()
    {
        if(isset($_POST['search'])){
            $search = strtolower($this->input->post('search'));
          }else{ $search = ''; }
        $country_info = $this->Projects_model->getautocompleteofdata($search,"bdcrm_countries","name");
        if(count($country_info) > 0){
            foreach ($country_info as $row){
              $new_row['label']=stripslashes($row["name"]);
              $new_row['value']=stripslashes($row["name"]);
              $new_row['phonecode']=stripslashes($row["phonecode"]);
              $new_row['region']=stripslashes($row["region"]);
              $new_row['postal_code']=stripslashes($row["postal_code"]);
                  $row_set[] = $new_row; //build an array
                }

                echo json_encode($row_set);
        }
    }

    public function getindustry()
    {
        if(isset($_POST['search'])){
            $search = strtolower($this->input->post('search'));
          }else{ $search = ''; }
        $country_info = $this->Projects_model->getautocompleteofdata($search,"bdcrm_industries","Industries");
        if(count($country_info) > 0){
            foreach ($country_info as $row){
              $new_row['label']=stripslashes($row["Industries"]);
              $new_row['value']=stripslashes($row["Industries"]);
              $row_set[] = $new_row; 
                }
                echo json_encode($row_set);
        }
    }

    public function getcompany_disposition()
    {
        if(isset($_POST['search'])){
            $search = strtolower($this->input->post('search'));
          }else{ $search = ''; }
        $country_info = $this->Projects_model->getautocompleteofdata($search,"bdcrm_company_disposition","company_dispostion");
        if(count($country_info) > 0){
            foreach ($country_info as $row){
              $new_row['label']=stripslashes($row["company_dispostion"]);
              $new_row['value']=stripslashes($row["company_dispostion"]);
              $row_set[] = $new_row; 
                }
                echo json_encode($row_set);
        }
    }

    public function getcompany_web_dispositon()
    {
        if(isset($_POST['search'])){
            $search = strtolower($this->input->post('search'));
          }else{ $search = ''; }
        $country_info = $this->Projects_model->getautocompleteofdata($search,"bdcrm_web_disposition","web_disposition_name");
        if(count($country_info) > 0){
            foreach ($country_info as $row){
              $new_row['label']=stripslashes($row["web_disposition_name"]);
              $new_row['value']=stripslashes($row["web_disposition_name"]);
              $row_set[] = $new_row; 
                }
                echo json_encode($row_set);
        }
    }

    public function getcompany_voice_disposition()
    {
        if(isset($_POST['search'])){
            $search = strtolower($this->input->post('search'));
          }else{ $search = ''; }
        $country_info = $this->Projects_model->getautocompleteofdata($search,"bdcrm_caller_disposition","caller_disposition");
        if(count($country_info) > 0){
            foreach ($country_info as $row){
              $new_row['label']=stripslashes($row["caller_disposition"]);
              $new_row['value']=stripslashes($row["caller_disposition"]);
              $row_set[] = $new_row; 
                }
                echo json_encode($row_set);
        }
    }

    public function getweb_staff_disposition()
    {
        if(isset($_POST['search'])){
            $search = strtolower($this->input->post('search'));
          }else{ $search = ''; }
        $country_info = $this->Projects_model->getautocompleteofdata($search,"bdcrm_staff_web_disposition","dispositions");
        if(count($country_info) > 0){
            foreach ($country_info as $row){
              $new_row['label']=stripslashes($row["dispositions"]);
              $new_row['value']=stripslashes($row["dispositions"]);
              $row_set[] = $new_row; 
                }
                echo json_encode($row_set);
        }
    }

    public function getvoice_staff_disposition()
    {
        if(isset($_POST['search'])){
            $search = strtolower($this->input->post('search'));
          }else{ $search = ''; }
        $country_info = $this->Projects_model->getautocompleteofdata($search,"bdcrm_staff_voice_dispositions","voice_dispositions");
        if(count($country_info) > 0){
            foreach ($country_info as $row){
              $new_row['label']=stripslashes($row["voice_dispositions"]);
              $new_row['value']=stripslashes($row["voice_dispositions"]);
              $row_set[] = $new_row; 
                }
                echo json_encode($row_set);
        }
    }


    public function update_company_details()
    {
        // echo "<pre>";
        // print_r($_POST);die;
        $project_id=$this->input->post('project_id');
        $staff_id=$this->input->post('staff_id');
        $company_name=$this->input->post('company_name');
        $error_count=$this->input->post('error_count');
        $address_1=$this->input->post('address_1');
        $address_2=$this->input->post('address_2');
        $address_3=$this->input->post('address_3');
        $city_name=$this->input->post('city_name');
        $postal_code=$this->input->post('postal_code');
        $state_name=$this->input->post('state_name');
        $country=$this->input->post('country');
        $country_id = $this->model->selectWhereData('bdcrm_countries', array('name' => $country), array('id'));
        $region_name=$this->input->post('region_name');
        $address_source_url=$this->input->post('address_source_url');
        $ca1=$this->input->post('ca1');
        $ca2=$this->input->post('ca2');
        $ca3=$this->input->post('ca3');
        $ca4=$this->input->post('ca4');
        $ca5=$this->input->post('ca5');
        $title=$this->input->post('title');
        $company_disposition=$this->input->post('company_disposition');
        $company_web_dispositon=$this->input->post('company_web_dispositon');
        $company_voice_disposition=$this->input->post('company_voice_disposition');
        $company_genaral_notes=$this->input->post('company_genaral_notes');
        //$company_remark=$this->input->post('company_remark');
        $researcher_company_remarks=$this->input->post('researcher_company_remark');
        $researcher_company_remark=implode(',',$researcher_company_remarks);
        $caller_company_remarks=$this->input->post('caller_company_remark');
        $caller_company_remark=implode(',',$caller_company_remarks);
        $researcher_company_note=$this->input->post('researcher_company_note');
        $caller_company_note=$this->input->post('caller_company_note');
        $country_code=$this->input->post('country_code');
        $tel_number=$this->input->post('tel_number');
        $alternate_number=$this->input->post('alternate_number');
        $industry=$this->input->post('industry');
        $industry_id = $this->model->selectWhereData('bdcrm_industries', array('Industries' => $industry), array('id'));
        $revenue=$this->input->post('revenue');
        $revenue_curr=$this->input->post('revenue_cur');
        $no_of_emp=$this->input->post('no_of_emp');
        $first_name=$this->input->post('first_name');
        $last_name=$this->input->post('last_name');
        $provided_job_title=$this->input->post('job_title');
        $staff_job_function=$this->input->post('staff_job_function');
        $staff_email=$this->input->post('staff_email');
        $staff_department=$this->input->post('staff_department');
        $staff_url=$this->input->post('staff_url');
        $assumed_email=$this->input->post('assumed_email');
        $staff_email_harvesting=$this->input->post('staff_email_harvesting');
        $staff_direct_tel=$this->input->post('staff_direct_tel');
        $staff_mobile=$this->input->post('staff_mobile');
        $web_staff_disposition=$this->input->post('web_staff_disposition');
        $voice_staff_disposition=$this->input->post('voice_staff_disposition');
        $staff_linkedin_con=$this->input->post('staff_linkedin_count');
        $staff_note=$this->input->post('staff_note');
        $staff_remark=$this->input->post('staff_remark');
        $research_remarks=$this->input->post('research_remark');
        $research_remark=implode(',',$research_remarks);
        $voice_remarks=$this->input->post('voice_remark');
        $voice_remark=implode(',',$voice_remarks);
        $sa1=$this->input->post('sa1');
        $sa2=$this->input->post('sa2');
        $sa3=$this->input->post('sa3');
        $sa4=$this->input->post('sa4');
        $sa5=$this->input->post('sa5');
        $website_url=$this->input->post('website_url');
         if($error_count > 0)
        {
            $validation_status=0;
        }else{
            $validation_status=1;
        }
        //$check_country = $this->model->selectWhereData('bdcrm_countries', array('id' => $country), array('name'));
        $company_details=array(
            
            'company_name'=>$company_name,
            'address1'=>$address_1,
            'address2'=>$address_2,
            'address3'=>$address_3,
            'city'=>$city_name,
            'postal_code'=>$postal_code,
            'state_county'=>$state_name,
            'country'=>$country_id['id'],
            'country_code'=>$country_code,
            'region'=>$region_name,
            'address_souce_url'=>$address_source_url,
            'no_of_emp'=>$no_of_emp,
            'ca1'=>$ca1,
            'ca2'=>$ca2,
            'ca3'=>$ca3,
            'ca4'=>$ca4,
            'ca5'=>$ca5,
            'company_disposition'=>$company_disposition,
            'web_disposition'=>$company_web_dispositon,
            'voice_staff_disposition'=>$voice_staff_disposition,
            'company_genaral_notes'=>$company_genaral_notes,
            //'remarks'=>$company_remark,
            'researcher_company_remark'=>$researcher_company_remark,
            'caller_company_remark'=>$caller_company_remark,
            'researcher_company_note'=>$researcher_company_note,
            'caller_company_note'=>$caller_company_note,
            'tel_number'=>$tel_number,
            'alternate_number'=>$alternate_number,
            'industry'=>$industry_id['id'],
            'revenue'=>$revenue,
            'revenue_curr'=>$revenue_curr,
            'updated_at'=>date('Y-m-d H:i:s'),
            'updated_by'=>$this->session->userdata('designation_id'),
            'first_name'=>$first_name,
            'last_name'=>$last_name,
            'provided_job_title'=>$provided_job_title,
            'staff_job_function'=>$staff_job_function,
            'staff_email'=>$staff_email,
            'provided_staff_email'=>$staff_email,
            'staff_department'=>$staff_department,
            'staff_url'=>$staff_url,
            'assumed_email'=>$assumed_email,
            'staff_email_harvesting'=>$staff_email_harvesting,
            'voice_disposition'=>$company_voice_disposition,
            'staff_direct_tel'=>$staff_direct_tel,
            'staff_mobile'=>$staff_mobile,
            'web_staff_disposition'=>$web_staff_disposition,
            'staff_linkedin_con'=>$staff_linkedin_con,
            'staff_note'=>$staff_note,
            'staff_remark'=>$staff_remark,
            'research_remark'=>$research_remark,
            'voice_remark'=>$voice_remark,
            'sa1'=>$sa1,
            'sa2'=>$sa2,
            'sa3'=>$sa3,
            'sa4'=>$sa4,
            'sa5'=>$sa5,
            'website_url'=>$website_url,
            'suffix'=>$title,
            'validation_status'=>$validation_status,
        );
        if( $this->model->updateData('bdcrm_uploaded_feildss',$company_details,array('project_id'=>$project_id,'id'=>$staff_id)))
        {
            $response['status']='success';
            $response['error']=array('msg' => "Company Details Updated Successfully !");
        }
        else{
            $response['status']='failure';
            $response['error']=array('msg' => "Company Details Updated  UnSuccessfully !"); 

        }
        
        echo json_encode($response);
    }

  

    public function save_company_allocation_data(){
        //print_r($_POST);die();
        $company_names = $this->input->post('company_name');
        $total_staff_count=$this->input->post('total_staff_count');

        if(!empty($company_names)){
            foreach ($company_names as $key => $value) {
            if($key<$total_staff_count){
               $company_name[$key] =  $value;
            }
        }
        $user_list = $this->input->post('user_list');
        $project_id = $this->input->post('project_id');
        $perUser = count($user_list);
        $company_count = count($company_name);
        $break = round(count($company_name) / $perUser); 
        if(!empty($break) && ($company_count>=$perUser && count($company_name)>=$total_staff_count)){
            $user_list_last_key = array_key_last($user_list);
            $start = 0;
            foreach ($user_list as $user_list_key => $user_list_row) {

                $user_designation = $this->Projects_model->getDesignationById($user_list_row);
                if($user_designation=="Researcher"){
                    $project_status = "researcher_project_status";
                }else{
                    $project_status = "caller_project_status";
                }

                if($user_list_last_key == $user_list_key){
                    if(!empty($company_name)){
                        foreach ($company_name as $company_name_key => $company_name_row) {


                            $company_name_id_info = $this->model->selectWhereData('bdcrm_uploaded_feildss',array('received_company_name' => $company_name_row,'project_id'=>$project_id),array('id','project_id'),false);
                            if(!empty($company_name_id_info[0])){
                                foreach ($company_name_id_info as $company_name_id_info_key => $company_name_id_info_row) {
                                    $check_assigned_task = $this->Projects_model->getallocationdetails($project_id,$company_name_id_info_row['id'],$this->session->userdata('id'));
                                    if(!empty($check_assigned_task))
                                    {   
                                        $update_companywise_allocation=array('project_id'=>$project_id,'reassigned_to'=>$user_list_row,'staff_id'=>$company_name_id_info_row['id'],'assigned_by'=>$this->session->userdata('id'),'assigned_at'=>date('Y-m-d H:i:s'),$project_status=>'0');
                                        foreach($check_assigned_task as $key => $value)
                                        {
                                            $reassignstaff= $this->model->updateData("companywise_allocation",$update_companywise_allocation,array('project_id'=>$value['project_id'],'staff_id'=>$value['staff_id'],'assigned_by'=>$this->session->userdata('id')));

                                            $insert_companywise_allocation_history= $this->model->insertData('bdcrm_allocation_history',array('project_id'=>$project_id,'user_id'=>$user_list_row,'staff_id'=>$company_name_id_info_row['id'],'assigned_by'=>$this->session->userdata('id')));
                                        }
                                       
                                    }
                                    else{
                                        $insert_companywise_allocation = array(
                                            'project_id'=> $project_id,
                                            'staff_id' =>$company_name_id_info_row['id'],
                                            'user_id'=> $user_list_row,
                                            'assigned_by'=> $this->session->userdata('id'),
                                            'assigned_at'=>date('Y-m-d H:i:s'),$project_status=>'0','total_count'=>$total_staff_count,
                                            'reassigned_to'=>$user_list_row
                                        );
                                     
                                        $this->model->insertData('companywise_allocation',$insert_companywise_allocation);

                                        $insert_companywise_allocation_history= $this->model->insertData('bdcrm_allocation_history',array('project_id'=>$project_id,'user_id'=>$user_list_row,'staff_id'=>$company_name_id_info_row['id'],'assigned_by'=>$this->session->userdata('id')));
                                    }
                                  
                                }
                            }
                            
                        }
                       
                    }
                    break;
                } else {
                    for ($i=$start; $i < $break ; $i++) { 
                        $company_name_id_info = $this->model->selectWhereData('bdcrm_uploaded_feildss',array('received_company_name' => $company_name[$i],'project_id'=>$project_id),array('id','project_id'),false);
                        if(!empty($company_name_id_info[0])){
                            foreach ($company_name_id_info as $company_name_id_info_key => $company_name_id_info_row) {
                                 $check_assigned_task = $this->Projects_model->getallocationdetails($project_id,$company_name_id_info_row['id'],$this->session->userdata('id'));
                                if(!empty($check_assigned_task))
                                {   
                                    $update_companywise_allocation=array('project_id'=>$project_id,'reassigned_to'=>$user_list_row,'staff_id'=>$company_name_id_info_row['id'],'assigned_by'=>$this->session->userdata('id'),'assigned_at'=>date('Y-m-d H:i:s'),$project_status=>'0');
                                    foreach($check_assigned_task as $key => $value)
                                    {
                                        $reassignstaff= $this->model->updateData("companywise_allocation",$update_companywise_allocation,array('project_id'=>$value['project_id'],'staff_id'=>$value['staff_id'],'assigned_by'=>$this->session->userdata('id')));

                                        $insert_companywise_allocation_history= $this->model->insertData('bdcrm_allocation_history',array('project_id'=>$project_id,'user_id'=>$user_list_row,'staff_id'=>$company_name_id_info_row['id'],'assigned_by'=>$this->session->userdata('id')));
                                    }
                                   
                                }
                                else{
                                    $insert_companywise_allocation = array(
                                        'project_id'=> $project_id,
                                        'staff_id' =>$company_name_id_info_row['id'],
                                        'user_id'=> $user_list_row,
                                        'assigned_by'=> $this->session->userdata('id'),
                                        'assigned_at'=>date('Y-m-d H:i:s'),$project_status=>'0','total_count'=>$total_staff_count,
                                        'reassigned_to'=>$user_list_row
                                    );
                                 
                                    $this->model->insertData('companywise_allocation',$insert_companywise_allocation);

                                    $insert_companywise_allocation_history= $this->model->insertData('bdcrm_allocation_history',array('project_id'=>$project_id,'user_id'=>$user_list_row,'staff_id'=>$company_name_id_info_row['id'],'assigned_by'=>$this->session->userdata('id')));
                                }
                            }
                           
                        }
                        unset($company_name[$i]);
                    }
                    $start = $start+$break;
                    $break = $break+$break;
                }
            }
            $response['message'] = "Company Allocation Inserted Successfully";
            $response['status'] = "success";
            $msg = "Successfully ".$total_staff_count." Companies Allocated to ".count($user_list)." Users.";
            $this->session->set_flashdata("success", $msg);  
        } else {
            $response['message'] = "Userlist Cannot Be Greater Than Companies";
            $response['status'] = "error";
            $this->session->set_flashdata("error", "Userlist Cannot Be Greater Than Companies");  
        }
    }else{
        $response['message'] = "Company Unvailable for the Allocation";
        $response['status'] = "error";
        $this->session->set_flashdata("error", "Company Unvailable for the Allocation");  
    }

      $redirect_url = "Projects/ProjectInfoNew/".base64_encode($project_id);
      redirect(base_url($redirect_url));

    }

    public function getprojectrecord()
    {
        $data[] = json_encode($_POST);  
        $staffid = $_POST['staffid'];
        $received_company_name = $_POST['received_company_name'];
        if(!empty($_POST['count']))
        {
            $counter=$_POST['count'];
        }else{
            $counter = $_POST['length'];
        }
        $workstatus = '';
        if(!empty($_POST['workalloc']))
        {
           if($_POST['workalloc'] == 'Assigned')
           {
                $workstatus=1;
           }elseif($_POST['workalloc'] == 'Unassigned'){
                $workstatus =2;
           }
           else{
                $workstatus =3;
           }
        }
        $rowno = $_POST['start'];
        $search_text = $_POST['search']['value'];   
        $totalData=$this->Projects_model->get_staff_info($staffid,$received_company_name,$rowno,$counter,$workstatus);
        $count_filtered=$this->Projects_model->get_no_staff_info($staffid,$received_company_name,$rowno,$counter,$workstatus);
        $count_all = $this->Projects_model->get_all_staff_info($staffid,$received_company_name,$rowno,$counter,$workstatus);
        $data_array=array();

        foreach($totalData as $category_details_key => $data_row)
        {
           $input_type = "<input type='hidden' name='staff_info[]' value="."'".$data_row['staff_id']."'>"; 
          $staff_info = '<a class="" href="'.base_url().'Projects/my_projects/'.base64_encode($data_row['project_id']).'/'.base64_encode($data_row['staff_id']).'/'.base64_encode($data_row['received_company_name']).'">'.$data_row['salutation'].'. '. $data_row['first_name'].' '.$data_row['last_name'].'</a>&nbsp;&nbsp;'; 
            $nestedData=array();
                $nestedData[] = ++$category_details_key;
                $nestedData[] = $input_type.$data_row['project_name'];
                $nestedData[] = $staff_info;
                $nestedData[] = $data_row['industry'];
                $nestedData[] = $data_row['provided_staff_email'];
                $nestedData[] = $data_row['received_company_name'];
                $nestedData[] = $data_row['company_disposition'];
                $nestedData[] = $data_row['web_disposition'];
                $nestedData[] = $data_row['website_url'];
                $nestedData[] = $data_row['no_of_emp'];
                $nestedData[] = $data_row['revenue'];
                $nestedData[] = $data_row['provided_job_title'];
                $nestedData[] = $data_row['address1'];
                $nestedData[] = $data_row['country_name'];
                $nestedData[] = $data_row['region'];
                $nestedData[] = $data_row['web_staff_disposition'];
                $nestedData[] = $data_row['voice_staff_disposition'];
                $nestedData[] = "<span class='badge btn btn-primary btn-sm'>".$data_row['assigned_to']."</span>";
                $nestedData[] = "<span class='badge btn btn-warning btn-sm'>".$data_row['assigned_by']."</span>";
                $nestedData[] = date(('d-m-Y h:i A'),strtotime($data_row['created_date']));
                $nestedData[] = date(('d-m-Y h:i A'),strtotime($data_row['assigned_at']));
                $nestedData[] = $data_row['staff_id'];
                $data_array[] = $nestedData;
    
   }
      $output = array(
            "draw" => intval($_POST['draw']),
            "recordsTotal" => intval($count_all),
            "recordsFiltered" => intval($count_filtered),
            "data" => $data_array,
        );

        echo json_encode($output);
    }


    public function isDataExist($data){
        unset($data['assigned_at']);
        unset($data['assigned_by']);
        unset($data['user_id']);
        $data['status'] = 1;
        $datas = $this->model->getData('companywise_allocation', $data);     
       if(!empty($datas)){      
            if(count($datas) > 0){
                echo count($datas); 
                unset($data['status']);
                $deactivateAssignee= $this->model->updateData("companywise_allocation", array('status'=>0), $data);
                 echo $this->db->last_query(); 
            }
        }
        else
        {
            //echo "hii";
        }

        return true;
    }

    function excel_download()
    {
        error_reporting(0);
        $project_id=base64_decode($_GET['id']);
        //echo $project_id;die();
       // load excel library
       $this->load->library('excel');
       $totalData=$this->Projects_model->excel_download($project_id);  
       //echo '<pre>'; print_r($totalData); exit;
       $objPHPExcel = new PHPExcel();
       $objPHPExcel->setActiveSheetIndex(0);
       // set Header
       $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'ID');
       $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Salutation');
       $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'First Name');
       $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Last Name');
       $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Provided Job Title');
       $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Job Title');
       $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Received Company Name');   
       $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Company Name'); 
       $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Company Web Disposition');   
       $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Company Voice Dispositions');     
       $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Address1');   
       $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Address2');   
       $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Address3');     
       $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'City');   
       $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'State');   
       $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Postalcode');   
       $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Provided Country');   
       $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Country');   
       $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Region');   
       $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Company Tel');   
       $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Alternate Company Tel');   
       $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Mobile'); 
       $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Website'); 
       $objPHPExcel->getActiveSheet()->SetCellValue('X1', 'Address'); 
       $objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'Revenue'); 
       $objPHPExcel->getActiveSheet()->SetCellValue('Z1', 'Industry'); 
       $objPHPExcel->getActiveSheet()->SetCellValue('AA1', 'General Notes'); 
       $objPHPExcel->getActiveSheet()->SetCellValue('AB1', 'Caller Web Disposition');  
       $objPHPExcel->getActiveSheet()->SetCellValue('AC1', 'Caller Voice Dispostion');    
       $objPHPExcel->getActiveSheet()->SetCellValue('AD1', 'Staff Note');   
       $objPHPExcel->getActiveSheet()->SetCellValue('AE1', 'Research Remark');   
       $objPHPExcel->getActiveSheet()->SetCellValue('AF1', 'Voice Remark');   
       $objPHPExcel->getActiveSheet()->SetCellValue('AG1', 'Researcher Company Remark');   
       $objPHPExcel->getActiveSheet()->SetCellValue('AH1', 'Researcher Company Note');   
       $objPHPExcel->getActiveSheet()->SetCellValue('AI1', 'Voice Company Remark'); 
       $objPHPExcel->getActiveSheet()->SetCellValue('AJ1', 'Caller Company Note');   
       $objPHPExcel->getActiveSheet()->SetCellValue('AK1', 'Has Replaced');   
       $objPHPExcel->getActiveSheet()->SetCellValue('AL1', 'Caller Has Replaced');   
       $objPHPExcel->getActiveSheet()->SetCellValue('AM1', 'Created Date');   
       $objPHPExcel->getActiveSheet()->SetCellValue('AN1', 'Updated At');   
       $objPHPExcel->getActiveSheet()->SetCellValue('AO1', 'Updated By');   
       $objPHPExcel->getActiveSheet()->SetCellValue('AP1', 'Job Function');   
       $objPHPExcel->getActiveSheet()->SetCellValue('AQ1', 'Staff Department');   
       $objPHPExcel->getActiveSheet()->SetCellValue('AR1', 'Linkedin Connection');     
       $objPHPExcel->getActiveSheet()->SetCellValue('AS1', 'Staff Url');   
       $objPHPExcel->getActiveSheet()->SetCellValue('AT1', 'Provided Email');     
       $objPHPExcel->getActiveSheet()->SetCellValue('AU1', 'Assumed Email');   
       $objPHPExcel->getActiveSheet()->SetCellValue('AV1', 'Email Harvesting');   
       $objPHPExcel->getActiveSheet()->SetCellValue('AW1', 'Direct Tel');   
       $objPHPExcel->getActiveSheet()->SetCellValue('AX1', 'No Of Emp'); 
      
       $rowCount = 2;
        $i=1;
       foreach($totalData as $totalData_key => $totalData_row)
       {
        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $i);
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $totalData_row['prefix']);
        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $totalData_row['first_name']);
        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $totalData_row['last_name']);
        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $totalData_row['provided_job_title']);
        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $totalData_row['provided_job_title']);
        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $totalData_row['received_company_name']);
        $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $totalData_row['company_name']);
        $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $totalData_row['company_web_disposition']);  
        $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $totalData_row['company_voice_disposition']);    
        $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $totalData_row['address1']); 
        $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $totalData_row['address2']);
        $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $totalData_row['address3']);
        $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $totalData_row['city']);
        $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $totalData_row['state_county']);
        $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $totalData_row['postal_code']);
        $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $totalData_row['provided_country']);
        $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $totalData_row['updated_country']);
        $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $totalData_row['region']);
        $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $totalData_row['tel_number']);
        $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $totalData_row['alternate_number']);
        $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $totalData_row['staff_mobile']);  
        $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $totalData_row['website_url']);  
        $objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, $totalData_row['address_url']);  
        $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, $totalData_row['revenue']); 
        $objPHPExcel->getActiveSheet()->SetCellValue('Z' . $rowCount, $totalData_row['industry_type']);  
        $objPHPExcel->getActiveSheet()->SetCellValue('AA' . $rowCount, $totalData_row['genaral_note']);      
        $objPHPExcel->getActiveSheet()->SetCellValue('AB' . $rowCount, $totalData_row['web_staff_disposition']);  
        $objPHPExcel->getActiveSheet()->SetCellValue('AC' . $rowCount, $totalData_row['caller_staff_disposition']);    
        $objPHPExcel->getActiveSheet()->SetCellValue('AD' . $rowCount, $totalData_row['staff_note']);  
        $objPHPExcel->getActiveSheet()->SetCellValue('AE' . $rowCount, $totalData_row['research_remark']);    
        $objPHPExcel->getActiveSheet()->SetCellValue('AF' . $rowCount, $totalData_row['voice_remark']);
        $objPHPExcel->getActiveSheet()->SetCellValue('AG' . $rowCount, $totalData_row['researcher_company_remark']);
        $objPHPExcel->getActiveSheet()->SetCellValue('AH' . $rowCount, $totalData_row['researcher_company_note']);
        $objPHPExcel->getActiveSheet()->SetCellValue('AI' . $rowCount, $totalData_row['caller_company_remark']);
        $objPHPExcel->getActiveSheet()->SetCellValue('AJ' . $rowCount, $totalData_row['caller_company_note']);
        $objPHPExcel->getActiveSheet()->SetCellValue('AK' . $rowCount, $totalData_row['has_replaced']);
        $objPHPExcel->getActiveSheet()->SetCellValue('AL' . $rowCount, $totalData_row['caller_has_replaced']);
        $objPHPExcel->getActiveSheet()->SetCellValue('AM' . $rowCount, $totalData_row['created_date']);
        $objPHPExcel->getActiveSheet()->SetCellValue('AN' . $rowCount, $totalData_row['updated_at']);
        $objPHPExcel->getActiveSheet()->SetCellValue('AO' . $rowCount, $totalData_row['updated_by']);
        $objPHPExcel->getActiveSheet()->SetCellValue('AP' . $rowCount, $totalData_row['job_function']);
        $objPHPExcel->getActiveSheet()->SetCellValue('AQ' . $rowCount, $totalData_row['staff_department']);
        $objPHPExcel->getActiveSheet()->SetCellValue('AR' . $rowCount, $totalData_row['staff_linkedin_con']);
        $objPHPExcel->getActiveSheet()->SetCellValue('AS' . $rowCount, $totalData_row['staff_source_url']);
        $objPHPExcel->getActiveSheet()->SetCellValue('AT' . $rowCount, $totalData_row['staff_email']);
        $objPHPExcel->getActiveSheet()->SetCellValue('AU' . $rowCount, $totalData_row['assumed_email']);
        $objPHPExcel->getActiveSheet()->SetCellValue('AV' . $rowCount, $totalData_row['staff_email_harvesting']);
        $objPHPExcel->getActiveSheet()->SetCellValue('AW' . $rowCount, $totalData_row['staff_direct_tel']); 
        $objPHPExcel->getActiveSheet()->SetCellValue('AX' . $rowCount, $totalData_row['no_of_emp']); 

        $rowCount++; $i++;
       }
        $filename = FCPATH . "uploads/projects/".$totalData_row['project_name'].".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="01simple.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save($filename);
        redirect(base_url("uploads/projects/".$totalData_row['project_name'].".xls"));
    }

    // function FinalSubmit($project_id,$user_id){
    //     $user_id=$this->session->userdata('id');
    //      if(!empty($project_id) && !empty($user_id)){
    //     $assigned_records=$this->Projects_model->get_final_submit_record($project_id,$user_id);
      
    //      if(!empty($assigned_records)){
    //       $date = date('Y-m-d H:i:s');
    //       foreach($assigned_records as $key => $values){
    //          $this->model->updateData('companywise_allocation',array('is_final_submited'=>'1','submission_date'=>$date),array('project_id'=>$values['project_id'],'user_id'=>$values['user_id'],'staff_id'=>$values['staff_id'],'status'=>'1'));
    //      }
    //       $this->model->updateData('companywise_allocation',array('project_status'=>'1'),array('project_id'=>$project_id,'reassigned_to'=>$user_id,'status'=>'1'));
    //       $this->session->set_flashdata("success", "Successfully Project Submited.");  
    //      }
    //      $this->session->set_flashdata("error", "Something Went Wrong.");  
    //      }else{
    //      $this->session->set_flashdata("error", "Something Went Wrong.");  
    //      }
    //      redirect(base_url("projects/project_list"));
 
         
    //  }

    function CompanyFinalSubmit($project_id,$user_id,$id){
        if(!empty($project_id) && !empty($user_id)){
        $data['allInfo'] =  $this->Projects_model->getProjectInfoByStaffId($project_id,$id);
        $staff_list=$this->Projects_model->getStaffInfoDetails($project_id,$data['allInfo'][0]['received_company_name']);
        
       
        foreach($staff_list as $staff_list_key => $staff_list_values){
            $this->model->updateData('bdcrm_uploaded_feildss',array('updated_status'=>0,'validation_status'=>1),array('project_id'=>$staff_list_values['project_id'],'id'=>$staff_list_values['id']));
        }   
        $assigned_records=$this->Projects_model->get_final_submit_record($project_id,$user_id);
         $user_designation = $this->Projects_model->getDesignationById($user_id);
        if($user_designation=="Researcher"){
            $project_status = "researcher_company_status";
        }else{
            $project_status = "caller_company_status";
        }

        foreach($staff_list as $assigned_records_key => $assigned_records_values){
            $this->model->updateData('companywise_allocation',array($project_status=>1),array('project_id'=>$assigned_records_values['project_id'],'staff_id'=>$assigned_records_values['id']));
        }   
            
         
        } 
        $redirect_url="projects/project_list";
        redirect($redirect_url);
    }

    function ProjectFinalSubmit($project_id,$user_id){
       $user_id=$this->session->userdata('id');
        if(!empty($project_id) && !empty($user_id)){
       $assigned_records=$this->Projects_model->get_final_submit_record($project_id,$user_id);
     
        if(!empty($assigned_records)){
         $date = date('Y-m-d H:i:s');
         foreach($assigned_records as $key => $values){
            $this->model->updateData('companywise_allocation',array('is_final_submited'=>'1','submission_date'=>$date),array('project_id'=>$values['project_id'],'user_id'=>$values['user_id'],'staff_id'=>$values['staff_id'],'status'=>'1'));
        }
        $user_designation = $this->Projects_model->getDesignationById($user_id);
        if($user_designation=="Researcher"){
            $project_status = "researcher_project_status";
        }else{
            $project_status = "caller_project_status";
        }
         $this->model->updateData('companywise_allocation',array($project_status=>'1'),array('project_id'=>$project_id,'reassigned_to'=>$user_id,'status'=>'1'));
         $this->session->set_flashdata("success", "Successfully Project Submited.");  
        }
        $this->session->set_flashdata("error", "Something Went Wrong.");  
        }else{
        $this->session->set_flashdata("error", "Something Went Wrong.");  
        }
        redirect(base_url("projects/project_list"));

        
    }
     
     public function ProjectInfo($id){
         $id=base64_decode($id);
         $data['id'] = $id;
          
         $user_id=$this->session->userdata('id');
         $data['getcompletedstatus']=$this->Projects_model->get_completed_count($id,$user_id);
         $data['ProjectInfo'] = $this->Projects_model->getProjectInfo($id);
         $data['user_list'] = $this->model->selectWhereData('users',array('status'=>'1','username !='=>'superadmin'),array('id','first_name','last_name'),false);
         $data['designation_name'] = $this->session->userdata('designation_name');
         $data['main_content'] = "projects/project_info"; 
         $this->load->view("includes/template", $data);
    }
    


     public function ProjectInfoNew($id=''){

        $total = 0;
        if(!empty($_POST)){
            $status = $_POST['record_type'];
            $data['ProjectInfo'] = $this->getfilterData($_POST)['project_info'];
            $data['project_id'] = $_POST['id'];
            $data['sqlData'] = "SELECT * FROM TABLE WHERE ".$this->getfilterData($_POST)['sql']; 
        }else{
        
         $id=base64_decode($id);
         $data['id'] = $id;
          $data['ProjectInfo'] = $this->Projects_model->getProjectInfoById($id);
         $data['project_id'] = $id;
         $data['sqlData'] = "SELECT * FROM TABLE "; 
        }
        //print_r( $data['ProjectInfo']);die();
         $data['user_list'] = $this->Projects_model->getUsersDesigInfo($data['project_id']);

         $data['designation_name'] =$this->session->userdata('designation_name');
         $user_id=$this->session->userdata('id');
        
         foreach ($data['ProjectInfo'] as $key => $value) {
                $total += $value['staff_count'];
                $validation_status = $value['validation_status'];
                $split_status=explode(',',$validation_status);
                $count=0;$count1=0;
                foreach($split_status as $split_status_key => $split_status_val)
                {
                   if($split_status_val == 0)
                   {
                    $count= $count +1;
                   }
                   if($split_status_val == 1)
                   {
                    $count1= $count1 +1;
                   }
                }
            $data['ProjectInfo'][$key]['validations']= $count; 
            $data['ProjectInfo'][$key]['updatedcount']= $count1; 
         }
        
         $data['total_staff'] = $total; 
        
         $data['total_validation_count'] =count($data['validation_status']); 
         $data['total_company'] =count($data['ProjectInfo']); 
         $data['main_content'] = "projects/project_info_new"; 
         $this->load->view("includes/template", $data);
    }
    
    public function getfilterData($data){
        

        // echo "<pre>";
        // print_r($_POST);
        // die;
        $_POST = $data;
        $records_count=$this->input->post('records_count');
        $input_field=$this->input->post('input_field');
        $operator=$this->input->post('operator');
        $assignment=$this->input->post('assignment');
        $input_types=$this->input->post('input_types');
        $company_count=$this->input->post('company_count');
        $project_id=$this->input->post('id');
        $table_name=$this->input->post('table_name');
        $status=$this->input->post('record_type');
        $user_ids=$this->input->post('user_ids');
        
        
      

        foreach($input_field as $input_field_key => $input_field_row){
             $input_field=$input_field_row;
             $operators=$operator[$input_field_key];
             $assignments=$assignment[$input_field_key];
             $inputtypes=$input_types[$input_field_key];
             $table_names=$table_name[$input_field_key];
             $insert_record[] = array(
                 'input_field' =>$input_field_row,
                 'operator'=>$operators,
                 'inputtype'=>$inputtypes,
                 'table_name'=>$table_names,
                 'assignment'=>$assignments,
             );
        }
        $sql="";
        $new="";
        foreach($insert_record as $k =>$val){

             $feild_name = "bdcrm_uploaded_feildss.".$val['input_field']."";
             $operator = $val['operator'];
             if($operator == "LIKE")
             {
                $inputtypes = "'%".$val['inputtype']."%'"; 
             }else{
                $inputtypes = "'".$val['inputtype']."'"; 
             }
             $assignment = $val['assignment'];
             $sql .= $feild_name.' '.$operator.' '.$inputtypes.' '.$assignment.' ';
             $new .= $val['input_field'].' '.$operator.' '.$inputtypes.' '.$assignment.' ';
        }
       
                 $sqlQuery = "SELECT * FROM TABLE_NAME WHERE ".$new;
                 $new_sql=$sql;
                 $id= $this->input->post('id');
                 $ProjectInfo = $this->Projects_model->getProjectInfo($sql,$id,$records_count,$status,$user_ids);
                 return $data = array('project_info'=>$ProjectInfo,'sql'=>$new);

    }
     public function get_input_type() {
         $id=$this->input->post('label_name');
        $html="";
         $data = $this->model->getDataOrderBy('bdcrm_feilds',array('input_name'=>$id,'field_status' => '1'),'label_name');
        if($data[0]['input_type']=='text')
        {
            $html="<input type='text' value='' title='' id='received_company_name_key'  name='input_types[]' class='form-control form-control-sm' style='margin-left:15px;'><input type='hidden' value='".$data[0]['table_name']."' title='' id='table_name'  name='table_name[]' class='form-control form-control-sm' style='margin-left:15px;'>";
        }
        else if($data[0]['input_type']=='select'){
            $html="<input type='hidden' value='".$data[0]['table_name']."' title='' id='table_name'  name='table_name[]' class='form-control form-control-sm' style='margin-left:15px;'>";
            $html .="<select  class='form-control received_company_name_key form-control-sm' id='received_company_name_key' name='input_types[]' style='margin-left:15px;width:200px;'><option value=''>Select Option</option>";
            $master_record=$this->Projects_model->get_master_record($data[0]['table_name']);
            foreach($master_record as $master_record_key => $master_record_val)
            {
            $html.="<option value='".$master_record_val['id']."'>".$master_record_val['disposition']."</option>";
            }
            $html.="</select>";
        }
       
        echo json_encode($html);
    }
    
     public function get_all_input_fields() {
        $html="";
        $selected="selected";
        $data=$this->model->selectWhereData('bdcrm_feilds', array('field_status' => '1'),array('DISTINCT(label_name),id,input_name'),false);
        $html .= "<option value='' selected disabled >Select Feilds</option>";
        if (!empty($data)) {
            foreach ($data as $data_key => $data_row) {
                $html .= "<option value='".$data_row['input_name']."'>".$data_row['label_name']."</option>";
            }
        }
        echo json_encode($html);
    }





                    // Staff Information Managements




        public function get_staff_info_new(){

       
         $data['id']=base64_decode($_GET['id']);
         $data['received_company_name'] = base64_decode($_GET['received_company_name']);
         if(!empty($_POST) && !empty($_POST['input_field']) && !empty($_POST['input_types'])){

         		$datas = $this->getFilteredData()['project_info'];
         		$data['sqlData'] = $this->getFilteredData()['sql'];
         	    $data['ProjectInfo'] = $datas ;
         }else if(!empty($_POST) && empty($_POST['input_field']) && !empty($_POST['record_type'])){
         	$record_type = $this->input->post('record_type');
            $user_idss = $this->input->post('user_ids');
         	$data['ProjectInfo'] = $this->Projects_model->get_staff_info($data['id'],$data['received_company_name'],$record_type,'',$user_idss);
            $data['sqlData'] ="SELECT * FROM TABLE_NAME WHERE company_name="."'".$data['received_company_name']."'";
         }else{
            $data['ProjectInfo'] = $this->Projects_model->get_staff_info($data['id'],$data['received_company_name']);
            $data['sqlData'] ="SELECT * FROM TABLE_NAME WHERE company_name="."'".$data['received_company_name']."'";
         }
         $data['user_list'] = $this->Projects_model->getUsersDesigInfo($data['id']);
         $data['main_content'] = "projects/staff_info_new";
         
         
        //  echo "<pre>";
        //  print_r($data);
        //  die;
         $this->load->view("includes/template", $data);
    }


    public function getFilteredData(){



        $project_id =  base64_decode($_GET['id']); 
        $company_name =  base64_decode($_GET['received_company_name']); 
        $input_field=$this->input->post('input_field');
        $operator=$this->input->post('operator');
        $assignment=$this->input->post('assignment');
        $input_types=$this->input->post('input_types');
        $table_name=$this->input->post('table_name');
        $record_type=$this->input->post('record_type');
        foreach($input_field as $input_field_key => $input_field_row){
             $input_field=$input_field_row;
             $operators=$operator[$input_field_key];
             $assignments=$assignment[$input_field_key];
             $inputtypes=$input_types[$input_field_key];
             $table_names=$table_name[$input_field_key];
             $insert_record[] = array(
                 'input_field' =>$input_field_row,
                 'operator'=>$operators,
                 'inputtype'=>$inputtypes,
                 'table_name'=>$table_names,
                 'assignment'=>$assignments,
             );
        }
        $sql="";
        $new="";
        foreach($insert_record as $k =>$val){
             $feild_name = "buf.".$val['input_field']."";
             $operator = $val['operator'];
             $inputtypes = "'".$val['inputtype']."'"; 
             $assignment = $val['assignment'];
             $sql .= $feild_name.' '.$operator.' '.$inputtypes.' '.$assignment.' ';
             $new .= $val['input_field'].' '.$operator.' '.$inputtypes.' '.$assignment.' ';
        }
            $sqlQuery = "SELECT * FROM TABLE_NAME WHERE company_name=".$company_name." AND ".$new;
            $new_sql=$sql;
            $id= $this->input->post('id');
            $ProjectInfo = $this->Projects_model->get_staff_info($project_id,$company_name,$record_type,$sql);
            //echo $this->db->last_query(); die;


        	return $data = array('project_info'=>$ProjectInfo,'sql'=>$sqlQuery);
      
    }



      public function save_staff_allocation_data(){
      	// echo "<pre>";
      	// print_r($_POST);
      	// die;
        $project_id = $this->input->post('project_id');
        $assignee_users = $this->input->post('users');
        $company_name = $this->input->post('company_name');
        $total_count = $this->input->post('total_staff_count');
        $perUser = count($assignee_users);
        $staff_infos = $this->input->post('staff_info');  

        if(!empty($staff_infos)){
            foreach ($staff_infos as $key => $value) {
            if($key<$total_count){
               $staff_info[$key] =  $value;
            }
        }
    
		$staff_count = count($staff_info);    
        $break = round(count($staff_info) / $perUser);

        if(!empty($break)){

            $user_list_last_key = array_key_last($assignee_users);
             $start = 0;
            foreach ($assignee_users as $user_list_key => $user_list_row) {
                  $user_designation = $this->Projects_model->getDesignationById($user_list_row);
                if($user_designation=="Researcher"){
                    $project_status = "researcher_project_status";
                }else{
                    $project_status = "caller_project_status";
                }

               if($user_list_last_key == $user_list_key){
                  
                    if(!empty($staff_info)){
                        foreach ($staff_info as $staff_info_key => $staff_info_row) {
                            $insert_data=array('project_id'=>$project_id,'user_id'=>$user_list_row,'reassigned_to'=>$user_list_row,'staff_id'=>$staff_info_row,'assigned_by'=>$this->session->userdata('id'),'assigned_at'=>date('Y-m-d H:i:s'),$project_status=>'0','total_count'=>$total_count);
                            $update_data=array('project_id'=>$project_id,'reassigned_to'=>$user_list_row,'staff_id'=>$staff_info_row,'assigned_by'=>$this->session->userdata('id'),'assigned_at'=>date('Y-m-d H:i:s'),$project_status=>'0');
                            $check_assigned_task = $this->Projects_model->getallocationdetails($project_id,$staff_info_row,$this->session->userdata('id'));
                            
                            if(!empty($check_assigned_task))
                            { 
                                foreach($check_assigned_task as $key => $value)
                                {
                                $reassignstaff= $this->model->updateData("companywise_allocation",$update_data,array('project_id'=>$value['project_id'],'staff_id'=>$value['staff_id'],'assigned_by'=>$this->session->userdata('id')));
                                $insert_companywise_allocation_history  = $this->model->insertData('bdcrm_allocation_history',array('project_id'=>$project_id,'staff_id'=>$staff_info_row,'user_id'=>$user_list_row,'assigned_by'=>$this->session->userdata('id')));    
                                }
                            }else{
                              
                                $insert_companywise_allocation  = $this->model->insertData('companywise_allocation', $insert_data);
                                $insert_companywise_allocation_history  = $this->model->insertData('bdcrm_allocation_history',array('project_id'=>$project_id,'user_id'=>$user_list_row,'staff_id'=>$staff_info_row,'assigned_by'=>$this->session->userdata('id')));
                            }
                        }

                    }
                    break;
                }else{
                   
                    for ($i=$start; $i < $break ; $i++) { 
                        if(!empty($staff_info)){
                            $insert_data=array('project_id'=>$project_id,'user_id'=>$user_list_row,'reassigned_to'=>$user_list_row,'staff_id'=>$staff_info[$i],'assigned_by'=>$this->session->userdata('id'),'assigned_at'=>date('Y-m-d H:i:s'),$project_status=>'0','total_count'=>$total_count);
                            $update_data=array('project_id'=>$project_id,'reassigned_to'=>$user_list_row,'staff_id'=>$staff_info[$i],'assigned_by'=>$this->session->userdata('id'),'assigned_at'=>date('Y-m-d H:i:s'),$project_status=>'0');
                            $check_assigned_task = $this->Projects_model->getallocationdetails($project_id,$staff_info[$i],$this->session->userdata('id'));
                            
                            if(!empty($check_assigned_task))
                            {
                                foreach($check_assigned_task as $key => $value)
                                {
                                $reassignstaff= $this->model->updateData("companywise_allocation",$update_data,array('project_id'=>$value['project_id'],'staff_id'=>$value['staff_id'],'assigned_by'=>$this->session->userdata('id')));
                                $insert_companywise_allocation_history  = $this->model->insertData('bdcrm_allocation_history',array('project_id'=>$value['project_id'],'staff_id'=>$value['staff_id'],'user_id'=>$value['user_id'])); 
                                }
                            }else{
                                $insert_companywise_allocation  = $this->model->insertData('companywise_allocation', $insert_data);
                                $insert_companywise_allocation_history  = $this->model->insertData('bdcrm_allocation_history',array('project_id'=>$project_id,'user_id'=>$user_list_row,'staff_id'=>$staff_info[$i]));
                            }
                           
                        }
                        unset($staff_info[$i]);
                     
                    }
                    $start = $start+$break;
                    $break = $break+$break; 
                }
               
            }
            $response['message'] = "Company Allocation Inserted Successfully";
            $response['status'] = "success";
            $msg = "Successfully ".$total_count." Staff's Allocated to ".count($assignee_users)." Users.";
            $this->session->set_flashdata("success", $msg);  
          
        }
        else {
            $response['message'] = "Userlist Cannot Be Greater Than Staff Records.";
            $response['status'] = "failure";
            $this->session->set_flashdata("error", "Assignee Users Cannot Be Greater Than Staffs.");  
        }
    }else{
    	$response['message'] = "Staff Unvailable for the Allocation";
        $response['status'] = "error";
        $this->session->set_flashdata("error", "Staff Unvailable for the Allocation");
    }
      $redirect_url = "Projects/get_staff_info_new?id=".base64_encode($project_id)."&received_company_name=".base64_encode($company_name);
      redirect(base_url($redirect_url));
  
    }

public function insert_noresult_row()
    {
        $project_id=$this->input->post('project_id');
        $staff_id=$this->input->post('staff_id');
        $assigned_by=$this->input->post('assigned_by');
        $web_staff_disposition1 =$this->input->post('web_staff_disposition1');
        $voice_staff_disposition1 =$this->input->post('voice_staff_disposition1');
       
        $get_exisiting_row = $this->model->selectWhereData('bdcrm_uploaded_feildss',array('id' => $staff_id,'project_id'=>$project_id),array('*'),false);
        $company_alloc_exisiting_row = $this->model->selectWhereData('companywise_allocation',array('staff_id' => $staff_id,'project_id'=>$project_id),array('*'),false);
        if($this->session->userdata('designation_id') == 6)
        {
            $this->model->updateData("bdcrm_uploaded_feildss", array('web_staff_disposition'=>$web_staff_disposition1), array('id' =>$staff_id));
            $has_replaced=$staff_id;
            $caller_has_replaced="";
            $web_staff_disposition1='5';
        }else if($this->session->userdata('designation_id') == 3){
            $this->model->updateData("bdcrm_uploaded_feildss", array('web_staff_disposition'=>$web_staff_disposition1,'voice_staff_disposition'=>$voice_staff_disposition1), array('id' =>$staff_id));
            $caller_has_replaced=$staff_id;
            $has_replaced=$get_exisiting_row[0]['has_replaced'];
            $voice_staff_disposition1='5';
        }
        $new_row_staff_details=array(
            'project_id'=>$project_id,
            'has_replaced'=>$has_replaced,
            'caller_has_replaced'=>$caller_has_replaced,
            'company_name'=>$get_exisiting_row[0]['company_name'],
            'activity_type'=>'1',
            'received_company_name'=>$get_exisiting_row[0]['received_company_name'],
            'address1'=>$get_exisiting_row[0]['address1'],
            'address2'=>$get_exisiting_row[0]['address2'],
            'address3'=>$get_exisiting_row[0]['address3'],
            'city'=>$get_exisiting_row[0]['city'],
            'postal_code'=>$get_exisiting_row[0]['postal_code'],
            'state_county'=>$get_exisiting_row[0]['state_county'],
            'country'=>$get_exisiting_row[0]['country'],
            'country_code'=>$get_exisiting_row[0]['country_code'],
            'region'=>$get_exisiting_row[0]['region'],
            'address_souce_url'=>$get_exisiting_row[0]['address_souce_url'],
            'no_of_emp'=>$get_exisiting_row[0]['no_of_emp'],
            'ca1'=>$get_exisiting_row[0]['ca1'],
            'ca2'=>$get_exisiting_row[0]['ca2'],
            'ca3'=>$get_exisiting_row[0]['ca3'],
            'ca4'=>$get_exisiting_row[0]['ca4'],
            'ca5'=>$get_exisiting_row[0]['ca5'],
            'company_disposition'=>$get_exisiting_row[0]['company_disposition'],
            'web_disposition'=>$get_exisiting_row[0]['web_disposition'],
            //'voice_staff_disposition'=>$get_exisiting_row[0]['voice_staff_disposition'],
            'company_genaral_notes'=>$get_exisiting_row[0]['company_genaral_notes'],
            'researcher_company_remark'=>$get_exisiting_row[0]['researcher_company_remark'],
            'caller_company_remark'=>$get_exisiting_row[0]['caller_company_remark'],
            'researcher_company_note'=>$get_exisiting_row[0]['researcher_company_note'],
            'caller_company_note'=>$get_exisiting_row[0]['caller_company_note'],
            'tel_number'=>$get_exisiting_row[0]['tel_number'],
            'alternate_number'=>$get_exisiting_row[0]['alternate_number'],
            'industry'=>$get_exisiting_row[0]['industry'],
            'revenue'=>$get_exisiting_row[0]['revenue'],
            'revenue_curr'=>$get_exisiting_row[0]['revenue_curr'],
            'created_date'=>date('Y-m-d H:i:s'),
            'first_name'=>'',
            'last_name'=>'',
            'provided_job_title'=>'',
            'staff_job_function'=>'',
            'staff_email'=>'',
            'provided_staff_email'=>'',
            'staff_department'=>'',
            'staff_url'=>'',
            'assumed_email'=>'',
            'staff_email_harvesting'=>'',
            'voice_disposition'=>'',
            'staff_direct_tel'=>'',
            'staff_mobile'=>'',
            'web_staff_disposition'=>$web_staff_disposition1,
            'voice_staff_disposition'=>$voice_staff_disposition1,
            'staff_linkedin_con'=>'',
            'staff_note'=>'',
            'staff_remark'=>'',
            'research_remark'=>'',
            'voice_remark'=>'',
            'sa1'=>'',
            'sa2'=>'',
            'sa3'=>'',
            'sa4'=>'',
            'sa5'=>'',
            'website_url'=>'',
            'suffix'=>'',
            'validation_status'=>'0',
        );
       $insert_id=$this->model->insertData('bdcrm_uploaded_feildss',$new_row_staff_details);
       if(!empty($insert_id))
        {
           $company_alloc_new_row=array('project_id'=>$project_id,'staff_id'=>$insert_id,'user_id'=>$this->session->userdata('id'),'reassigned_to  '=>$this->session->userdata('id'),'assigned_by'=>$company_alloc_exisiting_row[0]['assigned_by'],'created_at'=>date('Y-m-d H:i:s'));
            $last_comp_alloc_id=$this->model->insertData('companywise_allocation',$company_alloc_new_row);

            $company_allochist_new_row=array('project_id'=>$project_id,'staff_id'=>$insert_id,'user_id'=>$this->session->userdata('id'),'assigned_by'=>$company_alloc_exisiting_row[0]['assigned_by'],'created_at'=>date('Y-m-d H:i:s'));
            $last_comp_alloc_hist_id=$this->model->insertData('bdcrm_allocation_history',$company_allochist_new_row);
            $response['status']='success';
            $response['error']=array('staff_id' => $insert_id,'project_id'=>$project_id,'company_name'=>$get_exisiting_row[0]['received_company_name']);
        }
       else{
            $response['status']='failure';
            $response['error']=array('msg' => "Failed to Insert New Record !");
       }

        echo json_encode($response);
    }

public function insert_replacement_row()
    {


        // echo "<pre>";
        // print_r($_POST);
        // die;

        $project_id=$this->input->post('project_id');
        $staff_id=$this->input->post('staff_id');
        $assigned_by=$this->input->post('assigned_by');
        $web_staff_disposition =$this->input->post('web_staff_dispo');
        $voice_staff_disposition =$this->input->post('voice_staff_dispositions');

        
        $get_exisiting_row = $this->model->selectWhereData('bdcrm_uploaded_feildss',array('id' => $staff_id,'project_id'=>$project_id),array('*'),false);
        $company_alloc_exisiting_row = $this->model->selectWhereData('companywise_allocation',array('staff_id' => $staff_id,'project_id'=>$project_id),array('*'),false);
        if($this->session->userdata('designation_id') == 6)
        {
            $this->model->updateData("bdcrm_uploaded_feildss", array('web_staff_disposition'=>$web_staff_disposition), array('id' =>$staff_id));
            $has_replaced=$staff_id;
            $caller_has_replaced="";
            $web_staff_disposition = '4';

        }else if($this->session->userdata('designation_id') == 3){
            $this->model->updateData("bdcrm_uploaded_feildss", array('web_staff_disposition'=>$web_staff_disposition,'voice_staff_disposition'=>$voice_staff_disposition), array('id' =>$staff_id));
            $caller_has_replaced=$staff_id;
            $has_replaced=$get_exisiting_row[0]['has_replaced'];
            $voice_staff_disposition = '4';
        }

      
        $new_row_staff_details=array(
            'project_id'=>$project_id,
            'has_replaced'=>$has_replaced,
            'caller_has_replaced'=>$caller_has_replaced,
            'activity_type'=>'3',
            'company_name'=>$get_exisiting_row[0]['company_name'],
            'received_company_name'=>$get_exisiting_row[0]['received_company_name'],
            'address1'=>$get_exisiting_row[0]['address1'],
            'address2'=>$get_exisiting_row[0]['address2'],
            'address3'=>$get_exisiting_row[0]['address3'],
            'city'=>$get_exisiting_row[0]['city'],
            'postal_code'=>$get_exisiting_row[0]['postal_code'],
            'state_county'=>$get_exisiting_row[0]['state_county'],
            'country'=>$get_exisiting_row[0]['country'],
            'country_code'=>$get_exisiting_row[0]['country_code'],
            'region'=>$get_exisiting_row[0]['region'],
            'address_souce_url'=>$get_exisiting_row[0]['address_souce_url'],
            'no_of_emp'=>$get_exisiting_row[0]['no_of_emp'],
            'ca1'=>$get_exisiting_row[0]['ca1'],
            'ca2'=>$get_exisiting_row[0]['ca2'],
            'ca3'=>$get_exisiting_row[0]['ca3'],
            'ca4'=>$get_exisiting_row[0]['ca4'],
            'ca5'=>$get_exisiting_row[0]['ca5'],
            'company_disposition'=>$get_exisiting_row[0]['company_disposition'],
            'web_disposition'=>$get_exisiting_row[0]['web_disposition'],
            'web_staff_disposition'=>$web_staff_disposition,
            'voice_staff_disposition'=>$voice_staff_disposition,
            'company_genaral_notes'=>$get_exisiting_row[0]['company_genaral_notes'],
            'researcher_company_remark'=>$get_exisiting_row[0]['researcher_company_remark'],
            'caller_company_remark'=>$get_exisiting_row[0]['caller_company_remark'],
            'researcher_company_note'=>$get_exisiting_row[0]['researcher_company_note'],
            'caller_company_note'=>$get_exisiting_row[0]['caller_company_note'],
            'tel_number'=>$get_exisiting_row[0]['tel_number'],
            'alternate_number'=>$get_exisiting_row[0]['alternate_number'],
            'industry'=>$get_exisiting_row[0]['industry'],
            'revenue'=>$get_exisiting_row[0]['revenue'],
            'revenue_curr'=>$get_exisiting_row[0]['revenue_curr'],
            'created_date'=>date('Y-m-d H:i:s'),
            'first_name'=>'',
            'last_name'=>'',
            'provided_job_title'=>'',
            'staff_job_function'=>'',
            'staff_email'=>'',
            'provided_staff_email'=>'',
            'staff_department'=>'',
            'staff_url'=>'',
            'assumed_email'=>'',
            'staff_email_harvesting'=>'',
            'voice_disposition'=>'',
            'staff_direct_tel'=>'',
            'staff_mobile'=>'',
            'staff_linkedin_con'=>'',
            'staff_note'=>'',
            'staff_remark'=>'',
            'research_remark'=>'',
            'voice_remark'=>'',
            'sa1'=>'',
            'sa2'=>'',
            'sa3'=>'',
            'sa4'=>'',
            'sa5'=>'',
            'website_url'=>'',
            'suffix'=>'',
            'validation_status'=>'0',
        );
        //  echo "<pre>";print_r($get_exisiting_row);
        //  echo "<pre>";print_r($new_row_staff_details);die();
        $check_staff_has_replaced = $this->model->selectWhereData('bdcrm_uploaded_feildss',array('project_id'=>$project_id,'has_replaced'=>$staff_id,'web_staff_disposition'=>'4'),array('*'),false);
        
           $insert_id=$this->model->insertData('bdcrm_uploaded_feildss',$new_row_staff_details);

            if(!empty($insert_id))
             {
                $company_alloc_new_row=array('project_id'=>$project_id,'staff_id'=>$insert_id,'user_id'=>$this->session->userdata('id'),'reassigned_to  '=>$this->session->userdata('id'),'assigned_by'=>$company_alloc_exisiting_row[0]['assigned_by'],'created_at'=>date('Y-m-d H:i:s'));
                 $last_comp_alloc_id=$this->model->insertData('companywise_allocation',$company_alloc_new_row);
     
                 $company_allochist_new_row=array('project_id'=>$project_id,'staff_id'=>$insert_id,'user_id'=>$this->session->userdata('id'),'assigned_by'=>$company_alloc_exisiting_row[0]['assigned_by'],'created_at'=>date('Y-m-d H:i:s'));
                 $last_comp_alloc_hist_id=$this->model->insertData('bdcrm_allocation_history',$company_allochist_new_row);
                 
                 $response['status']='success';
                 $response['error']=array('staff_id' => $insert_id,'project_id'=>$project_id,'company_name'=>$get_exisiting_row[0]['received_company_name']);
             }
            else{
                 $response['status']='failure';
                 $response['error']=array('msg' => "Failed to Insert New Record !");
            }
       
        echo json_encode($response);
    }

    public function insert_staff_row()
    {
        
        // echo "<pre>";
        // print_r($_POST);
        // die;
        $project_id=$this->input->post('project_id');
        $staff_id=$this->input->post('staff_id');
        $assigned_by=$this->input->post('assigned_by');
        //$staff_disposition =$this->input->post('dispo');
        $web_staff_disposition =$this->input->post('web_staff_dispo');
        $voice_staff_disposition =$this->input->post('voice_staff_dispositions');

        $get_exisiting_row = $this->model->selectWhereData('bdcrm_uploaded_feildss',array('id' => $staff_id,'project_id'=>$project_id),array('*'),false);
        $company_alloc_exisiting_row = $this->model->selectWhereData('companywise_allocation',array('staff_id' => $staff_id,'project_id'=>$project_id),array('*'),false);
        if($this->session->userdata('designation_id') == 6)
        {
            $this->model->updateData("bdcrm_uploaded_feildss", array('web_staff_disposition'=>$web_staff_disposition), array('id' =>$staff_id));
            $has_replaced=$staff_id;
            $caller_has_replaced="";
            $web_staff_disposition ='5';

        }else if($this->session->userdata('designation_id') == 3){
            $this->model->updateData("bdcrm_uploaded_feildss", array('web_staff_disposition'=>$web_staff_disposition,'voice_staff_disposition'=>$voice_staff_disposition), array('id' =>$staff_id));
            $caller_has_replaced=$staff_id;
            $has_replaced=$get_exisiting_row[0]['has_replaced'];
            $voice_staff_disposition = '5';
        }
     
        $new_row_staff_details=array(
            'project_id'=>$project_id,
            'received_company_name'=>$get_exisiting_row[0]['received_company_name'],
            'company_name'=>$get_exisiting_row[0]['received_company_name'],
            'has_replaced'=>$has_replaced,
            'caller_has_replaced'=>$caller_has_replaced,
            'activity_type'=>'2',
            'web_staff_disposition'=>$web_staff_disposition,
            'voice_staff_disposition'=>$voice_staff_disposition,
            'created_date'=>date('Y-m-d H:i:s'),
            'validation_status'=>'0'
        );
     
           $insert_id=$this->model->insertData('bdcrm_uploaded_feildss',$new_row_staff_details);
    
            if(!empty($insert_id))
             {
                $this->model->updateData('bdcrm_uploaded_feildss',array('company_name'=>''),array('id'=>$staff_id));
                //echo $this->db->last_query();die();
                $company_alloc_new_row=array('project_id'=>$project_id,'staff_id'=>$insert_id,'user_id'=>$this->session->userdata('id'),'reassigned_to  '=>$this->session->userdata('id'),'assigned_by'=>$company_alloc_exisiting_row[0]['assigned_by'],'created_at'=>date('Y-m-d H:i:s'));
                 $last_comp_alloc_id=$this->model->insertData('companywise_allocation',$company_alloc_new_row);
     
                 $company_allochist_new_row=array('project_id'=>$project_id,'staff_id'=>$insert_id,'user_id'=>$this->session->userdata('id'),'assigned_by'=>$company_alloc_exisiting_row[0]['assigned_by'],'created_at'=>date('Y-m-d H:i:s'));
                 $last_comp_alloc_hist_id=$this->model->insertData('bdcrm_allocation_history',$company_allochist_new_row);
                 
                 $response['status']='success';
                 $response['error']=array('staff_id' => $insert_id,'project_id'=>$project_id,'company_name'=>$get_exisiting_row[0]['received_company_name']);
             }
            else{
                 $response['status']='failure';
                 $response['error']=array('msg' => "Failed to Insert New Record !");
            }
        
        echo json_encode($response);
    }
    
        public function insert_acquired_row()
    {
        
        $project_id=$this->input->post('project_id');
        $staff_id=$this->input->post('staff_id');
        $assigned_by=$this->input->post('assigned_by');
        //$staff_disposition =$this->input->post('dispo');
        $web_staff_disposition =$this->input->post('web_staff_dispo');
        $voice_staff_disposition =$this->input->post('voice_staff_dispositions');

        $get_exisiting_row = $this->model->selectWhereData('bdcrm_uploaded_feildss',array('id' => $staff_id,'project_id'=>$project_id),array('*'),false);
        $company_alloc_exisiting_row = $this->model->selectWhereData('companywise_allocation',array('staff_id' => $staff_id,'project_id'=>$project_id),array('*'),false);
        if($this->session->userdata('designation_id') == 6)
        {
            $this->model->updateData("bdcrm_uploaded_feildss", array('web_staff_disposition'=>$web_staff_disposition), array('id' =>$staff_id));
            $has_replaced=$staff_id;
            $caller_has_replaced="";
            $web_staff_disposition ='2';

        }else if($this->session->userdata('designation_id') == 3){
            $this->model->updateData("bdcrm_uploaded_feildss", array('web_staff_disposition'=>$web_staff_disposition,'voice_staff_disposition'=>$voice_staff_disposition), array('id' =>$staff_id));
            $caller_has_replaced=$staff_id;
            $has_replaced=$get_exisiting_row[0]['has_replaced'];
            $voice_staff_disposition = '2';
        }
     
        $new_row_staff_details=array(
            'project_id'=>$project_id,
            'received_company_name'=>$get_exisiting_row[0]['received_company_name'],
            'company_name'=>$get_exisiting_row[0]['received_company_name'],
            'has_replaced'=>$has_replaced,
            'caller_has_replaced'=>$caller_has_replaced,
            'activity_type'=>'4',
            'web_staff_disposition'=>$web_staff_disposition,
            'voice_staff_disposition'=>$voice_staff_disposition,
            'created_date'=>date('Y-m-d H:i:s'),
            'validation_status'=>'0'
        );
           $insert_id=$this->model->insertData('bdcrm_uploaded_feildss',$new_row_staff_details);
    
            if(!empty($insert_id))
             {
                $this->model->updateData('bdcrm_uploaded_feildss',array('company_name'=>''),array('id'=>$staff_id));
                //echo $this->db->last_query();die();
                $company_alloc_new_row=array('project_id'=>$project_id,'staff_id'=>$insert_id,'user_id'=>$this->session->userdata('id'),'reassigned_to  '=>$this->session->userdata('id'),'assigned_by'=>$company_alloc_exisiting_row[0]['assigned_by'],'created_at'=>date('Y-m-d H:i:s'));
                 $last_comp_alloc_id=$this->model->insertData('companywise_allocation',$company_alloc_new_row);
     
                 $company_allochist_new_row=array('project_id'=>$project_id,'staff_id'=>$insert_id,'user_id'=>$this->session->userdata('id'),'assigned_by'=>$company_alloc_exisiting_row[0]['assigned_by'],'created_at'=>date('Y-m-d H:i:s'));
                 $last_comp_alloc_hist_id=$this->model->insertData('bdcrm_allocation_history',$company_allochist_new_row);
                 
                 $response['status']='success';
                 $response['error']=array('staff_id' => $insert_id,'project_id'=>$project_id,'company_name'=>$get_exisiting_row[0]['received_company_name']);
             }
            else{
                 $response['status']='failure';
                 $response['error']=array('msg' => "Failed to Insert New Record !");
            }
        
        echo json_encode($response);
    }

    public function getProjectDataById(){
        $id= 1;
       $data =  $this->Projects_model->getAllDataByProjectId($id);
       
       echo "<pre>";
       print_r($data);
       die;
        
    }



}
