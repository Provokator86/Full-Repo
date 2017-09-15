<?php
    /////////Javascript For List View//////////
?>
<script language="javascript">
var g_controller;

jQuery.noConflict();///$ can be used by other prototype which is not jquery
jQuery(function($) {
$(document).ready(function(){

g_controller="<?php echo $s_controller_name;?>";//controller Path

/****************Access Control Logic****************************/

////Click Delete ////
$("input[id^='btn_del_']").each(function(i){
   $(this).click(function(){

       ////////Confirm///// 
       $("#dialog-confirm #dialog_msg").html('<strong>These items will be permanently removed and cannot be recovered.</strong> Are you sure?');       
       $("#dialog-confirm").dialog({
            resizable: false,
            height:240,
            width:350,
            modal: true,
            title: "Removal Confirmation?",
            buttons: {
                'Delete': function() {
                    $(this).dialog('close');
                    $.blockUI({ message: 'Just a moment please...' });
                    $("#h_list").attr("value",$("#dd_list_"+i).find("option:selected").attr("value"));
                    $("#frm_list").attr("action",g_controller+'remove_information/');
                    $("#frm_list").submit();
                },
                Cancel: function() {
                    $("#h_list").attr("value","");
                    $(this).dialog('close');
                }
            }
        });
       ////////end Confirm/////

   }); 
});    
////end Click Delete ////    

// Click Status Update
////Click Delete ////
$("input[id^='btn_status_']").each(function(i){
   $(this).click(function(){

       ////////Confirm///// 
       $("#dialog-confirm #dialog_msg").html('Are you sure?');       
       $("#dialog-confirm").dialog({
            resizable: false,
            height:240,
            width:350,
            modal: true,
            title: "Confirmation?",
            buttons: {
                'Update': function() {
                    $(this).dialog('close');
                    $.blockUI({ message: 'Just a moment please...' });
                    $("#h_list").attr("value",$("#dd_list_"+i).find("option:selected").attr("value"));
					$("#h_status").attr("value",'<?php echo encrypt(2)?>');
                    $("#frm_list").attr("action",g_controller+'change_status/');
                    $("#frm_list").submit();
                },
                Cancel: function() {
                    $("#h_list").attr("value","");
                    $(this).dialog('close');
                }
            }
        });
       ////////end Confirm/////

   }); 
});    
////end Click Delete ////    


////Click Delete ////
$("input[id^='btn_status_app_']").each(function(i){
   $(this).click(function(){

       ////////Confirm///// 
       $("#dialog-confirm #dialog_msg").html('Are you sure?');       
       $("#dialog-confirm").dialog({
            resizable: false,
            height:240,
            width:350,
            modal: true,
            title: "Confirmation?",
            buttons: {
                'Update': function() {
                    $(this).dialog('close');
                    $.blockUI({ message: 'Just a moment please...' });
                    $("#h_list").attr("value",$("#dd_list_"+i).find("option:selected").attr("value"));
					$("#h_status").attr("value",'<?php echo encrypt(1)?>');
                    $("#frm_list").attr("action",g_controller+'change_status/');
                    $("#frm_list").submit();
                },
                Cancel: function() {
                    $("#h_list").attr("value","");
                    $(this).dialog('close');
                }
            }
        });
       ////////end Confirm/////

   }); 
});    
////end Click Delete ////   
// Click Status Update

/////Click Edit////
$("a[id^='btn_edit_']").each(function(i){
   $(this).click(function(){
        var url=g_controller+'modify_information/'+$(this).attr("value");
        window.location.href=url;
   }); 
});
/////end Click Edit////

///Remove Top Add Button
$("input[id^='btn_top_add_']").remove();

/////Click Add////
$("input[id^='btn_add_']").each(function(i){
   //$(this).attr("title","Add new information.")     
   $(this).click(function(){

        var url=g_controller+'add_information';
        window.location.href=url;
   }); 
});
/////end Click Add////
/****************end Access Control Logic****************************/

////////Selecting dd_list_//////////
$("select[id^='dd_list_']").each(function(i){
   $(this).change(function(){
       var s_optv=$(this).find("option:selected").attr("value");
       switch(s_optv)
       {
           case "page":
            $("#chk_all").attr("checked",true); 
            chk_dechk_multi(true);
           break;
           case "":
            $("#chk_all").attr("checked",false); 
            chk_dechk_multi(false);
           break;           
           default:
           break;
       }
   }); 
});
////////end Selecting dd_list_//////////

////////Selecting chk_del_//////////
/**
* Selecting the dd_list_  w.r.t chk_del_
*/
$("input:checkbox[id^='chk_del_']").each(function(i){
   $(this).change(function(){
      if($(this).attr("checked"))
      {
        $("select[id^='dd_list_']").each(function(m){
          
           $(this).find("option").each(function(k){
              if($(this).attr("value")=="selected") 
              {
                  $(this).attr("selected",true);
              }
           });
           
        });          
      } 
      else
      {
        var b_chkatleast=false;
        $("input[id^='chk_del_']").each(function(i){
           if($(this).is(":checked"))
           {
               b_chkatleast=true;
           }
        });
        if(!b_chkatleast)       
        {
            $("select[id^='dd_list_']").each(function(m){
              
               $(this).find("option").each(function(k){
                  if($(this).attr("value")=="") 
                  {
                      $(this).attr("selected",true);
                  }
               });
               
            });             
        }     
      }
   });
});
////////end Selecting chk_del_//////////

////////checking all//////////
$("#chk_all").click(function(){
    //alert($(this).is(":checked"));
    if($(this).is(":checked"))
    {
        /*$("input[id^='chk_del_']").each(function(i){
           $(this).attr("checked",true); 
        });*/       
        chk_dechk_multi(true);
    } 
    else
    {
        //alert($(this).attr("checked"));
        /*$("input[id^='chk_del_']").each(function(i){
           $(this).attr("checked",false); 
        });*/        
        chk_dechk_multi(false);
    }
});
////////end checking all//////////    

/////////Check or decheck all checkboxed/////
function chk_dechk_multi(chk)
{
    $("input[id^='chk_del_']").each(function(i){
       $(this).attr("checked",chk); 
    });      
}
/////////end Check or decheck all checkboxed/////
    
///////////Submitting the form/////////
$("#frm_list").submit(function(){
    var b_valid=true;
    var s_err="";
    $("#div_err").hide("slow");  
    
    var b_chkatleast=false;
    $("input[id^='chk_del_']").each(function(i){
       if($(this).is(":checked"))
       {
           b_chkatleast=true;
       }
    });     

    if(!b_chkatleast)
    {
        s_err+='<div id="err_msg" class="error_massage">Please select atleast one record to delete.</div>';
        b_valid=false;
    }
    
    <?php /////selecting All Records to be removed//////?>
    var s_sel_dd=$("select[id^='dd_list_']").find("option[value='all']:selected").attr("value");
    if(s_sel_dd=="all")
    {
        b_valid=true;
    }   
    <?php /////end selecting All Records to be removed//////?>     
    
    
    /////////validating//////
    if(!b_valid)
    {
        $.unblockUI(); 
        $("#div_err").html(s_err).show("slow");
    }
    
    return b_valid;
});    
///////////end Submitting the form/////////    
    
////////Popup Details Page///////
$("[id^='disp_det_']").each(function(i){
    
    $(this).click(function(){
        var tmp=JSON.parse('<?php echo makeArrayJs($headers[0]);?>');
        var pop_w=(tmp["popup_width"]?"width="+tmp["popup_width"]:"");
        var pop_h=(tmp["popup_height"]?"height="+tmp["popup_height"]:"");
        
        $.prettyPhoto.open(g_controller+'show_detail/'+$(this).attr("value")+'/iframe'
                           +(pop_w!=""||pop_h!=""?"?"+pop_w+"&"+pop_h:"")
                            ,'<?php echo $caption;?>');  
    });
    
});
////////end Popup Details Page///////    

   ////////Popup History Page///////
$("[id^='disp_his_']").each(function(i){
    
    $(this).click(function(){
        var tmp=JSON.parse('<?php echo makeArrayJs($headers[0]);?>');
        var pop_w=(tmp["popup_width"]?"width="+tmp["popup_width"]:"");
        var pop_h=(tmp["popup_height"]?"height="+tmp["popup_height"]:"");
        
        $.prettyPhoto.open(g_controller+'show_history/'+$(this).attr("value")+'/iframe'
                           +(pop_w!=""||pop_h!=""?"?"+pop_w+"&"+pop_h:"")
                            ,'<?php echo $caption;?>');  
    });
    
});
////////end Popup Details Page///////    

    
})});    
</script>    
 
<?php
  /////////end Javascript For List View//////////  

//////////Removing Controls as per access rights/////////
    /////Removing Add////
//	var_dump($controllers_selected);exit;
    $i_action_add=$controllers_selected["action_add"];
    $i_action_edit=$controllers_selected["action_edit"];
    $i_action_delete=$controllers_selected["action_delete"];
    /////end Removing Add////

//////////end Removing Controls as per access rights/////////  
  
?> 
       <form id="frm_list" action="" method="post">
       <input type="hidden" id="h_list" name="h_list"> 
	   <?php if($status_update) { ?>
	   <input type="hidden" id="h_status" name="h_status"> 
	   <?php } ?>
       <input type="hidden" id="h_pageno" name="h_pageno" value="<?php echo $i_pageno;?>">
       
       <div id="accountlist">
       <?php /*?> <h2><?php echo $caption;?> List</h2><?php */?>
        <div id="div_err">
            <?php
              show_msg();  
            ?>
        </div>
        <div class="clr"></div>        
        <div class="top">
        <?php
             if($i_action_delete)///Access Control for delete
             {
                 echo '<div class="left">
                    <select id="dd_list_0" name="dd_list">
                      <option value="selected">Select</option>
                      <option value="page">This Page</option>
                      <!--option value="all">All Records</option-->
                      <option value="">None</option>
                    </select>
                    </div>
                    <div class="left" style="padding-left:10px;"><input id="btn_del_0" name="btn_del" type="button" value="Delete" title="To remove information click here." /></div>';
             }        
			if($status_update) // Access Control for status update
			{
				
				 echo '<div class="left" style="padding-left:10px;">
                   <input id="btn_status_app_0" name="btn_status_app" type="button" value="Approve" title="Click here to approve job." />
                    </div>
                    <div class="left" style="padding-left:10px;"><input id="btn_status_0" name="btn_status" type="button" value="Reject" title="Click here to reject job." /></div>';
			}
             if($i_action_add)///Access Control for insert
             {
                 echo '<div class="right"><input id="btn_add_0" name="btn_add" type="button" value="Insert Record" title="To add new information click here." /></div>';
             } 
             ?>
            
            <div class="right">
                <ul class="pagination">
                    <?php
                    echo $pagination;
                   ?>   
              </ul>
            </div>
        </div>
        <div class="mid">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
				<?php
						 if($i_action_delete)///Access Control for delete
						 {
						 ?>		
                <th width="3%" align="left">
						  		
							<input name="chk_all" id="chk_all" type="checkbox" value="1" title="To select all information below. Click and check here." />
						 
				</th>
				 <?php
						  }/// end of i_action_delete
						 ?>
				<?php
              ////////////////Looping the headers//////////
              foreach($headers as $k=>$head)
              {
			  	$head_val = ucfirst($head["val"]);
				$arr_sort = isset($head["sort"])?$head["sort"]:"";
				$image = "";
				/*
					The following block is used to create sorting link for the header element of whose "sort" value is set.
					The sort array contain the following values.
					array("field_name" => Field name to sort
					 )
				
				*/
				if(is_array($arr_sort) )
				{
					$image = ($order_name == $arr_sort['field_name']  && $order_by=='asc')? '<img src="images/admin/shorting_up.png" />':(( $order_name == $arr_sort['field_name']  && $order_by=='desc')? '<img src="images/admin/shorting_down.png" />':'');
					$orderby = (($order_name == $arr_sort['field_name'] &&$order_by=='asc') ? 'desc' : 'asc');
					$label = (($order_name == $arr_sort['field_name']) ? "<strong>$head_val</strong>" : "$head_val");
					$head_val = "<a class='grey_link' href='".$src_action.'/'.$arr_sort['field_name'].'/'.$orderby."'>".$label."</a>";
				}
              ?>
                <th  width="<?php echo $head["width"];?>" align="<?php echo ($head["align"]?$head["align"]:"left");?>">
					<strong><?php echo $head_val;?> <?php echo $image;?></strong>
				</th>
              <?php
              }
              unset($k,$head);              
              /*
              ?>
              
                <th align="left"><input name="" type="checkbox" value="" /></th>
                <th align="left"><strong>Account Name</strong></th>
                <th align="left"><strong>City</strong></th>
                <th align="left"><strong>Phone</strong></th>
                <th align="left"><strong>User</strong></th>
                <th align="center">&nbsp;</th>
              <?php
              */
              ////////////////end Looping the headers//////////
              if($i_action_edit)///Access Control for edit
              {
                echo '<th width="3%" align="left" >'.($action_header?$action_header:"Edit").'</th>';        
              }                    
              ?>
              </tr>
              <?php
              ///////////////////////Looping the Rows and Columns For Displaying the result/////////
              if(!empty($tablerows))
              {
                  $s_temp="";
                  foreach($tablerows as $k=>$row)
                  {                   
                      
                      $s_temp="<tr>";///Starting drawing the row
                      
                      foreach($row as $c=>$col)
                      {
                          
                          switch($c)
                          {
                              case 0:
                               
									 if($i_action_delete)///Access Control for delete
									 {
									  $s_temp.='<td>';	
									  $s_temp.='<input id="chk_del_'.$k.'" name="chk_del[]" type="checkbox" value="'.$row[0].'" />';						
									   $s_temp.='</td>';
									 } // end of  i_action_delete
								//  	$s_temp.='<a href="javascript:void(0);" id="disp_det_0_'.$row[0].'" value="'.$row[0].'"> <img src="images/admin/info_inline.gif" alt="" width="12" height="12" /></a>';
							 
							  
                                /*
                                $s_popuplink=$s_controller_name.'show_detail/'.$row[0].'?iframe=true'
                                            .($headers[0]["popup_width"]?"&width=".$headers[0]["popup_width"]:"")
                                            .($headers[0]["popup_height"]?"&height=".$headers[0]["popup_height"]:"");
                                
                                $s_temp.='<td><input id="chk_del_'.$k.'" name="chk_del[]" type="checkbox" value="'.$row[0].'" /> <a href="'.$s_popuplink.'" id="disp_det_0_'.$row[0].'" value="'.$row[0].'" rel="prettyPhoto[iframes]" title="'.$caption.'"><img src="images/admin/info_inline.gif" alt="" width="12" height="12" /></a></td>';
                                */
                              break;
                              case 1:
							  	$view = ($detail_view===FALSE)?FALSE:TRUE;
							  	if($view)
								{
                                	$s_temp.= '<td><a href="javascript:void(0);" id="disp_det_1_'.$row[0].'" value="'.$row[0].'" >'.$col.'</a></td>';
								}
								else
								{
									$s_temp.= '<td>'.$col.'</td>';
								}
                              break;
                              default:
                                $s_temp.= '<td align="'.($headers[$c-1]["align"]?$headers[$c-1]["align"]:"left").'" >'.$col.'</td>';
                                
                              break;
                          }
                      }///end for
                      
                     if($i_action_edit)///Access Control for edit
                     {
					 	
                      $s_temp.='<td align="left" ><a href="javascript:void(0);" id="btn_edit_'.$k.'" value="'.$row[0].'" ><img src="images/admin/edit_inline.gif" title="Edit" alt="Edit" width="12" height="12" /></a></td>';
                     }
                      
                      $s_temp.= "</tr>";    
                      echo $s_temp;
                  }///end for  
                  unset($s_temp,$k,$row,$c,$col);
              }
              else///empty Row
              {
                  echo '<tr><td id="td_no_record_found" colspan="'.(count($headers)+2).'">No information found.</td></tr>';
              }
              ///////////////////////end Looping the Rows and Columns For Displaying the result/////////
              ?>
            </table>
            <div class="clr"></div>
        </div>
        <div class="bot">
            <?php
             if($i_action_delete)///Access Control for delete
             {
                 echo '<div class="left">
                    <select id="dd_list_1" name="dd_list">
                      <option value="selected">Select</option>
                      <option value="page">This Page</option>
                      <!--option value="all">All Records</option-->
                      <option value="">None</option>
                    </select>
                    </div>
                    <div class="left" style="padding-left:10px;"><input id="btn_del_1" name="btn_del" type="button" value="Delete" title="To remove information click here." /></div>';
             } 
             if($status_update) // Access Control for status update
			{
				 echo '<div class="left" style="padding-left:10px;"><input id="btn_status_app_1" name="btn_status_app" type="button" value="Approve" title="Click here to approve job." />
                    </div>
                    <div class="left" style="padding-left:10px;"><input id="btn_status_1" name="btn_status" type="button" value="Reject" title="To update status click here." /></div>';
			}
             if($i_action_add)///Access Control for insert
             {
                 echo '<div class="right"><input id="btn_add_1" name="btn_add" type="button" value="Insert Record" title="To add new information click here."/></div>';
             } 
             ?>            
            <div class="right">
                <ul class="pagination">
                    <?php
                    echo $pagination;
                   ?> 
              </ul>
            </div>
        </div>
    </div>
    </form>
    
