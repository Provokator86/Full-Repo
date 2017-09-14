
<?php // pr($store_list);?>
<?php /*
<span class="store_alp"><a href="#"><?php // echo 'A';?></a></span>
<span class="back_to_top"><a href="#"><img src="<?php echo base_url()?>images/fe/back_to_top.png" alt="top"></a></span>
<div class="clear"></div>						
<ul class="stores">
<li><a href="#"></a></li>
</ul>
*/
?>
<?php 
if(!empty($store_list))
{
	$temp_alpha	=	'';
	foreach($store_list as $val)
	{
		if($temp_alpha!=$val['alpha'])
		{ 
			if($temp_alpha!='')
				echo '</ul>';
	?>
    		 <div class="clear"></div>	
    		<span class="store_alp"><a href="#"><?php echo $val['alpha'];?></a></span>
            <span class="back_to_top"><a href="javascript:"><img src="<?php echo base_url()?>images/fe/back_to_top.png" alt="top"></a></span>
            <div class="clear"></div>						
            <ul class="stores">
            <li><a href="<?php echo base_url()?><?php echo $val['s_url']?>-coupons"><?php echo $val['s_store_title']; ?></a></li>
	   <?php
       	}
		else
		{
			?>
			<li><a href="<?php echo base_url()?><?php echo $val['s_url']?>-coupons"><?php echo $val['s_store_title']; ?></a></li>
            <?php
		}
		
		$temp_alpha	=	$val['alpha'];
		 
		
	}
	echo '</ul>';
}
else
{ ?>
 <div class="clear"></div>	
    		<span class="store_alp"></span>
            <span class="back_to_top"></span>
            <div class="clear"></div>						
            <ul class="stores">
            <p><?php echo "No result"?></p>	
<?php }
?>
 
