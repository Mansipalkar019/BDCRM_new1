

<div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-right mb-0">


        

        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                
                <span class="d-none d-sm-inline-block ml-1"><b style="color: black;">Welcome : <?= $this->session->userdata('first_name');?>&nbsp;(Desig: <?= $this->session->userdata('designation_name');?>)</b></span>&nbsp;
                <img src="<?php echo base_url();?>assets/images/users/avatar-1.jpg" alt="user-image" class="rounded-circle">
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                <!-- item-->
                <div class="dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Welcome !</h6>
                </div>

                <!-- item-->
                <a href="javascript:void(0);" class="dropdown-item notify-item">
                    <i class="mdi mdi-account-outline"></i>
                    <span>Profile</span>
                </a>

                <!-- item-->
                <a href="javascript:void(0);" class="dropdown-item notify-item">
                    <i class="mdi mdi-settings-outline"></i>
                    <span>Settings</span>
                </a>

                <a href="<?php echo base_url("login/logout");?>" class="dropdown-item notify-item">
                    <i class="mdi mdi-logout-variant"></i>
                    <span>Logout</span>
                </a>

            </div>
        </li>


    </ul>

    <!-- LOGO -->
    <div class="logo-box">
        <a href="<?php echo base_url('dashboard'); ?>" class="logo text-center">
            <span class="logo-lg">
                <img src="<?php echo base_url();?>assets/images/favicon.png" alt="" height="18">
            </span>
            <span class="logo-sm">
                
                <img src="<?php echo base_url();?>assets/images/favicon.png" alt="" height="24">
            </span>
        </a>
    </div>

    <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
        <li>
            <button class="button-menu-mobile waves-effect">
                <i class="mdi mdi-menu"></i>
            </button>
        </li>

      



    </ul>
</div>
<!-- end Topbar