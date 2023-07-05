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


    function getprojectrecord(){
        
    $designation_name = $this->session->userdata('designation_name');
    $user_id = $this->session->userdata('id');
    $this->db->select('bmp.id,bmp.project_name,bmp.project_breif,bpt.project_type,bpts.project_type as task_type,bmp.created_at,bmp.created_by,bmp.file_name,bmp.file_path,us.username');
    $this->db->from('bdcrm_master_projects as bmp');
    $this->db->join('bdcrm_project_type bpt','bmp.task_type = bpt.id','left');
    $this->db->join('bdcrm_project_types bpts','bmp.project_type = bpts.id','left');
    $this->db->join('users us','bmp.created_by = us.id','left');
    if(($designation_name=='Researcher') || $designation_name=='Caller'){
       $this->db->join('companywise_allocation ca','bmp.id = ca.project_id','left');
       $this->db->where('ca.user_id',$user_id);
       $this->db->where('ca.is_final_submited',0);
       $this->db->group_by('bmp.id');
    }
    $this->db->where('bmp.status','1');
    $this->db->order_by("bmp.id", "DESC");
    $query=$this->db->get();
    $this->db->last_query(); 
    $data = $query->result_array();
    $fData=[];
    foreach ($data as $key => $value) {
        $project_id = $value['id'];
        $info = $this->getCompanyInfoByProjectId($project_id);
        $value['company_count'] = $info['company_count'];
        $value['no_of_staff'] = $info['no_of_staff'];
        $fData[] = $value;
    }
 return $fData;
}


    function getCompanyInfoByProjectId($project_id){
            $this->db->select('COUNT(DISTINCT buf.received_company_name) as company_count,COUNT(buf.id) as no_of_staff');
            $this->db->from('bdcrm_uploaded_feildss buf');
            $designation_name = $this->session->userdata('designation_name');
            $user_id = $this->session->userdata('id');
            if(($designation_name=='Researcher') || $designation_name=='Caller'){
                    $this->db->join('companywise_allocation ca','buf.id = ca.staff_id','left');
                    $this->db->where('ca.user_id',$user_id);
                    $this->db->where('ca.status',1);
                }
            $this->db->where('buf.project_id',$project_id);
            $querys=$this->db->get();
            $this->db->last_query(); 
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


    function get_staff_info($project_id="",$received_company_name="",$rowno="",$rowperpage="",$workstatus=""){
        
        $this->db->select('bmp.id as project_id,bmp.project_name,bmp.project_breif,buf.received_company_name,bin.Industries as industry,buf.provided_job_title,buf.city,buf.address1,
     bc.name as country_name,buf.region,bswd.dispositions as web_staff_disposition,buf.provided_staff_email,bcd.company_dispostion as company_disposition,bwd.web_disposition_name as web_disposition,buf.website_url,buf.no_of_emp,buf.revenue,bsvd.voice_dispositions as voice_staff_disposition,buf.id as staff_id,bnp.prefix as salutation,buf.first_name,buf.last_name,CONCAT(us.first_name,us.last_name) as assigned_to,CONCAT(usd.first_name,usd.last_name) as assigned_by,ca.status,buf.created_date,ca.created_at as assigned_at');
     $this->db->from('bdcrm_uploaded_feildss as buf');
     $this->db->join('bdcrm_master_projects bmp','buf.project_id = bmp.id','left');
     $this->db->join('bdcrm_countries bc','buf.provided_country = bc.id','left');
     $this->db->join('bdcrm_name_prefix bnp','buf.suffix = bnp.id','left');
     $this->db->join('companywise_allocation ca','buf.id = ca.staff_id','left');
     $this->db->join('users us','ca.user_id=us.id','left');
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
     $this->db->where('bmp.id',$project_id);
     $user_id = $this->session->userdata('id');
     if(($designation_name=='Researcher') || $designation_name=='Caller'){
        $this->db->where('ca.user_id',$user_id);
     }
     $this->db->where($where);
     if($workstatus==1)
     {
         $this->db->where('ca.assigned_by !=""');
     }
     elseif($workstatus==2){
         $this->db->where('ca.assigned_by IS NULL');
     }
     $this->db->limit($rowperpage,$rowno);
     $this->db->group_by('buf.id');
      $query=$this->db->get();
    //echo  $this->db->last_query(); die;
     return $data = $query->result_array();
 }
    
    function get_no_staff_info($project_id="",$received_company_name="",$rowno="",$rowperpage="",$workstatus=""){
         $this->db->select('cmpallo.status as assigne_status,cmpallo.*,buf.*,bmp.project_name,bcn.name as country_name,bnp.prefix as salutation,CONCAT(us.first_name," ",us.last_name) as assigned_to,users.username,md.designation_name');
        $this->db->from('bdcrm_uploaded_feildss as buf');
        $this->db->join('bdcrm_master_projects bmp','buf.project_id = bmp.id','left');
        $this->db->join('bdcrm_countries bcn','buf.provided_country = bcn.id','left');
        $this->db->join('bdcrm_name_prefix bnp','buf.suffix = bnp.id','left');
        $this->db->join('companywise_allocation cmpallo','buf.id = cmpallo.staff_id','left');
        $this->db->join('users users','cmpallo.assigned_by=users.id','left');
        $this->db->join('users us','cmpallo.user_id=us.id','left');
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
        $this->db->join('users us','cmpallo.user_id=us.id','left');
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
    
     function getProjectInfo($filter,$project_id="",$records_count,$status){
        $sql ="SELECT GROUP_CONCAT(DISTINCT(bdcrm_uploaded_feildss.received_company_name)) as received_company_name,count(bdcrm_uploaded_feildss.received_company_name) as staff_count, count(bdcrm_uploaded_feildss.updated_status) as completed_updated_status, `bdcrm_uploaded_feildss`.`created_date`, GROUP_CONCAT(DISTINCT(bdcrm_uploaded_feildss.project_id)) as project_id, `bdcrm_uploaded_feildss`.`id`, `bdcrm_master_projects`.`project_name`, GROUP_CONCAT(bdcrm_uploaded_feildss.id) as bdcrm_uploaded_feildss_id, GROUP_CONCAT(companywise_allocation.assigned_by) as assigned_by, CONCAT(users.first_name,' ',users.last_name) as user_name, COUNT(companywise_allocation.total_count) as total_count FROM `bdcrm_uploaded_feildss` LEFT JOIN `bdcrm_master_projects` ON `bdcrm_uploaded_feildss`.`project_id` = `bdcrm_master_projects`.`id` LEFT JOIN `companywise_allocation` ON `bdcrm_uploaded_feildss`.`id` = `companywise_allocation`.`staff_id` LEFT JOIN `users` ON `companywise_allocation`.`reassigned_to` = `users`.`id` WHERE `bdcrm_master_projects`.`id` = '".$project_id."' AND `bdcrm_master_projects`.`status` = 1";
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
        }



        $sql.=" GROUP BY `bdcrm_uploaded_feildss`.`received_company_name`";
        if($records_count!=''){
            $sql .= 'LIMIT '. $records_count;
        }

        $query = $this->db->query($sql);
        return $data =  $query->result_array();
    }
    
    
     function getProjectInfoById($project_id){
        $sql ="SELECT GROUP_CONCAT(DISTINCT(bdcrm_uploaded_feildss.received_company_name)) as received_company_name,count(bdcrm_uploaded_feildss.received_company_name) as staff_count, count(bdcrm_uploaded_feildss.updated_status) as completed_updated_status, `bdcrm_uploaded_feildss`.`created_date`, GROUP_CONCAT(DISTINCT(bdcrm_uploaded_feildss.project_id)) as project_id, `bdcrm_uploaded_feildss`.`id`, `bdcrm_master_projects`.`project_name`, GROUP_CONCAT(bdcrm_uploaded_feildss.id) as bdcrm_uploaded_feildss_id, GROUP_CONCAT(companywise_allocation.assigned_by) as assigned_by, CONCAT(users.first_name,' ',users.last_name) as user_name, COUNT(companywise_allocation.total_count) as total_count FROM `bdcrm_uploaded_feildss` LEFT JOIN `bdcrm_master_projects` ON `bdcrm_uploaded_feildss`.`project_id` = `bdcrm_master_projects`.`id` LEFT JOIN `companywise_allocation` ON `bdcrm_uploaded_feildss`.`id` = `companywise_allocation`.`staff_id` LEFT JOIN `users` ON `companywise_allocation`.`reassigned_to` = `users`.`id` WHERE `bdcrm_master_projects`.`id` = '".$project_id."' AND `bdcrm_master_projects`.`status` = 1";
          $designation_name = $this->session->userdata('designation_name');
          $user_id = $this->session->userdata('id');
          if(($designation_name=='Researcher') || $designation_name=='Caller'){
            $sql.="LEFT JOIN `users` ON `companywise_allocation`.`reassigned_to` = '".$user_id."' WHERE `bdcrm_master_projects`.`id` = '".$project_id."' AND `bdcrm_master_projects`.`status` = 1";
          }
        if($filter != '')
        {
            $sql.=' AND'.'('.$filter.')';
        }
        $sql.=" GROUP BY `bdcrm_uploaded_feildss`.`received_company_name`";
        if(!empty($slot_count))
        {
            $sql.=" LIMIT ".$slot_count;
        }
       // echo $sql; die;

        $query = $this->db->query($sql);
        return $data =  $query->result_array();


    }
    

    function getProjectInfoByStaffId($pid,$sid){
        
        // $this->db->select('ca.user_id as assigned_to,buf.*,bmp.project_name,bmp.project_breif');
        // $this->db->from('bdcrm_uploaded_feildss as buf');
        // $this->db->join('bdcrm_master_projects bmp','buf.project_id = bmp.id','left');
        // $this->db->join('companywise_allocation ca','buf.id = ca.staff_id','left');
        // $this->db->where('buf.project_id',$pid);
        // $this->db->where('buf.id',$sid);
        // $this->db->where('bmp.status',1);
         $this->db->select('ca.user_id as assigned_to,buf.*,bmp.project_name,bmp.project_breif,bdctry.name as countryname,bcd.company_dispostion as companydispostion,bi.Industries as industryname,bwd.web_disposition_name as webdispositionname,bcld.caller_disposition as voicedispositionname,bswd.dispositions as webstaffdis,bsvd.voice_dispositions as voicestaffdis');
        $this->db->from('bdcrm_uploaded_feildss as buf');
        $this->db->join('bdcrm_master_projects bmp','buf.project_id = bmp.id','left');
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
        $data[0]['company_count']=$info['company_count'];
        $data[0]['no_of_staff']=$info['no_of_staff'];
        return $data;
    }

    // function getStaffInfoDetails($project_id,$company_name){
    //     $this->db->select('bmp.*,buf.first_name,buf.last_name,buf.updated_status,buf.received_company_name as comp_name,buf.project_id,buf.id');
    //     $this->db->from('bdcrm_uploaded_feildss buf');
    //     $this->db->join('bdcrm_company_disposition bmp','buf.company_disposition = bmp.id','left');
    //       $designation_name = $this->session->userdata('designation_name');
    //       $user_id = $this->session->userdata('id');
    //       if(($designation_name=='Researcher') || $designation_name=='Caller'){
    //          $this->db->join('companywise_allocation ca','buf.id = ca.staff_id','left');
    //          $this->db->where('ca.user_id',$user_id);
    //          $this->db->where('ca.status',1);
    //          $where = '(ca.status IS NULL OR ca.status=1)';
    //          $this->db->where($where);
    //       }
        
    //     $this->db->where('buf.project_id',$project_id);
    //     $this->db->where('buf.received_company_name',$company_name);
    //     //$this->db->group_by('');
  
          
    //     $querys=$this->db->get();
    //      $this->db->last_query(); 
    //     return $datas =  $querys->result_array();
    // }

    // function getAllStaffInfoDetails($project_id){
    //     $this->db->select('bmp.*,buf.first_name,buf.last_name,buf.updated_status,buf.received_company_name as comp_name,buf.project_id,buf.id');
    //     $this->db->from('companywise_allocation ca');
    //     $this->db->join('bdcrm_uploaded_feildss buf','ca.staff_id = buf.id','left');
    //     $this->db->join('bdcrm_company_disposition bmp','buf.company_disposition = bmp.id','left');
    //     $this->db->where('buf.project_id',$project_id);
    //     if($this->session->userdata('designation_name') != 'Superadmin' && $this->session->userdata('designation_name') != 'Project Manger' && $this->session->userdata('designation_name') != 'Team Leader'){
    //         $this->db->where('ca.user_id',$this->session->userdata('id'));
    //     }
    //     $this->db->where('ca.status','1');
    //     $querys=$this->db->get();
    //     //echo $this->db->last_query();die();
    //     return $datas =  $querys->result_array();
    // }

    // function getCompanyInfoDetails($project_id,$cmp_name){
     
    //     $this->db->select('buf.id,buf.received_company_name,buf.project_id,count(buf.received_company_name) as staffcount');
    //     $this->db->distinct('received_company_name');
    //     $this->db->from('bdcrm_uploaded_feildss buf');
    //     $this->db->where('project_id',$project_id);
    //     $this->db->group_by('received_company_name');
    //     $querys=$this->db->get();
    //     // echo $this->db->last_query();die();
    //     return $datas =  $querys->result_array();
    // }
    function getCompanyInfoDetails($project_id,$cmp_name){
          $designation_name = $this->session->userdata('designation_name');
        $user_id = $this->session->userdata('id');
        $this->db->select('bmp.*,bmap.project_name,GROUP_CONCAT(DISTINCT(buf.received_company_name)) as received_company_name,count(bmp.id) as staffcount,buf.updated_status,count(buf.received_company_name) as staffcount,buf.project_id,buf.id');
        // $this->db->distinct('received_company_name');
        $this->db->from('bdcrm_uploaded_feildss buf');
        $this->db->join('bdcrm_company_disposition bmp','buf.company_disposition = bmp.id','left');
        $this->db->join('bdcrm_master_projects bmap','buf.project_id = bmap.id','left');

          if(($designation_name=='Researcher') || $designation_name=='Caller'){
             $this->db->join('companywise_allocation ca','buf.id = ca.staff_id','left');
             $this->db->where('ca.user_id',$user_id);
             $this->db->where('ca.status',1);
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
        // $this->db->select('bmp.*,buf.first_name,buf.last_name,buf.updated_status,buf.received_company_name as comp_name,buf.project_id,buf.id');
        // $this->db->from('bdcrm_uploaded_feildss buf');
        // $this->db->join('bdcrm_company_disposition bmp','buf.company_disposition = bmp.id','left');     
          $this->db->select('bmp.*,buf.first_name,buf.last_name,buf.updated_status,buf.received_company_name as comp_name,buf.project_id,buf.id,bswd.dispositions,bsvd.voice_dispositions');
        $this->db->from('bdcrm_uploaded_feildss buf');
        $this->db->join('bdcrm_company_disposition bmp','buf.company_disposition = bmp.id','left');  
        $this->db->join('bdcrm_staff_web_disposition bswd','buf.web_staff_disposition=bswd.id','left');
        $this->db->join('bdcrm_staff_voice_dispositions bsvd','buf.voice_staff_disposition=bsvd.id','left');         
          if(($designation_name=='Researcher') || $designation_name=='Caller'){
             $this->db->join('companywise_allocation ca','buf.id = ca.staff_id','left');
             $this->db->where('ca.user_id',$user_id);
             $this->db->where('ca.status',1);
             $where = '(ca.status IS NULL OR ca.status=1)';
             $this->db->where($where);
          }
        
        $this->db->where('buf.project_id',$project_id);
        $this->db->where('buf.received_company_name',$company_name);   
        $querys=$this->db->get();
        return $datas =  $querys->result_array();
    }

    function getAllStaffInfoDetails($project_id){
        //  $this->db->select('bmp.*,buf.first_name,buf.last_name,buf.updated_status,buf.received_company_name as comp_name,buf.project_id,buf.id');
        // $this->db->from('bdcrm_uploaded_feildss buf');
        // $this->db->join('bdcrm_company_disposition bmp','buf.company_disposition = bmp.id','left');
         $this->db->select('bmp.*,buf.first_name,buf.last_name,buf.updated_status,buf.received_company_name as comp_name,buf.project_id,buf.id,bswd.dispositions,bsvd.voice_dispositions');
        $this->db->from('bdcrm_uploaded_feildss buf');
        $this->db->join('bdcrm_company_disposition bmp','buf.company_disposition = bmp.id','left');
        $this->db->join('bdcrm_staff_web_disposition bswd','buf.web_staff_disposition=bswd.id','left');
        $this->db->join('bdcrm_staff_voice_dispositions bsvd','buf.voice_staff_disposition=bsvd.id','left');

          $designation_name = $this->session->userdata('designation_name');
          $user_id = $this->session->userdata('id');
          if(($designation_name=='Researcher') || $designation_name=='Caller'){
             $this->db->join('companywise_allocation ca','buf.id = ca.staff_id','left');
             $this->db->where('ca.user_id',$user_id);
             $this->db->where('ca.status',1);
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
          if(($designation_name=='Researcher') || $designation_name=='Caller'){
             $this->db->join('companywise_allocation ca','bdcrm_uploaded_feildss.id = ca.staff_id','left');
             $this->db->where('ca.user_id',$user_id);
             $this->db->where('ca.status',1);
             $where = '(ca.status IS NULL OR ca.status=1)';
             // $this->db->where($where);
          }
            $this->db->where('bdcrm_uploaded_feildss.project_id',$project_id);
            // $this->db->where('received_company_name',$cmp_name);
            $querys=$this->db->get();
            //echo $this->db->last_query();die();
            return $datas =  $querys->row_array();  
    }

 function excel_download($product_id="")
    {
        $this->db->select('bmp.*,buf.*,bin.Industries,bswd.dispositions,bsvd.voice_dispositions,bcd.company_dispostion,bwd.web_disposition_name,bdcrm_name_prefix.prefix,bdcrm_countries.name as countryname,bdcrm_countries.region');
        $this->db->from('bdcrm_master_projects bmp');
        $this->db->join('bdcrm_uploaded_feildss buf','buf.project_id=bmp.id','left');
        $this->db->join('bdcrm_countries','bdcrm_countries.id=buf.provided_country','left');
        $this->db->join('bdcrm_name_prefix','bdcrm_name_prefix.id=buf.suffix','left');
        $this->db->join('bdcrm_industries bin','buf.industry=bin.id','left');
        $this->db->join('bdcrm_staff_web_disposition bswd','buf.web_staff_disposition=bswd.id','left');
        $this->db->join('bdcrm_staff_voice_dispositions bsvd','buf.voice_staff_disposition=bsvd.id','left');
        $this->db->join('bdcrm_company_disposition bcd','buf.company_disposition=bcd.id','left');
        $this->db->join('bdcrm_web_disposition bwd','buf.web_disposition=bwd.id','left');
       
        $this->db->where('bmp.status',1);
         $this->db->where('buf.project_id',$product_id);
        $query=$this->db->get();
        //echo $this->db->last_query();die();
        return $query->result_array();
    }

    function getautocompleteofdata($search_term, $tablename, $field_name){
        if($this->db->table_exists($tablename)){
            $this->db->select("*");
            $this->db->from($tablename);
    
            $this->db->like("LOWER(".$field_name.")", $search_term);
           
            $this->db->group_by($field_name);
            $query = $this->db->get();
            //echo $this->db->last_query();die();
            $result = $query->result_array();
        }else{
            $result = array();
        }
        return $result;
    }

    
}
