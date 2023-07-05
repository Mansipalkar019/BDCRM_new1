<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Project Type Management</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-6">
                    <div class="card-box">
                        <p><?php echo $this->session->flashdata("error");?></p>
                        <p><?php echo $this->session->flashdata("success");?></p>

                        <form action="<?php echo base_url('master/submit_projects'); ?>" method="post">
                            <div class="form-group">
                                <label>Project Type</label>
                                <input type="text" name="project_name" class="form-control" 
                                placeholder="Enter Project Type" required="">
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
                                    <th>Project Type</th>
                                    <th>Action</th>

                                </tr>
                            </thead>

                            <?php
                            if (!empty($getAllProjects)) {
                                foreach ($getAllProjects as $value) {
                            ?>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $value['id']?></td>
                                            <td><?php echo $value['project_name']?></td>
                                            <td>
                                               <a href="<?php echo base_url('master/edit_projects')?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                                &nbsp;&nbsp;&nbsp;<a href=""><i class="fa-solid fa-trash"></i></a>
                                                
                                                
                                            </td>

                                        </tr>
                                    </tbody>
                                <?php
                                }
                            } 

                            ?>

                            
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>





</div>