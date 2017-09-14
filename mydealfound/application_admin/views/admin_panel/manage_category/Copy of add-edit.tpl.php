<?php

/*********

* Author:Mrinmoy Mondal

* Date  : 19 Jan 2013

* Modified By: 

* Modified Date:

* Purpose:

*  View For book category Add & Edit

* @package General

* @subpackage book category

* @link InfController.php 

* @link My_Controller.php

* @link views/admin/book_category/

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

    $("#div_err").hide("slow"); 

    

	if($.trim($("#s_category").val())=="") 

	{

		s_err +='Please provide category name.<br />';

		b_valid=false;

	}

	

	/*if($.trim($("#s_image").val())=="" && $.trim($("#h_s_image").val())=="") 

	{

		s_err += 'Please provide image.<br />';

		b_valid = false;

	}*/

    

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

    <h2><?php echo $heading;?></h2>

    <p>&nbsp;</p>

        <div id="div_err">

            <?php

              show_msg("error");  

              echo validation_errors();

			/*  pr($posted);*/

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

          <td>Category Name *:</td>

          <td><input id="s_category" name="s_category" value="<?php echo $posted["s_category"];?>" type="text" size="50" /></td>

          <td>&nbsp;</td>

        </tr>          

        <tr>

          <td>Active:</td>

          <td><input id="i_status" name="i_status" value="1" <?php if($posted["i_status"]==1) { echo 'checked="checked"';}?>  type="checkbox" /></td>

          <td>&nbsp;</td>

        </tr>        

        <tr>

          <td>Meta Title :</td>

          <td><input id="s_meta_title" name="s_meta_title" value="<?php echo $posted["s_meta_title"];?>" type="text" size="50" /></td>

          <td>&nbsp;</td>

        </tr>

        <tr>

          <td>Meta Description :</td>

          <td>

          <textarea rows="5" cols="45" name="s_meta_description" id="s_meta_description"><?php echo $posted["s_meta_description"];?></textarea>

          </td>

          <td>&nbsp;</td>

        </tr>

        <tr>

          <td>Meta Keyword :</td>

          <td><input id="s_meta_keyword" name="s_meta_keyword" value="<?php echo $posted["s_meta_keyword"];?>" type="text" size="50" /></td>

          <td>&nbsp;</td>

        </tr>

         <tr>

          <td>Parent Category :</td>

          <td>

            <select name="i_parent_id" id="i_parent_id" style="width:280px">

                  <option value="0" >Select A Category</option>

                  <?php 

                  foreach ($category as $value):?>

                      <option value="<?php echo $value['i_id']?>"  <?php if($posted['i_parent_id']==$value['i_id']) echo 'selected="selected"'?>><?php echo $value['s_category']?></option>                

                  <?php endforeach; ?>

            </select>

          </td>

          <td>&nbsp;</td>

        </tr>

        

        <tr>

          <td>Image  :<span style="color:red; font-family:Arial, Helvetica, sans-serif"><b>(Please upload images of minimum dimension 300x350 for best view)</b></span></td>

          	<td>

			<?php

			if($posted["s_image"] !="")

			{

			?>

			<span id="user_image">

				<img src="uploaded/category/right_image/right_image_<?php echo $posted["s_image"];?>" />

				<!--<span  style="height:50px; cursor:pointer;"><img src="images/admin/err.jpg" id="cross" alt="" /></span>--><br/>

				<input id="h_s_image" name="h_s_image"  type="hidden" value="<?php echo $posted["s_image"];?>" />

			</span>

			<?php }?>

			<input id="s_image" name="s_image"  type="file" /></td>

          	<td>&nbsp;</td>

        </tr>

        

        <tr>

          <td>Thumb  :<span style="color:red; font-family:Arial, Helvetica, sans-serif"><b>(Please upload images of minimum dimension 20x20 for best view)</b></span></td>

          	<td>

			<?php

			if($posted["s_thumb"] !="")

			{

			?>

			<span id="user_image">

                            <img src="uploaded/category/thumb/thumb_<?php echo $posted["s_thumb"];?>" />

                            <!--<span  style="height:50px; cursor:pointer;"><img src="images/admin/err.jpg" id="cross" alt="" /></span>--><br/>

                            <input id="h_s_thumb" name="h_s_thumb"  type="hidden" value="<?php echo $posted["s_thumb"];?>" />

			</span>

			<?php }?>

			<input id="s_thumb" name="s_thumb"  type="file" /></td>

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