<?php 
/***
File Name: payer_record add-edit.tpl.php 
Created By: SWI Dev 
Created On: June 6, 2016 
Purpose: CURD for payer_record 
*/
?>
<script>var g_controller="<?php echo $pathtoclass;?>", search_action = '<?php echo $search_action;?>';</script>
<script src="<?php echo base_url()?>resource/web_master/js/custom_js/add_edit_view.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){    
    
    //~ $('.datepicker').datepicker({
        //~ format: 'mm/dd/yyyy',
        //~ maxDate:0
    //~ })
    //~ $('.datepicker_mask').mask('99/99/9999');
    
    
    $("#frm_add_edit").submit(function(){
        var b_valid=true;
        var s_err='';
        var email_pattern = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        $("#div_err").hide("slow");        
		
		if($("#s_payer_tin").val()=='')
		{
			markAsError($("#s_payer_tin"),'<?php echo addslashes(t("Please provide payer TIN"))?>');
            b_valid = false;
		}
		if($("#s_first_payer_name_line").val()=='')
		{
			markAsError($("#s_first_payer_name_line"),'<?php echo addslashes(t("Please provide payer first name"))?>');
            b_valid = false;
		}
		if($("#s_payer_shipping_address").val()=='')
		{
			markAsError($("#s_payer_shipping_address"),'<?php echo addslashes(t("Please provide payer shipping address"))?>');
            b_valid = false;
		}
		if($("#s_payer_city").val()=='')
		{
			markAsError($("#s_payer_city"),'<?php echo addslashes(t("Please provide payer city"))?>');
            b_valid = false;
		}
		if($("#s_payer_state").val()=='')
		{
			markAsError($("#s_payer_state"),'<?php echo addslashes(t("Please provide payer state"))?>');
            b_valid = false;
		}
		if($("#s_payer_zip_code").val()=='')
		{
			markAsError($("#s_payer_zip_code"),'<?php echo addslashes(t("Please provide payer zip code"))?>');
            b_valid = false;
		}
        
        if(!b_valid)
        {        
            $("#div_err").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
        }
    
        return b_valid;
    });
   

});
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
             <?php show_all_messages(); echo validation_errors();?>
                        
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-edit"></i>
                    <h3 class="box-title"><?php echo $heading;?></h3>
                </div>
                <!-- /.box-header -->
            
                <!-- form start -->
                <form role="form" id="frm_add_edit" name="frm_add_edit" action="" method="post" autocomplete="off"  enctype="multipart/form-data">
                    <input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>">
                    <div class="box-body no-padding">
						
                        <div class="row">    							
							<div class="col-md-5">   
                                 <div class="col-md-6">   
									<div class="form-group">
										<label for="focusedInput">Taxpayer Identification Number (TIN)<span class="text-danger">*</span></label> 
										<input type="text" class="form-control" id="s_payer_tin" name="s_payer_tin" value="<?php echo $posted["s_payer_tin"];?>" />
										<span class="text-danger"></span>
									</div>
								</div>
                                <div class="col-md-6">
								</div>
                            </div>
                            
                            <div class="col-md-5  col-md-offset-2">
                                <div class="col-md-6">		
									<div class="form-group">
										<label for="focusedInput">First Payer Name Line<span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="s_first_payer_name_line" name="s_first_payer_name_line" value="<?php echo $posted["s_first_payer_name_line"];?>" />
										<span class="text-danger"></span>
									</div>
								</div>								
                                <div class="col-md-6">						
									 <div class="form-group">
										<label for="focusedInput">Second Payer Name Line<span class="text-danger"></span></label>
										<input class="form-control" id="s_second_payer_name_line" name="s_second_payer_name_line" value="<?php echo $posted["s_second_payer_name_line"];?>" type="text" />
										<span class="text-danger"></span>
									</div>
									
								</div>                            
                            </div>
                            
                        </div>
                        
                        <div class="row">   
                            <div class="col-md-5">
                                <div class="col-md-6">	
									<div class="form-group">
										<label for="focusedInput">Payer Shipping Address<span class="text-danger">*</span></label>
										<input class="form-control" id="s_payer_shipping_address" name="s_payer_shipping_address" value="<?php echo $posted["s_payer_shipping_address"];?>" type="text" />
										<span class="text-danger"></span>
									</div>
                                </div>
                                <div class="col-md-6">	
									<label for="focusedInput">Payer City<span class="text-danger">*</span></label>
									<input class="form-control" id="s_payer_city" name="s_payer_city" value="<?php echo $posted["s_payer_city"];?>" type="text" />  
									<span class="text-danger" ></span>
                                </div>
                            </div>
                            
                            <div class="col-md-5  col-md-offset-2">  
                                <div class="col-md-6">	
									<div class="form-group">
										<label for="focusedInput">Payer State Abbreviation<span class="text-danger">*</span></label>
										<input class="form-control" id="s_payer_state" name="s_payer_state" value="<?php echo $posted["s_payer_state"];?>" type="text" />
										<span class="text-danger"></span>
									</div>
                                </div>
                                <div class="col-md-6">	
									<label for="focusedInput">Payer ZIP Code<span class="text-danger">*</span></label>
									<input class="form-control" id="s_payer_zip_code" name="s_payer_zip_code" value="<?php echo $posted["s_payer_zip_code"];?>" type="text" />  
									<span class="text-danger" ></span>
                                </div>                              
                            </div>                            
                        </div>
                        
                        <div class="row">   
                            <div class="col-md-5">
                                <div class="col-md-6">
									<div class="form-group">
										<label for="focusedInput">Payer's Telephone Number and Extension<span class="text-danger"></span></label><br/>
										<input class="form-control" id="s_payers_telephone_number_and_extension" name="s_payers_telephone_number_and_extension" value="<?php echo $posted["s_payers_telephone_number_and_extension"];?>" type="text" />
										<span class="text-danger"></span>
									</div>
                                </div>
                            </div>
                            
                            <div class="col-md-5  col-md-offset-2">
                            </div>                            
                        </div>
                        
                        
                    </div>
                    
                    <div class="box-footer">
                        <input type="button" id="btn_save" name="btn_save" class="btn btn-primary" value="<?php echo addslashes(t("Save changes"))?>">
                        <input type="button" id="btn_cancel" name="btn_cancel" class="btn" value="<?php echo addslashes(t("Cancel"))?>">
                    </div>
                </form>
            </div>
        </div>
    </div><!--/row-->
</div><!-- content ends -->
