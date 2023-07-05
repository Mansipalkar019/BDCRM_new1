<?php

class Projects_model extends CI_Model
{
public function __construct()
{
parent::__construct();
$designation_name = $this->session->userdata('designation_name');
$user_id = $this->session->userdata('id');
}

public function getAll()
{
try {
    $query = $this->db->select("*")
        ->from("master_department")
        ->where("status", 0)
        ->get();
        
    if ($query->num_rows() > 0) {
        $rows = $query->result_array();
        return $rows;
    } else {
        return false;
    }
} catch (Exception $e) {
    return false;
}
}


function getindustryInfoByName($industry){

$sql = "SELECT id FROM `bdcrm_industries` WHERE LOWER(Industries) =  LOWER('$industry') OR UPPER(Industries) = UPPER('$industry')"; 
$query = $this->db->query($sql);
$data=  $query->result_array();

if(!empty($data)){
$industry_id = $data[0]['id'];
}else{
$industry_id = "";
}
return $industry_id;

}

function getSalutationInfoByName($industry){

    $sql = "SELECT id FROM `bdcrm_name_prefix` WHERE LOWER(prefix) =  LOWER('$industry') OR UPPER(prefix) = UPPER('$industry') and status=1"; 
    $query = $this->db->query($sql);
    //echo $this->db->last_query();die();
    $data=  $query->result_array();
    
    if(!empty($data)){
    $industry_id = $data[0]['id'];
    }else{
    $industry_id = "";
    }
    return $industry_id;
    
}

function getdispositions($dispositions){
$sql = "SELECT id FROM `bdcrm_caller_disposition` WHERE caller_disposition LIKE  '%".$dispositions."%' and status=1"; 
$query = $this->db->query($sql);
$data=  $query->result_array();
if(!empty($data)){
 $disp_id = $data[0]['id'];
}else{
 $disp_id = "";
}

 return $disp_id;

}

function getsubdispositions($subdispositions){

$sql = "SELECT id FROM `bdcrm_staff_voice_dispositions` WHERE voice_dispositions LIKE  '%".$subdispositions."%' and status=1"; 
$query = $this->db->query($sql);
$data=  $query->result_array();

if(!empty($data)){
 $subdisp_id = $data[0]['id'];
}else{
 $subdisp_id = "";
}
 return $subdisp_id;

}



public function get_task_fields($tasktypeid){
$this->db->select('id,label_name');
$this->db->from('bdcrm_feilds');
$this->db->where('status','1');
$this->db->order_by("sort_order");

$query=$this->db->get();
$data =  $query->result_array();

foreach ($data as $key => $value) {
    $feild_id= $value['id'];
    $label_name = $value['label_name'];
    $this->db->select('id,feild_id,task_type_id');
    $this->db->from('bdcrm_default_feilds_access');
    $this->db->where('feild_id',$feild_id);
    $this->db->where('task_type_id',$tasktypeid);
    $this->db->where('status',1);

    $querys=$this->db->get();
    $datas =  $querys->row_array();
  
    if(!empty($datas)){
        $fdata[$key]= $datas;
        $fdata[$key]['access'] = 1;
        $fdata[$key]['label_name'] = $label_name;
    }else{
        $fdata[$key]['id'] = $feild_id;
        $fdata[$key]['feild_id'] = $feild_id;
        $fdata[$key]['task_type_id'] = $tasktypeid;
        $fdata[$key]['access'] = 0;
        $fdata[$key]['label_name'] = $label_name;
    }

}

return $fdata;
}


function getUsersDesigInfo($project_id){

    $sql = "SELECT us.id,us.first_name,us.last_name,md.designation_name,bpt.designation_id FROM `bdcrm_master_projects` as bmp
    left join bdcrm_project_types as bpt on bmp.project_type = bpt.id
    left join users as us on bpt.designation_id = us.designation
    left join master_designation as md on us.designation = md.id
    WHERE bmp.id = $project_id";
    $query = $this->db->query($sql);
    $data =  $query->result_array();
    
    if($data[0]['designation_id']=='6,15,3,14,1'){
 
    if($this->session->userdata('designation_name') == "Caller Team Leader")
    {
    $data='3,14,8';
    $data =$this->getDesignationInfoById($data);
    
    }else  if($this->session->userdata('designation_name') == "Researcher Team Leader"){
    $data='6,15';
    $data =$this->getDesignationInfoById($data);
    
    }else  if($this->session->userdata('designation_name') == "Superadmin"){
    $data='3,6,15,14,8';
    $data =$this->getDesignationInfoById($data);
    }
    else  if($this->session->userdata('designation_name') == "Project Manger"){
        $data='3,6,15,14,8';
        $data =$this->getDesignationInfoById($data);
    }
    else  if($this->session->userdata('designation_name') == "Caller"){
    $data='3,14,8';
    $data =$this->getDesignationInfoById($data);
    }
    }
    
    if($data[0]['designation_id']=='6,15'){
      
    if($this->session->userdata('designation_name') == "Caller Team Leader")
    {
    $data='3,14,8';
    $data =$this->getDesignationInfoById($data);
    
    }else  if($this->session->userdata('designation_name') == "Researcher Team Leader"){
    $data='6,15,3,14';
    $data =$this->getDesignationInfoById($data);
    
    }else  if($this->session->userdata('designation_name') == "Superadmin"){
    $data='3,6,15,14,8';
    $data =$this->getDesignationInfoById($data);
    }
    else  if($this->session->userdata('designation_name') == "Project Manger"){
        $data='3,6,15,14,8';
        $data =$this->getDesignationInfoById($data);
    }
    else  if($this->session->userdata('designation_name') == "Caller"){
    $data='3,14,8';
    $data =$this->getDesignationInfoById($data);
    }
    }
    if($data[0]['designation_id']=='3,14'){
       
    if($this->session->userdata('designation_name') == "Caller Team Leader")
    {
    $data='3,14,8';
    $data =$this->getDesignationInfoById($data);
    
    }else  if($this->session->userdata('designation_name') == "Researcher Team Leader"){
    $data='6,15,3,14';
    $data =$this->getDesignationInfoById($data);
    
    }else  if($this->session->userdata('designation_name') == "Superadmin"){
    $data='3,14,8';
    $data =$this->getDesignationInfoById($data);
    }
    else  if($this->session->userdata('designation_name') == "Project Manger"){
        $data='3,6,15,14,8';
        $data =$this->getDesignationInfoById($data);
    }
    else  if($this->session->userdata('designation_name') == "Caller"){
    $data='3,14,8';
    $data =$this->getDesignationInfoById($data);
    }
    }
    return $data; 
    }
    
    function getUsersDesigInfo_projlst(){
    
    $sql = "SELECT us.id,us.first_name,us.last_name,md.designation_name,bpt.designation_id FROM `bdcrm_master_projects` as bmp
    left join bdcrm_project_types as bpt on bmp.project_type = bpt.id
    left join users as us on bpt.designation_id = us.designation
    left join master_designation as md on us.designation = md.id";
    $query = $this->db->query($sql);
    $data =  $query->result_array();
    
    if($data[0]['designation_id']=='6,15,3,14'){
    
    if($this->session->userdata('designation_name') == "Caller Team Leader")
    {
    $data='3,14';
    $data =$this->getDesignationInfoById($data);
    
    }else  if($this->session->userdata('designation_name') == "Researcher Team Leader"){
    $data='6,15';
    $data =$this->getDesignationInfoById($data);
    
    }else  if($this->session->userdata('designation_name') == "Superadmin"){
    $data='3,6,15,14';
    $data =$this->getDesignationInfoById($data);
    }
    else  if($this->session->userdata('designation_name') == "Caller"){
    $data='3,14';
    $data =$this->getDesignationInfoById($data);
    }
    }
    
    if($data[0]['designation_id']=='6,15'){
    
    if($this->session->userdata('designation_name') == "Caller Team Leader")
    {
    $data='3,14';
    $data =$this->getDesignationInfoById($data);
    
    }else  if($this->session->userdata('designation_name') == "Researcher Team Leader"){
    $data='6,15,3,14';
    $data =$this->getDesignationInfoById($data);
    
    }else  if($this->session->userdata('designation_name') == "Superadmin"){
    $data='3,6,15,14';
    $data =$this->getDesignationInfoById($data);
    }
    else  if($this->session->userdata('designation_name') == "Caller"){
    $data='3,14';
    $data =$this->getDesignationInfoById($data);
    }
    }
    if($data[0]['designation_id']=='3,14'){
    
    if($this->session->userdata('designation_name') == "Caller Team Leader")
    {
    $data='3,14';
    $data =$this->getDesignationInfoById($data);
    
    }else  if($this->session->userdata('designation_name') == "Researcher Team Leader"){
    $data='6,15,3,14';
    $data =$this->getDesignationInfoById($data);
    
    }else  if($this->session->userdata('designation_name') == "Superadmin"){
    $data='3,14,6,15,14';
    $data =$this->getDesignationInfoById($data);
    }
    else  if($this->session->userdata('designation_name') == "Caller"){
    $data='3,14';
    $data =$this->getDesignationInfoById($data);
    }
    }
    return $data; 
    }
    
public function getDesignationInfoById($reseracher_id)
{
//echo $reseracher_id;die();
$this->db->select('us.id,us.first_name,us.last_name,md.designation_name');
$this->db->from('users as us');
$this->db->join('master_designation md','md.id = us.designation','left');
$this->db->where('us.status',1);

$this->db->where_in('md.id',$reseracher_id,false);

$this->db->order_by("us.first_name");
$query=$this->db->get();
$data = $query->result_array();
return $data;
}


function getprojectrecord(){

$designation_name = $this->session->userdata('designation_name');
$user_id = $this->session->userdata('id');

$this->db->select('bmp.id,bmp.project_name,bmp.project_breif,bpt.project_type,bpts.project_type as task_type,bmp.created_at,bmp.created_by,bmp.file_name,bmp.file_path,us.username');
$this->db->from('bdcrm_master_projects as bmp');
$this->db->join('bdcrm_project_type bpt','bmp.task_type = bpt.id','left');
$this->db->join('bdcrm_project_types bpts','bmp.project_type = bpts.id','left');
$this->db->join('users us','bmp.created_by = us.id','left');

if(($designation_name=='Researcher')){
$this->db->join('companywise_allocation ca','bmp.id = ca.project_id','left');
$this->db->where('ca.reassigned_to',$user_id);
$this->db->where('ca.researcher_project_status',0);
$this->db->where('ca.researcher_company_status',0);
$this->db->group_by('bmp.id');
$where = '(ca.status IS NULL OR ca.status=1)';
$this->db->where($where);
}else if($designation_name=='Caller')
{

$this->db->join('companywise_allocation ca','bmp.id = ca.project_id','left');
$this->db->where('ca.reassigned_to',$user_id);
$this->db->where('ca.researcher_project_status',0);
$this->db->where('ca.researcher_company_status',0);
$this->db->group_by('bmp.id');
$where = '(ca.status IS NULL OR ca.status=1)';
$this->db->where($where);
}
else if($designation_name=='Researcher Team Leader')
{
$this->db->join('companywise_allocation ca','bmp.id = ca.project_id','left');
$this->db->where('ca.researcher_project_status',0);
$this->db->where('ca.researcher_company_status',0);
$this->db->group_by('bmp.id');
$where = '(ca.status IS NULL OR ca.status=1) AND (bmp.project_type = 1 OR bmp.project_type = 2) AND (us.designation = 8 OR us.designation = 15)';
$this->db->where($where);
}
else if($designation_name=='Caller Team Leader')
{
$this->db->join('companywise_allocation ca','bmp.id = ca.project_id','left');
$this->db->where('ca.reassigned_to',$user_id);
$this->db->where('ca.researcher_project_status',0);
$this->db->where('ca.researcher_company_status',0);
$this->db->group_by('bmp.id');
$where = '(ca.status IS NULL OR ca.status=1) AND (bmp.project_type = 3 OR bmp.project_type = 4) AND (us.designation = 8 OR us.designation = 14)';
$this->db->where($where);
}
$this->db->where('bmp.status','1');
$this->db->order_by("bmp.id", "DESC");

$query=$this->db->get();
//echo $this->db->last_query();die();
$data = $query->result_array();
$fData=[];
foreach ($data as $key => $value) {
$project_id = $value['id'];
$info = $this->getCompanyInfoByProjectId($project_id);
$value['company_count'] = $info['company_count'];
$value['validation_status'] = $info['validation_status'];
$value['no_of_staff'] = $info['no_of_staff'];
$fData[] = $value;
}

return $fData;
}


function getCompanyInfoByProjectId($project_id){
$designation_name = $this->session->userdata('designation_name');
  if(($designation_name=='Researcher') || $designation_name=='Caller' || $designation_name=='Caller Team Leader'){
    $this->db->select('COUNT(DISTINCT buf.company_name) as company_count,COUNT(ca.staff_id) as no_of_staff,GROUP_CONCAT(buf.validation_status) as validation_status');
    $this->db->from('bdcrm_uploaded_feildss buf');
  }else{ $this->db->select('COUNT(DISTINCT buf.company_name) as company_count,COUNT(buf.id) as no_of_staff,GROUP_CONCAT(buf.validation_status) as validation_status');
    $this->db->from('bdcrm_uploaded_feildss buf'); }
    
    
    $user_id = $this->session->userdata('id');
    if(($designation_name=='Researcher')){
            $this->db->join('companywise_allocation ca','buf.id = ca.staff_id','left');
            $this->db->where('ca.reassigned_to',$user_id);
            $this->db->where('ca.status',1);
            $this->db->where('ca.is_final_submited',0);
            $this->db->where('ca.researcher_project_status',0);
            $this->db->where('ca.researcher_company_status',0);
    }else if($designation_name=='Caller')
    {
      $this->db->join('companywise_allocation ca','buf.id = ca.staff_id','left');
            $this->db->where('ca.reassigned_to',$user_id);
            $this->db->where('ca.status',1);
            $this->db->where('ca.is_final_submited',0);
            $this->db->where('ca.caller_project_status',0);
            $this->db->where('ca.caller_company_status',0);
    }
    else if($designation_name=='Caller Team Leader')
    {
      $this->db->join('companywise_allocation ca','buf.id = ca.staff_id','left');
      $this->db->join('bdcrm_master_projects bmp','bmp.id = ca.project_id','left');
      $this->db->join('users us','bmp.created_by = us.id','left');
        $where = '(ca.status IS NULL OR ca.status=1)  AND (us.designation = 8 OR us.designation = 14)';
        $this->db->where($where);
        
        $this->db->where('ca.status',1);
        $this->db->where('ca.is_final_submited',0);
        $this->db->where('ca.caller_project_status',0);
        $this->db->where('ca.caller_company_status',0);
    }
    else if($designation_name=='Researcher Team Leader')
    {
      $this->db->join('companywise_allocation ca','buf.id = ca.staff_id','left');
      $this->db->join('bdcrm_master_projects bmp','bmp.id = ca.project_id','left');
      $this->db->join('users us','bmp.created_by = us.id','left');
        $where = '(ca.status IS NULL OR ca.status=1)  AND (us.designation = 8 OR us.designation = 13)';
        $this->db->where($where);
        
        $this->db->where('ca.status',1);
        $this->db->where('ca.is_final_submited',0);
        $this->db->where('ca.caller_project_status',0);
        $this->db->where('ca.caller_company_status',0);
    }
    $this->db->where('buf.project_id',$project_id);
    $querys=$this->db->get();
    return $datas =  $querys->row_array();
}


function get_project_input_fields($project_id)
{
$this->db->select('bdcrm_master_projects_fields.field_id,bdcrm_feilds.label_name,bdcrm_feilds.input_name');
$this->db->from('bdcrm_master_projects_fields');
$this->db->join('bdcrm_feilds','bdcrm_feilds.id=bdcrm_master_projects_fields.field_id','left');
$this->db->where('bdcrm_master_projects_fields.project_id',$project_id);    
$this->db->group_by('bdcrm_master_projects_fields.id');
$this->db->order_by('bdcrm_master_projects_fields.id');
$query=$this->db->get();

$data=$query->result_array();
foreach($data as $data_key =>$data_val)
{
    $fdata[]=$data_val['input_name'];
   
}
//echo "<pre>";print_r($data);die();
return $fdata;
}



function get_no_staff_info($project_id="",$received_company_name="",$rowno="",$rowperpage="",$workstatus=""){
 $this->db->select('cmpallo.status as assigne_status,cmpallo.*,buf.*,bmp.project_name,bcn.name as country_name,bnp.prefix as salutation,CONCAT(us.first_name," ",us.last_name) as assigned_to,users.username,md.designation_name');
$this->db->from('bdcrm_uploaded_feildss as buf');
$this->db->join('bdcrm_master_projects bmp','buf.project_id = bmp.id','left');
$this->db->join('bdcrm_countries bcn','buf.provided_country = bcn.id','left');
$this->db->join('bdcrm_name_prefix bnp','buf.suffix = bnp.id','left');
$this->db->join('companywise_allocation cmpallo','buf.id = cmpallo.staff_id','left');
$this->db->join('users users','cmpallo.assigned_by=users.id','left');
$this->db->join('users us','cmpallo.reassigned_to=us.id','left');
$this->db->join('master_designation md','md.id=users.designation','left');
$this->db->where('buf.project_id',$project_id);
$this->db->where('buf.received_company_name',$received_company_name);
$this->db->where('bmp.status',1);
$this->db->where('bmp.id',$project_id);

if($this->session->userdata('designation_id') != 8)
{
    $this->db->where('users.designation',$this->session->userdata('designation_id'));  
}
if($workstatus==1)
{
    $this->db->where('cmpallo.assigned_by !=""');  
}
elseif($workstatus==2){
    $this->db->where('cmpallo.assigned_by IS NULL');   
}
$this->db->limit($rowperpage,$rowno);
$this->db->group_by('buf.id');
$query=$this->db->get();
$result = $query->row_array();

return $result;
}

function get_all_staff_info($project_id="",$received_company_name="",$rowno="",$rowperpage="",$workstatus=""){
 $this->db->select('cmpallo.status as assigne_status,cmpallo.*,buf.*,bmp.project_name,bcn.name as country_name,bnp.prefix as salutation,CONCAT(us.first_name," ",us.last_name) as assigned_to,users.username,md.designation_name');
$this->db->from('bdcrm_uploaded_feildss as buf');
$this->db->join('bdcrm_master_projects bmp','buf.project_id = bmp.id','left');
$this->db->join('bdcrm_countries bcn','buf.provided_country = bcn.id','left');
$this->db->join('bdcrm_name_prefix bnp','buf.suffix = bnp.id','left');
$this->db->join('companywise_allocation cmpallo','buf.id = cmpallo.staff_id','left');
$this->db->join('users users','cmpallo.assigned_by=users.id','left');
$this->db->join('users us','cmpallo.reassigned_to=us.id','left');
$this->db->join('master_designation md','md.id=users.designation','left');
$this->db->where('buf.project_id',$project_id);
$this->db->where('buf.received_company_name',$received_company_name);
$this->db->where('bmp.status',1);
$this->db->where('bmp.id',$project_id);

if($this->session->userdata('designation_id') != 8)
{
    $this->db->where('users.designation',$this->session->userdata('designation_id'));  
}
if($workstatus==1)
{
    $this->db->where('cmpallo.assigned_by !=""');  
}
elseif($workstatus==2){
    $this->db->where('cmpallo.assigned_by IS NULL');   
}
$this->db->limit($rowperpage,$rowno);
$this->db->group_by('buf.id');
$query=$this->db->get();
return $this->db->count_all_results();     
}

function getProjectInfoById($project_id){
$sql ="SELECT GROUP_CONCAT(DISTINCT(bdcrm_uploaded_feildss.company_name)) as received_company_name,count(bdcrm_uploaded_feildss.company_name) as staff_count, count(bdcrm_uploaded_feildss.updated_status) as completed_updated_status, `bdcrm_uploaded_feildss`.`created_date`, GROUP_CONCAT(DISTINCT(bdcrm_uploaded_feildss.project_id)) as project_id, `bdcrm_uploaded_feildss`.`id`, `bdcrm_master_projects`.`project_name`,`bdcrm_uploaded_feildss`.`validation_status`, GROUP_CONCAT(bdcrm_uploaded_feildss.id) as bdcrm_uploaded_feildss_id,GROUP_CONCAT(bdcrm_uploaded_feildss.validation_status) as validation_status, GROUP_CONCAT(companywise_allocation.assigned_by) as assigned_by, CONCAT(users.first_name,' ',users.last_name) as user_name, COUNT(companywise_allocation.total_count) as total_count FROM `bdcrm_uploaded_feildss` LEFT JOIN `bdcrm_master_projects` ON `bdcrm_uploaded_feildss`.`project_id` = `bdcrm_master_projects`.`id`";
  $designation_name = $this->session->userdata('designation_name');
  $user_id = $this->session->userdata('id');


  if(($designation_name=='Researcher')){
    $sql.="LEFT JOIN `companywise_allocation` ON `bdcrm_uploaded_feildss`.`id` = `companywise_allocation`.`staff_id` LEFT JOIN `users` ON `companywise_allocation`.`reassigned_to` = `users`.`id` WHERE `bdcrm_master_projects`.`id` = '".$project_id."' AND   `companywise_allocation`.`reassigned_to` = '".$user_id."'  AND   `bdcrm_master_projects`.`status` = 1 AND   `companywise_allocation`.`researcher_company_status` = 0 AND `companywise_allocation`.`researcher_project_status` = 0";
  }
  else if($designation_name=='Caller')
  {
    $sql.="LEFT JOIN `companywise_allocation` ON `bdcrm_uploaded_feildss`.`id` = `companywise_allocation`.`staff_id` LEFT JOIN `users` ON `companywise_allocation`.`reassigned_to` = `users`.`id` WHERE `bdcrm_master_projects`.`id` = '".$project_id."' AND   `companywise_allocation`.`reassigned_to` = '".$user_id."'  AND   `bdcrm_master_projects`.`status` = 1 AND   `companywise_allocation`.`caller_company_status` = 0 AND `companywise_allocation`.`caller_project_status` = 0";
  }else if($designation_name=='Caller Team Leader' || $designation_name=='Researcher Team Leader')
  {
    $sql.="LEFT JOIN `companywise_allocation` ON `bdcrm_uploaded_feildss`.`id` = `companywise_allocation`.`staff_id` LEFT JOIN `users` ON `companywise_allocation`.`reassigned_to` = `users`.`id` WHERE `bdcrm_master_projects`.`id` = '".$project_id."'   AND   `bdcrm_master_projects`.`status` = 1  AND   `companywise_allocation`.`caller_company_status` = 0 AND `companywise_allocation`.`caller_project_status` = 0";
  }
  else
  {
    $sql.="LEFT JOIN `companywise_allocation` ON `bdcrm_uploaded_feildss`.`id` = `companywise_allocation`.`staff_id` LEFT JOIN `users` ON `companywise_allocation`.`reassigned_to` = `users`.`id` WHERE `bdcrm_master_projects`.`id` = '".$project_id."' AND `bdcrm_master_projects`.`status` = 1";
  }

$sql.=" GROUP BY `bdcrm_uploaded_feildss`.`company_name`";

$query = $this->db->query($sql);
return $data =  $query->result_array();


}

function getProjectInfo($filter,$project_id="",$records_count,$status,$user_idss){
$sql ="SELECT GROUP_CONCAT(DISTINCT(bdcrm_uploaded_feildss.company_name )) as received_company_name,count(bdcrm_uploaded_feildss.company_name) as staff_count, count(bdcrm_uploaded_feildss.updated_status) as completed_updated_status, `bdcrm_uploaded_feildss`.`created_date`, GROUP_CONCAT(DISTINCT(bdcrm_uploaded_feildss.project_id)) as project_id, `bdcrm_uploaded_feildss`.`id`, `bdcrm_master_projects`.`project_name`, GROUP_CONCAT(bdcrm_uploaded_feildss.id) as bdcrm_uploaded_feildss_id, GROUP_CONCAT(companywise_allocation.assigned_by) as assigned_by, CONCAT(users.first_name,' ',users.last_name) as user_name,GROUP_CONCAT(bdcrm_uploaded_feildss.validation_status) as validation_status, COUNT(companywise_allocation.total_count) as total_count FROM `bdcrm_uploaded_feildss` LEFT JOIN `bdcrm_master_projects` ON `bdcrm_uploaded_feildss`.`project_id` = `bdcrm_master_projects`.`id` LEFT JOIN `companywise_allocation` ON `bdcrm_uploaded_feildss`.`id` = `companywise_allocation`.`staff_id` LEFT JOIN `users` ON `companywise_allocation`.`reassigned_to` = `users`.`id` WHERE `bdcrm_master_projects`.`id` = '".$project_id."' AND `bdcrm_master_projects`.`status` = 1";
  $designation_name = $this->session->userdata('designation_name');
  $user_id = $this->session->userdata('id');
  if(($designation_name=='Researcher') || $designation_name=='Caller'){
    $sql.="LEFT JOIN `users` ON `companywise_allocation`.`reassigned_to` = '".$user_id."' WHERE `bdcrm_master_projects`.`id` = '".$project_id."' AND `bdcrm_master_projects`.`status` = 1";
  }

if($filter != '')
{
    $sql.=' AND'.'('.$filter.')';
}


 if($status=="Assigned"){
    $sql .= ' AND companywise_allocation.assigned_by !=""';
}
 if($status=="Unassigned"){
    $sql .= ' AND companywise_allocation.assigned_by IS NULL';
}
elseif($status=="Pending"){
    $sql .= ' AND companywise_allocation.is_final_submited=0';
}else{

}

 if(!empty($user_idss) && $designation_name=="Superadmin"){
    $sql .= ' AND companywise_allocation.reassigned_to='.$user_idss;
}

$sql.=" GROUP BY `bdcrm_uploaded_feildss`.`company_name`"; 
if($records_count!=''){
    $sql .= 'LIMIT '. $records_count;
}

$query = $this->db->query($sql);
return $data =  $query->result_array();

}

function getProjectInfo1($filter,$project_id="",$records_count,$status,$user_idss){

// echo $project_id; die;
$sql ="SELECT GROUP_CONCAT(DISTINCT(bdcrm_uploaded_feildss.company_name)) as received_company_name,count(bdcrm_uploaded_feildss.company_name) as staff_count, count(bdcrm_uploaded_feildss.updated_status) as completed_updated_status, `bdcrm_uploaded_feildss`.`created_date`, GROUP_CONCAT(DISTINCT(bdcrm_uploaded_feildss.project_id)) as project_id, `bdcrm_uploaded_feildss`.`id`, `bdcrm_master_projects`.`project_name`, GROUP_CONCAT(bdcrm_uploaded_feildss.id) as bdcrm_uploaded_feildss_id, GROUP_CONCAT(companywise_allocation.assigned_by) as assigned_by, CONCAT(users.first_name,' ',users.last_name) as user_name,GROUP_CONCAT(bdcrm_uploaded_feildss.validation_status) as validation_status, COUNT(companywise_allocation.total_count) as total_count FROM `bdcrm_uploaded_feildss` LEFT JOIN `bdcrm_master_projects` ON `bdcrm_uploaded_feildss`.`project_id` = `bdcrm_master_projects`.`id`";
  $designation_name = $this->session->userdata('designation_name');
  $user_id = $this->session->userdata('id');
  if($designation_name=='Superadmin')
  {
     $sql.="LEFT JOIN `companywise_allocation` ON `bdcrm_uploaded_feildss`.`id` = `companywise_allocation`.`staff_id` LEFT JOIN `users` ON `companywise_allocation`.`reassigned_to` = `users`.`id` WHERE  `bdcrm_master_projects`.`id` = '".$project_id."' AND `bdcrm_master_projects`.`status` = 1" ;
  }
  if(($designation_name=='Researcher') || $designation_name=='Caller'){
    $sql.="LEFT JOIN `users` ON `companywise_allocation`.`reassigned_to` = '".$user_id."' WHERE `bdcrm_master_projects`.`id` = '".$project_id."' AND `bdcrm_master_projects`.`status` = 1";
  }

if($filter != '')
{
    $sql.=' AND'.'('.$filter.')';
}


 if($status=="Assigned"){
    $sql .= ' AND companywise_allocation.assigned_by !=""';
}
 if($status=="Unassigned"){
    $sql .= ' AND companywise_allocation.assigned_by IS NULL';
}
elseif($status=="Pending"){
    $sql .= ' AND companywise_allocation.is_final_submited=0';
}else{

}

 if(!empty($user_idss) && $designation_name=="Superadmin"){
    $sql .= ' AND companywise_allocation.reassigned_to='.$user_idss;
}

$sql.=" GROUP BY `bdcrm_uploaded_feildss`.`company_name`"; 
if($records_count!=''){
    $sql .= 'LIMIT '. $records_count;
}

$query = $this->db->query($sql);
//echo $this->db->last_query(); die;
return $data =  $query->result_array();

}



function getProjectInfoByStaffId($pid,$sid){

$this->db->select('ca.user_id as assigned_to,ca.user_id as assigned_by,buf.*,buff.web_staff_disposition as main_staff_disposition,buf.voice_staff_disposition as main_voice_staff_disposition,bmp.project_name,bmp.project_breif,bdctry.name as countryname,bdctry.postal_code as postal_codes,bcd.company_dispostion as companydispostion,bi.Industries as industryname,bwd.web_disposition_name as webdispositionname,bcld.caller_disposition as voicedispositionname,bswd.dispositions as webstaffdis,bsvd.voice_dispositions as voicestaffdis,bpts.project_type as project_type,bpts.activity_type as activity_type,bpt.project_type as task_type,buf.activity_type as disposition_status');
$this->db->from('bdcrm_uploaded_feildss as buf');
$this->db->join('bdcrm_uploaded_feildss buff','buff.id = buf.has_replaced','left');
$this->db->join('bdcrm_master_projects bmp','buf.project_id = bmp.id','left');
$this->db->join('bdcrm_project_types bpts','bmp.project_type = bpts.id','left');
$this->db->join('bdcrm_project_type bpt','bmp.task_type = bpt.id','left');
$this->db->join('companywise_allocation ca','buf.id = ca.staff_id','left');
$this->db->join('bdcrm_countries bdctry','buf.country = bdctry.id','left');
$this->db->join('bdcrm_company_disposition bcd','buf.company_disposition = bcd.id','left');
$this->db->join('bdcrm_industries bi','buf.industry = bi.id','left');
$this->db->join('bdcrm_web_disposition bwd','buf.web_disposition = bwd.id','left');
$this->db->join('bdcrm_caller_disposition bcld','buf.voice_disposition = bcld.id','left');
$this->db->join('bdcrm_staff_web_disposition bswd','buf.web_staff_disposition=bswd.id','left');
$this->db->join('bdcrm_staff_voice_dispositions bsvd','buf.voice_staff_disposition=bsvd.id','left');
$this->db->where('buf.project_id',$pid);
$this->db->where('buf.id',$sid);
$this->db->where('bmp.status',1);
$where = "(ca.status IS NULL OR ca.status=1)";
$this->db->where($where);
$query=$this->db->get();
$data = $query->result_array();
$info = $this->getCompanyInfoByProjectId($pid);
//$replacedcount = $this->getreplacedcounter($pid,$data[0]['web_staff_disposition'],$data[0]['id']);
$data[0]['company_count']=$info['company_count'];
$data[0]['no_of_staff']=$info['no_of_staff'];
return $data;
}

// function getreplacedcounter($project_id,$web_staff_disposition,$staff_id){
//      $designation_name = $this->session->userdata('designation_name');

//          if($web_staff_disposition == 6)
//          {
//              $sql="SELECT COUNT(DISTINCT buf.has_replaced) as noresult_count FROM `bdcrm_uploaded_feildss` `buf` WHERE `buf`.`project_id` = '".$project_id."' AND `buf`.`web_staff_disposition` ='5' AND `buf`.`has_replaced` = '".$staff_id."' ";
        
//          }
//          else if($web_staff_disposition == 3)
//          {
//              $sql="SELECT COUNT(DISTINCT buf.has_replaced) as added_count FROM `bdcrm_uploaded_feildss` `buf` WHERE `buf`.`project_id` = '".$project_id."' AND `buf`.`web_staff_disposition` ='5' AND `buf`.`has_replaced` = '".$staff_id."' ";
//          }
//          $query = $this->db->query($sql);
//          return $data =  $query->result_array();
//          print_r($data);die();
//          echo $this->db->last_query();die();
//  }

function getallocationdetails($project_id,$staff_id,$assigned_by){
$this->db->select('ca.*');
$this->db->from('companywise_allocation ca');
$this->db->where('project_id',$project_id);
if($this->session->userdata('designation_name') == "Caller Team Leader")
{
    $where = '(assigned_by = 1 OR assigned_by = 14) AND staff_id = '.$staff_id.' AND is_final_submited = 0';
}else if($this->session->userdata('designation_name') == "Researcher Team Leader"){

    $where = '(assigned_by = 1 OR assigned_by = 13) AND staff_id = '.$staff_id.' AND is_final_submited = 0';
}
else{
    $where = 'assigned_by = 1 AND staff_id = '.$staff_id.' AND is_final_submited = 0';
}
$this->db->where($where);
$querys=$this->db->get();
// echo $this->db->last_query();die();
return $datas =  $querys->result_array();

}
function getCompanyInfoDetails($project_id,$cmp_name){
  $designation_name = $this->session->userdata('designation_name');
$user_id = $this->session->userdata('id');
$this->db->select('bmp.*,bmap.project_name,GROUP_CONCAT(DISTINCT(buf.company_name)) as received_company_name,count(bmp.id) as staffcount,buf.updated_status,count(buf.received_company_name) as staffcount,buf.project_id,buf.id');
// $this->db->distinct('received_company_name');
$this->db->from('bdcrm_uploaded_feildss buf');
$this->db->join('bdcrm_company_disposition bmp','buf.company_disposition = bmp.id','left');
$this->db->join('bdcrm_master_projects bmap','buf.project_id = bmap.id','left');
$this->db->join('bdcrm_staff_web_disposition bswd','buf.web_staff_disposition=bswd.id','left');
$this->db->join('bdcrm_staff_voice_dispositions bsvd','buf.voice_staff_disposition=bsvd.id','left'); 

  if(($designation_name=='Researcher')){
     $this->db->join('companywise_allocation ca','buf.id = ca.staff_id','left');
     $this->db->where('ca.reassigned_to',$user_id);
     $this->db->where('ca.status',1);
      $this->db->where('ca.is_final_submited',0);
     $this->db->where('ca.researcher_project_status',0);
     $this->db->where('ca.researcher_company_status',0);
     $where = '(ca.status IS NULL OR ca.status=1)';
     $this->db->where($where);
  }else if($designation_name=='Caller'){
    $this->db->join('companywise_allocation ca','buf.id = ca.staff_id','left');
     $this->db->where('ca.reassigned_to',$user_id);
     $this->db->where('ca.status',1);
      $this->db->where('ca.is_final_submited',0);
     $this->db->where('ca.caller_project_status',0);
     $this->db->where('ca.caller_company_status',0);
     $where = '(ca.status IS NULL OR ca.status=1)';
     $this->db->where($where); 
  }
$this->db->where('buf.project_id',$project_id);
// $this->db->where('received_company_name',$cmp_name);
$this->db->group_by('buf.company_name');
$querys=$this->db->get();
return $datas =  $querys->result_array();
}
function getStaffInfoDetails($project_id,$company_name){
$designation_name = $this->session->userdata('designation_name');
  $user_id = $this->session->userdata('id');
$this->db->select('bmp.*,buf.first_name,buf.last_name,buf.has_replaced,buf.caller_has_replaced,buf.updated_status,buf.company_name as comp_name,buf.project_id,buf.id,bswd.dispositions,bsvd.id as vdid,bsvd.voice_dispositions,bmps.project_type,buf.validation_status,bc.name as country_name,buf.activity_type');
$this->db->from('bdcrm_uploaded_feildss buf');
$this->db->join('bdcrm_company_disposition bmp','buf.company_disposition = bmp.id','left');  
$this->db->join('bdcrm_staff_web_disposition bswd','buf.web_staff_disposition=bswd.id','left');
$this->db->join('bdcrm_staff_voice_dispositions bsvd','buf.voice_staff_disposition=bsvd.id','left');  
 $this->db->join('bdcrm_master_projects bmps','buf.project_id=bmps.id','left');  
  $this->db->join('bdcrm_countries bc','buf.country=bc.id','left');       
  if(($designation_name=='Researcher')){
     $this->db->join('companywise_allocation ca','buf.id = ca.staff_id','left');
     $this->db->where('ca.reassigned_to',$user_id);
     $this->db->where('ca.status',1);
     $this->db->where('ca.is_final_submited',0);
     $this->db->where('ca.researcher_project_status',0);
      $this->db->where('ca.researcher_company_status',0);
     $where = '(ca.status IS NULL OR ca.status=1)';
     $this->db->where($where);
  }else if($designation_name=='Caller')
  {
    $this->db->join('companywise_allocation ca','buf.id = ca.staff_id','left');
    $this->db->where('ca.reassigned_to',$user_id);
    $this->db->where('ca.status',1);
    $this->db->where('ca.is_final_submited',0);
    $this->db->where('ca.caller_project_status',0);
     $this->db->where('ca.caller_company_status',0);
    $where = '(ca.status IS NULL OR ca.status=1)';
    $this->db->where($where);
  }

$this->db->where('buf.project_id',$project_id);
$this->db->where('buf.company_name',$company_name);   
$this->db->order_by("bc.name");
$querys=$this->db->get();
//echo $this->db->last_query();die();
$datas =  $querys->result_array();
foreach($datas as $data_key =>$data_val)
{
    if(!empty($data_val['has_replaced']))
    {
        $has_replaced=$this->model->selectWhereData('bdcrm_uploaded_feildss',array('id'=>$data_val['has_replaced']),array('first_name','last_name'));
        $has_replaced_val=$has_replaced['first_name'].' '.$has_replaced['last_name'];
      
    } 
    else{
        $has_replaced_val='';
    }

    if(!empty($data_val['caller_has_replaced']))
    {
        $caller_has_replaced=$this->model->selectWhereData('bdcrm_uploaded_feildss',array('id'=>$data_val['caller_has_replaced']),array('first_name','last_name'));
        $caller_has_replaced_val=$caller_has_replaced['first_name'].' '.$caller_has_replaced['last_name'];
      
    } else{
        $caller_has_replaced_val='';
    }
    $datas[$data_key]['replaced_by']=$has_replaced_val;
    $datas[$data_key]['caller_has_replaced']=$caller_has_replaced_val;
}
return $datas;
}

function getAllStaffInfoDetails($project_id){
 $this->db->select('bmp.*,buf.first_name,buf.last_name,buf.updated_status,buf.company_name as comp_name,buf.project_id,buf.id,bswd.dispositions,bsvd.voice_dispositions,bmps.project_type,buf.validation_status,bc.name as country_name');
$this->db->from('bdcrm_uploaded_feildss buf');
$this->db->join('bdcrm_company_disposition bmp','buf.company_disposition = bmp.id','left');
$this->db->join('bdcrm_staff_web_disposition bswd','buf.web_staff_disposition=bswd.id','left');
$this->db->join('bdcrm_staff_voice_dispositions bsvd','buf.voice_staff_disposition=bsvd.id','left');
$this->db->join('bdcrm_master_projects bmps','buf.project_id=bmps.id','left');
$this->db->join('bdcrm_countries bc','buf.country=bc.id','left');

  $designation_name = $this->session->userdata('designation_name');
  $user_id = $this->session->userdata('id');
  if(($designation_name=='Researcher')){
     $this->db->join('companywise_allocation ca','buf.id = ca.staff_id','left');
     $this->db->where('ca.reassigned_to',$user_id);
     $this->db->where('ca.status',1);
     $this->db->where('ca.is_final_submited',0);
     $this->db->where('ca.researcher_project_status',0);
     $this->db->where('ca.researcher_company_status',0);
     $where = '(ca.status IS NULL OR ca.status=1)';
     $this->db->where($where);
  }
  else if($designation_name=='Caller'){
    $this->db->join('companywise_allocation ca','buf.id = ca.staff_id','left');
     $this->db->where('ca.reassigned_to',$user_id);
     $this->db->where('ca.status',1);
      $this->db->where('ca.is_final_submited',0);
     $this->db->where('ca.caller_project_status',0);
     $this->db->where('ca.caller_company_status',0);
     $where = '(ca.status IS NULL OR ca.status=1)';
     $this->db->where($where); 
  }
 
$this->db->where('buf.project_id',$project_id);
$this->db->order_by("bc.name");
// $this->db->where('buf.received_company_name',$company_name);  
$querys=$this->db->get();
return $datas =  $querys->result_array();
}

function getPreLastInfo($project_id="",$rowid="",$cmp_name=""){
    $this->db->select('min(bdcrm_uploaded_feildss.id) as myfirst,max(bdcrm_uploaded_feildss.id) as mylast,bdcrm_uploaded_feildss.project_id,bdcrm_uploaded_feildss.received_company_name');
    $this->db->from('bdcrm_uploaded_feildss');
    $designation_name = $this->session->userdata('designation_name');
  $user_id = $this->session->userdata('id');
  if(($designation_name=='Researcher')){
     $this->db->join('companywise_allocation ca','bdcrm_uploaded_feildss.id = ca.staff_id','left');
     $this->db->where('ca.reassigned_to',$user_id);
     $this->db->where('ca.status',1);
     $this->db->where('ca.researcher_company_status',0);
     $where = '(ca.status IS NULL OR ca.status=1)';
     // $this->db->where($where);
  }
  else if($designation_name=='Caller'){
    $this->db->join('companywise_allocation ca','bdcrm_uploaded_feildss.id = ca.staff_id','left');
     $this->db->where('ca.reassigned_to',$user_id);
     $this->db->where('ca.status',1);
     $this->db->where('ca.caller_company_status',0);
     $where = '(ca.status IS NULL OR ca.status=1)';
  }
    $this->db->where('bdcrm_uploaded_feildss.project_id',$project_id);
    // $this->db->where('received_company_name',$cmp_name);
    $querys=$this->db->get();
    //echo $this->db->last_query();die();
    return $datas =  $querys->row_array();  
}

function excel_download($project_id="")
{

$sql = "SELECT buf.id as staff_id,buf.time_zone,buf.ca1,buf.ca2,buf.sa1,buf.sa2,buf.sa3,buf.sa4,buf.sa5,buf.received_company_name,buf.company_name,buf.postal_code,buf.alternate_number,buf.website_url,buf.address_url,buf.provided_staff_email,buf.staff_email,buf.address1,buf.address2,buf.address3,
buf.city,buf.postal_code,buf.state_county,buf.state_county,bc.name as provided_country,bcc.name as updated_country,bcc.region as region,buf.country_code,buf.address_souce_url,buf.no_of_emp,bi.Industries as industry_type,buf.revenue,bcd.company_dispostion,bwd.web_disposition_name as company_web_disposition,
bccd.caller_disposition as company_voice_disposition,buf.genaral_note,bnp.prefix,buf.first_name,buf.last_name,buf.tel_number,
buf.provided_job_title as provided_job_title,buf.updated_job_title as updated_job_title,buf.activity_type,buf.staff_job_function as job_function,buf.staff_email,
buf.staff_department,buf.staff_url as staff_source_url,buf.assumed_email,buf.staff_email_harvesting as email_source_url,buf.staff_direct_tel,
buf.staff_mobile,bswd.dispositions as web_staff_disposition,bsvd.voice_dispositions as caller_staff_disposition,buf.staff_linkedin_con,
buf.staff_note,buf.research_remark,buf.voice_remark,buf.researcher_company_note,buf.caller_company_note,buf.has_replaced,buf.has_replaced1,
buf.caller_has_replaced,buf.caller_has_replaced1,buf.created_date,buf.updated_at,CONCAT(us.first_name,' ',us.last_name) as updated_by,GROUP_CONCAT(ca.reassigned_to) as reassigned_to,GROUP_CONCAT(ca.assigned_by) as assigned_by_date,ca.assigned_at,bmp.project_name,buf.provided_direct_tel
FROM `bdcrm_uploaded_feildss` as buf
Left join bdcrm_master_projects as bmp on buf.project_id = bmp.id
left join bdcrm_countries as bc on buf.provided_country = bc.id
left join bdcrm_countries as bcc on buf.country= bcc.id
left join bdcrm_industries as bi on buf.industry = bi.id
left join bdcrm_company_disposition as bcd on buf.company_disposition = bcd.id
left join bdcrm_web_disposition as bwd on buf.web_disposition=bwd.id
left join bdcrm_caller_disposition as bccd on buf.voice_disposition = bccd.id
left JOIN bdcrm_name_prefix as bnp on buf.suffix = bnp.id
left join bdcrm_staff_web_disposition as bswd on buf.web_staff_disposition = bswd.id
left join bdcrm_staff_voice_dispositions as bsvd on buf.voice_staff_disposition = bsvd.id
left JOIN users as us on buf.updated_by = us.id
left JOIN companywise_allocation as ca on buf.id=ca.staff_id
WHERE buf.project_id = $project_id";

$designation_name = $this->session->userdata('designation_name');
if($designation_name=="Caller"){
     $user_id = $this->session->userdata('id');
    $sql .=" AND ca.reassigned_to='".$user_id."'";
}

$sql .=" GROUP by buf.id";

$queryss = $this->db->query($sql);
//echo $this->db->last_query();die();
$data=  $queryss->result_array();

 foreach($data as $total_key => $total_val)
{
    $follow_up_date=$this->getFollowupdate($total_val['staff_id'],$project_id);
    $last_remark=$this->getlastremark($total_val['staff_id']);
    $data[$total_key]['follow_up_date'] =$follow_up_date;
    $data[$total_key]['caller_hist_remark'] =$last_remark[0];
    $data[$total_key]['caller_hist_remark_date'] =$last_remark[1];
    if(!empty($total_val['researcher_company_remark']))
    {
        $research_co_remark =$this->getResearcherInfoById($total_val['researcher_company_remark']);
        $data[$total_key]['researcher_company_remark'] =$research_co_remark;  
       
    }
    if(!empty($total_val['research_remark']))
    {
        $research_remark =$this->getResearcherRemarkById($total_val['research_remark']);
        $data[$total_key]['research_remark'] =$research_remark;   
    }
    if(!empty($total_val['caller_company_remark']))
    {
        $caller_co_remark =$this->getCallerCoRemarkById($total_val['caller_company_remark']);
        $data[$total_key]['caller_company_remark'] =$caller_co_remark;   
    }
    if(!empty($total_val['voice_remark']))
    {
        $caller_remark =$this->getCallerRemarkById($total_val['voice_remark']);
        $data[$total_key]['voice_remark'] =$caller_remark;   
    }
    if(!empty($total_val['reassigned_to']))
    {
        $reassigned_to =$this->getAssignedToById($total_val['reassigned_to']);
        $data[$total_key]['reassigned_to'] =$reassigned_to;  
       
    }
    if(!empty($total_val['assigned_by_date']))
    {
        $reassigned_to =$this->getAssignedToById($total_val['assigned_by_date']);
        $data[$total_key]['assigned_by_date'] =$reassigned_to;  
       
    }
    if(!empty($total_val['has_replaced1'] && $total_val['has_replaced']))
    {
        if($total_val['activity_type'] == 4)
        {
            $data[$total_key]['has_replaced']=$total_val['has_replaced'].'-'.$total_val['has_replaced1'];
        }else{
            $data[$total_key]['has_replaced']=$total_val['has_replaced'].'_'.$total_val['has_replaced1'];
        }
        
    }
    if(!empty($total_val['caller_has_replaced1'] && $total_val['caller_has_replaced']))
    {
        if($total_val['activity_type'] == 4)
        { 
            $data[$total_key]['caller_has_replaced']=$total_val['caller_has_replaced'].'-'.$total_val['caller_has_replaced1']; 
        }else{
           
            $data[$total_key]['caller_has_replaced']=$total_val['caller_has_replaced'].'_'.$total_val['caller_has_replaced1']; 
        }
    }
}
return $data;
}

public function getFollowupdate($staff_id,$project_id)
{
$this->db->select("*");
$this->db->from('followup_date_history');
$this->db->where('staff_id',$staff_id);
$this->db->where('project_id',$project_id);
$this->db->group_by('id');
$this->db->order_by('id',"DESC");
$this->db->limit(1);
$query = $this->db->get();
$result = $query->result_array();
$fdh=$result[0]['date_time'];
return $fdh;
}

public function getlastremark($staff_id)
{
$this->db->select("*");
$this->db->from('caller_history');
$this->db->where('staff_id',$staff_id);
$this->db->group_by('id');
$this->db->order_by('id',"DESC");
$this->db->limit(1);
$query = $this->db->get();
$result = $query->result_array();
$fdh1[]=$result[0]['caller_remark'];
$fdh1[]=$result[0]['created_at'];
return $fdh1;
}

// function excel_download($project_id="")
//    {

//        $sql = "SELECT buf.id, buf.received_company_name,buf.company_name,buf.postal_code,buf.alternate_number,buf.website_url,buf.address_url,buf.provided_staff_email,buf.staff_email,buf.address1,buf.address2,buf.address3,
//        buf.city,buf.postal_code,buf.state_county,buf.state_county,bc.name as provided_country,bcc.name as updated_country,bcc.region as region,buf.country_code,buf.address_souce_url,buf.no_of_emp,bi.Industries as industry_type,buf.revenue,bcd.company_dispostion,bwd.web_disposition_name as company_web_disposition,
//        bccd.caller_disposition as company_voice_disposition,buf.genaral_note,bnp.prefix,buf.first_name,buf.last_name,
//        buf.provided_job_title as job_title,buf.staff_job_function as job_function,buf.staff_email,
//        buf.staff_department,buf.staff_url as staff_source_url,buf.assumed_email,buf.staff_email_harvesting as email_source_url,buf.staff_direct_tel,
//        buf.staff_mobile,bswd.dispositions as web_staff_disposition,bsvd.voice_dispositions as caller_staff_disposition,buf.staff_linkedin_con,
//        buf.staff_note,buf.research_remark,buf.voice_remark,buf.researcher_company_remark,buf.caller_company_remark,buf.researcher_company_note,buf.caller_company_note,buf.has_replaced,
//        buf.caller_has_replaced,buf.created_date,buf.updated_at,CONCAT(us.first_name,' ',us.last_name) as updated_by,bmp.project_name
//        FROM `bdcrm_uploaded_feildss` as buf
//        Left join bdcrm_master_projects as bmp on buf.project_id = bmp.id
//        left join bdcrm_countries as bc on buf.provided_country = bc.id
//        left join bdcrm_countries as bcc on buf.country= bcc.id
//        left join bdcrm_industries as bi on buf.industry = bi.id
//        left join bdcrm_company_disposition as bcd on buf.company_disposition = bcd.id
//        left join bdcrm_web_disposition as bwd on buf.web_disposition
//        left join bdcrm_caller_disposition as bccd on buf.voice_disposition = bccd.id
//        left JOIN bdcrm_name_prefix as bnp on buf.suffix = bnp.id
//        left join bdcrm_staff_web_disposition as bswd on buf.web_staff_disposition = bswd.id
//        left join bdcrm_staff_voice_dispositions as bsvd on buf.voice_staff_disposition = bsvd.id
//        left JOIN users as us on buf.updated_by = us.id
//        WHERE buf.project_id = $project_id";

//        $queryss = $this->db->query($sql);
//        $data=  $queryss->result_array();

//         foreach($data as $total_key => $total_val)
//        {
//            if(!empty($total_val['researcher_company_remark']))
//            {
//                $research_co_remark =$this->getResearcherInfoById($total_val['researcher_company_remark']);
//                $data[$total_key]['researcher_company_remark'] =$research_co_remark;  
       
//            }
//            if(!empty($total_val['research_remark']))
//            {
//                $research_remark =$this->getResearcherRemarkById($total_val['research_remark']);
//                $data[$total_key]['research_remark'] =$research_remark;   
//            }
//            if(!empty($total_val['caller_company_remark']))
//            {
//                $caller_co_remark =$this->getCallerCoRemarkById($total_val['caller_company_remark']);
//                $data[$total_key]['caller_company_remark'] =$caller_co_remark;   
//            }
//            if(!empty($total_val['voice_remark']))
//            {
//                $caller_remark =$this->getCallerRemarkById($total_val['voice_remark']);
//                $data[$total_key]['voice_remark'] =$caller_remark;   
//            }

//        }

//        return $data;
//    }

public function getResearcherInfoById($reseracher_id)
{
$this->db->select("*");
$this->db->from('bdcrm_company_remark');

$this->db->where_in('id',$reseracher_id,false);

$query = $this->db->get();

$result = $query->result_array();
$count='';
foreach($result as $result_key => $result_val)
{
    $count .= $result_val['company_remark'].',';
}

return rtrim($count," ,");
}

public function getResearcherRemarkById($reseracher_remarker)
{
$this->db->select("*");
$this->db->from('bdcrm_researcher_remark');

$this->db->where_in('id',$reseracher_remarker,false);

$query = $this->db->get();
$result = $query->result_array();
$count='';
foreach($result as $result_key => $result_val)
{
    $count .= $result_val['researcher_remark'].',';
}

return rtrim($count," ,");
}

public function getCallerCoRemarkById($caller_co_remarker)
{
$this->db->select("*");
$this->db->from('bdcrm_company_remark');

$this->db->where_in('id',$caller_co_remarker,false);

$query = $this->db->get();

$result = $query->result_array();
$count='';
foreach($result as $result_key => $result_val)
{
    $count .= $result_val['company_remark'].',';
}

return rtrim($count," ,");
}

public function getCallerRemarkById($caller_remarker)
{
$this->db->select("*");
$this->db->from('bdcrm_company_remark');

$this->db->where_in('id',$caller_remarker,false);

$query = $this->db->get();

$result = $query->result_array();
$count='';
foreach($result as $result_key => $result_val)
{
    $count .= $result_val['caller_remark'].',';
}

return rtrim($count," ,");
}

public function getAssignedToById($reassigned_to)
{
$this->db->select("*");
$this->db->from('users');

$this->db->where_in('id',$reassigned_to,false);

$query = $this->db->get();

$result = $query->result_array();
$count='';
foreach($result as $result_key => $result_val)
{
    $count .= $result_val['first_name'].' '.$result_val['last_name'].',';
}

return rtrim($count," ,");
}

function getautocompleteofdata($search_term, $tablename, $field_name){
if($this->db->table_exists($tablename)){
    $this->db->select("*");
    $this->db->from($tablename);

    $this->db->like("LOWER(".$field_name.")", $search_term, 'after');
   
    $this->db->group_by($field_name);
    $query = $this->db->get();
    //echo $this->db->last_query();die();
    $result = $query->result_array();
}else{
    $result = array();
}
return $result;
}


function get_final_submit_record($project_id,$user_id){
$this->db->select('ca.*,buf.validation_status');
$this->db->from('companywise_allocation ca');
$this->db->join('bdcrm_uploaded_feildss buf','ca.staff_id = buf.id','left');
$this->db->where('ca.project_id',$project_id);
$this->db->where('ca.reassigned_to',$user_id);
$this->db->where('ca.status','1');
//$this->db->where('ca.researcher_company_status',0);
//$this->db->where('ca.researcher_project_status',0);
$this->db->where('buf.updated_status',0);
$querys=$this->db->get();
//echo $this->db->last_query();die();
return $datas =  $querys->result_array();
}

function get_completed_count($project_id,$user_id){
$this->db->select('ca.*,COUNT(buf.updated_status)');
$this->db->from('companywise_allocation ca');
$this->db->join('bdcrm_uploaded_feildss buf','ca.staff_id = buf.id','left');
$this->db->where('ca.project_id',$project_id);
$this->db->where('ca.reassigned_to',$user_id);
$this->db->where('ca.status','1');
$this->db->where('buf.updated_status','Updated');
$querys=$this->db->get();
//echo $this->db->last_query();die();
return $datas =  $querys->result_array();
}




public function get_master_record($tablename)
{

if(trim($tablename) == 'bdcrm_company_disposition')
{
    $this->db->select('id,company_dispostion as disposition');
    $this->db->from($tablename);
    $this->db->where('status','1');
    $querys=$this->db->get();
    return $datas =  $querys->result_array();
}
else if(trim($tablename) == 'bdcrm_web_disposition')
{
    $this->db->select('id,web_disposition_name as disposition');
    $this->db->from($tablename);
    $this->db->where('status','1');
    $querys=$this->db->get();
    return $datas =  $querys->result_array();
}
else if(trim($tablename) == 'bdcrm_caller_disposition')
{
    $this->db->select('id,caller_disposition as disposition');
    $this->db->from($tablename);
    $this->db->where('status','1');
    $querys=$this->db->get();
    return $datas =  $querys->result_array();
}
else if(trim($tablename) == 'bdcrm_countries')
{
    $this->db->select('id,name as disposition');
    $this->db->from($tablename);
    $this->db->where('status','1');
    $this->db->order_by("name");
    $querys=$this->db->get();
    return $datas =  $querys->result_array();
}
else if(trim($tablename) == 'bdcrm_industries')
{
    $this->db->select('id,Industries as disposition');
    $this->db->from($tablename);
    $this->db->where('status','1');
    $querys=$this->db->get();
    return $datas =  $querys->result_array();
}
else if(trim($tablename) == 'bdcrm_staff_web_disposition')
{
    
    $this->db->select('id,dispositions as disposition');
    $this->db->from($tablename);
    $this->db->where('status','1');
    $querys=$this->db->get();
    return $datas =  $querys->result_array();
}
else if(trim($tablename) == 'bdcrm_staff_voice_dispositions')
{
    $this->db->select('id,voice_dispositions as disposition');
    $this->db->from($tablename);
    $this->db->where('status','1');
    $querys=$this->db->get();
    return $datas =  $querys->result_array();
}
}


// function get_completed_count($project_id="",$user_id=""){
//     $this->db->select('count(buf.updated_status) as total_count');
//     $this->db->from('bdcrm_uploaded_feildss as buf');
//     $this->db->join('companywise_allocation','buf.id = companywise_allocation.staff_id','left');
//     $this->db->join('users','companywise_allocation.user_id = users.id','left');
//     $this->db->where('bmp.id',$project_id);
//     $this->db->where('bmp.status',1);
//       $designation_name = $this->session->userdata('designation_name');
//       $user_id = $this->session->userdata('id');
//       if(($designation_name=='Researcher') || $designation_name=='Caller'){
//          $this->db->where('companywise_allocation.user_id',$user_id);
//          $this->db->where('companywise_allocation.status',1);
//       }

//     $this->db->group_by('buf.received_company_name');
//     $query=$this->db->get();
//     echo $this->db->last_query();die();
//     return $data = $query->result_array();
// }

// Stafff Managemnet Started by Raj 


function get_staff_info($project_id="",$received_company_name="",$record_type="",$filter="",$user_ids=""){
// echo $user_ids; die;
$this->db->select('bmp.id as project_id,bmp.project_name,bmp.project_breif,buf.company_name,bin.Industries as industry,buf.provided_job_title,buf.city,buf.address1,
bc.name as country_name,buf.region,bswd.dispositions as web_staff_disposition,buf.provided_staff_email,bcd.company_dispostion as voice_disposition,bcalld.caller_disposition as company_voice_disp,bwd.web_disposition_name as web_disposition,buf.website_url,buf.no_of_emp,buf.revenue,bsvd.voice_dispositions as voice_staff_disposition,buf.id as staff_id,bnp.prefix as salutation,buf.first_name,buf.last_name,CONCAT(us.first_name,us.last_name) as assigned_to,CONCAT(usd.first_name,usd.last_name) as assigned_by,ca.status,buf.created_date,ca.assigned_at as assigned_at,buf.has_replaced,buf.activity_type');
$this->db->from('bdcrm_uploaded_feildss as buf');
$this->db->join('bdcrm_master_projects bmp','buf.project_id = bmp.id','left');
$this->db->join('bdcrm_countries bc','buf.country = bc.id','left');
$this->db->join('bdcrm_name_prefix bnp','buf.suffix = bnp.id','left');
$this->db->join('companywise_allocation ca','buf.id = ca.staff_id','left');
$this->db->join('users us','ca.reassigned_to=us.id','left');
$this->db->join('users usd','ca.assigned_by=usd.id','left');
$this->db->join('bdcrm_industries bin','buf.industry=bin.id','left');
$this->db->join('bdcrm_staff_web_disposition bswd','buf.web_staff_disposition=bswd.id','left');
$this->db->join('bdcrm_staff_voice_dispositions bsvd','buf.voice_staff_disposition=bsvd.id','left');
$this->db->join('bdcrm_company_disposition bcd','buf.company_disposition=bcd.id','left');
$this->db->join('bdcrm_caller_disposition bcalld','buf.voice_disposition=bcalld.id','left');
$this->db->join('bdcrm_web_disposition bwd','buf.web_disposition=bwd.id','left');
$where = '((ca.status IS NULL OR ca.status=1) AND (bmp.status=1))';
$this->db->where('buf.company_name',$received_company_name);
;
$designation_name = $this->session->userdata('designation_name');
$user_id = $this->session->userdata('id');
if(($designation_name=='Researcher') || $designation_name=='Caller'){
$this->db->where('ca.reassigned_to',$user_id);
}

if(!empty($filter)){
$where .= " AND ".$filter;
$this->db->where($where);
}else{

}
if($record_type=='Assigned')
{
 $this->db->where('ca.assigned_by !=""');
}
else if($record_type=='Unassigned'){
 $this->db->where('ca.assigned_by IS NULL');
}else{

}


if(!empty($user_ids) && $designation_name=='Superadmin')
{
 $this->db->where('ca.reassigned_to',$user_ids);
}
$this->db->where('bmp.id',$project_id);
$this->db->group_by('buf.id');
$query=$this->db->get();
//echo $this->db->last_query(); die;
return $data = $query->result_array();

}

//function get_staff_info1($limit,$start){
function get_staff_info1(){
if($this->session->userdata('designation_id') == 1 || $this->session->userdata('designation_id') == 14 || $this->session->userdata('designation_id') == 8){
$this->db->select('bmp.id as project_id,bmp.project_name,bmp.project_breif,buf.company_name,bin.Industries as industry,buf.provided_job_title,buf.city,buf.address1,
bc.name as country_name,buf.region,bswd.dispositions as web_staff_disposition,buf.provided_staff_email,bcd.company_dispostion as voice_disposition,bcalld.caller_disposition as company_voice_disp,bwd.web_disposition_name as web_disposition,buf.website_url,buf.provided_direct_tel,buf.tel_number,buf.staff_direct_tel,buf.staff_mobile,buf.no_of_emp,buf.revenue,bsvd.voice_dispositions as voice_staff_disposition,buf.id as staff_id,bnp.prefix as salutation,buf.first_name,buf.last_name,CONCAT(us.first_name,us.last_name) as assigned_to,CONCAT(usd.first_name,usd.last_name) as assigned_by,ca.created_at as assigned_at,buf.created_date,buf.updated_at,buf.has_replaced,buf.activity_type,buf.sa1,buf.sa2,buf.sa3,buf.sa4,buf.sa5,buf.address1');
$this->db->from('bdcrm_uploaded_feildss as buf');
$this->db->join('bdcrm_master_projects bmp','buf.project_id = bmp.id','left');
$this->db->join('bdcrm_countries bc','buf.country = bc.id','left');
$this->db->join('bdcrm_name_prefix bnp','buf.suffix = bnp.id','left');
 $this->db->join('companywise_allocation ca','buf.id = ca.staff_id','left');
$this->db->join('users us','ca.reassigned_to=us.id','left');
$this->db->join('users usd','ca.assigned_by=usd.id','left');


}


if($this->session->userdata('designation_id') == 6 || $this->session->userdata('designation_id') == 3){
$this->db->select('bmp.id as project_id,bmp.project_name,bmp.project_breif,buf.company_name,bin.Industries as industry,buf.provided_job_title,buf.city,buf.address1,
bc.name as country_name,buf.region,bswd.dispositions as web_staff_disposition,buf.provided_staff_email,bcd.company_dispostion as voice_disposition,bcalld.caller_disposition as company_voice_disp,bwd.web_disposition_name as web_disposition,buf.website_url,buf.provided_direct_tel,buf.tel_number,buf.staff_direct_tel,buf.staff_mobile,buf.no_of_emp,buf.revenue,bsvd.voice_dispositions as voice_staff_disposition,buf.id as staff_id,bnp.prefix as salutation,buf.first_name,buf.last_name,CONCAT(us.first_name,us.last_name) as assigned_to,CONCAT(usd.first_name,usd.last_name) as assigned_by,ca.status,buf.created_date,buf.updated_at,ca.created_at as assigned_at,buf.has_replaced,buf.activity_type,buf.sa1,buf.sa2,buf.sa3,buf.sa4,buf.sa5,buf.address1');
$this->db->from('bdcrm_uploaded_feildss as buf');
$this->db->join('bdcrm_master_projects bmp','buf.project_id = bmp.id','left');
$this->db->join('bdcrm_countries bc','buf.country = bc.id','left');
$this->db->join('bdcrm_name_prefix bnp','buf.suffix = bnp.id','left');

$this->db->join('companywise_allocation ca','buf.id = ca.staff_id','left');
$this->db->join('users us','ca.reassigned_to=us.id','left');
$this->db->join('users usd','ca.assigned_by=usd.id','left');

}

$this->db->join('bdcrm_industries bin','buf.industry=bin.id','left');
$this->db->join('bdcrm_staff_web_disposition bswd','buf.web_staff_disposition=bswd.id','left');
$this->db->join('bdcrm_staff_voice_dispositions bsvd','buf.voice_staff_disposition=bsvd.id','left');
$this->db->join('bdcrm_company_disposition bcd','buf.company_disposition=bcd.id','left');
$this->db->join('bdcrm_caller_disposition bcalld','buf.voice_disposition=bcalld.id','left');
$this->db->join('bdcrm_web_disposition bwd','buf.web_disposition=bwd.id','left');
$where = '((ca.status IS NULL OR ca.status=1) AND (bmp.status=1))';

if(!empty($filter)){
$where .= " AND ".$filter;
$this->db->where($where);
}else{

}
$designation_name = $this->session->userdata('designation_name');
$user_id = $this->session->userdata('id');
if($designation_name=='Caller'){
$this->db->where('ca.reassigned_to',$user_id);
}
$this->db->where('buf.status',1);
$this->db->where('bmp.status',1);
$this->db->group_by('buf.id');
//$this->db->limit($limit, $start);
$query=$this->db->get();
return $data = $query->result_array();

}

function get_staff_info1_count(){
if($this->session->userdata('designation_id') == 1 || $this->session->userdata('designation_id') == 14 || $this->session->userdata('designation_id') == 8){
$this->db->select('bmp.id as project_id,bmp.project_name,bmp.project_breif,buf.company_name,bin.Industries as industry,buf.provided_job_title,buf.city,buf.address1,
bc.name as country_name,buf.region,bswd.dispositions as web_staff_disposition,buf.provided_staff_email,bcd.company_dispostion as voice_disposition,bcalld.caller_disposition as company_voice_disp,bwd.web_disposition_name as web_disposition,buf.website_url,buf.provided_direct_tel,buf.tel_number,buf.staff_direct_tel,buf.staff_mobile,buf.no_of_emp,buf.revenue,bsvd.voice_dispositions as voice_staff_disposition,buf.id as staff_id,bnp.prefix as salutation,buf.first_name,buf.last_name,CONCAT(us.first_name,us.last_name) as assigned_to,CONCAT(usd.first_name,usd.last_name) as assigned_by,ca.created_at as assigned_at,buf.created_date,buf.updated_at,buf.has_replaced,buf.activity_type,buf.sa1,buf.sa2,buf.sa3,buf.sa4,buf.sa5,buf.address1');
$this->db->from('bdcrm_uploaded_feildss as buf');
$this->db->join('bdcrm_master_projects bmp','buf.project_id = bmp.id','left');
$this->db->join('bdcrm_countries bc','buf.country = bc.id','left');
$this->db->join('bdcrm_name_prefix bnp','buf.suffix = bnp.id','left');
 $this->db->join('companywise_allocation ca','buf.id = ca.staff_id','left');
$this->db->join('users us','ca.reassigned_to=us.id','left');
$this->db->join('users usd','ca.assigned_by=usd.id','left');

}


if($this->session->userdata('designation_id') == 6 || $this->session->userdata('designation_id') == 3){
$this->db->select('bmp.id as project_id,bmp.project_name,bmp.project_breif,buf.company_name,bin.Industries as industry,buf.provided_job_title,buf.city,buf.address1,
bc.name as country_name,buf.region,bswd.dispositions as web_staff_disposition,buf.provided_staff_email,bcd.company_dispostion as voice_disposition,bcalld.caller_disposition as company_voice_disp,bwd.web_disposition_name as web_disposition,buf.website_url,buf.provided_direct_tel,buf.tel_number,buf.staff_direct_tel,buf.staff_mobile,buf.no_of_emp,buf.revenue,bsvd.voice_dispositions as voice_staff_disposition,buf.id as staff_id,bnp.prefix as salutation,buf.first_name,buf.last_name,CONCAT(us.first_name,us.last_name) as assigned_to,CONCAT(usd.first_name,usd.last_name) as assigned_by,ca.status,buf.created_date,buf.updated_at,ca.created_at as assigned_at,buf.has_replaced,buf.activity_type,buf.sa1,buf.sa2,buf.sa3,buf.sa4,buf.sa5,buf.address1');
$this->db->from('bdcrm_uploaded_feildss as buf');
$this->db->join('bdcrm_master_projects bmp','buf.project_id = bmp.id','left');
$this->db->join('bdcrm_countries bc','buf.country = bc.id','left');
$this->db->join('bdcrm_name_prefix bnp','buf.suffix = bnp.id','left');

$this->db->join('companywise_allocation ca','buf.id = ca.staff_id','left');
$this->db->join('users us','ca.reassigned_to=us.id','left');
$this->db->join('users usd','ca.assigned_by=usd.id','left');

}

$this->db->join('bdcrm_industries bin','buf.industry=bin.id','left');
$this->db->join('bdcrm_staff_web_disposition bswd','buf.web_staff_disposition=bswd.id','left');
$this->db->join('bdcrm_staff_voice_dispositions bsvd','buf.voice_staff_disposition=bsvd.id','left');
$this->db->join('bdcrm_company_disposition bcd','buf.company_disposition=bcd.id','left');
$this->db->join('bdcrm_caller_disposition bcalld','buf.voice_disposition=bcalld.id','left');
$this->db->join('bdcrm_web_disposition bwd','buf.web_disposition=bwd.id','left');
$where = '((ca.status IS NULL OR ca.status=1) AND (bmp.status=1))';

if(!empty($filter)){
$where .= " AND ".$filter;
$this->db->where($where);
}else{

}
$designation_name = $this->session->userdata('designation_name');
$user_id = $this->session->userdata('id');
if($designation_name=='Caller'){
$this->db->where('ca.reassigned_to',$user_id);
}
$this->db->where('buf.status',1);
$this->db->where('bmp.status',1);
$this->db->group_by('buf.id');

$query=$this->db->get();
return count($query->result_array());

}


function getAssignee(){

$sql ="SELECT GROUP_CONCAT(DISTINCT(bdcrm_uploaded_feildss.received_company_name)) as received_company_name,count(bdcrm_uploaded_feildss.received_company_name) as staff_count, count(bdcrm_uploaded_feildss.updated_status) as completed_updated_status, `bdcrm_uploaded_feildss`.`created_date`, GROUP_CONCAT(DISTINCT(bdcrm_uploaded_feildss.project_id)) as project_id, `bdcrm_uploaded_feildss`.`id`, `bdcrm_master_projects`.`project_name`, GROUP_CONCAT(bdcrm_uploaded_feildss.id) as bdcrm_uploaded_feildss_id, GROUP_CONCAT(companywise_allocation.assigned_by) as assigned_by, CONCAT(users.first_name,' ',users.last_name) as user_name, COUNT(companywise_allocation.total_count) as total_count FROM `bdcrm_uploaded_feildss` LEFT JOIN `bdcrm_master_projects` ON `bdcrm_uploaded_feildss`.`project_id` = `bdcrm_master_projects`.`id`";
  $designation_name = $this->session->userdata('designation_name');
  
}


function getDesignationById($id){

$this->db->select('md.designation_name');
$this->db->from('users us');
$this->db->join('master_designation md','md.id = us.designation','left');
$this->db->where('md.status',1);
$this->db->where('us.id',$id);
$querys=$this->db->get();
$data =  $querys->result_array();
return $data[0]['designation_name'];


}

function getstaffwebdisbytasktype($task_type,$disposition_status,$main_staff_disposition,$first_name,$last_name,$web_staff_disposition)
{
// echo $web_staff_disposition;
// echo $disposition_status;
// echo $main_staff_disposition;die();
$fullname=$first_name.$last_name;
$this->db->select('*');
$this->db->from('bdcrm_staff_web_disposition');
if($main_staff_disposition == 6 && strtolower($task_type) == "named" && $web_staff_disposition == 5)
{ 
$this->db->where_in('id',['5']); 
}
else if($main_staff_disposition == 3 && strtolower($task_type) == "named")
{
if($disposition_status == 2)
{ 
    $this->db->where_in('id',['5']); 
}
else if($disposition_status == 3){
   
    $this->db->where_in('id',['4']); 
}

}
else if(strtolower($task_type) == "named"){
$this->db->where_in('id',['1','3','6','7']);
}
/***************************For UnNamed and name with unnamed********************************/
if($main_staff_disposition == 6 && strtolower($task_type) == "name with unnamed" && $web_staff_disposition == 5 && $disposition_status == 1)
{  
 $this->db->where_in('id',['5']); 
}
else if($main_staff_disposition == 3 && strtolower($task_type) == "name with unnamed" && $fullname == '' && $web_staff_disposition == 5)
{
 if($disposition_status == 2)
 { 
     $this->db->where_in('id',['5']); 
 }
 else if($disposition_status == 3){
    
     $this->db->where_in('id',['4']); 
 }

}
else if($main_staff_disposition == 3 && strtolower($task_type) == "name with unnamed" && $fullname == '' && $web_staff_disposition == 4)
{
 if($disposition_status == 2)
 { 
     $this->db->where_in('id',['5']); 
 }
 else if($disposition_status == 3){
    
     $this->db->where_in('id',['4']); 
 }

}
else if($main_staff_disposition == 2 && (strtolower($task_type) == "name with unnamed") && $fullname == '' && $web_staff_disposition == 5  && $disposition_status == 4)
{
 $this->db->where_in('id',['2']); 
}
else if($main_staff_disposition == 7 && (strtolower($task_type) == "name with unnamed") && $fullname == '' && $web_staff_disposition == 2  && $disposition_status == 4)
{
 $this->db->where_in('id',['2']); 
}
else if($main_staff_disposition == 2 && (strtolower($task_type) == "name with unnamed") && $fullname == '' && $web_staff_disposition == 2  && $disposition_status == 4)
{
 $this->db->where_in('id',['2']); 
}
else if($main_staff_disposition == 1 && (strtolower($task_type) == "name with unnamed") && $fullname == '' && $web_staff_disposition == 2  && $disposition_status == 4)
{
 $this->db->where_in('id',['2']); 
}
else if($main_staff_disposition == 6 && (strtolower($task_type) == "name with unnamed") && $fullname == '' && $web_staff_disposition == 2  && $disposition_status == 4)
{
 $this->db->where_in('id',['2']); 
}
else if($main_staff_disposition == 3 && (strtolower($task_type) == "name with unnamed") && $fullname == '' && $web_staff_disposition == 2  && $disposition_status == 4)
{
 $this->db->where_in('id',['2']); 
}

else if($main_staff_disposition == '' && strtolower($task_type) == "name with unnamed" && $fullname == '' && $web_staff_disposition == 0  && $disposition_status == ''){
 $this->db->where_in('id',['6','2']);
}

else if(strtolower($task_type) == "name with unnamed" && $fullname !='' && $web_staff_disposition == 2 ){

 $this->db->where_in('id',['2']);
}

else if(strtolower($task_type) == "name with unnamed" && $fullname !='' && $web_staff_disposition != 2 ){

$this->db->where_in('id',['1','3','6','7']);
}

else{   
$this->db->where_in('id',['1','2','3','4','5','6','7']);  
}
$querys=$this->db->get();
//print_r($querys->result_array());die()
return $data =  $querys->result_array();
}


function getstaffvoicedisbytasktype($staff_id,$task_type,$disposition_status,$main_staff_disposition,$caller_has_replaced,$first_name,$last_name,$web_staff_disposition)
{
// echo $web_staff_disposition;
// echo $disposition_status;
// echo $main_staff_disposition;die();
$fullname=$first_name.$last_name;
$this->db->select('*');
$this->db->from('bdcrm_staff_voice_dispositions');

if($main_staff_disposition == 6 && strtolower($task_type) == "named" && $caller_has_replaced !='')
{
$this->db->where_in('id',['5']); 
}
else if($main_staff_disposition == 3 && strtolower($task_type) == "named"  && $caller_has_replaced !='')
{
if($disposition_status == 2)
{
    $this->db->where_in('id',['5']); 
}
else if($disposition_status == 3){
    $this->db->where_in('id',['4']); 
}

}
else if(strtolower($task_type) == "named" && $caller_has_replaced == ''){
$this->db->where_in('id',['1','3','6','7']);
}
/***************************For UnNamed and name with unnamed********************************/
else if($main_staff_disposition == 2 && (strtolower($task_type) == "name with unnamed") && $fullname == '' && $web_staff_disposition == 5  && $disposition_status == 4)
{
  $this->db->where_in('id',['2']); 
}
else if($main_staff_disposition == 7 && (strtolower($task_type) == "name with unnamed") && $fullname == '' && $web_staff_disposition == 2  && $disposition_status == 4)
{
  $this->db->where_in('id',['2']); 
}
else if($main_staff_disposition == 2 && (strtolower($task_type) == "name with unnamed") && $fullname == '' && $web_staff_disposition == 2  && $disposition_status == 4)
{
  $this->db->where_in('id',['2']); 
}
else if($main_staff_disposition == 1 && (strtolower($task_type) == "name with unnamed") && $fullname == '' && $web_staff_disposition == 2  && $disposition_status == 4)
{
  $this->db->where_in('id',['2']); 
}
else if($main_staff_disposition == 6 && (strtolower($task_type) == "name with unnamed") && $fullname == '' && $web_staff_disposition == 2  && $disposition_status == 4)
{
  $this->db->where_in('id',['2']); 
}
else if($main_staff_disposition == 3 && (strtolower($task_type) == "name with unnamed") && $fullname == '' && $web_staff_disposition == 2  && $disposition_status == 4)
{
  $this->db->where_in('id',['2']); 
}

else if($main_staff_disposition == 0 && strtolower($task_type) == "name with unnamed" && $fullname == '' && $web_staff_disposition == 0  && $disposition_status == ''){
  $this->db->where_in('id',['6','2']);
}

else if(strtolower($task_type) == "name with unnamed" && $fullname !='' && $web_staff_disposition == 2 ){

  $this->db->where_in('id',['2']);
}

else if(strtolower($task_type) == "name with unnamed" && $fullname !='' && $web_staff_disposition != 2 ){

 $this->db->where_in('id',['1','3','6','7']);
}
else{
$this->db->where_in('id',['1','2','3','4','5','6','7']);  
}
$querys=$this->db->get();
return $data =  $querys->result_array();

}

function getCurrentRecordStatus($staff_id,$task_type){
if($this->session->userdata('designation_id') == 6)
{
$sql = "SELECT web_staff_disposition FROM `bdcrm_uploaded_feildss` WHERE id='$staff_id'";
$query = $this->db->query($sql);
$data =  $query->result_array(); 
$primary_disposition_id = $data[0]['web_staff_disposition']; 

// CASE IF STAFF DISPOSITION TYPE IS NO RESULT AND RECORD HAS BEEN ADDED FOR THE SAME 

if(!empty($primary_disposition_id) && $primary_disposition_id=='6' && $task_type == 'named'){
    $checkAddInfo = "SELECT * FROM `bdcrm_uploaded_feildss` WHERE has_replaced='$staff_id' AND activity_type='1'"; 
    $querys = $this->db->query($checkAddInfo);
    $datas =  $querys->result_array();
    $datas = array('button_type'=>"NS",'count'=>count($datas));
 
}else if(!empty($primary_disposition_id) && $primary_disposition_id=='6' && $task_type == 'name with unnamed'){
    $checkAddInfo = "SELECT * FROM `bdcrm_uploaded_feildss` WHERE id='$staff_id' "; 
    $querys = $this->db->query($checkAddInfo);
    $datas =  $querys->result_array();
    $datas = array('button_type'=>"NS",'count'=>count($datas));
    //print_r($datas);die();
 
}else if(!empty($primary_disposition_id) && $primary_disposition_id=='2' && $task_type == 'name with unnamed'){
    $checkAddInfo = "SELECT * FROM `bdcrm_uploaded_feildss` WHERE has_replaced ='$staff_id'  AND activity_type='4'"; 
    $querys = $this->db->query($checkAddInfo);
    $datas =  $querys->result_array();
    $datas = array('button_type'=>"NS",'count'=>count($datas));
    //print_r($datas);die();
 
}else if(!empty($primary_disposition_id) && $primary_disposition_id=='1' && $task_type == 'name with unnamed'){
    $checkAddInfo = "SELECT * FROM `bdcrm_uploaded_feildss` WHERE has_replaced ='$staff_id'  AND activity_type='4'"; 
    $querys = $this->db->query($checkAddInfo);
    $datas =  $querys->result_array();
    $datas = array('button_type'=>"NS",'count'=>count($datas));
    //print_r($datas);die();
 
}else if(!empty($primary_disposition_id) && $primary_disposition_id=='7' && $task_type == 'name with unnamed'){
    $checkAddInfo = "SELECT * FROM `bdcrm_uploaded_feildss` WHERE has_replaced ='$staff_id'  AND activity_type='4'"; 
    $querys = $this->db->query($checkAddInfo);
    $datas =  $querys->result_array();
    $datas = array('button_type'=>"NS",'count'=>count($datas));
    //print_r($datas);die();
 
}else if(!empty($primary_disposition_id) && $primary_disposition_id=='3' && $task_type == 'name with unnamed'){
    $checkRepInfo = "SELECT DISTINCT web_staff_disposition FROM `bdcrm_uploaded_feildss` WHERE has_replaced='$staff_id' AND (activity_type='3' OR activity_type='2')"; 
    $queryss = $this->db->query($checkRepInfo);
    $dataSL =  $queryss->result_array();
    
    //print_r(($dataSL));die();
    if(count($dataSL)==2){
         $datas = array('button_type'=>"SLA",'count'=>count($dataSL));
    }else if(count($dataSL)==1 && $dataSL[0]['web_staff_disposition']==5){
        $datas = array('button_type'=>"SLAA",'count'=>count($dataSL));
    }else if(count($dataSL)==1 && $dataSL[0]['web_staff_disposition']==4){
         $datas = array('button_type'=>"SLREP",'count'=>count($dataSL));
    }
  
   
}else if(!empty($primary_disposition_id) && $primary_disposition_id=='3' && $task_type == 'named'){
    $checkRepInfo = "SELECT DISTINCT web_staff_disposition FROM `bdcrm_uploaded_feildss` WHERE has_replaced='$staff_id' AND (activity_type='3' OR activity_type='2')"; 
    $queryss = $this->db->query($checkRepInfo);
    $dataSL =  $queryss->result_array();
    
    if(count($dataSL)==2){
         $datas = array('button_type'=>"SLA",'count'=>count($dataSL));
    }else if(count($dataSL)==1 && $dataSL[0]['web_staff_disposition']==5){
        $datas = array('button_type'=>"SLAA",'count'=>count($dataSL));
    }else if(count($dataSL)==1 && $dataSL[0]['web_staff_disposition']==4){
         $datas = array('button_type'=>"SLREP",'count'=>count($dataSL));
    }
  
   
}

}elseif($this->session->userdata('designation_id') == 3)
{
$sql = "SELECT voice_staff_disposition FROM `bdcrm_uploaded_feildss` WHERE id='$staff_id'";
$query = $this->db->query($sql);
$data =  $query->result_array(); 


$primary_disposition_id = $data[0]['voice_staff_disposition']; 

// CASE IF STAFF DISPOSITION TYPE IS NO RESULT AND RECORD HAS BEEN ADDED FOR THE SAME 

if(!empty($primary_disposition_id) && $primary_disposition_id=='6' && $task_type == 'named'){
$checkAddInfo = "SELECT * FROM `bdcrm_uploaded_feildss` WHERE caller_has_replaced='$staff_id' AND activity_type='1'"; 
$querys = $this->db->query($checkAddInfo);
$datas =  $querys->result_array();
$datas = array('button_type'=>"NS",'count'=>count($datas));

}else if(!empty($primary_disposition_id) && $primary_disposition_id=='6' && $task_type == 'name with unnamed'){
$checkAddInfo = "SELECT * FROM `bdcrm_uploaded_feildss` WHERE caller_has_replaced='$staff_id' AND activity_type='1'"; 
$querys = $this->db->query($checkAddInfo);
$datas =  $querys->result_array();
$datas = array('button_type'=>"NS",'count'=>count($datas));

}else if(!empty($primary_disposition_id) && $primary_disposition_id=='3' && $task_type == 'named'){
$checkRepInfo = "SELECT DISTINCT voice_staff_disposition FROM `bdcrm_uploaded_feildss` WHERE caller_has_replaced='$staff_id' AND (activity_type='3' OR activity_type='2')"; 
$queryss = $this->db->query($checkRepInfo);
$dataSL =  $queryss->result_array();


if(count($dataSL)==2){
     $datas = array('button_type'=>"SLA",'count'=>count($dataSL));
}else if(count($dataSL)==1 && $dataSL[0]['voice_staff_disposition']==5){
    $datas = array('button_type'=>"SLAA",'count'=>count($dataSL));
}else if(count($dataSL)==1 && $dataSL[0]['voice_staff_disposition']==4){
     $datas = array('button_type'=>"SLREP",'count'=>count($dataSL));
} 

}else if(!empty($primary_disposition_id) && $primary_disposition_id=='3' && $task_type == 'name with unnamed'){
$checkRepInfo = "SELECT DISTINCT voice_staff_disposition FROM `bdcrm_uploaded_feildss` WHERE caller_has_replaced='$staff_id' AND (activity_type='3' OR activity_type='2')"; 
$queryss = $this->db->query($checkRepInfo);
$dataSL =  $queryss->result_array();


if(count($dataSL)==2){
     $datas = array('button_type'=>"SLA",'count'=>count($dataSL));
}else if(count($dataSL)==1 && $dataSL[0]['voice_staff_disposition']==5){
    $datas = array('button_type'=>"SLAA",'count'=>count($dataSL));
}else if(count($dataSL)==1 && $dataSL[0]['voice_staff_disposition']==4){
     $datas = array('button_type'=>"SLREP",'count'=>count($dataSL));
} 

}
//else  if(!empty($primary_disposition_id) && $primary_disposition_id=='1' && $task_type == 'named'){
//     $checkAddInfo = "SELECT * FROM `bdcrm_uploaded_feildss` WHERE caller_has_replaced='$staff_id' AND activity_type='1'"; 
//     $querys = $this->db->query($checkAddInfo);
//     $datas =  $querys->result_array();
//     $datas = array('button_type'=>"NS",'count'=>count($datas));

// }
else  if(!empty($primary_disposition_id) && $primary_disposition_id=='1' && $task_type == 'name with unnamed'){
$checkAddInfo = "SELECT * FROM `bdcrm_uploaded_feildss` WHERE caller_has_replaced='$staff_id' AND activity_type='4'"; 
$querys = $this->db->query($checkAddInfo);
$datas =  $querys->result_array();
$datas = array('button_type'=>"NS",'count'=>count($datas));

}
else if(!empty($primary_disposition_id) && $primary_disposition_id=='7' && $task_type == 'name with unnamed'){
    $checkAddInfo = "SELECT * FROM `bdcrm_uploaded_feildss` WHERE caller_has_replaced ='$staff_id'  AND activity_type='4'"; 
    $querys = $this->db->query($checkAddInfo);
    $datas =  $querys->result_array();
    $datas = array('button_type'=>"NS",'count'=>count($datas));
    //print_r($datas);die();
 
}
}
//  echo "<pre>";
// print_r($datas);
// die;
return $datas; 

}


public function DumpingTable($reference){
$sql = "CREATE TABLE $reference LIKE bdcrm_uploaded_feildss"; 
$query = $this->db->query($sql); 
}

public function MaxStaffId($staff_id)
{ 
if($this->session->userdata('designation_id') == 6)
{
$sql = "SELECT Max(has_replaced1) FROM `bdcrm_uploaded_feildss` WHERE has_replaced='$staff_id' and activity_type='4'" ;
$query = $this->db->query($sql);
$data =  $query->result_array();
 if(!empty($data[0]['Max(has_replaced1)']))
{
    $counter=$data[0]['Max(has_replaced1)'] + 1;
}else{
    $counter=1;
}
}else if($this->session->userdata('designation_id') == 3){
$sql = "SELECT Max(caller_has_replaced1) FROM `bdcrm_uploaded_feildss` WHERE caller_has_replaced='$staff_id' and activity_type='4'" ;
$query = $this->db->query($sql);
$data =  $query->result_array();
 if(!empty($data[0]['Max(caller_has_replaced1)']))
{
    $counter=$data[0]['Max(caller_has_replaced1)'] + 1;
}else{
    $counter=1;
}
}


return $counter;
}


public function  getAllDataByProjectId($id){

             $id=1;
             $sql = "SELECT buf.id, buf.received_company_name,buf.company_name,buf.address1,buf.address2,buf.address3,
             buf.city,buf.postal_code,buf.state_county,buf.state_county,bc.name as provided_country,bcc.name as updated_country,bcc.region as region,buf.country_code,buf.address_souce_url,buf.no_of_emp,bi.Industries as industry_type,buf.revenue,bcd.company_dispostion,bwd.web_disposition_name,
             bccd.caller_disposition as company_voice_disposition,buf.genaral_note,bnp.prefix,buf.first_name,buf.last_name,
             buf.provided_job_title as job_title,buf.staff_job_function as job_function,buf.staff_email,
             buf.staff_department,buf.staff_url as staff_source_url,buf.assumed_email,buf.staff_email_harvesting as email_source_url,buf.staff_direct_tel,
             buf.staff_mobile,bswd.dispositions as web_disposition,bsvd.voice_dispositions as caller_staff_disposition,buf.staff_linkedin_con,
             buf.staff_note,buf.research_remark,buf.voice_remark,buf.researcher_company_remark,buf.researcher_company_note,buf.caller_company_note,buf.has_replaced,
             buf.caller_has_replaced,buf.created_date,buf.updated_at,CONCAT(us.first_name,' ',us.last_name) as updated_by
             FROM `bdcrm_uploaded_feildss` as buf
             left join bdcrm_countries as bc on buf.provided_country = bc.id
             left join bdcrm_countries as bcc on buf.country= bcc.id
             left join bdcrm_industries as bi on buf.industry = bi.id
             left join bdcrm_company_disposition as bcd on buf.company_disposition = bcd.id
             left join bdcrm_web_disposition as bwd on buf.web_disposition
             left join bdcrm_caller_disposition as bccd on buf.voice_disposition = bccd.id
             left JOIN bdcrm_name_prefix as bnp on buf.suffix = bnp.id
             left join bdcrm_staff_web_disposition as bswd on buf.web_staff_disposition = bswd.id
             left join bdcrm_staff_voice_dispositions as bsvd on buf.voice_staff_disposition = bsvd.id
             left JOIN users as us on buf.updated_by = us.id
             WHERE buf.project_id = $id";
            
            
             $queryss = $this->db->query($sql);
             return $data=  $queryss->result_array();


}

function getvoicerecord($from_date="",$to_date="",$rowno="",$rowperpage="",$search_text="",$first_name="",$last_name="",$staff_id="")
{
$this->db->select('ch.*,bsvd.voice_dispositions,bcd.caller_disposition,us.username');
$this->db->from('caller_history ch');
$this->db->join('bdcrm_staff_voice_dispositions bsvd','bsvd.id=ch.voice_staff_disposition','left');
$this->db->join('bdcrm_caller_disposition bcd','bcd.id=ch.co_caller_disposition','left');
$this->db->join('users us','us.id=ch.created_by','left');

$this->db->where('ch.staff_id',$staff_id);
$this->db->limit($rowperpage,$rowno);
if(!empty($from_date))
{
   $this->db->where('ch.ondate >=',$from_date);
}
if(!empty($to_date))
{
   $this->db->where('ch.ondate <=',$to_date);
}
if(!empty($search_text))
{
   $this->db->where("(ch.firstname LIKE '%".$search_text."%' OR ch.lastname LIKE '%".$search_text."%' OR bsvd.voice_dispositions LIKE '%".$search_text."%' OR ch.caller_remark LIKE '%".$search_text."%')", NULL, FALSE); 
}
$this->db->group_by('ch.id');
$this->db->order_by('ch.id',"DESC");
$query=$this->db->get();
return $query->result_array();
}

function getvoicerecord_count_filtered($from_date="",$to_date="",$rowno="",$rowperpage="",$search_text="",$first_name="",$last_name="",$staff_id="")
{
$this->db->select('ch.*,bsvd.voice_dispositions,bcd.caller_disposition,us.username');
$this->db->from('caller_history ch');
$this->db->join('bdcrm_staff_voice_dispositions bsvd','bsvd.id=ch.voice_staff_disposition','left');
$this->db->join('bdcrm_caller_disposition bcd','bcd.id=ch.co_caller_disposition','left');
$this->db->join('users us','us.id=ch.created_by','left');
//$this->db->where('ch.created_by',$this->session->userdata('id'));
//     $this->db->where('ch.firstname',$first_name);
//    $this->db->where('ch.lastname',$last_name);
$this->db->where('ch.staff_id',$staff_id);
$this->db->limit($rowperpage,$rowno);
if(!empty($from_date))
{
   $this->db->where('ch.ondate >=',$from_date);
}
if(!empty($to_date))
{
   $this->db->where('ch.ondate <=',$to_date);
}
if(!empty($search_text))
{
$this->db->where("(ch.firstname LIKE '%".$search_text."%' OR ch.lastname LIKE '%".$search_text."%' OR bsvd.voice_dispositions LIKE '%".$search_text."%' OR ch.caller_remark LIKE '%".$search_text."%')", NULL, FALSE); 
}
$this->db->group_by('ch.id');
$this->db->order_by('ch.id',"DESC");
$query=$this->db->get();
return $query->num_rows();
}

function getvoicerecord_count_all($from_date="",$to_date="",$rowno="",$rowperpage="",$search_text="",$first_name="",$last_name="",$staff_id="")
{
$this->db->select('ch.*,bsvd.voice_dispositions,bcd.caller_disposition,us.username');
$this->db->from('caller_history ch');
$this->db->join('bdcrm_staff_voice_dispositions bsvd','bsvd.id=ch.voice_staff_disposition','left');
$this->db->join('bdcrm_caller_disposition bcd','bcd.id=ch.co_caller_disposition','left');
$this->db->join('users us','us.id=ch.created_by','left');
//$this->db->where('ch.created_by',$this->session->userdata('id'));
//     $this->db->where('ch.firstname',$first_name);
//    $this->db->where('ch.lastname',$last_name);
$this->db->where('ch.staff_id',$staff_id);
$this->db->limit($rowperpage,$rowno);
if(!empty($from_date))
{
   $this->db->where('ch.ondate >=',$from_date);
}
if(!empty($to_date))
{
   $this->db->where('ch.ondate <=',$to_date);
}
if(!empty($search_text))
{
$this->db->where("(ch.firstname LIKE '%".$search_text."%' OR ch.lastname LIKE '%".$search_text."%' OR bsvd.voice_dispositions LIKE '%".$search_text."%' OR ch.caller_remark LIKE '%".$search_text."%')", NULL, FALSE); 
}
$this->db->group_by('ch.id');
$this->db->order_by('ch.id',"DESC");
$query=$this->db->count_all_results();
return $this->db->count_all_results();
}

function getStaffVoiceDispo()
{
$this->db->select('bsvd.*,bcd.caller_disposition');
$this->db->from('bdcrm_staff_voice_dispositions bsvd');
$this->db->join('bdcrm_caller_disposition bcd','bcd.id=bsvd.co_dispositions','left');
$this->db->where('bsvd.status','1');
$this->db->group_by('bsvd.id');
$this->db->order_by('bsvd.id',"DESC");
$query=$this->db->get();
return $query->result_array();
}

function get_Staff_Voice_Dispo($disp_id)
{
$this->db->select('bsvd.*,bcd.caller_disposition');
$this->db->from('bdcrm_staff_voice_dispositions bsvd');
$this->db->join('bdcrm_caller_disposition bcd','bcd.id=bsvd.co_dispositions','left');
$this->db->where('bsvd.status','1');
$this->db->where('bsvd.co_dispositions',$disp_id);
$this->db->group_by('bsvd.id');
$this->db->order_by('bsvd.id',"DESC");
$query=$this->db->get();
return $query->result_array();
}

public function getcalendarevents()
{
$events = array();
if($this->session->userdata('designation_id') == 8 || $this->session->userdata('designation_id') == 1)
{
$this->db->select('buf.*,fdh.date_time as followupdate');
$this->db->from('followup_date_history fdh');
$this->db->join('bdcrm_uploaded_feildss buf','buf.id=fdh.staff_id','left');
$this->db->group_by('fdh.id');
$this->db->order_by('fdh.id',"DESC");
$query=$this->db->get();
$results = $query->result_array();

}else{
$this->db->select('buf.*,fdh.date_time as followupdate');
$this->db->from('followup_date_history fdh');
$this->db->join('bdcrm_uploaded_feildss buf','buf.id=fdh.staff_id','left');
$this->db->where('fdh.created_by',$this->session->userdata('id'));
$this->db->group_by('fdh.id');
$this->db->order_by('fdh.id',"DESC");
$query=$this->db->get();
$results = $query->result_array();
}
if ($results) {
$results_count = count($results);
foreach ($results as $resultskey =>  $row) {
    if (strtotime($row['followupdate']) <= strtotime(date('Y-m-d H:i:s'))) $color = 'red';
    else $color = '#007bff';
    $retVal = (!empty($row['company_name'])) ? $row['company_name'] : $row['received_company_name'] ;
    array_push($events, array(
        'title' => $row['first_name'].' '. $row['last_name'],
        'start' => date('Y-m-d H:i:s', strtotime($row['followupdate'])),
        'borderColor' => $color,
        // 'start' => str_replace(' ', 'T', date('Y-m-d H:i:s', strtotime($row->followup_dt))),
        // 'end' => str_replace(' ', 'T', date('Y-m-d H:i:s', strtotime($row->followup_dt))),
        'url' => base_url()."Projects/my_projects/".base64_encode($row['project_id']).'/'.base64_encode($row['id']).'/'.base64_encode($retVal),
        'company_name' => $retVal,
        'staff_name' => $row['first_name'].' '. $row['last_name'],
        'results_count'=> $results_count,
        // 'allDay' => true,
        // 'extendedProps' =>  [
        // 	'my_props' => 'props_value'
        // ],
    ));
    
}

$data['events'] = json_encode($events);
} else $data['events'] = json_encode($events);
return $data['events'] ;
}

public function searchcalendarevents($from_date='',$to_date='',$user_id='')
{
$events = array();
$this->db->select('buf.*,fdh.date_time as followupdate');
$this->db->from('followup_date_history fdh');
$this->db->join('bdcrm_uploaded_feildss buf','buf.id=fdh.staff_id','left');
if($this->session->userdata('designation_id') == 8 || $this->session->userdata('designation_id') == 1)
{
if(!empty($from_date))
{
    $this->db->where('DATE(fdh.date_time) >=',$from_date);  
}
if(!empty($to_date))
{
    $this->db->where('DATE(fdh.date_time) <=',$to_date);  
}
// if(!empty($user_id))
// {
//     $this->db->where('fdh.created_by',$user_id);
// }
$this->db->group_by('fdh.id');
$this->db->order_by('fdh.id',"DESC");
$query=$this->db->get();
$results = $query->result_array();

}else{
if(!empty($from_date))
{
    $this->db->where('DATE(fdh.date_time)',$from_date);  
}
if(!empty($to_date))
{
    $this->db->where('DATE(fdh.date_time)',$to_date);  
}
$this->db->where('fdh.created_by',$this->session->userdata('id'));
$this->db->group_by('fdh.id');
$this->db->order_by('fdh.id',"DESC");
$query=$this->db->get();
$results = $query->result_array();
}
if ($results) {
$results_count = count($results);
foreach ($results as $resultskey =>  $row) {
    if (strtotime($row['followupdate']) <= strtotime(date('Y-m-d H:i:s'))) $color = 'red';
    else $color = '#007bff';
    $retVal = (!empty($row['company_name'])) ? $row['company_name'] : $row['received_company_name'] ;
    array_push($events, array(
        'title' => $row['first_name'].' '. $row['last_name'],
        'start' => date('Y-m-d H:i:s', strtotime($row['followupdate'])),
        'borderColor' => $color,
        // 'start' => str_replace(' ', 'T', date('Y-m-d H:i:s', strtotime($row->followup_dt))),
        // 'end' => str_replace(' ', 'T', date('Y-m-d H:i:s', strtotime($row->followup_dt))),
        'url' => base_url()."Projects/my_projects/".base64_encode($row['project_id']).'/'.base64_encode($row['id']).'/'.base64_encode($retVal),
        'company_name' => $retVal,
        'results_count'=> $results_count,
        // 'allDay' => true,
            // 'extendedProps' =>  [
        // 	'my_props' => 'props_value'
        // ],
    ));
    
}

$data['events'] = json_encode($events);
} else $data['events'] = json_encode($events);
return $data['events'] ;
}


function getnotification(){
$current_date_time=date('Y-m-d H:i:s');
$reserve_from_time_10 = date('Y-m-d H:i:s',strtotime($current_date_time .'+10 minutes'));
$reserve_from_time_5 = date('Y-m-d H:i:s',strtotime($current_date_time .'+5 minutes'));
$user_id = $this->session->userdata('id');
$sql = "select followup_date_history.*,bdcrm_uploaded_feildss.id as staff_id,bdcrm_uploaded_feildss.project_id as project_id,bdcrm_uploaded_feildss.received_company_name,bdcrm_uploaded_feildss.company_name from followup_date_history LEFT JOIN `bdcrm_uploaded_feildss` ON `followup_date_history`.`staff_id` = `bdcrm_uploaded_feildss`.`id` where date_time = '".$reserve_from_time_5."' AND created_by=  '".$user_id."'"; 
$query = $this->db->query($sql);
//echo $this->db->last_query();
$data =  $query->result_array(); 
return $data;
}

function getcallbackrecord($from_date="",$to_date="",$rowno="",$rowperpage="",$search_text="",$staff_id="")
{
$this->db->select('fdh.date_time,fdh.project_id as f_p_i,fdh.created_at as fdhcreatedat,buf.project_id,buf.id,buf.company_name,buf.received_company_name,buf.first_name,buf.last_name,buf.updated_at,cr.caller_remark');
$this->db->from('followup_date_history fdh');
$this->db->join('bdcrm_uploaded_feildss buf','buf.id=fdh.staff_id','left');
$this->db->join('caller_history cr','cr.created_at=fdh.created_at','left');
if(!empty($from_date))
{
    $this->db->where('DATE(fdh.date_time) >=',$from_date);
}
if(!empty($to_date))
{
    $this->db->where('DATE(fdh.date_time) <=',$to_date);
}
if($this->session->userdata('designation_id') != 8 || $this->session->userdata('designation_id') == 1)
{
    $this->db->where('fdh.created_by',$this->session->userdata('id'));
}

if(empty($from_date) && empty($to_date)){
    $current_date=date('Y-m-d');
    $this->db->where('DATE(fdh.date_time) =',$current_date);
    $this->db->where('DATE(fdh.date_time) =',$current_date);
}
if(!empty($search_text))
{
    $this->db->where("(fdh.date_time LIKE '%".$search_text."%' OR buf.company_name LIKE '%".$search_text."%' OR buf.first_name LIKE '%".$search_text."%' OR buf.last_name LIKE '%".$search_text."%' OR cr.caller_remark LIKE '%".$search_text."%')", NULL, FALSE); 
}
$this->db->where('buf.status',1);
$this->db->group_by('fdh.date_time');
$this->db->order_by('fdh.date_time',"DESC");
$this->db->limit($rowperpage,$rowno);
$query=$this->db->get();
//echo $this->db->last_query();die();
$data=$query->result_array();

foreach($data as $data_key =>$data_val){
$datetime=strtotime($data_val['date_time']);
$updateddatetime=strtotime($data_val['updated_at']);
$fdhcreatedat=$data_val['fdhcreatedat'];
if($updateddatetime > $datetime)
{  
    $data[$data_key]['status']='true';
}
// else if($updateddatetime < $datetime)
// {  
//     $data[$data_key]['status']='true';
// }
else{
    $data[$data_key]['status']='false'; 
}
}

return $data;
}

function get_callback_count($from_date="",$to_date="",$rowno="",$rowperpage="",$search_text="",$staff_id="")
{
$this->db->select('fdh.date_time,fdh.created_at as fdhcreatedat,buf.id,buf.company_name,buf.received_company_name,buf.first_name,buf.last_name,buf.updated_at,cr.caller_remark');
$this->db->from('followup_date_history fdh');
$this->db->join('bdcrm_uploaded_feildss buf','buf.id=fdh.staff_id','left');
$this->db->join('caller_history cr','cr.created_at=fdh.created_at','left');
if(!empty($from_date))
{
    $this->db->where('DATE(fdh.date_time) >=',$from_date);
}
if(!empty($to_date))
{
    $this->db->where('DATE(fdh.date_time) <=',$to_date);
}
if($this->session->userdata('designation_id') != 8 || $this->session->userdata('designation_id') == 1)
{
    $this->db->where('fdh.created_by',$this->session->userdata('id'));
}
if(empty($from_date) && empty($to_date)){
    $current_date=date('Y-m-d');
    $this->db->where('DATE(fdh.date_time) =',$current_date);
    $this->db->where('DATE(fdh.date_time) =',$current_date);
}
if(!empty($search_text))
{
    $this->db->where("(fdh.date_time LIKE '%".$search_text."%' OR buf.company_name LIKE '%".$search_text."%' OR buf.first_name LIKE '%".$search_text."%' OR buf.last_name LIKE '%".$search_text."%' OR cr.caller_remark LIKE '%".$search_text."%')", NULL, FALSE); 
}
$this->db->group_by('fdh.date_time');
$this->db->order_by('fdh.date_time',"DESC");
$query=$this->db->get();
$this->db->limit($rowperpage,$rowno);
$data=$query->result_array();

foreach($data as $data_key =>$data_val){
$datetime=strtotime($data_val['date_time']);
$updateddatetime=strtotime($data_val['updated_at']);
$fdhcreatedat=$data_val['fdhcreatedat'];
$fdhcreatedat1= date("d-m-Y H:i:s", strtotime($fdhcreatedat));  ;
if($updateddatetime > $datetime)
{  
    $data[$data_key]['status']='true';
}
else{
    $data[$data_key]['status']='false'; 
}
}
return count($data);
}

//public function bd_master_account_data($limit, $start)
public function bd_master_account_data()
{
$this->db->select('DISTINCT(buf.company_name) as received_company_name,buf.id,bc.name,us.username,buf.updated_at');
$this->db->from('bdcrm_uploaded_feildss as buf');
$this->db->join('companywise_allocation cal','buf.id = cal.staff_id','left');
$this->db->join('users us','cal.reassigned_to=us.id','left');
$this->db->join('bdcrm_countries bc','buf.country=bc.id','left');
$this->db->join('bdcrm_master_projects bmp','buf.project_id = bmp.id','left');
$this->db->where('buf.status',1);
$this->db->where('bmp.status',1);
$this->db->group_by('buf.id');
//$this->db->limit($limit, $start);
$query=$this->db->get();
$data=$query->result_array();
return $data;
}

public function bd_master_account_datacount()
{
$this->db->select('DISTINCT(buf.company_name) as received_company_name,buf.id,bc.name,us.username,buf.updated_at');
$this->db->from('bdcrm_uploaded_feildss as buf');
$this->db->join('companywise_allocation cal','buf.id = cal.staff_id','left');
$this->db->join('users us','cal.reassigned_to=us.id','left');
$this->db->join('bdcrm_countries bc','buf.country=bc.id','left');
$this->db->join('bdcrm_master_projects bmp','buf.project_id = bmp.id','left');
$this->db->where('buf.status',1);
$this->db->where('bmp.status',1);
$this->db->group_by('buf.id');
$query=$this->db->get();
$data=$query->result_array();
return count($data);
}

function get_master_project_by_id()
{

if($this->session->userdata('designation_id') == 8 || $this->session->userdata('designation_id') == 1)
{
    $this->db->select('project_name,id');
    $this->db->from('bdcrm_master_projects');
    $this->db->where('status',1);

}else
{
    $this->db->select('DISTINCT(bmp.project_name),bmp.id');
    $this->db->from('bdcrm_uploaded_feildss buf');
    $this->db->join('bdcrm_master_projects bmp','buf.project_id=bmp.id','left');
    $this->db->join('companywise_allocation ca','buf.id=ca.staff_id','left');
    $this->db->where('ca.reassigned_to',$this->session->userdata('id'));
    $this->db->where('bmp.status',1);
}
$query=$this->db->get();
//echo $this->db->last_query();die();
return $query->result_array();
}


function get_callerhis_filter($from_date="",$to_date="",$rowno="",$rowperpage="",$search_text="",$project_id="",$user_id="")
{
  
$this->db->select('bmp.project_name,buf.company_name,bc.name as country_name,buf.region,buf.first_name,buf.last_name,ch.caller_remark,ch.created_at,us.username');
$this->db->from('bdcrm_uploaded_feildss buf');
$this->db->join('bdcrm_master_projects bmp','buf.project_id=bmp.id','left');
$this->db->join('companywise_allocation ca','buf.id=ca.staff_id','left');
$this->db->join('caller_history ch','buf.id=ch.staff_id','left');
$this->db->join('users us','us.id=ca.reassigned_to','left');
$this->db->join('bdcrm_countries bc','bc.id=buf.country','left');

if(!empty($user_id))
{
 $this->db->where('ca.reassigned_to',$user_id);  
}

if($this->session->userdata('designation_id') == 6 || $this->session->userdata('designation_id') == 3)
{
 $this->db->where('ca.reassigned_to',$this->session->userdata('id'));
}

if(!empty($from_date))
{
   $this->db->where('Date(ch.created_at) >=',$from_date);
}else
{
      
   $this->db->where('Date(ch.created_at) >=',date('d-m-Y')); 
}
if(!empty($to_date))
{
   $this->db->where('Date(ch.created_at) <=',$to_date);
}else
{
 $this->db->where('Date(ch.created_at) <=',date('d-m-Y'));   
}
if(!empty($project_id))
{
   $this->db->where_in('buf.project_id',$project_id);
}
if(!empty($search_text))
{
   $this->db->where("(ch.created_at LIKE '%".$search_text."%' OR bmp.project_name LIKE '%".$search_text."%' OR us.username LIKE '%".$search_text."%' OR ch.caller_remark LIKE '%".$search_text."%')", NULL, FALSE); 
}
$this->db->group_by('ch.id');
$this->db->order_by('ch.id',"DESC");
$this->db->limit($rowperpage,$rowno);
$query=$this->db->get();
//echo $this->db->last_query();die();
return $query->result_array();
}

function get_callerhis_filter_count($from_date="",$to_date="",$rowno="",$rowperpage="",$search_text="",$project_id="",$user_id="")
{
$this->db->select('bmp.project_name,buf.company_name,bc.name as country_name,buf.region,buf.first_name,buf.last_name,ch.caller_remark,ch.created_at,us.username');
$this->db->from('bdcrm_uploaded_feildss buf');
$this->db->join('bdcrm_master_projects bmp','buf.project_id=bmp.id','left');
$this->db->join('companywise_allocation ca','buf.id=ca.staff_id','left');
$this->db->join('caller_history ch','buf.id=ch.staff_id','left');
$this->db->join('users us','us.id=ca.reassigned_to','left');
$this->db->join('bdcrm_countries bc','bc.id=buf.country','left');
if(!empty($user_id))
{
 $this->db->where('ca.reassigned_to',$user_id);  
}

if($this->session->userdata('designation_id') == 6 || $this->session->userdata('designation_id') == 3)
{
 $this->db->where('ca.reassigned_to',$this->session->userdata('id'));
}
if(!empty($from_date))
{
   $this->db->where('Date(ch.created_at) >=',$from_date);
}else
{
      
   $this->db->where('Date(ch.created_at) >=',date('d-m-Y')); 
}
if(!empty($to_date))
{
   $this->db->where('Date(ch.created_at) <=',$to_date);
}else
{
 $this->db->where('Date(ch.created_at) <=',date('d-m-Y'));   
}
if(!empty($project_id))
{
   $this->db->where_in('buf.project_id',$project_id);
}
if(!empty($search_text))
{
   $this->db->where("(ch.created_at LIKE '%".$search_text."%' OR bmp.project_name LIKE '%".$search_text."%' OR us.username LIKE '%".$search_text."%' OR ch.caller_remark LIKE '%".$search_text."%')", NULL, FALSE); 
}
$this->db->group_by('ch.id');
$this->db->order_by('ch.id',"DESC");

$query=$this->db->get();
return $query->num_rows();
}

function get_callerhis_filter_count_all($from_date="",$to_date="",$rowno="",$rowperpage="",$search_text="",$project_id="",$user_id="")
{
$this->db->select('bmp.project_name,buf.company_name,bc.name as country_name,buf.region,buf.first_name,buf.last_name,ch.caller_remark,ch.created_at,us.username');
$this->db->from('bdcrm_uploaded_feildss buf');
$this->db->join('bdcrm_master_projects bmp','buf.project_id=bmp.id','left');
$this->db->join('companywise_allocation ca','buf.id=ca.staff_id','left');
$this->db->join('caller_history ch','buf.id=ch.staff_id','left');
$this->db->join('users us','us.id=ca.reassigned_to','left');
$this->db->join('bdcrm_countries bc','bc.id=buf.country','left');
if(!empty($user_id))
{
 $this->db->where('ca.reassigned_to',$user_id);  
}

if($this->session->userdata('designation_id') == 6 || $this->session->userdata('designation_id') == 3)
{
 $this->db->where('ca.reassigned_to',$this->session->userdata('id'));
}
if(!empty($from_date))
{
   $this->db->where('Date(ch.created_at) >=',$from_date);
}else
{
      
   $this->db->where('Date(ch.created_at) >=',date('d-m-Y')); 
}
if(!empty($to_date))
{
   $this->db->where('Date(ch.created_at) <=',$to_date);
}else
{
 $this->db->where('Date(ch.created_at) <=',date('d-m-Y'));   
}
if(!empty($project_id))
{
   $this->db->where_in('buf.project_id',$project_id);
}
if(!empty($search_text))
{
   $this->db->where("(ch.created_at LIKE '%".$search_text."%' OR bmp.project_name LIKE '%".$search_text."%' OR us.username LIKE '%".$search_text."%' OR ch.caller_remark LIKE '%".$search_text."%')", NULL, FALSE); 
}
$this->db->group_by('ch.id');
$this->db->order_by('ch.id',"DESC");

return $this->db->count_all_results();
}


function download_record($from_date="",$to_date="",$project_id="",$user_id="")
{
//$this->db->select('ch.staff_id,bmp.project_name,buf.company_name,bc.name as country_name,buf.region,buf.first_name,buf.last_name,ch.caller_remark,ch.created_at,us.username'); 
$this->db->select('ch.staff_id,bmp.project_name,,buf.company_name,bc.name as country_name,buf.region,buf.first_name,buf.last_name,GROUP_CONCAT(ch.caller_remark SEPARATOR "#") as caller_remark,GROUP_CONCAT(ch.created_at SEPARATOR "#") as created_at,us.username'); 
$this->db->from('bdcrm_uploaded_feildss buf');
$this->db->join('bdcrm_master_projects bmp','buf.project_id=bmp.id','left');
$this->db->join('companywise_allocation ca','buf.id=ca.staff_id','left');
$this->db->join('caller_history ch','buf.id=ch.staff_id','left');
$this->db->join('users us','us.id=ca.reassigned_to','left');
$this->db->join('bdcrm_countries bc','bc.id=buf.country','left');

if(!empty($user_id))
{
 $this->db->where('ca.reassigned_to',$user_id);  
}

if($this->session->userdata('designation_id') == 6 || $this->session->userdata('designation_id') == 3)
{
 $this->db->where('ca.reassigned_to',$this->session->userdata('id'));
}

if(!empty($from_date))
{
   $this->db->where('Date(ch.created_at) >=',$from_date);
}else
{
      
   $this->db->where('Date(ch.created_at) >=',date('d-m-Y')); 
}
if(!empty($to_date))
{
   $this->db->where('Date(ch.created_at) <=',$to_date);
}else
{
 $this->db->where('Date(ch.created_at) <=',date('d-m-Y'));   
}
if(!empty($project_id))
{
   $this->db->where_in('buf.project_id',$project_id);
}

// $this->db->group_by('ch.id');
// $this->db->order_by('ch.id',"DESC");
$this->db->group_by('ch.staff_id');
$this->db->order_by('ch.id',"DESC");

$query=$this->db->get();
//echo $this->db->last_query();die();
return $query->result_array();
}


function excel_download1()
{

$sql = "SELECT buf.id as staff_id,buf.project_id,buf.time_zone,buf.ca1,buf.ca2,buf.sa1,buf.sa2,buf.sa3,buf.sa4,buf.sa5,buf.received_company_name,buf.company_name,buf.postal_code,buf.alternate_number,buf.website_url,buf.address_url,buf.provided_staff_email,buf.staff_email,buf.address1,buf.address2,buf.address3,
buf.city,buf.postal_code,buf.state_county,buf.state_county,bc.name as provided_country,bcc.name as updated_country,bcc.region as region,buf.country_code,buf.address_souce_url,buf.no_of_emp,bi.Industries as industry_type,buf.revenue,bcd.company_dispostion,bwd.web_disposition_name as company_web_disposition,
bccd.caller_disposition as company_voice_disposition,buf.genaral_note,bnp.prefix,buf.first_name,buf.last_name,buf.tel_number,
buf.provided_job_title as provided_job_title,buf.updated_job_title as updated_job_title,buf.activity_type,buf.staff_job_function as job_function,buf.staff_email,
buf.staff_department,buf.staff_url as staff_source_url,buf.assumed_email,buf.staff_email_harvesting as email_source_url,buf.staff_direct_tel,
buf.staff_mobile,bswd.dispositions as web_staff_disposition,bsvd.voice_dispositions as caller_staff_disposition,buf.staff_linkedin_con,
buf.staff_note,buf.research_remark,buf.voice_remark,buf.researcher_company_note,buf.caller_company_note,buf.has_replaced,buf.has_replaced1,
buf.caller_has_replaced,bmp.project_name,buf.caller_has_replaced1,buf.created_date,buf.updated_at,CONCAT(us.first_name,' ',us.last_name) as updated_by,GROUP_CONCAT(ca.reassigned_to) as reassigned_to,GROUP_CONCAT(ca.assigned_by) as assigned_by_date,ca.assigned_at,bmp.project_name,buf.provided_direct_tel
FROM `bdcrm_uploaded_feildss` as buf
Left join bdcrm_master_projects as bmp on buf.project_id = bmp.id
left join bdcrm_countries as bc on buf.provided_country = bc.id
left join bdcrm_countries as bcc on buf.country= bcc.id
left join bdcrm_industries as bi on buf.industry = bi.id
left join bdcrm_company_disposition as bcd on buf.company_disposition = bcd.id
left join bdcrm_web_disposition as bwd on buf.web_disposition=bwd.id
left join bdcrm_caller_disposition as bccd on buf.voice_disposition = bccd.id
left JOIN bdcrm_name_prefix as bnp on buf.suffix = bnp.id
left join bdcrm_staff_web_disposition as bswd on buf.web_staff_disposition = bswd.id
left join bdcrm_staff_voice_dispositions as bsvd on buf.voice_staff_disposition = bsvd.id
left JOIN users as us on buf.updated_by = us.id
left JOIN companywise_allocation as ca on buf.id=ca.staff_id WHERE bmp.status = 1";

$designation_name = $this->session->userdata('designation_name');
if($designation_name=="Caller"){
     $user_id = $this->session->userdata('id');
    $sql .=" AND ca.reassigned_to='".$user_id."'";
}

$sql .=" GROUP by buf.id";

$queryss = $this->db->query($sql);
//echo $this->db->last_query();die();
$data=  $queryss->result_array();

 foreach($data as $total_key => $total_val)
{
    $follow_up_date=$this->getFollowupdate($total_val['staff_id'],$total_val['project_id']);
    $last_remark=$this->getlastremark($total_val['staff_id']);
    $data[$total_key]['follow_up_date'] =$follow_up_date;
    $data[$total_key]['caller_hist_remark'] =$last_remark[0];
    $data[$total_key]['caller_hist_remark_date'] =$last_remark[1];
//     if(!empty($total_val['researcher_company_remark']))
//     {
//         $research_co_remark =$this->getResearcherInfoById($total_val['researcher_company_remark']);
//         $data[$total_key]['researcher_company_remark'] =$research_co_remark;  
       
//     }
//     if(!empty($total_val['research_remark']))
//     {
//         $research_remark =$this->getResearcherRemarkById($total_val['research_remark']);
//         $data[$total_key]['research_remark'] =$research_remark;   
//     }
//     if(!empty($total_val['caller_company_remark']))
//     {
//         $caller_co_remark =$this->getCallerCoRemarkById($total_val['caller_company_remark']);
//         $data[$total_key]['caller_company_remark'] =$caller_co_remark;   
//     }
//     if(!empty($total_val['voice_remark']))
//     {
//         $caller_remark =$this->getCallerRemarkById($total_val['voice_remark']);
//         $data[$total_key]['voice_remark'] =$caller_remark;   
//     }
    if(!empty($total_val['reassigned_to']))
    {
        $reassigned_to =$this->getAssignedToById($total_val['reassigned_to']);
        $data[$total_key]['reassigned_to'] =$reassigned_to;  
       
    }
    if(!empty($total_val['assigned_by_date']))
    {
        $reassigned_to =$this->getAssignedToById($total_val['assigned_by_date']);
        $data[$total_key]['assigned_by_date'] =$reassigned_to;  
       
    }
//     if(!empty($total_val['has_replaced1'] && $total_val['has_replaced']))
//     {
//         if($total_val['activity_type'] == 4)
//         {
//             $data[$total_key]['has_replaced']=$total_val['has_replaced'].'-'.$total_val['has_replaced1'];
//         }else{
//             $data[$total_key]['has_replaced']=$total_val['has_replaced'].'_'.$total_val['has_replaced1'];
//         }
        
//     }
//     if(!empty($total_val['caller_has_replaced1'] && $total_val['caller_has_replaced']))
//     {
//         if($total_val['activity_type'] == 4)
//         { 
//             $data[$total_key]['caller_has_replaced']=$total_val['caller_has_replaced'].'-'.$total_val['caller_has_replaced1']; 
//         }else{
           
//             $data[$total_key]['caller_has_replaced']=$total_val['caller_has_replaced'].'_'.$total_val['caller_has_replaced1']; 
//         }
//     }
 }
return $data;
}
}