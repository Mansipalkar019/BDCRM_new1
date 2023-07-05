<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Company Dispostion Management</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card-box">
                        <p><?php echo $this->session->flashdata("error");?></p>
                        <p><?php echo $this->session->flashdata("success");?></p>

                        <?php
                         if(!empty($getFormCompDispo)){
                           $id = $getFormCompDispo['id']; 
                           $company_dispostion = $getFormCompDispo['company_dispostion']; 
                           $button = "Update";

                         }else{
                            $id = ""; 
                            $company_dispostion = ""; 
                            $button = "Submit";


                         }
                        ?>

                        <form action="<?php echo base_url('master/submit_company_dispositions'); ?>" 
                            method="post">
                            <div class="form-group">
                                <label>Dispostion Name</label>
                                <input type="hidden" name="c_id" value="<?= $id; ?>">
                                <input type="text" name="c_dispostions_name" class="form-control" 
                                placeholder="Dispostion Name" value="<?= $company_dispostion; ?>" required="">
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
                                    <th>Company Dispostions Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (!empty($getCompDispo)) {
                                foreach ($getCompDispo as $k =>$value) {
                            ?>
                                   
                                        <tr>
                                            <td><?php echo $k+1;?></td>
                                            <td><?php echo $value['company_dispostion']?></td>
                                            <td>
                                               <a href="<?php echo base_url('master/add_company_disposition').'/'.$value['id'];?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                                &nbsp;&nbsp;&nbsp;
                                                <a href="<?php echo base_url('master/DeleteDisposition').'/'.$value['id'];?>" onclick="return confirm('are you sure to want delete selected company Disposition.')"><i class="fa-solid fa-trash"></i></a>
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