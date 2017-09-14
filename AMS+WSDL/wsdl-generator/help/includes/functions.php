<?php
// function base-url()...
function base_url() {
	
	// output: /myproject/index.php
    $currentPath = $_SERVER['PHP_SELF']; 
    
    // output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index ) 
    $pathInfo = pathinfo($currentPath); 
    
    // output: localhost
    $hostName = $_SERVER['HTTP_HOST']; 
    
    // output: http://
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off'?'https://':'http://';
    
    // return: http://localhost/myproject/
    return $protocol.$hostName.$pathInfo['dirname']."/";
	
}


// function to get project-url...
function project_url() {

	// output: /myproject/index.php
	$currentPath = $_SERVER['PHP_SELF'];
	
	// output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index )
	$pathInfo = pathinfo($currentPath);
	
	// output: localhost
	$hostName = $_SERVER['HTTP_HOST'];
	
	// output: http://
	$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off'?'https://':'http://';
	
	$project_dir = get_path_dir($pathInfo['dirname']);
	
	// return: http://localhost/myproject/
	return $protocol.$hostName."/". $project_dir ."/";
	
}

// get project-dir (if any) for 
function get_path_dir($param_dir_path, $param_index=null) {
	
	$dir_arr = explode('/', $param_dir_path);
	
	$arr_index = ( !empty($param_index) )? $param_index: 1;
	
	return $dir_arr[$arr_index];
}
