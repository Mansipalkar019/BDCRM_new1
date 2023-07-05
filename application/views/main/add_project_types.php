<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Project Type Management</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card-box">
                        <p><?php echo $this->session->flashdata("error");?></p>
                        <p><?php echo $this->session->flashdata("success");?></p>

                        <?php
                         if(!empty($getFormProjects)){
                           $id = $getFormProjects['id']; 
                           $project_type = $getFormProjects['project_type']; 
                           $button = "Update";

                         }else{
                            $id = ""; 
                            $project_type = ""; 
                            $button = "Submit";
                         }
                        ?>
                        <form action="<?php echo base_url('master/submit_project_types'); ?>" method="post">
                            <div class="form-group">
                                <label>Project Type</label>
                                <input type="hidden" name="project_type_id" value="<?= $id; ?>">

                                <input type="text" name="project_type" class="form-control" 
                                placeholder="Project Type.." required="" value="<?= $project_type; ?>" >
                            </div>
                            <div class="form-group">
                                <label>Select Activity</label>
                                <select class="form-control" required="" name="activity_type" id="activity_type" onchange="gettasktype(this.value)" id="task_type">
                                    <option value="">Select Activity</option>
                                    <option value="web">web</option>
                                    <option value="voice">voice</option>
                                    <option value="web & voice">web & voice</option>

                                </select>
                            </div>
                            <button type="submit" class="btn btn-purple waves-effect waves-light"><?= $button;?></button>
                        </form>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card-box">
                        <table id="datatable-fixed-col" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sr</th>
                                    <th>Project Type</th>
                                    <th>Activity Type</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (!empty($getProjectTypes)) {

                                foreach ($getProjectTypes as $key => $value) {
                            ?>
                                    
                                        <tr>
                                            <td><?php echo $key+1;?></td>
                                            <td><?php echo $value['project_type']?></td>
                                            <td><?php echo $value['activity_type']?></td>
                                            <td>
                                               <a href="<?php echo base_url('master/add_project_types').'/'.$value['id'];?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                                &nbsp;

                                                <a href="<?php echo base_url('master/DeleteProjectTypes').'/'.$value['id'];?>" onclick="return confirm('are you sure to want delete selected Project.')"><i class="fa-solid fa-trash"></i></a>&nbsp;
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