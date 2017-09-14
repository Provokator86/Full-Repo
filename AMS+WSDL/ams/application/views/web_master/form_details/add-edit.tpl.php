<?php 
/***
File Name: form_details add-edit.tpl.php 
Created By: SWI Dev 
Created On: June 6, 2016 
Purpose: CURD for form_details 
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
        
		if($("#i_form_id").val()=='')
		{
			$("#err_i_form_id").html('<?php echo addslashes(t("Please select form ID"))?>').show();
            b_valid = false;
		}
        else
        {
            $("#err_i_form_id").html('').hide();
        }
        
		if($("#e_record_type").val()=='')
		{
			$("#err_e_record_type").html('<?php echo addslashes(t("Please select record type"))?>').show();
            b_valid = false;
		}
        else
        {
            $("#err_e_record_type").html('').hide();
        }
        
		if($("#i_field_pos_start").val()=='')
		{
			markAsError($("#i_field_pos_start"),'<?php echo addslashes(t("Please provide start position"))?>');
            b_valid = false;
		}
		if($("#i_field_pos_end").val()=='')
		{
			markAsError($("#i_field_pos_end"),'<?php echo addslashes(t("Please provide end position"))?>');
            b_valid = false;
		}
		if($("#s_xml_tag").val()=='')
		{
			markAsError($("#s_xml_tag"),'<?php echo addslashes(t("Please provide xml tag name"))?>');
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
                                 <!--<div class="col-md-6">   
									<div class="form-group">
										<label for="focusedInput">Form ID<span class="text-danger">*</span></label>
										<select name="i_form_id" id="i_form_id" class="form-control" data-rel="chosen">
											<option value="">Select</option>
											<?php echo makeOptionFormsMaster($posted['i_form_id']);   ?>
										</select>
										<span class="text-danger" id="err_i_form_id"></span>
									</div>
								</div>-->
								<input type="hidden" id="i_form_id" name="i_form_id" value="<?php echo $i_form_id?$i_form_id:$posted['i_form_id']; ?>" >
                                <div class="col-md-6">
									<div class="form-group">
										<label for="focusedInput">Record Type<span class="text-danger">*</span></label>
										<select name="e_record_type" id="e_record_type" class="form-control" data-rel="chosen">
											<option value="">Select</option>
											<?php echo makeOptionRecordType($posted['e_record_type']);   ?>
										</select>
										<span class="text-danger" id="err_e_record_type"></span>
									</div>
								</div>
                            </div>
                            
                            <div class="col-md-5  col-md-offset-2">
                                <div class="col-md-6">								
									 <div class="form-group">
										<label for="focusedInput">Field Position Start<span class="text-danger">*</span></label>
										<input class="form-control" id="i_field_pos_start" name="i_field_pos_start" value="<?php echo $posted["i_field_pos_start"];?>" type="text" />
										<span class="text-danger"></span>
									</div>
								</div>								
                                <div class="col-md-6">
									<div class="form-group">
										<label for="focusedInput">Field Position End<span class="text-danger">*</span></label>
										<input class="form-control" id="i_field_pos_end" name="i_field_pos_end" value="<?php echo $posted["i_field_pos_end"];?>" type="text" />
										<span class="text-danger"></span>
									</div>
								</div>                            
                            </div>
                            
                        </div>
                        
                        <div class="row">   
                            <div class="col-md-5">
                                <div class="col-md-6">	
									<div class="form-group">
										<label for="focusedInput">XML Tag Name<span class="text-danger">*</span></label>
										<input class="form-control" id="s_xml_tag" name="s_xml_tag" value="<?php echo $posted["s_xml_tag"];?>" type="text" />
										<span class="text-danger"></span>
									</div>
                                </div>
                                <div class="col-md-6">	
<!--
									<label for="focusedInput">Status</label>
										<select name="i_status" id="i_status" class="form-control" data-rel="chosen">
											<option value="1" <?php echo $posted['i_status']==1?"selected='selected'":"" ?>>Active</option>
											<option value="0" <?php echo $posted['i_status']!=1?"selected='selected'":"" ?>>Inactive</option>
										</select>   
									<span class="text-danger" id="err_i_status"></span>
-->
                                </div>
                            </div>
                            
                            <div class="col-md-5  col-md-offset-2">                                
                            </div>                            
                        </div>
                        
                        <div class="row">   
                            <div class="col-md-5">
                                <div class="col-md-6">
									<div class="form-group">
										<label for="focusedInput">Purpose<span class="text-danger"></span></label><br/>
										<textarea id="s_purpose_fileds" name="s_purpose_fileds" rows="4" cols="80"><?php echo $posted["s_purpose_fileds"];?></textarea>
										<span class="text-danger"></span>
									</div>
                                </div>
                            </div>
                            
                            <div class="col-md-5  col-md-offset-2">
                                <div class="col-md-6">
									<div class="form-group">
										<label for="focusedInput">Validation Rules<span class="text-danger"></span></label><br/>
										<textarea id="s_validation_rules" name="s_validation_rules" rows="4" cols="80"><?php echo $posted["s_validation_rules"];?></textarea>
										<span class="text-danger"></span>
									</div>
                                </div>
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
