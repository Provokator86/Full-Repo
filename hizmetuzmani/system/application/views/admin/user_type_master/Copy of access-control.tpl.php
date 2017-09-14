<?php
    /////////Javascript For List View//////////
?>
<script language="javascript">
jQuery.noConflict();///$ can be used by other prototype which is not jquery
jQuery(function($) {
$(document).ready(function(){

var g_controller="<?php echo $pathtoclass;?>";//controller Path 
    
$('input[id^="btn_cancel"]').each(function(i){
   $(this).click(function(){
       $.blockUI({ message: 'Just a moment please...' });
       window.location.href=g_controller+"show_list";
   }); 
});      
    
$('input[id^="btn_save"]').each(function(i){
   $(this).click(function(){
       $.blockUI({ message: 'Just a moment please...' });
       //check_duplicate();
	   $("#frm_add_edit").submit();
   }); 
}); 

///////////Submitting the form/////////
$("#frm_add_edit").submit(function(){
    var b_valid=true;
    var s_err="";
    $("#div_err").hide("slow"); 
    /////////validating//////
    if(!b_valid)
    {
        $.unblockUI();  
		 $("#div_err").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
    }
    return b_valid;
});    
///////////end Submitting the form/////////   


////////////Expand Collapse with icon [+] [-]/////////////
$("span[id^='expand_collapse_']").each(function(i){
   $(this).css({"cursor":"hand","cursor":"pointer"});
   var s_controller=$(this).attr("id").replace("expand_collapse_","");

   $(this).click(function(){
       var b_collapse=($(this).text().match('[/+]')=="+"?false:true);
       var $next=$("#top_mnu_"+s_controller).next();
       var targetOffset = $(this).offset().top;

       //////////collapse the content//////
       if(b_collapse)///collapse
       {
           $(this).text("[+]");
           /*$("#top_mnu_"+s_controller).stop(true,true).animate(
                                                          {height:"toggle",opacity: 'toggle'}
                                                          , {
                                                            duration: 5000, 
                                                            specialEasing: {
                                                              height: 'easeOutBounce'
                                                            }}
                                                          /*,1000
                                                          ,'slide'* /  
                                                      );*/    
                                                      
           $("#top_mnu_"+s_controller).stop(true,true).effect("slide",
                                                            {"direction":"up","mode":"hide"}
                                                            ,1000);            
       }
       else/////expand
       {
           $(this).text("[-]");
           /*$("#top_mnu_"+s_controller).stop(true,true).animate(
                                                          {height:"toggle",opacity: 'toggle'}
                                                          ,1000
                                                          ,'linear'  
                                                      ); */        
                                                      
           $("#top_mnu_"+s_controller).stop(true,true).effect("slide",
                                                            {"direction":"up","mode":"show"}
                                                            ,1000);                                                                                                    
       }
       //////////end collapse the content//////
   }); 
   
   ///////Expanding the container if add or edit or delete is checked////////
   if($("#top_mnu_"+s_controller).find("[id^='chk_action']").is(":checked"))
   {
       $(this).click();       
   }
   ///////end Expanding the container if add or edit or delete is checked////////
   
});
////////////end Expand Collapse with icon [+] [-]/////////////

})});   
</script>    
 

<div id="right_panel">
<form id="frm_add_edit" name="frm_add_edit" method="post" action="">
<input type="hidden" id="h_mode" name="h_mode" value="<?php echo $posted["h_mode"];?>">
<input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
    <h2><?php echo $heading;?></h2>
    <p>&nbsp;</p>
        <div id="div_err">
            <?php
              show_msg("error");  
              echo validation_errors();
            ?>
        </div>     
    
    
    <div class="left"><input id="btn_save" name="btn_save" type="button" value="Save" title="Click here to save information." /> <input id="btn_cancel" name="btn_cancel" type="button" value="Cancel" title="Click here to cancel saving information and return to previous page."/></div>
    <div class="add_edit">
    <? /*****Modify Section Starts*******/?>
    <div>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" >
       <tr>
          <td width="26%">User type:</td>
          <td width="17%" nowrap="nowrap"><?=$posted["txt_user_type"]?></td>
          <td width="15%">&nbsp;</td>
          <td width="42%">&nbsp;</td>
        </tr>
	   </table>
		<?php
        $tmp_top_mnu="";
        $i_aceess_table_id  = '';
        $s_checked = '';
        $i_total=count($controller_array);
        $i_counter=0;
		if($i_total>0)
		{
            
		 foreach($controller_array as $key=>$value )
		 {
             ///////////Grouping the controllers w.r.t top_menu name////
             if($tmp_top_mnu!=$value["top_menu"])
             {
                 /**
                 * Replacing all spaces with "_" from 
                 * $value["top_menu"] for html ids 
                 * ex- $value["top_menu"] ="MIS Report"
                 * then <span id="expand_collapse_MIS Report" > 
                 * will be <span id="expand_collapse_MIS_Report" > 
                 */
                 
                 $top_menu_for_id=str_replace(" ","_",$value["top_menu"]);
                 
                 $toptr= '<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>';
                 $toptr.='<td align="left" style="color: blue;border:solid 1px;" >
                            <strong>'.$value["top_menu"].'</strong>&nbsp;
                            <span id="expand_collapse_'.$top_menu_for_id.'" >[+]</span>
                         </td>';
                 $toptr.='</tr></table>';       
                          
                 ///////////putting the entire sub-menus under the top-menu-table///////  
                 if($i_counter>0)
                 {
                     $tr= '</table>';///closing the previously opened table for sub-menus///
                 }
                 else
                 {
                     $tr="";
                 }

                 ///opening a new table for sub-menus///
                 $tr.=$toptr;
                 $tr.='<table id="top_mnu_'.$top_menu_for_id.'" style="width:100%;display:none;background-color:gray;" border="0" cellspacing="0" cellpadding="0">';
                 $tr.='<tr>';
                 $tr.='   <td><strong>Section Name</strong></td>';
                 $tr.='   <td><strong>Add</strong></td>';
                 $tr.='   <td><strong>Edit</strong></td>';
                 $tr.='   <td><strong>Delete</strong></td>';
                 $tr.='</tr>';                     
                 ///end opening a new table for sub-menus///
                 echo $tr;
                 ///////////end putting the entire sub-menus under the top-menu-table///////                 
                 $tmp_top_mnu=$value["top_menu"];
                 unset($tr,$toptr);
             }
             ///////////end Grouping the controllers w.r.t top_menu name////
		  ?>
		 <tr>
          <td style="width: 400px;">
		  <?=$value['label']?>
		  <?php
				$i_aceess_table_id  = '';
				if(array_key_exists($key,$access_info))
					$i_aceess_table_id = $access_info[$key]['id'];
		  ?>
			<input type="hidden" name="txt_controller_<?=strtolower($key)?>" id="txt_controller_<?=strtolower($key)?>" value="<?=$i_aceess_table_id ?>"  />
		  </td>
          <td>
		  <?php
				$s_checked = '';
				if(array_key_exists($key,$access_info) && $access_info[$key]['i_action_add'] == 1)
					$s_checked = 'checked="checked"';
		  ?>
		  <input type="checkbox" name="chk_action_add_<?=strtolower($key)?>" id="chk_action_add_<?=strtolower($key)?>" <?=$s_checked?> value="1" />			          </td>
          <td>
		  <?php
				$s_checked = '';
				if(array_key_exists($key,$access_info) && $access_info[$key]['i_action_edit'] == 1)
					$s_checked = 'checked="checked"';
		  ?>
		  <input type="checkbox" name="chk_action_edit_<?=strtolower($key)?>" id="chk_action_edit_<?=strtolower($key)?>" <?=$s_checked?> value="1" />			          </td>
		  <td>
		   <?php
				$s_checked = '';
				if(array_key_exists($key,$access_info) && $access_info[$key]['i_action_delete'] == 1)
					$s_checked = 'checked="checked"';
		  ?>
		  <input type="checkbox" name="chk_action_delete_<?=strtolower($key)?>" id="chk_action_delete_<?=strtolower($key)?>" <?=$s_checked?> value="1" />			          </td>
         </tr>
		  
		 <?php
            $i_counter++;
            ///closing the last opened table for sub-menus///
            if($i_counter==$i_total)
            {
                echo '</table>';
            }
            ///end closing the last opened table for sub-menus///
		 }////end for
         unset($key,$value);
		}////end if
        unset($tmp_top_mnu,$i_aceess_table_id,$s_checked,$i_total,$i_counter);
		 ?>
		
	
      </table>
      </div>
    <? /*****end Modify Section*******/?>      
    </div>
    <div class="left"><input id="btn_save" name="btn_save" type="button" value="Save" title="Click here to save information." /> <input id="btn_cancel" name="btn_cancel" type="button" value="Cancel" title="Click here to cancel saving information and return to previous page."/></div>
    
</form>
</div>