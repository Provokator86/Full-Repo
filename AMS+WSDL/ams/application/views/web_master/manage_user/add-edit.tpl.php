<?php
/*********
* Author: SWI
* Date  : 17 Aug 2017
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
<!-- wysihtml5 Editor-->
<link href="<?php echo r_path('css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')?>" rel="stylesheet" type="text/css" />
<!-- End -->

<script type="text/javascript" src="<?php echo r_path('js/custom_js/add_more.js')?>"></script>

<!-- Tag Editor -->
<link rel="stylesheet" href="<?php echo r_path('js/plugins/tagEditor/jquery.tag-editor.css')?>">
<script type="text/javascript" src="<?php echo r_path('js/plugins/tagEditor/jquery.caret.min.js')?>"></script>
<script type="text/javascript" src="<?php echo r_path('js/plugins/tagEditor/jquery.tag-editor.js')?>"></script>
<!-- End -->

<!-- Noti -->
<link href="<?php echo r_path('js/plugins/noty/noty_theme_default.css')?>" rel="stylesheet" type="text/css">
<link href="<?php echo r_path('js/plugins/noty/jquery.noty.css')?>" rel="stylesheet" type="text/css">
<script src="<?php echo base_url()?>resource/web_master/js/plugins/noty/jquery.noty.js" type="text/javascript"></script>
<!-- End -->

<!-- wysihtml5 Editor-->
<!--<script src="<?php echo r_path('js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')?>" type="text/javascript"></script>-->
<!-- End -->

<script type="text/javascript" language="javascript">
$(document).ready(function(){
    var g_controller="<?php echo $pathtoclass;?>"; //controller Path 
    
    
    /*$('.datepicker').datepicker({
        format: 'mm/dd/yyyy',
        minDate:0
    })*/
    //$('.datepicker').mask('99/99/9999');  
     //$(".wysihtml5").wysihtml5();     
     // Masking
    jQuery(function($){
       /*$(".phone_number").mask("999-999-9999");*/
    });
    
    
        
    $('#btn_cancel').click(function(i){
         window.location.href=g_controller+'show_list/'+'<?php echo $this->session->userdata('last_uri');?>'; 
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
        
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        if($("#s_first_name").val()=="") 
        {
            markAsError($("#s_first_name"),'<?php echo addslashes(t("Please provide first name"))?>');
            b_valid=false;
        }
        if($("#s_last_name").val()=="") 
        {
            markAsError($("#s_last_name"),'<?php echo addslashes(t("Please provide last name"))?>');
            b_valid=false;
        }
        if($("#i_user_type").val()=="") 
        {
            //markAsError($("#i_user_type"),'<?php echo addslashes(t("Please provide last name"))?>');
            $("#err_i_user_type").html('Please select role');
            b_valid=false;
        }
        else
        {
			$("#err_i_user_type").html('');
		}
		
        if($("#s_email").val()=="") 
        {
            markAsError($("#s_email"),'<?php echo addslashes(t("Please provide email"))?>');
            b_valid=false;
        }else if(reg.test($.trim($("#s_email").val())) == false){
            markAsError($("#s_email"),'<?php echo addslashes(t("Please provide valid email"))?>');
            b_valid=false;
        }
        
        if($("#s_password").val()=="") 
        {
            markAsError($("#s_password"),'<?php echo addslashes(t("Please provide password"))?>');
            b_valid = false;
        }
        else if ($("#s_password").val() != $("#s_con_password").val())
        {
            markAsError($("#s_con_password"),'<?php echo addslashes(t("Password and confirm password must be same"))?>');
            b_valid = false;
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
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <?php show_all_messages(); echo validation_errors();?>
                
                <div class="box-header">
                    <i class="fa fa-edit"></i>
                    <h3 class="box-title"><?php echo $heading;?></h3>
                </div>
                <div class="box-body">
                    <form role="form" id="frm_add_edit" name="frm_add_edit" action="" method="post" autocomplete="off" enctype="multipart/form-data">
                        <input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
                        <input name="my_selected" id="my_selected" value="" type="hidden" />
                                                
                        <div class="box box-warning">
                            <div class="box-header">
                                <i class="fa fa-info"></i>
                                <h3 class="box-title"><?php echo t('General Information')?></h3>
                                <div class="box-tools pull-right">
                                    <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                   
                                    <div class="col-md-5">
                                        <div class="col-md-6 no-padding-left">
                                        <div class="form-group">
                                            <label><?php echo addslashes(t("First Name"))?><span class="text-danger">*</span></label>
                                            <input class="form-control" id="s_first_name" name="s_first_name" value="<?php echo $posted["s_first_name"];?>" type="text" />
                                            <span class="text-danger"></span>
                                        </div>
                                        </div>
                                        <div class="col-md-6 no-padding-right">
                                        <div class="form-group">
                                            <label><?php echo addslashes(t("Last Name"))?><span class="text-danger">*</span></label>
                                            <input class="form-control" id="s_last_name" name="s_last_name" value="<?php echo $posted["s_last_name"];?>" type="text" />
                                            <span class="text-danger"></span>
                                        </div>                           
                                        </div>
                                    </div>    
                                     
                                    <!--<div class="col-md-5 col-md-offset-2">
                                        <div class="col-md-6 no-padding-left">
                                            <div class="form-group">
                                                <label>User Number</label>
                                                <input class="form-control" id="" name="" value="<?php echo $posted["i_id"];?>" type="text" readonly="readonly" />
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 no-padding-right">
                                        </div>
                                    </div>  -->
                                    <div class="col-md-5 col-md-offset-2">
                                        <div class="col-md-6 no-padding-left">
                                            <div class="form-group">
                                                <label>User Role<span class="text-danger">*</span></label>
                                                <select class="form-control" name="i_user_type" id="i_user_type" data-rel="chosen" data-placeholder="Select Role">
                                                    <option value="">Select Role</option>
                                                    <?php echo makeOptionNoEncrypt($user_type, $posted['i_user_type'])?>
                                                </select>                                                
                                                <span class="text-danger" id="err_i_user_type"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 no-padding-right">
                                        </div>
                                    </div>
                                    
                                      
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label><?php echo addslashes(t("Email"))?><span class="text-danger">*</span></label>
                                            <input class="form-control" id="s_email" name="s_email" value="<?php echo $posted["s_email"];?>" type="text" />
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>        
                                     
                                    <div class="col-md-5 col-md-offset-2">
                                        <div class="col-md-6 no-padding-left">
                                            <div class="form-group">
                                                <label for="focusedInput"><?php echo addslashes(t("Company Name"))?><span class="text-danger"></span></label>
                                                <input class="form-control" id="s_company_name" name="s_company_name" value="<?php echo $posted["s_company_name"];?>" type="text" />
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 no-padding-right">
                                            <div class="form-group">
                                                <label for="focusedInput"><?php echo addslashes(t("Company Address"))?><span class="text-danger"></span></label>
                                                <input class="form-control" id="s_company_address" name="s_company_address" value="<?php echo $posted["s_company_address"];?>" type="text" />
                                                <span class="text-danger"></span>
                                            </div>                           
                                        </div>
                                    </div>              
                                </div>
                                
                                <?php if($mode == 'add'){?>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label ><?php echo addslashes(t("Password"))?><span class="text-danger">*</span>(Min length: 6, Max length: 20) </label>
                                            <input class="form-control" id="s_password" name="s_password" value="" type="password" />
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>        
                                    <div class="col-md-5 col-md-offset-2">
                                        <div class="form-group">
                                            <label><?php echo addslashes(t("Confirm Password"))?> <span class="text-danger">*</span> </label>
                                            <input class="form-control" id="s_con_password" name="s_con_password" value="" type="password" />
                                            <span class="text-danger"></span>
                                        </div>                           
                                    </div>   
                                </div> 
                                <?php }?>   
                               
                                
                            </div>
                        </div>
                        
                    </form> 
                </div>
                <div class="box-footer">
                    <input type="button" id="btn_save" name="btn_save" class="btn btn-primary" value="<?php echo addslashes(t("Save Changes"))?>">                                   
                    <input type="button" id="btn_cancel" name="btn_cancel" class="btn btn-warning" value="<?php echo addslashes(t("Cancel"))?>" >
                </div>
            </div>
        </div>
    </div><!--/row-->        
<!-- content ends -->
</div>
