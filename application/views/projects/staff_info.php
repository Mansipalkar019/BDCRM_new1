<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
    

<style>
    #code{width:100%;height:200px}
.grey-bg {  
background-color: #F5F7FA;
}
</style>
<div class="content-page">
<div class="content"
<div class="container-fluid">
<?php 

if($this->session->userdata('designation_name') == 'Superadmin' || $this->session->userdata('designation_name') == 'Project Manger' || $this->session->userdata('designation_name') == 'Team Leader') {?>
<div class="row">
    <div class="col-8">
        <div class="page-title-box">
            <h4 class="page-title" style="color: black">Staff Informations of Project : <?= $received_company_name;?></h4>
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
    <button  href="" onclick="history.back();" class="btn btn-danger btn-sm" style="background-image: linear-gradient(to right,#ff4156,#FF9A49);height: 30px;color:white;float:right"><i class="fa fa-arrow-left "></i> Back</button >
    </div>
</div>

<div class="grey-bg container-fluid" style="font-size: 100%">
<section id="minimal-statistics">
    <div class="row">
    <div class="col-3">
            <div class="page-title-box">
               <label>Enter count</label>
               <input type="text" value="" class="form-control" id="count">
               <input type="hidden" value="<?= $received_company_name;?>" class="form-control" name="company_name" id="company_name">
               <input type="hidden" value="<?= $id;?>" class="form-control" name="project_id" id="project_id">
            </div>
        </div>
        <div class="col-3">
            <div class="page-title-box">
               <label>Select Status</label>
               <select  class="form-control" id="workalloc">
               <option value="">Select Work Type</option>
                <option value="Assigned">Assigned</option>
                <option value="Unassigned">Unassigned</option>
                <option value="Pending">Pending</option>
                </select>
            </div>
        </div>
        <div class="col-3">
            <div class="page-title-box">
               <label>Select Users</label>
               <select  class="form-control users" id="users[]" multiple name="users[]"> 
                <option value="">Select Users</option>
                <?php 
                foreach($users as $user_key => $user_row)
                {?>
                <option value="<?= $user_row['id']; ?>"><?= $user_row['first_name'].' '.$user_row['last_name']; ?></option>
                <?php }
                ?>
                </select>
            </div>
        </div>
        <div class="float-right">
        <button type="submit" value="" class="btn btn-primary form-control" id="btn-search-by-count" style="margin-top:30px;width:125%">Assign</button>
        
        </div> 
    </div>
    
        <br><br><br>
        <?php } ?>
<div style="overflow-y: auto;">
<input type="hidden"  value="<?= $id;?>" id="staff_id">
<input type="hidden"  value="<?= $received_company_name; ?>" id="received_company_name">
    <table id="company_staff_count_datatable" class="table table-striped table-bordered "  cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Project</th>
            <th>Staff </th>
            <th>Industry</th>
            <th>Email</th>
            <th>Company</th>
            <th>Company Dispo</th>
            <th>Company Web Dispo</th>
            <th>Website</th>
            <th>Emp Size</th>
            <th>Revenue</th>
            <th>Job Title</th>
            <th>Address</th>
            <th>Country</th>
            <th>Region</th>
            <th>Web Staff Disposition</th>
            <th>Web Voice Disposition</th>
            <th>Ass. To</th>
            <th>Ass. By</th>
            <th>Created At</th>
            <th>Assigned At</th>
            <th>Staff Id</th>
        </tr>
        </thead>
        
</table>
</div>
</section>
</div>
</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<!-- <script src="   https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script> -->

<script type="text/javascript">
    $(".users").select2({
         placeholder: " Select Users",
         allowClear: true
         });
 
$(document).ready(function (e) {
    var table = $('#company_staff_count_datatable').DataTable({
        'ajax': {
           'url': bases_url + 'projects/getprojectrecord',
           'type':"POST",
           'data': function(data){
            data.staffid=$('#staff_id').val();
            data.received_company_name=$('#received_company_name').val();
            data.count=$('#count').val();
            data.workalloc=$('#workalloc').find(":selected").val();
           }
        },
       
   });
   table.column( 21 ).visible( false );
   $('#btn-search-by-count').click(function () {
    var staff_info = [];
    var count = $('#count').val();
    var users =  $('.users').val();
    var project_id = $('#project_id').val();
    var company_name=$('#received_company_name').val();
    for (var i = 0; i < count; i++) {
            d = table.rows({
               search: 'applied'
            }).nodes()[i];
            if (d) {
                table.column( 21 ).visible( true );
               var td = d.getElementsByTagName("td")[21];
              
               var td_text = td.innerHTML;
               staff_info.push(td_text);
            }
         }
         table.column( 21 ).visible( false );
         if (staff_info) {
               $.ajax({
                  dataType: 'json',
                  type: 'POST',
                  url: bases_url + 'projects/getsInfo',
                  data: {
                    staff_info: staff_info,
                     users: users,
                     project_id: project_id,
                     company_name:company_name,
                  },
                  success: function (response) {
                    if(response.status=='success'){
                        Swal.fire(
                                  'Good job!',
                                    response.message,
                                  'success'
                                ).then((result) => {
                                  if (result.isConfirmed) {
                                    location.reload();
                                  }
                                })
                                setTimeout(function(){location.reload()},3000);
                    } else if(response.status=='failure'){
                        
                        Swal.fire({
                                  title: 'Oops...',
                                  text: response.message,
                                  icon: 'error',
                                  confirmButtonColor: '#3085d6',
                                  confirmButtonText: 'Ok'
                                }).then((result) => {
                                  if (result.isConfirmed) {
                                    setTimeout(function(){location.reload()},2000);
                                  }
                                })
                    }
                    
                  }
               });
            }
});    


   table.on('order.dt search.dt', function () {
      table.column(0, {
         search: 'applied',
         order: 'applied'
      }).nodes().each(function (cell, i) {
         cell.innerHTML = i + 1;
      });
   }).draw();


$("#count").keyup(function(){
    table.ajax.reload();
});
$('#workalloc').change(function(){
        table.ajax.reload();
    });

});


</script>
