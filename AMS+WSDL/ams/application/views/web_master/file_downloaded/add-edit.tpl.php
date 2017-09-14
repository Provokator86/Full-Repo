<?php 
/***
File Name: manage_forms add-edit.tpl.php 
Created By: SWI Dev 
Created On: June 16, 2016 
Purpose: CURD for manage_forms 
*/
?>
<script>var g_controller="<?php echo $pathtoclass;?>", search_action = '<?php echo $search_action;?>';</script>
<script src="<?php echo base_url()?>resource/web_master/js/custom_js/add_edit_view.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){    
    
    $('.datepicker').datepicker({
        format: 'mm/dd/yyyy',
        maxDate:0
    })
    $('.datepicker_mask').mask('99/99/9999');
    
    
    $("#frm_add_edit").submit(function(){
        var b_valid=true;
        var s_err='';
        var email_pattern = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        $("#div_err").hide("slow");
        //var content = CKEDITOR.instances['s_description'].getData();
        
		if($("#s_form_title").val()=='')
		{
			markAsError($("#s_form_title"),'<?php echo addslashes(t("Please provide title"))?>');
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
                    <div class="box-body">
                        <div class="row">                
                            <div class="col-md-5 ">
                                <div class="form-group">
                                    <label for="focusedInput">Title<span class="text-danger">*</span></label>
                                    <input class="form-control" id="s_form_title" name="s_form_title" value="<?php echo $posted["s_form_title"];?>" type="text" />
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            
                            <div class="col-md-5 ">
                                <div class="form-group">
                                    <label for="focusedInput">Amount Codes<span class="text-danger"></span></label><br/>
                                    <input class="form-control" id="amount_codes" name="amount_codes" value="<?php echo $posted["s_amount_codes"];?>" type="text" />
                                    <span class="text-danger"></span>
                                </div>
                            </div>  
                                                      
                        </div> 
                        
                        <div class="row">   
                            <div class="col-md-5 ">
                                <div class="form-group">
                                    <label for="focusedInput">Summary<span class="text-danger"></span></label><br/>
                                    <textarea rows="4" cols="80" id="s_form_description" name="s_form_description" rows="8" cols="20"><?php echo $posted["s_form_description"];?></textarea>
                                    <span class="text-danger"></span>
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
