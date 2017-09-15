<div id="block">
	<div class="inner_top"></div>
	<?php
        $this->load->view('layouts/tree_link.tpl.php');
       ?>					
	<div class="inner_bg">					
		<div id="inner_right_big">							
			<div class="clear" style="height:10px"></div>	
			<div class="login_bg">
				<div class="login_box"><br /><br />
					<div class="top_left_green"></div>
					<div style="width:388px;" class="top_back_green" ><h1><?=WD('Login')?></h1></div>
					<div class="top_right_green"></div>
					<div class="clear"></div>
					<div class="login_mid_area">
						<?php
		                $this->load->view('admin/common/message_page.tpl.php');
		                ?>
						<form id="frm_login" name="frm_login" method="post" action="<?=base_url().'user/login'?>">
						<input type="hidden" name="submit_button" value="1" />
						<table cellpadding="0" cellspacing="12px" border="0" bgcolor="#FFFFFF">
							<tr>
								<td class="b_font"><?=WD('User ID')?>:</td>
								<td><input type="text" id="uid" name="uid" class="input_key"  value="<?=($uid) ? $uid : ''?>"/></td>
							</tr>
							<tr>
								<td class="b_font"><?=WD('Password')?>:</td>
								<td><input type="password" id="pwd" name="pwd" class="input_key" value="<?=($password) ? $password : ''?>"/></td>
							</tr>
								<tr>
								<td class="b_font"></td>
								<td><input type="button" class="login_btn" onclick="document.frm_login.submit();"/></td>
							</tr>
							<tr>
								<td class="b_font"></td>
								<td><a href="<?=base_url().'user/forget_password'?>" class="nor_links"><?=WD('Forgotten Password?')?></a></td>
							</tr>
							<tr><td></td><td><input type="checkbox" name="remember" id="remember" value="1" <?=($remember_me)? 'checked' : ''?> />&nbsp;<?=WD('Keep me logged in on this computer')?></td></tr>
							<tr><td colspan="2">&nbsp;</td></tr>
								<tr><td colspan="2">&nbsp;</td></tr>
						</table>
						</form>
					</div>
					<div class="clear"></div>
					<div class="botm_left"></div>
			<div style="width:388px;" class="botm_back"></div>
			<div class="botm_right"></div>
			<div class="clear"></div>
			<p>&nbsp;</p>
			<p>&nbsp;</p>
			<p>&nbsp;</p>
			<p>&nbsp;</p>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>				
	<div class="inner_btm"></div>
</div>	