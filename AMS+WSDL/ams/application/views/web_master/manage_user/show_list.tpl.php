<!-- Noti -->
<link href="<?php echo r_path('js/plugins/noty/noty_theme_default.css')?>" rel="stylesheet" type="text/css">
<link href="<?php echo r_path('js/plugins/noty/jquery.noty.css')?>" rel="stylesheet" type="text/css">
<script src="<?php echo base_url()?>resource/web_master/js/plugins/noty/jquery.noty.js" type="text/javascript"></script>
<!-- End -->
<script type="text/javascript">
$(document).ready(function(){
    var g_controller="<?php echo $this->pathtoclass;?>"; //controller Path

    //Submitting the form//                                            
    $("#btn_submit").click(function(){
        var formid=$(this).attr("search");	
        $("#frm_search_"+formid).attr("action","<?php echo $search_action;?>");
        $("#frm_search_"+formid).submit(); 
    });                                              
    //Submitting the form//

    //Submitting the form2//
    $("#frm_search_2").submit(function(){
        var b_valid = true, s_err="";
        $("#frm_search_2 #div_err_2").hide("slow"); 
        //validating//
        if(!b_valid)
            $("#frm_search_2 #div_err_2").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
        return b_valid;
    });    
    //end Submitting the form2//

    //Submitting search all//
    $("#btn_srchall").click(function(){
        $("#frm_search_3").submit();
    });
    //end Submitting search all//  
    
    $('.ajax').colorbox({maxWidth:'95%', maxHeight:'95%'});   
    
        
     
    
	//Admin change status by ajax//
	$("a[id^='status_img_id_']").click(function(){
		var arr_arg,temp_id,temp_class;
		temp_class=$(this).attr('class');
		temp_id = $(this).attr('id');
		arr_arg = temp_id.split('_');
		var i_status   = (arr_arg[4]=="active")?1:0;
	
		$.ajax({
				type: "POST",
				async: false,
				url: g_controller+'ajax_change_status',
				data: "i_status="+i_status+"&h_id="+arr_arg[3]+"&class="+temp_class,
				success: function(msg){           
					if(msg == "ok")
					{
					   if(i_status)
						{
							$("span[id='status_row_id_"+arr_arg[3]+"']").text("<?php echo addslashes(t('Active')) ?>") ;
							$("span[id='status_row_id_"+arr_arg[3]+"']").addClass("label-success");
							$("#"+temp_id).attr('id','status_img_id_'+arr_arg[3]+'_inactive');
							
							var newId = 'status_img_id_'+arr_arg[3]+'_inactive';
							$("#"+newId).removeClass('glyphicon glyphicon-ban-circle');
							$("#"+newId).addClass('glyphicon glyphicon-ok');
							$("#"+newId).attr('data-toggle','tooltip');
							$("#"+newId).attr('data-placement','bottom');
							$("#"+newId).attr('data-original-title','Make Inactive');
						}
						else
						{
							$("span[id='status_row_id_"+arr_arg[3]+"']").text("<?php echo addslashes(t('Inactive')) ?>");
							$("span[id='status_row_id_"+arr_arg[3]+"']").removeClass("label-success");
							$("span[id='status_row_id_"+arr_arg[3]+"']").addClass("label-warning");
							$("#"+temp_id).attr('id','status_img_id_'+arr_arg[3]+'_active');
							
							var newId = 'status_img_id_'+arr_arg[3]+'_active';
							
							$("#"+newId).removeClass('glyphicon glyphicon-ok');
							$("#"+newId).addClass('glyphicon glyphicon-ban-circle');
							$("#"+newId).attr('data-toggle','tooltip');
							$("#"+newId).attr('data-placement','bottom');
							$("#"+newId).attr('data-original-title','Make Active');
						}
				   }
				}
		   });
	});
	//Admin change status by ajax//
     
});
</script>
<style type="text/css">
a.cnt_link:hover{ text-decoration: underline !important;}
</style>
<div class="row">
    <div class="col-md-12">
        <?php show_all_messages(); ?>
        <div class="box box-info collapsed-box">
			<div class="box-header" data-original-title>
                <i class="fa fa-search"></i>
				<h2 class="box-title"><?php echo addslashes(t("Search"))?></h2>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div>
			</div>
            <div class="box-body">
                <form id="frm_search_2" name="frm_search_2" method="get" action="" >
                <input type="hidden" id="h_search" name="h_search" value="advanced" /> 
                <input type="hidden" name="alphabate_pagination" id="alphabate_pagination" value="<?php echo $alphabate_pagination?>"/>               
                <div class="col-md-3">
                    <div class="form-group">
                        <label><?php echo addslashes(t("First Name"))?></label>

                        <input type="text" name="s_first_name" id="s_first_name" value="<?php echo $s_first_name?>" class="form-control" />
                    </div>
                </div>   
                <div class="col-md-3">
                    <div class="form-group">
                        <label><?php echo addslashes(t("Last Name"))?></label>

                        <input type="text" name="s_last_name" id="s_last_name" value="<?php echo $s_last_name?>" class="form-control" />
                    </div>
                </div>   
                <div class="col-md-3">
                    <div class="form-group">
                        <label><?php echo addslashes(t("User Email"))?></label>

                        <input type="text" name="s_email" id="s_email" value="<?php echo $s_user_email?>" class="form-control" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label><?php echo addslashes(t("User Type"))?></label>
                        <select class="form-control" name="i_user_type" data-rel="chosen" data-placeholder="Select Role">
                            <option value="">Select Role</option>
                            <?php echo makeOption($user_type, $i_user_type)?>
                        </select>
                    </div>
                </div> 
                
                </form> 
                <form class="form-horizontal" id="frm_search_3" name="frm_search_3" method="get" action="<?php echo $search_action ?>" >
                    <input type="hidden" id="h_search" name="h_search" value="" />    
                 </form> 
            </div>
            <div class="box-footer">
                <button type="button" search="2" id="btn_submit" name="btn_submit" class="btn btn-primary"><?php echo addslashes(t("Search"))?></button>

                <button type="button" id="btn_srchall" name="btn_srchall" class="btn btn-warning"><?php echo addslashes(t("Show All"))?></button>
            </div>
        </div>
       <?php  echo $table_view;?>
        <!-- content ends -->
    </div>
</div>
