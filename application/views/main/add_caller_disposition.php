<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Voice Disposition Management</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card-box">
                        <p><?php echo $this->session->flashdata("error");?></p>
                        <p><?php echo $this->session->flashdata("success");?></p>

                        <?php
                         if(!empty($getFormCallDispo)){
                           $id = $getFormCallDispo['id']; 
                           $caller_dispostion = $getFormCallDispo['caller_disposition']; 
                           $button = "Update";

                         }else{
                            $id = ""; 
                            $caller_dispostion = ""; 
                            $button = "Submit";


                         }
                        ?>




                        <form action="<?php echo base_url('master/submit_caller_dispositions'); ?>" method="post">
                            <div class="form-group">
                                <label>Voice Disposition Name</label>
                                <input type="hidden" name="caller_id" value="<?= $id; ?>">

                                <input type="text" name="caller_disposition" class="form-control" 
                                placeholder="Voice Dispostion Name" required="" value="<?= $caller_dispostion; ?>" >
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
                                    <th>Voice Disposition </th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (!empty($getCallerDispo)) {
                                foreach ($getCallerDispo as $k => $value) {
                            ?>
                                        <tr>
                                            <td><?php echo $k+1;?></td>
                                            <td><?php echo $value['caller_disposition']?></td>
                                            <td>
                                               <a href="<?php echo base_url('master/add_caller_disposition').'/'.$value['id'];?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                                &nbsp;&nbsp;&nbsp;

                                                <a href="<?php echo base_url('master/DeleteCallerDisposition').'/'.$value['id'];?>" onclick="return confirm('are you sure to want delete selected caller disposition.')"><i class="fa-solid fa-trash"></i></a>
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