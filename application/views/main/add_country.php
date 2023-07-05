<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Country Management</h4>
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
                            $country_id = $getFormInfo['id'];
                            $name = $getFormInfo['name'];
                            $phonecode = $getFormInfo['phonecode'];
                            $button = "Update";
                        }else{

                            $country_id = "";
                            $name = "";
                            $phonecode = "";
                            $button = "Add";
                        }
                        ?>

                        <form action="<?php echo base_url('master/submit_country'); ?>" method="post">
                            <div class="form-group">
                                <label>Country Name</label>
                                <input type="hidden" name="country_id" value="<?= $country_id;?>">
                                <input type="text" name="country_name" class="form-control" 
                                placeholder="Country Name" required="" value="<?= $name;?>"> 
                            </div>

                            <div class="form-group">
                                <label>Phone Code</label>
                                <input type="number" name="phone_code" class="form-control" 
                                placeholder="Phone Code" required="" value="<?= $phonecode; ?>"> 
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
                                            <th>Country Name</th>
                                            <th>Phone Code</th>
                                            <th>Action</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php 

                                        foreach ($getAllCountry as $key => $value) { ?>

                                        <tr>
                                            <td><?= $key+1; ?></td>
                                            <td><?= $value['name'];?></td>
                                            <td><?= $value['phonecode'];?></td>
                                            <td><a href="<?php echo base_url("master/add_country/"); ?><?php echo $value['id']; ?>"><i class="fa-solid fa-pen-to-square"></i></a>&nbsp;&nbsp;&nbsp;
                                                <a href="<?php echo base_url("master/delete_country").'/'.$value['id']; ?>" onclick="return confirm('are you sure to want delete selected country.')"><i class="fa-solid fa-trash"></i></a></td>
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