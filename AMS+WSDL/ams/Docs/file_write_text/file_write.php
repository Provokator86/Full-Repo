<?php 
$file = "newfile.txt";
$myfile = fopen($file, "w") or die("Unable to open file!");
fclose($myfile);
//chown('/var/www/html/test/file/'.$file,"root");

system('chown root '.$file);

#system('chown root:root newfile.txt');
#system('chmod -0777 newfile.txt');


// Get file content :: which is also blank
//$content = file_get_contents($file); //Append
$content = ''; //New

$content .= 'Hello Moy';
$content .= generate_string('jagannath',20);
$content .= generate_string('samanta',20);
$content .= generate_string('moy',3);
$content .= generate_string(' ',4);
$content .= generate_string('sona',4);


$content = file_put_contents($file, $content);



/*$txt = "John Doe\n";
fwrite($myfile, $txt);
$txt = "Jane Doe\n";
fwrite($myfile, $txt);
fclose($myfile);
system('chown jagannath:jagannath newfile.txt');*/


function generate_string($string, $length)
{
	if($string == '' || intval($length) == 0)
		return '';
	return str_pad($string,  $length, " ");
}
