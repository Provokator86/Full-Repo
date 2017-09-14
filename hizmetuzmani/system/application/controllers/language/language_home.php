<?php

include(BASEPATH.'application/controllers/My_Controller.php');

include(BASEPATH.'application/libraries/multilanguage/MultilingualTMX.php');

class Language_home extends MY_Controller {
	private $_pages = array();

	private $_extentions = array('php', 'phtml');
	private $_directory = BASEPATH;
	private $_xml = '';
	private $_function_name = 't';
	private $_plural_function_name = 'tp';
	private $_strip_path = 'application';
	private $_master_language = 'en';
	private $_languages = '';	
	//private $_languages = array('en'=>'English','fr'=>'French','hin'=>'Hindi');
	

	private $_mtmx = null;
	
	function __construct() {
		parent::__construct();
		
		//$this->_languages = array('en'=>'English','fr'=>'French','hin'=>'Hindi');
		$this->_languages = genLanguage();
		$this->_xml = BASEPATH.'multilanguage/tmx.xml';
		$this->_mtmx = new MultilingualTMX($this->_xml);
		$this->_mtmx->setDirectory($this->_directory);
		$this->_mtmx->setFunctionName($this->_function_name);
		$this->_mtmx->setStripUpto($this->_strip_path);
		//$this->_mtmx->setLanguages($this->_languages);
		$this->_mtmx->setMasterLanguage($this->_master_language);
		$this->_mtmx->setExtension($this->_extentions);

		$this->load->helper('common_helper');

		$this->_set_data_pages();
	}

	private function _set_data_pages() {
		$this->_pages = $this->_mtmx->getPages();
	}
	
	function index() {
		$data['page'] = 'index';
		$data['pages'] = $this->_pages;

		$this->load->view('language/language_home.php', $data);
	}

	function translations($page = '') {
		if($page == '') {
			if(isset($this->_pages[0])) {
				$page = base64_encode($this->_pages[0]);
			}
		}

		$data['page'] = 'translations';
		$data['translation_page'] = base64_decode($page);
		$data['pages'] = $this->_pages;
		$data['languages'] = $this->_languages;


		if( $this->input->post('submit_translations')!='' ) {
			$tc = new TranslationContainer($this->_master_language);
			$counter = $this->input->post('counter');
			for($i=0; $i<$counter; $i++) {
				foreach($this->_languages as $key=>$lang) {
					$tuid = base64_decode($this->input->post('tuid_'.$i)); 

					$word = $this->input->post('text_'.$i.'_'.$key);
					$language = $key;
					$t_page = '';
					//echo $tuid.'######'.$word.'######'.$language.'######'.$t_page;exit;
					// O/p-> Aucune activité sélectionnés.######Aucune activité sélectionnés.######fr######
					
					$tc->addWordTuid($tuid, $word, $language, $t_page);
				}
			}
		//	print_r($tc);
			$this->_mtmx->setTranslationTC($tc);

			header('location:'.base_url().'language/language_home/translations/'.$page);
			exit;
// 			echo '<pre>';
// 			print_r($tc);
// 			echo '</pre>';
		}

		if($page=='' && isset($this->_pages[0])) {
			$page = $this->_pages[0];
		}

		$data['translations'] = $this->_mtmx->getTranslationsByPage(base64_decode($page));

		//print_r($data['translations']);

		$this->load->view('language/translations.php', $data);
	}

	function scan() {
		$data['page'] = 'scan';
		$data['pages'] = $this->_pages;

		$this->load->view('language/scan.php', $data);
	}

	function backup_this() {
		$matches = array();
		preg_match('/(^.*)\.([^\.]*)$/', $this->_xml, $matches);
		$backup_name = $matches[1];
		$ext = $matches[2];
		

		$date = date("Y-m-d");
		$backup_file = $backup_name.'_'.$date.'.'.$ext;

		if(file_exists($backup_file)) {
			for( $i=1; file_exists($backup_name.'_'.$date.'_'.$i.'.'.$ext); $i++ ) {
			}

			$backup_file = $backup_name.'_'.$date.'_'.$i.'.'.$ext;
		}
		
		copy($this->_xml, $backup_file);

		//echo $this->_xml;
		preg_match('#(?:/)([^/]*\.[^\./]*)#', $this->_xml, $matches);
		$xml_filename = $matches[1];

		preg_match('#(?:/)([^/]*\.[^\./]*)#', $backup_file, $matches);
		$xml_backup_filename = $matches[1];

		$this->session->set_flashdata('backup_msg', "A backup named $xml_backup_filename has been created from $xml_filename");

		//echo $src_file = preg_replace('#(?:/)([^/]*\.[^\./]*)#', "$1", $this->_xml);

		header('location:'.base_url().'language/language_home/scan');
	}

	function scan_this() {
		$this->_mtmx->mergeWithXML();
		header('location:'.base_url().'language/language_home/scan');
	}

	function delete_scan() {
		$this->_mtmx->createXML();
		header('location:'.base_url().'language/language_home/scan');
	}
    
    
    
    //////////////////////dummy testing functions//////////////////////////
	
	function test() {
		$words = $this->_mtmx->getWords();
		print_r($words);
	}
    
    
    function words() 
    {
        $str = 'hello world hi';

        $word = 'hello';

        if( preg_match('#(^|\s)'.$word.'($|\s)#', $str) ) {
         echo 'found';
        }
        else {
         echo 'not found';
        }
    }
    
    
    function match_words($s_heystack,$s_search) 
    {
        if( preg_match('#(^|\s)'.$s_search.'($|\s)#', $s_heystack) ) {
         return TRUE;
        }
        else {
         return FALSE;
        }
    }    
    
    ////////////////////////added by soumya///////////////////////
    
  
  function search_words() {
        $words = $this->_mtmx->getWords();
        //print_r($words);
        return $words;
    } 
 
    
    function search_process()
     {
         
         header('location:'.base_url().'language/language_home/search/'.rawurldecode($this->input->post("txt_fulltext_src")));
     }
 
    function search($check = '') 
    {
        
      
        $data['page'] = 'search';
        $data['translation_page'] = base64_decode($page);
        $data['pages'] = $this->_pages;
        $data['languages'] = $this->_languages;
        $data['result'] = $this->search_words();
        //  print_r($data['result']);
        $data['$search_page']= base64_decode($page);
    
          if($check!='')
            {
                
                $result = $data['result']; /* array of words from where to b searched*/
                
                
               $temp=array();
               foreach($result as $id=>$lang_srch)
               {
                   $b_matched=FALSE;
                   if(is_array($lang_srch))
                   {
                       /////searching throughout all languages available in the conversion//////
                       foreach(array_keys($this->_languages) as $ln )
                       {
                           $b_matched=$this->match_words($lang_srch[$ln],$check);
                           /**
                           * if the search word matches in any of the language 
                           * then exit from this for loop and store it in temp.
                           */
                           if($b_matched)
                           {
                               $temp[$id]=$result[$id];
                               break;
                           }
                       }///end for
                       /////end searching throughout all languages available in the conversion//////
                   }
               }///end for
               $data['display_result']=$temp;
               $data['txt_fulltext_src']=$check;               
               /*echo '<pre>';
               print_r($temp);
               echo '</pre>';*/
             //  unset($temp);
              // unset($check);
               
                 
            }
   
        if( $this->input->post('submit_translations')!='' ) {
            $tc = new TranslationContainer($this->_master_language);
            $counter = $this->input->post('counter');
            for($i=0; $i<$counter; $i++) {
                foreach($this->_languages as $key=>$lang) {
                    $tuid = base64_decode($this->input->post('tuid_'.$i)); 

                    $word = $this->input->post('text_'.$i.'_'.$key);
                    $language = $key;
                    $t_page = '';
                    //echo $tuid.'######'.$word.'######'.$language.'######'.$t_page;exit;
                    // O/p-> Aucune activité sélectionnés.######Aucune activité sélectionnés.######fr######
                    
                    $tc->addWordTuid($tuid, $word, $language, $t_page);
                }
            }
        //    print_r($tc);
            $this->_mtmx->setTranslationTC($tc);

            header('location:'.base_url().'language/language_home/search/'.$check);
            exit;
//             echo '<pre>';
//             print_r($tc);
//             echo '</pre>';
        }

        if($page=='' && isset($this->_pages[0])) {
            $page = $this->_pages[0];
        }

        $data['translations'] = $this->_mtmx->getTranslationsByPage(base64_decode($page));

        //print_r($data['translations']);

        $this->load->view('language/search.php', $data);
    }
    
  
}



