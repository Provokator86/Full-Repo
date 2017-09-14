<!-- sign up light box is on header.tpl.php -->
<div class="signin">
	<ul>
		  <li><a href="javascript:void(0);" id="signin"><?php echo addslashes(t('login')); ?></a></li>
		  <li>|</li>
		  <li><a href="javascript:void(0);" onclick="show_dialog('photo_zoom')"><?php echo addslashes(t('sign up')); ?></a></li>
	</ul>
	<div id="signin_menu">
		<div class="signin_menu_content">
		<input id="usrname" name="textfield" type="text"  value="Username" size="35" onclick="if(this.value=='Username') document.getElementById('usrname').value ='';" onblur="if(this.value=='') document.getElementById('usrname').value ='Username';"/>
		<input id="pswrd" name="textfield" type="text"  value="Password" size="35" onclick="if(this.value=='Password') document.getElementById('pswrd').value ='';" onblur="if(this.value=='') document.getElementById('pswrd').value ='Password';"/>
		<a href="#"><?php echo addslashes(t('Forgot your password')); ?>?</a>
		<div class="login_btn">
		  <div class="left">
			  <input name="" type="checkbox" value="" />
			  <?php echo addslashes(t('Keep me logged in')); ?><input name="" type="button" value="Login"  class="login_button" onclick="window.location.href='javascript:void(0);'"/>
		  </div>
		
		<div class="clr"></div>
		</div>
		</div>
	</div>
</div>


