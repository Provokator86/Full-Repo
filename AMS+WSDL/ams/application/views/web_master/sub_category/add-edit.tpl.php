<?php 
/***
File Name: category add-edit.tpl.php 
Created By: ACS Dev 
Created On: June 02, 2015 
Purpose: CURD for Category 
*/
?>
<script>var g_controller="<?php echo $pathtoclass;?>", search_action = '<?php echo $search_action;?>';// Controller Path </script>
<script src="<?php echo base_url()?>resource/web_master/js/custom_js/add_edit_view.js" type="text/javascript"></script>
<script type"text/javascript">
$(document).ready(function(){
    //Submitting the form//
    $("#frm_add_edit").submit(function(){
        var b_valid=true;
        var s_err='';
        var email_pattern = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        $("#div_err").hide("slow");
        
		if($("#i_parent_id").val()=='')
        {
            //markAsError($("#i_parent_id"),'<?php echo addslashes(t("Please select parent category"))?>');
            $("#err_i_parent_id").html('<?php echo addslashes(t("Please select parent category"))?>').show();
            b_valid = false;
        }
        else
        {
            $("#err_i_parent_id").html('');
            b_valid=true;
        }
        
        if($("#s_category").val()=='')
		{
			markAsError($("#s_category"),'<?php echo addslashes(t("Please provide sub category"))?>');
			b_valid = false;
		}
        //validating//
        if(!b_valid)
        {        
            $("#div_err").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
        }
    
        return b_valid;
    });
});
</script>

<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <?php show_all_messages();?>
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
                                <label for="focusedInput"><?php echo addslashes(t("Parent Category"))?><span class="text-danger">*</span></label>
                                <select name="i_parent_id" id="i_parent_id" class="form-control" data-rel="chosen">
                                    <option value="">Select Category</option>
                                    <?php 
                                    if(decrypt($posted['h_id'])>0){
                                        echo makeOptionParentCategory(' i_id!= "'.decrypt($posted['h_id']).'" ',$posted['i_parent_id']);
                                    } else{ 
                                        echo makeOptionParentCategory('',$posted['i_parent_id']) ;
                                    }
                                    ?>
                                </select>
                                <span class="text-danger" id="err_i_parent_id"></span>
                            </div>
	                    </div>
	                    <div class="col-md-5  col-md-offset-2">
                            <div class="form-group">
                            <label for="focusedInput"><?php echo addslashes(t("Sub Category"))?><span class="text-danger">*</span></label>
                                <input class="form-control" rel="s_category" id="s_category" name="s_category" value="<?php echo $posted["s_category"];?>" type="text" /><span class="text-danger"></span>
                            </div>
	                    </div>
                    </div>
                    
                    <div class="row">
	                    <div class="col-md-5 ">
                            <div class="form-group">
                            <label for="focusedInput"><?php echo addslashes(t("Status"))?><span class="text-danger"></span></label>    
                                <select class="form-control" rel="i_status" id="i_status" name="i_status" data-rel="chosen">
                                    <!--<option value="">Select</option>-->
                                    <option value="1" <?php echo ($posted['i_status']==1)?'selected="selected"':""; ?>>Active</option>
                                    <option value="2" <?php echo ($posted['i_status']*1==0 && $posted['i_status'].'A'!='A')?'selected="selected"':""; ?>>Inactive</option>
                                    
                                </select>
                                <span class="text-danger"></span>
                            </div>
	                    </div>
	                    <div class="col-md-5  col-md-offset-2">
	                    </div>
                    </div>
                </div>
                
                <div class="box-footer">
                    <input type="button" id="btn_save" name="btn_save" class="btn btn-primary" value="<?php echo addslashes(t("Save Changes"))?>">
                    <input type="button" id="btn_cancel" name="btn_cancel" class="btn" value="<?php echo addslashes(t("Cancel"))?>">
                </div>
            </form>
        </div>
    </div>
</div><!--/row-->

