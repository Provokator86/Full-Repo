<script>

$('form#frm_invite').ajaxForm({
	beforeSubmit: before_ajaxform_addemail_modify,
	success:      after_ajaxform_addemail_modify
});

function before_ajaxform_addemail_modify(){
	//UiBlock();
	
}

function after_ajaxform_addemail_modify(responseText, statusText, xhr, $form) {
   var all_mails = ($('#invites').val()) ? $('#invites').val()+','+responseText:responseText
   $('#invites').val(all_mails);
   tb_remove();
}	
</script>


<div class="box01">
<?
if(isset($rows) && isset($rows[0]))
{
    $str1   = $str2 = '';
    foreach($rows as $k=>$v)
    {
//        if($k%2==0)
//        {
            $str1   .= '<tr>
                <td>'.$v['f_name'].'</td>
                <td>'.$v['email'].'</td>
            </tr>';
//        }
//        else
//        {
//            $str2   .= '<tr>
//                <td>'.$v['f_name'].'</td>
//                <td>'.$v['email'].'</td>
//            </tr>';
//        }
    }
}

?>
	<form name="frm_invite"  id="frm_invite" method="post" action="<?=base_url().'party/get_imported_users'?>">
    <div class="address_div" style="max-height: 500px;overflow: auto;width: 600px;">
        <table width="100%" cellpadding="0" cellspacing="4" border="0">
          <?
			if(isset($rows) && isset($rows[0]))
			{
		 ?>	
			<tr>
                            <td style="font-weight: bold; "><input checked type="checkbox" name="allContact" id="allContact" value="ALL" onClick="checkAll('allContact','sel_users')">&nbsp;&nbsp;Name</td>
                <td style="font-weight: bold;">E-mail</td>
            </tr>
			<?php
				$str1   = $str2 = '';
				foreach($rows as $k=>$v)
				{
			?>
						<tr>
							<td width="30%"><input type="checkbox" name="sel_users[]" id="sel_users" value="<?=$v['email']?>" checked="checked" />&nbsp;&nbsp;<?=$v['f_name']?></td>
							<td><?=$v['email']?></td>
						</tr>
			<?php			
				}
			?>
			<tr>
				<td colspan="2" style="text-align:center; padding-top:10px;">
				<input type="submit" name="submit" value="Submit">
				</td>
			</tr>
		<?php } else {?>	
			<tr>
				<td colspan="2" style="text-align:center; padding-top:10px;">
					You have not added any data in your address book yet.
				</td>
			</tr>			
		<?php } ?>
        </table>
    </div>
	</form>

    <div class="clear"></div>
</div>