<?php 
include('layout/header.php');


$sql='SELECT * FROM dept WHERE i_id= "'.$_GET['dept_id'].'"';
if($result=$database->get_query($sql))
{
	$_SESSION['success_msg']='Department successfully deleted.';
}
else
{
	$_SESSION['error_msg']='Department not deleted.';
}
header('Location:manage_dept.php');
exit;


?>
