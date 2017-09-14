<?php 
/***
File Name: payer_record add-edit.tpl.php 
Created By: SWI Dev 
Created On: May 26, 2017
Purpose: CURD for payer_record 
*/
?>
<script>var g_controller="<?php echo $pathtoclass;?>", search_action = '<?php echo $search_action;?>';</script>
<script src="<?php echo base_url()?>resource/web_master/js/custom_js/add_edit_view.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){    
    
    
    $("#frm_add_edit").submit(function(){
        var b_valid=true;
        var s_err='';
        var email_pattern = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        $("#div_err").hide("slow");        
		
		if($("#s_first_name").val()=='')
		{
			markAsError($("#s_first_name"),'<?php echo addslashes(t("Please provide first name"))?>');
            b_valid = false;
		}
		if($("#s_last_name").val()=='')
		{
			markAsError($("#s_last_name"),'<?php echo addslashes(t("Please provide last name"))?>');
            b_valid = false;
		}
		if($("#s_email").val()=='')
		{
			markAsError($("#s_email"),'<?php echo addslashes(t("Please provide email"))?>');
            b_valid = false;
		}
	    else if($("#s_email").val()!="") 
        {
		    if(email_pattern.test($.trim($("#s_email").val())) == false)
		    {
			    markAsError($("#s_email"),'<?php echo addslashes(t("Please provide valid email"))?>');
			    b_valid=false;
		    }
	    }
		/*if($("#s_customer_name").val()=='')
		{
			markAsError($("#s_customer_name"),'<?php echo addslashes(t("Please provide customer name"))?>');
            b_valid = false;
		}*/
		if($("#s_company_name").val()=='')
		{
			markAsError($("#s_company_name"),'<?php echo addslashes(t("Please provide company name"))?>');
            b_valid = false;
		}
		if($("#s_company_fein_number").val()=='')
		{
			markAsError($("#s_company_fein_number"),'<?php echo addslashes(t("Please provide FEIN number"))?>');
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
                    <input type="hidden" id="h_user_name" name="h_user_name" value="<?php echo $posted["s_user_name"];?>">
                    <div class="box-body no-padding">
						
						<!-- start row -->
                        <div class="row">    							
							<div class="col-md-5">   
                                 <div class="col-md-6">   
									<div class="form-group">
										<label for="focusedInput">First Name<span class="text-danger">*</span></label> 
										<input type="text" class="form-control" id="s_first_name" name="s_first_name" value="<?php echo $posted["s_first_name"];?>" />
										<span class="text-danger"></span>
									</div>
								</div>
                                <div class="col-md-6">
									<div class="form-group">
										<label for="focusedInput">Last Name<span class="text-danger">*</span></label> 
										<input type="text" class="form-control" id="s_last_name" name="s_last_name" value="<?php echo $posted["s_last_name"];?>" />
										<span class="text-danger"></span>
									</div>
								</div>
                            </div>
                            
                            <div class="col-md-5  col-md-offset-2">
                                <div class="col-md-6">		
									<div class="form-group">
										<label for="focusedInput">Email<span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="s_email" name="s_email" value="<?php echo $posted["s_email"];?>" />
										<span class="text-danger"></span>
									</div>
								</div>								
                                <div class="col-md-6">	
									<div class="form-group">
										<label for="focusedInput">Generate Password<span class="text-danger"></span></label>
										<br>
										<input type="checkbox" class="form-control" id="generate_password" name="generate_password" value="generate_password" />
										<span class="text-danger"></span>
									</div>					
									 <!--<div class="form-group">
										<label for="focusedInput">Customer Name<span class="text-danger"></span></label>
										<input class="form-control" id="s_customer_name" name="s_customer_name" value="<?php echo $posted["s_customer_name"];?>" type="text" />
										<span class="text-danger"></span>
									</div>-->
									
								</div>                            
                            </div>
                            
                        </div>
                        <!-- end row -->
                        
						<!-- start row -->
                        <div class="row">    							
							<div class="col-md-5">   
                                 <div class="col-md-6">   
									<div class="form-group">
										<label for="focusedInput">Company Name<span class="text-danger">*</span></label> 
										<input type="text" class="form-control" id="s_company_name" name="s_company_name" value="<?php echo $posted["s_company_name"];?>" />
										<span class="text-danger"></span>
									</div>
								</div>
                                <div class="col-md-6">
									<div class="form-group">
										<label for="focusedInput">Company FEIN number<span class="text-danger">*</span></label> 
										<input type="text" class="form-control" id="s_company_fein_number" name="s_company_fein_number" value="<?php echo $posted["s_company_fein_number"];?>" />
										<span class="text-danger"></span>
									</div>
								</div>
                            </div>
                            
                            <div class="col-md-5  col-md-offset-2">
                                <div class="col-md-6">		
									<div class="form-group">
										<label for="focusedInput">Address<span class="text-danger"></span></label>
										<input type="text" class="form-control" id="s_company_address" name="s_company_address" value="<?php echo $posted["s_company_address"];?>" />
										<span class="text-danger"></span>
									</div>
								</div>								
                                <div class="col-md-6">						
									 <div class="form-group">
										<label for="focusedInput">State<span class="text-danger"></span></label>
										<input class="form-control" id="s_company_state" name="s_company_state" value="<?php echo $posted["s_company_state"];?>" type="text" />
										<span class="text-danger"></span>
									</div>
									
								</div>                            
                            </div>
                            
                        </div>
                        <!-- end row -->                        
                        
						<!-- start row -->
                        <div class="row">    							
							<div class="col-md-5">   
                                 <div class="col-md-6">   
									<div class="form-group">
										<label for="focusedInput">City<span class="text-danger"></span></label> 
										<input type="text" class="form-control" id="s_company_city" name="s_company_city" value="<?php echo $posted["s_company_city"];?>" />
										<span class="text-danger"></span>
									</div>
								</div>
                                <div class="col-md-6">
									<div class="form-group">
										<label for="focusedInput">Zip Code<span class="text-danger"></span></label> 
										<input type="text" class="form-control" id="s_company_zip" name="s_company_zip" value="<?php echo $posted["s_company_zip"];?>" />
										<span class="text-danger"></span>
									</div>
								</div>
                            </div>
                            
                            <div class="col-md-5  col-md-offset-2">
                                <div class="col-md-6">		
									<div class="form-group">
										<label for="focusedInput">Phone<span class="text-danger"></span></label>
										<input type="text" class="form-control" id="s_company_phone" name="s_company_phone" value="<?php echo $posted["s_company_phone"];?>" />
										<span class="text-danger"></span>
									</div>
								</div>								
                                <div class="col-md-6">						
									 <div class="form-group">
										<label for="focusedInput">Auto Email<span class="text-danger"></span></label>
										<select class="form-control" id="i_auto_email" name="i_auto_email">
											<option value='2' <?php echo $posted["i_auto_email"]==2? 'selected' : ''; ?>>Off</option>
											<option value='1' <?php echo $posted["i_auto_email"]==1? 'selected' : ''; ?>>On</option>
										</select>
											
										<span class="text-danger"></span>
									</div>
								</div>                            
                            </div>
                            
                        </div>
                        <!-- end row -->
                        
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
