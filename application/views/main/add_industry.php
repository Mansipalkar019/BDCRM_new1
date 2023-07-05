<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Industry Management</h4>
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
                        if(!empty($getFormInfo)){
                            $industry_id = $getFormInfo['id'];
                            $Industries = $getFormInfo['Industries'];
                            $button = "Update";
                        }else{

                            $industry_id = "";
                            $Industries = "";
                            $button = "Add";
                        }
                        ?>

                        <form action="<?php echo base_url('master/submit_industry'); ?>" method="post">
                            <div class="form-group">
                                <label>Industry Name</label>
                                <input type="hidden" name="industry_id" value="<?= $industry_id;?>">
                                <input type="text" name="industry_name" class="form-control" 
                                placeholder="Industry Name" required="" value="<?= $Industries;?>"> 
                            </div>

                            <button type="submit" class="btn btn-purple waves-effect waves-light">
                                <?= $button; ?>
                            </button>

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
                                            <th>Industry Name</th>
                                            <th>Action</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php 

                                        foreach ($getAllCountry as $key => $value) { ?>

                                        <tr>
                                            <td><?= $key+1; ?></td>
                                            <td><?= $value['Industries'];?></td>
                                            <td><a href="<?php echo base_url("master/add_industry/"); ?><?php echo $value['id']; ?>"><i class="fa-solid fa-pen-to-square"></i></a>&nbsp;&nbsp;&nbsp;
                                                <a href="<?php echo base_url("master/delete_industry").'/'.$value['id']; ?>" onclick="return confirm('are you sure to want delete selected country.')"><i class="fa-solid fa-trash"></i></a></td>
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