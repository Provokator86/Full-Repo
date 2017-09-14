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
		var b_valid=true;
		var s_err="";
	
		$("#frm_search_2 #div_err_2").hide("slow"); 
	
		//validating//
		if(!b_valid)
		{
			$("#frm_search_2 #div_err_2").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
		}    
		return b_valid;
	});    
	//end Submitting the form2//

	//Submitting search all//
	$("#btn_srchall").click(function(){
		$("#frm_search_3").submit();
	});
	//end Submitting search all//     	
	
	
   $("a[id^='btn_view_menu_page_']").each(function(i){
       $(this).click(function(){
            var url= g_controller+'assign_pages/'+$(this).attr("value");
            window.location.href=url;
           // window.open(url,'_blank');
       });
    }); 
    
});
</script>

<?php /* ?>
<div id="content" class="span10">
    <!-- content starts -->
    <?php echo admin_breadcrumb($BREADCRUMB); ?>
    <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header well" data-original-title>
                <h2><i class="icon-edit"></i> <?php echo  addslashes(custom_lang_display("Search Menu"))?></h2>
                <div class="box-icon">
                    
                    <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
            <?php show_all_messages(); ?>
            <form class="form-horizontal" id="frm_search_3" name="frm_search_3" method="post" action="<?php echo $search_action?>" >
                <input type="hidden" id="h_search" name="h_search" value="" />	
             </form>
            
            <form class="form-horizontal" id="frm_search_2" name="frm_search_2" method="post" action="" >
                <input type="hidden" id="h_search" name="h_search" value="advanced" />				
                <fieldset>	
                <div class="searchBox">
                    <div class="searchRow">
                        <div class="searchCell">
                            <div class="searchLabel">
                                <label><?php echo addslashes(custom_lang_display("Name"))?></label>
                            </div>
                            <div>
                                <input type="text" name="s_name" id="s_name" value="<?php echo $s_name?>" />
                            </div>                    
                        </div>                                           
                    </div>
                 </div>                                                         
                <div style="clear:both;"></div>                
                <div class="form-actions">
                  <button type="button" search="2" id="btn_submit" name="btn_submit" class="btn btn-primary"><?php echo  addslashes(custom_lang_display("Search"))?></button>
                 
                  <button type="button" id="btn_srchall" name="btn_srchall" class="btn"><?php echo  addslashes(custom_lang_display("Show All"))?></button>
                </div>
                </fieldset>
            </form>  
            </div>
		</div>
    </div>

 <?php echo $table_view;?><!-- content ends -->
</div>
<?php */ ?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-info collapsed-box">
            <div class="box-header">
                <i class="fa fa-search"></i>
                <h2 class="box-title"><?php echo addslashes(t("Search"))?></h2>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div>                                 
            </div>
            
    
            <div class="box-body">
                <?php show_all_messages(); ?>
                <form class="form-horizontal" id="frm_search_3" name="frm_search_3" method="get" action="<?php echo $search_action?>" >
                    <input type="hidden" id="h_search" name="h_search" value="" />    
                </form>
        
                <form class="" id="frm_search_2" name="frm_search_2" method="get" action="" >
                    <input type="hidden" id="h_search" name="h_search" value="advanced" />        
                    <div id="div_err_2"></div>        
                    <div class="row">
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class=""><?php echo addslashes(t("Name"))?></label>
                                <input type="text" name="s_name" id="s_name" value="<?php echo $s_name?>" class="form-control" />
                            </div>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <button type="button" search="2" id="btn_submit" name="btn_submit" class="btn btn-primary"><?php echo addslashes(t("Search"))?></button>                 
                        <button type="button" id="btn_srchall" name="btn_srchall" class="btn btn-warning"><?php echo addslashes(t("Show All"))?></button>
                    </div>
                </form>
            </div>   
                
        </div>

        <?php echo $table_view;?><!-- content ends -->
    </div>
</div>

