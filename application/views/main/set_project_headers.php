<div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                   <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                              <?php 
                              $string_with_spaces = preg_replace("/%20+/"," ", $this->uri->segment(4, 0));
                              ?>
                              <h6 class="page-title">Feilds Management For Task Type <?= $string_with_spaces?></h6>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                      <form action="<?php echo base_url('master/submitFeildsAccess'); ?>" method="post">
                        <div class="col-lg-12">
                            <div class="card-box">
                                <p><?php echo $this->session->flashdata("error");?></p>
                                <p><?php echo $this->session->flashdata("success");?></p>

                               <div class="row">
                                <input type="hidden" name="task_type_id" 
                                value="<?= $this->uri->segment(3, 0);?>">
                                <input type="hidden" name="task_name" 
                                value="<?= $this->uri->segment(4, 0);?>">

                                <?php 
                                  foreach ($getAllHeders as $key => $value) {
                                  $id = $value['id'];
                                  $feild_access = getFeildsAccessByTaskType($id,$this->uri->segment(3, 0));
                                  $checked = ($feild_access>0) ? 'checked' : '' ;
                                
                                  ?>
                                    <div class="col-4">
                                      <div class="checkbox checkbox-primary" >
                                        <input id="<?= 'checkbox'.$key;?>" type="checkbox"
                                         name="feild_access[<?= $id; ?>][]" <?=  $checked; ?> >
                                        <label for="<?= 'checkbox'.$key;?>">
                                           <b><h6 style="margin-top:2%"><?= $value['label_name'];?></h6></b>
                                        </label>
                                      </div>
                                    </div>
                            <hr>
                            <?php } ?>
                           </div><hr>
                           <center><button type="submit" style="" class="btn btn-purple waves-effect waves-light" >Submit</button></center> 

                            </div>
                            

                                <hr>
                            </div>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
        </div>


 <script>
 
 function CheckAll(className, elem) {
        var elements = document.getElementsByClassName(className);
        var l = elements.length;

        if (elem.checked) {
            for (var i = 0; i < l; i++) {
                elements[i].checked = true;
            }
        } else {
            for (var i = 0; i < l; i++) {
                elements[i].checked = false;
            }
        }
    }

</script>