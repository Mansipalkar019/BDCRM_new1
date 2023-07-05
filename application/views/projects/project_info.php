<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
<style>
   #code{width:100%;height:200px}
   .grey-bg {  
   background-color: #F5F7FA;
   }
</style>
<div class="content-page">
   <div class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-12">
               <div class="page-title-box">
                  <center>
                     <h4 class="page-title" style="color: black">Staff Informations of Project : <?= $ProjectInfo[0]['project_name'];?></h4>
                  </center>
               </div>
            </div>
         </div>
         <p><?php echo $this->session->flashdata("error");?></p>
         <p><?php echo $this->session->flashdata("success");?></p>
           <input type="hidden" id="designation_name" name="designation_name" value="<?=$designation_name?>">
         <?php
            if($this->session->userdata('designation_name') == 'Superadmin' || $this->session->userdata('designation_name') == 'Project Manger') {  $style=''; }else{ $style="style='display:none'";} ?> 
         <div id="have_access" <?= $style; ?>>
            <div class="row">
               <input type="hidden" id="id" name="id" value="<?=$id?>">
               <div class="col-md-2">
                  <label>Companies Count</label>
                  <input type="text" name="slot_allocation" id="slot_allocation" class="form-control company_allocation">
               </div>
               <div class="col-md-2">
                  <label>Total Staff</label>
                  <input type="text" name="total_staff_count" id="total_staff_count" class="form-control company_allocation" value='0' readonly>
               </div>
               <div class="col-md-3">
                  <div class="form-group">
                     <div class="page-title-box">
                        <label>Select Status</label>
                        <select  class="form-control company_allocation" id="workalloc" name="workalloc">
                           <option value="">Select Work Type</option>
                           <option value="Assigned">Assigned</option>
                           <option value="Unassigned">Unassigned</option>
                           <option value="Pending">Pending</option>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group">
                     <label>User List</label>
                     <select class="form-control select2 company_allocation" id="user_list" name="user_list[]" multiple>
                        <option value="">Select Assignee</option>
                        <?php foreach ($user_list as $user_list_key => $user_list_row) { ?>
                        <option value="<?=$user_list_row['id']?>"><?=$user_list_row['first_name']." ".$user_list_row['last_name']?></option>
                        <?php }?>
                     </select>
                  </div>
               </div>

               <div class="col-md-2">
                  <div class="form-group">
                     <div>
                        <button class="btn btn-primary" id="btn-search-by-date" style='margin-top:17%'>Assign</button>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="grey-bg container-fluid" style="font-size: 100%">
            <section id="minimal-statistics">
               <br>
               <div style="overflow-y: auto;">
                  <table id="company_staff_count_datatable" class="table table-striped table-bordered "  cellspacing="0" width="100%">
                     <thead>
                        <tr>
                           <th>ID</th>
                           <th>Staff Count</th>
                           <th>Completed Staff Count</th>
                           <th>Company Received</th>
                           <th>Created At</th>
                           <th>Assigned To</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                  </table>
               </div>
            </section>
         </div>
      </div>
   </div>
</div>

