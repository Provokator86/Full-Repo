<?php 
/*$hostName = 'localhost';
$dbUserName = 'eshoppj3_caspsp';
$dbPassword = 'q}Vw(UBaa-;1';
$databaseName = 'eshoppj3_vaneloeshop';*/
if(SITE_FOR_LIVE)///For live site
{   
    $hostName = 'localhost';
    $dbUserName = 'eshoppj3_acumen';
    $dbPassword = 'Saltlake999';
    $databaseName = 'eshoppj3_vaneloeshop';
}
else
{
    $hostName = 'localhost';
    $dbUserName = 'root';
    $dbPassword = '';
    $databaseName = 'eshoppj3_vaneloeshop';
}

 ?>