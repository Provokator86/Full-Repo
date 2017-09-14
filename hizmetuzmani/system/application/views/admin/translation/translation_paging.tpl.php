<?php
	  			
	  			if( is_array($languages) && count($languages) ) :
				?>
				<form method="post" action="" id="translation_form" name="translation_form">
				<table class="translations" cellpadding="5" cellspacing="1">
				<tbody>
				<tr class="top">
				<th class="width02">Original Text</th>
				<?php
					foreach($languages as $language) :
				?>
					<th><?=$language?></th>
				<?php
					endforeach;
				?>
				</tr>
	
				<?php
					$i = 0;
					foreach($translations as $id=>$translation) :
				?>
					<tr>
						<td align="center"><div class="icon"><a href="#" title="This will show up in the tooltip" class="masterTooltip"></a><img src="<?php echo base_url()?>images/admin/question.png" class="masterTooltip" title="<?php echo $id;?>" /></div></td>
						<?php
							foreach($languages as $key=>$language) :
						?>
							<td>
							
							<textarea name="text_<?=$i.'_'.$key?>" rows="3" style="background-color:#e4e2e2;border:1px solid #d4cfcf;min-width:100%; margin-bottom:5px;"><?=(isset($translation[$key]))?$translation[$key]:''?></textarea>
							
							
							</td>
						<?php
							endforeach;
						?>
					</tr>
						<input type="hidden" name="tuid_<?=$i?>" value="<?=base64_encode($id)?>" />
				<?php
					$i++;
					endforeach;
				?>
					<tr>
						<td colspan="<?=count($languages)?>" style="height:30px;;">
						<input type="hidden" name="counter" value="<?=$i?>" />
						<input name="submit_translations" type="button" value="Submit" onclick="submit_translation('translation_form')" />
						<input type="hidden" name="page_submitted" id="page_submitted" value="1" />
						</td>
					</tr>
				</tbody>
				</table>
				</form>
				<?php
					endif;
				?>
				
		<div class="right">
           <ul class="pagination">
				<?php
					echo $pagination;
			    ?> 
           </ul>
        </div>	
		
<script type="text/javascript">

jQuery(document).ready(function() {
        
});


function submit_translation(frmid)
{	
	var frm_data	= jQuery('#'+frmid).serialize();
	
	jQuery.ajax({
			type: 'POST',
			url : '<?php echo admin_base_url()?>language_home/translation_submit/',
			data: frm_data,
			//dataType: 'json',
			
			/*success: function(msg)
			{
				document.getElementById('translation_box').innerHTML=msg;
			}*/			
	});
}

</script>	