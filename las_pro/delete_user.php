<?php
include('layout/header.php');
	
		
$sql='DELETE FROM user WHERE i_id="'.$_GET['user_id'].'"';

if($result=$database->get_query($sql))
{
	$_SESSION['success_msg']='User successfully deleted.';
}
else
{
	$_SESSION['error_msg']='User not deleted.';
}
header('Location:manage_user.php');
exit;


?>