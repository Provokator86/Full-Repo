<?php
/*********
* Author: SWI
* Date  : 4 Jan 2016
* Modified By: 
* Modified Date: 
* Purpose:
*  View For Admin Change Password Edit
* @package General
* @subpackage Change Password
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/my_account/change_password
*/
?>
<script language="javascript">
$(document).ready(function(){
    jQuery(function($){
       $(".phone_number").mask("999-999-9999");
    });

    var g_controller="<?php echo $pathtoclass;?>"; //controller Path 

    $('#btn_save').click(function(){
	    $("#frm_add_edit").submit();
    });

    $('#btn_cancel').click(function(){
	     window.location.href=g_controller; 
	     //alert(1);
    }); 

    $("#txt_new_password").keypress(function(evt){
	    var charCode = (evt.which) ? evt.which : evt.keyCode
	    if(charCode==32)
		    return false;
	    else
		    return true;
    });
     
    //Submitting the form//
    $("#frm_add_edit").submit(function(){
        var b_valid=true;
        var s_err="";
	    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;	
	    
        $("#div_err").hide("slow");
	    
	    if($.trim($("#txt_new_password").val())=="")
        {
            markAsError($("#txt_new_password"),'<?php echo addslashes(t("Please provide new password"))?>');
            b_valid=false;
        }
        if($.trim($("#txt_confirm_password").val())=="")
        {
            markAsError($("#txt_confirm_password"),'<?php echo addslashes(t("Please provide confirm password"))?>');
            b_valid=false;
        }
        if(($.trim($("#txt_new_password").val())!="" || $.trim($("#txt_confirm_password").val())!="") && ($.trim($("#txt_new_password").val()) != $.trim($("#txt_confirm_password").val())))
        {    
            markAsError($("#txt_confirm_password"),'<?php echo addslashes(t("New Password and Confirm Password did not match"))?>');
            b_valid=false;
        }
        //validating//
        if(!b_valid)
        {        
            $("#div_err").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
        }
        
        return b_valid;
    });    
    //end Submitting the form//  
}); 
 
</script>

<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <?php show_all_messages(); echo validation_errors(); ?>
            <div class="box-header">
                <i class="fa fa-edit"></i>
                <h3 class="box-title"><?php echo $heading;?></h3>
            </div><!-- /.box-header -->
            
			
            <form role="form" class="" id="frm_add_edit" name="frm_add_edit" action="" method="post" autocomplete="off"  enctype="multipart/form-data">
            <input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
                 <div class="box-body">
                    <div class="row">
                        <div class="col-md-5">                            
                            <!--<div class="form-group">
                                <label for="exampleInputPassword1" ><?php echo addslashes(t("Old Password"))?></label>
                                <input type="password" class="form-control" id="txt_password" name="txt_password" placeholder="Password" value="<?php //echo $posted["txt_password"];?>">
                            </div>-->                
                            <div class="form-group">
                                <label for="exampleInputFile"><?php echo addslashes(t("New Password"))?><span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="txt_new_password" name="txt_new_password" placeholder="New Password" value="<?php //echo $posted["txt_password"];?>">
                                <span class="text-danger"></span>
                            </div>
                            
                            <div class="form-group" >
                                <label ><?php echo addslashes(t("Confirm Password"))?><span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="txt_confirm_password" name="txt_confirm_password" placeholder="New Password" value="<?php //echo $posted["txt_password"];?>">
                                <span class="text-danger"></span>
                            </div>
                         </div>

                        <div class="col-md-5 col-md-offset-2">	
                        </div>
                    </div>
                    
                    <?php /* ?>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="exampleInputFile"><?php echo addslashes(t("Select Avatar"))?></label>
                                <div class="clearfix"></div>                           
                                <img src="<?php echo r_path('img/avatar.png');?>" alt="avatar.png" width="80" height="80" onclick="select_avatar($(this));" class="img-thumbnail" />
                                <img src="<?php echo r_path('img/avatar2.png');?>" alt="avatar2.png" width="80" height="80"  onclick="select_avatar($(this));" class="img-thumbnail"  />
                                <img src="<?php echo r_path('img/avatar3.png');?>" alt="avatar3.png" width="80" height="80"  onclick="select_avatar($(this));" class="img-thumbnail"  />
                                <img src="<?php echo r_path('img/avatar04.png');?>" alt="avatar04.png" width="80" height="80"  onclick="select_avatar($(this));" class="img-thumbnail"  />
                                <img src="<?php echo r_path('img/avatar5.png');?>" alt="avatar5.png"  width="80" height="80"  onclick="select_avatar($(this));" class="img-thumbnail" />
                            </div>				
                        </div>

                        <div id="selected_avatar" class="col-md-5 text-center col-md-offset-2">
                        <?php
                        if(!empty($posted["s_avatar"]))
                            echo '<img class="img-thumbnail" src="'.r_path('img/'.$posted["s_avatar"]).'" />';
                        ?>
                        </div>
                        <input type="hidden" name="s_avatar" id="s_avatar" value="<?php echo $posted["s_avatar"];?>" />
                    </div>  	
                    <?php */ ?>
                    
                 </div>

                <div class="box-footer">
                    <input type="button" id="btn_save" name="btn_save" class="btn btn-primary" value="<?php echo addslashes(t("Save Changes"))?>">
                    <input type="button" id="btn_cancel" name="btn_cancel" class="btn btn-warning" value="<?php echo addslashes(t("Cancel"))?>" >
                </div>
            </form>
        </div>
    </div>
</div>
