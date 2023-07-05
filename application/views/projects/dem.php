<td id="check_<?=$staff_list_val['id'];?>"><?php if($staff_list_val['validation_status'] == '0'){?><a href="<?php echo base_url().'Projects/my_projects/'.base64_encode($staff_list_val['project_id']).'/'.base64_encode($staff_list_val['id']).'/'.base64_encode($staff_list_val['comp_name']);?>"><span class="badge bg-danger " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"><span class="fa fa-times"></span></span></a><?php }elseif($staff_list_val['validation_status'] == '1'){?>
                                    <a href="<?php echo base_url().'Projects/my_projects/'.base64_encode($staff_list_val['project_id']).'/'.base64_encode($staff_list_val['id']).'/'.base64_encode($staff_list_val['comp_name']);?>"><span class="badge bg-success " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"><span class="fa fa-check"></span></span></a><?php }else{?>
                                    <a href="<?php echo base_url().'Projects/my_projects/'.base64_encode($staff_list_val['project_id']).'/'.base64_encode($staff_list_val['id']).'/'.base64_encode($staff_list_val['comp_name']);?>"><span class="badge bg-danger " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"><span class="fa fa-times"></span></span></a>
                                    <?php } ?>
                                 </td>
                                 <td><?= $staff_list_val['first_name'].' '.$staff_list_val['last_name']; ?></td>
                                 <td><?php  if($designation_name=='Researcher'){ ?>
                                    <?= $staff_list_val['dispositions']; ?>
                                    <?php }elseif($designation_name=='Caller'){?>
                                    <?= $staff_list_val['dispositions']; ?>
                                 <td><?= $staff_list_val['voice_dispositions']; ?></td>
                                 <?php }else{ if($allInfo[0]['activity_type'] == "web"){?>
                                 <?= $staff_list_val['dispositions']; ?>
                                 <?php }else if($allInfo[0]['activity_type'] == "voice"){?>
                                 <?= $staff_list_val['voice_dispositions']; ?>
                                 <?php }else{?>
                                 <?= $staff_list_val['dispositions']; ?>
                                 <td><?= $staff_list_val['voice_dispositions']; ?></td>
                                 <?php } } ?></td>
                                 <?php 
                                    $designation_name = $this->session->userdata('designation_name');
                                    if($designation_name=='Researcher'){ ?>
                                 <td>
                                    <?php if(!empty($staff_list_val['replaced_by'])){
                                       echo $staff_list_val['first_name'].' '.$staff_list_val['last_name'].' is '. $staff_list_val['dispositions'].' for '.$staff_list_val['replaced_by']; 
                                        ?>
                                    <?php } ?>
                                 </td>
                                 <?php }elseif($designation_name=='Caller'){?>
                                 <td> <?php if(!empty($staff_list_val['replaced_by'])){
                                    echo $staff_list_val['first_name'].' '.$staff_list_val['last_name'].' is '. $staff_list_val['dispositions'].' for '.$staff_list_val['replaced_by']; 
                                     ?>
                                    <?php } ?>
                                 </td>
                                 <td>
                                    <?php if(!empty($staff_list_val['caller_has_replaced'])){
                                       echo $staff_list_val['first_name'].' '.$staff_list_val['last_name'].' is '. $staff_list_val['voice_dispositions'].' for '.$staff_list_val['caller_has_replaced']; 
                                        ?>
                                    <?php } ?>
                                 </td>
                                 <?php } ?>
                                 <td>
                                    <?php
                                       $designation_name = $this->session->userdata('designation_name');
                                       if($designation_name=='Researcher')
                                       {
                                          if(strtolower($staff_list_val['dispositions']) == 'verified' || strtolower($staff_list_val['dispositions']) == 'required' || strtolower($staff_list_val['dispositions']) == 'added' || strtolower($staff_list_val['dispositions']) == 'acquired' || strtolower($staff_list_val['dispositions']) == 'replaced'|| strtolower($staff_list_val['dispositions']) == 'replacement'){?>
                                    <span class="badge bg-success " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span>
                                    <?php }elseif(strtolower($staff_list_val['dispositions']) == 'staff left' || strtolower($staff_list_val['dispositions']) == 'duplicate' || strtolower($staff_list_val['dispositions']) == 'no answer'){?>
                                    <span class="badge bg-warning " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span>
                                    <?php }elseif(strtolower($staff_list_val['dispositions']) == 'no result'){
                                       ?>
                                    <span class="badge bg-danger " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span>
                                    <?php }else{?>
                                    <span class="badge bg-danger " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span>
                                    <?php } }
                                       elseif($designation_name=='Caller'){
                                          
                                          if(strtolower($staff_list_val['voice_dispositions']) == 'verified' || strtolower($staff_list_val['voice_dispositions']) == 'required' || strtolower($staff_list_val['voice_dispositions']) == 'added' || strtolower($staff_list_val['voice_dispositions']) == 'acquired' || strtolower($staff_list_val['voice_dispositions']) == 'replaced'){?>
                                    <span class="badge bg-success " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span>
                                    <?php }elseif(strtolower($staff_list_val['voice_dispositions']) == 'staff left' || strtolower($staff_list_val['voice_dispositions']) == 'duplicate' || strtolower($staff_list_val['voice_dispositions']) == 'no answer'){
                                       ?>
                                    <span class="badge bg-warning " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span>
                                    <?php }elseif(strtolower($staff_list_val['voice_dispositions']) == 'no result'|| strtolower($staff_list_val['voice_dispositions']) == 'not verified'){
                                       ?>
                                    <span class="badge bg-danger " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span>
                                    <?php }else{?>
                                    <span class="badge bg-danger " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span>
                                    <?php }}elseif($designation_name=='Superadmin'){
                                       if($allInfo[0]['activity_type'] == "web"){
                                          if(strtolower($staff_list_val['dispositions']) == 'verified' || strtolower($staff_list_val['dispositions']) == 'required' || strtolower($staff_list_val['dispositions']) == 'added' || strtolower($staff_list_val['dispositions']) == 'acquired' || strtolower($staff_list_val['dispositions']) == 'replaced'|| strtolower($staff_list_val['dispositions']) == 'replacement') {?>
                                    <span class="badge bg-success " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span>
                                    <?php }elseif(strtolower($staff_list_val['dispositions']) == 'staff left' || strtolower($staff_list_val['dispositions']) == 'duplicate' || strtolower($staff_list_val['dispositions']) == 'no answer'){?>
                                    <span class="badge bg-warning " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span>
                                    <?php }elseif(strtolower($staff_list_val['dispositions']) == 'no result'){
                                       ?>
                                    <span class="badge bg-danger " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span>
                                    <?php }else{?>
                                    <span class="badge bg-danger " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span>
                                    <?php } }
                                       elseif($allInfo[0]['activity_type'] == "voice")
                                       {
                                          echo $staff_list_val['country_name'];   
                                       }
                                       else{ ?>
                                    <?php 
                                       if(strtolower($staff_list_val['dispositions']) == 'verified' || strtolower($staff_list_val['dispositions']) == 'required' || strtolower($staff_list_val['dispositions']) == 'added' || strtolower($staff_list_val['dispositions']) == 'acquired' || strtolower($staff_list_val['dispositions']) == 'replaced'|| strtolower($staff_list_val['dispositions']) == 'replacement') {?>
                                    <span class="badge bg-success " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span>
                                    <?php }elseif(strtolower($staff_list_val['dispositions']) == 'staff left' || strtolower($staff_list_val['dispositions']) == 'duplicate' || strtolower($staff_list_val['dispositions']) == 'no answer'){?>
                                    <span class="badge bg-warning " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span>
                                    <?php }elseif(strtolower($staff_list_val['dispositions']) == 'no result'){
                                       ?>
                                    <span class="badge bg-danger " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span>
                                    <?php }else{?><span class="badge bg-danger " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span><?php } 
                                       ?>
                                 <td>
                                    <?php 
                                       if(strtolower($staff_list_val['voice_dispositions']) == 'verified' || strtolower($staff_list_val['voice_dispositions']) == 'required' || strtolower($staff_list_val['voice_dispositions']) == 'added' || strtolower($staff_list_val['voice_dispositions']) == 'acquired'|| strtolower($staff_list_val['voice_dispositions']) == 'replaced'){?>
                                    <span class="badge bg-success " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span>
                                    <?php }elseif(strtolower($staff_list_val['voice_dispositions']) == 'staff left' || strtolower($staff_list_val['voice_dispositions']) == 'duplicate' || strtolower($staff_list_val['voice_dispositions']) == 'no answer'){?>
                                    <span class="badge bg-warning " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span>
                                    <?php }elseif(strtolower($staff_list_val['voice_dispositions']) == 'no result' || strtolower($staff_list_val['voice_dispositions']) == 'not verified'){
                                       ?>
                                    <span class="badge bg-danger " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span>
                                    <?php }else{?><span class="badge bg-danger " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span><?php }
                                       ?>
                                 </td>
                                 <?php }
                                    }
                                    ?>
                                 </td>