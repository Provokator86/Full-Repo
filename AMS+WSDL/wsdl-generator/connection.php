<?php
	
// for local

$username 	= "root";
$password 	= "shld123";
$hostname 	= "localhost"; 
$dbname 	= "ams";

// for live
/*$username 	= "staginga_ams";
$password 	= "ams123";
$hostname 	= "localhost"; 
$dbname 	= "staginga_ams_oauth";*/

//connection to the database
/*$con = mysql_connect($hostname, $username, $password) 
  or die("Unable to connect to MySQL");
 
 //select a database to work with
$db = mysql_select_db("ams",$con) 
  or die("Could not select database");*/
  
$con = mysqli_connect($hostname, $username, $password, $dbname);
// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
  
?>
