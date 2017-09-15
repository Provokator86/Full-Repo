  <!--Yuva Registration-->
	<?
    $this->load->view('admin/common/message_page.tpl.php');
    ?>
	<div class="yuva_registration">
		 <input type="hidden" id="user_type_id" name="user_type_id" value="2"/>
		<form action="<?=base_url()?>project_yuva/save_registration" method="post" enctype="multipart/form-data">
		<span style="color:#FFFFFF;font-size:11px;"> **required fields are marked in white</span>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td width="24%" align="right">Email*</td>
				<td width="76%"><input type="text" id="email" name="email" value="<?=$old_values['email']?>"/></td>
			  </tr>
			  <tr>
				<td width="24%" align="right">First Name*</td>
				<td width="76%"><input type="text" id="f_name"  name="f_name" value="<?=$old_values['f_name']?>"/></td>
			  </tr>
			  <tr>
				<td width="24%" align="right">Last Name*</td>
				<td width="76%"><input type="text" id="l_name" name="l_name"  value="<?=$old_values['l_name']?>"/></td>
			  </tr>
			 
			  <tr>
				<td width="24%" align="right" style="color:#39caf7">Screen Name</td>
				<td width="76%"><input type="text" id="screen_name" name="screen_name" value="<?=$old_values['screen_name']?>"/>
				</td></td>
			  </tr>
			  <tr>
				
				<td width="24%" align="right">Password*</td>
				<td width="76%"><span style="font-size: 11px; color: rgb(235, 16, 24); font-weight: normal;">
		Enter a new password for your urbanZing account</span><br/><input type="password" id="pwd1" name="pwd1" />
				</td>
				
				
			  </tr>
			  
			  
			  
			  
			  <tr>
				<td width="24%" align="right" style="color:#39caf7">Gender</td>
				<td width="76%">
					<input type="radio" name="gender" value="M" /> Male
					<input type="radio" name="gender" value="F" /> Female
				</td>
			  </tr>
			 
			   <tr>
				<td align="right" style="color:#39caf7">Birthday</td>
				<td>
					<?php echo $dob;?>
				</td>
			  </tr>
			  <tr>
				<td align="right" style="color:#39caf7">Occupation</td>
				<td>
					<select id="occupation_id" name="occupation_id" style="width:290px;">
						<option value="">Select an occupation</option>
						<?=$occupation_option?>
					</select></td>
			  </tr>
			  
			  
			  <tr>
				<td width="24%" align="right" style="color:#39caf7">Photo</td>
				<td width="76%"><input type="file" id="img" name="img"/></td>
			  </tr>
			  <tr>
				<td width="24%" align="right" valign="top" style="color:#39caf7">How do you want to get involved?</td>
				<td width="76%">
				<span style="font-size: 11px; color: rgb(235, 16, 24); font-weight: normal;">
				Please click on an entry to select, hold down the control key to select multiple entries
				</span><br/>
				<select style="width:290px;height:100px;background:#FFFFFF;" multiple="multiple" id="entries_id" name="entries_id[]">
				   <?=$entries_option?>
				</select>
				
				
				</td>
			  </tr>
			   <tr>
				<td width="24%" align="right" style="color:#39caf7">Other involvement</td>
				<td width="76%"><input type="text" id="other" name="other" value="<?=$old_values['other']?>"/></td>
			  </tr>
			   <tr>
				<td width="24%" align="right"></td>
				<td width="76%">
				<input class="button_02" type="Reset" value="Reset>>" /> 
				<input class="button_02" type="submit" value="submit>>" /></td>
				<tr> 
				<td> </td>
				<td> <a href="<?=base_url()?>about_project_yuva" style="color:#FFFFFF" > Click here to learn more about Project Yuva</a></td>
				
				</tr>
			  </tr>
			 </table>
			 </form>

	   </div>

