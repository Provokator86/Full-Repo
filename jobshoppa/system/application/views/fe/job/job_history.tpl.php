<?php /*?><link href="css/fe/style.css" rel="stylesheet" type="text/css" media="screen" /><?php */?>
<div class="lightbox1" style="display:block">
   <!-- <div class="close"><a href="javascript:void(0)" onclick="onClosed()"><img src="images/fe/close.png" alt="" /></a></div>-->
    <div class="top">&nbsp;</div>
    <div class="mid">
        <div class="title">
            <h5><span>History</span> - <?php echo $history_details[0]['s_title']?></h5>
        </div>
		 <?php
		  if($history_details)
		  {
			foreach($history_details as $val)
			{
		  ?>		
        <p class="big_txt14"><?php echo $val['msg_string']?></p>
		<?php
			}
		 }	
		?>
    </div>
    <div class="bot">&nbsp;</div>
</div>
