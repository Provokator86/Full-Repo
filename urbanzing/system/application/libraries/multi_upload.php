<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Multi_upload {

    function multi_upload($configs,$files){
	$CI = & get_instance(); 
        $CI->load->library('upload');

        if(count($configs) != count($files)){
           return 'array_count_wrong';
        }

        $errors = $successes = array();

        for($i=0, $j = count($files);$i<$j;$i++){
           $CI->upload->initialize($config[$i]);

           if( ! $CI->upload->do_upload($files[$i])){
               $errors[$files[$i]] = $CI->upload->display_errors();
           } else {
               $successes[$files[$i]] = $CI->upload->data();
           }
        }

        return array($errors, $successes);
    }
}?> 