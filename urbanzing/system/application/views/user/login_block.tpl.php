<?php 
	if(!$this->session->userdata('user_username'))
	{
?>
<form id="frm_login" name="frm_login" method="post" action="<?=base_url().'user/login'?>">
<input type="hidden" name="submit_button" value="1" />
<div class="top_left_login"></div>
<div style="width:206px;" class="login_back" ><h5><?=WD('login for user')?></h5></div>
<div class="top_right_login"></div>	
<div class="clear"></div>
<div class="login_mid">
	<div class="input_txt"><?=WD('User Name')?> :<br /><input type="text" id="uid" name="uid" class="regis_box"   value="<?=($uid) ? $uid : ''?>"/></div>
	<div class="input_txt"><?=WD('Password')?> :<br /><input id="pwd" name="pwd" type="password" class="regis_box" value="<?=($password) ? $password : ''?>"/></div>
	<div class="input_txt"><a href="<?=base_url().'user/forget_password'?>" class="forgot"><?=WD('Forgot Username / Password?')?></a></div>
	<div class="input_txt"><input type="checkbox" name="remember" id="remember" value="1" <?=($remember_me)? 'checked' : ''?> />&nbsp;<?=WD('Keep me logged in on this computer')?><br /></div>
	<div class="input_txt"><input type="button" class="login_btn" onclick="document.frm_login.submit();"  /></div>
</div>
<div class="clear"></div>
<div class="botm_left"></div>
<div style="width:206px;" class="botm_back"></div>
<div class="botm_right"></div>	
</form>	
<?php
	} 
?>