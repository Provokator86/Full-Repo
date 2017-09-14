<?php 
include('layout/header.php');

$sql='SELECT * FROM role WHERE i_id= "'.$_GET['role_id'].'"';
if($result=$database->get_query($sql))
{
	$_SESSION['success_msg']='Role successfully deleted.';
}
else
{
	$_SESSION['error_msg']='Role not deleted.';
}
header('Location:manage_role.php');
exit;


?>
