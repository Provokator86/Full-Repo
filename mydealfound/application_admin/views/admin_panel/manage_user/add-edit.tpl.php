<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 12 June 2014
* Modified By: 
* Modified Date 
* Purpose
*  View For User List Showing
* @package User
* @subpackage Manage User
* @link InfController.php 
* @link My_Controller.php
* @link views/admin_panel/manage_user/
*/
?>

<?php

    /////////Javascript For add edit //////////

?>

<script language="javascript">



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

      $("#frm_add_edit").submit();

	   //check_duplicate();

   }); 

});    

    

//////////Checking Duplicate/////////

/*function check_duplicate(){

    var $this = $("#s_category");

    $this.next().remove("#err_msg");  

	$(".star_err1").remove();

	$(".star_succ1").remove();

	

    if($this.val()!="")

    {

        $.blockUI({ message: 'Checking duplicates.Just a moment please...' });

        $.post(g_controller+"ajax_checkduplicate",

               {"h_id":$("#h_id").val(),

                "h_duplicate_value":$this.val(),

                },

                function(data)

                {

                  if(data!="valid")////invalid 

                  {

                      $this.focus();

                      $('<div id="err_msg" class="star_err1">Duplicate exists.</div>')

                      .insertAfter("#s_category");

                      

                  }

                  else

                  {   

                      $("#frm_add_edit").submit();                 

                  }

                });

    }

    else

    {

         $("#frm_add_edit").submit();  

    }

    



}

  */  

    

///////////Submitting the form/////////

$("#frm_add_edit").submit(function(){
    var b_valid=true;
    var s_err="";
	var reg_address   = /^(http:\/\/|https:\/\/|ftp:\/\/|www.){1}([0-9A-Za-z]+\.)/;
	var website_add   = $("#s_store_url").val();
    $("#div_err").hide("slow");     

	if($.trim($("#s_name").val())=="") 
	{
		s_err +='Please provide name.<br />';
		b_valid=false;
	}
	
    /////////validating//////
    if(!b_valid)
    {
        $.unblockUI();  
        $("#div_err").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
    }
    return b_valid;

});    

///////////end Submitting the form/////////    

    

});    

</script>    

<?php

    ///////// End Javascript For add edit //////////

?>

<div id="right_panel">

<form id="frm_add_edit" name="frm_add_edit" method="post" action="" enctype="multipart/form-data">
<!--<input type="hidden" id="h_mode" name="h_mode" value="<?php echo $posted["h_mode"];?>">-->
<input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>">
<input type="hidden" id="h_s_brand_logo" name="h_s_brand_logo" value="<?php echo $posted["s_store_logo"];?>">
    <h2><?php echo $heading;?></h2>
    <p>&nbsp;</p>
        <div id="div_err">
            <?php
              show_msg("error"); 
              echo validation_errors();
			  //pr($posted);
            ?>
        </div>  

    <div class="left"><!--<input id="btn_save" name="btn_save" type="button" value="Save" title="Click here to save information." /> <input id="btn_cancel" name="btn_cancel" type="button" value="Cancel" title="Click here to cancel saving information and return to previous page."/>--></div>
    <div class="add_edit">
    <? /*****Modify Section Starts*******/?>
    <div>

      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th width="30%" align="left"><h4><?php echo $heading;?></h4></th>
          <th width="60%" align="left">&nbsp;</th>
          <th width="10%">&nbsp;</th>
        </tr>        

		<tr>
          <td>Name *:</td>
          <td>
		  <input id="s_name" name="s_name" value="<?php echo $posted["s_name"];?>" type="text" size="50" />
		  </td>
          <td>&nbsp;</td>
        </tr>        

        <tr>
          <td>Email *:</td>
          <td>
		  <input id="s_email" name="s_email" value="<?php echo $posted["s_email"];?>" type="text" size="50" />
		  </td>
          <td>&nbsp;</td>
        </tr>

        <tr>
          <td>Status:</td>
          <td><select name="i_active" id="i_active">
          <option value="1" <?php if($posted['i_active'] == '1') {echo 'selected="selected"';}?>>Active</option>
          <option value="0" <?php if($posted['i_active'] == '0') {echo 'selected="selected"';}?>>Inactive</option>
          </select></td>
          <td>&nbsp;</td>
        </tr>
      </table>
      </div>

    <? /***** end Modify Section *******/?>    
    </div>
    <div class="left">
    <input id="btn_save" name="btn_save" type="button" value="Save" title="Click here to save information." /> 
    <input id="btn_cancel" name="btn_cancel" type="button" value="Cancel" title="Click here to cancel saving information and return to previous page."/>
    </div>
</form>
</div>