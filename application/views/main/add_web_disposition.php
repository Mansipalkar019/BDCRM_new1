<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Web Disposition Management</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card-box">
                        <p><?php echo $this->session->flashdata("error");?></p>
                        <p><?php echo $this->session->flashdata("success");?></p>

                        <?php
                         if(!empty($getFormWebDispo)){
                           $id = $getFormWebDispo['id']; 
                           $web_disposition = $getFormWebDispo['web_disposition_name']; 
                           $button = "Update";

                         }else{
                            $id = ""; 
                            $web_disposition = ""; 
                            $button = "Submit";


                         }
                        ?>

                        <form action="<?php echo base_url('master/submit_web_dispositions'); ?>" 
                            method="post">
                            <div class="form-group">
                                <label>Disposition Name</label>
                                <input type="hidden" name="w_id" value="<?= $id; ?>">
                                <input type="text" name="web_dispostions_name" class="form-control" 
                                placeholder="Web Disposition " value="<?= $web_disposition; ?>" required="">
                            </div>
                            <button type="submit" class="btn btn-purple waves-effect waves-light"><?= $button; ?></button>

                        </form>
                    </div>
                    <!-- end card-box -->
                </div>
                <!-- end col -->

                <div class="col-lg-6">
                    <div class="card-box">

                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sr</th>
                                    <th>Web Dispostions</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (!empty($getWebDispo)) {
                                foreach ($getWebDispo as $k =>$value) {
                            ?>
                                        <tr>
                                            <td><?php echo $k+1;?></td>
                                            <td><?php echo $value['web_disposition_name']?></td>
                                            <td>
                                               <a href="<?php echo base_url('master/add_web_disposition').'/'.$value['id'];?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                                &nbsp;&nbsp;&nbsp;
                                                <a href="<?php echo base_url('master/DeleteWebDisposition').'/'.$value['id'];?>" onclick="return confirm('are you sure to want delete selected web disposition.')"><i class="fa-solid fa-trash"></i></a>
                                            </td>

                                        </tr>
                                <?php
                                }
                            } 
                            ?>
                          </tbody>   
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>