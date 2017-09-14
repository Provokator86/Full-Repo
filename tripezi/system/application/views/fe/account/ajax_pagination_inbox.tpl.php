<script type="text/javascript" src="js/fe/accordion.js"></script>  
<script type="text/javascript">

jQuery(function($){
     $(document).ready(function() {   
           $(".strong li").css("font-weight","bold");
            
     });
})  ;
</script>

<!--tab 1-->
<?php
    if(!empty($message_list))
    {
        foreach($message_list as $val)
        {
            if($val['i_receiver_read']==0)
            {
                $strong   =   'class="strong" onclick="changeReadStatus(\''.encrypt($val['id']).'\',\'receiver\',this);"';
            }
            else
            {
                $strong   =   '';
            }
            ?>

        <div class="menu-head width02">
        <ul <?php echo $strong ;?> >
        <li class="box01">From:</li>
        <li class="box02"><?php echo $val['sender_first_name'].' '.$val['sender_last_name']; ?></strong></li>
        <li class="box03"><?php echo $val['s_subject']; ?></li>
        <li class="box04"><?php echo $val['dt_date_send']; ?></li>
        <li class="box05"><a href="javascript:void(0);" onclick="move_to_trash('<?php echo  encrypt($val['id']); ?>','receiver');"><img src="images/fe/del.png" alt="del"  /></a>
        <?php if($val['e_status']=='Amount paid' && time()<$val['t_booked_to'] )
        {
            ?>
       
            <a href="<?php echo base_url().'write-a-message/'.encrypt($val['i_booking_id']); ?>"><img src="images/fe/reply.png" alt="reply"  class="last-img" /></a>
       <?php
        }
            ?>
        </li>
        </ul>
        <div class="spacer"></div>
        </div>
        <div class="menu-body width02" style="display:none">
        <p>Property Name: <em><?php echo $val['s_property_name']; ?></em></p>
              <p><?php echo $val['s_body']; ?></p>
        </div>
<?php
        }
    }
    else
    {
        echo '<div style="margin-left:5px;"><p>No message found</p></div>' ; 
    } 
?>


<!--tab 1-->
 <div class="page-number">
     <?php echo $page_links; ?>
 </div>