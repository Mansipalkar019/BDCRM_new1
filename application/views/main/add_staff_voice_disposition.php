<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Staff Voice Disposition Management</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card-box">
                        <p><?php echo $this->session->flashdata("error");?></p>
                        <p><?php echo $this->session->flashdata("success");?></p>

                        <?php
                         if(!empty($getFormStaffVoiceDispo)){
                           $id = $getFormStaffVoiceDispo['id']; 
                           $web_disposition = $getFormStaffVoiceDispo['voice_dispositions']; 
                           $co_dispositions = $getFormStaffVoiceDispo['co_dispositions']; 
                           $button = "Update";

                         }else{
                            $id = ""; 
                            $web_disposition = ""; 
                            $button = "Submit";


                         }
                        ?>

                        <form action="<?php echo base_url('master/submit_staff_voice_dispositions'); ?>" 
                            method="post">
                            <div class="form-group">
                                <label>Staff Voice Disposition </label>
                                <input type="hidden" name="w_id" value="<?= $id; ?>">
                                <input type="text" name="staff_voice_dispostions_name" class="form-control" 
                                placeholder="Staff Voice Disposition " value="<?= $web_disposition; ?>" required="">
                            </div>
                            <div class="form-group">
                                <label>Select Co voice Disposition</label>
                                <select class='form-control form-control-sm' id="company_voice_dispositon"  name='company_voice_dispositon' tabindex="25" required="">
                                <option value=''>Select</option>   
                                <?php 
                                 if (!empty($getcoStaffVoiceDispo)) {
                                    foreach ($getcoStaffVoiceDispo as $key =>$values) {
                                ?>
                                    <option value='<?= $values['id']; ?>' <?php if($co_dispositions==$values['id']){?>selected<?php } ?>><?= $values['caller_disposition']; ?></option>      
                                <?php
                                }
                                } 
                                ?>
                                </select>
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
                                    <th>Staff Voice Dispostions</th>
                                    <th>Co. Voice Dispostions</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (!empty($getStaffVoiceDispo)) {
                                foreach ($getStaffVoiceDispo as $k =>$value) {
                            ?>
                                        <tr>
                                            <td><?php echo $k+1;?></td>
                                            <td><?php echo $value['voice_dispositions']?></td>
                                            <td><?php echo $value['caller_disposition']?></td>
                                            <td>
                                               <a href="<?php echo base_url('master/add_staff_voice_dispositions').'/'.$value['id'];?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                                &nbsp;&nbsp;&nbsp;
                                                <a href="<?php echo base_url('master/DeleteStaffVoiceDisposition').'/'.$value['id'];?>" onclick="return confirm('are you sure to want delete selected staff voice disposition.')"><i class="fa-solid fa-trash"></i></a>
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
<script>

</script>