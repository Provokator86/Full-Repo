<div class="lightbox_all" style="display:block;">
    <!--<div class="close"><a href="javascript:void(0)" onclick="hide_dialog()"><img src="images/fe/close.png" alt="" /></a></div>-->
    <div class="top">&nbsp;</div>
    <div class="mid">
        <div class="title">
            <h3><span><?php echo $title_pre; ?></span><?php echo $title_next; ?></h3>
        </div>
		 <div class="clr"></div>
        <div class="content_box" style="overflow-y:auto; height:450px;" >
              <?php 
			  if($contents)
			  {
			   ?>
                    <p><?php echo $contents[0]['s_full_description'] ?></p>
              <?php 
			 }?>
        </div>
		 <div class="clr"></div>
    </div>
    <div class="bot">&nbsp;</div>
</div>