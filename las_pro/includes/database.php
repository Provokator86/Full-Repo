<?php
$localhost	=	TRUE;
if($localhost)
{
	$link=mysql_connect('localhost','root','');
	$my_db_name	=	'las_pro';
}
else
{
	$link=mysql_connect('localhost','acumencs_las','las');
	$my_db_name	=	'acumencs_las';
}
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
//echo "connected successfully"."<br/>";
mysql_select_db($my_db_name,$link);

?>