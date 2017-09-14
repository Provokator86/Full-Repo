<?php
//require_once(BASEPATH.'application/controllers/base_controller.php');
include(BASEPATH.'application/controllers/My_Controller.php');
//include(BASEPATH.'application/controllers/backoffice/admin_base_controller.php');
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
	private $_languages = array('en'=>'English' , 'tr'=>'Turkish');
	
	public  $alphabetArr	= array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	public  $alphabetArr1	= array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');

	private $_mtmx = null;
	
	function __construct() {
		parent::__construct();

		$this->_xml = BASEPATH.'multilanguage/tmx.xml';
		$this->_mtmx = new MultilingualTMX($this->_xml);
		$this->_mtmx->setDirectory($this->_directory);
		$this->_mtmx->setFunctionName($this->_function_name);
		$this->_mtmx->setStripUpto($this->_strip_path);
// 		$this->_mtmx->setLanguages($this->_languages);
		$this->_mtmx->setMasterLanguage($this->_master_language);
		$this->_mtmx->setExtension($this->_extentions);

		$this->load->helper('common_helper');
		$this->_set_data_pages();
	}

	private function _set_data_pages() {
		$this->_pages = $this->_mtmx->getPages();
	}
	
	function index() {
		/*$this->data['page'] = 'index';
		$this->data['pages'] = $this->_pages;
		$this->load->view('language/language_home.php', $this->data);*/
		
		$this->translations();
	}

	function translations() 
	{
		/*if($page == '') 
		{
			if(isset($this->_pages[0])) 
			{
				$page = base64_encode($this->_pages[0]);
			}
		}*/
		
		$this->data['page'] 			= 'Translations';
		$this->data['translation_page'] = base64_decode($page);
		$this->data['pages'] 			= $this->_pages;
		$this->data['languages'] 		= $this->_languages;
		$this->data['alphabets']		= $this->alphabetArr;
        $this->data['heading']          = 'Translations' ;
		
		/*if($page=='' && isset($this->_pages[0])) 
		{
			$page = $this->_pages[0];
		}*/
				
		ob_start();
			$this->translationPagination();
			$this->data['translation_list'] = ob_get_contents();				
		ob_end_clean();
		
		$this->add_js('js/admin/common.js');
		
		$this->render('translation/translations');
	}
	
	function translation_submit()
	{
		$this->data['page'] 			= 'Translations';
		$this->data['translation_page'] = base64_decode($page);
		$this->data['pages'] 			= $this->_pages;
		$this->data['languages'] 		= $this->_languages;
		$this->data['alphabets']		= $this->alphabetArr;
	
		if( $this->input->post('page_submitted')==1) 
		{
			$tc = new TranslationContainer($this->_master_language);
			$counter = $this->input->post('counter');
			for($i=0; $i<$counter; $i++)
			{
				foreach($this->_languages as $key=>$lang)
				{
					$tuid = base64_decode($this->input->post('tuid_'.$i)); 

					$word = $this->input->post('text_'.$i.'_'.$key);
					$language = $key;
					$t_page = '';
								
					$tc->addWordTuid($tuid, $word, $language, $t_page);
				}
			}
			$this->_mtmx->setTranslationTC($tc);
		}		
		
		$this->translationPagination();
	}
	
	function translationPagination($page='') 
	{	
		$page	= ($page=='')?0:$page;
		
		$this->load->model('pagination_model');
		
		$this->data['languages']	= $this->_languages;
		
		$perpage					= 10; //$this->i_admin_page_limit;
		
		$this->data['translations'] = $this->_mtmx->getTranslationsByPage();
		
		
		$totRow						= count($this->data['translations']);
		
		$this->data['translations']	= array_slice($this->data['translations'],$page,$perpage);		
		
		$s_pageurl					= admin_base_url().$this->router->fetch_class() . '/translationPagination/';
				
		$this->data['pagination'] 	= $this->pagination_model->get_jpagination($s_pageurl,$totRow,$perpage,4,"translation_box");		
		$this->load->view('admin/translation/translation_paging.tpl.php',$this->data);
	}	

	function scan()
	{
		$this->data['page'] = 'scan';
		$this->data['pages'] = $this->_pages;
        $this->data['heading']          = 'Back up' ; 

		$this->render('translation/scan');
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

		preg_match('#(?:/)([^/]*\.[^\./]*)#', $this->_xml, $matches);
		$xml_filename = $matches[1];

		preg_match('#(?:/)([^/]*\.[^\./]*)#', $backup_file, $matches);
		$xml_backup_filename = $matches[1];

		$this->session->set_flashdata('backup_msg', "A backup named $xml_backup_filename has been created from $xml_filename");

		header('location:'.admin_base_url().'language_home/scan');
	}

	function scan_this() {
		$this->_mtmx->mergeWithXML();
		header('location:'.admin_base_url().'language_home/scan');
	}

	function delete_scan() {
		$this->_mtmx->createXML();
		header('location:'.admin_base_url().'language_home/scan');
	}
    
    
    
    //////////////////////dummy testing functions//////////////////////////
	
	function search_by_letter($s_heystack,$s_search) {
		/*$words = $this->_mtmx->getWords();
		print_r($words);*/
		
		if($s_search=='others')
			return (!in_array(substr($s_heystack,0,1),$this->alphabetArr) && (!in_array(strtolower(substr($s_heystack,0,1)),$this->alphabetArr1)))?TRUE:FALSE;
		else
			return strtolower(substr($s_heystack,0,1))==strtolower($s_search)?TRUE:FALSE;
		/*if( preg_match('(^|\A)'.$s_search, $s_heystack) ) {
         return TRUE;
        }
        else {
         return FALSE;
        }*/
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
         
         header('location:'.admin_base_url().'language_home/search/'.rawurldecode($this->input->post("txt_fulltext_src")));
     }
 
    function search($check = '') 
    {
		$this->data['check'] 	= trim($this->input->post('txt_fulltext_src'));
		
        $this->data['page'] = 'search';
        $this->data['translation_page'] = base64_decode($page);
        $this->data['pages'] = $this->_pages;
        $this->data['languages'] = $this->_languages;
        $this->data['result'] = $this->search_words();
        
        $this->data['$search_page']= base64_decode($page);
    
        ob_start();
			$this->word_search_pagination($this->data['check']);
			$this->data['translation_list'] = ob_get_contents();	
		ob_end_clean();

        echo $this->load->view('admin/translation/result.tpl.php', $this->data);		
    }
	
	function letter_search() 
    {  
		/*$check	=  ($this->input->post('letter')!='')?$this->input->post('letter'):$this->session->userdata('search_letter'); 
		$this->session->set_userdata('search_letter',$check);*/
		$this->data['check']			=  $this->input->post('letter');
		
        $this->data['page'] 			= 'search';
        $this->data['translation_page'] = base64_decode($page);
        $this->data['pages'] 			= $this->_pages;
        $this->data['languages'] 		= $this->_languages;
        $this->data['result'] 			= $this->search_words();
        $this->data['$search_page']		= base64_decode($page);
    
         ob_start();
			$this->letter_search_pagination($this->data['check']);
			$this->data['translation_list'] = ob_get_contents();				
		ob_end_clean();

        echo $this->load->view('admin/translation/result.tpl.php',$this->data);
    }
	
	function search_translation_submit()
	{
		$this->data['page'] 			= 'Translations';
		$this->data['translation_page'] = base64_decode($page);
		$this->data['pages'] 			= $this->_pages;
		$this->data['languages'] 		= $this->_languages;
		$this->data['alphabets']		= $this->alphabetArr;
	
		if( $this->input->post('page_submitted')==1) 
		{
			$tc = new TranslationContainer($this->_master_language);
			$counter = $this->input->post('counter');
			for($i=0; $i<$counter; $i++)
			{
				foreach($this->_languages as $key=>$lang)
				{
					$tuid = base64_decode($this->input->post('tuid_'.$i)); 

					$word = $this->input->post('text_'.$i.'_'.$key);
					$language = $key;
					$t_page = '';
								
					$tc->addWordTuid($tuid, $word, $language, $t_page);
				}
			}
			$this->_mtmx->setTranslationTC($tc);
		}		
		
		$this->letter_search_pagination($this->input->post('check'));
	}
	
	function letter_search_pagination($check,$page='') 
    {  
		$this->data['page'] = 'search';
        $this->data['translation_page'] = base64_decode($page);
        $this->data['pages'] = $this->_pages;
        $this->data['languages'] = $this->_languages;
        $this->data['result'] = $this->search_words();
        $this->data['$search_page']= base64_decode($page);
		$this->data['check']	=  $check;
		
          if($check!='')
            {                
               $result = $this->data['result']; /* array of words from where to b searched*/
               $temp=array();
               foreach($result as $id=>$lang_srch)
               {
                   $b_matched=FALSE;
				   
                   if(is_array($lang_srch))
                   {
                       /////searching throughout all languages available in the conversion//////
                       foreach(array_keys($this->_languages) as $ln)
                       {					   
					   	 if($ln=='en')
						 {
						 	   $b_matched=$this->search_by_letter($lang_srch[$ln],$check);
							   /**
							   * if the search word matches in any of the language 
							   * then exit from this for loop and store it in temp.
							   */
							   if($b_matched)
							   {
							   	   $temp[$id]=$result[$id];
								   break;
							   }
						  }
                       }///end for
                       /////end searching throughout all languages available in the conversion//////
                   }				   
               }///end for
			   
			   $this->data['translations']=$temp;
               $this->data['txt_fulltext_src']=$check; 
			   
			   $page	= ($page=='')?0:$page;
		
			   $this->load->model('pagination_model');
						
			   $perpage						= 10; //$this->i_admin_page_limit;
						
			   $totRow						= count($this->data['translations']);
				
			   $this->data['translations']	= array_slice($this->data['translations'],$page,$perpage);		
				
			   $s_pageurl					= admin_base_url().$this->router->fetch_class() . '/letter_search_pagination/'.$check;
						
			   $this->data['pagination'] 	= $this->pagination_model->get_jpagination($s_pageurl,$totRow,$perpage,5,"result");    
        }
      
        echo $this->load->view('admin/translation/search_paging.tpl.php',$this->data);
    } 
	
	function word_search_pagination($check,$page='') 
    { 	
        $this->data['page'] = 'search';
        $this->data['translation_page'] = base64_decode($page);
        $this->data['pages'] = $this->_pages;
        $this->data['languages'] = $this->_languages;
        $this->data['result'] = $this->search_words();		
	    $this->data['search_page']= base64_decode($page);
		$this->data['check']	=  $check;
    
          if($check!='')
          {                
              $result = $this->data['result']; /* array of words from where to b searched*/
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
               $this->data['translations']=$temp;
               $this->data['txt_fulltext_src']=$check;               
             			   
			   $page	= ($page=='')?0:$page;
		
			   $this->load->model('pagination_model');
						
			   $perpage						= 3; //$this->i_admin_page_limit;
						
			   $totRow						= count($this->data['translations']);
				
			   $this->data['translations']	= array_slice($this->data['translations'],$page,$perpage);		
				
			   $s_pageurl					= admin_base_url().$this->router->fetch_class() . '/word_search_pagination/'.$check;
						
			   $this->data['pagination'] 	= $this->pagination_model->get_jpagination($s_pageurl,$totRow,$perpage,5,"result");    
        }
      
        echo $this->load->view('admin/translation/word_search_paging.tpl.php',$this->data);
    }  
	
	function word_search_translation_submit()
	{
		$this->data['page'] 			= 'Translations';
		$this->data['translation_page'] = base64_decode($page);
		$this->data['pages'] 			= $this->_pages;
		$this->data['languages'] 		= $this->_languages;
		$this->data['alphabets']		= $this->alphabetArr;
	
		if( $this->input->post('page_submitted')==1) 
		{
			$tc = new TranslationContainer($this->_master_language);
			$counter = $this->input->post('counter');
			for($i=0; $i<$counter; $i++)
			{
				foreach($this->_languages as $key=>$lang)
				{
					$tuid = base64_decode($this->input->post('tuid_'.$i)); 

					$word = $this->input->post('text_'.$i.'_'.$key);
					$language = $key;
					$t_page = '';
								
					$tc->addWordTuid($tuid, $word, $language, $t_page);
				}
			}
			$this->_mtmx->setTranslationTC($tc);
		}		
		
		$this->word_search_pagination($this->input->post('check'));
	}   
  
}



