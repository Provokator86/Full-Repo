<?php
/*********
* Author: Nabarun
* Date  : 06 Jan 2014
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
<script src="<?php echo r_path('js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')?>" type="text/javascript"></script>
<!-- End -->

<script type="text/javascript" language="javascript">
$(document).ready(function(){
    var g_controller="<?php echo $pathtoclass;?>"; //controller Path 
    
    $("#dt_start").datepicker({ 
        dateFormat: 'yy-mm-dd',
        onSelect: function(date){

            var selectedDate = new Date(date);
            var msecsInADay = 86400000;
            var endDate = new Date(selectedDate.getTime() + msecsInADay);

            $("#dt_termination").datepicker( "option", "minDate", endDate );
            $("#dt_termination").datepicker( "option", "maxDate", '+2y' );

        }
    });

    $("#dt_termination").datepicker({ 
        dateFormat: 'yy-mm-dd'
    });
    
    /*$('.datepicker').datepicker({
        format: 'mm/dd/yyyy',
        minDate:0
    })*/
    //$('.datepicker').mask('99/99/9999');    

     $(".wysihtml5").wysihtml5();
    
    // Autocomplete for zip code start
    $("#s_postal_code").autocomplete({
        source: '<?php echo admin_base_url()?>city/ajax_get_postal_code_AJAX',
        minLength: 3,
        select: function(event, ui ) {
            //console.log(ui);
            if(ui.item.value!='')
            {
                // Fetch postal code details
                $.ajax({
                    url: '<?php echo admin_base_url()?>city/ajax_get_postal_code_details_AJAX/',
                    data: 'postal_code='+ui.item.value,
                    dataType: 'json',
                    type: 'post',
                    success: function(res){                        
                        
                        if(res.countryId>0)
                        {
                            $("#i_country_id").val(res.countryId);
                            $("#i_country_id").trigger("liszt:updated").trigger('chosen:updated');    
                        }
                        
                        $("#i_region").html(res.state_html).val(res.stateId);
                        $("#i_region").trigger("liszt:updated").trigger('chosen:updated');
                        
                        $("#i_city_id").html(res.city_html).val(res.cityId);
                        $("#i_city_id").trigger("liszt:updated").trigger('chosen:updated');
                    }
                });
            }
        }
    });
    
    $("#s_postal_code").keyup(function(){
        var postal_code = $(this).val();
            
        if(postal_code.length>=3)
        {
           // Fetch postal code details
                $.ajax({
                    url: '<?php echo admin_base_url()?>city/ajax_get_postal_code_details_AJAX/',
                    data: 'postal_code='+postal_code,
                    dataType: 'json',
                    type: 'post',
                    success: function(res){                        
                        
                        if(res.countryId>0)
                        {
                            $("#i_country_id").val(res.countryId);
                            $("#i_country_id").trigger("liszt:updated").trigger('chosen:updated');    
                        }
                        else
                        {
                            $("#i_country_id").val('');
                            $("#i_country_id").trigger("liszt:updated").trigger('chosen:updated');   
                        }
                        
                        if(res.stateId)
                        {
                            $("#i_region").html(res.state_html).val(res.stateId);
                            $("#i_region").trigger("liszt:updated").trigger('chosen:updated');
                        }
                        else
                        {
                            $("#i_region").html('<option value="">Select State/Province</option>').val('');
                            $("#i_region").trigger("liszt:updated").trigger('chosen:updated');
                        }
                        
                        if(res.cityId)
                        {
                            $("#i_city_id").html(res.city_html).val(res.cityId);
                            $("#i_city_id").trigger("liszt:updated").trigger('chosen:updated');
                        }
                        else
                        {
                            $("#i_city_id").html('<option value="">Select City</option>').val('');
                            $("#i_city_id").trigger("liszt:updated").trigger('chosen:updated');                            
                        }
                    }
                });
        }
        else
        {       
            $("#i_country_id").val('');
            $("#i_country_id").trigger("liszt:updated").trigger('chosen:updated');   

            $("#i_region").html('<option value="">Select State/Province</option>').val('');
            $("#i_region").trigger("liszt:updated").trigger('chosen:updated');

            $("#i_city_id").html('<option value="">Select City</option>').val('');
            $("#i_city_id").trigger("liszt:updated").trigger('chosen:updated'); 
           
        }
    });
    
    // Autocomplete for zip code end     
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
        if($("#txt_first_name").val()=="") 
        {
            markAsError($("#txt_first_name"),'<?php echo addslashes(t("Please provide first name"))?>');
            b_valid=false;
        }
        if($("#txt_last_name").val()=="") 
        {
            markAsError($("#txt_last_name"),'<?php echo addslashes(t("Please provide last name"))?>');
            b_valid=false;
        }
        if($("#txt_email").val()=="") 
        {
            markAsError($("#txt_email"),'<?php echo addslashes(t("Please provide email"))?>');
            b_valid=false;
        }else if(reg.test($.trim($("#txt_email").val())) == false){
            markAsError($("#txt_email"),'<?php echo addslashes(t("Please provide valid email"))?>');
            b_valid=false;
        }
        if($("#txt_user_name").val()=="") 
        {
            markAsError($("#txt_user_name"),'<?php echo addslashes(t("Please provide username"))?>');
            b_valid=false;
        }
        if($("#txt_password").val()=="") 
        {
            markAsError($("#txt_password"),'<?php echo addslashes(t("Please provide password"))?>');
            b_valid = false;
        }
        else if ($("#txt_password").val() != $("#txt_con_password").val())
        {
            markAsError($("#txt_con_password"),'<?php echo addslashes(t("Password and confirm password must be same"))?>');
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
    
    
    /************************* SCRIPT FOR COUTRY STATE COUNTY CHANGE *********************/     
    $( "#i_country_id" ).change(function() {
        var cID = $( "#i_country_id" ).val();
        $('#i_region').parent().find('.text-danger').html('<img src="<?php echo r_path('img/spinner-mini.gif')?>" alt="Loading...">');
        $.ajax({
        type: 'POST',
        url: base_url+'web_master/city/ajax_get_all_state_AJAX',
        data: { countryID: cID }
        })
        .done(function( msg ) {
            //console.log(msg);
            if(msg!='')
               {
                    $('#i_region').parent().find('.text-danger').html('');
                    $("#i_region").html(msg);
                    $("#i_region").trigger("liszt:updated");
                    $("#i_region").trigger('chosen:updated');
                    
                    $("#i_city_id").html('');
                    $("#i_city_id").html('<option value="">Select City</option>');
                    $("#i_city_id").trigger("liszt:updated");
                    $("#i_city_id").trigger('chosen:updated');
               }
        });
    });
    
    $( "#i_region" ).change(function() {
        var sID = $( "#i_region" ).val();
        $('#i_city_id').parent().find('.text-danger').html('<img src="<?php echo r_path('img/spinner-mini.gif')?>" alt="Loading...">');
        $.ajax({
        type: 'POST',
        url: base_url+'web_master/city/ajax_get_all_city_AJAX',
        data: { stateID: sID }
        })
        .done(function( msg ) {
            //console.log(msg);
            if(msg!='')
               {
                    $('#i_city_id').parent().find('.text-danger').html('');
                    $("#i_city_id").html(msg);
                    $("#i_city_id").trigger("liszt:updated");
                    $("#i_city_id").trigger('chosen:updated');
               }
        });
    });
    
    /*$( "#i_country_id" ).change(function() {
        var cID = $( "#i_country_id" ).val();
        $('#i_city_id').parent().find('.text-danger').html('<img src="<?php echo r_path('img/spinner-mini.gif')?>" alt="Loading...">');
        $.ajax({
            type: 'POST',
            url: base_url+'web_master/city/ajax_get_city_on_country_AJAX',
            data: {countryID:cID}
        }).done(function(msg){
            if(msg!='')
            {
                $('#i_city_id').parent().find('.text-danger').html('');
                $("#i_city_id").html(msg).trigger("liszt:updated").trigger('chosen:updated');
            }
        });
    });*/
    
    /************************* SCRIPT FOR COUTRY STATE COUNTY CHANGE *********************/     
    
    
    /*--------------- SCRIPT FOR PERSONAL COUNTRY AND STATE CHANGE -----------------------*/
    $( "#i_personal_country_id" ).change(function() {
        var cID = $( "#i_personal_country_id" ).val();
        $('#i_personal_state_id').parent().find('.text-danger').html('<img src="<?php echo r_path('img/spinner-mini.gif')?>" alt="Loading...">');
        $.ajax({
        type: 'POST',
        url: base_url+'web_master/city/ajax_get_all_state_AJAX',
        data: { countryID: cID }
        })
        .done(function( msg ) {
            //console.log(msg);
            if(msg!='')
               {
                    $('#i_personal_state_id').parent().find('.text-danger').html('');
                    $("#i_personal_state_id").html(msg);
                    $("#i_personal_state_id").trigger("liszt:updated");
                    $("#i_personal_state_id").trigger('chosen:updated');
                    
                    $("#i_personal_city_id").html('');
                    $("#i_personal_city_id").html('<option value="">Select County</option>');
                    $("#i_personal_city_id").trigger("liszt:updated");
                    $("#i_personal_city_id").trigger('chosen:updated');
               }
        });
    });
    
    $( "#i_personal_state_id" ).change(function() {
        var sID = $( "#i_personal_state_id" ).val();
        $('#i_personal_city_id').parent().find('.text-danger').html('<img src="<?php echo r_path('img/spinner-mini.gif')?>" alt="Loading...">');
        $.ajax({
        type: 'POST',
        url: base_url+'web_master/city/ajax_get_all_city_AJAX',
        data: { stateID: sID }
        })
        .done(function( msg ) {
            //console.log(msg);
            if(msg!='')
               {
                    $('#i_personal_city_id').parent().find('.text-danger').html('');
                    $("#i_personal_city_id").html(msg);
                    $("#i_personal_city_id").trigger("liszt:updated");
                    $("#i_personal_city_id").trigger('chosen:updated');
               }
        });
    });

    /*--------------- END SCRIPT FOR COUNTRY AND STATE CHANGE -----------------------*/
    
   
    
    
    
    
    
    
    
    
    
    
    
    
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
                                    <!--<div class="col-md-5">
                                        <div class="form-group">
                                            <label><?php echo addslashes(t("First Name"))?><span class="text-danger">*</span></label>
                                            <input class="form-control" id="txt_first_name" name="txt_first_name" value="<?php echo $posted["s_first_name"];?>" type="text" />
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>        
                                    <div class="col-md-5 col-md-offset-2">
                                        <div class="form-group">
                                            <label><?php echo addslashes(t("Last Name"))?><span class="text-danger">*</span></label>
                                            <input class="form-control" id="txt_last_name" name="txt_last_name" value="<?php echo $posted["s_last_name"];?>" type="text" />
                                            <span class="text-danger"></span>
                                        </div>                           
                                    </div>    -->
                                     
                                    <div class="col-md-5">
                                        <div class="col-md-6 no-padding-left">
                                        <div class="form-group">
                                            <label><?php echo addslashes(t("First Name"))?><span class="text-danger">*</span></label>
                                            <input class="form-control" id="txt_first_name" name="txt_first_name" value="<?php echo $posted["s_first_name"];?>" type="text" />
                                            <span class="text-danger"></span>
                                        </div>
                                        </div>
                                        <div class="col-md-6 no-padding-right">
                                        <div class="form-group">
                                            <label><?php echo addslashes(t("Last Name"))?><span class="text-danger">*</span></label>
                                            <input class="form-control" id="txt_last_name" name="txt_last_name" value="<?php echo $posted["s_last_name"];?>" type="text" />
                                            <span class="text-danger"></span>
                                        </div>                           
                                        </div>
                                    </div>    
                                     
                                    <div class="col-md-5 col-md-offset-2">
                                        <div class="col-md-6 no-padding-left">
                                            <div class="form-group">
                                                <label>User Number</label>
                                                <input class="form-control" id="" name="" value="<?php echo $posted["i_id"];?>" type="text" readonly="readonly" />
                                                <span class="text-danger"></span>
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
                                            <input class="form-control" id="txt_email" name="txt_email" value="<?php echo $posted["s_email"];?>" type="text" />
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>        
                                    <!--<div class="col-md-5 col-md-offset-2">
                                        <div class="form-group">
                                            <label ><?php echo addslashes(t("User Name"))?><span class="text-danger">*</span> </label>
                                            <input class="form-control" id="txt_user_name" name="txt_user_name" value="<?php echo $posted["s_user_name"];?>" type="text" />
                                            <span class="text-danger"></span>
                                        </div>                           
                                    </div>-->  
                                    <div class="col-md-5 col-md-offset-2">
                                        <div class="col-md-6 no-padding-left">
                                            <div class="form-group">
                                                <label for="focusedInput"><?php echo addslashes(t("Telephone"))?><span class="text-danger"></span></label>
                                                <input class="form-control phone_number" rel="s_telephone" id="s_telephone" name="s_telephone" value="<?php echo $posted["s_telephone"];?>" type="text" />
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 no-padding-right">
                                            <div class="form-group">
                                                <label for="focusedInput"><?php echo addslashes(t("Cell Phone"))?><span class="text-danger"></span></label>
                                                <input class="form-control" rel="s_cell_phone" id="s_cell_phone" name="s_cell_phone" value="<?php echo $posted["s_cell_phone"];?>" type="text" />
                                                <span class="text-danger"></span>
                                            </div>                           
                                        </div>
                                    </div>              
                                </div>
                                
                                <?php if($mode == 'add'){?>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label ><?php echo addslashes(t("Password"))?><span class="text-danger">*</span> </label>
                                            <input class="form-control" id="txt_password" name="txt_password" value="" type="password" />
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>        
                                    <div class="col-md-5 col-md-offset-2">
                                        <div class="form-group">
                                            <label><?php echo addslashes(t("Confirm Password"))?> <span class="text-danger">*</span> </label>
                                            <input class="form-control" id="txt_con_password" name="txt_con_password" value="" type="password" />
                                            <span class="text-danger"></span>
                                        </div>                           
                                    </div>   
                                </div> 
                                <?php }?>   
                                
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            
                                            <label for="focusedInput"><?php echo addslashes(t("Title"))?><span class="text-danger"></span></label>
                                            <input class="form-control" rel="s_title" id="s_title" name="s_title" value="<?php echo $posted["s_title"];?>" type="text" />
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>        
                                    <div class="col-md-5 col-md-offset-2">
                                        <div class="form-group">
                                            <label for="focusedInput"><?php echo addslashes(t("Credentials"))?><span class="text-danger"></span></label>
                                            <input class="form-control" rel="s_credentials" id="s_credentials" name="s_credentials" value="<?php echo $posted["s_credentials"];?>" type="text" />
                                            <span class="text-danger"></span>
                                        </div>                           
                                    </div>                
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="focusedInput"><?php echo addslashes(t("Display Name"))?><span class="text-danger"></span></label>
                                            <input class="form-control" rel="s_display_name" id="s_display_name" name="s_display_name" value="<?php echo $posted["s_display_name"];?>" type="text" />
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>        
                                    <div class="col-md-5 col-md-offset-2">
                                        <div class="form-group">
                                            <label for="focusedInput"><?php echo addslashes(t("Company Name"))?><span class="text-danger"></span></label>
                                            <input class="form-control" rel="s_company_name" id="s_company_name" name="s_company_name" value="<?php echo $posted["s_company_name"];?>" type="text" />
                                            <span class="text-danger"></span>
                                        </div>                           
                                    </div>                
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="focusedInput"><?php echo addslashes(t("Unit"))?><span class="text-danger"></span></label>
                                            <input class="form-control" rel="s_unit" id="s_unit" name="s_unit" value="<?php echo $posted["s_unit"];?>" type="text" />
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>        
                                    <div class="col-md-5 col-md-offset-2">
                                        <div class="form-group">
                                            <label for="focusedInput"><?php echo addslashes(t("Street"))?><span class="text-danger"></span></label>
                                            <input class="form-control" rel="s_street" id="s_street" name="s_street" value="<?php echo $posted["s_street"];?>" type="text" />
                                            <span class="text-danger"></span>
                                        </div>                           
                                    </div>                
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="col-md-6 no-padding-left">                                            
                                            <div class="form-group">
                                                <label for="focusedInput">City</label> 
                                                <select name="i_city_id" id="i_city_id" class="form-control" data-rel="chosen">
                                                    <option value="">Select City</option>
                                                    <?php 
                                                    if($posted['i_country_id'] && $posted['i_region']){
                                                    echo makeOptionCity(' i_country_id ="'.$posted['i_country_id'].'" AND i_state_id="'.$posted['i_region'].'" ',$posted['i_city_id']) ;
                                                    }
                                                ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 no-padding-right">
                                            <div class="form-group">
                                                <label><?php echo addslashes(t("Zip/Postal Code"))?></label>
                                                <input class="form-control" rel="s_postal_code" id="s_postal_code" name="s_postal_code" value="<?php echo $posted["s_postal_code"];?>" type="text" maxlength="10" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5  col-md-offset-2">
                                        <div class="form-group">
                                            <label for="focusedInput"><?php echo addslashes(t("State/Province"))?><span class="text-danger"></span></label>                                    
                                            <select name="i_region" id="i_region" class="form-control" data-rel="chosen">
                                            <option value="">Select State/Province</option>
                                            <?php 
                                            if($posted['i_country_id']){
                                            echo makeOptionState(' i_country_id="'.$posted['i_country_id'].'"',$posted['i_region']) ;
                                            }
                                            //echo makeOptionRegion('',$posted['i_region']);
                                            ?>
                                            </select>
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-5">
                                         <div class="form-group">
                                          <label for="focusedInput"><?php echo addslashes(t("Country"))?></label>
                                             <select name="i_country_id" id="i_country_id" class="form-control" data-rel="chosen">
                                             <option value="">Select Country</option>
                                             <?php echo makeOptionCountry('',$posted['i_country_id']) ?>
                                             </select>
                                             <span class="text-danger"></span>
                                         </div>
                                     </div>
                                    <div class="col-md-5 col-md-offset-2">
                                            <div class="form-group">
                                                <label>County</label>
                                                <input class="form-control" rel="s_city" id="s_city" name="s_city" value="<?php echo $posted["s_city"];?>" type="text" />
                                            </div>
                                        <!--<div class="col-md-11 no-padding-left">
                                            <div class="form-group">
                                                <label for="focusedInput">County</label> 
                                                <select name="i_city_id" id="i_city_id" class="form-control" data-rel="chosen">
                                                    <option value="">Select County</option>
                                                    <?php 
                                                    if($posted['i_country_id'] && $posted['i_region']){
                                                    echo makeOptionCity(' i_country_id ="'.$posted['i_country_id'].'" AND i_state_id="'.$posted['i_region'].'" ',$posted['i_city_id']) ;
                                                    }
                                                ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-1  no-padding-right">
                                            <label for="add-new-county">&nbsp;&nbsp;</label>
                                            <div class="pull-left">
                                                <a href="#new-county" id="add-new-county" class="" title="Add New County" style="display: inline-block; margin-top: 5px;"><i class="fa fa-plus"></i></a>
                                            </div> 
                                        </div>-->
                                    </div>
                                </div>  
                                
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="focusedInput">Start Date<span class="text-danger"></span></label>
                                            <input class="form-control datepicker" id="dt_start" name="dt_start" value="<?php echo ($posted["dt_start"]  && $posted["dt_start"]!='0000-00-00 00:00:00')?date("Y-m-d",strtotime($posted['dt_start'])):"";?>" type="text" />
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>        
                                    <div class="col-md-5 col-md-offset-2">
                                        <div class="form-group">
                                            <label for="focusedInput">Termination Date<span class="text-danger"></span></label>
                                            <input class="form-control datepicker" id="dt_termination" name="dt_termination" value="<?php echo ($posted["dt_termination"] && $posted["dt_termination"]!='0000-00-00 00:00:00')?date("Y-m-d",strtotime($posted['dt_termination'])):"";?>" type="text" />
                                            <span class="text-danger"></span>
                                        </div>                           
                                    </div>                
                                </div>
                                <!--<div class="row">
                                    <div class="col-md-5">
                                        <div class="box ">
                                            <div class="box-body no-padding">
                                                <div class="form-group">
                                                    <label for="focusedInput"><?php echo addslashes(t("Bio"))?><span class="text-danger"></span></label>
                                                    <textarea cols="" rows="6" class="form-control wysihtml5" id="s_bio" name="s_bio"><?php echo $posted["s_bio"];?></textarea>
                                                    <span class="text-danger"></span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>        
                                    <div class="col-md-5 col-md-offset-2">
                                        <div class="form-group">
                                            <label for="focusedInput">Expertise <span class="help-text">(Type expertise and press enter)</span></label>
                                            <input class="form-control" rel="s_expertise" id="s_expertise" name="s_expertise" value="<?php echo $posted["s_expertise"];?>" type="text" />
                                            <span class="text-danger"></span>
                                        </div>                           
                                    </div>                
                                </div>-->
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="focusedInput"><?php echo addslashes(t("Bio"))?><span class="text-danger"></span></label>
                                            <textarea cols="" rows="6" class="form-control wysihtml5" id="s_bio" name="s_bio"><?php echo $posted["s_bio"];?></textarea>
                                            <span class="text-danger"></span>
                                        </div>
                                        
                                    </div> 
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-5 ">
                                        <div class="form-group">
                                            <label for="focusedInput"><?php echo addslashes(t("Web Site"))?><span class="text-danger"></span></label>
                                            <input class="form-control" rel="s_web_site" id="s_web_site" name="s_web_site" value="<?php echo $posted["s_web_site"];?>" type="text" />
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-5  col-md-offset-2">
                                        <!--<div class="form-group">
                                        <label for="focusedInput"><?php echo addslashes(t("Professional Partner"))?><span class="text-danger"></span></label>
                                            <input class="form-control" rel="s_professional_partner" id="s_professional_partner" name="s_professional_partner" value="<?php echo $posted["s_professional_partner"];?>" type="text" /><span class="text-danger"></span>
                                        </div>-->
                                    </div>
                                </div>
                                
                                <?php if($this->user_type==1 || $this->user_type==2){ ?>
                                <div class="row">
                                    <div class="col-md-5 ">
                                        <div class="form-group">                                            
                                            <label for="focusedInput">Profile Image(127px X 164px)</label>
                                            <input id="s_profile_image" name="s_profile_image" type="file"/>
                                            <span class="text-danger"></span>
                                        </div>
                                        <?php if($posted['s_profile_image'] != ''){?>
                                        <div class="form-group">
                                            <img src="<?php echo base_url('uploaded/user_image/thumb/'.$posted['s_profile_image'])?>" alt="Logo" style="max-height: 100px; max-width: 150px;">
                                            <input rel="h_profile_image" id="h_profile_image" name="h_profile_image" type="hidden" value="<?php echo $posted['s_profile_image']; ?>"/>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <div class="col-md-5  col-md-offset-2">
                                        
                                    </div>
                                </div>
                                <?php } ?>
                                
                                
                            </div>
                        </div>
                        
                        <div class="box box-warning">
                            <div class="box-header">
                                <i class="fa fa-gears"></i>
                                <h3 class="box-title"><?php echo t('Role Information');?></h3>
                                <div class="box-tools pull-right">
                                    <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-3 col-md-3_1">
                                        <span class="text"><b><?php echo t('User Role')?></b></span>
                                    </div>
                                    <div class="col-md-3 col-md-3_1">
                                        <span class="text"><b></b></span>
                                    </div>
                                    <div class="col-md-3 col-md-3_1">
                                        <span class="text"><b></b></span>
                                    </div>
                                    <div class="col-md-1">&nbsp;</div>
                                </div>
                                
                                <div class="add-more-container" id="add_more_user_role_<?php echo $i?>>">
                                    <div class="row">
                                        <div class="col-md-3 col-md-3_1">
                                            <div class="form-group">
                                                <select class="form-control" name="role_id[]" data-rel="chosen" data-placeholder="Select Role">
                                                    <option value="">Select Role</option>
                                                    <?php echo makeOption($user_type, encrypt($user_role[$i]['i_role_id']))?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-md-3_1">
                                            
                                        </div>
                                        <div class="col-md-3 col-md-3_1">
                                            
                                        </div>
                                        
                                    </div>  
                                </div>
                                
                                
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

<div class="hidden">
    <div class="form-add-new-county" id="new-county">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header">
                    <i class="fa fa-plus"></i>
                    <h3 class="box-title"><?php echo t('Add New County')?></h3>
                </div>
                <div class="box-body">
                    <div class="col-md-8 no-padding">
                        <div class="form-group">
                            <label for="new_county">Enter New Country <span class="text-danger">*</span></label>
                             <input class="form-control" id="txt_new_county" name="txt_new_county" value="" type="text" />
                             <span class="text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>&nbsp;&nbsp;</label>
                            <input type="button" name="btn_add_new_county" id="btn_add_new_county" class="btn btn-primary" value="Add County" style="margin-top: 5px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
