<?php
  /*********
* Author: 
* Date  : 
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For user Admin
* 
* @package User Admin
* @subpackage user admin
* 
* @link InfController.php 
* @link My_Controller.php
* @link Controler/admin/user_admin/
*/



?>

<script type="text/javascript" language="javascript" >

//jQuery.noConflict();///$ can be used by other prototype which is not jquery

jQuery(function($) {

$(document).ready(function(){


$("#tab_search").tabs({

   cache: true,

   collapsible: true,

   fx: { "height": 'toggle', "duration": 500 },

   show: function(clicked,show){ 

        $("#btn_submit").attr("search",$(show.tab).attr("id"));

        $("#tabbar ul li a").each(function(i){

           $(this).attr("class","");

        });

        $(show.tab).attr("class","select");

   }

});



$("#tab_search ul").each(function(i){

    $(this).removeClass("ui-widget-header");

    $("#tab_search").removeClass("ui-widget-content");

});





//////////end Clicking the tabbed search/////                                              

           




 




                                                                         

})});   

</script>

<div id="right_panel">

    <h2><?php echo $heading;?></h2>
		<div class="info_box">From here admin can view all the advertisement and edit them.</div>
   <?php

    echo $table_view;

    ?>

  </div>