<?php
$current_url =  str_replace('=','',base64_encode(base_url().substr(uri_string(),1)));

?>
<?
		if(isset($_COOKIE['User'])&&isset($_COOKIE['pass']))
		{
			
			$user_name	=	$_COOKIE['User'];
			$password	=	$_COOKIE['pass'];
			$checked	=	'checked="checked"';
		}
		else
		{
			
			$user_name	=	t('Username');
			$password	=	t('password');
			$checked	=	'';
		}
 ?>

      <div style="display: none;">
            <div id="register_div" class="lightbox" style="width:650px;">
                  <h1><?php echo t('Register')?></h1>
                  <h3><?php echo t('How do you like to choose to use Quote Your Job')?>?</h3>
                  <form name="frm1" action="<?php echo base_url().'user/registration/TVNOaFkzVT0'?>" method="post" >
                        <div class="register_blue">
                              <div class="left" style="width:300px;"><input type="radio" name="registration" value="buyer_registration" id="Radio_buyer" checked="checked"/>
                              <span class="pink_txt"><?php echo t('Buyer')?></span> <?php echo t('Registration')?>
                          </div>
                           <div class="right" style="width:250px;">   <input type="radio" name="registration" value="tradesman_registration" id="Radio_tradesman"   />
                              <span class="pink_txt"><?php echo t('Tradesman')?></span> <?php echo t('Registration')?></div>
                     
                        </div>
                        <div style="text-align:center;">
                              <input name="submit1" type="button" value="<?php echo t('Register')?>"  class="button" onclick="validate_registration()" />
                        </div>
                  </form>
            </div>
      </div>
      <ul class="left">
	  <?php
	  if($language_list)
	  {
	  		$cnt = count($language_list);
			$x=1;
	  		$str = '';
	  		foreach($language_list as $val)
			{
				$cls = (encrypt($val['id']) == encrypt($this->i_default_language)) ? 'class="current"':'';
				$str .= '<li><a href="'.base_url().'home/change_lang/'.encrypt($val['id']).'/'.$current_url.'" '.$cls.'>'.$val['s_language'].'</a>
						</li>';
				if($x!=$cnt)		
					$str .= '<li>|</li>';		
					
				$x++;							
			}
			echo $str;	
	  
	  }
	  ?>	
      </ul>
      <ul class="right">
	  <?php
	  	if(empty($loggedin))
    	{
	  ?>
            <li><a href="javascript:();" class="signin"><img src="images/fe/login.png" alt="" /><?php echo t('Login')?></a></li>
            <li>|</li>
            <li><a href="#register_div"  class="lightbox_main"><img src="images/fe/signup.png" alt="" /> <?php echo t('Signup')?></a></li>
	  <?php }  else {?>
			<li><img src="images/fe/signup.png" alt="" /> <?php echo t('Welcome')?> <?php echo $loggedin['user_name']?></li>
            <li>|</li>
            <li><a href="<?php echo base_url().'user/dashboard'?>"><img src="images/fe/dashboard.png" alt="" /> <?php echo t('Dashboard')?> </a> </li>
            <li>|</li>
            <li><a href="<?php echo base_url().'user/logout'?>"><img src="images/fe/logout.png" alt="" /> <?php echo t('SignOut')?></a></li>
	  <?php } ?>	
				
      </ul>
      <div id="signin_menu">
            <div class="signin_menu_content">					
				<form name="login_form" action="<?php echo base_url().'user/login/TVNOaFkzVT0'?>" method="post">
				
                  <input id="usrname" name="txt_user_name" type="text"  value="<?php echo $user_name?>"  size="35"  onclick="if(this.value=='<?php echo addslashes($user_name)?>') document.getElementById('usrname').value ='';" onblur="if(this.value=='') document.getElementById('usrname').value ='<?php echo addslashes($user_name)?>';" autocomplete="off" />
                  <input id="pswrd" name="txt_password" type="password"   size="35" value="<?php echo $password?>" onfocus="if(this.value=='<?php echo addslashes($password)?>') document.getElementById('pswrd').value ='';" onblur="if(this.value=='') document.getElementById('pswrd').value ='<?php echo addslashes($password)?>';"  autocomplete="off"/>
                  <a href="<?php echo base_url().'user/forget_password'?>"><?php echo t('Forgot your password')?>?</a>
                  <div class="login_btn">
                        <div class="left">
                              <input name="remember_me" type="checkbox" value="1" <?php echo $checked?>/>
                              <?php echo t('Keep me logged in')?></div>
                        <div class="right" style="width:90px;">
                              <input name="submit1" type="submit" value="<?php echo t('Login')?>"  class="login_btn8"/>
                        </div>
                        <div class="clr"></div>
                  </div>
				  </form>
            </div>
      </div>

<script type="text/javascript">
	
function validate_registration()
{
	 var obj = document.forms['frm1'].getElementsByTagName('input');
	 var chk = false;
	 var str = 'TVNOaFkzVT0';
	 var str1 = 'TWlOaFkzVT0';
	 var text1 = '';
	 for(i=0;i<obj.length;i++)
	 {
		  type = obj[i].getAttribute('type');
		  name = obj[i].getAttribute('name');
		 
		  if(type == 'radio' && 'registration' == name && obj[i].checked) 
		  {
			text1 = obj[i].value;
		  }
		  
			if(text1 == 'buyer_registration')
				{
				 //document.forms['frm1'].action='user/registration/'+str;
				 location.href=base_url+'user/registration/'+str;
				}
			else
				{
				 //document.forms['frm1'].action='user/registration/'+str1;	
				 location.href=base_url+'user/registration/'+str1;
				 }
	 }
	return true;
}
</script>	  
