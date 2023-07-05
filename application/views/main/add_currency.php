<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Currency Management</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card-box">
                        <p><?php echo $this->session->flashdata("error");?></p>
                        <p><?php echo $this->session->flashdata("success");?></p>

                        <?php
                         if(!empty($getFormCurrency)){
                           $id = $getFormCurrency['id']; 
                           $currency_name = $getFormCurrency['currency_name']; 
                           $currency_symbol = $getFormCurrency['currency_symbol']; 
                           $button = "Update";

                         }else{
                            $id = ""; 
                            $currency_name = ""; 
                            $currency_symbol = ""; 
                            $button = "Submit";

                         }
                        ?>




                        <form action="<?php echo base_url('master/submit_currency'); ?>" method="post">
                            <div class="form-group">
                                <label>Currency Name</label>
                                <input type="hidden" name="currency_id" value="<?= $id; ?>">

                                <input type="text" name="currency_name" class="form-control" 
                                placeholder="Currency Name.." required="" value="<?= $currency_name; ?>" >
                            </div>

                             <div class="form-group">
                                <label>Currency Symbol</label>
                                <input type="text" name="currency_symbol" class="form-control" 
                                placeholder="Currency Symbol" required="" value="<?= $currency_symbol; ?>" >
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
                                    <th>Currency Name</th>
                                    <th>Currency Symbol</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (!empty($getAllCurrency)) {

                                foreach ($getAllCurrency as $key => $value) {
                            ?>
                                    
                                        <tr>
                                            <td><?php echo $key+1;?></td>
                                            <td><?php echo $value['currency_name']?></td>
                                            <td><?php echo $value['currency_symbol']?></td>
                                            <td>
                                               <a href="<?php echo base_url('master/add_currency').'/'.$value['id'];?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                                &nbsp;&nbsp;&nbsp;

                                                <a href="<?php echo base_url('master/DeleteCurrency').'/'.$value['id'];?>" onclick="return confirm('are you sure to want delete selected Currency.')"><i class="fa-solid fa-trash"></i></a>
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