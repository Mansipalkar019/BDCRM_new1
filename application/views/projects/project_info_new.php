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
<div class="container-fluid">

    <div class="row">
       <div class="col-12">
              <div class="page-title-box">
                  <center>
                    <p class="page-title" style="color: black">Staff Informations of Project : <?= $ProjectInfo[0]['project_name'];?></h6>
                    <a  href="<?php echo base_url();?>projects/project_list" class="btn btn-danger btn-sm" style="background-image: linear-gradient(to right,#ff4156,#FF9A49);height: 30px;color:white;float:right"><i class="fa fa-arrow-left "></i> Back</a>
                  </center>
                 
               </div>
              

              <?php
              
              if($this->session->userdata('designation_name')=='Superadmin' || $this->session->userdata('designation_id')==1 || $this->session->userdata('designation_id')==8 || $this->session->userdata('designation_id')==3 || $this->session->userdata('designation_name') == 'Team Leader')
               {
              ?>

               <form  method="post" action="<?php echo base_url('projects/ProjectInfoNew'); ?>">

                  <?php
                  if(empty($id)){
                     $id = $project_id;
                  } 
                  ?>

                  <input type="hidden" name="id" id="id" value="<?=$id?>" class="form-control id">
               <div class="container" id="advancesearchId" style="">
                  <div class="row" style="margin-left: 0%;">

                     <select  class="form-control operators form-control-sm" id="" name="record_type" style="margin-left:15px;width:170px;" required="">
                        <option value="" selected disabled>Select Record Type</option>
                        <option value="All">All</option>
                        <option value="Assigned">Assigned</option>
                        <option value="Unassigned">Unassigned</option>
                        <!-- <option value="Pending">Pending</option> -->
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
                     <select  class="form-control operators form-control-sm" id="operators" name="operator[]" style="margin-left:15px;width:200px;">
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
                     <a href="<?= base_url().'Projects/ProjectInfoNew/'.base64_encode($id); ?>" onclick="return confirm('Are you sure you want to reset the filter..?');" class="btn btn-danger btn-sm" style="margin-left:25px;height: 30px;color:white;"><i class="fa fa-refresh"></i></a>
                  </div>
                  <div id="newRow"></div>
               </div><br><hr>
               </form>
               <form  method="post" action="<?php echo base_url('projects/save_company_allocation_data'); ?>">
               <div class="container">
                  <div class="row">
                      <input type="hidden" name="project_id" id="id" value="<?=$id?>" class="form-control id">
                     <div class="col-sm-3">
                     <label>Records Count</label>
                     <input type="text" name="total_staff_count" placeholder="No. of Records / ex: 2,3,4"  class="form-control form-control-sm" required="">&nbsp;&nbsp;
                    </div>
                    <div class="col-sm-3">
                     <label>Select Users</label>
                      <select class="form-control select2 company_allocation" id="user_list" name="user_list[]" multiple required="">
                           <option value="" disabled="" >Select Assignee</option>
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
            <span class="badge badge-primary">Total Staff : <?= $total_staff;?></span>
            <span class="badge badge-warning">Total Company : <?= $total_company; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
            <b><h7><?= $sqlData;?></h7></b>
         </div>

        
    </div>
 <center><p><b style="color: red;"><?php echo $this->session->flashdata("error");?></b></p></center>
 <center><p><b style="color: green;"><p><?php echo $this->session->flashdata("success");?></b></p></center>
<?php } ?>
<div class="grey-bg container-fluid">
<section id="minimal-statistics">
<div style="overflow-y: auto;"><br>
  <table class="table table-hover table-bordered table-sm p-0 m-0" width="100%" cellspacing="0" id="theTable">
    <div class="form-group" style="float:right;">
    </div>
    <thead>
        <tr>
         <th>ID</th>
         <th>Company Name</th>
         <th>Staff Count</th>
         <th>Completed Staff Count</th>
       <!--   <th>Created At</th> -->
        <!--  <th>Action</th> -->
        </tr>
        </thead>
        <tbody>
         <?php 
         // echo "<pre>";
         // print_r($ProjectInfo);
         // die;
         foreach ($ProjectInfo as $key => $value) {
            $url = "Projects/get_staff_info_new?id=".base64_encode($value['project_id']).'&received_company_name='.base64_encode($value['received_company_name']);
          ?> 
           <tr>

               <td><?= $key+1;?>
                <input type="hidden" name="company_name[]" value="<?= $value['received_company_name']?>">
               </td>
               <td><?= $value['received_company_name'];?></td>
               <td><span><a href='<?= base_url($url) ?>'class="badge btn btn-primary btn-sm" href="#"><?= $value['staff_count'];?></a></span></td>
                <td><span><a class="badge btn btn-warning btn-sm" href="#"><?= $value['updatedcount'];?></a></span></td>
             
               
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


<script type="text/javascript">
    var simpletable = $('#doc_list_datatable').DataTable();
    window.onload = function exampleFunction() {
  
      $("#voice_staff_disposition").select2({
          placeholder: "Select Voice Staff Disposition",
          allowClear: true
      });
    // Function to be executed
}

</script>
