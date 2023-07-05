<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Designations Management</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-6">
                    <div class="card-box">
                        <p><?php echo $this->session->flashdata("error");?></p>
                        <p><?php echo $this->session->flashdata("success");?></p>

                        <?php 

                        if(!empty($getDesigValues)){
                            $desig_id = $getDesigValues['id'];
                            $desig_name = $getDesigValues['designation_name'];
                        }else{
                            $desig_id = "";
                            $desig_name = "";
                        }
                        ?>

                        <form action="<?php echo base_url('master/submit_designations'); ?>" method="post">
                            <div class="form-group">
                                <label>Designation Name</label>
                                <input type="hidden" name="designation_id" class="form-control" value="<?= $desig_id; ?>">
                                <input type="text" name="designation_name" class="form-control" placeholder="Enter Designation Name..." required="" value="<?= $desig_name; ?>">
                            </div>

                            <button type="submit" class="btn btn-purple waves-effect waves-light">Submit</button>

                        </form>
                    </div>
                    <!-- end card-box -->
                </div>
                <!-- end col -->

                <div class="col-lg-6">
                    <div class="card-box">

                        <table id="datatable-fixed-col" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sr</th>
                                    <th>Designation</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (!empty($getAllDesignations)) {
                                foreach ($getAllDesignations as $k =>$value) {
                                    $id = $value['id'];
                            ?>
                                        <tr>
                                            <td style="color: black"><?php echo $k+1;?></td>
                                            <td><?php echo $value['designation_name']?></td>
                                            <td>
                                               <a href="<?php echo base_url('master/add_designations').'/'.$id ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                                &nbsp;&nbsp;
                                                <a href="<?php echo base_url('master/delete_designations').'/'.$id ?>"><i class="fa-solid fa-trash"></i></a>&nbsp;&nbsp;
                                                <a href="<?= base_url('master/permissons').'/'.$id.'/'.$value['designation_name'];?>" title='Set Permissons '>
                                                <i class="fa fa-lock" aria-hidden="true"></i></a>

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