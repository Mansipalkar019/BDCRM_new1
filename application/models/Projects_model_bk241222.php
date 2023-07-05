<?php

class Projects_Model extends CI_Model
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

       if($data[0]['designation_id']=='3,6'){

       $this->db->select('us.id,us.first_name,us.last_name,md.designation_name');
       $this->db->from('users as us');
       $this->db->join('master_designation md','md.id = us.designation','left');
       $this->db->where('us.status',1);
       $this->db->or_where('md.id',3);
       $this->db->or_where('md.id',6); 
       $this->db->order_by("us.first_name");
       $query=$this->db->get();
       $data = $query->result_array();
       }

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
          if(($designation_name=='Researcher') || $designation_name=='Caller'){
            $this->db->select('COUNT(DISTINCT buf.received_company_name) as company_count,COUNT(ca.staff_id) as no_of_staff,GROUP_CONCAT(buf.validation_status) as validation_status');
            $this->db->from('bdcrm_uploaded_feildss buf');
          }else{ $this->db->select('COUNT(DISTINCT buf.received_company_name) as company_count,COUNT(buf.id) as no_of_staff,GROUP_CONCAT(buf.validation_status) as validation_status');
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
            $this->db->where('buf.project_id',$project_id);
            $querys=$this->db->get();
           //echo $this->db->last_query();die();
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
        $this->db->last_query(); 

        $data=$query->result_array();
        foreach($data as $data_key =>$data_val)
        {
            $fdata[]=$data_val['input_name'];
           
        }
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
        $sql ="SELECT GROUP_CONCAT(DISTINCT(bdcrm_uploaded_feildss.received_company_name)) as received_company_name,count(bdcrm_uploaded_feildss.received_company_name) as staff_count, count(bdcrm_uploaded_feildss.updated_status) as completed_updated_status, `bdcrm_uploaded_feildss`.`created_date`, GROUP_CONCAT(DISTINCT(bdcrm_uploaded_feildss.project_id)) as project_id, `bdcrm_uploaded_feildss`.`id`, `bdcrm_master_projects`.`project_name`,`bdcrm_uploaded_feildss`.`validation_status`, GROUP_CONCAT(bdcrm_uploaded_feildss.id) as bdcrm_uploaded_feildss_id,GROUP_CONCAT(bdcrm_uploaded_feildss.validation_status) as validation_status, GROUP_CONCAT(companywise_allocation.assigned_by) as assigned_by, CONCAT(users.first_name,' ',users.last_name) as user_name, COUNT(companywise_allocation.total_count) as total_count FROM `bdcrm_uploaded_feildss` LEFT JOIN `bdcrm_master_projects` ON `bdcrm_uploaded_feildss`.`project_id` = `bdcrm_master_projects`.`id`";
          $designation_name = $this->session->userdata('designation_name');
          $user_id = $this->session->userdata('id');


          if(($designation_name=='Researcher')){
            $sql.="LEFT JOIN `companywise_allocation` ON `bdcrm_uploaded_feildss`.`id` = `companywise_allocation`.`staff_id` LEFT JOIN `users` ON `companywise_allocation`.`reassigned_to` = `users`.`id` WHERE `bdcrm_master_projects`.`id` = '".$project_id."' AND   `companywise_allocation`.`reassigned_to` = '".$user_id."'  AND   `bdcrm_master_projects`.`status` = 1 AND   `companywise_allocation`.`researcher_company_status` = 0 AND `companywise_allocation`.`researcher_project_status` = 0";
          }
          else if($designation_name=='Caller')
          {
            $sql.="LEFT JOIN `companywise_allocation` ON `bdcrm_uploaded_feildss`.`id` = `companywise_allocation`.`staff_id` LEFT JOIN `users` ON `companywise_allocation`.`reassigned_to` = `users`.`id` WHERE `bdcrm_master_projects`.`id` = '".$project_id."' AND   `companywise_allocation`.`reassigned_to` = '".$user_id."'  AND   `bdcrm_master_projects`.`status` = 1 AND   `companywise_allocation`.`caller_company_status` = 0 AND `companywise_allocation`.`caller_project_status` = 0";
          }
          else
          {
            $sql.="LEFT JOIN `companywise_allocation` ON `bdcrm_uploaded_feildss`.`id` = `companywise_allocation`.`staff_id` LEFT JOIN `users` ON `companywise_allocation`.`reassigned_to` = `users`.`id` WHERE `bdcrm_master_projects`.`id` = '".$project_id."' AND `bdcrm_master_projects`.`status` = 1";
          }
       
        $sql.=" GROUP BY `bdcrm_uploaded_feildss`.`received_company_name`";


        //echo $sql; die;

        $query = $this->db->query($sql);
        //echo $this->db->last_query();die();
        return $data =  $query->result_array();


    }
    
    function getProjectInfo($filter,$project_id="",$records_count,$status,$user_idss){
        $sql ="SELECT GROUP_CONCAT(DISTINCT(bdcrm_uploaded_feildss.received_company_name)) as received_company_name,count(bdcrm_uploaded_feildss.received_company_name) as staff_count, count(bdcrm_uploaded_feildss.updated_status) as completed_updated_status, `bdcrm_uploaded_feildss`.`created_date`, GROUP_CONCAT(DISTINCT(bdcrm_uploaded_feildss.project_id)) as project_id, `bdcrm_uploaded_feildss`.`id`, `bdcrm_master_projects`.`project_name`, GROUP_CONCAT(bdcrm_uploaded_feildss.id) as bdcrm_uploaded_feildss_id, GROUP_CONCAT(companywise_allocation.assigned_by) as assigned_by, CONCAT(users.first_name,' ',users.last_name) as user_name,GROUP_CONCAT(bdcrm_uploaded_feildss.validation_status) as validation_status, COUNT(companywise_allocation.total_count) as total_count FROM `bdcrm_uploaded_feildss` LEFT JOIN `bdcrm_master_projects` ON `bdcrm_uploaded_feildss`.`project_id` = `bdcrm_master_projects`.`id` LEFT JOIN `companywise_allocation` ON `bdcrm_uploaded_feildss`.`id` = `companywise_allocation`.`staff_id` LEFT JOIN `users` ON `companywise_allocation`.`reassigned_to` = `users`.`id` WHERE `bdcrm_master_projects`.`id` = '".$project_id."' AND `bdcrm_master_projects`.`status` = 1";
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




        $sql.=" GROUP BY `bdcrm_uploaded_feildss`.`received_company_name`"; 
        if($records_count!=''){
            $sql .= 'LIMIT '. $records_count;
        }


        
        //echo $sql; die;
        $query = $this->db->query($sql);
        //echo $this->db->last_query();die();
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
        //echo $this->db->last_query(); die;
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
        $this->db->where('assigned_by',$assigned_by);
        $this->db->where('staff_id',$staff_id);
        $this->db->where('is_final_submited',0);
        $querys=$this->db->get();
        return $datas =  $querys->result_array();
    }
    function getCompanyInfoDetails($project_id,$cmp_name){
          $designation_name = $this->session->userdata('designation_name');
        $user_id = $this->session->userdata('id');
        $this->db->select('bmp.*,bmap.project_name,GROUP_CONCAT(DISTINCT(buf.received_company_name)) as received_company_name,count(bmp.id) as staffcount,buf.updated_status,count(buf.received_company_name) as staffcount,buf.project_id,buf.id');
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
        $this->db->group_by('buf.received_company_name');
        $querys=$this->db->get();
        return $datas =  $querys->result_array();
    }
    function getStaffInfoDetails($project_id,$company_name){
        $designation_name = $this->session->userdata('designation_name');
          $user_id = $this->session->userdata('id');
        $this->db->select('bmp.*,buf.first_name,buf.last_name,buf.has_replaced,buf.caller_has_replaced,buf.updated_status,buf.received_company_name as comp_name,buf.project_id,buf.id,bswd.dispositions,bsvd.voice_dispositions,bmps.project_type,buf.validation_status');
        $this->db->from('bdcrm_uploaded_feildss buf');
        $this->db->join('bdcrm_company_disposition bmp','buf.company_disposition = bmp.id','left');  
        $this->db->join('bdcrm_staff_web_disposition bswd','buf.web_staff_disposition=bswd.id','left');
        $this->db->join('bdcrm_staff_voice_dispositions bsvd','buf.voice_staff_disposition=bsvd.id','left');  
         $this->db->join('bdcrm_master_projects bmps','buf.project_id=bmps.id','left');        
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
        $this->db->where('buf.received_company_name',$company_name);   
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
         $this->db->select('bmp.*,buf.first_name,buf.last_name,buf.updated_status,buf.received_company_name as comp_name,buf.project_id,buf.id,bswd.dispositions,bsvd.voice_dispositions,bmps.project_type,buf.validation_status');
        $this->db->from('bdcrm_uploaded_feildss buf');
        $this->db->join('bdcrm_company_disposition bmp','buf.company_disposition = bmp.id','left');
        $this->db->join('bdcrm_staff_web_disposition bswd','buf.web_staff_disposition=bswd.id','left');
        $this->db->join('bdcrm_staff_voice_dispositions bsvd','buf.voice_staff_disposition=bsvd.id','left');
        $this->db->join('bdcrm_master_projects bmps','buf.project_id=bmps.id','left');

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
        // $this->db->select('bmp.*,buf.*,bin.Industries,bswd.dispositions,bsvd.voice_dispositions,bcd.company_dispostion,bwd.web_disposition_name,bdcrm_name_prefix.prefix,bdcrm_countries.name as countryname,bdcrm_countries.region');
        // $this->db->from('bdcrm_master_projects bmp');
        // $this->db->join('bdcrm_uploaded_feildss buf','buf.project_id=bmp.id','left');
        // $this->db->join('bdcrm_countries','bdcrm_countries.id=buf.provided_country','left');
        // $this->db->join('bdcrm_name_prefix','bdcrm_name_prefix.id=buf.suffix','left');
        // $this->db->join('bdcrm_industries bin','buf.industry=bin.id','left');
        // $this->db->join('bdcrm_staff_web_disposition bswd','buf.web_staff_disposition=bswd.id','left');
        // $this->db->join('bdcrm_staff_voice_dispositions bsvd','buf.voice_staff_disposition=bsvd.id','left');
        // $this->db->join('bdcrm_company_disposition bcd','buf.company_disposition=bcd.id','left');
        // $this->db->join('bdcrm_web_disposition bwd','buf.web_disposition=bwd.id','left');
       
        // $this->db->where('bmp.status',1);
        // $this->db->where('buf.project_id',$product_id);
        // $query=$this->db->get();
        // //echo $this->db->last_query();die();
        // return $query->result_array();
        $sql = "SELECT buf.id, buf.received_company_name,buf.company_name,buf.postal_code,buf.alternate_number,buf.website_url,buf.address_url,buf.provided_staff_email,buf.staff_email,buf.address1,buf.address2,buf.address3,
        buf.city,buf.postal_code,buf.state_county,buf.state_county,bc.name as provided_country,bcc.name as updated_country,bcc.region as region,buf.country_code,buf.address_souce_url,buf.no_of_emp,bi.Industries as industry_type,buf.revenue,bcd.company_dispostion,bwd.web_disposition_name as company_web_disposition,
        bccd.caller_disposition as company_voice_disposition,buf.genaral_note,bnp.prefix,buf.first_name,buf.last_name,
        buf.provided_job_title as job_title,buf.staff_job_function as job_function,buf.staff_email,
        buf.staff_department,buf.staff_url as staff_source_url,buf.assumed_email,buf.staff_email_harvesting as email_source_url,buf.staff_direct_tel,
        buf.staff_mobile,bswd.dispositions as web_staff_disposition,bsvd.voice_dispositions as caller_staff_disposition,buf.staff_linkedin_con,
        buf.staff_note,buf.research_remark,buf.voice_remark,buf.researcher_company_remark,buf.caller_company_remark,buf.researcher_company_note,buf.caller_company_note,buf.has_replaced,
        buf.caller_has_replaced,buf.created_date,buf.updated_at,CONCAT(us.first_name,' ',us.last_name) as updated_by,bmp.project_name
        FROM `bdcrm_uploaded_feildss` as buf
        Left join bdcrm_master_projects as bmp on buf.project_id = bmp.id
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
        WHERE buf.project_id = $project_id";
       
       
        $queryss = $this->db->query($sql);
        //echo $this->db->last_query();die();
        return $data=  $queryss->result_array();
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

    // function get_final_submit_record($project_id,$user_id){
    //     $this->db->select('ca.*');
    //     $this->db->from('companywise_allocation ca');
    //     $this->db->join('bdcrm_uploaded_feildss buf','ca.staff_id = buf.id','left');
    //     $this->db->where('ca.project_id',$project_id);
    //     $this->db->where('ca.reassigned_to',$user_id);
    //     $this->db->where('ca.status','1');
    //     //$this->db->where('buf.updated_status','Updated');
    //     $querys=$this->db->get();
    //     return $datas =  $querys->result_array();
    // }

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
        $this->db->select('bmp.id as project_id,bmp.project_name,bmp.project_breif,buf.received_company_name,bin.Industries as industry,buf.provided_job_title,buf.city,buf.address1,
        bc.name as country_name,buf.region,bswd.dispositions as web_staff_disposition,buf.provided_staff_email,bcd.company_dispostion as company_disposition,bwd.web_disposition_name as web_disposition,buf.website_url,buf.no_of_emp,buf.revenue,bsvd.voice_dispositions as voice_staff_disposition,buf.id as staff_id,bnp.prefix as salutation,buf.first_name,buf.last_name,CONCAT(us.first_name,us.last_name) as assigned_to,CONCAT(usd.first_name,usd.last_name) as assigned_by,ca.status,buf.created_date,ca.created_at as assigned_at,buf.has_replaced,buf.activity_type');
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
     $this->db->join('bdcrm_web_disposition bwd','buf.web_disposition=bwd.id','left');
     $where = '((ca.status IS NULL OR ca.status=1) AND (bmp.status=1))';
     $this->db->where('buf.received_company_name',$received_company_name);
     ;
     $designation_name = $this->session->userdata('designation_name');
     $user_id = $this->session->userdata('id');
     if(($designation_name=='Researcher') || $designation_name=='Caller'){
        $this->db->where('ca.reassigned_to',$user_id);
     }

     if(!empty($filter)){
        $where .= " AND ".$filter;
        $this->db->where($where);
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
     // /echo $this->db->last_query(); die;
     return $data = $query->result_array();
   
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
    if($main_staff_disposition == 6 && strtolower($task_type) == "named")
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
     if($main_staff_disposition == 6 && strtolower($task_type) == "name with unnamed")
     {
         $this->db->where_in('id',['2']); 
     }
     else if($main_staff_disposition == 3 && strtolower($task_type) == "name with unnamed")
     {
         if($disposition_status == 2)
         { 
             $this->db->where_in('id',['5']); 
         }
         else if($disposition_status == 3){
            
             $this->db->where_in('id',['4']); 
         }
        
     }
     else if($main_staff_disposition == 2 && (strtolower($task_type) == "name with unnamed") && ($first_name == '' || $last_name == '') && $disposition_status == 4)
     {
         $this->db->where_in('id',['2']); 
     }
    
     else if(strtolower($task_type) == "name with unnamed" && $fullname == '' ){
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


 function getstaffvoicedisbytasktype($staff_id,$task_type,$disposition_status,$main_staff_disposition,$caller_has_replaced)
 {
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
     else if($main_staff_disposition == 6 && (strtolower($task_type) == "name with unnamed"))
     {
         $this->db->where_in('id',['2']); 
     }
    else if(strtolower($task_type) == "name with unnamed" && $caller_has_replaced == ''){
        $this->db->where_in('id',['1','3','6','7','2']);
    }
    else{
        $this->db->where_in('id',['1','2','3','4','5','6','7']);  
    }
    $querys=$this->db->get();
     return $data =  $querys->result_array();
    // print_r($data);die();
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

    // echo "<pre>";
    // print_r($data);
    // die;
    $primary_disposition_id = $data[0]['voice_staff_disposition']; 

    // CASE IF STAFF DISPOSITION TYPE IS NO RESULT AND RECORD HAS BEEN ADDED FOR THE SAME 

    if(!empty($primary_disposition_id) && $primary_disposition_id=='6'){
        $checkAddInfo = "SELECT * FROM `bdcrm_uploaded_feildss` WHERE caller_has_replaced='$staff_id' AND activity_type='1'"; 
        $querys = $this->db->query($checkAddInfo);
        $datas =  $querys->result_array();
        $datas = array('button_type'=>"NS",'count'=>count($datas));
     
    }else if(!empty($primary_disposition_id) && $primary_disposition_id=='3'){
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
    }
    return $datas; 

 }


  public function DumpingTable($reference){
      $sql = "CREATE TABLE $reference LIKE bdcrm_uploaded_feildss"; 
      $query = $this->db->query($sql); 
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

 
}
