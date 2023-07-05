<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

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
.select2-search__field{
   width: 150.5px !important;
}
</style>
<div class="content-page">
<div class="content">
<div class="container-fluid">

    <div class="row">
       <div class="col-12">
              <div class="page-title-box">
                  <center>
                    <p class="page-title" style="color: black">Search Caller History Reports: <?= $ProjectInfo[0]['project_name'];?></h6>
                    <a  href="<?php echo base_url();?>projects/project_list" class="btn btn-danger btn-sm" style="background-image: linear-gradient(to right,#ff4156,#FF9A49);height: 30px;color:white;float:right"><i class="fa fa-arrow-left "></i> Back</a>
                  </center>
                 
               </div>
              

             

               <!--<form  method="post" action="<?php// echo base_url('projects/getcallerhistorys'); ?>">-->

                  <?php
                  if(empty($id)){
                     $id = $project_id;
                  } 
                  ?>

                  <input type="hidden" name="id" id="id" value="<?=$id?>" class="form-control id">
               <div class="container-fluid" id="advancesearchId" style="">
                  <div class="row" style="margin-left: 0%;">

                 
                     <select  class="form-control operators form-control-sm" id="project_id" name="project_id" style="margin-left:15px;width:300px;" required="" multiple="">
                        <option value="" selected disabled>Select Project</option>
                         <?php foreach ($master_project as $master_project_key => $master_project_row) { ?>
                        <option value="<?=$master_project_row['id']?>"><?=$master_project_row['project_name'];?></option>
                        <?php }?>
                        <!-- <option value="Pending">Pending</option> -->
                     </select>&nbsp;&nbsp;&nbsp;
                <?php
    
                  if($this->session->userdata('designation_name')=='Superadmin' || $this->session->userdata('designation_id')==8 ||  $this->session->userdata('designation_name') == 'Team Leader'){
                  ?>
                     <div class="col-sm-2">
                      <select class="form-control operators form-control-sm" id="user_lists" name="user_ids">
                           <option value="" selected disabled="" >Select User</option>
                           <?php foreach ($user_list as $user_list_key => $user_list_row) { ?>
                           <option value="<?=$user_list_row['id']?>"><?=$user_list_row['first_name']." ".$user_list_row['last_name'];?></option>
                           <?php }?>
                        </select>
                    </div>
                    <?php } ?>
                      <label for="tel_number" class="col-form-label" style="font-size:15px !important;">From Date: </label>
                     <input type="date" name="from_date1" id="fromdate1"  class="form-control mr-2 datepicker" style="width:150px;" placeholder="From Date">
                     
                      <label for="tel_number" class="col-form-label" style="font-size:15px !important;">To Date: </label>
                     <input type="date" class="form-control mr-2 datepicker" name="to_date1" id="todate1" style="width:150px;" placeholder="To Date">
                     
                     <button class="btn btn-primary btn-sm" type="submit" style="margin-left:25px;height: 30px;color:white;" id=search><i class="fa fa-search"></i></button>
                     
                     <a href="<?= base_url().'Projects/caller_remark_his'; ?>" onclick="return confirm('Are you sure you want to reset the filter..?');" class="btn btn-danger btn-sm" style="margin-left:25px;height: 30px;color:white;"><i class="fa fa-refresh"></i></a>
                     <button class="btn btn-success btn-sm" type="submit" style="margin-left:25px;height: 30px;color:white;" id=excel_download>Download CSV</button>
                  </div>
                  <div id="newRow"></div>
               </div><br><hr>
               <!--</form>-->
              
         </div>

        
    </div>
 <center><p><b style="color: red;"><?php echo $this->session->flashdata("error");?></b></p></center>
 <center><p><b style="color: green;"><p><?php echo $this->session->flashdata("success");?></b></p></center>
<?php //} ?>
<div class="grey-bg container-fluid">
<section id="minimal-statistics">
<div style="overflow-y: auto;"><br>
  <table id="doc_list_datatable" class="display" style="width:100%">
    
        <thead>
        <tr>
         <th>Project Name</th>
         <th>Company Name</th>
         <th>Country</th>
         <th>Region</th>
         <th>Staff Name</th>
         <th>Caller Remark</th>
         <th>Created At</th>
         <th>Username</th>
     
        </tr>
        </thead>
       
</table>


</div>
</section>
</div>
</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script type="text/javascript">
var simpletable = $('#doc_list_datatable').DataTable({
 
            // aoColumns : [
            //   { sWidth: '5%' },
            //   { sWidth: '5%' },
            //   { sWidth: '5%' },
            //   { sWidth: '5%' },
            //   { sWidth: '15%' },
            //   { sWidth: '5%' },
            // ],
          
            "responsive": true,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'language': {
              'processing': '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>',
              searchPlaceholder: ""
               
            },
            'ajax': {
              'url': "<?= base_url() ?>Projects/getcallerhistorys",
              'method': "POST",
              'dataType':'json',
              "data": function (data) {
                  data.from_date = $('#fromdate1').val();
                  data.to_date = $('#todate1').val();
                  data.project_id = $('#project_id').val();
                  data.user_lists=$('#user_lists').val();
              }
            }, 
            createdRow: function (row, data, index) {
              $('td', row).eq(2).addClass('text-capitalize');
            },
            columnDefs: [{
    "defaultContent": "-",
    "targets": "_all"
  }]
         });
        $("#search").click(function(){
         console.log($('#project_id').val());

           simpletable.ajax.reload(null, false); //just reload table
         });


         $("#excel_download").click(function(){
           $.ajax({
				type:"POST",
				async: "true",
				url:"<?php echo base_url(); ?>Projects/call_history_download",
				dataType:"json",
				data:{
					fromdate:$('#fromdate1').val(),
                    todate:$('#todate1').val(),
                    project_id:$('#project_id').val(),
                    user_lists:$('#user_lists').val(),
				},
				success: function(response)
				{
				    console.log(response['url']);
                 window.location.replace(response['url']);
				}
			});
         });
         
         $("#project_id").select2({
    placeholder: "Select Project Name",
    allowClear: true,
});  
</script>
