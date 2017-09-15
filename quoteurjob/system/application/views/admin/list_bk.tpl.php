<?php

    /////////Javascript For List View//////////

?>

<script language="javascript">

jQuery.noConflict();///$ can be used by other prototype which is not jquery

jQuery(function($) {

$(document).ready(function(){



var g_controller="<?php echo $s_controller_name;?>";//controller Path

//controller Path to product_image .Added by Jagannath Samanta on 22 June 2011
var g_controller_pro_img="<?php echo $s_controller_name_pro_img;?>";



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

/////Click Edit////

$("a[id^='btn_edit_']").each(function(i){

   $(this).click(function(){

        var url=g_controller+'modify_information/'+$(this).attr("value");

        window.location.href=url;

   }); 

});
/////end Click Edit////


/*
+----------------------------------------------------+
| Purpose :: Forwording to product_image module      |
+----------------------------------------------------+
| Added by Jagannath Samanta on date 22 June 2011    |
+----------------------------------------------------+
*/
$("a[id^='btn_img_']").each(function(i){
   $(this).click(function(){
        var url=g_controller_pro_img+'show_list/'+$(this).attr("value");
        window.location.href=url;

   }); 

});



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
		  
		  case "all":
          
		  $("#chk_all").attr("checked",true); 

          chk_dechk_multi(true);

           break;         

           default:

           break;

       }

   }); 

});

////////end Selecting dd_list_//////////

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

        

        $.prettyPhoto.open(g_controller+'show_detail/'+$(this).attr("value")+'/iframe','<?php echo $caption;?>');  

    });

    

});





////////end Popup Details Page///////    

    

})});    

</script>    

 

<?php

  /////////end Javascript For List View//////////  

?> 

       <form id="frm_list" action="" method="post">

       <input type="hidden" id="h_list" name="h_list"> 

       <input type="hidden" id="h_pageno" name="h_pageno" value="<?php echo $i_pageno;?>">

       

       <div id="accountlist">

        <h2><?php echo $caption;?> List</h2>

        <div id="div_err">

            <?php

              show_msg();  

            ?>

        </div>

        <div class="clr"></div>        
		<?php if(!$no_action) 
			{	
		 ?>
        <div class="top">

            <div class="left">

            <select id="dd_list_0" name="dd_list">

              <option value="selected">Select</option>

              <option value="page">This Page</option>

              <option value="all">All Records</option>

              <option value="">None</option>

            </select>

            </div>

            <div class="left" style="padding-left:10px;"><input id="btn_del_0" name="btn_del" type="button" value="Delete" title="To remove information click here." /></div>

            <div class="right"><input id="btn_add_0" name="btn_add" type="button" value="Insert Record" title="To add new information click here." /></div>

            <div class="right">

                <ul class="pagination">

                    <?php

                    echo $pagination;

                       /* 

                    ?>

                    <li class="previous-off">&laquo;Previous</li>

                      <li class="active">1</li>

                      <li><a href="">2</a></li>

                      <li><a href="">3</a></li>

                      <li><a href="">4</a></li>

                      <li><a href="">5</a></li>

                      <li><a href="">6</a></li>

                      <li><a href="">7</a></li>

                      <li class="next"><a href="">Next&raquo;</a></li>

                   <?php

                   */

                   ?>   

              </ul>

            </div>

        </div>
		
		<?php } ?>

        <div class="mid">

            <table width="100%" border="0" cellspacing="0" cellpadding="0">

              <tr>
					
				<?php if(!$no_action) 
				{	
			 ?>
                <th width="5%" align="left">
				<input name="chk_all" id="chk_all" type="checkbox" value="1" title="To select all information below. Click and check here." /></th>
				<?php } else { ?>
				<th width="5%" align="left">&nbsp;</th>
				<?php } ?>

              <?php

              ////////////////Looping the headers//////////

              foreach($headers as $k=>$head)

              {

              ?>

                <th width="<?php echo $head["width"];?>" align="<?php echo ($head["align"]?$head["align"]:"left");?>"><strong><?php echo ucfirst($head["val"]);?></strong></th>

              <?php

              }

              unset($k,$head);

              /*

              ?>

              

                <th width="5%" align="left"><input name="" type="checkbox" value="" /></th>

                <th width="35%" align="left"><strong>Account Name</strong></th>

                <th width="20%" align="left"><strong>City</strong></th>

                <th width="20%" align="left"><strong>Phone</strong></th>

                <th width="15%" align="left"><strong>User</strong></th>

                <th width="5%" align="center">&nbsp;</th>

              <?php

              */

              ////////////////end Looping the headers//////////

              ?>            

                <th width="5%" align="left">&nbsp;</th>    

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
								 if(!$no_action) 
								{	
			
                                $s_temp.='<td nowrap="nowrap" ><input id="chk_del_'.$k.'" name="chk_del[]" type="checkbox" value="'.$row[0].'" /> <a href="javascript:void(0);" id="disp_det_0_'.$row[0].'" value="'.$row[0].'"><img src="images/admin/info_inline.gif" alt="" width="12" height="12" /></a></td>';
							   }
							   else
							   {
								  $s_temp.='<td><a href="javascript:void(0);" id="disp_det_0_'.$row[0].'" value="'.$row[0].'"><img src="images/admin/info_inline.gif" alt="" width="12" height="12" /></a></td>';
								  }

                              break;

                              case 1:

                                $s_temp.= '<td><a href="javascript:void(0);" id="disp_det_1_'.$row[0].'" value="'.$row[0].'" >'.$col.'</a></td>';
								
                              break;
							  
							  case 10: /* This case is added by Jagannath Samanta on 22 June 2011. Note :: Don't change the value 10 */
										
									$s_temp.='<td><a href="javascript:void(0);" id="btn_img_'.$k.'" value="'.$row[0].'"
									 alt="Product Image"><img src="images/admin/edit_inline.gif" 
									 alt="Product Image" title="Product Image List" width="12" height="12" /></a></td>';
							  	
							  break;
							  
                              default:

                                $s_temp.= '<td>'.$col.'</td>';
								
                              break;

                          }

                      }///end for

                      $s_temp.='<td align="center"><a href="javascript:void(0);" id="btn_edit_'.$k.'" value="'.$row[0].'" alt="Edit Information"><img src="images/admin/edit_inline.gif" alt="Edit" width="12" height="12" /></a></td>';

                      $s_temp.= "</tr>";    

                      echo $s_temp;

                  }///end for  

                  unset($s_temp,$k,$row,$c,$col);

              }

              else///empty Row

              {

                  echo '<tr ><td colspan="'.count($headers).'" width="100%">No information found.</td></tr>';

              }

              ///////////////////////end Looping the Rows and Columns For Displaying the result/////////

              /*

              ?>



              <tr>

                <td><input name="input5" type="checkbox" value="" /> <a href="#"><img src="images/admin/info_inline.gif" alt="" width="12" height="12" /></a></td>

                <td><a href="#">ABC GmbH</a></td>

                <td>Hamburg</td>

                <td>+49 40 56789123 </td>

                <td>Alexadmin</td>

                <td align="center"><a href="add-edit.html"><img src="images/admin/edit_inline.gif" alt="" width="12" height="12" /></a></td>

              </tr>

              <tr>

                <td><input name="input5" type="checkbox" value="" /> <a href="#"><img src="images/admin/info_inline.gif" alt="" width="12" height="12" /></a></td>

                <td><a href="#">ABC GmbH</a></td>

                <td>Hamburg</td>

                <td>+49 40 56789123 </td>

                <td>Alexadmin</td>

                <td align="center"><a href="add-edit.html"><img src="images/admin/edit_inline.gif" alt="" width="12" height="12" /></a></td>

              </tr>

              <tr>

                <td><input name="input5" type="checkbox" value="" /> <a href="#"><img src="images/admin/info_inline.gif" alt="" width="12" height="12" /></a></td>

                <td><a href="#">ABC GmbH</a></td>

                <td>Hamburg</td>

                <td>+49 40 56789123 </td>

                <td>Alexadmin</td>

                <td align="center"><a href="add-edit.html"><img src="images/admin/edit_inline.gif" alt="" width="12" height="12" /></a></td>

              </tr>

              <tr>

                <td><input name="input5" type="checkbox" value="" /> <a href="#"><img src="images/admin/info_inline.gif" alt="" width="12" height="12" /></a></td>

                <td><a href="#">ABC GmbH</a></td>

                <td>Hamburg</td>

                <td>+49 40 56789123 </td>

                <td>Alexadmin</td>

                <td align="center"><a href="add-edit.html"><img src="images/admin/edit_inline.gif" alt="" width="12" height="12" /></a></td>

              </tr>

              <tr>

                <td><input name="input5" type="checkbox" value="" /> <a href="#"><img src="images/admin/info_inline.gif" alt="" width="12" height="12" /></a></td>

                <td><a href="#">ABC GmbH</a></td>

                <td>Hamburg</td>

                <td>+49 40 56789123 </td>

                <td>Alexadmin</td>

                <td align="center"><a href="add-edit.html"><img src="images/admin/edit_inline.gif" alt="" width="12" height="12" /></a></td>

              </tr>

              <tr>

                <td><input name="input5" type="checkbox" value="" /> <a href="#"><img src="images/admin/info_inline.gif" alt="" width="12" height="12" /></a></td>

                <td><a href="#">ABC GmbH</a></td>

                <td>Hamburg</td>

                <td>+49 40 56789123 </td>

                <td>Alexadmin</td>

                <td align="center"><a href="add-edit.html"><img src="images/admin/edit_inline.gif" alt="" width="12" height="12" /></a></td>

              </tr>

              <?php

              */

              ?>

            </table>

            <div class="clr"></div>

        </div>
	<?php if(!$no_action) 
			{	
		 ?>
        <div class="bot">

            <div class="left">

            <select id="dd_list_1" name="dd_list">

              <option value="selected">Select</option>

              <option value="page">This Page</option>

              <option value="all">All Records</option>

              <option value="">None</option>

            </select>

            </div>

            <div class="left" style="padding-left:10px;"><input id="btn_del_1" name="btn_del" type="button" value="Delete" title="To remove information click here." /></div>

            <div class="right"><input id="btn_add_1" name="btn_add" type="button" value="Insert Record" title="To add new information click here."/></div>

            <div class="right">

                <ul class="pagination">

                    <?php

                    echo $pagination;

                       /* 

                    ?>

                    <li class="previous-off">&laquo;Previous</li>

                      <li class="active">1</li>

                      <li><a href="">2</a></li>

                      <li><a href="">3</a></li>

                      <li><a href="">4</a></li>

                      <li><a href="">5</a></li>

                      <li><a href="">6</a></li>

                      <li><a href="">7</a></li>

                      <li class="next"><a href="">Next&raquo;</a></li>

                   <?php

                   */

                   ?> 

              </ul>

            </div>

        </div>
		
	<?php
		}
		?>

    </div>

    </form>

    

