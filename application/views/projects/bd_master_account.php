<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
    

<style>
tfoot {
    display: table-row-group;
    }
#pagination{
margin: 40 40 0;
}
ul.tsc_pagination li a
{
border:solid 1px;
border-radius:3px;
-moz-border-radius:3px;
-webkit-border-radius:3px;
padding:6px 9px 6px 9px;
}
ul.tsc_pagination li strong
{
border:solid 1px;
border-radius:3px;
-moz-border-radius:3px;
-webkit-border-radius:3px;
padding:6px 9px 6px 9px;
}
ul.tsc_pagination li
{
padding-bottom:1px;
}
ul.tsc_pagination li a:hover,
ul.tsc_pagination li a.current
{
color:#FFFFFF;
box-shadow:0px 1px #EDEDED;
-moz-box-shadow:0px 1px #EDEDED;
-webkit-box-shadow:0px 1px #EDEDED;
}
ul.tsc_pagination
{
margin:25px 0;
padding:0px;
height:100%;
overflow:hidden;
list-style-type:none;
}
ul.tsc_pagination li
{
float:left;
margin:0px;
padding:0px;
margin-left:5px;
display: inline-flex !important;
}
ul.tsc_pagination li a
{
color:black;
display:block;
text-decoration:none;
padding:7px 10px 7px 10px;
}
ul.tsc_pagination li a img
{
border:none;
}
ul.tsc_pagination li a
{
color:#0A7EC5;
border-color:#8DC5E6;
background:#F8FCFF;
}
ul.tsc_pagination li a:hover,
ul.tsc_pagination li a.current
{
text-shadow:0px 1px #388DBE;
border-color:#3390CA;
background:#58B0E7;
background:-moz-linear-gradient(top, #B4F6FF 1px, #63D0FE 1px, #58B0E7);
background:-webkit-gradient(linear, 0 0, 0 100%, color-stop(0.02, #B4F6FF), color-stop(0.02, #63D0FE), color-stop(1, #58B0E7));
}
div.dataTables_wrapper div.dataTables_info {
  display:none;
}
</style>
<div class="content-page">
<div class="content">
<div class="container-fluid">

    <div class="row">
        <div class="col-6">
            <div class="page-title-box">
               <!--  <h4 class="page-title">BD Master Account(<b>Total: <?= (empty($total_rows)) ? 0 :  $total_rows; ?></b>)</h4> -->
                <h4 class="page-title">BD Master Account</h4>
            </div>
        </div>
    </div>
    <div class="row">
    <div style="overflow-y: auto;">
    <table id="example" class="display" style="width:100%" >
        <thead>
            <tr>
            <th>ID</th>
            <th>Company Name </th>
            <th>Country</th>
            <th>Users</th>
            <th>Last Voice Disposition</th>
            <th>Last Caller Remark</th>
            <th>Last updated Date</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach($bd_master_account as $key => $value){ ?>
                <tr>
                       
                       <td><?= $value['id'];?></td>
                       <td><?= $value['received_company_name'];?></td>
                       <td><?= $value['name'];?></td>
                       <td><?= $value['username'];?></td>
                       <td><?= $value['voice_dispositions'];?></td>
                       <td><?= $value['caller_remark'];?></td>
                       <td><?= $value['last_remark_date'];?></td>
                </tr>
             <?php } ?>
           
        </tbody>
       <tfoot>
            <tr>
            <th>ID</th>
            <th>Company Name </th>
            <th>Country</th>
            <th>Users</th>
            <th>Voice Disposition</th>
            <th>Caller Remark</th>
            <th>Last updated Date</th>
            </tr>
        </tfoot>
    </table>
     <!--    <div id="pagination">
        <ul class="tsc_pagination">
        <li><?php echo $links; ?><li>
        </ul>
        </div> -->
    </div>
    </div>

</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
     $('tfoot').each(function () {
    $(this).insertAfter($(this).siblings('thead'));
});
   $(document).ready(function () {
    // Setup - add a text input to each footer cell
    $('#example tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="Search ' + title + '" />');
    });
 
    // DataTable
    var table = $('#example').DataTable({
       
        
        initComplete: function () {
            
            this.api()
                .columns()
                .every(function () {
                    var that = this;
 
                    $('input', this.footer()).on('keyup change clear', function () {
                        if (that.search() !== this.value) {
                            that.search(this.value).draw();
                        }
                    });
                });
        },
    });
});
</script>
