<?php
/*********
* Author: SWI
* Date  : 11 sept 2017
* Modified By: 
* Modified Date: 
* Purpose:
*  View For Admin My account Edit
* @package General
* @subpackage My account
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/my_account/
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
	    
	    
	    /*if($.trim($("#txt_user_name").val())=="") 
        {
		    markAsError($("#txt_user_name"),'Please provide user name');
            b_valid=false;
        }*/
	    /*
        if($.trim($("#s_email").val())=="") 
        {
            markAsError($("#s_email"),'Please provide email');
            b_valid=false;
        }
	    else if($("#s_email").val()!="") 
        {
		    if(reg.test($.trim($("#s_email").val())) == false)
		    {
			    markAsError($("#s_email"),'Please provide valid email');
			    b_valid=false;
		    }
	    }*/	
       
        //validating//
        if(!b_valid)
        {        
            $("#div_err").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
        }
        
        return b_valid;
    });    
    //end Submitting the form//  
}); 

     
 function select_avatar(obj)
 {
 	var img	= obj.attr('src');
	$('#selected_avatar').html('<img src="'+img+'"/>');
	$('#s_avatar').val(obj.attr('alt'));
 }
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
                            <div class="form-group">
                                <label>First Name</label>                        
                                <input type="email" class="form-control" name="s_first_name" id="s_first_name" placeholder="First Name" value="<?php echo $posted["s_first_name"];?>">
                                <span class="text-danger"></span>
                            </div>				                 
                            <div class="form-group">
                                <label>Last Name</label>                                    
                                <input type="email" class="form-control" name="s_last_name" id="s_last_name" placeholder="Last Name" value="<?php echo $posted["s_last_name"];?>">
                                <span class="text-danger"></span>
                            </div>
                      
                            <div class="form-group">
                                <label >Customer Name</label>
                                <input type="text" class="form-control" id="s_customer_name" name="s_customer_name" placeholder="Customer Name" value="<?php echo $posted["s_customer_name"];?>">                                            
                            </div>
                      
                            <div class="form-group">
                                <label >Automatic Email<?php //echo '==>'.$posted["i_auto_email"] ?></label><br>
                                <input type="radio" name="i_auto_email" value="1" <?php echo ($posted["i_auto_email"]==1)?'checked':'';?> >On&nbsp;<input type="radio" name="i_auto_email" value="2"  <?php echo ($posted["i_auto_email"]==2)?'checked':'';?> >Off
                            </div>
                            
                         </div>

                        <div class="col-md-5 col-md-offset-2">	
                            
                            <div class="form-group">
                                <label >Company Name</label>
                                <input type="text" class="form-control" id="s_company_name" name="s_company_name" placeholder="Company Name" value="<?php echo $posted["s_company_name"];?>">
                            </div>                
                            <div class="form-group">
                                <label>Company FEIN</label>
                                <input type="text" class="form-control" id="s_company_fein_number" name="s_company_fein_number" placeholder="Company FEIN" value="<?php echo $posted["s_company_fein_number"];?>">
                            </div>                            
                            <div class="form-group" >
                                <label >Company Address</label>
                                <input type="text" class="form-control" id="s_company_address" name="s_company_address" placeholder="Company Address" value="<?php echo $posted["s_company_address"];?>">
                            </div>
                            
                            <div class="form-group" >
                                <label >Company Phone</label>
                                <input type="text" class="form-control" id="s_company_phone" name="s_company_phone" placeholder="Company Phone" value="<?php echo $posted["s_company_phone"];?>">
                            </div>
                            
                        </div>
                    </div>
                    
                 </div>

                <div class="box-footer">
                    <input type="button" id="btn_save" name="btn_save" class="btn btn-primary" value="Save Changes">
                    <input type="button" id="btn_cancel" name="btn_cancel" class="btn btn-warning" value="Cancel" >
                </div>
            </form>
        </div>
    </div>
</div>
