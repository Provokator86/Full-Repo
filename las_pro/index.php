<?php 
error_reporting(0);
session_start(); 
include('includes/database.php');
if(isset($_SESSION['user_roll']))
{
	if($_SESSION['user_roll']=='1'){
		header('Location:manage_user.php');
		exit;
		} 
	else if($_SESSION['user_roll']=='2'){
			header('Location:pending_leave.php');
			exit;  
		}
	else if($_SESSION['user_roll']=='3'){
			header('Location:apply_leave.php');
			exit;	
		}
}


if(	isset($_POST['submit'])	)
{
	$error_flag	=	0;
		
	if($_POST['email']=='')
	{
		$error_email	=	'Give Correct email.';
		$error_flag		=	1;
	}
	if($_POST['password']=='')
	{
		$error_password	=	'Give Correct Password.';
		$error_flag		=	1;
	}
	if($error_flag==0)
	{
	
	$sql='SELECT * FROM user WHERE s_email="'.$_POST['email'].'"';
		$result=mysql_query($sql,$link);
		$row=mysql_fetch_assoc($result);
		
		if (($row['s_pass']	== md5($_POST['password']))&&$_POST['password']!='')
			   { 
			   
			    $_SESSION['user_roll']	=	$row['i_role'];
				$_SESSION['user_id']	=	$row['i_id'];
				if($_SESSION['user_roll']=='1'){
					header('Location:manage_user.php');
					exit;
					} 
		  		else if($_SESSION['user_roll']=='2'){
					 	header('Location:pending_leave.php');
						exit;  
					}
				else if($_SESSION['user_roll']=='3'){
						header('Location:apply_leave.php');
						exit;	
					}
				}	
			else { 
				$login_err	=	"Check If Both Email And password Is Correct?";
				}		  
 			
	}
}
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		
		<title>Leave Application System | Sign In</title>
		
		<!--                       CSS                       -->
	  
		<!-- Reset Stylesheet -->
		<link rel="stylesheet" href="resources/css/reset.css" type="text/css" media="screen" />
	  
		<!-- Main Stylesheet -->
		<link rel="stylesheet" href="resources/css/style.css" type="text/css" media="screen" />
		
		<!-- Invalid Stylesheet. This makes stuff look pretty. Remove it if you want the CSS completely valid -->
		<link rel="stylesheet" href="resources/css/invalid.css" type="text/css" media="screen" />	
		
		<!-- Colour Schemes
	  
		Default colour scheme is green. Uncomment prefered stylesheet to use it.
		
		<link rel="stylesheet" href="resources/css/blue.css" type="text/css" media="screen" />
		
		<link rel="stylesheet" href="resources/css/red.css" type="text/css" media="screen" />  
	 
		-->
		
		<!-- Internet Explorer Fixes Stylesheet -->
		
		<!--[if lte IE 7]>
			<link rel="stylesheet" href="resources/css/ie.css" type="text/css" media="screen" />
		<![endif]-->
		
		<!--                       Javascripts                       -->
	  
		<!-- jQuery -->
		<script type="text/javascript" src="resources/scripts/jquery-1.3.2.min.js"></script>
		
		<!-- jQuery Configuration -->
		<script type="text/javascript" src="resources/scripts/simpla.jquery.configuration.js"></script>
		
		<!-- Facebox jQuery Plugin -->
		<script type="text/javascript" src="resources/scripts/facebox.js"></script>
		
		<!-- jQuery WYSIWYG Plugin -->
		<script type="text/javascript" src="resources/scripts/jquery.wysiwyg.js"></script>
		
		<!-- Internet Explorer .png-fix -->
		
		<!--[if IE 6]>
			<script type="text/javascript" src="resources/scripts/DD_belatedPNG_0.0.7a.js"></script>
			<script type="text/javascript">
				DD_belatedPNG.fix('.png_bg, img, li');
			</script>
		<![endif]-->
</head>

<body id="login">
<div id="login-wrapper" class="png_bg">
			<div id="login-top">
			
				<div>
            	<div id="logo"><img src="resources/images/logo.png" alt="" width="300" height="48" /></div>

          		</div>
			</div> <!-- End #logn-top -->
			
			
			<div id="login-content">
				
				<form action="" method="post">
				
					<div class="notification information png_bg">
						<?php /*?><div>
							Just click "Sign In". No password needed.						
						</div><?php */?>
					</div>
					<div align="center" class="error_msg"><?php echo $login_err; ?></div>
					
				<p>
					<label>Email</label>
				<input class="text-input" type="text" name="email" value="<?php echo $_POST['email'];?>"/>
				<span class="err_msg"><?php echo $error_email; ?></span>
				</p>
					<div class="clear"></div>
		<p>
			<label>Password</label>
			<input class="text-input" type="password" name="password" value="<?php echo $_POST['password']; ?>"/>
			<span class="err_msg"><?php echo $error_password; ?></span>
		</p>
					<div class="clear"></div>
					<!--<p id="remember-password">
						<input type="checkbox" />Remember me
					</p>
					<div class="clear"></div>-->
					<p>
						<input class="button" type="submit" name=" submit" value="Sign In" />
					</p>
					
				</form>
			</div> <!-- End #login-content -->
			
		</div>
</body>
</html>
