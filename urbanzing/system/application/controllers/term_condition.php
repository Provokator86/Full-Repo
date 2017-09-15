<?php
include BASEPATH.'application/controllers/MY_Controller'.EXT;
class term_condition extends MY_Controller
{
	function __construct()
    {
        parent::__construct();
    }

    function index()
    {
		$this->set_include_files(array('term_condition_static/term_condition'));
		$this->render();
    }

   
}