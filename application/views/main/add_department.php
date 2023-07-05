<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <?php
            if (!empty($getDepartment)) {
                $dept_name = $getDepartment['dept_name'];
                $sort_name = $getDepartment['sort_name'];
                $dep_id = $getDepartment['id'];
            } else {
                $dept_name = "";
                $sort_name = "";
                $dep_id = "";
            }
            ?>

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <?php 
                            if($dep_id==''){
                                echo " <h4 class='page-title'>Add Department</h4>";
                            }else{
                                echo " <h4 class='page-title'>Edit Department</h4>";
    
                            }
                        ?>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-6">
                    <div class="card-box">
                        <p>
                            <?php echo $this->session->flashdata("success"); ?>
                            <?php echo $this->session->flashdata("error"); ?>
                        </p>

                        <form action="<?php echo base_url('master/submit_departments'); ?>" method="post">
                            <div class="form-group">
                                <label>Department Name</label>

                                <input type="hidden" name="id" value="<?= $dep_id; ?>">
                                <input type="text" name="department_name" class="form-control" placeholder="Enter Name..." required="" value="<?= $dept_name;  ?>">
                            </div>


                            <div class="form-group">
                                <label>Sort Name</label>
                                <input type="text" name="sort_name" class="form-control" placeholder="Enter Sort Name.." required="" value="<?= $sort_name; ?>">
                            </div>
                            

                            <?php 
                            if($dep_id==''){
                                echo " <button type='submit' class='btn btn-purple waves-effect waves-light'>Submit</button>";
                            }else{
                                echo " <button type='submit' class='btn btn-purple waves-effect waves-light'>Update</button>";
    
                            }
                        ?>
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
                                    <th>Department</th>
                                    <th>Sort Name</th>
                                    <th>Action</th>

                                </tr>
                            </thead>

                            <?php
                            if (!empty($getAllDepartments)) {
                                foreach ($getAllDepartments as $k => $value) {
                            ?>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $k+1; ?></td>
                                            <td><?php echo $value['dept_name'] ?></td>
                                            <td><?php echo $value['sort_name'] ;?></td>
                                            <td><a href="<?php echo base_url("master/add_departments/"); ?><?php echo $value['id']; ?>"><i class="fa-solid fa-pen-to-square"></i></a>&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url("master/delete_departments/"); ?><?php echo $value['id']; ?>"><i class="fa-solid fa-trash"></i></a></td>

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