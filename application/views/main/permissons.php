

<div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                              <?php 
                                $string_with_spaces = preg_replace("/%20+/"," ", $this->uri->segment(4, 0));

                              ?>
                                <h4 class="page-title">Roles Management For <?= $string_with_spaces;
?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-box">
                              <p><?php echo $this->session->flashdata("error");?></p>
                              <p><?php echo $this->session->flashdata("success");?></p>
                                <form action="<?php echo base_url('master/set_permissons'); ?>" method="post">
                                   <div class="row">
                                    <div class="col-lg-12">
                                      <input type="hidden" name="designation_id" value="<?= $this->uri->segment(3, 0); ?>">

                                      <input type="hidden" name="designation_name" value="<?= $string_with_spaces; ?>">


                                        <table id="datatable-fixed-col" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <?php 
                                      $menu = getMenus(); 
                                      $designation_id = $this->uri->segment(3, 0);
                                      foreach ($menu as $key => $value) { 
                                        $menu_id = $value['menu_id'];
                                        $access = getRolesByMenuId($designation_id,$menu_id);
                                        $check = '';
                                        if(count($access)>0){
                                          $check = "checked=''";
                                        }

                                        ?>
                                        <tbody>
                                             <div class="checkbox checkbox-primary">
                                              <input id="<?= 'checkbox'.$key;?>" type="checkbox"
                                               name="menu[<?=$menu_id; ?>][]" <?= $check;?>>
                                              <label for="<?= 'checkbox'.$key;?>">
                                                 <b><h5><?= $value['menu_name'];?></h5></b>
                                              </label>
                                            </div>
                                             <hr>
                                             <?php 
                                             if(!empty($value['submenu'])){

                                              
                                             foreach ($value['submenu'] as $keys => $val){
                                              $submenu = $val['id'];
                                              $SubMenuAccess = getRolesBySubMenuId($designation_id,$submenu);
                                              $Scheck = '';
                                              if(count($SubMenuAccess)>0){
                                                $Scheck = "checked=''";
                                              }


                                              ?>
                                               <div class="checkbox checkbox-primary" style="margin-left: 8%">
                                              <input id="<?= 'subcheckbox'.$key.$keys;?>" 
                                              name="submenu[<?= $submenu;?>]"
                                              type="checkbox" <?= $Scheck;?>>
                                              <label for="<?= 'subcheckbox'.$key.$keys;?>">
                                                 <p><?= $val['sub_menu_name']; ?></p>
                                              </label>
                                            </div>
                                         <?php }
                                         }
                                             ?>
                                       </tbody>
                                     <?php }
                                    ?>
                                </table>
                                    </div>
                                    <br>
                                  <center><button type="submit" style="margin-left: 585%" class="btn btn-purple waves-effect waves-light" >Submit</button></center> 
                                 </form>

                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


 <script>
  
</script>