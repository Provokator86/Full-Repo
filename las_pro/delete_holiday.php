<?php 
include('layout/header.php');

$sql='SELECT * FROM holidays WHERE i_id= "'.$_GET['holidays_id'].'"';
if($result=$database->get_query($sql))
{
	$_SESSION['success_msg']='Holiday successfully deleted.';
}
else
{
	$_SESSION['error_msg']='Holiday not deleted.';
}
header('Location:holiday_list.php');
exit;
?>
