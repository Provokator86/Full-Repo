<?php
/*********
* Author: Jagabor
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
<script language="javascript">
$(document).ready(function(){
    var g_controller="<?php echo $pathtoclass;?>"; //controller Path 
    
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
    $(function(){
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
    
   
    
    // Add more callback
    if(add_more_after_add_callback)
    {
        add_more_after_add_callback = function(_this)
        {
            _this.find('.chosen-container').remove();
            _this.find('select').show().val('').chosen({width:'100%'});
            
            // Change role
            _this.find('select[name^="role_id"]').change(function(){
                var $this = $(this), role_id = $(this).val();
                
                if(role_id == 'TVNOaFkzVT0=' || role_id == 'TWlOaFkzVT0=' || role_id == 'TXlOaFkzVT0=' )
                {
                    // Disable all region and franchise
                    _this.find('select[name^="region_id"]').html('<option value="">Select Region</option>')
                                                           .trigger("liszt:updated")
                                                           .trigger("chosen:updated");
                    _this.find('select[name^="franchise_id"]').html('<option value="">Select Franchise</option>')
                                                              .trigger("liszt:updated")
                                                              .trigger("chosen:updated");
                }
                else
                {
                    var region = '<?php echo make_option_region()?>';
                    // set region
                    _this.find('select[name^="region_id"]').html(region);
                    _this.find('select[name^="region_id"]').trigger("liszt:updated");
                    _this.find('select[name^="region_id"]').trigger('chosen:updated');
                    
                    // Unset the franchise
                    _this.find('select[name^="franchise_id"]').html('<option value="">Select Franchise</option>')
                                                              .trigger("liszt:updated")
                                                              .trigger("chosen:updated");
                }
            });
            // End change role
            
            // Change region
            _this.find('select[name^="region_id"]').change(function(){
                var $this = $(this), region_id = $(this).val();
                var role_id = _this.find('select[name^="role_id"]').val();
                if(role_id == 'TkNOaFkzVT0=')
                {
                    _this.find('select[name^="franchise_id"]').html('<option value="">Select Franchise</option>')
                                                              .trigger("liszt:updated")
                                                              .trigger("chosen:updated");
                }
                else
                {
                    $.ajax({
                        url: g_controller+'ajax_get_franchise',
                        data: 'region_id='+region_id,
                        dataType: 'json',
                        type: 'post'
                    }).done(function(response){
                        _this.find('select[name^="franchise_id"]').html(response.data)
                                                                  .trigger("liszt:updated")
                                                                  .trigger('chosen:updated');
                    });
                }
            });
            // End Change region
        }
    }
    // End add more
    
    // Remove add more data
    $('.add_more_remove').on('click', function(){
        var cnt = $('.add-more-container').length, obj = $(this).parent().parent().parent();
        if(cnt > 1)
            obj.remove();
        else
        {
            obj.find('select').val('')
                              .trigger("liszt:updated")
                              .trigger('chosen:updated');
        }
    });
    // End
    
    // Change role
    $('select[name^="role_id"]').change(function(){
        var $this = $(this), role_id = $(this).val(), _this = $(this).parent().parent().parent().parent();
        if(role_id == 'TVNOaFkzVT0=' || role_id == 'TWlOaFkzVT0=' || role_id == 'TXlOaFkzVT0=' )
        {
            // Disable all region and franchise
            _this.find('select[name^="region_id"]').html('<option value="">Select Region</option>')
                                                   .trigger("liszt:updated")
                                                   .trigger("chosen:updated");
            _this.find('select[name^="franchise_id"]').html('<option value="">Select Franchise</option>')
                                                      .trigger("liszt:updated")
                                                      .trigger("chosen:updated");
        }
        else
        {
            var region = '<?php echo make_option_region()?>';
            // set region
            _this.find('select[name^="region_id"]').html(region);
            _this.find('select[name^="region_id"]').trigger("liszt:updated");
            _this.find('select[name^="region_id"]').trigger('chosen:updated');
            
            // Unset the franchise
            _this.find('select[name^="franchise_id"]').html('<option value="">Select Franchise</option>')
                                                      .trigger("liszt:updated")
                                                      .trigger("chosen:updated");
        }
    });
    // End change role
    
    // Change region
    $('select[name^="region_id"]').change(function(){
        var $this = $(this), region_id = $(this).val(), _this = $(this).parent().parent().parent().parent();
        var role_id = _this.find('select[name^="role_id"]').val();
        if(role_id == 'TkNOaFkzVT0=')
        {
            _this.find('select[name^="franchise_id"]').html('<option value="">Select Franchise</option>')
                                                      .trigger("liszt:updated")
                                                      .trigger("chosen:updated");
        }
        else
        {
            $.ajax({
                url: g_controller+'ajax_get_franchise',
                data: 'region_id='+region_id,
                dataType: 'json',
                type: 'post'
            }).done(function(response){
                _this.find('select[name^="franchise_id"]').html(response.data);
                _this.find('select[name^="franchise_id"]').trigger("liszt:updated");
                _this.find('select[name^="franchise_id"]').trigger('chosen:updated');
            });
        }
    });
    // End change region
    
    // Tag editor
    var expertise = <?php echo json_encode(explode(',',$posted['s_expertise']))?>;
    $('#s_expertise').tagEditor({
        //placeholder: 'Enter expertise',
        initialTags: expertise,
        forceLowercase: false,
        autocomplete: { 
            source: g_controller+'ajax_get_keyword', 
            minLength: 2, 
            delay: 0, 
            html: false, 
            position: { 
                collision: 'flip' 
            }
        },
        //onChange: function(field, editor, tags) {},
        //beforeTagSave: function(field, editor, tags, tag, val) {},
        beforeTagDelete: function(field, editor, tags, val) {
            //var q = confirm('Remove expertise  "' + val + '"?');
            return true;
        }
    });
    // End tag editor
    
    /*$('select[name^="role_id"]').on('chosen:showing_dropdown', function(){
        var chosen_width = $('.chosen-drop').width();
        var container_position = jQuery(this).height();
        console.log(jQuery(this).offset().top);
        console.log($(window).height()+'-->');
        console.log(chosen_width+'-->');
    });*/
    
    // Add new county
    $('#add-new-county').click(function(e){
        e.preventDefault();
        $.noty.closeAll()
        var country_id = parseInt($('#i_country_id').val()), state_id = parseInt($('#i_region').val());
        if(country_id && state_id)
        {
            $("#txt_new_county").val('').focus();
            $(this).colorbox({inline:true, maxWidth:'95%', maxHeight:'95%'}); 
            $('#btn_add_new_county').click(function(){
                var _this = $(this), county = $.trim($('#txt_new_county').val());
                if(county != '')
                {
                    // Save the county 
                    $.ajax({
                        url: g_controller+'ajax_add_new_county',
                        data: {country_id:country_id, state_id:state_id, county:county},
                        dataType: 'json',
                        type: 'post',
                        success: function(response){
                            if(response.status == 'exist')
                                markAsError($("#txt_new_county"),'<?php echo get_message("county_exist")?>','no');
                            else if(response.status == 'success')
                            {
                                // Replace county list with the new county
                                $('#i_city_id').html(response.html)
                                               .trigger("liszt:updated")
                                               .trigger('chosen:updated');
                                
                                $('#cboxClose').click(); // Close colorbox
                                noty({"text":'<?php echo get_message('save_success')?>',"layout":"bottomRight","type":'success'});
                            }
                            else
                            {
                                 $('#cboxClose').click(); // Close colorbox
                                 noty({"text":'<?php echo get_message('save_failed')?>',"layout":"top","type":'warning'});
                            }
                        }
                    });
                }
                else
                {
                    $.colorbox.resize();
                    markAsError($("#txt_new_county"),'<?php echo addslashes(t("Please provide county name"))?>','no');
                }
            });  
        }
        else
            noty({"text":'<?php echo get_message('country_state')?>',"layout":"top","type":'warning'});
    });
    // End
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
                    <form role="form" id="frm_add_edit" name="frm_add_edit" action="" method="post" autocomplete="off">
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
                                            <label for="focusedInput"><?php echo addslashes(t("Bio"))?><span class="text-danger"></span></label>
                                            <textarea cols="" rows="" class="form-control" id="s_bio" name="s_bio"><?php echo $posted["s_bio"];?></textarea>
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>        
                                    <div class="col-md-5 col-md-offset-2">
                                        <div class="form-group">
                                            <label for="focusedInput">Expertise <span class="help-text">(Type expertise and press enter)</span></label>
                                            <input class="form-control" rel="s_expertise" id="s_expertise" name="s_expertise" value="<?php echo $posted["s_expertise"];?>" type="text" />
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
                                        <div class="form-group">
                                        <label for="focusedInput"><?php echo addslashes(t("Professional Partner"))?><span class="text-danger"></span></label>
                                            <input class="form-control" rel="s_professional_partner" id="s_professional_partner" name="s_professional_partner" value="<?php echo $posted["s_professional_partner"];?>" type="text" /><span class="text-danger"></span>
                                        </div>
                                    </div>
                                </div>
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
                                        <span class="text"><b><?php echo t('Select Region')?></b></span>
                                    </div>
                                    <div class="col-md-3 col-md-3_1">
                                        <span class="text"><b><?php echo t('Select Franchise Office')?></b></span>
                                    </div>
                                    <div class="col-md-1">&nbsp;</div>
                                </div>
                                <?php 
                                $i = 0;
                                do{
                                ?>
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
                                            <div class="form-group">
                                                <select class="form-control" name="region_id[]" data-rel="chosen" data-placeholder="Select Region">
                                                    <?php if($user_role[$i]['i_role_id'] > 3){echo make_option_region($user_role[$i]['i_region_id']);} else{ echo '<option value="">Select Region</option>';}?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-md-3_1">
                                            <div class="form-group">
                                                <select class="form-control" name="franchise_id[]" data-rel="chosen" data-placeholder="Select Franchise">
                                                    <?php if($user_role[$i]['i_region_id'] > 0 && $user_role[$i]['i_role_id'] == 10){
                                                        echo make_option_franchise($user_role[$i]['i_region_id'], $user_role[$i]['i_franchise_id']);
                                                    } else {
                                                        echo '<option value="">Select Franchise</option>';
                                                    }?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <a href="javascript:;" class="add_more_remove" id="add_more_remove" rel="add_more_user_role_" style="display: inline-block; margin-top: 6px;"><i class="glyphicon glyphicon-remove text-red"></i></a>
                                        </div>
                                    </div>  
                                </div>
                                <?php $i++;} while($i < count($user_role));?>
                                <a href="javascript:;" style="margin-top:0px; display:inline-block;" rel="user_role"  onclick="addmore('add_more_user_role_');" class="add_more_link"><i class="glyphicon glyphicon-plus"></i> Add More User Role</a>
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
