<?php
/*********
* Author: Acumen CS
* Date  : 06 Feb 2014
* Modified By: 
* Modified Date: 
* Purpose:
*  View For Admin user Add & Edit
* @package General
* @subpackage admin_user
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/manage_admin_user/
*/
?>
<script>var g_controller="<?php echo $pathtoclass;?>", search_action = '<?php echo $search_action;?>';// Controller Path </script>
<script src="<?php echo base_url()?>resource/web_master/js/custom_js/add_edit_view.js" type="text/javascript"></script>

<!--<script type="text/javascript" src="<?php echo r_path('js/tinymce/jscripts/tiny_mce/tiny_mce.js')?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo r_path('js/tinymce/load_tiny_mce.js')?>"></script>-->

<script language="javascript">
$(document).ready(function(){

var g_controller="<?php echo $pathtoclass;?>"; //controller Path 

$("#btn_add_record").click(function(){
            var url=g_controller+'add_information/';
            window.location.href=url;
    
 });
     
$('#btn_cancel').click(function(i){
	 window.location.href=g_controller; 
});   


$('#btn_save').click(function(){
   //check_duplicate();
   $("#frm_add_edit").submit();
}); 

    
//Submitting the form//
$("#frm_add_edit").submit(function(){
    var b_valid=true;
    var s_err="";
    $("#div_err").hide("slow");
    var content = CKEDITOR.instances['s_description'].getData();
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	if($("#s_title").val()=="") 
    {
		markAsError($("#s_title"),'<?php echo  "Please provide title"?>');
        b_valid=false;
    }
    if(content=='')
    {
        //markAsError($("#s_content"),'<?php echo "Please provide content"?>');
        $("#err_s_description").html('<?php echo "Please provide content"?>').show();
        b_valid = false;
    }
    else
    {
        $("#err_s_description").html('').hide();
    }
    
	/*if($("#s_description").val()=="") 
    {
		     
    }*/
    
   
	
    //validating//
    if(!b_valid)
    {        
        $("#div_err").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
    }
    
    return b_valid;
});    
//end Submitting the form//  	


	/*$('#txt_like_keyword, #txt_dislike_keyword').on("keyup", function(e) {
		this.value = this.value.replace(/[^a-zA-Z\,]/g, '');
	});*/

    


	var markAsError	=	function(selector,msg){
		//$(selector).next('.help-inline').html(msg);	
        $(selector).parents('.controls').find('.help-inline').html(msg);
		$(selector).parents('.control-group').addClass("error");
		
		$(selector).on('focus',function(){
			removeAsError($(this));
		});
	}
	
	var removeAsError	=	function(selector){
		//$(selector).next('.help-inline').html('');	
        $(selector).parents('.controls').find('.help-inline').html('');
		$(selector).parents('.control-group').removeClass("error");
	} 
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
                                    <input class="form-control" rel="s_title" id="s_title" name="s_title" value="<?php echo $posted["s_title"];?>" type="text" />
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-5  col-md-offset-2">    
                               
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-5 ">
                                <div class="form-group">
                                    <?php //if($mode=='add'){ ?>
                                    <label for="focusedInput">Page<span class="text-danger">*</span></label>
                                        <select name="i_parent_id" id="i_parent_id" class="form-control" data-rel="chosen">
                                            <option>Root</option>
                                            <?php echo getOptionPages(0,'',$posted["i_id"],$posted["i_parent_id"]);?>
                                        </select>   
                                    <span class="text-danger" id="err_i_parent_id"></span>
                                    <?php // } else{ ?>
                                    <!--<label for="focusedInput">Page<span class="text-danger"></span></label>
                                    <p><?php echo _cms_master($posted['i_cms_master_id']) ?></p>
                                    <input type="hidden" name="i_cms_master_id" value="<?php echo $posted['i_cms_master_id'];?>">-->
                                    <?php //} ?>
                                </div>
                            </div>
                            <div class="col-md-5  col-md-offset-2">
                            </div>
                        </div>
                        
                        
                        <div class="row">                
                            <div class="col-md-12 ">                   
                                <!--<div class="form-group">-->
                                    <label for="focusedInput">Content<span class="text-danger">*</span></label>
                                    
                                    <textarea name="s_description" id="s_description" rel="s_description" class="ckeditor" rows="8" cols="80" ><?php echo $posted["s_description"]?></textarea>
                                    <span class="text-danger" id="err_s_description"></span>
                                <!--</div>-->
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
