<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Researcher Remark Management</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-5">
                    <div class="card-box">
                        <p><?php echo $this->session->flashdata("error");?></p>
                        <p><?php echo $this->session->flashdata("success");?></p>

                        <?php
                         if(!empty($getFormProjects)){
                           $id = $getFormProjects['id']; 
                           $project_type = $getFormProjects['researcher_remark']; 
                           $button = "Update";

                         }else{
                            $id = ""; 
                            $project_type = ""; 
                            $button = "Submit";
                         }
                        ?>

                        <form action="<?php echo base_url('master/submit_researcher_remark'); ?>" method="post">
                        <div class="form-group">
                                <label>Researcher Reamark</label>
                                <input type="hidden" name="researcher_remark_id" value="<?= $id; ?>">

                                <input type="text" name="researcher_remark" class="form-control" 
                                placeholder="Researcher Remark.." required="" value="<?= $project_type; ?>" >
                            </div>

                            <button type="submit" class="btn btn-purple waves-effect waves-light"><?= $button;?></button>

                        </form>
                    </div>
                    <!-- end card-box -->
                </div>
                <!-- end col -->

                <div class="col-lg-7">
                    <div class="card-box">

                         <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                        <th>Sr</th>
                                        <th>R. Remark</th>
                                        <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php 

                                        foreach ($getProjectTypes as $key => $value) { ?>

                                        <tr>
                                            <td><?= $key+1; ?></td>
                                            <td><?= $value['researcher_remark'];?></td>
                                            
                                            <td><a href="<?php echo base_url("master/add_researcher_remark/"); ?><?php echo $value['id']; ?>"><i class="fa-solid fa-pen-to-square"></i></a>&nbsp;&nbsp;&nbsp;
                                                <a href="<?php echo base_url("master/DeleteResearcherRemark").'/'.$value['id']; ?>" onclick="return confirm('are you sure you want to delete selected Remark.')"><i class="fa-solid fa-trash"></i></a></td>
                                        </tr>

                                        <?php 
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