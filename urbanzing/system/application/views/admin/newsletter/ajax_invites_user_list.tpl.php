<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr align="left"  bgcolor="#cccccc">
	<td width="35%" align="left" class="text1" valign="top" style="color:#000000;">Selected user </td>
	<td width="65%"  valign="middle" class="text1">
		<select style="height: auto; width: 180px;" id="user_id" name="user_id[]" multiple class="textbox" size="10" >
		<?
		foreach($ck	as $k=>$v)
		{
		?>
				 <option value="<?=$v?>" selected><?=$v?></option>
				
		<?
		}
		?>
		</select>
	</td>
</tr>
</table>
