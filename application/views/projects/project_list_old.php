<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
    

<style>
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
                <h4 class="page-title">Project List</h4>
            </div>
        </div>

        
    </div>
<!--  <p><?php echo $this->session->flashdata("error");?></p>
 --> <p><?php echo $this->session->flashdata("success");?></p>
<form class="form-horizontal" action='<?php echo base_url('projects/upload_project'); ?>' method="post" enctype="multipart/form-data">
<div class="grey-bg container-fluid">
<section id="minimal-statistics">
<div style="overflow-y: auto;">
    <table id="doc_list_datatable" class="table table-striped table-bordered data-table"  cellspacing="0" width="100%">
    <div class="form-group" style="float:right;">
    </div>
    <thead>
        <tr>
            <th>ID</th>
            <th>Companies</th>
            <th>Staffs</th>
            <th>Project Name</th>
            <th>Project Type</th>
            <th>Task Type</th>
            <th>Company Brief</th>
            <th>Uploaded By</th>
            <th>Created At</th>
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
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="   https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script type="text/javascript">
    var simpletable = $('#doc_list_datatable').DataTable({
    "responsive": true,
    'processing': true,
    'serverSide': true,
    'serverMethod': 'post',
    'language': {
        'processing': '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>',
        searchPlaceholder: ""
        
    },
   'ajax': {
       'url': "<?= base_url() ?>Projects/getprojectrecord",
       'method': "POST",
       'dataType':'json',
       "data": function (data) {
         
       }
   }, 
   createdRow: function (row, data, index) {
        $('td', row).eq(2).addClass('text-capitalize');
    },
});
</script>
