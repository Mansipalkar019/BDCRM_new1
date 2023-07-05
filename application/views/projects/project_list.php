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
        <div class="col-6">
            <div class="page-title-box">
                <h4 class="page-title">Project List</h4>
            </div>
        </div>


        <?php

        $designation_name = $this->session->userdata('designation_name');
        if($designation_name=="Superadmin"){

        ?>
        <div class="col-6" >
           <div class="page-title-box">
              <a type='submit' href="<?php echo base_url(); ?>projects/new_projects" class='btn btn-purple btn-sm waves-effect waves-light' style="float:right;background-color: #357a95;margin-top:20px;margin-right:3%;background-image: linear-gradient(to right,#ff4156,#FF9A49);">New Project</a>
            </div>
        </div>

    <?php } ?>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="page-title-box">
                 <a type='submit' href="<?php echo base_url(); ?>projects/excel_download1" class='btn btn-purple btn-sm waves-effect waves-light' style="float:left;background-color: #357a95;margin-top:20px;margin-right:3%;background-image: linear-gradient(to right,#ff4156,#FF9A49);">Excel Download</a>
            </div>
        </div>

    </div>
 <?php
 $designation_name = $this->session->userdata('designation_name');?>
 <?php if($this->session->flashdata("success") != ''){?>
 <div class="alert alert-success alert-dismissible" style="padding: 25px;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close" style="font-size: 17px;left: 0 !important;"><?php echo $this->session->flashdata("success");?></a>
</div>
 <?php } ?>
 
<form class="form-horizontal" action='<?php echo base_url('projects/upload_project'); ?>' method="post" enctype="multipart/form-data">
<div class="grey-bg container-fluid">
<section id="minimal-statistics">
<div style="overflow-y: auto;"><br>
    <table id="doc_list_datatable" class="table table-striped table-bordered data-table"  cellspacing="0" width="100%">
    <div class="form-group" style="float:right;">
    </div>
    <thead>
        <tr>
            <th>ID</th>
            <th>Project Name</th>
            <th>Companies</th>
            <th>Staffs</th>
            <th>Task Type</th>
            <th>Project Type</th>
          <!--   <th>Company Brief</th> -->
            <th>Uploaded By</th>
            <th>Created At</th>
            <th>Action</th>
         
        </tr>
        </thead>
        <tbody>
            <?php 
                foreach ($projects as $key => $value) { ?>
                    <tr>
                        <td><?= $key+1; ?></td>
                        <td><span><a href='<?= base_url().'Projects/ProjectInfoNew/'.base64_encode($value['id']); ?>'class="badge btn btn-primary btn-sm" href="#"><?= $value['project_name'];?></a></span></td>
                        <td><span><a class="badge rounded-pill bg-success" href="#"><?= $value['company_count'];?></a></span></td>
                        <td><span><a class="badge rounded-pill bg-dark" href="#"><?= $value['no_of_staff'];?></a></span></td>
                        <td><?= $value['project_type'];?></td>
                        <td><?= $value['task_type'];?></td>
                       <!--  <td><P><?= $value['project_breif'];?></P></td> -->
                        <td><?= $value['username'];?></td>
                        <td><?= date(('d-m-Y h:i A'),strtotime($value['created_at']));?></td>
                        
                        <td>
                              <?php 
                           if(($designation_name!='Researcher') AND $designation_name!='Caller'){ ?>
                           <!--  <a href="<?= base_url().$value['file_path']; ?>" title='Download File'><i class="fas fa-download"></i></a> -->
                           &nbsp; <a onclick=" return confirm('are you sure you want to delete this project')" href="<?= base_url().'Projects/DeleteProjects/'.$value['id']; ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                             <?php } ?>
                           &nbsp; <a href="<?= base_url().'Projects/excel_download?id='.base64_encode($value['id']); ?>"><i class="fas fa-download"></i></i></a>
                        </td>
                       

                    </tr>
                    
                <?php }


            ?>
        </tbody>
</table>
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
<script type="text/javascript">
    var simpletable = $('#doc_list_datatable').DataTable();
    window.onload = function exampleFunction() {
  
    // Function to be executed
}

</script>
