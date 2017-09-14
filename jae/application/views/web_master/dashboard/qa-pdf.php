<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>pdf</title>
</head>
<body>
<?php
	$font_style =  "font-family: Arial,' sans-serif'; font-size:10pt; width:250px;";
	
	$page_arr = array_chunk($qa_res, 10);
	//pr($page_arr); exit;
	
	$cnt_no = 1;
	//$page_arr = array_merge($page_arr, $page_arr, $page_arr);
	for($i=0; $i < count($page_arr); $i++) { 
		
		$column_arr = array_chunk($page_arr[$i], 5);
		
		$lt_column = $column_arr[0];
		$rt_column = $column_arr[1];
	
?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
		<tr>
			<?php 
			if(!empty($lt_column)) {
			?>
			<td>	
				<!-- FIRST TABLE -->
				<table width="99%" border="0" cellspacing="0" cellpadding="0" align="left">
					
					<tbody>
						<?php 
						foreach($lt_column as $lk => $lv){ 
							$ansArr = array($lv['s_option1'], $lv['s_option2'], $lv['s_option3'], $lv['s_option4']);
							shuffle($ansArr);
						?>
						<tr nobr="true">
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="5">
									<tbody>
										<tr>
											<td valign="top" align="right" width="25" style="<?php echo $font_style; ?>"><strong><?php echo $cnt_no.'.'; ?></strong></td>
											<td style="<?php echo $font_style; ?>"><?php echo $lv['s_question']; ?></td>
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
						</tr>
						<?php if($lk != (count($lt_column) - 1)) { ?>
						<tr>
						<td height="2"></td>	
						</tr>
						<?php } ?>
						
						<?php
							$cnt_no = $cnt_no + 1;
							}
						?>
						
					</tbody>
					
				</table>
				
				<!-- FIRST TABLE -->
			</td>
			<?php 
			}
			?>
			
			<?php 
			if(!empty($rt_column)) {
			?>
			<td>
				<!-- SECOND TABLE -->
				<table width="99%" border="0" cellspacing="0" cellpadding="0" align="left">
					
					<tbody>
						<?php 
						foreach($rt_column as $rk => $rv){ 
							$ansArr = array($rv['s_option1'], $rv['s_option2'], $rv['s_option3'], $rv['s_option4']);
							shuffle($ansArr);
						?>
						<tr nobr="true">
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="5">
									<tbody>
										<tr>
											<td valign="top" align="right" width="25" style="<?php echo $font_style; ?>"><strong><?php echo $cnt_no.'.'; ?></strong></td>
											<td style="<?php echo $font_style; ?>"><?php echo $rv['s_question']; ?></td>
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
						</tr>
						<?php if($rk != (count($rt_column) - 1)) { ?>
						<tr>
						<td height="2"></td>	
						</tr>
						<?php } ?>
						
						<?php
							$cnt_no = $cnt_no + 1;
							}
						?>
						
					</tbody>
					
				</table>
				
				<!-- SECOND TABLE -->
			</td>
			<?php 
			}
			?>
			
		</tr>

	</table>
	<?php 
		} 
	?>
	
	
	
	
	
	
	
	
	
	
	
	
	
	<?php /* ?><table width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
		<tr>
			<td>	
				<!-- FIRST TABLE -->
				<table style="width:500px;" border="0" cellspacing="0" cellpadding="0" align="left">
					
					<tbody>
						<tr nobr="true">
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="5">
									<tbody>
										<tr>
											<td valign="top" width="30" style="<?php echo $font_style; ?>"><strong>77</strong></td>
											<td style="<?php echo $font_style; ?>">Who among the following was the first Home Minister of India?</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td style="<?php echo $font_style; ?>">(A)&nbsp;Govind Ballabh Pant</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td style="<?php echo $font_style; ?>">(B)&nbsp;Sardar Patel</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td style="<?php echo $font_style; ?>">(C)&nbsp;Babu Jagjivan Ram</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td style="<?php echo $font_style; ?>">(D)&nbsp;Morarji Desai</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						
						<tr>
						<td height="20"></td>	
						</tr>
						
						<tr nobr="true">
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="5">
									<tbody>
										<tr>
											<td valign="top" width="30" style="<?php echo $font_style; ?>"><strong>78</strong></td>
											<td style="<?php echo $font_style; ?>">Who among the following was the first Home Minister of India?</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td style="<?php echo $font_style; ?>">(A)&nbsp;Govind Ballabh Pant</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td style="<?php echo $font_style; ?>">(B)&nbsp;Sardar Patel</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td style="<?php echo $font_style; ?>">(C)&nbsp;Babu Jagjivan Ram</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td style="<?php echo $font_style; ?>">(D)&nbsp;Morarji Desai</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						
						
						<tr>
						<td height="20"></td>	
						</tr>
						
						<tr nobr="true">
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="5">
									<tbody>
										<tr>
											<td valign="top" width="30" style="<?php echo $font_style; ?>"><strong>79</strong></td>
											<td style="<?php echo $font_style; ?>">Who among the following was the first Home Minister of India?</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td style="<?php echo $font_style; ?>">(A)&nbsp;Govind Ballabh Pant</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td style="<?php echo $font_style; ?>">(B)&nbsp;Sardar Patel</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td style="<?php echo $font_style; ?>">(C)&nbsp;Babu Jagjivan Ram</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td style="<?php echo $font_style; ?>">(D)&nbsp;Morarji Desai</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						
						
						<tr>
						<td height="20"></td>	
						</tr>
						
						<tr nobr="true">
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="5">
									<tbody>
										<tr>
											<td valign="top" width="30" style="<?php echo $font_style; ?>"><strong>80</strong></td>
											<td style="<?php echo $font_style; ?>">Who among the following was the first Home Minister of India?</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td style="<?php echo $font_style; ?>">(A)&nbsp;Govind Ballabh Pant</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td style="<?php echo $font_style; ?>">(B)&nbsp;Sardar Patel</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td style="<?php echo $font_style; ?>">(C)&nbsp;Babu Jagjivan Ram</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td style="<?php echo $font_style; ?>">(D)&nbsp;Morarji Desai</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						
						
						<tr>
						<td height="20"></td>	
						</tr>
						
						<tr nobr="true">
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="5">
									<tbody>
										<tr>
											<td valign="top" width="30" style="<?php echo $font_style; ?>"><strong>81</strong></td>
											<td style="<?php echo $font_style; ?>">Who among the following was the first Home Minister of India?</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td style="<?php echo $font_style; ?>">(A)&nbsp;Govind Ballabh Pant</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td style="<?php echo $font_style; ?>">(B)&nbsp;Sardar Patel</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td style="<?php echo $font_style; ?>">(C)&nbsp;Babu Jagjivan Ram</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td style="<?php echo $font_style; ?>">(D)&nbsp;Morarji Desai</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						
					</tbody>
					
				</table>
				<!-- FIRST TABLE -->
			</td>
			
			<td>
				<!-- SECOND TABLE -->
				<table style="width:500px;" border="0" cellspacing="0" cellpadding="0" align="left">
					<tbody>
						<tr nobr="true">
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="5">
									<tbody>
										<tr>
											<td valign="top" width="30" style="<?php echo $font_style; ?>"><strong>82</strong></td>
											<td style="<?php echo $font_style; ?>">Who among the following was the first Home Minister of India?</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td style="<?php echo $font_style; ?>">(A)&nbsp;Govind Ballabh Pant</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td style="<?php echo $font_style; ?>">(B)&nbsp;Sardar Patel</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td style="<?php echo $font_style; ?>">(C)&nbsp;Babu Jagjivan Ram</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td style="<?php echo $font_style; ?>">(D)&nbsp;Morarji Desai</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						
						<tr>
							<td height="20"></td>
						</tr>
						
						<tr nobr="true">
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="5">
									<tbody>
											<tr>
												<td valign="top" width="30" style="<?php echo $font_style; ?>"><strong>83</strong></td>
												<td style="<?php echo $font_style; ?>">Who among the following was the first Home Minister of India?</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td style="<?php echo $font_style; ?>">(A)&nbsp;Govind Ballabh Pant</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td style="<?php echo $font_style; ?>">(B)&nbsp;Sardar Patel</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td style="<?php echo $font_style; ?>">(C)&nbsp;Babu Jagjivan Ram</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td style="<?php echo $font_style; ?>">(D)&nbsp;Morarji Desai</td>
											</tr>
									</tbody>
								</table>
							</td>
						</tr>
					
						<tr>
							<td height="20"></td>
						</tr>
						
						<tr nobr="true">
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="5">
									<tbody>
											<tr>
												<td valign="top" width="30" style="<?php echo $font_style; ?>"><strong>84</strong></td>
												<td style="<?php echo $font_style; ?>">Who among the following was the first Home Minister of India?</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td style="<?php echo $font_style; ?>">(A)&nbsp;Govind Ballabh Pant</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td style="<?php echo $font_style; ?>">(B)&nbsp;Sardar Patel</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td style="<?php echo $font_style; ?>">(C)&nbsp;Babu Jagjivan Ram</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td style="<?php echo $font_style; ?>">(D)&nbsp;Morarji Desai</td>
											</tr>
									</tbody>
								</table>
							</td>
						</tr>
					
						<tr>
							<td height="20"></td>
						</tr>
						
						<tr nobr="true">
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="5">
									<tbody>
											<tr>
												<td valign="top" width="30" style="<?php echo $font_style; ?>"><strong>85</strong></td>
												<td style="<?php echo $font_style; ?>">Who among the following was the first Home Minister of India?</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td style="<?php echo $font_style; ?>">(A)&nbsp;Govind Ballabh Pant</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td style="<?php echo $font_style; ?>">(B)&nbsp;Sardar Patel</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td style="<?php echo $font_style; ?>">(C)&nbsp;Babu Jagjivan Ram</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td style="<?php echo $font_style; ?>">(D)&nbsp;Morarji Desai</td>
											</tr>
									</tbody>
								</table>
							</td>
						</tr>
					
						<tr>
							<td height="20"></td>
						</tr>
						
						<tr nobr="true">
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="5">
									<tbody>
											<tr>
												<td valign="top" width="30" style="<?php echo $font_style; ?>"><strong>86</strong></td>
												<td style="<?php echo $font_style; ?>">Who among the following was the first Home Minister of India?</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td style="<?php echo $font_style; ?>">(A)&nbsp;Govind Ballabh Pant</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td style="<?php echo $font_style; ?>">(B)&nbsp;Sardar Patel</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td style="<?php echo $font_style; ?>">(C)&nbsp;Babu Jagjivan Ram</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td style="<?php echo $font_style; ?>">(D)&nbsp;Morarji Desai</td>
											</tr>
									</tbody>
								</table>
							</td>
						</tr>
					
					</tbody>
				</table>
				<!-- SECOND TABLE -->
			</td>
		</tr>

	</table><?php */ ?>
	
</body>
</html>
