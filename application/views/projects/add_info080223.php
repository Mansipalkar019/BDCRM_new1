<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="BDS DATABASE PROJECT">
      <meta name="author" content="">
      <link href="https://bdsserv.com/assets/icon/fv.png" rel="icon">
      <title>BD-CRM----<?= $allInfo[0]['id']; ?> </title>
      
      <link href="<?php echo base_url();?>public/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
      <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
      <link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">
      <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> 
      <script src="https://momentjs.com/downloads/moment.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
    
      <style>
         .bd-placeholder-img {
         font-size: 1.125rem;
         text-anchor: middle;
         -webkit-user-select: none;
         -moz-user-select: none;
         user-select: none;
         }
         @media (min-width: 768px) {
         .bd-placeholder-img-lg {
         font-size: 3.5rem;
         }
         }
         @media (min-width: 1024px) {
         .select2-container--default .select2-selection--single .select2-selection__rendered {
         font-size: 14px !important;
         }
         .select2-container--default .select2-selection--single .select2-selection__rendered {
         font-size: 14px !important;
         }
         .table-bordered>:not(caption)>*>* {
         border-width: 0 1px;
         font-size: 10px !important;
         }
         .table-bordered>:not(caption)>*>* {
         border-width: 0 1px;
         font-size: 12px !important;
         }
         .col-form-label {
         font-size: 10px !important;
         }
         .form-control-sm {
         font-size: 10px !important;
         }
         .alert .alert-warning .text-center .p-1{
         font-size: 10 !important;
         }
         .select2-container--default .select2-selection--single .select2-selection__rendered {
         font-size: 10px !important;
         }
         .input-group:not(.has-validation)>.dropdown-toggle:nth-last-child(n+3), .input-group:not(.has-validation)>:not(:last-child):not(.dropdown-toggle):not(.dropdown-menu) {
         font-size: 13 !important;
         }
         .btnsize{
         font-size: 10 !important;
         }
         .container-fluid {
         padding: 10px;
         margin: 0px;
         }
         .input-group>:not(:first-child):not(.dropdown-menu):not(.valid-tooltip):not(.valid-feedback):not(.invalid-tooltip):not(.invalid-feedback) {
         font-size: 10px !important;
         }
         }
         /* Show it is fixed to the top */
         body {
         padding-top: 4.5rem;
         }
         .swal-text {
         padding: 17px;
         border: 1px solid #F0E1A1;
         display: block;
         margin: 22px;
         font-size: 17px;;
         text-align: center;
         color: #61534e;
         }
         .row1 {
         overflow-y: hidden !important;
         overflow-x: hidden;
         }
         .ui-menu .ui-menu-item-wrapper {
         font-size: 12px !important;
         font-weight: 1000 !important;
         }
         .ui-menu .ui-widget .ui-widget-content .ui-autocomplete .ui-front{
         opacity: 0.6 !important;
         }
         label{
         font-weight: 700 !important;
         }
         .modal-lg, .modal-xl {
         max-width: 1000px !important;
         }
         table.dataTable td {
         font-size: 15px !important;
         }
         .btnsize {
               /* font-size: 10 !important; */
         }
         .select2-container {
            display: block !important;
            width: auto !important;
         }
      </style>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js" 
         integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
      <script>
         $(function() {});
      </script>
   </head>
   <body class="" >
      <style>
         pre {
         /* white-space:pre-line; */
         white-space: pre-wrap;       /* Since CSS 2.1 */
         white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
         white-space: -pre-wrap;      /* Opera 4-6 */
         white-space: -o-pre-wrap;    /* Opera 7 */
         word-wrap: break-word;       /* Internet Explorer 5.5+ */
         font-size: 11px;
         }
         .card-body p { font-size:12.11px; }
         .card-header { font-size: 0.7rem!important; }
         html, body
         {
         overflow: hidden;
         height: 100%;
         }
         body { padding: 1px;  }
         .container-fluid { padding: 20px; margin: 0px; } /*padding-top: 55px;*/
         .row1
         {
         overflow-y: scroll;
         overflow-x: hidden;
         }
         .col-form-label
         {
         font-size: 13px;
         }
         .select2-container--default .select2-selection--multiple {
         font-size: 12px !important;}
         .select2-container--default .select2-results>.select2-results__options {
         font-size: 12px !important;
         }
         .col-form-label {
         font-size: 12px !important;
         }
         .form-control-sm {
         font-size: 13px !important;
         }
      </style>
      <main class="container-fluid" style="background-color: #FFFFEA;">
         <?php //echo "<pre>";print_r($allInfo);die();?>
         <?php echo form_open('Projects/update_company_details', array('id' => 'update_company_details_form')) ?>
         <div class="row g-3 align-items-center justify-content-md-center">
         <div class="col">
         </div>
         <div class="col">
         <div class="alert alert-warning text-center p-1" role="alert" id="">
                  <?php
                     $project_id = $allInfo[0]['project_id'];
                     $user_id = $allInfo[0]['assigned_to'];
                     $id = $allInfo[0]['id'];
                     $company_name = $allInfo[0]['received_company_name'];
                     //$user_id=$this->session->userdata('id');
                     if(!empty($project_id) && !empty($user_id)){
                     
                        $url = "projects/CompanyFinalSubmit/".$project_id.'/'.$user_id.'/'.$id; 
                         ?>
                  <?php 
                     foreach($staff_list as $staff_list_key => $staff_list_val) { 
                        if($staff_list_val['validation_status'] == 0){ {
                           $error[] = count($staff_list_val['validation_status']);
                          }} }?>
                  <?php if(count($error) > 0){?>
                 
                  <?php }else {?><?php }?>
                  <?php
                     }?>
                  <a  style="text-decoration: none;font-weight: 700;"><?= $allInfo[0]['project_name']; ?></a>
                  <a type='submit' title="Go To Home Page" href="<?php echo base_url(); ?>projects/project_list" class='btn btn-purple btn-sm waves-effect waves-light' style="float:right;background-color: darkred;margin-top:-1px;margin-right:3%;color:white;"><i class="fa fa-home" aria-hidden="true"></i></a>
               </div>
               <div class="modal fade" id="briefDetails" tabindex="-1" aria-labelledby="briefDetailsLabel" aria-hidden="true">
                  <div class="modal-dialog">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="briefDetailsLabel">Project - Company Brief</h5>
                        </div>
                        <div class="modal-body text-center"><b><?=  (!empty($allInfo[0]['project_breif'])) ?  $allInfo[0]['project_breif'] : ''  ?></b></div>
                        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button></div>
                     </div>
                  </div>
               </div>
         </div>
         <div class="col">
         </div>
               
               </div>
         <div class="row row1">
            <div class="col">
               <!-- check input access for company received -->
               <input type="hidden" value="<?=  (!empty($allInfo[0]['project_id'])) ?  $allInfo[0]['project_id'] : ''  ?>" title="" id="project_id"  name='project_id' class="form-control form-control-sm">
               <input type="hidden" value="<?=  (!empty($allInfo[0]['assigned_by'])) ?  $allInfo[0]['assigned_by'] : ''  ?>" title="" id="assigned_by"  name='assigned_by' class="form-control form-control-sm">
               <input type="hidden" value="<?=  (!empty($allInfo[0]['replacedcount'])) ?  $allInfo[0]['replacedcount'] : ''  ?>" title="" id="replacedcount"  name='replacedcount' class="form-control form-control-sm">
               <input type="hidden" value="<?=  (!empty($allInfo[0]['task_type'])) ?  strtolower($allInfo[0]['task_type']) : ''  ?>" title="" id="task_type"  name='task_type' class="form-control form-control-sm">
               <input type="hidden" value="<?=  (!empty($allInfo[0]['first_name'])) ?  strtolower($allInfo[0]['first_name']) : ''  ?>" title="" id="first_name"  name='first_name' class="form-control form-control-sm">
               <input type="hidden" value="<?=  (!empty($allInfo[0]['last_name'])) ?  strtolower($allInfo[0]['last_name']) : ''  ?>" title="" id="last_name"  name='last_name' class="form-control form-control-sm">
               <input type="hidden" value="<?=  (!empty($allInfo[0]['id'])) ?  $allInfo[0]['id'] : ''  ?>" title="" id="staff_id"  name='staff_id' class="form-control form-control-sm">
               <input type="hidden" value="<?= $userinfo; ?>" title="" id="session_user_id"  name='session_user_id' class="form-control form-control-sm">
               
               <?php        
                  if(in_array('received_company_name',$project_info)) { ?>
               <div class="row g-3 align-items-center justify-content-md-center" style="display: none;">
                  <div class="col">
                     <label for="company_received" class="col-form-label">Co. Name Recd:</label>
                  </div>
                  <div class="col">
                     <input type="text" value="<?=  (!empty($allInfo[0]['received_company_name'])) ?  $allInfo[0]['received_company_name'] : ''  ?>" title="" id="company_received"  name='company_received' class="form-control form-control-sm" readonly>
                  </div>
               </div>
               <?php } ?>
               <!-- check input access for company name -->
               <?php if(in_array('company_name',$project_info)) { ?>
               <!-- <div class="row g-3 align-items-center justify-content-md-center">
                  <div class="col">
                     <label for="company_name" class="col-form-label">Co. Name:</label>
                  </div>
                  <div class="col">
                     <input type="text" value="<?=  (!empty($allInfo[0]['company_name'])) ?  $allInfo[0]['company_name'] : $allInfo[0]['received_company_name']  ?>" title="" id="company_name"  name='company_name' class="form-control form-control-sm" tabindex="1">
                  </div>
                  </div> -->
               <div class="row g-3 align-items-center justify-content-md-center">
                  <div class="col-auto">
                     <label for="company_name" class="col-form-label">Co. Name:</label>
                  </div>
                  <div class="col">
                     <?php 
                        if($userinfo == 6 && $allInfo[0]['web_staff_disposition'] == 5){?>
                     <input type="text" value="" title="" id="company_name"  name='company_name' class="form-control form-control-sm" tabindex="1">
                     <?php }elseif($userinfo == 3 && $allInfo[0]['voice_staff_disposition'] == 5){?>
                     <input type="text" value="" title="" id="company_name"  name='company_name' class="form-control form-control-sm" tabindex="1">
                     <?php }else{?>
                     <input type="text" value="<?=  (!empty($allInfo[0]['company_name'])) ?  $allInfo[0]['company_name'] : $allInfo[0]['received_company_name']  ?>" title="" id="company_name"  name='company_name' class="form-control form-control-sm" tabindex="1">
                     <?php }
                        ?>
                  </div>
               </div>
               <?php } ?>
               <div class="row g-3 align-items-center justify-content-md-center">
                  <!-- check input access for address_1 -->
                  <?php if(in_array('address1',$project_info)){ ?>
                  <div class="col">
                     <label for="address_1" class="col-form-label">Address:</label>
                     <input type="text" value="<?=  (!empty($allInfo[0]['address1'])) ?  $allInfo[0]['address1'] : ''  ?>" title="" id="address_1"  name='address_1' class="form-control form-control-sm" tabindex="2">
                  </div>
                  <?php } ?>
                  <!-- check input access for address_2 -->
                  <?php if(in_array('address2',$project_info)){ ?>
                  <div class="col">
                     <label for="address_2" class="col-form-label">Address 2:</label>
                     <input type="text" value="<?=  (!empty($allInfo[0]['address2'])) ?  $allInfo[0]['address2'] : ''  ?>" title="" id="address_2"  name='address_2' class="form-control form-control-sm" tabindex="3">
                  </div>
                  <?php } ?>
                  <!-- check input access for address_3 -->
                  <?php if(in_array('address3',$project_info)){ ?>
                  <div class="col">
                     <label for="address_3" class="col-form-label">Address 3:</label>
                     <input type="text" value="<?=  (!empty($allInfo[0]['address3'])) ?  $allInfo[0]['address3'] : ''  ?>" title="" id="address_3"  name='address_3' class="form-control form-control-sm" tabindex="4">
                  </div>
                  <?php } ?>
               </div>
               <?php 
                  $div_count=div_access($project_info,array('country','region','address_url'));
                  $access1 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access1; ?> style="margin-top:5px !important;">
                  <!-- check input access for country -->
                  <?php if(in_array('country',$project_info)){ ?>
                  <div class="col">
                     <label for="country" class="col-form-label">Country:</label>
                     <div id="search0" class="search input-group form-group" >
                        <input class="autosearch-input form-control form-control-sm" type="text" size="50" autocomplete="on"
                           placeholder="Search Country" id="country" value="<?= $allInfo[0]['countryname']; ?>" name="country" tabindex="5">
                        <span class="input-group-btn">
                        </span>
                     </div>
                  </div>
                  <?php } ?>
                  <!-- check input access for state/country -->
                  <?php if(in_array('state_county',$project_info)){ ?>
                  <div class="col">
                     <label for="state_name" class="col-form-label">State/County:</label>
                     <input type="text" value="<?=  (!empty($allInfo[0]['state_county'])) ?  $allInfo[0]['state_county'] : ''  ?>" title="" id="state_name"  name='state_name' class="form-control form-control-sm" tabindex="6">
                  </div>
                  <?php } ?>
                 
               </div>
               <?php 
                  $div_count=div_access($project_info,array('city','postal_code','state_county','tel_number','alternate_number','country_code'));
                  $access = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access; ?>>
                <!-- check input access for city -->
                <?php if(in_array('city',$project_info)){ ?>
                  <div class="col">
                     <label for="city_name" class="col-form-label">City:</label>
                     <input type="text" value="<?=  (!empty($allInfo[0]['city'])) ?  $allInfo[0]['city'] : ''  ?>" title="" id="city_name"  name='city_name' class="form-control form-control-sm" tabindex="7">
                  </div>
                  <?php } ?>
                  <!-- check input access for region -->
                  <?php if(in_array('region',$project_info)){ ?>
                  <div class="col">
                     <label for="region_name" class="col-form-label">Region:</label>
                     <input type="text" value="<?=  (!empty($allInfo[0]['region'])) ?  $allInfo[0]['region'] : ''  ?>" title="" id="region_name"  name='region_name' class="form-control form-control-sm" tabindex="8">
                  </div>
                  <?php } ?>
                  <!-- check input access for pincode -->
                  <?php if(in_array('postal_code',$project_info)){ ?>
                  <div class="col">
                     <label for="postal_code" class="col-form-label">Postal Code:</label>
                     <input type="hidden" value="<?=  (!empty($allInfo[0]['postal_codes'])) ?  $allInfo[0]['postal_codes'] : ''  ?>" title="" id="postal_codes"  name='postal_codes' class="form-control form-control-sm" >
                     <?php if(!empty($allInfo[0]['postal_codes'] && $allInfo[0]['postal_codes'] == 'No')){ $style="disabled";} ?>
                     <input type="text" value="<?=  (!empty($allInfo[0]['postal_code'])) ?  $allInfo[0]['postal_code'] : ''  ?>" title="" id="postal_code"  name='postal_code' class="form-control form-control-sm" tabindex="9" <?= $style ?>>
                  </div>
                  <?php } ?>
                  <!-- check input access for address_url -->
                  <?php if(in_array('address_url',$project_info)){ ?>
                  <div class="col">
                     <label for="address_source_url" class="col-form-label" style="font-size: 0.7rem;">Address Source URL:</label>
                     <div class="input-group" >
                        <input type="text" value="<?=  (!empty($allInfo[0]['address_souce_url'])) ?  $allInfo[0]['address_souce_url'] : ''  ?>" title="" id="address_source_url"  name='address_source_url' class="form-control form-control-sm" tabindex="10">
                        <a title="Open Address Source URL In New Tab"  onclick="openUrls(document.getElementById('address_source_url').value)" class="btn-sm btn-primary input-group-text" id="addressurl" target="_blank" tabindex="10"><span class="fa fa-arrow-right"  >-></span></a>
                     </div>
                  </div>
                  <?php } ?>
                  <?php if(in_array('country_code',$project_info)){ ?>
                  <div class="col">
                     <label for="country_code" class="col-form-label">Country Code:</label>
                     <input type="" value="<?=  (!empty($allInfo[0]['country_code'])) ?  $allInfo[0]['country_code'] : ''  ?>" title="" id="country_code"  name='country_code' class="form-control form-control-sm" readonly style="width:80px;" tabindex="11">
                  </div>
                  <?php } ?>
                 
               </div>
               <!-- check input access for industry,revenue -->
             <?php 
                  $div_count=div_access($project_info,array('tel_number','alternate_number'));
                  $access11 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access11; ?>>
                  <?php if(in_array('tel_number',$project_info)){ ?>
                  <div class="col">
                     <label for="tel_number" class="col-form-label">Telephone Number:</label>
                     <input type="" value="<?=  (!empty($allInfo[0]['tel_number'])) ?  $allInfo[0]['tel_number'] : ''  ?>" title="2 2403 3856" id="tel_number"  name='tel_number' class="form-control form-control-sm"  tabindex="12" >
                     <span id="spndirecttelError" style="color: Red; display: none">*Enter Valid characters: only Numbers & space.</span>
                  </div>
                  <?php } ?>
                  <?php if(in_array('alternate_number',$project_info)){ ?>
                     <div class="col">
                     <label for="alternate_number" class="col-form-label">Alternate Number:</label>
                     <input type="" value="<?=  (!empty($allInfo[0]['alternate_number'])) ?  $allInfo[0]['alternate_number'] : ''  ?>" title="" id="alternate_number"  name='alternate_number' class="form-control form-control-sm" tabindex="13">
                     <span id="spnaltnoError" style="color: Red; display: none;font-size:10px;">*Enter Valid characters: only Numbers & space.</span>
                     </div>
                  <?php } ?>
               </div>
                 <!-- check input access for alternate_number,tel_number -->
                 <?php 
                  $div_count=div_access($project_info,array('alternate_number','tel_number'));
                  $access9 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access9; ?>>
                  <!-- <div class="col">
                     <label for="fax_number" class="col-form-label">Fax Number:</label>
                     <input type="number" value="" title="" id="fax_number"  name='fax_number' class="form-control form-control-sm">
                     </div> -->
                  <?php //if(in_array('website_url',$project_info)){ ?>
                  <div class="col">
                     <label for="website_url" class="col-form-label">Website:</label>
                     <div class="input-group">
                        <input type="text" value="<?=  (!empty($allInfo[0]['website_url'])) ?  $allInfo[0]['website_url'] : ''  ?>" title="" id="website_url"  name='website_url' class="form-control form-control-sm" tabindex="14">
                        <a title="Open Website URL In New Tab." onclick="openUrls(document.getElementById('website_url').value)" class="btn-sm btn-primary input-group-text" id="websiteurl" target="_blank" tabindex="14"><span class="fa fa-arrow-right" >-></span></a>
                     </div>
                  </div>
                  <?php //} ?>
                  <!-- check input access for email_address,no_of_employees -->
                  <?php 
                     $div_count=div_access($project_info,array('email_address','no_of_emp'));
                     $access10 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                     ?>
                  <!-- <div class="row g-3 align-items-center justify-content-md-center" <?= $access10; ?>>
                     <?php if(in_array('email_address',$project_info)){ ?>
                         <div class="col">
                             <label for="email_address" class="col-form-label">Email Address:</label>
                             <input type="email" value="<?=  (!empty($allInfo[0]['ca5'])) ?  $allInfo[0]['ca5'] : ''  ?>" title="" id="email_address"  name='email_address' class="form-control form-control-sm">
                         </div>
                     <?php } ?> -->
                  <?php if(in_array('no_of_emp',$project_info)){ ?>
                  <div class="col">
                     <label for="no_of_employee" class="col-form-label">No. of Employees:</label>
                     <input type="text" value="<?=$allInfo[0]['no_of_emp'];?>" type="text" size="50" autocomplete="on"
                        placeholder="Search No. of Employees" title="" id="no_of_emp"  name='no_of_emp' class="autosearch-input form-control form-control-sm" tabindex="15">
                  </div>
                  <?php } ?>
                  <?php if(in_array('generic_email',$project_info)){ ?>
                  <div class="col">
                     <label for="generic_email" class="col-form-label">Generic Email:</label>
                     <input type="email" value="<?=$allInfo[0]['generic_email'];?>" type="text" 
                        placeholder="" title="" id="generic_mail"  name='generic_mail' class="form-control form-control-sm" tabindex="15">
                  </div>
                  <?php } ?>
               </div>
             <!-- check input access for industry,revenue -->
             <?php 
                  $div_count=div_access($project_info,array('industry','revenue'));
                  $access11 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access11; ?>>
                  <?php if(in_array('industry',$project_info)){ ?>
                  <div class="col">
                     <label for="industry" class="col-form-label">Industry:</label>
                     <input type="text" value="<?=$allInfo[0]['industryname'];?>" type="text" size="50" autocomplete="on"
                        placeholder="Search Industry" title="" id="industry"  name='industry' class="autosearch-input form-control form-control-sm" tabindex="16">
                  </div>
                  <?php } ?>
                  <?php if(in_array('revenue',$project_info)){ ?>
                  <div class="col">
                     <label for="revenue" class="col-form-label">Revenue:</label>
                     <div class="input-group">
                        <input type="text" value="<?=  (!empty($allInfo[0]['revenue'])) ?  $allInfo[0]['revenue'] : ''  ?>" title="" id="revenue"  name='revenue' class="form-control form-control-sm" tabindex="17">
                        <!-- <button class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" id="revenue_currency" name="revenue_currency"></button>
                           <ul class="dropdown-menu dropdown-menu-end revenue_currency" name="revenue_currency" id="revenue_currency">
                              <?php 
                              foreach ($currency as $key => $val) { ?>
                              <li><a href="#" class="dropdown-item"><?= $val['currency_name']." (".$val['currency_symbol'].")";?></a></li>
                              <?php }
                              ?>
                           </ul> -->
                        <select class="browser-default custom-select" id="revenue_cur" name="revenue_cur" placeholder="Select Revenue" tabindex="18">
                           <?php 
                              foreach ($currency as $key => $val) { ?>
                           <option value="<?= $val['id']?>" <?php if($allInfo[0]['revenue_curr'] == $val['id']){?> selected <?php } ?>><?= $val['currency_name']." (".$val['currency_symbol'].")";?></option>
                           <?php }
                              ?>
                        </select>
                     </div>
                  </div>
                  <?php } ?>
               </div>
               <!-- check input access for ca1,ca2,ca3,ca4,ca5 -->
               <?php 
                  $div_count=div_access($project_info,array('ca1','ca2','ca3','ca4','ca5'));
                  $access2 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access2; ?>>
                  <?php if(in_array('ca1',$project_info)){ ?>
                  <!-- <div class="col">
                     <label for="ca1" class="col-form-label">Event Link:</label>
                     <input type="text" value="<?=  (!empty($allInfo[0]['ca1'])) ?  $allInfo[0]['ca1'] : ''  ?>" title="" id="ca1"  name='ca1' class="form-control form-control-sm" tabindex="19">
                     
                     </div> -->
                  <label for="ca1" class="col-form-label">Event Link:</label>
                  <div class="input-group" style="margin-top: 0px !important;">
                     <input type="text" class="form-control" value="<?=  (!empty($allInfo[0]['ca1'])) ?  $allInfo[0]['ca1'] : ''  ?>" title="" id="ca1"  name='ca1'  aria-describedby="basic-addon1" tabindex="19">
                     <a  title="Browse Staff Source URL" onclick="openUrls(document.getElementById('ca1').value)" class="btn-sm btn-primary input-group-text" id="staffurl" target="_blank" tabindex="19"><span class="fa fa-arrow-right"style="margin-top:5px;" >-></span></a>
                  </div>
                  <?php } ?>
                  <?php if(in_array('ca3',$project_info)){ ?>
                  <div class="col">
                     <label for="ca3" class="col-form-label">CA3:</label>
                     <input type="text" value="<?=  (!empty($allInfo[0]['ca3'])) ?  $allInfo[0]['ca3'] : ''  ?>" title="" id="ca3"  name='ca3' class="form-control form-control-sm" tabindex="21">
                  </div>
                  <?php } ?>
                  <?php if(in_array('ca4',$project_info)){ ?>
                  <div class="col">
                     <label for="ca4" class="col-form-label">CA4:</label>
                     <input type="text" value="<?=  (!empty($allInfo[0]['ca4'])) ?  $allInfo[0]['ca4'] : ''  ?>" title="" id="ca4"  name='ca4' class="form-control form-control-sm" tabindex="22">
                  </div>
                  <?php } ?>
                  <?php
                     if(in_array('ca5',$project_info)){ ?>
                  <div class="col">
                     <label for="ca5" class="col-form-label">CA5:</label>
                     <input type="text" value="<?=  (!empty($allInfo[0]['ca5'])) ?  $allInfo[0]['ca5'] : ''  ?>" title="" id="ca5"  name='ca5' class="form-control form-control-sm" tabindex="23">
                  </div>
                  <?php } ?>
               </div>
               <!-- check input access for ca1,ca2,ca3,ca4,ca5 -->
               <?php 
                  $div_count=div_access($project_info,array('ca1','ca2','ca3','ca4','ca5'));
                  $access2 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access2; ?>>
                  <?php if(in_array('ca2',$project_info)){ ?>
                  <div class="col">
                     <label for="ca2" class="col-form-label">Specialities:</label>
                     <input type="text" value="<?=  (!empty($allInfo[0]['ca2'])) ?  $allInfo[0]['ca2'] : ''  ?>" title="" id="ca2"  name='ca2' class="form-control form-control-sm" tabindex="20">
                  </div>
                  <?php } ?>
               </div>
                 <!-- check input access for company_voice_disposition -->
                 <?php 
                  if($this->session->userdata('designation_id') == 3){
                  $div_count=div_access($project_info,array('voice_disposition'));
                  $access5 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access5; ?>>
                  <?php if(in_array('voice_disposition',$project_info)){ ?>
               
                  <div class="col">
                  <label for="company_voice_disposition" class="col-form-label">Co. Voice Disposition:</label>
                     <select class='form-control form-control-sm' id="company_voice_disposition"  name='company_voice_disposition' tabindex="26" onchange="getdisp(this.value)">
                        <?php if(empty($allInfo[0]['voice_disposition'])){?>
                        <option value='' selected disabled>Select Voice Disposition</option>
                        <?php }else{ ?>
                        <option value='' disabled hidden>Select Voice Disposition</option>
                        <?php } ?>
                        <?php 
                           foreach ($VoiceDispo as $key => $val) { ?>
                        <option value='<?= $val['id']; ?>' <?php if($allInfo[0]['voice_disposition']==$val['id']){?>selected<?php } ?>><?= $val['caller_disposition']; ?></option>
                        <?php }
                           ?>
                     </select>
                  </div>
               </div>
               <?php } }elseif($this->session->userdata('designation_id') == 8 ){ 
                  $div_count=div_access($project_info,array('voice_disposition'));
                  $access5 = ($div_count < 1) ? "style='display:none;'"."></div" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access5; ?>>
                  <?php if(in_array('voice_disposition',$project_info)){ ?>
                
                  <div class="col">
                  <label for="company_voice_disposition" class="col-form-label">Co. Voice Disposition:</label>
                     <select class='form-control form-control-sm' id="company_voice_disposition"  name='company_voice_disposition' tabindex="27" onchange="getdisp(this.value)">
                        <?php if(empty($allInfo[0]['voice_disposition'])){?>
                        <option value='' selected disabled>Select Voice Disposition</option>
                        <?php }else{ ?>
                        <option value='' disabled hidden>Select Voice Disposition</option>
                        <?php } ?>
                        <?php 
                           foreach ($VoiceDispo as $key => $val) { ?>
                        <option value='<?= $val['id']; ?>' <?php if($allInfo[0]['voice_disposition']==$val['id']){?>selected<?php } ?>><?= $val['caller_disposition']; ?></option>
                        <?php }
                           ?>
                     </select>
                  </div>
               </div>
               <?php } } ?>
            </div>
            <div class="col">
           
              <!-- check input access for first_name,last_name -->
              <?php 
                  $div_count=div_access($project_info,array('first_name','last_name','suffix'));
                  $access12 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access12; ?> style="margin-bottom:10px;">
                  <?php if(in_array('suffix',$project_info)){ ?>
                  <div class="col">
                     <label for="title" class="col-form-label">Title:</label>
                     <select class='form-control form-control-sm' id="title"  name='title' tabindex="31">
                        <option value=''>select a title</option>
                        <?php 
                           foreach ($name_prefix as $key => $val) { ?>
                        <option value='<?= $val['id']; ?>'
                           <?php if($allInfo[0]['suffix'] == $val['id']){ echo "selected"; } ?>><?= $val['prefix']; ?></option>
                        <?php }
                           ?>
                     </select>
                  </div>
                  <?php } ?> 
                  <?php if(in_array('first_name',$project_info)){ ?>
                  <div class="col">
                     <label for="first_name" class="col-form-label">First Name:</label>
                     <input type="text" value="<?=  (!empty($allInfo[0]['first_name'])) ?  $allInfo[0]['first_name'] : ''  ?>" title="" id="first_name"  name='first_name' class="form-control form-control-sm first_name" tabindex="32">
                  </div>
                  <?php } ?>
                  <?php if(in_array('last_name',$project_info)){ ?>
                  <div class="col">
                     <label for="last_name" class="col-form-label">Last Name:</label>
                     <input type="text" value="<?=  (!empty($allInfo[0]['last_name'])) ?  $allInfo[0]['last_name'] : ''  ?>"  id="last_name"  name='last_name' class="form-control form-control-sm last_name" tabindex="33">
                  </div>
                  <div class="col">
                     <div class="input-group" style="margin-top:20px;">
                        <a title="Browse Staff Info" class="btn-sm btn-primary input-group-text" target="_blank"  id="link" tabindex="34"><span style="color: white;" class="fa fa-arrow-right">-></span></a>
                     </div>
                  </div>
                  <?php } ?>
               </div>
               <!-- check input access for job_title -->
               <?php 
                  $div_count=div_access($project_info,array('provided_job_title'));
                  $access13 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center"  <?= $access13; ?> style="margin-bottom:10px;">
                  <?php if(in_array('provided_job_title',$project_info)){ ?>
                  <div class="col-3">
                     <label for="job_title" class="col-form-label">Job Title:</label>
                  </div>
                  <div class="col">
                     <input type="text" value="<?=  (!empty($allInfo[0]['updated_job_title'])) ?  $allInfo[0]['updated_job_title'] : ''  ?>" title="" id="job_title"  name='job_title' class="form-control form-control-sm" tabindex="35">
                  </div>
                  <?php } ?>
               </div>
               <!-- check input access for staff_job_function -->
               <?php 
                  $div_count=div_access($project_info,array('staff_job_function'));
                  $access14 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access14; ?> style="margin-bottom:10px;">
                  <?php if(in_array('staff_job_function',$project_info)){ ?>
                  <div class="col-3">
                     <label for="staff_job_function" class="col-form-label">Job Function:</label>
                  </div>
                  <div class="col">
                     <input type="text" value="<?=  (!empty($allInfo[0]['staff_job_function'])) ?  $allInfo[0]['staff_job_function'] : ''  ?>" title="" id="staff_job_function"  name='staff_job_function' class="form-control form-control-sm" tabindex="36">
                  </div>
                  <?php } ?>
               </div>
               <!-- check input access for staff_job_function -->
               <?php 
                  $div_count=div_access($project_info,array('provided_staff_email'));
                  $access15 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access15; ?> style="margin-bottom:10px;">
                  <?php if(in_array('provided_staff_email',$project_info)){ ?>
                  <div class="col-3">
                     <label for="staff_email" class="col-form-label">Staff Email:</label>
                  </div>
                  <div class="col">
                     <div class="input-group">
                        <input type="email" value="<?=  (!empty($allInfo[0]['staff_email'])) ?  $allInfo[0]['staff_email'] : ''  ?>" title="" id="staff_email"  name='staff_email' class="form-control form-control-sm" tabindex="37">
                        <span class="error" id="invalid_email"></span>
                     </div>
                  </div>
                  <?php } ?>
               </div>
               <!-- check input access for staff_department -->
               <?php 
                  $div_count=div_access($project_info,array('staff_department'));
                  $access16 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access16; ?> style="margin-bottom:10px;">
                  <?php if(in_array('staff_department',$project_info)){ ?>
                  <div class="col-3">
                     <label for="staff_department" class="col-form-label">Staff Department:</label>
                  </div>
                  <div class="col">
                     <input type="text" value="<?=  (!empty($allInfo[0]['staff_department'])) ?  $allInfo[0]['staff_department'] : ''  ?>" title="" id="staff_department"  name='staff_department' class="form-control form-control-sm" tabindex="38">
                  </div>
                  <?php } ?>
               </div>
               <!-- check input access for staff_department -->
               <?php 
                  $div_count=div_access($project_info,array('staff_url'));
                  $access17 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access17; ?> >
                  <?php if(in_array('staff_url',$project_info)){ ?>
                  <div class="col-3">
                     <label for="staff_url" class="col-form-label">Staff Linkedin URL:</label>
                  </div>
                  <div class="col">
                     <div class="input-group mb-3">
                        <input type="text" class="form-control" value="<?=  (!empty($allInfo[0]['staff_url'])) ?  $allInfo[0]['staff_url'] : ''  ?>" title="" id="staff_url"  name='staff_url'  aria-describedby="basic-addon1" tabindex="39">
                        <a  title="Browse Staff Source URL" onclick="openUrls(document.getElementById('staff_url').value)" class="btn-sm btn-primary input-group-text" id="staffurl" target="_blank" tabindex="39"><span class="fa fa-arrow-right"style="margin-top:5px;" >-></span></a>
                     </div>
                  </div>
                  <?php } ?>
               </div>
               <!-- check input access for staff_department -->
               <?php 
                  $div_count=div_access($project_info,array('assumed_email'));
                  $access18 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access18; ?> style="margin-bottom:10px;">
                  <?php if(in_array('assumed_email',$project_info)){ ?>
                  <div class="col-3">
                     <label for="assumed_email" class="col-form-label">Assumed Email:</label>
                  </div>
                  <div class="col">
                     <input type="" value="<?=  (!empty($allInfo[0]['assumed_email'])) ?  $allInfo[0]['assumed_email'] : ''  ?>" title="" id="assumed_email"  name='assumed_email' class="form-control form-control-sm" tabindex="40">
                  </div>
                  <?php } ?>
               </div>
               <!-- check input access for staff_email_harvesting -->
               <?php 
                  $div_count=div_access($project_info,array('staff_email_harvesting'));
                  $access19 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access19; ?> >
                  <?php if(in_array('staff_email_harvesting',$project_info)){ ?>
                  <div class="col-3">
                     <label for="staff_email_harvesting" class="col-form-label">Email Source URL:</label>
                  </div>
                  <div class="col">
                     <div class="input-group mb-3">
                        <input type="text" value="<?=  (!empty($allInfo[0]['staff_email_harvesting'])) ?  $allInfo[0]['staff_email_harvesting'] : ''  ?>" title="Clearbit" id="staff_email_harvesting"  name='staff_email_harvesting' class="form-control form-control-sm" tabindex="41">
                        <a title="Browse Email Source URL" onclick="openUrls(document.getElementById('staff_email_harvesting').value)" class="btn-sm btn-primary input-group-text" id="staffemailharvesting" target="_blank" tabindex="41"><span class="fa fa-arrow-right"style="margin-top:5px;" >-></span></a>
                     </div>
                  </div>
                  <?php } ?>
               </div>
               <!-- check input access for staff_direct_tel,staff_mobile -->
               <?php 
                  $div_count=div_access($project_info,array('staff_direct_tel','staff_mobile'));
                  $access20 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access20; ?> >
                  <?php if(in_array('staff_direct_tel',$project_info)){ ?>
                  <div class="col-3">
                     <label for="staff_direct_tel" class="col-form-label">Direct Tel:</label>
                     <input type="text" value="<?=  (!empty($allInfo[0]['staff_direct_tel'])) ?  $allInfo[0]['staff_direct_tel'] : ''  ?>" title="" tabindex="42" id="staff_direct_tel"  name='staff_direct_tel' class="form-control form-control-sm">
                     <span id="spnError" style="color: Red; display: none">*Enter Valid characters: Numbers X Number.</span>
                  </div>
                  <!-- <div class="col">
                     <label for="staff_extension" class="col-form-label">Extension:</label>
                     <input type="text" value="" title="" id="staff_extension"  name='staff_extension' class="form-control form-control-sm">
                     </div> -->
                  <div class="col">
                     <label for="staff_mobile" class="col-form-label">Mobile:</label>
                     <input type="" value="<?=  (!empty($allInfo[0]['staff_mobile'])) ?  $allInfo[0]['staff_mobile'] : ''  ?>" title="" id="staff_mobile"  name='staff_mobile' class="form-control form-control-sm" tabindex="43">
                     <span id="spnmobileError" style="color: Red; display: none">*Enter Valid characters: only Numbers & Space.</span>
                  </div>
                  <?php } ?>
               </div>
               <!-- check input access for voice_staff_disposition -->
               <?php
                  if($this->session->userdata('designation_id') == 3 || $this->session->userdata('designation_id') == 1 || $this->session->userdata('designation_id') == 2 ||  $this->session->userdata('designation_id') == 8 ||  $this->session->userdata('designation_id') == 14){ 
                    $div_count=div_access($project_info,array('voice_staff_disposition'));
                    $access22 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                    ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access22; ?> style="margin-top:2px;">
                  <?php if(in_array('voice_staff_disposition',$project_info)){ ?>
                  <div class="col-auto">
                     <label for="voice_staff_disposition" class="col-form-label">Voice Staff Disposition:</label>
                     <input type="hidden" value="<?php echo $allInfo[0]['voice_staff_disposition'] ?>" id="vsd">
                  </div>
                  <div class="col voice_staff_disposition">
                     <?php 
                        $style = '';
                        if($ButtonInfo['button_type']=='NS'  && $ButtonInfo['count']>0 || $ButtonInfo['button_type']=='SLREP'  && $ButtonInfo['count']>0 || $ButtonInfo['button_type']=='SLAA'  && $ButtonInfo['count']>0 || $ButtonInfo['button_type']=='SLA'  && $ButtonInfo['count']>0 ){
                           $style="";
                        }
                        elseif($allInfo[0]['caller_has_replaced'] != '')
                        {
                           $style=""; 
                        }
                        
                        
                        ?>
                     <select class='form-control form-control-sm select2 voice_staff_disposition' id="voice_staff_disposition"  name='voice_staff_disposition' tabindex="45" <?= $style; ?> style="display:block !important;">
                        <?php
                           if(empty($allInfo[0]['voice_staff_disposition'])){?>
                        <option value='' selected disabled>select Voice Staff Disposition</option>
                        <?php }else{ ?>
                        <option value='' disabled hidden>select Voice Staff Disposition</option>
                        <?php }?>
                        <?php 
                           //foreach ($VoiceDispos as $key => $val) { ?>
                        <!-- <option value='<?= $val['id']; ?>' <?php if($allInfo[0]['voice_staff_disposition']==$val['id']){?>selected<?php } ?>><?= $val['voice_dispositions']; ?></option> -->
                        <?php //}
                           ?>
                     </select>
                  </div>
               </div>
               <?php } }?>
               <!-- <div class="row g-3 align-items-center justify-content-md-center">
                  <div class="col">
                      <label for="staff_interest_area" class="col-form-label">Interest Area:</label>
                  </div>
                  <div class="col">
                      <input type="text" value="" title="" id="staff_interest_area"  name='staff_interest_area' class="form-control form-control-sm">
                  </div>
                  </div> -->
               <!-- check input access for voice_staff_disposition -->
               
               <?php 
                  $div_count=div_access($project_info,array('staff_linkedin_count'));
                  $access23 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access23; ?>>
                  <?php if(in_array('staff_linkedin_count',$project_info)){ ?>
                  <div class="col">
                     <label for="staff_linkedin_count" class="col-form-label">Linkedin Connections Count:</label>
                  </div>
                  <div class="col">
                     <input type="number" value="<?=  (!empty($allInfo[0]['staff_linkedin_con'])) ?  $allInfo[0]['staff_linkedin_con'] : ''  ?>" title="" id="staff_linkedin_count"  name='staff_linkedin_count' class="form-control form-control-sm" tabindex="46">
                  </div>
                  <?php } ?>
               </div>
               <?php 
                  $div_count=div_access($project_info,array('work_experience'));
                  $access23 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access23; ?>>
                  <?php if(in_array('work_experience',$project_info)){ ?>
                  <div class="col">
                     <label for="work_experience" class="col-form-label">Work Experience:</label>
                  </div>
                  <div class="col">
                     <input type="number" value="<?=  (!empty($allInfo[0]['work_experience'])) ?  $allInfo[0]['work_experience'] : ''  ?>" title="" id="work_experience"  name='work_experience' class="form-control form-control-sm" tabindex="46">
                  </div>
                  <?php } ?>
               </div>
               
               <!-- check input access for voice_staff_disposition -->
               <?php 
                  $div_count=div_access($project_info,array('staff_note'));
                  $access24 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access24; ?> style="margin-top:2px;">
                  <?php if(in_array('staff_note',$project_info)){ ?>
                  <div class="col-auto">
                     <label for="staff_note" class="col-form-label">Caller Remark:</label>
                  </div>
                  <div class="col mb-1">
                     <textarea title="" tabindex="47" id="staff_note"  name='staff_note' class="form-control form-control-sm"><?=  (!empty($allInfo[0]['staff_note'])) ?  $allInfo[0]['staff_note'] : ''  ?></textarea>
                  </div>
                  <?php } ?>
               </div>
               <div class="row g-3 align-items-center justify-content-md-center"  <?= $access13; ?> style="margin-top:10px;display:flex" id="followdatetime">
                  <?php if(in_array('provided_job_title',$project_info)){ ?>
                  <div class="col-3">
                     <label for="job_title" class="col-form-label">Followup DateTime:</label>
                  </div>
                  <div class="col">
                  <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                            <input type="text" class="form-control form-control-sm datetimepicker-input" data-target="#datetimepicker1" id="from_date1" name="from_date1" placeholder="From Date" value="<?= ($allInfo[0]['followup_date']) ? $allInfo[0]['followup_date'] : '' ?>" />
                            <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                  </div>
                  <?php } ?>
               </div>
               <!-- check input access for Rearcher_remark-->
               <?php 
                  $div_count=div_access($project_info,array('research_remark'));
                  $access25 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access25; ?>>
                  <div class="col">
                     <label for="research_remark" class="col-form-label">Researcher Remark:</label>
                  </div>
                  <div class="col">
                     <a href="#"  style="text-decoration: none" data-bs-toggle="modal" data-bs-target="#researcher_remarkss" tabindex="48">
                     <input type="text" value="View Researcher Remark" title="" id="researcher_remarks_input"  name='' class="form-control form-control-sm" tabindex="48" readonly=""></a>
                  </div>
               </div>
               <!-- Started Popup for the Researcher Remarks -->
               <div class="modal fade" id="researcher_remarkss" tabindex="-1" aria-labelledby="briefDetailsLabel" aria-hidden="true">
                  <div class="modal-dialog">
                     <div class="modal-content" >
                        <div class="modal-header">
                           <h5 class="modal-title" id="briefDetailsLabel">View Researcher Remark:</h5>
                        </div>
                        <div class="col researchcompanyremark">
                           <?php if(in_array('research_remark',$project_info)){ 
                              if($userinfo == 3){
                              ?>
                           <div class="col researchremark">
                              <select  class="form-control form-control-sm research_remark" id="research_remark[]" multiple name="research_remark[]" tabindex="47" disabled style="overflow: hidden;height: 210px;background-color: #ffffff;">
                                 <?php 
                                    $remark=explode(',', $allInfo[0]['research_remark']);
                                    foreach($researcher_remark as $user_key => $val)
                                    {  
                                       $id = $val['id'];
                                       $style="style='background-color:white;color:blue;'"; 
                                       if(in_array($id,$remark)){
                                       ?>
                                 <option <?= $style;  ?> value='<?= $val['id']; ?>' <?php if(in_array($id,$remark)){echo "selected";}  ?>><?= $val['researcher_remark']; ?></option>
                                 <?php } }
                                    ?>
                              </select>
                           </div>
                           <?php }else{ ?>
                           <div class="col researchremark">
                              <select  style="overflow: hidden;height: 210px;" class="form-control form-control-sm research_remark" id="research_remark[]" multiple name="research_remark[]" tabindex="47" >
                                 <?php 
                                    $remark=explode(',', $allInfo[0]['research_remark']);
                                    foreach($researcher_remark as $user_key => $val)
                                    {  
                                       $id = $val['id'];
                                       ?>
                                 <option value='<?= $val['id']; ?>' <?php if(in_array($id,$remark)){echo "selected";} ?>><?= $val['researcher_remark']; ?></option>
                                 <?php }
                                    ?>
                              </select>
                           </div>
                           <?php } }?>
                        </div>
                        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button></div>
                     </div>
                  </div>
               </div>
               <!-- Ended Popup for the Researcher Remarks -->
               <!-- check input access for Rearcher_remark-->
               <?php 
                  $div_count=div_access($project_info,array('voice_remark'));
                  $div_count =0;
                  $access25 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  
                  if($userinfo == 3 || $userinfo == 8)
                  {?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access25; ?>>
                  <?php if(in_array('voice_remark',$project_info)){ ?>
                  <div class="col">
                     <label for="voice_remark" class="col-form-label">Caller Remark:</label>
                  </div>
                  <div class="col">
                     <a href="#"  style="text-decoration: none" data-bs-toggle="modal" data-bs-target="#caller_multi_remarks" tabindex="49">
                     <input type="text" value="Select Caller Remark" title="" id=""  name='' class="form-control form-control-sm" tabindex="49" readonly="" style="background-color:white;"></a>
                  </div>
                  <?php } ?>
               </div>
               <?php }?>
               <!-- Popup Started for the Caller Remarks -->
               <div class="modal fade" id="caller_multi_remarks" tabindex="-1" aria-labelledby="briefDetailsLabel" aria-hidden="true">
                  <div class="modal-dialog">
                     <div class="modal-content" >
                        <div class="modal-header">
                           <h5 class="modal-title" id="briefDetailsLabel">Caller Remark</h5>
                        </div>
                        <div class="col researchcompanyremark">
                           <select  class="form-control form-control-sm voice_remark" id="voice_remark[]" multiple name="voice_remark[]" tabindex="30" style="overflow: scroll;height: 350px;" >
                              <?php 
                                 foreach($caller_remark as $user_key => $val)
                                 {?>
                              <option value='<?= $val['id']; ?>' <?php if(in_array($val['id'],explode(',',$allInfo[0]['voice_remark']))){?>selected<?php } ?>><?= $val['caller_remark']; ?></option>
                              <?php }
                                 ?>
                           </select>
                        </div>
                        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button></div>
                     </div>
                  </div>
               </div>
               <!-- Popup Enede for the Caller Remarks -->
               <!-- check input access for ca1,ca2,ca3,ca4,ca5 -->
               <?php 
                  $div_count=div_access($project_info,array('ca1','ca2','ca3','ca4','ca5'));
                  $access2 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access2; ?>>
                  <?php if(in_array('sa1',$project_info)){ ?>
                  <div class="col">
                     <label for="sa1" class="col-form-label">SA1:</label>
                     <input type="text" value="<?=  (!empty($allInfo[0]['sa1'])) ?  $allInfo[0]['sa1'] : ''  ?>" title="" id="sa1"  name='sa1' class="form-control form-control-sm" tabindex="52">
                  </div>
                  <?php } ?>
                  <?php if(in_array('sa2',$project_info)){ ?>
                  <div class="col">
                     <label for="sa2" class="col-form-label">SA2:</label>
                     <input type="text" value="<?=  (!empty($allInfo[0]['sa2'])) ?  $allInfo[0]['sa2'] : ''  ?>" title="" id="sa2"  name='sa2' class="form-control form-control-sm" tabindex="53">
                  </div>
                  <?php } ?>
                  <?php if(in_array('sa3',$project_info)){ ?>
                  <div class="col">
                     <label for="sa3" class="col-form-label">SA3:</label>
                     <input type="text" value="<?=  (!empty($allInfo[0]['sa3'])) ?  $allInfo[0]['sa3'] : ''  ?>" title="" id="sa3"  name='sa3' class="form-control form-control-sm" tabindex="54">
                  </div>
                  <?php } ?>
                  <?php if(in_array('sa4',$project_info)){ ?>
                  <div class="col">
                     <label for="sa4" class="col-form-label">SA4:</label>
                     <input type="text" value="<?=  (!empty($allInfo[0]['sa4'])) ?  $allInfo[0]['sa4'] : ''  ?>" title="" id="sa4"  name='sa4' class="form-control form-control-sm" tabindex="55">
                  </div>
                  <?php } ?>
                  <?php if(in_array('sa5',$project_info)){ ?>
                  <div class="col">
                     <label for="sa5" class="col-form-label">SA5:</label>
                     <input type="text" value="<?=  (!empty($allInfo[0]['sa5'])) ?  $allInfo[0]['sa5'] : ''  ?>" title="" id="sa5"  name='sa5' class="form-control form-control-sm" tabindex="56">
                  </div>
                  <?php } ?>
               </div>
               <!-- check input access for company_disposition -->
               <?php 
                  $div_count=div_access($project_info,array('company_disposition'));
                  $access3 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access3; ?>>
                  <?php if(in_array('company_disposition',$project_info)){ ?>
                  <div class="col">
                     <label for="company_disposition" class="col-form-label">Co. Disposition:</label>
                  </div>
                  <div class="col">
                     <select class='form-control form-control-sm' id="company_disposition"  name='company_disposition' tabindex="24">
                        <?php if(empty($allInfo[0]['company_disposition'])){?>
                        <option value='' selected disabled>Select Co. Disposition</option>
                        <?php }else{?> 
                        <option value='' disabled hidden>Select Co. Disposition</option>
                        <?php } ?>
                        <?php 
                           foreach ($compDispo as $key => $val) { ?>
                        <option value='<?= $val['id']; ?>' <?php if($val['id'] == $allInfo[0]['company_disposition']){?>selected<?php } ?> ><?= $val['company_dispostion']; ?></option>
                        <?php }
                           ?>
                     </select>
                  </div>
                  <?php } ?>
               </div>
               <!-- check input access for company_web_dispositon -->
               <?php 
                  $div_count=div_access($project_info,array('web_disposition'));
                  $access4 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access4; ?>>
                  <?php if(in_array('web_disposition',$project_info)){ 
                     if($userinfo == 3){?>
                  <div class="col">
                     <label for="company_web_dispositon" class="col-form-label">Co. Web Disposition:</label>
                  </div>
                  <div class="col">
                     <select class='form-control form-control-sm' id="company_web_dispositon"  name='company_web_dispositon' tabindex="25" disabled>
                        <?php if(empty($allInfo[0]['web_disposition'])){?>
                        <option value='' selected disabled>select Web Disposition</option>
                        <?php }else{ ?>
                        <option value=''hidden>select Web Disposition</option>
                        <?php } ?>
                        <?php  //echo $allInfo[0]['web_disposition'];die();
                           foreach ($webDispo as $key => $val) {?>
                        <option value='<?= $val['id']; ?>' <?php if($allInfo[0]['web_disposition']==$val['id']){?>selected<?php } ?>><?= $val['web_disposition_name']; ?></option>
                        <?php }
                           ?>
                     </select>
                  </div>
                  <?php }else{?>
                  <div class="col">
                     <label for="company_web_dispositon" class="col-form-label">Co. Web Disposition:</label>
                  </div>
                  <div class="col">
                     <select class='form-control form-control-sm' id="company_web_dispositon"  name='company_web_dispositon' tabindex="25" >
                        <?php if(empty($allInfo[0]['web_disposition'])){?>
                        <option value='' selected disabled>select Web Disposition</option>
                        <?php }else{ ?>
                        <option value='' disabled hidden>select Web Disposition</option>
                        <?php } ?>
                        <?php
                           foreach ($webDispo as $key => $val) { ?>
                        <option value='<?= $val['id']; ?>' <?php if($allInfo[0]['web_disposition']==$val['id']){?>selected<?php } ?>><?= $val['web_disposition_name']; ?></option>
                        <?php }
                           ?>
                     </select>
                  </div>
                  <?php } } ?>
               </div>
             
               <!-- check input access for company_voice_disposition -->
               <?php 
                  $div_count=div_access($project_info,array('company_genaral_notes'));
                  $access6 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <!-- <div class="row g-3 align-items-center justify-content-md-center" <?= $access6; ?>>
                  <?php if(in_array('company_genaral_notes',$project_info)){ ?>
                  <div class="col">
                     <label for="company_genaral_notes" class="col-form-label">Co. General Notes:</label>
                  </div>
                  <div class="col">
                     <input type="text" value="<?=  (!empty($allInfo[0]['company_genaral_notes'])) ?  $allInfo[0]['company_genaral_notes'] : ''  ?>" title="" id="company_genaral_notes"  name='company_genaral_notes' class="form-control form-control-sm" tabindex="29">
                  </div>
                  <?php } ?>
                  </div> -->
               <!-- check input access for researcher_company_remark -->
               <?php if($userinfo == 6 || $userinfo == 8){?>
               <?php 
                  $div_count=div_access($project_info,array('researcher_company_remark'));
                  $access7 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access7; ?>>
                  <?php if(in_array('researcher_company_remark',$project_info)){ ?>
                  <div class="col">
                     <label for="researcher_company_remark" class="col-form-label">Researcher Co. Remark:</label>
                  </div>
                  <div class="col">
                     <a href="#"  style="text-decoration: none" data-bs-toggle="modal" data-bs-target="#company_remarkss" tabindex="29">
                     <input type="text" value="Select Researcher Co. Remark" title="" id="researcher_company_remark_input"  name='' class="form-control form-control-sm" tabindex="29" readonly="" style="background-color:white;"></a>
                  </div>
                  <?php } ?>
               </div>
               <!--  Popup for Researcher company Remark -->
               <div class="modal fade" id="company_remarkss" tabindex="-1" aria-labelledby="briefDetailsLabel" aria-hidden="true" >
                  <div class="modal-dialog">
                     <div class="modal-content" >
                        <div class="modal-header">
                           <h5 class="modal-title" id="briefDetailsLabel">Researcher Co. Remark: </h5>
                        </div>
                        <div class="col researchcompanyremark" >
                           <select  class="form-control form-control-sm researcher_company_remark" id="researcher_company_remark[]" multiple name="researcher_company_remark[]" tabindex="30" style="overflow: scroll;height: 300px;">
                              <?php 
                                 foreach($company_remark as $user_key => $val)
                                 {?>
                              <option value='<?= $val['id']; ?>' <?php if(in_array($val['id'],explode(',',$allInfo[0]['researcher_company_remark']))){?>selected<?php } ?>><?= $val['company_remark']; ?></option>
                              <?php }
                                 ?>
                           </select>
                        </div>
                        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button></div>
                     </div>
                  </div>
               </div>
               <!-- Ended Popup for Researcher Company Remark -->
               <!-- check input access for researcher_company_note -->
               <?php 
                  $div_count=div_access($project_info,array('researcher_company_note'));
                  $access7 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access7; ?>>
                  <?php if(in_array('researcher_company_note',$project_info)){ ?>
                  <div class="col">
                     <label for="researcher_company_remark" class="col-form-label">Researcher Co. Note:</label>
                  </div>
                  <div class="col">
                     <textarea  tabindex="30" title="" id="researcher_company_note"  name='researcher_company_note' class="form-control form-control-sm" tabindex="30"><?=  (!empty($allInfo[0]['researcher_company_note'])) ?  $allInfo[0]['researcher_company_note'] : ''  ?></textarea>
                  </div>
                  <?php } ?>
               </div>
               <?php }else{?>
               <?php 
                  $div_count=div_access($project_info,array('researcher_company_remark'));
                  $access7 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access7; ?>>
                  <?php if(in_array('researcher_company_remark',$project_info)){ ?>
                  <div class="col">
                     <label for="researcher_company_remark" class="col-form-label">Researcher Co. Remark:</label>
                  </div>
                  <div class="col">
                     <a href="#"  style="text-decoration: none" data-bs-toggle="modal" data-bs-target="#disabled_company_remarks" tabindex="29">
                     <input type="text" value="View Researcher Co. Remark" title="" id="researcher_company_remark_input"  name='' class="form-control form-control-sm" tabindex="29" readonly=""></a>
                  </div>
                  <?php } ?>
               </div>
               <!-- Disabled Company Remarks for the caller -->
               <div class="modal fade" id="disabled_company_remarks" tabindex="-1" aria-labelledby="briefDetailsLabel" aria-hidden="true">
                  <div class="modal-dialog">
                     <div class="modal-content" >
                        <div class="modal-header">
                           <h5 class="modal-title" id="briefDetailsLabel">View Researcher Company Remarks </h5>
                        </div>
                        <div class="col researchcompanyremark">
                           <select  class="form-control form-control-sm researcher_company_remark" id="researcher_company_remark[]" multiple name="researcher_company_remark[]" tabindex="30" style="overflow: hidden;height: 210px;background-color: #ffffff;"    >
                              <?php 
                                 foreach($company_remark as $user_key => $val)
                                 {?>
                              <?php 
                                 $style="style='background-color:white;color:blue;'";  
                                 if(in_array($val['id'],explode(',',$allInfo[0]['researcher_company_remark']))){ ?>
                              <option disabled="true" <?= $style; ?>     value='<?= $val['id']; ?>' <?php if(in_array($val['id'],explode(',',$allInfo[0]['researcher_company_remark']))){?>selected<?php } ?>><?= $val['company_remark']; ?></option>
                              <?php }
                                 ?>
                              <?php }
                                 ?>
                           </select>
                        </div>
                        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button></div>
                     </div>
                  </div>
               </div>
               <!-- Ended Disabled Company Remarks for the caller -->
               <!-- check input access for researcher_company_note -->
               <?php 
                  $div_count=div_access($project_info,array('researcher_company_note'));
                  $access7 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access7; ?>>
                  <?php if(in_array('researcher_company_note',$project_info)){ ?>
                  <div class="col">
                     <label for="researcher_company_remark" class="col-form-label">Researcher Co. Note:</label>
                  </div>
                  <div class="col">
                     <textarea  tabindex="30" title="" id="researcher_company_note"  name='researcher_company_note' class="form-control form-control-sm" readonly><?=  (!empty($allInfo[0]['researcher_company_note'])) ?  $allInfo[0]['researcher_company_note'] : ''  ?></textarea>
                  </div>
                  <?php } ?>
               </div>
               <?php } ?>
               <?php if($userinfo == 8 || $userinfo == 3){ ?>
               <!-- check input access for caller_company_remark -->
               <?php 
                  $div_count=div_access($project_info,array('caller_company_remark'));
                  $access7 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access7; ?>>
                  <?php if(in_array('caller_company_remark',$project_info)){ ?>
                  <div class="col">
                     <label for="caller_company_remark" class="col-form-label">Caller Co. Remark:</label>
                  </div>
                  <div class="col">
                     <a href="#"  style="text-decoration: none" data-bs-toggle="modal" data-bs-target="#caller_com_remarkss" tabindex="29">
                     <input type="text" value="Select Caller Co. Remark" title="" id="caller_company_remark_input"  name='' class="form-control form-control-sm" tabindex="29" style="background-color: white;" readonly=""></a>
                  </div>
                  <?php } ?>
               </div>
               <!-- Enabled Popup for the caller Remarks -->
               <div class="modal fade" id="caller_com_remarkss" tabindex="-1" aria-labelledby="briefDetailsLabel" aria-hidden="true">
                  <div class="modal-dialog">
                     <div class="modal-content" >
                        <div class="modal-header">
                           <h5 class="modal-title" id="briefDetailsLabel">Caller Co. Remark:</h5>
                        </div>
                        <div class="col callercompanyremark">
                           <select  class="form-control form-control-sm caller_company_remark" id="caller_company_remark[]" multiple name="caller_company_remark[]" tabindex="30"  style="overflow: scroll;height: 300px;"   >
                              <?php 
                                 foreach($company_remark as $user_key => $val)
                                 {?>
                              <option value='<?= $val['id']; ?>' <?php if(in_array($val['id'],explode(',',$allInfo[0]['caller_company_remark']))){?>selected<?php } ?>><?= $val['company_remark']; ?></option>
                              <?php }
                                 ?>
                           </select>
                        </div>
                        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button></div>
                     </div>
                  </div>
               </div>
               <!-- Enabled Popup Closed for the caller Remarks -->
               <!-- check input access for caller_company_note -->
               <?php 
                  $div_count=div_access($project_info,array('caller_company_note'));
                  $access7 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access7; ?>>
                  <?php if(in_array('caller_company_note',$project_info)){ ?>
                  <div class="col">
                     <label for="caller_company_note" class="col-form-label">Caller Co. Note:</label>
                  </div>
                  <div class="col">
                     <textarea  tabindex="30" title="" id="caller_company_note"  name='caller_company_note' class="form-control form-control-sm"><?=  (!empty($allInfo[0]['caller_company_note'])) ?  $allInfo[0]['caller_company_note'] : ''  ?></textarea>
                  </div>
                  <?php } ?>
               </div>
               <?php } ?>
            </div>
            <div class="col">
               
               <div id="valid_error">
               </div>
               <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-top:15px;">
                  <li class="nav-item" role="presentation">
                     <button style='font-size:12px' class="nav-link active" id="company-tab" data-bs-toggle="tab" data-bs-target="#company" type="button" role="tab" aria-controls="company" aria-selected="true"><?=  (!empty($allInfo[0]['received_company_name'])) ?  $allInfo[0]['received_company_name'] : ''  ?><?=  (!empty($staff_list)) ?  ' ('.count($staff_list).')' : '(0)' ?></button>
                  </li>
                  <li class="nav-item" role="presentation">
                     <button style='font-size:12px' class="nav-link" id="project-tab" data-bs-toggle="tab" data-bs-target="#project" type="button" role="tab" aria-controls="project" aria-selected="false"><?=  (!empty($company_list[0]['project_name'])) ?  $company_list[0]['project_name'] : ''  ?> <?=  (!empty($company_list[0]['project_name'])) ?  '('.count($company_list).')' : '(0)' ?></button>
                  </li>
                  <li class="nav-item" role="presentation">
                     <button style='font-size:12px' class="nav-link" id="company-tab1" data-bs-toggle="tab" data-bs-target="#company1" type="button" role="tab" aria-controls="company1" aria-selected="true"><?php if(!empty($allstaffinfo)){ echo 'All ('.count($allstaffinfo).')'; }else{ 'All (0)'; } ?></button>
                  </li>
               </ul>
               <div id="refreshtable">
                  <div class="tab-content" id="myTabContent">
                     <div class="tab-pane fade show active" id="company" role="tabpanel" aria-labelledby="company-tab">
                        <div class='table-responsive' style='height:230px;font-size:12px'>
                           <table class="table table-hover table-bordered table-sm p-0 m-0" width="100%" cellspacing="0" id="company_table">
                              <tr>
                                 <?php  if(!empty($this->session->userdata('error'))){?>
                                 <th>Pending Records</th>
                                 <?php }?>
                                 <th>Pending status</th>
                                 <th>Staff Name</th>
                                 <?php $designation_name = $this->session->userdata('designation_name');  if($designation_name=='Researcher'){ ?>
                                 <th>web Staff Disposition</th>
                                 <?php }else if($designation_name=='Caller'){?>
                                 <th>voice Staff Disposition</th>
                                 <th>Caller Has Replaced</th>
                                 <th>Status</th>
                                 <?php }else{
                                     if($allInfo[0]['activity_type'] == "voice"){?>
                                 <th>voice Staff Disposition</th>
                                 <th>Country</th>
                                 <?php } ?>
                                 <?php } ?>
                                 
                              </tr>
                              <?php 
                                 foreach($staff_list as $staff_list_key => $staff_list_val) {
                                    //echo $staff_list_val['dispositions'];
                                    ?>
                              <tr <?php if($staff_list_val['id'] == $allInfo[0]['id']){ ?>style="background: yellow;" <?php } ?>>
                              <td id="check_<?=$staff_list_val['id'];?>"><?php if($staff_list_val['validation_status'] == '0'){?><a href="<?php echo base_url().'Projects/my_projects/'.base64_encode($staff_list_val['project_id']).'/'.base64_encode($staff_list_val['id']).'/'.base64_encode($staff_list_val['comp_name']);?>"><span class="badge bg-danger " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"><span class="fa fa-times"></span></span></a><?php }elseif($staff_list_val['validation_status'] == '1'){?>
                                    <a href="<?php echo base_url().'Projects/my_projects/'.base64_encode($staff_list_val['project_id']).'/'.base64_encode($staff_list_val['id']).'/'.base64_encode($staff_list_val['comp_name']);?>"><span class="badge bg-success " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"><span class="fa fa-check"></span></span></a><?php }else{?>
                                    <a href="<?php echo base_url().'Projects/my_projects/'.base64_encode($staff_list_val['project_id']).'/'.base64_encode($staff_list_val['id']).'/'.base64_encode($staff_list_val['comp_name']);?>"><span class="badge bg-danger " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"><span class="fa fa-times"></span></span></a>
                                    <?php } ?>
                                 </td>
                                 <td><?= $staff_list_val['first_name'].' '.$staff_list_val['last_name']; ?></td>
                                 <td><?php  if($designation_name=='Caller'){?>
                                 <?= $staff_list_val['voice_dispositions']; ?>
                                 <?php }else{  if($allInfo[0]['activity_type'] == "voice"){?>
                                 <?= $staff_list_val['voice_dispositions']; ?>
                                 <?php }else{?>
                                 <?= $staff_list_val['voice_dispositions']; ?>
                                 <?php } } ?>
                                 </td>
                                 <?php 
                                    $designation_name = $this->session->userdata('designation_name');
                                    if($designation_name=='Caller'){?>
                                 <td> <?php if(!empty($staff_list_val['replaced_by'])){
                                    echo $staff_list_val['first_name'].' '.$staff_list_val['last_name'].' is '. $staff_list_val['dispositions'].' for '.$staff_list_val['replaced_by']; 
                                     ?>
                                    <?php }else if(!empty($staff_list_val['caller_has_replaced'])){
                                       //echo "<pre>";print_r($staff_list_val);
                                       if($staff_list_val['vdid'] == 36 && $staff_list_val['activity_type'] == 3){
                                          echo $staff_list_val['first_name'].' '.$staff_list_val['last_name'].' is '.'Replacement for '.$staff_list_val['caller_has_replaced']; 
                                       }else if($staff_list_val['vdid'] == 36 && ($staff_list_val['activity_type'] == 2)){
                                          echo $staff_list_val['first_name'].' '.$staff_list_val['last_name'].' is '.'Added for '.$staff_list_val['caller_has_replaced']; 
                                       }else if($staff_list_val['vdid'] != 36 && ($staff_list_val['activity_type'] == 1)){
                                          echo $staff_list_val['first_name'].' '.$staff_list_val['last_name'].' is '.'Added for '.$staff_list_val['caller_has_replaced']; 
                                       }
                                       else if($staff_list_val['vdid'] != 36 && ($staff_list_val['activity_type'] == 2)){
                                          echo $staff_list_val['first_name'].' '.$staff_list_val['last_name'].' is '.'Added for '.$staff_list_val['caller_has_replaced']; 
                                       }
                                       else if($staff_list_val['vdid'] != 36 && ($staff_list_val['activity_type'] == 3)){
                                          echo $staff_list_val['first_name'].' '.$staff_list_val['last_name'].' is '.'Replacement for '.$staff_list_val['caller_has_replaced']; 
                                       }
                                        ?>
                                    <?php } ?>
                                 </td>
                             
                                 <?php } ?>

                                 <td>
                                       <?php 
                                       if($designation_name=='Caller'){ echo $staff_list_val['country_name'];  ?>
                                       <?php }elseif($designation_name=='Superadmin'){
                                          if($allInfo[0]['activity_type'] == "voice")
                                       {echo $staff_list_val['country_name'];   ?>
                                       <?php }
                                        } ?>
                                 </td>


                              </tr> 
                              <?php } ?>
                           </table>
                        </div>
                     </div>
                     <div class="tab-pane fade" id="project" role="tabpanel" aria-labelledby="project-tab">
                        <div class='table-responsive' style='height:230px;font-size:12px'>
                           <table class="table table-hover table-bordered table-sm p-0 m-0" width="100%" cellspacing="0" id="project_table">
                              <tr>
                                 <th>#</th>
                                 <th>Company Name</th>
                                 <th>No. of Staff</th>
                              </tr>
                              <?php 
                                 foreach($company_list as $allstaffinfo_key => $allstaffinfo_val) {?>
                              <tr class="" <?php if($allstaffinfo_val['received_company_name'] == $allInfo[0]['received_company_name']){ ?>style="background: yellow;" <?php } ?>>
                                 <td><a href="<?php echo base_url().'Projects/my_projects/'.base64_encode($allstaffinfo_val['project_id']).'/'.base64_encode($allstaffinfo_val['id']).'/'.base64_encode($allstaffinfo_val['received_company_name']);?>"><i class="fas fa-eye"></i></a></td>
                                 <td><?= $allstaffinfo_val['received_company_name']; ?></td>
                                 <td><?= $allstaffinfo_val['staffcount']; ?></td>
                              </tr>
                              <?php } ?>
                           </table>
                        </div>
                     </div>
                     <div class="tab-pane fade show" id="company1" role="tabpanel" aria-labelledby="company-tab1">
                        <div class='table-responsive' style='height:230px;font-size:12px'>
                           <table class="table table-hover table-bordered table-sm p-0 m-0" width="100%" cellspacing="0" id="company_table">
                              <tr>
                                 <th>Pending status</th>
                                 <th>Staff Name</th>
                                 <th>Company Name<span class="badge badge-pill badge-dark"></span></th>
                                 <?php $designation_name = $this->session->userdata('designation_name');  if($designation_name=='Researcher'){ ?>
                                 <th>web Staff Disposition</th>
                                 <?php }else if($designation_name=='Caller'){?>
                                 <th>voice Staff Disposition</th>
                                 <?php }else{
                                    if($allInfo[0]['activity_type'] == "web")
                                    {?>
                                 <th>web Staff Disposition</th>
                                 <?php }else if($allInfo[0]['activity_type'] == "voice"){?>
                                 <th>voice Staff Disposition</th>
                                 <?php }else{?>
                                <!--  <th>web Staff Disposition</th> -->
                                 <th>voice Staff Disposition</th>
                                 <?php }?>
                                 <?php } ?>
                                 <?php if($designation_name=='Researcher'){ ?>
                                 <th>Status</th>
                                 <?php }else if($designation_name=='Caller'){?>
                                 <th>Status</th>
                                 <?php }else{
                                    if($allInfo[0]['activity_type'] == "web")
                                    {?>
                                 <th>web staff status</th>
                                 <?php }else if($allInfo[0]['activity_type'] == "voice"){?>
                                 <th>Country</th>
                                 <?php }else{?>
                                 <th>web Status</th>
                                 <th>voice Status</th>
                                 <?php }?>
                                 <?php } ?>
                              </tr>
                              </tr>
                              <?php foreach($allstaffinfo as $allstaffinfo_key => $allstaffinfo_val) {?>
                              <tr  <?php if($allstaffinfo_val['id'] == $allInfo[0]['id']){ ?>style="background: yellow;" <?php } ?>>
                                 <td id="checkall_<?=$allstaffinfo_val['id'];?>">
                                    <?php if($allstaffinfo_val['validation_status'] == '0'){?>
                                    <a href="<?php echo base_url().'Projects/my_projects/'.base64_encode($allstaffinfo_val['project_id']).'/'.base64_encode($allstaffinfo_val['id']).'/'.base64_encode($allstaffinfo_val['comp_name']);?>">
                                       <span class="badge bg-danger " style="padding: 5px;border-radius: 20px;">
                                          <i class="glyphicon glyphicon-ok"><span class="fa fa-times"></span>
                                    </a>
                                    <?php }elseif($allstaffinfo_val['validation_status'] == '1'){?>
                                    <a href="<?php echo base_url().'Projects/my_projects/'.base64_encode($allstaffinfo_val['project_id']).'/'.base64_encode($allstaffinfo_val['id']).'/'.base64_encode($allstaffinfo_val['comp_name']);?>"><span class="badge bg-success " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"><span class="fa fa-check"></span></a><?php }else{?><a href="<?php echo base_url().'Projects/my_projects/'.base64_encode($allstaffinfo_val['project_id']).'/'.base64_encode($allstaffinfo_val['id']).'/'.base64_encode($allstaffinfo_val['comp_name']);?>"><span class="badge bg-danger " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"><span class="fa fa-times"></span></a><?php } ?>
                                 </td>
                                 <td><?= $allstaffinfo_val['first_name'].' '.$allstaffinfo_val['last_name']; ?></td>
                                 <td><?= $allstaffinfo_val['comp_name']; ?></td>
                                 <td><?php  if($designation_name=='Researcher'){ ?>
                                 <?= $allstaffinfo_val['dispositions']; ?>
                                 <?php }elseif($designation_name=='Caller'){?>
                                
                                 <?php }else{ if($allInfo[0]['activity_type'] == "web"){?>
                                 <?= $allstaffinfo_val['dispositions']; ?>
                                 <?php }else if($allInfo[0]['activity_type'] == "voice"){?>
                                 <?= $allstaffinfo_val['voice_dispositions']; ?>
                                 <?php }else{?>
                                 <?= $allstaffinfo_val['dispositions']; ?>
                                 <td><?= $allstaffinfo_val['voice_dispositions']; ?></td>
                                 <?php } } ?></td>
                                 <td>
                                 <?php
                                    if($designation_name=='Researcher')
                                    {
                                       if(strtolower($allstaffinfo_val['dispositions']) == 'verified' || strtolower($allstaffinfo_val['dispositions']) == 'required' || strtolower($allstaffinfo_val['dispositions']) == 'added' || strtolower($allstaffinfo_val['dispositions']) == 'acquired' || strtolower($allstaffinfo_val['dispositions']) == 'replaced'|| strtolower($allstaffinfo_val['dispositions']) == 'replacement') {?>
                                 <span class="badge bg-success " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span>
                                 <?php }elseif(strtolower($allstaffinfo_val['dispositions']) == 'staff left' || strtolower($allstaffinfo_val['dispositions']) == 'duplicate' || strtolower($allstaffinfo_val['dispositions']) == 'no answer'){?>
                                 <span class="badge bg-warning " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span>
                                 <?php }elseif(strtolower($allstaffinfo_val['dispositions']) == 'no result'){
                                    ?>
                                 <span class="badge bg-danger " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span>
                                 <?php }else{?><span class="badge bg-danger " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span><?php } }
                                    elseif($designation_name=='Caller'){ echo $allstaffinfo_val['country_name'];?>
                                    
                                    <?php
                                    }elseif($designation_name=='Superadmin'){
                                       if($allInfo[0]['activity_type'] == "web"){
                                          if(strtolower($allstaffinfo_val['dispositions']) == 'verified' || strtolower($allstaffinfo_val['dispositions']) == 'required' || strtolower($allstaffinfo_val['dispositions']) == 'added' || strtolower($allstaffinfo_val['dispositions']) == 'acquired' || strtolower($allstaffinfo_val['dispositions']) == 'replaced'|| strtolower($allstaffinfo_val['dispositions']) == 'replacement') {?>
                                 <span class="badge bg-success " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span>
                                 <?php }elseif(strtolower($allstaffinfo_val['dispositions']) == 'staff left' || strtolower($allstaffinfo_val['dispositions']) == 'duplicate' || strtolower($allstaffinfo_val['dispositions']) == 'no answer'){?>
                                 <span class="badge bg-warning " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span>
                                 <?php }elseif(strtolower($allstaffinfo_val['dispositions']) == 'no result'){
                                    ?>
                                 <span class="badge bg-danger" style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span>
                                 <?php }else{?><span class="badge bg-danger " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span><?php } 
                                    }
                                    elseif($allInfo[0]['activity_type'] == "voice")
                                    {
                                          echo $allstaffinfo_val['country_name'];    
                                    }
                                    else{ ?>
                                 <?php 
                                    if(strtolower($allstaffinfo_val['dispositions']) == 'verified' || strtolower($allstaffinfo_val['dispositions']) == 'required' || strtolower($allstaffinfo_val['dispositions']) == 'added' || strtolower($allstaffinfo_val['dispositions']) == 'acquired' || strtolower($allstaffinfo_val['dispositions']) == 'replaced'|| strtolower($allstaffinfo_val['dispositions']) == 'replacement') {?>
                                 <span class="badge bg-success " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span>
                                 <?php }elseif(strtolower($allstaffinfo_val['dispositions']) == 'staff left' || strtolower($allstaffinfo_val['dispositions']) == 'duplicate' || strtolower($allstaffinfo_val['dispositions']) == 'no answer'){?>
                                 <span class="badge bg-warning " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span>
                                 <?php }elseif(strtolower($allstaffinfo_val['dispositions']) == 'no result'){
                                    ?>
                                 <span class="badge bg-danger " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span>
                                 <?php }else{?><span class="badge bg-danger " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span><?php }
                                    ?>
                                 <td>
                                
                                    <?php 
                                       if(strtolower($allstaffinfo_val['voice_dispositions']) == 'verified' || strtolower($allstaffinfo_val['voice_dispositions']) == 'required' || strtolower($allstaffinfo_val['voice_dispositions']) == 'added' || strtolower($allstaffinfo_val['voice_dispositions']) == 'acquired'|| strtolower($allstaffinfo_val['voice_dispositions']) == 'replaced'){?>
                                    <span class="badge bg-success " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span></span>
                                    <?php }elseif(strtolower($allstaffinfo_val['voice_dispositions']) == 'staff left' || strtolower($allstaffinfo_val['voice_dispositions']) == 'duplicate' || strtolower($allstaffinfo_val['voice_dispositions']) == 'no answer'){?>
                                    <span class="badge bg-warning " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span></span>
                                    <?php }elseif(strtolower($allstaffinfo_val['voice_dispositions']) == 'no result' || strtolower($allstaffinfo_val['voice_dispositions']) == 'not verified'){
                                       ?>
                                    <span class="badge bg-danger " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span></span>
                                    <?php }else{?><span class="badge bg-danger " style="padding: 5px;border-radius: 20px;"><i class="glyphicon glyphicon-ok"></span><?php }
                                       ?>
                                 </td>
                                 <?php }
                                    }
                                    ?>
                                 </td>
                              </tr>
                              <?php } ?>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
               <div id="valid_error" style="margin-top: 20px;">
               <a href="#"  style="text-decoration: none;font-size: 15px !important;width: -webkit-fill-available;" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#caller_history" tabindex="49">
               <i class="fa fa-phone" aria-hidden="true"></i>  View Caller History</a> 
               </div>
               <div class="modal fade" id="caller_history" tabindex="-1" aria-labelledby="briefDetailsLabel" aria-hidden="true"  style="left: 220 !important;">
                  <div class="modal-dialog modal-lg">
                     <div class="modal-content" >
                        <div class="modal-header">
                           <h5 class="modal-title" id="briefDetailsLabel">Caller History</h5>
                        </div>
                        <div class="col researchcompanyremark" style="font-size: 15px !important;">
                           <div class="row">
                              <div class="col-md-12 px-3" style="margin-bottom: 5px;text-align:center;">
                                 <div class="bg-white" >
                                    <div class="row align-items-center justify-content-md-center" <?= $access8; ?>>
                                       <div class="col-auto">
                                          <label for="tel_number" class="col-form-label" style="font-size:15px !important;">From Date:</label>
                                          <input type="date" name="from_date" id="from_date"  class="form-control mr-2 datepicker" style="width:150px;" placeholder="DD/MM/YYYY">
                                       </div>
                                       <div class="col-auto">
                                          <label for="alternate_number" class="col-form-label"  style="font-size:15px !important;">To date:</label>
                                          <input type="date" class="form-control mr-2 datepicker" name="to_date" id="to_date" style="width:150px;" placeholder="DD/MM/YYYY">
                                       </div>
                                       <!-- <div class="col-auto">
                                          <button href="#" id="btn-search-by-date" type="button" style="text-decoration: none" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#caller_history" tabindex="49">
                                          Submit</button> 
                                          </div> -->
                                    </div>
                                    <hr>
                                    <div class="container-fluid" >
                                       <div style="overflow-y: auto;">
                                          <table id="doc_list_datatable" class="table table-striped table-bordered data-table"  cellspacing="0" width="100%">
                                             <thead>
                                                <tr>
                                               <!-- <th  style="font-size:15px !important;">ID</th> -->
                                                   <!--    <th  style="font-size:15px !important;">First Name</th>
                                                   <th  style="font-size:15px !important;">Last Name</th> 
                                                   <th class="ab" style="font-size:15px !important;">User</th>-->
                                                   <th class="ab" style="font-size:15px !important;">Voice Disposition</th>
                                                   <th  style="font-size:15px !important;">Caller Remark</th>
                                                   <th  style="font-size:15px !important;">Created At</th>

                                                </tr>
                                             </thead>
                                          </table>
                                       </div >
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button></div>
                     </div>
                  </div>
               </div>
            </div>
            
         </div>
       
         <div class="row g3 justify-content-md-center mt-4">
            <div class="col-auto">
               <button class="btn btn-warning btn-sm btnsize" title="Copy Compnay Information" type="button" id="copy_company" style="color: black;font-size: 12 !important;" tabindex="57"><i class="fa fa-copy"></i>&nbsp;&nbsp;Copy</button>
            </div>
            <div class="col-auto">
               <div class="input-group mb-3">
                  <a class="btn btn-outline-secondary btn-sm" href="<?php echo base_url().'Projects/my_projects/'.base64_encode($minmax['project_id']).'/'.base64_encode($minmax['myfirst']).'/'.base64_encode($minmax['received_company_name']);?>" title="First" id=""><<</a>
                  <a class="btn btn-outline-secondary btn-sm" href="<?php echo base_url().'Projects/my_projects/'.base64_encode($minmax['project_id']).'/'.base64_encode($minmax['prev']).'/'.base64_encode($minmax['received_company_name']);?>" title="Previous" id=""><</a>
                  <input type="text" class="form-control form-control-sm text-center" placeholder="Co. Id" size="6" value="<?= $minmax['current']; ?>" disabled>
                  <a class="btn btn-outline-secondary btn-sm" href="<?php echo base_url().'Projects/my_projects/'.base64_encode($minmax['project_id']).'/'.base64_encode($minmax['next']).'/'.base64_encode($minmax['received_company_name']);?>" title="Next" id="">></a>
                  <a class="btn btn-outline-secondary btn-sm" href="<?php echo base_url().'Projects/my_projects/'.base64_encode($minmax['project_id']).'/'.base64_encode($minmax['mylast']).'/'.base64_encode($minmax['received_company_name']);?>" title="Last" id="">>></a>
               </div>
            </div>
            <div class="col-auto">
               <button class="btn btn-warning btn-sm btnsize" title="Paste Copied Company Information" type="button" id="paste_company" style="color:black;font-size: 12 !important;" tabindex="59"><i class="fa fa-paste"></i>&nbsp;&nbsp;Paste</button>
            </div>
            <div class="col-auto">
               <button class="btn btn-success btn-sm btnsize" title="Save Records" type="submit" id="update_company" style="color: #edffed;font-size: 12 !important;" tabindex="58"><i class="fa fa-rotate-right"></i>&nbsp;&nbsp;Update</button>
            </div>
         </div>
         <div class="row row1">
            <div class="col">
               
            </div>
            <div class="col">
               <div class="alert alert-warning text-center p-1">
                  <?php if($userinfo == 6){ ?>
                  <div class="row g-3 align-items-center justify-content-md-center" >
                     <?php 
                        if(strtolower($allInfo[0]['task_type']) == "named"){
                        
                         if(!empty($ButtonInfo) && $ButtonInfo['button_type']=='NS'  && $ButtonInfo['count']==1){ ?>
                     <div class="col-auto" style="display:none"> <a class="btn btn-primary btn-sm" style="display:none"  id="added" disabled >Add</a>  </div>
                     <?php }else{ ?>
                     <div class="col-auto"><a class="btn btn-primary btn-sm"  id="added" disabled>Add</a> </div>
                     <?php } ?>
                     <?php 
                        if(!empty($ButtonInfo) && $ButtonInfo['button_type']=='SLA'  && $ButtonInfo['count']==2){ ?>
                     <div class="col-auto" style="display:none"><a class="btn btn-primary btn-sm"  id="replacement">Replacement</a>
                        <a class="btn btn-primary btn-sm"  id="staff_left_added">Add</a>
                     </div>
                     <?php }
                        else if(!empty($ButtonInfo) && $ButtonInfo['button_type']=='SLAA'  && $ButtonInfo['count']==1){ ?>
                     <div class="col-auto" style="display:none"><a class="btn btn-primary btn-sm"  id="staff_left_added">Add</a></div>
                     <div class="col-auto"><a class="btn btn-primary btn-sm"  id="replacement">Replacement</a></div>
                     <?php }else if(!empty($ButtonInfo) && $ButtonInfo['button_type']=='SLAA'  && $ButtonInfo['count']==0){ ?>
                     <div class="col-auto" style=""><a class="btn btn-primary btn-sm"  id="staff_left_added">ADD</a></div>
                     <?php }else if(!empty($ButtonInfo) && $ButtonInfo['button_type']=='SLREP'  && $ButtonInfo['count']==1){ ?>
                     <div class="col-auto" style="display:none"><a class="btn btn-primary btn-sm"  id="replacement">Replacement</a></div>
                     <div class="col-auto" style=""><a class="btn btn-primary btn-sm"  id="staff_left_added">Add</a></div>
                     <?php }else if(!empty($ButtonInfo) && $ButtonInfo['button_type']=='SLREP'  && $ButtonInfo['count']==0){ ?>
                     <div class="col-auto" style=""><a class="btn btn-primary btn-sm"  id="replacement">Replacement</a></div>
                     <?php }
                        else{ ?>
                     <div class="col-auto" ><a class="btn btn-primary btn-sm"  id="replacement">Replacement</a>
                        <a class="btn btn-primary btn-sm"  id="staff_left_added">Add</a>
                     </div>
                     <?php } }
                        else if(strtolower($allInfo[0]['task_type']) == "name with unnamed"){?>
                     <?php if(!empty($ButtonInfo) && $ButtonInfo['button_type']=='NS'  && $ButtonInfo['count']==0){ ?>
                     <div class="col-auto" style="display:none"> <a class="btn btn-primary btn-sm" id="acquired" style="display:none" >Acquire</a></div>
                     <?php }else{ ?>
                     <div class="col-auto"> <a class="btn btn-primary btn-sm" id="acquired">Acquire</a></div>
                     <?php } ?>
                     <?php if(!empty($ButtonInfo) && $ButtonInfo['button_type']=='NS'  && $ButtonInfo['count']==1){ ?>
                     <div class="col-auto" style="display:none"> <a class="btn btn-primary btn-sm" style="display:none"  id="added" disabled >Add</a>  </div>
                     <?php }else{ ?> 
                     <div class="col-auto"><a class="btn btn-primary btn-sm"  id="added" disabled>Add</a> </div>
                     <?php } ?>
                     <?php 
                        if(!empty($ButtonInfo) && $ButtonInfo['button_type']=='SLA'  && $ButtonInfo['count']==2){ ?>
                     <div class="col-auto" style="display:none"><a class="btn btn-primary btn-sm"  id="replacement">Replacement</a>
                        <a class="btn btn-primary btn-sm"  id="staff_left_added">Add</a>
                     </div>
                     <?php } else if(!empty($ButtonInfo) && $ButtonInfo['button_type']=='SLAA'  && $ButtonInfo['count']==1){ ?>
                     <div class="col-auto" style="display:none"><a class="btn btn-primary btn-sm"  id="staff_left_added">Add</a></div>
                     <div class="col-auto"><a class="btn btn-primary btn-sm"  id="replacement">Replacement</a></div>
                     <?php }else if(!empty($ButtonInfo) && $ButtonInfo['button_type']=='SLAA'  && $ButtonInfo['count']==0){ ?>
                     <div class="col-auto" style=""><a class="btn btn-primary btn-sm"  id="staff_left_added">ADD</a></div>
                     <?php }else if(!empty($ButtonInfo) && $ButtonInfo['button_type']=='SLREP'  && $ButtonInfo['count']==1){ ?>
                     <div class="col-auto" style="display:none"><a class="btn btn-primary btn-sm"  id="replacement">Replacement</a></div>
                     <div class="col-auto" style=""><a class="btn btn-primary btn-sm"  id="staff_left_added">Add</a></div>
                     <?php }else if(!empty($ButtonInfo) && $ButtonInfo['button_type']=='SLREP'  && $ButtonInfo['count']==0){ ?>
                     <div class="col-auto" style=""><a class="btn btn-primary btn-sm"  id="replacement">Replacement</a></div>
                     <?php }
                        else{ ?>
                     <div class="col-auto" ><a class="btn btn-primary btn-sm"  id="replacement">Replacement</a>
                        <a class="btn btn-primary btn-sm"  id="staff_left_added">Add</a>
                     </div>
                     <?php } } ?>
                  </div>
                  <?php } ?>
                  <?php if($userinfo == 3 || $userinfo == 8){?>
                  <div class="row g-3 align-items-center justify-content-md-center" >
                     <?php 
                      if(strtolower($allInfo[0]['task_type']) == "name with unnamed"){ ?>
                     <?php if(!empty($ButtonInfo) && $ButtonInfo['button_type']=='NS'  && $ButtonInfo['count']==0){ ?>
                     <div class="col-auto" style="display:none"> <a class="btn btn-primary btn-sm" id="acquired" style="display:none" >Acquire</a></div>
                     <?php }else{ ?>
                     <div class="col-auto" > <a class="btn btn-primary btn-sm" id="acquired">Acquire</a></div>
                     <?php } 
                        if(!empty($ButtonInfo) && $ButtonInfo['button_type']=='NS'  && $ButtonInfo['count']==1){ ?>
                     <div class="col-auto" style="display:none"> <a class="btn btn-primary btn-sm" style="display:none"  id="calladded" disabled ><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Add</a>  </div>
                     <?php }else{ ?>
                     <div class="col-auto"><a class="btn btn-primary btn-sm"  id="calladded" disabled><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Add</a> </div>
                     <?php } ?>
                     <?php 
                        if(!empty($ButtonInfo) && $ButtonInfo['button_type']=='SLA'  && $ButtonInfo['count']==2){ ?>
                     <div class="col-auto" style="display:none"><a class="btn btn-primary btn-sm"  id="callreplacement"><i class="fa fa-exchange" aria-hidden="true"></i>&nbsp;&nbsp;Replacement</a>
                        <a class="btn btn-primary btn-sm"  id="staff_left_added"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Add</a>
                     </div>
                     <?php } else if(!empty($ButtonInfo) && $ButtonInfo['button_type']=='SLAA'  && $ButtonInfo['count']==1){ ?>
                     <div class="col-auto" style="display:none"><a class="btn btn-primary btn-sm"  id="call_staff_left_added"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Add</a></div>
                     <div class="col-auto"><a class="btn btn-primary btn-sm"  id="callreplacement"><i class="fa fa-exchange" aria-hidden="true"></i>&nbsp;&nbsp;Replacement</a></div>
                     <?php }else if(!empty($ButtonInfo) && $ButtonInfo['button_type']=='SLAA'  && $ButtonInfo['count']==0){ ?>
                     <div class="col-auto" style=""><a class="btn btn-primary btn-sm"  id="call_staff_left_added"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;ADD</a></div>
                     <?php }else if(!empty($ButtonInfo) && $ButtonInfo['button_type']=='SLREP'  && $ButtonInfo['count']==1){ ?>
                     <div class="col-auto" style="display:none"><a class="btn btn-primary btn-sm"  id="callreplacement"><i class="fa fa-exchange" aria-hidden="true"></i>&nbsp;&nbsp;Replacement</a></div>
                     <div class="col-auto" style=""><a class="btn btn-primary btn-sm"  id="call_staff_left_added"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Add</a></div>
                     <?php }else if(!empty($ButtonInfo) && $ButtonInfo['button_type']=='SLREP'  && $ButtonInfo['count']==0){ ?>
                     <div class="col-auto" style=""><a class="btn btn-primary btn-sm"  id="callreplacement"><i class="fa fa-exchange" aria-hidden="true"></i>&nbsp;&nbsp;Replacement</a></div>
                     <?php }
                        else{ ?>
                     <div class="col-auto" ><a class="btn btn-primary btn-sm"  id="callreplacement"><i class="fa fa-exchange" aria-hidden="true"></i>&nbsp;&nbsp;Replacement</a>
                        <a class="btn btn-primary btn-sm"  id="call_staff_left_added"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Add</a>
                     </div>
                     <?php }
                        } ?>
                  </div>
                  <?php } ?>
               </div>
               <!-- check input access for web_staff_disposition -->
               <?php 
                  $div_count=div_access($project_info,array('web_staff_disposition'));
                  $access21 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access21; ?>>
                  <?php  if(in_array('web_staff_disposition',$project_info)){ 
                     if($userinfo == 3){?>
                  <div class="col">
                     <label for="web_staff_disposition" class="col-form-label">Web Staff Disposition:</label>
                  </div>
                  <div class="col">
                     <select class='form-control form-control-sm' id="web_staff_disposition"  name='web_staff_disposition' tabindex="44" disabled>
                        <?php 
                           if(empty($allInfo[0]['web_staff_disposition'])){?>
                        <option value='' selected disabled>select Web Disposition</option>
                        <?php }else{ ?>
                        <option value='' disabled hidden>select Web Disposition</option>
                        <?php }
                           foreach ($webDispos as $key => $val) { ?>
                        <option value='<?= $val['id']; ?>' <?php if($allInfo[0]['web_staff_disposition']==$val['id']){?>selected<?php } ?>><?= $val['dispositions']; ?></option>
                        <?php }
                           ?>
                     </select>
                  </div>
                  <?php }else{?>
                  <div class="col">
                     <label for="web_staff_disposition" class="col-form-label">Web Staff Disposition:</label>
                  </div>
                  <div class="col">
                     <?php
                        if($ButtonInfo['count']>0)
                        {
                          $sty="disabled";
                        }else{
                           $sty=""; 
                        }
                        ?>
                     <select class='form-control form-control-sm' id="web_staff_disposition"  name='web_staff_disposition' tabindex="44" <?=  $sty ; ?>>
                        <?php 
                           if(empty($allInfo[0]['web_staff_disposition'])){?>
                        <option value='' selected disabled>select Web Disposition</option>
                        <?php }else{ ?>
                        <option value='' disabled hidden>select Web Disposition</option>
                        <?php }
                           foreach ($webDispos as $key => $val) { ?>
                        <option value='<?= $val['id']; ?>' <?php if($allInfo[0]['web_staff_disposition']==$val['id']){?>selected<?php } ?>><?= $val['dispositions']; ?></option>
                        <?php }
                           ?>
                     </select>
                  </div>
                  <?php } }?>
               </div>
              
              
               <?php 
                  $div_count=div_access($project_info,array('staff_linkedin_count'));
                  $access23 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access23; ?>>
                  <?php if(in_array('staff_linkedin_count',$project_info)){ ?>
                  <div class="col">
                     <label for="staff_linkedin_count" class="col-form-label">Linkedin Connections Count:</label>
                  </div>
                  <div class="col">
                     <input type="number" value="<?=  (!empty($allInfo[0]['staff_linkedin_con'])) ?  $allInfo[0]['staff_linkedin_con'] : ''  ?>" title="" id="staff_linkedin_count"  name='staff_linkedin_count' class="form-control form-control-sm" tabindex="46">
                  </div>
                  <?php } ?>
               </div>
               <?php 
                  $div_count=div_access($project_info,array('work_experience'));
                  $access23 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access23; ?>>
                  <?php if(in_array('work_experience',$project_info)){ ?>
                  <div class="col">
                     <label for="work_experience" class="col-form-label">Work Experience:</label>
                  </div>
                  <div class="col">
                     <input type="number" value="<?=  (!empty($allInfo[0]['work_experience'])) ?  $allInfo[0]['work_experience'] : ''  ?>" title="" id="work_experience"  name='work_experience' class="form-control form-control-sm" tabindex="46">
                  </div>
                  <?php } ?>
               </div>
               
            
               <!-- check input access for Rearcher_remark-->
               <?php 
                  $div_count=div_access($project_info,array('research_remark'));
                  $access25 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access25; ?>>
                  <div class="col">
                     <label for="research_remark" class="col-form-label">Researcher Remark:</label>
                  </div>
                  <div class="col">
                     <a href="#"  style="text-decoration: none" data-bs-toggle="modal" data-bs-target="#researcher_remarkss" tabindex="48">
                     <input type="text" value="View Researcher Remark" title="" id="researcher_remarks_input"  name='' class="form-control form-control-sm" tabindex="48" readonly=""></a>
                  </div>
               </div>
               <!-- Started Popup for the Researcher Remarks -->
               <div class="modal fade" id="researcher_remarkss" tabindex="-1" aria-labelledby="briefDetailsLabel" aria-hidden="true">
                  <div class="modal-dialog">
                     <div class="modal-content" >
                        <div class="modal-header">
                           <h5 class="modal-title" id="briefDetailsLabel">View Researcher Remark:</h5>
                        </div>
                        <div class="col researchcompanyremark">
                           <?php if(in_array('research_remark',$project_info)){ 
                              if($userinfo == 3){
                              ?>
                           <div class="col researchremark">
                              <select  class="form-control form-control-sm research_remark" id="research_remark[]" multiple name="research_remark[]" tabindex="47" disabled style="overflow: hidden;height: 210px;background-color: #ffffff;">
                                 <?php 
                                    $remark=explode(',', $allInfo[0]['research_remark']);
                                    foreach($researcher_remark as $user_key => $val)
                                    {  
                                       $id = $val['id'];
                                       $style="style='background-color:white;color:blue;'"; 
                                       if(in_array($id,$remark)){
                                       ?>
                                 <option <?= $style;  ?> value='<?= $val['id']; ?>' <?php if(in_array($id,$remark)){echo "selected";}  ?>><?= $val['researcher_remark']; ?></option>
                                 <?php } }
                                    ?>
                              </select>
                           </div>
                           <?php }else{ ?>
                           <div class="col researchremark">
                              <select  style="overflow: hidden;height: 210px;" class="form-control form-control-sm research_remark" id="research_remark[]" multiple name="research_remark[]" tabindex="47" >
                                 <?php 
                                    $remark=explode(',', $allInfo[0]['research_remark']);
                                    foreach($researcher_remark as $user_key => $val)
                                    {  
                                       $id = $val['id'];
                                       ?>
                                 <option value='<?= $val['id']; ?>' <?php if(in_array($id,$remark)){echo "selected";} ?>><?= $val['researcher_remark']; ?></option>
                                 <?php }
                                    ?>
                              </select>
                           </div>
                           <?php } }?>
                        </div>
                        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button></div>
                     </div>
                  </div>
               </div>
               <!-- Ended Popup for the Researcher Remarks -->
               <!-- check input access for Rearcher_remark-->
               <?php 
                  $div_count=div_access($project_info,array('voice_remark'));
                  $div_count =0;
                  $access25 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  
                  if($userinfo == 3 || $userinfo == 8)
                  {?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access25; ?>>
                  <?php if(in_array('voice_remark',$project_info)){ ?>
                  <div class="col">
                     <label for="voice_remark" class="col-form-label">Caller Remark:</label>
                  </div>
                  <div class="col">
                     <a href="#"  style="text-decoration: none" data-bs-toggle="modal" data-bs-target="#caller_multi_remarks" tabindex="49">
                     <input type="text" value="Select Caller Remark" title="" id=""  name='' class="form-control form-control-sm" tabindex="49" readonly="" style="background-color:white;"></a>
                  </div>
                  <?php } ?>
               </div>
               
               <?php }?>
               <!-- Popup Started for the Caller Remarks -->
               <div class="modal fade" id="caller_multi_remarks" tabindex="-1" aria-labelledby="briefDetailsLabel" aria-hidden="true">
                  <div class="modal-dialog">
                     <div class="modal-content" >
                        <div class="modal-header">
                           <h5 class="modal-title" id="briefDetailsLabel">Caller Remark</h5>
                        </div>
                        <div class="col researchcompanyremark">
                           <select  class="form-control form-control-sm voice_remark" id="voice_remark[]" multiple name="voice_remark[]" tabindex="30" style="overflow: scroll;height: 350px;" >
                              <?php 
                                 foreach($caller_remark as $user_key => $val)
                                 {?>
                              <option value='<?= $val['id']; ?>' <?php if(in_array($val['id'],explode(',',$allInfo[0]['voice_remark']))){?>selected<?php } ?>><?= $val['caller_remark']; ?></option>
                              <?php }
                                 ?>
                           </select>
                        </div>
                        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button></div>
                     </div>
                  </div>
               </div>
               <!-- Popup Enede for the Caller Remarks -->
               <!-- check input access for ca1,ca2,ca3,ca4,ca5 -->
               
               <?php 
                  $div_count=div_access($project_info,array('ca1','ca2','ca3','ca4','ca5'));
                  $access2 = ($div_count < 1) ? "style='display:none;'" :  '' ; 
                  ?>
               <div class="row g-3 align-items-center justify-content-md-center" <?= $access2; ?>>
                  <?php if(in_array('sa1',$project_info)){ ?>
                  <div class="col">
                     <label for="sa1" class="col-form-label">SA1:</label>
                     <input type="text" value="<?=  (!empty($allInfo[0]['sa1'])) ?  $allInfo[0]['sa1'] : ''  ?>" title="" id="sa1"  name='sa1' class="form-control form-control-sm" tabindex="52">
                  </div>
                  <?php } ?>
                  <?php if(in_array('sa2',$project_info)){ ?>
                  <div class="col">
                     <label for="sa2" class="col-form-label">SA2:</label>
                     <input type="text" value="<?=  (!empty($allInfo[0]['sa2'])) ?  $allInfo[0]['sa2'] : ''  ?>" title="" id="sa2"  name='sa2' class="form-control form-control-sm" tabindex="53">
                  </div>
                  <?php } ?>
                  <?php if(in_array('sa3',$project_info)){ ?>
                  <div class="col">
                     <label for="sa3" class="col-form-label">SA3:</label>
                     <input type="text" value="<?=  (!empty($allInfo[0]['sa3'])) ?  $allInfo[0]['sa3'] : ''  ?>" title="" id="sa3"  name='sa3' class="form-control form-control-sm" tabindex="54">
                  </div>
                  <?php } ?>
                  <?php if(in_array('sa4',$project_info)){ ?>
                  <div class="col">
                     <label for="sa4" class="col-form-label">SA4:</label>
                     <input type="text" value="<?=  (!empty($allInfo[0]['sa4'])) ?  $allInfo[0]['sa4'] : ''  ?>" title="" id="sa4"  name='sa4' class="form-control form-control-sm" tabindex="55">
                  </div>
                  <?php } ?>
                  <?php if(in_array('sa5',$project_info)){ ?>
                  <div class="col">
                     <label for="sa5" class="col-form-label">SA5:</label>
                     <input type="text" value="<?=  (!empty($allInfo[0]['sa5'])) ?  $allInfo[0]['sa5'] : ''  ?>" title="" id="sa5"  name='sa5' class="form-control form-control-sm" tabindex="56">
                  </div>
                  <?php } ?>
               </div>
               
               <br><br><br>
            </div>
            <div class="col">
               
            </div>
         </div>
         <?php echo form_close() ?>
      </main>
      <script src="<?php echo base_url();?>public/js/bootstrap.bundle.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
      <script src="<?= base_url();?>assets/js/update_company_details.js"></script>
      <script src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script> 
      <script src="<?= base_url();?>assets/js/view_js/projects/zoom.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script> 
      <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.bootstrap4.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
      
      <script>
         $(document).on('select2:select','#voice_staff_disposition', function(e) {
         var data = e.params.data;
         var voice_staff_disposition = data.id;
         var arrays=['16','17','56','43','46','47'];

         if (jQuery.inArray(voice_staff_disposition, arrays) >= 0) {
           
            $('#followdatetime').css('display','flex');
         } else {
           $('#followdatetime').val(""); 
           $('#followdatetime').css('display','none');
         }

         });
        $('#datetimepicker1').datetimepicker({
             format: 'YYYY-MM-DD HH:mm:ss',
             icons: {
                time: 'far fa-clock',
                date: 'far fa-calendar'
            }
        });
       
         var bases_url="<?=base_url() ?>";
         var session_user_id=$('#session_user_id').val();
         var voice_staff_disposition1=$("#vsd").val();
         
         var web_staff_disposition1=$("#web_staff_disposition").find(":selected").val();
         var replacedcount=$("#replacedcount").val();
         var task_type=$("#task_type").val();
         var first_name=$("#first_name").val();
         var last_name=$("#last_name").val();
         var fullname=first_name+last_name;
         
         var arrays=['16','17','56','43','46','47'];

         if (jQuery.inArray(voice_staff_disposition1, arrays) >= 0) {
           
           $('#followdatetime').css('display','flex');
         } else {
            $('#followdatetime').val(""); 
            $('#followdatetime').css('display','none');
         }
         if(voice_staff_disposition1 == '36' && task_type == "name with unnamed")
         {
         $('#calladded').css("display","none");
         $('#callreplacement').css("display","inline-block");
         $('#call_staff_left_added').css("display","inline-block");
         $('#acquired').css("display","none");
         }else{
         $('#calladded').css("display","inline-block");
         $('#callreplacement').css("display","none");
         $('#call_staff_left_added').css("display","none");
         $('#acquired').css("display","none");
         }
         
         var simpletable = $('#doc_list_datatable').DataTable({
            bAutoWidth: false, 
            aoColumns : [
               { sWidth: '5%' },
               { sWidth: '15%' },
               { sWidth: '5%' },
            ],
            "responsive": true,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'language': {
               'processing': '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>',
               searchPlaceholder: ""
               
            },
            'ajax': {
               'url': "<?= base_url() ?>Projects/getcallerrecord",
               'method': "POST",
               'dataType':'json',
               "data": function (data) {
                  data.from_date = $('#from_date').val();
                  data.to_date = $('#to_date').val();
                  data.first_name = $('#first_name').val();
                  data.last_name = $('#last_name').val();
                  data.staff_id = $('#staff_id').val();
               }
            }, 
            createdRow: function (row, data, index) {
               $('td', row).eq(2).addClass('text-capitalize');
            },
         });
         
         $("#from_date").change(function(){
            simpletable.ajax.reload(null, false); //just reload table
         });
         
         $("#to_date").change(function(){
            simpletable.ajax.reload(null, false); //just reload table
         });
         
    
         
         
         function openUrls(urls){
         var target = openAddressUrl(urls);
         window.open(target, '_blank');
         }
         function openAddressUrl(source){
         if(source!=""){
         const first4 = source.slice(0, 4);
         if(first4=='http'){
         var url = source;
         }else{
         var url = 'http://'+source;
         }
         }else{
         var url = source;
         }
         return url;
         }
         
         document.addEventListener('DOMContentLoaded', function() {
         var link = document.getElementById('link');
         
         link.addEventListener('click', function() {
              var web_urls = $('#website_url').val();         
              let result = web_urls.substr(0, 4);
              const first8 = web_urls.slice(0, 8);
              const first7 = web_urls.slice(0, 7);
              
              if(first8=='https://' || first7=='http://'){
                  var web_url = web_urls;
              }else if(web_urls!=''){
                  var web_url = 'http://'+web_urls;
              }else{
                  var web_url = '';
              }
              
            if(web_url!=''){
               var domain = (new URL(web_url));
               var web_url=domain.hostname.replace("www.",''); 
            }
            
            var country=$('#country').val();
            var company_countrys = $("#company_name").val()+', '+country;
            var company_name=$("#company_name").val();
            var names=$("#first_name").val()+' '+$("#last_name").val();
         
            var one = company_name !='' && names !='' ?  company_name+', '+names : '';
         
            var company_country = company_countrys!='' && country !='' ?  company_countrys : "";
            var email = web_url!='' ? '"'+'* * * * * @'+web_url+'"'+' '+"email" : "";
            var email1 = web_url!='' ? 'Email "'+'* * * * * @'+web_url+'"'+' '+$("#first_name").val()+' '+$("#last_name").val() : "";
            var data = [one,company_country,email,email1];
            for (var i = 0; i < data.length; i++) {
             
               if(data[i]!='' && data[i]!='http://www.google.com'){
                  var two = 'https://www.google.com/search?q=' + encodeURIComponent(data[i]);
                  var redirectWindow = window.open(two, '_blank'); 
               }
                
            }
         });
         });
         
         
        $(document).ready(function() {
      function myNotification(title, message, link) {
      
       if (Notification.permission !== "granted") {
         Notification.requestPermission();
       } else {
         var notification = new Notification(title, {
           icon: 'https://bdsserv.com/assets/icon/fv.png',
           body: message
         });

         notification.onclick = function() {
           window.open(link);
         };
       }
     }
       setInterval(checkNotification, 1000);

       function checkNotification() {
         $.ajax({
           type: "POST",
           url: '<?php echo base_url(); ?>Projects/notify',
           dataType: 'json',
           data: {temp: ''},
           success: function(response) {
             if (response.show == true){
              // console.log('raj');
                myNotification(response.title, response.notification, response.link);
             }else{
                //myNotification('hello', 'test', 'oka');
             }
           },
           error: function(response) {
           
           }
         });
       }
            
         $("#country").autocomplete({
         
         source: function( request, response ) {
         $.ajax({
         url: '<?php echo base_url(); ?>Projects/getcountry',
         type: 'post',
         dataType: "json",
         data: {
         search: request.term
         },
         success: function( data ) {
         response( data );
         
         }
         });
         }, 
         select: function( event , ui ) {
         console.log(ui);
         if(ui.item.postal_code == 'Yes')
         {
         $("#postal_code").prop("disabled",false);
         $("#postal_codes").val("Yes");
         }
         else{
         $("#postal_code").prop("disabled",true); 
         $("#postal_code").val('');
         $("#postal_codes").val("No");
         }
         $("#country").val(ui.item.label);
         $("#country_code").val(ui.item.phonecode);
         $("#region_name").val(ui.item.region);
         }
         });
         
         
         $("#industry").autocomplete({
         
         source: function( request, response ) {
         $.ajax({
         url: '<?php echo base_url(); ?>Projects/getindustry',
         type: 'post',
         dataType: "json",
         data: {
         search: request.term
         },
         success: function( data ) {
         response( data );
         
         }
         });
         }, 
         select: function( event , ui ) {
         $("#industry").val(ui.item.value);
         }
         });
         
         $("#company_disposition").autocomplete({
         
         source: function( request, response ) {
         $.ajax({
         url: '<?php echo base_url(); ?>Projects/getcompany_disposition',
         type: 'post',
         dataType: "json",
         data: {
         search: request.term
         },
         success: function( data ) {
         response( data );
         
         }
         });
         }, 
         select: function( event , ui ) {
         $("#company_disposition").val(ui.item.value);
         }
         });
         
         $("#company_web_dispositon").autocomplete({
         
         source: function( request, response ) {
         $.ajax({
         url: '<?php echo base_url(); ?>Projects/getcompany_web_dispositon',
         type: 'post',
         dataType: "json",
         data: {
         search: request.term
         },
         success: function( data ) {
         response( data );
         
         }
         });
         }, 
         select: function( event , ui ) {
         $("#company_web_dispositon").val(ui.item.value);
         }
         });
         
         $("#company_voice_disposition").autocomplete({
         
         source: function( request, response ) {
         $.ajax({
         url: '<?php echo base_url(); ?>Projects/getcompany_voice_disposition',
         type: 'post',
         dataType: "json",
         data: {
         search: request.term
         },
         success: function( data ) {
         response( data );
         
         }
         });
         }, 
         select: function( event , ui ) {
         $("#company_voice_disposition").val(ui.item.value);
         }
         });
         
         $("#web_staff_disposition").autocomplete({
         
         source: function( request, response ) {
         $.ajax({
         url: '<?php echo base_url(); ?>Projects/getweb_staff_disposition',
         type: 'post',
         dataType: "json",
         data: {
         search: request.term
         },
         success: function( data ) {
         response( data );
         
         }
         });
         }, 
         select: function( event , ui ) {
         $("#web_staff_disposition").val(ui.item.value);
         }
         });
         
         $("#voice_staff_disposition").autocomplete({
         
         source: function( request, response ) {
         $.ajax({
         url: '<?php echo base_url(); ?>Projects/getvoice_staff_disposition',
         type: 'post',
         dataType: "json",
         data: {
         search: request.term
         },
         success: function( data ) {
         response( data );
         
         }
         });
         }, 
         select: function( event , ui ) {
         $("#voice_staff_disposition").val(ui.item.value);
         }
         });
         $('#voice_disposition').change(function(){
             var disposition = $(this).val();
             if(disposition == 'Incomplete') {$('.incomplete_disposition').fadeIn(1000);}
             else {$('.incomplete_disposition').fadeOut(1000);}
         });
         
         $('ul.revenue_currency li').click(function(){
            $('#revenue_currency').text($(this).text());
         });
         
         $(".dropdown-menu li a").click(function(){
         var selText = $(this).text();
         $('#revenue_cur').val(selText);
         });
         if(localStorage.getItem('company_details') != '')
         {
            $('#paste_company').css("display","block");
         }
         
         });
         
         $('#copy_company').click(function(){
         
            var items = [{
               company_name:$('#company_name').val(),
               address_1:$('#address_1').val(),
               address_2:$('#address_2').val(),
               address_3:$('#address_3').val(),
               city_name:$('#city_name').val(),
               postal_code:$('#postal_code').val(),
               state_name:$('#state_name').val(),         
               country:$("#country").val(), 
               region_name:$('#region_name').val(),      
               address_source_url:$('#address_source_url').val(), 
               ca1:$('#ca1').val(), 
               ca2:$('#ca2').val(), 
               ca3:$('#ca3').val(), 
               ca4:$('#ca4').val(), 
               ca5:$('#ca5').val(), 
               company_disposition:$("#company_disposition option:selected").val(), 
               company_web_dispositon:$("#company_web_dispositon option:selected").val(), 
               company_voice_disposition:$("#company_voice_disposition option:selected").val(),
               company_genaral_notes:$('#company_genaral_notes').val(),
               company_remark:$('#company_remark').val(),
               country_code:$('#country_code').val(),
               tel_number:$('#tel_number').val(),
               alternate_number:$('#alternate_number').val(),
               industry:$("#industry").val(), 
               revenue:$('#revenue').val(),
               revenue_cur:$("#revenue_cur option:selected").val(), 
               no_of_emp:$("#no_of_emp").val(), 
               website_url:$("#website_url").val(),
               researcher_company_remark:$(".researcher_company_remark").val(),
               caller_company_remark :$(".caller_company_remark").val(),
               researcher_company_note :$("#researcher_company_note").val(),
               caller_company_note :$("#caller_company_note").val(),
               generic_mail :$("#generic_mail").val(),
               }];
           console.log(items);
            localStorage.setItem('company_details',JSON.stringify(items));
            swal({
                     text: 'Company Details Copied Successfully',
                     dangerMode: true,
                     timer: 1500
                  });
         });
         
         $('#paste_company').click(function(){
            var getitems=JSON.parse(localStorage.getItem('company_details'));
             var research_remark=getitems[0].researcher_company_remark;
            $('.researcher_company_remark').val(research_remark).change();
            var voice_remark=getitems[0].caller_company_remark;
            $('.caller_company_remark').val(voice_remark).change();
            $('#researcher_company_note').val(getitems[0].researcher_company_note);
            $('#caller_company_note').val(getitems[0].caller_company_note);
            $('#company_name').val(getitems[0].company_name);
            $('#address_1').val(getitems[0].address_1);
            $('#address_2').val(getitems[0].address_2);
            $('#address_3').val(getitems[0].address_3);
            $('#city_name').val(getitems[0].city_name);
            $('#postal_code').val(getitems[0].postal_code);
            $('#state_name').val(getitems[0].state_name);
            $('#country').val(getitems[0].country)
            $('#industry').val(getitems[0].industry)
            $('#region_name').val(getitems[0].region_name);
            $('#address_source_url').val(getitems[0].address_source_url);
            $('#ca1').val(getitems[0].ca1);
            $('#ca2').val(getitems[0].ca2);
            $('#ca3').val(getitems[0].ca3);
            $('#ca4').val(getitems[0].ca4);
            $('#ca5').val(getitems[0].ca5);
            $('#company_disposition').val(getitems[0].company_disposition)
            $('#company_web_dispositon').val(getitems[0].company_web_dispositon)
            $('#company_voice_disposition').val(getitems[0].company_voice_disposition)
            $('#company_genaral_notes').val(getitems[0].company_genaral_notes);
            $('#company_remark').val(getitems[0].company_remark);
            $('#country_code').val(getitems[0].country_code);
            $('#tel_number').val(getitems[0].tel_number);
            $('#alternate_number').val(getitems[0].alternate_number);
            
            $('#revenue').val(getitems[0].revenue);
            $('#revenue_cur').val(getitems[0].revenue_cur)
            $('#no_of_emp').val(getitems[0].no_of_emp)
            $('#website_url').val(getitems[0].website_url);
            $('#generic_mail').val(getitems[0].generic_mail);
         });
         
         function getcountrycode(country) {
            $.ajax({
               url: '<?php echo base_url(); ?>Projects/getcountrycode',
               type: 'post',
               dataType: "json",
               data: {
                  country: country
               },
               success: function (data) {
                  $("#country_code").val(data.phonecode);
                  $("#region_name").val(data.region);
               }
            });
         }
         
         
         
         document.addEventListener('keydown', e => {
         if (e.ctrlKey && e.key === 's') {
         e.preventDefault();
         console.log('CTRL + S');
         $('#update_company').click();
         }
         });
         
         $('#link').keypress(function (e) {
         var key = e.which;
         
         if(key == 13)  
         {
         var link = document.getElementById('link');
         
         var one = $("#company_name").val()+', '+$("#first_name").val()+' '+$("#last_name").val();
         // var country = $("#country option:selected").val();
         var country=$('#country').val();
         var company_country = $("#company_name").val()+', '+country;
         var website_url = $('#website_url').val();
         var web_url = new URL(website_url);
         let result = web_url['host'].substr(0, 4);
         if(result=="www."){
         }else{
         web_url['host'] = "www."+web_url['host'];
         }
         var redirect_url = web_url['protocol']+"//"+web_url['host'];
         var domain_name = redirect_url.split("http://www.");
         alert(domain_name)
         var email = '"'+'* * * * * @'+domain_name[1]+'"'+' '+"email";
         var email1 = 'Email "'+'* * * * * @'+domain_name[1]+'"'+' '+$("#first_name").val()+' '+$("#last_name").val();
         var data = [one,company_country,email,email1];
         for (var i = 0; i < data.length; i++) {
         var two = 'https://www.google.com/search?q=' + encodeURIComponent(data[i]);
         var redirectWindow = window.open(two, '_blank');
         }
         
         return false;  
         }
         });  
         
         $('#addressurl').keypress(function (e) {
         var key = e.which;
         if(key == 13)  
         {
         var address_source_url = $('#address_source_url').val();
         if(address_source_url != ''){
         var redirectWindow = window.open(address_source_url, '_blank');
         }
         
         return false;  
         }
         }); 
         
         $('#websiteurl').keypress(function (e) {
         var key = e.which;
         if(key == 13)  
         {
         var website_url = $('#website_url').val();
         if(website_url != ''){
         var redirectWindow = window.open(website_url, '_blank');
         }
         
         return false;  
         }
         }); 
         
         $('#staffurl').keypress(function (e) {
         var key = e.which;
         if(key == 13)  
         {
         var staff_url = $('#staff_url').val();
         if(staff_url != ''){
         var redirectWindow = window.open(staff_url, '_blank');
         }
         return false;  
         }
         }); 
         
         $('#staffemailharvesting').keypress(function (e) {
         var key = e.which;
         if(key == 13)  
         {
         var staff_email_harvesting = $('#staff_email_harvesting').val();
         if(staff_email_harvesting != '')
         {
         var redirectWindow = window.open(staff_email_harvesting, '_blank');
         }
         return false;  
         }
         }); 
         
         var acList = ["1-10 Employees","11-50 Employees","51-200 Employees","201-500 Employees","501-1000 Employees","1001-5000 Employees","10,001 + Employees"];
         $('#no_of_emp').autocomplete({
         source: function (request, response) {
         var matches = $.map(acList, function (acItem) {
            if (acItem.toUpperCase().indexOf(request.term.toUpperCase()) === 0) {
                return acItem;
            }
         });
         response(matches);
         }
         });
         
         function isNumber(evt) {
         evt = (evt) ? evt : window.event;
         var charCode = (evt.which) ? evt.which : evt.keyCode;
         if (charCode > 31 && (charCode < 48 || charCode > 57)) {
         return false;
         }
         return true;
         }
         
         $("#staff_direct_tel").keypress(function (e) {
         var isValid = false;
         var regex = /^[Xx0-9\s]*$/;
         isValid = regex.test($("#staff_direct_tel").val());
         $("#spnError").css("display", !isValid ? "block" : "none");
         return isValid;
         });
         
         $("#tel_number").keypress(function (e) {
         var isValid = false;
         var regex = /^[0-9\s]*$/;
         isValid = regex.test($("#tel_number").val());
         $("#spndirecttelError").css("display", !isValid ? "block" : "none");
         return isValid;
         });
         
         $("#staff_mobile").keypress(function (e) {
         var isValid = false;
         var regex = /^[0-9\s]*$/;
         isValid = regex.test($("#staff_mobile").val());
         $("#spnmobileError").css("display", !isValid ? "block" : "none");
         return isValid;
         });
         
         $("#alternate_number").keypress(function (e) {
         var isValid = false;
         var regex = /^[,0-9\s]*$/;
         isValid = regex.test($("#alternate_number").val());
         $("#spnaltnoError").css("display", !isValid ? "block" : "none");
         return isValid;
         });
         
         
         /********** STATE COUNT FOR COUNTRY*************/
         
         $("#city_name").keyup(function(){
         var country = $('#country').val();
         var city= $('#city_name').val().toLowerCase();
         if(country == 'USA')
         {
         $('#state_name').prop('disabled', false);
         }else if(country == 'Canada')
         {
         $('#state_name').prop('disabled', false);
         }else if(country == 'Australia')
         {
         $('#state_name').prop('disabled', false);
         } 
         else if(country == 'United Kingdom' && city != 'london')
         {
         $('#state_name').val("");
         $('#state_name').prop('disabled', false);
         }
         else if(country == 'United Kingdom' && city == 'london')
         {
         $('#state_name').val("");
         $('#state_name').prop('disabled', true);
         }
        
         else if(country == 'India' && city == 'delhi')
         {
         $('#state_name').prop('disabled', true);
         }
         else if(country == 'India')
         {
         $('#state_name').prop('disabled', false);
         }
         else if(country == '')
         {
         $('#state_name').prop('disabled', false);
         }
         else{
         $('#state_name').val(''); 
         $('#state_name').prop('disabled', false); 
         }
         });
         
         $('#country').on('autocompletechange change', function () {
         var country = this.value;
         var city= $('#city_name').val().toLowerCase();
         if(country == 'USA')
         {
         
         $('#state_name').prop('disabled', false);
         }else if(country == 'Canada')
         {
        
         $('#state_name').prop('disabled', false);
         }
         else if(country == 'United Kingdom' && city != 'london')
         {
          $('#state_name').prop('disabled', false);
         }
         else if(country == 'Australia')
         {
        
         $('#state_name').prop('disabled', false);
         }else if(country == 'United Kingdom' && city == 'london')
         {
         $('#state_name').val("");
         $('#state_name').prop('disabled', true);
         }
        
         else if(country == 'India' && city == 'delhi')
         {  
         $('#state_name').val("");
         $('#state_name').prop('disabled', true);
         }
         else if(country == 'India')
         {
            $('#state_name').prop('disabled', false);
         }
         else if(country == '')
         {
         $('#state_name').prop('disabled', false);
         }
          else if(country != 'Canada' || country != 'Australia' ||  country != 'United Kingdom' ||  country != 'USA' ||  country != 'India')
        {
            $('#state_name').prop('disabled', true); 
        }
         else{
         $('#state_name').val(''); 
         //$('#city_name').val(''); 
         $('#state_name').prop('disabled', false); 
         }
         }).change();   
         $("#voice_staff_disposition").select2({
          placeholder: "Select Voice Staff Disposition",
          allowClear: true
         });

         var val=$('#company_voice_disposition').val();
         $.ajax({
         url: '<?php echo base_url(); ?>Master/getstaffvoicdisplist',
         type: 'post',
         dataType: "json",
         data:{
         val:val,
         vsd:$('#vsd').val(),
         },
         success: function( data ) {   
            console.log(data);      
         $("#voice_staff_disposition").html(data);
               $('#voice_staff_disposition').trigger("chosen:updated");
         }
         });

         function getdisp(val) {
         $.ajax({
         url: '<?php echo base_url(); ?>Master/getstaffvoicdisplist',
         type: 'post',
         dataType: "json",
         data:{
         val:val,
         vsd:$('#vsd').val(),
         },
         success: function( data ) {   
            console.log(data);          
         $("#voice_staff_disposition").html(data);
               $('#voice_staff_disposition').trigger("chosen:updated");
         }
         });
       } 
      </script>

      
   </body>
</html>