<?
require xml2array.php
require common_helper.php
$xmlToArryObj = new XML_Array();        
$arrayData = $this->xmlToArryObj->xml_to_array(file_get_contents('http://mydeal.acumencs.com/forum/feeds.php'));

pr($arrayData);

?>
