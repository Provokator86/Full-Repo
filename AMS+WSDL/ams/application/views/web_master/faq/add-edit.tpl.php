<?php 
/***

File Name: faq add-edit.tpl.php 
Created By: SWI Dev 
Created On: September 28, 2015 
Purpose: CURD for Faq 

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
        
		if($("#s_question").val()=='')
		{
			markAsError($("#s_question"),'<?php echo addslashes(t("Please provide question"))?>');
			b_valid = false;
		}
		if($("#s_answer").val()=='')
		{
			markAsError($("#s_answer"),'<?php echo addslashes(t("Please provide answer"))?>');
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
	                        <div class="col-md-10 ">
                                <div class="form-group">
                                    <label for="focusedInput"><?php echo addslashes(t("Question"))?><span class="text-danger">*</span></label>
                                    <input class="form-control" rel="s_question" id="s_question" name="s_question" value="<?php echo $posted["s_question"];?>" type="text" />
                                    <span class="text-danger"></span>
                                </div>
	                        </div>
	                        
                        </div>
                        <div class="row">
	                        <div class="col-md-10 ">
		                        <div class="form-group">
		                            <label for="focusedInput"><?php echo addslashes(t("Answer"))?><span class="text-danger">*</span></label>
			                        <textarea style="min-height: 140px;" class="form-control" rel="s_answer" id="s_answer" name="s_answer" rows="8" cols="20"><?php echo $posted["s_answer"]?$posted["s_answer"]:"";?></textarea>
                                    <span class="text-danger"></span>
		                        </div>
	                        </div>
	                        <!--<div class="col-md-5  col-md-offset-2">
	                        </div>-->
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
