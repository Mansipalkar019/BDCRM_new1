<div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Users Management</h4>
                            </div>
                        </div>
                    </div><br>

                    <div class="row">
                        <?php
                        if(!empty($usersData)){

                            $user_id  = $usersData['id'];
                            $username  = $usersData['username'];
                            $password  = ($usersData['password']);
                            $first_name  = $usersData['first_name']; 
                            $last_name  = $usersData['last_name'];
                            $email  = $usersData['email'];
                            $designation  = $usersData['designation'];
                        }else{
                            $user_id  = '';
                            $username  = "";
                            $password  = "";
                            $first_name  = "";
                            $last_name  ="";
                            $email  = "";
                            $designation  = "";
                        }
                            
                        ?>

                        <div class="col-lg-12">
                            <div class="card-box">
                                <center>
                                    <p><?php echo $this->session->flashdata("error");?></p>
                                    <p><?php echo $this->session->flashdata("success");?></p>
                                </center>
                                <form action="<?php echo base_url('master/submit_users'); ?>" method="post">
                                     <div class="row">
                                        <div class="col-lg-6">
                                        <form class="form-horizontal">
                                            <div class="form-group row">
                                                <label class="col-md-2 control-label">First Name</label>
                                                <div class="col-md-10">

                                                    <input type="hidden" class="form-control" name="user_id" 
                                                    value="<?= $user_id; ?>">

                                                    <input type="text" class="form-control" name="firstname" placeholder=" First Name" 
                                                    value="<?= $first_name; ?>" required="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-2 control-label">Email</label>
                                                <div class="col-md-10">
                                                    <input type="email" class="form-control" placeholder="Email" name="email" required="" value="<?= $email;?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-2 control-label">Username</label>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" placeholder="Username" name="username" required="" value="<?= $username; ?>">
                                                </div>
                                            </div>
                                    </div>
                                    <div class="col-lg-6">
                                           <div class="form-group row">
                                                <label class="col-md-2 control-label">Last Name</label>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control"  required="" name="lastname" placeholder="Last Name" value="<?= 
                                                    $last_name; ?>">
                                                </div>
                                            </div>
                                             <div class="form-group row">
                                                <label class="col-sm-2 control-label">Desig..</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" name="designation">
                                                         <option disabled>Select Designations</option>
                                                        <?php 
                                                        foreach ($getAllDesignations as $key => $value){
                                                            $selected = '';
                                                            if(!empty($designation)){
                                                                if($designation==$value['id']){
                                                                    $selected = 'selected';
                                                                }
                                                            }else{
                                                                $selected = '';
                                                            }

                                                         ?>
                                                            <option value="<?= $value['id']; ?>" <?= $selected; ?>>
                                                            <?= $value['designation_name'] ?></option>
                                                        <?php }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                             <div class="form-group row">
                                                <label class="col-md-2 control-label">Password</label>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" placeholder="Password" name="password" required="" value="<?= sha1($password);?>">
                                                </div>
                                            </div>
                                    </div>
                                    <br>
                           <center><button type="submit" style="margin-left: 585%" class="btn btn-purple waves-effect waves-light" >Submit</button></center> 
                                 </form>

                                </div>
                                <hr>
                                <br><br><br>
                                <center><h3>Users List</h3></center>
                                <table id="datatable-fixed-col" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Sr</th>
                                            <th>Name</th>
                                            <th>Designation</th>
                                            <th>Email</th>
                                            <th>Registration Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody> 
                                        <?php 

                                        foreach ($getAllUsers as $key => $value) {
                                            $id = $value['id'];
                                            ?>

                                        <tr>
                                            <td><?= $key+1;?></td>
                                            <td><?= $value['first_name']." ".$value['last_name'];?></td>
                                            <td><?= $value['designation_name'];?></td>
                                            <td><?= $value['email'];?></td>
                                            <td>
                                                <?= date("d-m-Y h:i A", strtotime($value['created_at']));?></td>
                                            <td>

                                                <a href="<?= base_url('master/add_users').'/'.$id;?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                                &nbsp;&nbsp;&nbsp;
                                                <a onclick="alert('are you sure want to delete this user')" href="<?= base_url('master/deleteUser').'/'.$id;?>"><i class="fa-solid fa-trash"></i></a>
                                            </td>

                                        </tr>

                                       <?php }

                                        ?>
                                        
                                       
                                    </tbody>
                                </table>

                            </div>

                        </div>
                        

                        <!-- end col -->


                    </div>
                </div>
            </div>

            

           

        </div>