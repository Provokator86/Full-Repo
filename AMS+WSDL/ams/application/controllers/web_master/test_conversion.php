<?php 
/***
File Name: test_conversion.php 
Created By: ACS Dev 
Created On: Sep 30, 2015 
Purpose: document conversion using CloudConvert
*/

use GuzzleHttp\Client;
use \CloudConvert\Api;

class Test_conversion extends MY_Controller 
{
	public $doc_path;
    
	public function __construct() {
        
		parent::__construct();
        
		$this->data["title"] = addslashes(t('Document Conversion'));//Browser Title 
        $this->data['BREADCRUMB'] = array(addslashes(t('Document Conversion')));
        
		$this->doc_path = BASEPATH ."../uploaded/converted/";
	}

	//Default method (index)
	public function index()
	{
        // disable cert verification
        /*$guzzle = new Client();
        $guzzle->setDefaultOption('verify', false);*/
        
        $api = new Api("RhmZkM-thYaTvnyzHtXP_SofFCAb7mSbWoBG-A2UxUDOlj2XaWHh5U6btu7qa1JQwj_SJujx5_JyrorjdTU6wA");
        
        $input_file_path = BASEPATH ."../uploaded/doc_master/master/MBFS-203.docx";
        $output_file_path = $this->doc_path ."MBFS-203.pdf";
        
        $api->convert([
            "input" => "upload",
            "inputformat" => "docx",
            "outputformat" => "pdf",
            "file" => fopen($input_file_path, 'r'),
        ])
        ->wait()
        ->download($output_file_path);
        
        echo "file converted successfully!";
	}

    // calling destructor...
	public function __destruct(){}
}
