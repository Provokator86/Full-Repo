<?php 
/***
File Name: news add-edit.tpl.php 
Created By: SWI Dev 
Created On: September 28, 2015 
Purpose: CURD for News 
*/
?>
<script>var g_controller="<?php echo $pathtoclass;?>", search_action = '<?php echo $search_action;?>';</script>
<script src="<?php echo base_url()?>resource/web_master/js/custom_js/add_edit_view.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
    
    
    $('.datepicker').datepicker({
        format: 'mm/dd/yyyy',
        maxDate:0
    })
    $('.datepicker_mask').mask('99/99/9999');
    
    
    $("#frm_add_edit").submit(function(){
        var b_valid=true;
        var s_err='';
        var email_pattern = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        $("#div_err").hide("slow");
        var content = CKEDITOR.instances['s_description'].getData();
        
		if($("#s_title").val()=='')
		{
			markAsError($("#s_title"),'<?php echo addslashes(t("Please provide title"))?>');
			b_valid = false;
		}
        if($("#s_url").val()=='')
        {
            markAsError($("#s_url"),'<?php echo addslashes(t("Please provide url"))?>');
            b_valid = false;
        }
		if(content=='')
        {
            $("#err_s_description").html('<?php echo addslashes(t("Please provide description"))?>').show();
            b_valid = false;
        }
        else
        {
            $("#err_s_description").html('').hide();
        }
        
        if(!b_valid)
        {        
            $("#div_err").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
        }
    
        return b_valid;
    });
    
    $("#s_title").blur(function(){
        var txt = $(this).val();
        var exurl = $.trim($("#s_url").val());
        if(txt && exurl=='')
        {            
            $.ajax({    
                type: "POST",    
                url: g_controller+'ajax_get_url_from_title/',    
                data: 'txt='+escape(txt),
                dataType: "json",
                async:'false',
                success: function(data) {
                    //console.log(data.urls);
                    $("#s_url").val(data.urls)
                }
            });           
        }
        
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
                            <div class="col-md-5 ">
                                <div class="form-group">
                                    <label for="focusedInput">Title<span class="text-danger">*</span></label>
                                    <input class="form-control" rel="s_title" id="s_title" name="s_title" value="<?php echo $posted["s_title"];?>" type="text" />
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            
                            <div class="col-md-5 ">
                                <div class="form-group">
                                    <label for="focusedInput">Author<span class="text-danger"></span></label>
                                    <input class="form-control" rel="s_author" id="s_author" name="s_author" value="<?php echo $posted["s_author"];?>" type="text" />
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">                
                            <div class="col-md-6 ">
                                <div class="form-group">
                                    <label for="focusedInput">URL<span class="text-danger">*</span><span title="i.e. Type about-us for <?php echo base_url('about-us') ?>">&nbsp;<i class="fa fa-question-circle text-primary"></i></span></label>
                                    <input class="form-control" rel="s_url" id="s_url" name="s_url" value="<?php echo $posted["s_url"];?>" type="text" />
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            
                            <div class="col-md-4 ">
                                <div class="form-group">
                                    <label for="focusedInput">Published Date</label>
                                    <input class="form-control datepicker datepicker_mask" id="dt_published" name="dt_published" value="<?php echo ($posted["dt_published"]!='0000-00-00 00:00:00' && $posted["dt_published"]!='')?date('m/d/Y',strtotime($posted["dt_published"])):date("m/d/Y");?>" type="text" />
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            
                        </div>
                        
                        <div class="row">                
                            <div class="col-md-5 ">
                                <div class="form-group">
                                    <label for="focusedInput">Summary<span class="text-danger"></span></label><br/>
                                    <textarea rows="8" cols="80" rel="s_summary" id="s_summary" name="s_summary" rows="8" cols="20"><?php echo $posted["s_summary"];?></textarea>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            
                            <div class="col-md-3  col-md-offset-2">
                                <div class="form-group">
                                    <label for="focusedInput">Status</label>
                                        <select name="e_status" id="e_status" class="form-control" data-rel="chosen">
                                            <option value="Active" <?php echo $posted['e_status']=='Active'?"selected='selected'":"" ?>>Active</option>
                                            <option value="Inactive" <?php echo $posted['e_status']=='Inactive'?"selected='selected'":"" ?>>Inactive</option>
                                        </select>   
                                    <span class="text-danger" id="err_e_status"></span>
                                    
                                </div>                                 
                            </div>
                            
                        </div>
                        
                        <div class="row">
                            <div class="col-md-10 ">
                                <div class="form-group">
                                    <label for="focusedInput">Description<span class="text-danger">*</span></label>
                                    <textarea class="ckeditor" rows="8" cols="80" rel="s_description" id="s_description" name="s_description" rows="8" cols="20"><?php echo $posted["s_description"];?></textarea>
                                    <span class="text-danger" id="err_s_description"></span>
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