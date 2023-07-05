<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Prefix Management</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card-box">
                        <p><?php echo $this->session->flashdata("error");?></p>
                        <p><?php echo $this->session->flashdata("success");?></p>
                        <?php
                         if(!empty($getFormPrefix)){
                           $id = $getFormPrefix['id']; 
                           $prefix = $getFormPrefix['prefix']; 
                           $button = "Update";
                         }else{
                            $id = ""; 
                            $prefix = ""; 
                            $button = "Submit";
                         }
                        ?>
                        <form action="<?php echo base_url('master/submit_prefix'); ?>" method="post">
                            <div class="form-group">
                                <label>Prefix..</label>
                                <input type="hidden" name="prefix_id" value="<?= $id; ?>">
                                <input type="text" name="prefix_name" class="form-control" 
                                placeholder="Enter Prefix .." required="" value="<?= $prefix; ?>" >
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
                                    <th>Prefix</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (!empty($getAllPrefix)) {
                                foreach ($getAllPrefix as $k =>$value) {
                            ?>
                                        <tr>
                                            <td><?php echo $k+1;?></td>
                                            <td><?php echo $value['prefix']?></td>
                                            <td>
                                               <a href="<?php echo base_url('master/add_name_prefix').'/'.$value['id'];?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                                &nbsp;&nbsp;&nbsp;

                                                <a href="<?php echo base_url('master/DeletePrefix').'/'.$value['id'];?>" onclick="return confirm('are you sure to want delete selected prefix.')"><i class="fa-solid fa-trash"></i></a>
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