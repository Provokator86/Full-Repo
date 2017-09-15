<?php
	$jsnFeaArr = json_encode(array('id'=>$business[0]['id'])); 
?>
<select name="is_featured" id="is_featured" onchange='call_ajax_status_change_featured("<?=base_url().'admin/business/ajax_change_featured_status'?>",<?=$jsnFeaArr?>,"featured_<?=$business[0]['id']?>",this.value)'>
  <option value="Y" <?=($business[0]['is_featured']=='Y'?'selected':'')?>>Yes</option>
  <option value="N" <?=($business[0]['is_featured']=='N'?'selected':'')?>>No</option>
</select>