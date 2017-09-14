<?php
/*********
* Author: Acumen CS
* Date  : 03 Feb 2014
* Modified By: 
* Modified Date: 
* Purpose:
*  View For Admin category management Edit
* @package General
* @subpackage category
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/category_management/
*/
?>
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
		var b_valid=true, s_err = "";
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
});
</script>
<div id="content" class="span10">
	<!-- content starts -->
	<?php echo admin_breadcrumb($BREADCRUMB); ?>
    <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header well" data-original-title>
                <h2><i class="icon-edit"></i> <?php echo addslashes(t("Search"))?></h2>
                <div class="box-icon">
                    <?php /*?><a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a><?php */?>
                    <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
            	<?php show_all_messages(); ?>
                <form class="form-horizontal" id="frm_search_3" name="frm_search_3" method="post" action="<?php echo $search_action ?>" >
                    <input type="hidden" id="h_search" name="h_search" value="" />	
                 </form>
                
                    <form class="form-horizontal" id="frm_search_2" name="frm_search_2" method="post" action="" >
                        <input type="hidden" id="h_search" name="h_search" value="advanced" />				
                        <fieldset>	
                        <div class="searchBox">
                            <div class="searchRow">
                                <div class="searchCell">
                                    <div class="searchLabel">
                                        <label><?php echo addslashes(t("Category"))?></label>
                                    </div>
                                    <div>
                                        <input type="text" name="s_category" id="s_category" value="<?php echo $s_category?>" />
                                    </div>                    
                                </div> 
                                <div class="searchCell">
                                    <div class="searchLabel">
                                        <label><?php echo addslashes(t("Parent Category"))?></label>
                                    </div>
                                    <div>
                                        <select name="opt_parent_cat" id="opt_parent_cat" data-placeholder="<?php echo addslashes(t('Select'))?>" data-rel="chosen"><option value=""><?php echo addslashes(t('Select'))?></option>
                                        <?php echo getOptionCategory('', '', '', '1', $opt_parent_cat,2);?>
                                        </select>
                                    </div>                    
                                </div>                   
                            </div>
                         </div>                                                         
                        <div style="clear:both;"></div>                
                        <div class="form-actions">
                          <button type="button" search="2" id="btn_submit" name="btn_submit" class="btn btn-primary"><?php echo addslashes(t("Search"))?></button>
                          <button type="button" id="btn_srchall" name="btn_srchall" class="btn"><?php echo addslashes(t("Show All"))?></button>
                    </div>
                    </fieldset>
                </form>  
            </div>
		</div>
	</div>
	<?php echo $table_view;?>
    <!-- content ends -->
</div>

