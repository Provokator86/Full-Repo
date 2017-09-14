<?php
/*********
* Author: SW
* Date  : 
* Modified By: 
* Modified Date: 
* Purpose:
*  View For Customer Add & Edit
* @package General
* @subpackage admin_user
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/manage_admin_user/
*/
?>
<?php
    if(!empty($posted)) extract($posted);    
?>
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
	
	if($("#s_name").val()=="") 
    {
		markAsError($("#s_name"),'<?php echo  addslashes(custom_lang_display("Please provide name"))?>');
        b_valid=false;
    }
	
	/*if($("#s_code").val()=="") 
    {
        markAsError($("#s_code"),'<?php echo  addslashes(custom_lang_display("Please provide code"))?>');
        b_valid=false;
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
}); 
  
</script>

<?php /* ?>
<div id="content" class="span10">
			<!-- content starts -->
		
			<?php echo admin_breadcrumb($BREADCRUMB); ?>
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> <?php echo $title;?></h2>
						<div class="box-icon">
                            <a href="#" class="btn btn-round" id="btn_add_record"><i class="icon-plus"></i></a>							
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>
                    
                    <div class="box-content">	
                   
                   
						 
						<?php show_all_messages();?>
					
					
						<form class="form-horizontal" id="frm_add_edit" name="frm_add_edit" action="" method="post" autocomplete="off">
                        <input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
						  <fieldset>            							
                          
                            <div class="control-group">   
							  <label class="control-label" for="focusedInput"><?php echo  addslashes(custom_lang_display("Name"))?>*</label>
								<div class="controls">
								  <input class="focused" id="s_name" name="s_name" value="<?php echo $s_name;?>" type="text" />
								  <span class="help-inline"></span> 	
                                </div>
							</div>
                            
                            <div class="control-group">
                              <label class="control-label" for="focusedInput"><?php echo  addslashes(custom_lang_display("Details"))?>*</label>
                                <div class="controls">   
                                  <textarea cols="" rows="" name="s_details" id="s_details"><?php echo $s_details;?></textarea>
                                  <span class="help-inline"></span>     
                                </div>
                            </div>
                            
							<div class="form-actions">
							  <button type="button" id="btn_save" name="btn_save" class="btn btn-primary"><?php echo  addslashes(custom_lang_display("Save changes"))?></button>
							  <button type="button" id="btn_cancel" name="btn_cancel" class="btn"><?php echo  addslashes(custom_lang_display("Cancel"))?></button>
							</div>
						  </fieldset>
						</form>   

					</div>
					
				</div><!--/span-->

			</div><!--/row-->		

<!-- content ends -->
</div>
<?php */ ?>


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
                                <label for="focusedInput">Name<span class="text-danger">*</span></label>
                                    <input class="form-control" rel="s_name" id="s_name" name="s_name" value="<?php echo $posted["s_name"];?>" type="text" />
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-5  col-md-offset-2">    
                               
                            </div>
                        </div>
                        
                        <div class="row">                
                            <div class="col-md-5 ">
                                <div class="form-group">
                                <label for="focusedInput">Details<span class="text-danger">*</span></label>
                                    <input class="form-control" rel="s_details" id="s_details" name="s_details" value="<?php echo $posted["s_details"];?>" type="text" />
                                    <span class="text-danger"></span>
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