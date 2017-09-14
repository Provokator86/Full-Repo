<?php 

if(!empty($store_list))
{

	$temp_alpha	=	'';

	foreach($store_list as $val)
	{

		if($temp_alpha!=$val['alpha'])
		{ 
			if($val['deal_count']>1)
				$number_txt	= ' deals and coupons found';
			else
				$number_txt	= ' deal and coupon found';

			if($temp_alpha!='')

				echo '<div class="clear"></div></ul></div>';

	?>

    		<div class="clear"></div>	

    		<div class="store_list_al"><span class="store_alp"><a href="<?php echo base_url().$val['s_url']?>"><?php echo $val['alpha'];?></a></span>

            <span class="back_to_top"><a href="javascript:"><img src="<?php echo base_url()?>images/back_to_top_blue.png" alt="top"></a></span>

            <div class="clear"></div>						

            <ul class="stores">

            <li>
            	<ul>
                	<li><table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
	<tr>
		<td align="center" valign="middle" height="100%"><a href="<?php echo base_url().$val['s_url']?>"><img src="<?php echo base_url()?>uploaded/store/<?php echo $val['s_store_logo']?>" alt="top"></a></td>
	</tr>
</table></li>
                   <?php /*?> <li><a href="<?php echo base_url().$val['s_url']?>"><?php echo ($val['deal_count']>0)?$val['deal_count'].$number_txt:''?> </a></li><?php */?>
				    <li>
						<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
							<tr>
							<td align="center" valign="middle" height="100%">
							<?php 
								$arr = array();
								if($val["deal_count"]>0) $arr[] = '<a href="'.base_url('products/'.$val['s_url']).'">View Products</a>';
								if($val["offers_count"]>0) $arr[] = '<a href="'.base_url('top-offers/'.$val['s_url']).'">View Offers</a>';
								echo @implode('&nbsp;|&nbsp;',$arr);	
							
							
							 ?>
							<?php /*?><a href="<?php echo base_url().$val['s_url']?>">View Offers</a>&nbsp;|&nbsp;
							<a href="<?php echo base_url().$val['s_url']?>">View Products</a><?php */?>
							</td>
							</tr>
						</table>
					</li>
                    <li><table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
	<tr>
		<td align="center" valign="middle" height="100%"><a href="<?php echo base_url().$val['s_url']?>"><?php echo ($val['s_cash_back']!='')?$val['s_cash_back']:''?></a></td>
	</tr>
</table></li>
                    <li><table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
	<tr>
		<td align="center" valign="middle" height="100%"><a href="<?php echo base_url().$val['s_url']?>"><img src="<?php echo base_url()?>images/view_details.png" alt="top"></a></td>
	</tr>
</table></li>
                </ul>
            </li>

	   <?php
       	}
		else
		{
			if($val['deal_count']>1)
				$number_txt	= ' deals and coupons found';
			else
				$number_txt	= ' deal and coupon found';
			?>

			<li>
            	<ul>
                	<li><table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
	<tr>
		<td align="center" valign="middle" height="100%"><a href="<?php echo base_url().$val['s_url']?>"><img src="<?php echo base_url()?>uploaded/store/<?php echo $val['s_store_logo']?>" alt="top"></a></td>
	</tr>
</table>
</li>
                  
				   <li><table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
	<tr>
		<td align="center" valign="middle" height="100%">
		<?php 
			$arr1 = array();
			if($val["deal_count"]>0) $arr1[] = '<a href="'.base_url('products/'.$val['s_url']).'">View Products</a>';
			if($val["offers_count"]>0) $arr1[] = '<a href="'.base_url('top-offers/'.$val['s_url']).'">View Offers</a>';
			echo @implode('&nbsp;|&nbsp;',$arr1);	
		
		
		 ?>
		<?php /*?><a href="<?php echo base_url().$val['s_url']?>">View Offers</a>&nbsp;|&nbsp;
		<a href="<?php echo base_url().$val['s_url']?>">View Products</a><?php */?>
		
		</td>
	</tr>
</table></li>
                    <li><table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
	<tr>
		<td align="center" valign="middle" height="100%">
		<a href="<?php echo base_url().$val['s_url']?>"><?php echo ($val['s_cash_back']!='')?$val['s_cash_back']:''?></a></td>
	</tr>
</table></li>
                    <li><table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
	<tr>
		<td align="center" valign="middle" height="100%"><a href="<?php echo base_url().$val['s_url']?>"><img src="<?php echo base_url()?>images/view_details.png" alt="top"></a></td>
	</tr>
</table></li>
                </ul>
            </li>
            
            <?php
		}		

		$temp_alpha	=	$val['alpha'];
	}

	echo '<div class="clear"></div></ul></div>';

}

else

{ ?>

 		<div class="clear"></div>	

    		<span class="store_alp"></span>

            <span class="back_to_top"></span>

            <div class="clear"></div>						

            <ul class="stores">

            <p><?php echo "No result"?></p>	
            
            </ul>

<?php }

?>

 

