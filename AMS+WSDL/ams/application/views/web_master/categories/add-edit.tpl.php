<?php
/*********
* Author: Acumen CS
* Date  : 03 Feb 2014
* Modified By: 
* Modified Date: 
* Purpose:
*  View For Admin category management Edit
* @package General
* @subpackage category
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/category_management/
*/
?>
<script language="javascript">

$(document).ready(function(){

	var g_controller="<?php echo $pathtoclass;?>"; //controller Path 
		
	$('#btn_cancel').click(function(i){
		 window.location.href=g_controller; 
	});   
	
	$('#btn_save').click(function(){
		var b_valid=true;
		var s_err="";
		$("#div_err").hide("slow"); 
		
		if($("#s_category").val()=="") 
		{
			markAsError($("#s_category"),'<?php echo get_message('category')?>');
			b_valid = false;
		}
		
		if(b_valid) // Check for uniqueness
		{
			$.ajax({
				url: '<?php echo $pathtoclass?>ajax_check_for_uniqueness',
				data: 'category='+$("#s_category").val()+'&h_id='+$('#h_id').val(),
				dataType: 'json',
				type: 'post',
				success: function(res){
					if(res.status == 'exist')
						$("#div_err").html('<div id="err_msg" class="error_massage">'+res.msg+'</div>').show("slow");
					else if(res.status == 'ok') // Check for uniqueness
						$("#frm_add_edit").submit();
				}
			});
		}
	}); 
	
		
	//Submitting the form//
	$("#frm_add_edit").submit(function(){
		return true;
	});    
	//end Submitting the form//  	
}); 

var markAsError	=	function(selector,msg){
	$(selector).next('.help-inline').html(msg);	
	$(selector).parents('.control-group').addClass("error");
	
	$(selector).on('focus',function(){
		removeAsError($(this));
	});
}

var removeAsError	=	function(selector){
	$(selector).next('.help-inline').html('');	
	$(selector).parents('.control-group').removeClass("error");
} 
  
</script>
<div id="content" class="span10">
    <!-- content starts -->
    <?php echo admin_breadcrumb($BREADCRUMB); ?>
    <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header well" data-original-title>
                <h2><i class="icon-edit"></i> <?php echo $heading;?></h2>
                <div class="box-icon">							
                    <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">	
                <?php show_all_messages(); ?>
                <div id="div_err"></div>
                <form class="form-horizontal" id="frm_add_edit" name="frm_add_edit" action="" method="post">
                <input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
                  <fieldset>
                    <div class="control-group">
                      <label class="control-label" for="focusedInput"><?php echo addslashes(t("Parent Category"))?></label>
                        <div class="controls">
                         <select name="opt_parent_cat" id="opt_parent_cat" data-placeholder="<?php echo addslashes(t('Select'))?>" data-rel="chosen"><option value=""><?php echo addslashes(t('Select'))?></option>
						<?php echo getOptionCategory('', '', '', '1', encrypt($posted['opt_parent_cat']),2);?>
                        </select>
                          <span class="help-inline"></span> 	
                        </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label" for="focusedInput"><?php echo addslashes(t("Category"))?>*</label>
                        <div class="controls">
                          <input class="focused" id="s_category" name="s_category" value="<?php echo $posted["s_category_name"];?>" type="text" >
                          <span class="help-inline"></span> 	
                        </div>
                    </div>	
                            
                    <div class="form-actions">
                      <button type="button" id="btn_save" name="btn_save" class="btn btn-primary"><?php echo addslashes(t("Save changes"))?></button>
                      <button type="button" id="btn_cancel" name="btn_cancel" class="btn"><?php echo addslashes(t("Cancel"))?></button>
                    </div>
                  </fieldset>
                </form>   
            </div>
        </div><!--/span-->
    </div><!--/row-->		
<!-- content ends -->
</div>