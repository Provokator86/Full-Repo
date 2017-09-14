<script language="javascript">

$(document).ready(function(){

var g_controller="<?php echo $pathtoclass;?>";//controller Path 
 

    
$('input[id^="btn_submit"]').each(function(i){
   $(this).click(function(){
       $("#reply_frm").submit();
   }); 
});    


///////////Submitting the form/////////
$("#reply_frm").submit(function(){
    var b_valid=true;
    var s_err="";
    //$("#div_err").hide("slow"); 

    
	 if($.trim($("#txt_comment").val())=="") 
		{
		   s_err +='<div class="error_massage"><strong>Please provide comment.</strong></div>';
			b_valid=false;
		}	
    /////////validating//////
     if(!b_valid)
    {
       // $.unblockUI();  
        $("#div_err").html(s_err).show("slow");
    }
    
    return b_valid;
});    
///////////end Submitting the form/////////   

})
//});
</script>

<div id="banner_section">
    <?php
	include_once(APPPATH."views/fe/common/header_top.tpl.php");
	?>
</div>
<!-- /BANNER SECTION -->
<!-- SERVICES SECTION -->
    <?php
	include_once(APPPATH."views/fe/common/common_buyer_search.tpl.php");
	?>
<!-- /SERVICES SECTION -->
<!-- CONTENT SECTION -->
<div id="content_section">
    <div id="content">
		<div id="div_err">
             <?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>   
                     <?php
                        //show_msg("error");  
                        echo validation_errors();
                        //pr($posted);
                    ?>
        </div>
		
        <div id="inner_container02">
            <div class="title">
                <h3><span>Private </span> Message Board</h3>
            </div>
            <div class="clr"></div>
            <!--<h6>&quot; From here you can view all the messages from professionals regarding your job(s). &quot;</h6>-->
            <div class="clr"></div>
            <div id="account_container">
                <div class="account_left_panel">
                    <div class="round_container">
                        <div class="top">&nbsp;</div>
                        <div class="mid" style="min-height:878px;">
						<form name="reply_frm" id="reply_frm" action="<?php echo base_url().'private_message/private_message_details/all__'.encrypt($msg_id);?>" method="post">
                            <div id="form_box01">
                                <textarea cols="105" name="txt_comment" id="txt_comment" rows="4"></textarea>
                                <div class="clr"></div>
                                <p>&nbsp;</p>
                                <input type="submit" name="submit" id="btn_submit" value="Submit" />
                            </div>
						</form>	
							
							 <?php
									if($pmb_details){
											
											foreach($pmb_details as $val)
										{ //echo $val['dt_reply_on'];
										$arr	=	explode('-',$val['dt_reply_on']);
										$date	=	date('M d',mktime(0,0,0,$arr[0],$arr[1],$arr[2]));
																
							?>
                            <div class="job_box">
                                <p class="left"><span class="blue_txt"><?php echo $val['s_sender_name'] ?> </span> to <?php echo $val['s_receiver_name'] ?></p>
                                <p class="grey_txt12 right">Posted on : <?php echo $val['dt_reply_on'] ?></p>
                                <div class="clr"></div>
                               <?php /*?> <p><?php echo $val['s_receiver_name'] ?>,</p>
                                <p>&nbsp;</p><?php */?>
                                <p><?php echo $val['s_content'] ?></p>
                                <p>&nbsp;</p>
                               <?php /*?> <p>Thanks</p>
                                <p><?php echo $val['s_sender_name'] ?></p>
                                <p>&nbsp;</p><?php */?>
                            </div>                            
                             <?php }
									 } else {
										echo '<div class="job_box " style="padding:5px;">No record found</div>';
									} 
							 ?>    
                            
                            
                            <div class="clr"></div>
                            <div class="paging_box" style="padding:5px 0;">
							<?php echo $pagination;?>
                               <!-- <ul>                                    
                                    <li><a href="javascript:void(0)" class="select">1</a></li>
                                    <li><a href="javascript:void(0)">2</a></li>
                                    <li><a href="javascript:void(0)">3</a></li>
                                    <li><a href="javascript:void(0)">4</a></li>
                                    <li><a href="javascript:void(0)">5</a></li>
                                    <li><span><a href="javascript:void(0)"><img src="../images/next.png" alt="" /></a></span></li>
                                </ul>-->
                            </div>
                            <div class="clr"></div>
                        </div>
                        <div class="bot">&nbsp;</div>
                    </div>
                </div>
                 <?php
					include_once(APPPATH."views/fe/common/buyer_left_menu.tpl.php");
				?>
            </div>
            <div class="clr"></div>
        </div>
        <div class="clr"></div>
    </div>
    <div class="clr"></div>
</div>