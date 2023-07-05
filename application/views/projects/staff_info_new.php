<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
    

<style>
.grey-bg {  
background-color: #F5F7FA;
}
#doc_list_datatable{
    text-overflow: ellipsis;
    white-space: nowrap;
    /* display: inline-block; */
    width: 180px;
    width: 180px;
    white-space: nowrap;
    overflow: hidden !important;
    font-size: 15px;
    line-height: 1;
}
#doc_list_datatable tr td p{
    text-overflow: ellipsis;
    white-space: nowrap;
    /* display: inline-block; */
    width: 180px;
    width: 180px;
    white-space: nowrap;
    overflow: hidden !important;
    font-size: 15px;
}
</style>
<div class="content-page">
<div class="content">
<div class="container-fluid"><br>
    <div class="row">
    <div class="col-8">
        <div class="page-title-box">
        
       <h4 class="page-title" style="color: black;float:right">Staff Informations of Project : <?= $received_company_name;?></h4>
       
         
        </div>
        <?php if(!empty($this->session->flashdata("error"))){?>
        <div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <?= $this->session->flashdata("error"); ?>
        </div>
        <?php }
        ?>

        <?php if(!empty($this->session->flashdata("success"))){?>
        <div class="alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <?= $this->session->flashdata("success"); ?>
        </div>
        <?php }
        ?>
    </div>
    <div class="col-md-4">
      <?php

      $url =  "projects/ProjectInfoNew/".$_GET['id']; 
      ?>
    <a  href="<?php echo base_url($url)?>" class="btn btn-danger btn-sm" style="background-image: linear-gradient(to right,#ff4156,#FF9A49);height: 30px;color:white;float:right"><i class="fa fa-arrow-left "></i> Back</a >
    </div>
</div>
 <?php
              $designation_name = $this->session->userdata('designation_name');
              if($this->session->userdata('designation_id')==8 || $this->session->userdata('designation_id')==1)
               {
              ?>
               <?php
                  if(empty($id)){
                     $id = $project_id;
                  } 
                  ?>
               <form  method="post" action="<?php echo base_url('Projects/get_staff_info_new?id='.base64_encode($id)).'&received_company_name='.base64_encode($received_company_name); ?>">
                  <input type="hidden" name="id" id="id" value="<?=$id?>" class="form-control id">
                  <input type="hidden" name="received_company_name" id="id" value="<?=$received_company_name;?>" class="form-control id">
               <div class="container" id="advancesearchId" style="">
                  <div class="row" style="margin-left: 0%;">

                     <select  class="form-control operators form-control-sm" id="" name="record_type" style="margin-left:15px;width:150px;" required="">
                        <option value="" selected disabled>Select Record Type</option>
                        <option value="All">All</option>
                        <option value="Assigned">Assigned</option>
                        <option value="Unassigned">Unassigned</option>
                     </select>&nbsp;&nbsp;&nbsp;


                      <div class="col-sm-2">
                      <select class="form-control operators form-control-sm" id="user_lists" name="user_ids">
                           <option value="" selected disabled="" >Select User</option>
                           <?php foreach ($user_list as $user_list_key => $user_list_row) { ?>
                           <option value="<?=$user_list_row['id']?>"><?=$user_list_row['first_name']." ".$user_list_row['last_name']." (". $user_list_row['designation_name']." )";?></option>
                           <?php }?>
                        </select>
                    </div>

                      <select  class="form-control project_id form-control-sm" id="project_id" name="input_field[]" style="width:150px;">
                      </select>
                     <select  class="form-control operators form-control-sm" id="operators" name="operator[]" style="margin-left:15px;width:150px;">
                        <option value="=">=</option>
                        <option value="!=">!=</option>
                        <option value="LIKE">LIKE</option>
                        <option value="NOT LIKE">NOT LIKE</option>
                        <!-- <option value="NULL">NULL</option> -->
                     </select>
                     <span id="input_type">
                     </span>
                     <a class="btn btn-success btn-sm" id="addRows1" style="margin-left:25px;height: 30px;color:white;"><i class="fa fa-plus"></i></a>
                     <button class="btn btn-primary btn-sm" style="margin-left:25px;height: 30px;color:white;"><i class="fa fa-search"></i></button>
                     <a href="<?= base_url().'Projects/get_staff_info_new?id='.base64_encode($id).'&received_company_name='.base64_encode($received_company_name); ?>" onclick="return confirm('Are you sure you want to reset the filter..?');" class="btn btn-danger btn-sm" style="margin-left:25px;height: 30px;color:white;"><i class="fa fa-refresh"></i></a>
                  </div>
                  <div id="newRow"></div>
               </div><br><hr>
               </form>
               <form  method="post" action="<?php echo base_url('projects/save_staff_allocation_data'); ?>">
               <div class="container">
                  <div class="row">
                      <input type="hidden" name="project_id" id="project_id" value="<?=$id?>" class="form-control id">
                      <input type="hidden" name="company_name" id="company_names" value="<?= $received_company_name;?>" class="form-control id">
                     <div class="col-sm-3">
                     <label>Records Count</label>
                     <input type="number" name="total_staff_count" placeholder="No. of Records / ex: 2,3,4"  class="form-control form-control-sm" required="">&nbsp;&nbsp;
                    </div>
                    <div class="col-sm-3">
                     <label>Select Users</label>
                      <select class="form-control select2 company_allocation" id="user_list" name="users[]" multiple required="">
                           <option value=""  disabled="">Select Users</option>
                           <?php foreach ($user_list as $user_list_key => $user_list_row) { ?>
                            <option value="<?=$user_list_row['id']?>"><?=$user_list_row['first_name']." ".$user_list_row['last_name']." (". $user_list_row['designation_name']." )";?></option>
                           <?php }?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                     <label></label>
                      <button class="btn btn-primary btn-block btn-sm" id="btn_assign_leads" style="margin-top: 4%;width: 71%;">Assign/Re-Assign Leads</button>
                    </div>
                  </div>
          </div><br><hr>
            <span class="badge badge-primary">Total Staff : <?= count($ProjectInfo); ?></span>
            <span class="badge badge-warning">Company Name : <b><?= $received_company_name; ?></b></span>&nbsp;&nbsp;&nbsp;&nbsp;
            <b><h7><?= $sqlData;?></h7></b>
         </div>
    </div>
 <center><p><b style="color: red;"><?php echo $this->session->flashdata("error");?></b></p></center>
 <center><p><b style="color: green;"><p><?php echo $this->session->flashdata("success");?></b></p></center>
<?php } ?>



<div class="grey-bg container-fluid" style="
    font-size: 14px;">
<section id="minimal-statistics">
<div style="overflow-y: auto;"><br>
    <table class="table table-hover table-bordered table-sm p-0 m-0" width="100%" cellspacing="0" id="theTable">
    <div class="form-group" style="float:right;">
    </div>
    <thead>
        <tr>
            <th>ID</th>
            <th>Project</th>
            <th>Staff </th>
            <th>Industry</th>
            <th>Email</th>
            <th>Company</th>
            <th>Company Dispo</th>
            <th>Website</th>
            <th>Emp Size</th>
            <th>Revenue</th>
            <th>Job Title</th>
           <!--  <th>Address</th> -->
            <th>Country</th>
            <th>Region</th>
            <th>Voice Disposition</th>
            <th>Ass. To</th>
            <th>Ass. By</th>
            <th>Created At</th>
            <th>Assigned At</th>
            <?php 
           // if(($designation_name!='Researcher') AND $designation_name!='Caller'){ 
               // echo "<th>Action</th>";
           // }?>
        </tr>
        </thead>
        <tbody>
            <?php 
                foreach ($ProjectInfo as $key => $value) {
                    $url = "Projects/my_projects/".base64_encode($value['project_id'])."/".base64_encode($value['staff_id'])."/".base64_encode($value['received_company_name']);          
                 ?>
                    <tr>
                       <td>
                        <input type="hidden" name="staff_info[]" value="<?= $value['staff_id'];?>">
                        <?= $key+1; ?></td>
                       <td><?= $value['project_name'];?></td>
                       <td><a href="<?= base_url($url); ?>" target="_blank"><?= $value['salutation']." ".$value['first_name']." ".$value['last_name'];?></a></td>
                       <td><?= $value['industry'];?></td>
                       <td><?= $value['provided_staff_email'];?></td>
                       <td><?= $value['company_name'];?></td>
                       <td><?= $value['company_voice_disp'];?></td>
                       <td><?= $value['website_url'];?></td>
                       <td><?= $value['no_of_emp'];?></td>
                       <td><?= $value['revenue'];?></td>
                       <td><?= $value['provided_job_title'];?></td>
                      <!--  <td><?= $value['address1'];?></td> -->
                       <td><?= $value['country_name'];?></td>
                       <td><?= $value['region'];?></td>
                       <td><?= $value['voice_staff_disposition'];?></td>
                       <td><span class='badge btn btn-primary btn-sm'><?= $value['assigned_to'];?></span></td>
                       <td><span class='badge btn btn-warning btn-sm'><?= $value['assigned_by'];?></span></td>
                       <td><?php if(!empty($value['created_date'])){ echo date(('d-m-Y h:i A'),strtotime($value['created_date'])); } ?></td>
                       <td><?php if(!empty($value['assigned_at'])){ echo date(('d-m-Y h:i A'),strtotime($value['assigned_at'])); }?></td>
                     <!--   <td></td> -->
                    </tr>
               <?php }
            ?>
        </tbody>
</table>
</form>
</div>
</section>
</div>
</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>


</script>
