<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>pdf</title>
</head>
<body>	
<?php
	$font_style =  "font-family: Arial,' sans-serif'; font-size:11pt;";
	$cnt_no = 0;
	
?>
<table width="800" border="0" cellspacing="0" cellpadding="0" align="left">
	<?php 
	 
	$i = 0;
	while($i < count($page_arr)) {

	$ansArr = array($page_arr[$i]['s_option1'], $page_arr[$i]['s_option2'], $page_arr[$i]['s_option3'], $page_arr[$i]['s_option4']);
	shuffle($ansArr);
	?>
<tr nobr="true">

<td>
	<table width="400" border="0" cellspacing="0" cellpadding="2">
			<tbody>
				<tr >
					<td valign="top" width="30" style="<?php echo $font_style; ?>"><strong><?php echo ++$cnt_no; ?></strong></td>
					<td style="<?php echo $font_style; ?>"><?php echo $page_arr[$i]['s_question']; ?></td>
				</tr>
				
				<tr>
					<td>&nbsp;</td>
					<td style="<?php echo $font_style; ?>">(A)&nbsp;<?php echo $ansArr[0]; ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td style="<?php echo $font_style; ?>">(B)&nbsp;<?php echo $ansArr[1]; ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td style="<?php echo $font_style; ?>">(C)&nbsp;<?php echo $ansArr[2]; ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td style="<?php echo $font_style; ?>">(D)&nbsp;<?php echo $ansArr[3]; ?></td>
				</tr>
			</tbody>
	</table>
</td>

<td width="20">	</td>
<?php
$i++;
$ansArr = array($page_arr[$i]['s_option1'], $page_arr[$i]['s_option2'], $page_arr[$i]['s_option3'], $page_arr[$i]['s_option4']);
shuffle($ansArr);
?>	
<td>
	<?php if($page_arr[$i]['s_question']!= '') { ?>
	<table width="400" border="0" cellspacing="0" cellpadding="2">
		<tbody>		
			
			<tr>
				<td valign="top" width="30" style="<?php echo $font_style; ?>"><strong><?php echo ++$cnt_no; ?></strong></td>
				<td style="<?php echo $font_style; ?>"><?php echo $page_arr[$i]['s_question']; ?></td>
			</tr>
				
				<tr>
					<td>&nbsp;</td>
					<td style="<?php echo $font_style; ?>">(A)&nbsp;<?php echo $ansArr[0]; ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td style="<?php echo $font_style; ?>">(B)&nbsp;<?php echo $ansArr[1]; ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td style="<?php echo $font_style; ?>">(C)&nbsp;<?php echo $ansArr[2]; ?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td style="<?php echo $font_style; ?>">(D)&nbsp;<?php echo $ansArr[3]; ?></td>
				</tr>
		</tbody>

	</table>
	<?php } ?>
</td>


</tr>

<tr>
<td height="20"></td>
<td></td>
<td></td>
</tr>
<?php //$cnt_no = $cnt_no +1; 
$i++;
} ?>

</table>

<?php //} ?>
</body>
</html>
