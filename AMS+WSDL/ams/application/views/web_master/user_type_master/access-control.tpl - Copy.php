<?php
/*********
* Author: Mrinmoy Mondal 
* Date  : 21 June 2013
* Modified By: 
* Modified Date: 
* Purpose:
*  View For Admin country Edit
* @package General
* @subpackage country
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/country/
*/
?>
<?php
    /////////Javascript For List View//////////
?>
<script language="javascript">

$(document).ready(function(){

var g_controller="<?php echo $pathtoclass;?>";//controller Path 
    
$('input[id^="btn_cancel"]').each(function(i){
   $(this).click(function(){      
       window.location.href=g_controller+"show_list";
   }); 
});      
    
$('input[id^="btn_save"]').each(function(i){
   $(this).click(function(){
       
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


////////////Ajax call to update the ststus of user type ///////////

$(".chkbox").click(function(){
//alert($(this).attr('checked'));
var arr = $(this).attr('id').split('_');
var s_controler_name =  $(this).attr('name').replace(/^[a-z]*_[a-z]*_[a-z]*_/,'');

var user_type_id =<?php echo decrypt($posted["h_id"])?> 
$.ajax({
    type: "POST",
    url: g_controller+'ajax_update_user_access',
    data: "i_menu_id="+arr[3]+"&s_action="+arr[2]+"&cur_status="+$(this).attr('checked')+"&i_user_type_id="+user_type_id+"&s_controler_name="+s_controler_name,
    success: function(msg){
        if(msg=="added" || msg =="deleted")
        {
       
        //$("#div_err").html('<div  class="success_massage">'+'User access succesfuly updated'+'</div>').show(1000).delay(500).hide(1000);    
		$("#div_err").html('').show(1000).delay(500).hide(1000);    
        }
        else if(msg=="error")
        {
             $("#div_err").html('<div  class="error_massage">'+'User access failed to updated'+'</div>').show(1000).delay(500).hide(1000);
             
            
        }
        
       
        
        
    }
	   } ); 

});

////////////End Ajax call to update the ststus of user type ///////////  

});   
</script>    
 
<div id="content" class="span10">
			<!-- content starts -->
		
			<?php echo admin_breadcrumb($BREADCRUMB); ?>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> <?php echo $posted["txt_user_type"]?></h2>
						<div class="box-icon">
							<?php /*?><a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a><?php */?>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>
                    
                    <div class="box-content">
						<?php foreach($s_menu as $key=>$value) {?>	
                 
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td align="left" style="color: #369BD7;border:solid 1px;" >
						<strong><?php echo str_replace('_',' ',$value['s_name']);?></strong>&nbsp;
						<span id="expand_collapse_<?php echo $value['s_name']; ?>" >[+]</span>
					 </td>
		 </tr>
		</table>  

                
	 <table id="top_mnu_<?php echo $value['s_name'];?>" style="width:100%;display:none;background-color:#DEDEDE;" border="0" cellspacing="0" cellpadding="0">
		 <tr>
			 <td><strong>Section Name</strong></td>
			 <td><strong>List View</strong></td>
			 <td><strong>Add</strong></td>
			 <td><strong>Edit</strong></td>
			 <td><strong>Delete</strong></td>
			 <td width="16%"><strong>Approve</strong></td>
			 <td width="16%"><strong>Active</strong></td>
		 </tr>
		<?php  //pr($value['s_sub_menu']);
		foreach($value['s_sub_menu'] as $k=>$val)
		{ 
            
			$i_aceess_table_id = $val['id'];
			$s_checked = '';
			//$s_link = str_replace('/','',$val['s_link']) ;
            preg_match('~^([A-Za-z_0-9]*)/~',$val['s_link'],$matches);
            $s_link =   $matches[1];
		
			 if(!empty($val['id'])){ 
			 
			 	$act_arr = array();
			
				 foreach($val['actions'] as $act)
				 {
					$act_arr[] = $act['s_action'];
				 }
				 $arr_action_permit     =   explode(',',$val['s_action_permit']);
			 
			 
			 
		?> 			 
		 <tr>
          <td style="width: 250px;">		 
		  	<?php echo $val['s_name'] ?>
			<input type="hidden" name="txt_controller_<?php echo strtolower($s_link)?>" id="txt_controller_<?=strtolower($s_link)?>" value="<?php echo $i_aceess_table_id ?>"  />
		  </td>
		  
		  <td>		    
		  <input type="checkbox" class="chkbox" name="chk_action_view_<?php echo strtolower($s_link)?>" id="chk_action_view_<?php echo $i_aceess_table_id?>" <?php echo in_array('View List',$act_arr)?"checked=checked":"";  ?> value="1" <?php echo in_array(1,$arr_action_permit)?"disabled":"";?>/>
          </td>
		 
          <td>		
		  <input type="checkbox" class="chkbox" name="chk_action_add_<?php echo strtolower($s_link)?>" id="chk_action_add_<?php echo $i_aceess_table_id?>" <?php echo in_array('Add',$act_arr)?"checked=checked":"";  ?> value="1" <?php echo in_array(2,$arr_action_permit)?"disabled":"";  ?>/>
		  </td>
		  
          <td>		 
		  <input type="checkbox" class="chkbox" name="chk_action_edit_<?php echo strtolower($s_link)?>" id="chk_action_edit_<?php echo $i_aceess_table_id?>" <?php echo in_array('Edit',$act_arr)?"checked=checked":"";  ?> value="1" <?php echo in_array(3,$arr_action_permit)?"disabled":"";  ?>/>
		  </td>
		  
		  <td>		  
		  <input type="checkbox" class="chkbox" name="chk_action_delete_<?php echo strtolower($s_link)?>" id="chk_action_delete_<?php echo $i_aceess_table_id?>" <?php echo in_array('Delete',$act_arr)?"checked=checked":"";  ?> value="1" <?php echo in_array(4,$arr_action_permit)?"disabled":"";  ?>/>
		  </td>
		  
		   <td>		 
		  <input type="checkbox" class="chkbox" name="chk_action_approve_<?php echo strtolower($s_link)?>" id="chk_action_approve_<?php echo $i_aceess_table_id?>" <?php echo in_array('Approve',$act_arr)?"checked=checked":"";  ?> value="1" <?php echo in_array(5,$arr_action_permit)?"disabled":"";  ?>/>
          </td>
		  
		   <td>		 
		  <input type="checkbox" class="chkbox" name="chk_action_active_<?php echo strtolower($s_link)?>" id="chk_action_active_<?php echo $i_aceess_table_id?>" <?php echo in_array('Status',$act_arr)?"checked=checked":"";  ?> value="1" <?php echo in_array(6,$arr_action_permit)?"disabled":"";  ?>/>
          </td>
		  
         </tr>
		<?php } } ?>
    </table>
	
	<?php } ?>            
					</div>
					
				</div><!--/span-->

			</div><!--/row-->		

<!-- content ends -->
</div>