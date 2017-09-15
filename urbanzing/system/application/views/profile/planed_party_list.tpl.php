<style type="text/css">
	.edit_activity { width:25%; float:right; text-align:left; font-size:12px; color:#273D3B}
	.edit_activity a { color:#273D3B; text-decoration:none;}
	.edit_activity a:hover { text-decoration:underline;}
</style>

<?php
if(isset($rows) && !empty($rows))
{
	foreach($rows as $k => $v)
	{
		$style = '';
		if($k % 2 == 0)
			$style = ' style="background:#f3f3f3;"';
?>
<div class="box02"<?php echo $style?>>
	<div style="width: 75%; float: left;">
	<h4><a href="<?=base_url().'party/party_details/'.$v['id']?>" style="color:#F8891A;"><?php echo $v['event_title']?></a></h4>
		<p>
			<?php echo date('l, dS, F Y', $v['start_date']); ?><br/>
			<?php echo date('G:i a', $v['start_date']);?>
			<?php //echo date('h-i-s');?>
			
		</p>
		<div class="margin15"></div>
		<p><?php echo $v['message']?></p>
	</div>
	<div class="edit_activity">
		<a href="<?php echo $v['edit_link'];?>"  style="text-decoration:underline;color:#FF0000">
		<?php if( (time() + 28800 ) < $v['start_date']):?> Edit <?php endif;?></a>&nbsp;
		<?php if( (time() + 28800 ) < $v['start_date']):?> |<?php endif;?> &nbsp;
		<strong>Status:</strong> <?php echo $v['text_status']; ?>
	</div>
</div>
<?php
	}
}
?>
