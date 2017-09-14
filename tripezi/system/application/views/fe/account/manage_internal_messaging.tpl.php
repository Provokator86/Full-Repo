<script type="text/javascript">

// start document ready
jQuery(function($) {
$(document).ready(function() {
       /*  $(".send_item").click(function(){
             
               $.ajax({
                            type: "POST",
                            async: false,
                            url: base_url+'account/ajax_pagination_send_item',
                            success: function(msg){
                                $("#message_list").html(msg)  ;
                            }
               });
             
         })  ;     */
    
    });
});

function move_to_trash(msg_id,type)
{
    jQuery(function($){
          $.ajax({
                            type: "POST",
                            async: false,
                            url: base_url+'account/ajax_move_to_trash',
                            data: "msg_id="+msg_id+"&type="+type,
                            success: function(msg){
                                $("#message_list").html(msg)  ;
                            }
               });
  
    });  
    
}

function switchMessage(cur_obj)
{
     jQuery(function($){
         
         if($(cur_obj).hasClass('send_item'))
         {
             $(cur_obj).removeClass('send_item');
             $(cur_obj).addClass('inbox');
             $(cur_obj).html('View Inbox');
               $.ajax({
                            type: "POST",
                            async: false,
                            url: base_url+'account/ajax_pagination_send_item',
                            success: function(msg){
                                $("#message_list").html(msg)  ;
                            }
               });
         }
         else if($(cur_obj).hasClass('inbox'))
         {
             $(cur_obj).removeClass('inbox'); 
             $(cur_obj).addClass('send_item');
             $(cur_obj).html('View Send Items'); 
              $.ajax({
                            type: "POST",
                            async: false,
                            url: base_url+'account/ajax_pagination_inbox',
                            success: function(msg){
                                $("#message_list").html(msg)  ;
                            }
               });
            
         }
        
     });

} // End of  switchMessage

function changeReadStatus(msg_id,type,cur_obj)
{
      $.ajax({
                            type: "POST",
                            async: false,
                            url: base_url+'account/ajax_change_read_status',
                            data: "msg_id="+msg_id+"&type="+type,
                            success: function(msg){
                                if(msg=='ok')
                                {
                                   $(cur_obj).find('li').css('font-weight','normal');
                                   $(cur_obj).removeClass('strong');
                                   $(cur_obj).attr('onclick',''); 
                                }
                                else
                                {
                                    return false;
                                }
                            }
      });
    
}

</script>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="container-box">
<?php include_once(APPPATH."views/fe/common/message.tpl.php"); ?> 
<?php include_once(APPPATH."views/fe/common/account_left_menu.tpl.php"); ?>
	<div class="right-part02">
	  <div class="text-container">
		<div class="inner-box03">
			  <div class="page-name02 margin00"><span>Manage Internal Messaging</span>
			  <a href="javascript:void(0);" class="send_item" onclick="switchMessage(this);">View Send Items</a></div>
			  
			   <div class="spacer">&nbsp;</div>
			  <div id="firstpane">
		
		      <div id="message_list">
                    <?php echo  $message_list ; ?>
              </div>

		</div>
		
		
			  <div class="spacer">&nbsp;</div>
		</div>
	  </div>
	</div>
	<br class="spacer" />
</div>