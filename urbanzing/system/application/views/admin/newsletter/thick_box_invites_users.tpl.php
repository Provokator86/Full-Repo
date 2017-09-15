<script>

$('form#frm_invite').ajaxForm({
	beforeSubmit: before_ajaxform_addimage_modify,
	success:      after_ajaxform_addimage_modify
});
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</table>
<form name="frm_invite" id="frm_invite" method="post" action="<?=base_url().'admin/newsletter/import_users_mail'?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<?php
	 if($inites_users)
	 {
	 	foreach($inites_users as $value){
	?>
		<div class="box_01"><input type="checkbox" name="chk[]" value="<?=$value['invited_email']?>" checked="checked">
		<?=$value['invited_email']?></div>
	<?php } } else  echo 'No data available';?>	
	</td>
  </tr>
  <tr>
  <td style="padding-top:10px; text-align:center"><input type="submit" name="submit" value="Submit"></td>
  </tr>
  
</table>

</form>
<style>
	.box_01 { width:190px; float: left; margin-left:10px; height:20px; margin-top:10px;}
</style>
