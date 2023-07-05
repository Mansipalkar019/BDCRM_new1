<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Task Type Management</h4>
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
                        <form action="<?php echo base_url('master/submit_project_type'); ?>" method="post">
                            <div class="form-group">
                                <label>Project Type</label>
                                <input type="hidden" name="project_type_id" value="<?= $id; ?>">

                                <input type="text" name="project_type" class="form-control" 
                                placeholder="Project Type.." required="" value="<?= $project_type; ?>" >
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
                                    <th>Task Type</th>
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
                                            <td>
                                               <a href="<?php echo base_url('master/add_project_type').'/'.$value['id'];?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                                &nbsp;

                                                <a href="<?php echo base_url('master/DeleteProjectType').'/'.$value['id'];?>" onclick="return confirm('are you sure to want delete selected Project.')"><i class="fa-solid fa-trash"></i></a>&nbsp;
                                                <a href="<?php echo base_url('master/setProjectHeaders').'/'.$value['id'].'/'.$value['project_type'];?>" title='Set Feilds Permissons'>
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