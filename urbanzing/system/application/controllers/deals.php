<?php
include BASEPATH.'application/controllers/MY_Controller'.EXT;

class deals extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->data['title'] = 'Deals';
        $this->menu_id  = 7;
        $this->set_include_files(array('deals/deals'));
        $this->render();
    }

}
