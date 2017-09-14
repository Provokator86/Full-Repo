<?php
error_reporting(0);
ob_start(); 
session_start(); 
global $conn;
$localhost	=	TRUE;
if($localhost)
{
	$conn=mysql_connect('localhost','root','');
	$my_db_name	=	'las';
}
else
{
	$conn=mysql_connect('212.69.160.19','acumencs_las','las');
	$my_db_name	=	'acumencs_las';
}
//$conn = mysql_connect('localhost','root','');

include('classes/database.php');
include('classes/ps_pagination.php');
include('includes/common_functions.php');
global $database;
$database	=	new database($conn,$my_db_name);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
 
	<head>
		
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		
		<title>Leave Application System</title>
		
		<!--                       CSS                       -->
		
		<link href="css/style.css" type="text/css" rel="stylesheet" />
		<link href="css/dhtmlgoodies_calendar.css" type="text/css" rel="stylesheet" />
		<link href="css/calender.css" type="text/css" rel="stylesheet" />
	  
		<!-- Reset Stylesheet -->
		<link rel="stylesheet" href="resources/css/reset.css" type="text/css" media="screen" />
	  
		<!-- Main Stylesheet -->
		<link rel="stylesheet" href="resources/css/style.css" type="text/css" media="screen" />
		
		<!-- Invalid Stylesheet. This makes stuff look pretty. Remove it if you want the CSS completely valid -->
		<link rel="stylesheet" href="resources/css/invalid.css" type="text/css" media="screen" />	
		
		
		
		<link rel="stylesheet" href="resources/css/blue.css" type="text/css" media="screen" />
			
	
		
		<!--                       Javascripts                       -->
  
		<!-- jQuery -->
		<script type="text/javascript" src="resources/scripts/jquery-1.3.2.min.js"></script>
		
		
		<!-- jQuery Configuration -->
		<script type="text/javascript" src="resources/scripts/simpla.jquery.configuration.js"></script>
		
		<!-- Facebox jQuery Plugin -->
		<script type="text/javascript" src="resources/scripts/facebox.js"></script>
		
		<!-- jQuery WYSIWYG Plugin -->
		<script type="text/javascript" src="resources/scripts/jquery.wysiwyg.js"></script>
		
		<script src="js/dhtmlgoodies_calendar.js" type="text/javascript"></script>
		
		<script src="js/calender.js" type="text/javascript"></script>
		
		

        
		
		
	</head>
  
	<body>
   
    <div id="body-wrapper">