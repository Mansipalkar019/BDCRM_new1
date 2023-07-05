        <!-- ========== Left Sidebar Start ========== -->
        <div class="left-side-menu">

            <div class="slimscroll-menu">

                <!--- Sidemenu -->
                <div id="sidebar-menu">

                    <ul class="metismenu" id="side-menu">
                        <?php 
                          $menu = get_sidebar_menu(); 
                          foreach ($menu as $key => $value) {
                            if(empty($value['submenu'])){
                                $child = "";
                            }
                            if($value['url']==''){
                                $url = "javascript: void(0);";
                            }else{
                                $url = base_url($value['url']);
                            }
                           ?>
                            <li>
                            <a href="<?= ($url);?>" class="waves-effect waves-light">
                                <i class="<?= $value['fa_fa_icons']; ?>"></i>
                                <span class="badge badge-info badge-pill float-right"></span>
                                <span><?= $value['menu_name']; ?></span>
                                <?php if(!empty($value['submenu'])){?>
                                <span class="menu-arrow"></span>
                                <?php } ?>
                            </a>
                            <?php 
                            echo "<ul class='nav-second-level' aria-expanded='false'>";
                            foreach ($value['submenu'] as $key => $sub_menu) { ?>
                                <li><a href="<?php echo base_url($sub_menu['url']); ?>"><?= $sub_menu['sub_menu_name']?></a></li>
                             <?php  }
                             echo "</ul>";
                              ?>
                         
                        </li>
                        
                          <?php }

                        ?>





                      <!--   <li>
                            <a href="<?php echo base_url('dashboard'); ?>" class="waves-effect waves-light">
                                <i class="mdi mdi-view-dashboard"></i>
                                <span class="badge badge-success badge-pill float-right">2</span>
                                <span> Dashboard </span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="waves-effect waves-light">
                                <i class="mdi mdi-diamond-stone"></i>
                                <span class="badge badge-info badge-pill float-right"></span>
                                <span>Masters</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li><a href="<?php echo base_url('master/add_departments'); ?>">Departments</a></li>
                                <li><a href="<?php echo base_url('master/add_designations'); ?>">Designations</a></li>
                                <li><a href="<?php echo base_url('master/add_projects'); ?>">Projects</a></li>
                                <li><a href="<?php echo base_url('master/add_users'); ?>">Users</a></li>
                            </ul>
                        </li>

                          <li>
                            <a href="javascript: void(0);" class="waves-effect waves-light">
                                <i class="mdi mdi-diamond-stone"></i>
                                <span class="badge badge-info badge-pill float-right"></span>
                                <span>Projects</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li><a href="<?php echo base_url('master/add_departments'); ?>">Upload Projects</a></li>
                                <li><a href="<?php echo base_url('master/add_designations'); ?>">My Projects </a></li>
                                <li><a href="<?php echo base_url('master/add_projects'); ?>">Assign Projects</a></li>
                                <li><a href="<?php echo base_url('master/add_users'); ?>">Users</a></li>
                            </ul>
                        </li> -->





                       <!--  <li>
                            <a href="javascript: void(0);" class="waves-effect waves-light">
                                <i class="mdi mdi-format-list-bulleted"></i>
                                <span> Tables </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li><a href="tables-basic.html">Basic Tables</a></li>
                                <li><a href="tables-layouts.html">Tables Layouts</a></li>
                                <li><a href="tables-datatable.html">Data Table</a></li>
                                <li><a href="tables-responsive.html">Responsive Table</a></li>
                                <li><a href="tables-tablesaw.html">Tablesaw Table</a></li>
                                <li><a href="tables-editable.html">Editable Table</a></li>
                            </ul>
                        </li> -->
                    </ul>

                </div>
                <!-- End Sidebar -->

                <div class="clearfix"></div>

                <!-- <div class="help-box">
                    <h5 class="text-muted mt-0">For Help ?</h5>
                    <p class=""><span class="text-info">Email:</span>
                        <br /> raj.namdev@stzsoft.com
                    </p>
                    <p class="mb-0"><span class="text-info">Call:</span>
                        <br /> (+91) 8080416002
                    </p>
                </div>
 -->
            </div>
            <!-- Sidebar -left -->

        </div>
        <!-- Left Sidebar End -->
        
<script type="text/javascript">
    
window.onload = function() {
    $('body').addClass('enlarged');
};
</script>