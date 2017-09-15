<?php
include BASEPATH.'application/controllers/admin/MY_Controller'.EXT;
class Deal_category extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('deal_category_model');
    }

    /**
    * function to show listing of category
    * 
    * @param string $order_name
    * @param int $order_type
    * @param int $page
    */
    function index($order_name='cat_name',$order_type='asc',$page=0)
    {
        $this->check_user_page_access('registered');
        $sessArrTmp = array();
        $this->menu_id  = 5;
        $this->data['title'] = 'Deal Category Page';
        
        if($this->input->post('go'))
        {
            $sessArrTmp['src_category_name']= trim(htmlentities($this->input->post('cat_name'),ENT_QUOTES, 'utf-8'));
			$page = 0;
        }
        else
        {
            $sessArrTmp['src_category_name']=$this->get_session_data('src_category_name');
        }

        $this->data['txtArray']   = array("cat_name"=>"Name");
        $this->data['txtValue']   = array($sessArrTmp['src_category_name']);
        
        $this->data['category']     =  $this->deal_category_model->get_category_list($this->admin_page_limit,
                                            ($page)?$page:0, -1, 
                                            $sessArrTmp['src_category_name'],
                                            $order_name,$order_type);
                                            
        $totRow                     = $this->deal_category_model->get_category_list_count(-1, $sessArrTmp['src_category_name']);
        $this->session->set_userdata(array('model_session'=>$sessArrTmp));
        if(!$this->data['category'])
        {
            if($page>=$totRow && $page!=0)
            {
                $page=$totRow-$this->admin_page_limit;
                if($page<0)
                    $page=0;
                redirect('admin/deal_category/index/'.$order_name.'/'.$order_type.'/'.$page);
            }
        }
        paggingInitialization($this,
            array('base_url'=>base_url().'admin/deal_category/index/'.$order_name.'/'.$order_type,
                    'total_row'=>$totRow,
                    'per_page'=>$this->admin_page_limit,
                    'uri_segment'=>6,
                    'next_link'=>'Next&gt;',
                    'prev_link'=>'&lt;Prev'
                )
            );

        $this->data['order_name']=$order_name;
        $this->data['order_type']=$order_type;
        $this->data['page']=$page;

        $sessArrTmp['redirect_url']=base_url().'admin/deal_category/index/'.$order_name.'/'.$order_type.'/'.$page;
        $this->add_js('ajax_helper');
        $this->set_include_files(array('common/admin_menu','deal_category/category_list'));
        $this->render();
    }

    
    /**
    * function to show add category page
    */
    function add_category()
    {
        $this->check_user_page_access('registered');
        $this->menu_id  = 5;

        $this->data['title'] = 'Add Deal Category Page';
        $this->data['table_title'] = 'Add Deal Category';
       
        $this->add_js(array('ajax_helper','fromvalidation'));
        $this->set_include_files(array('common/admin_menu','deal_category/add_category'));
		$this->render();
    }
    

    /**
    * function to insert deals category
    */
    function insert_category()
    {
        $this->check_user_page_access('registered');
        $arr= array("cat_name"=>htmlspecialchars($this->input->post('name'), ENT_QUOTES, 'utf-8'),
                    "status"=>intval($this->input->post('status')),
                    "cr_by"=>$this->session->userdata('user_id'),
                    "cr_date"=>time()
        );
        if($this->deal_category_model->set_category_insert($arr))
            $this->session->set_userdata(array('message'=>'Deal Category add successfully..','message_type'=>'succ'));
        else
            $this->session->set_userdata(array('message'=>'Unable to add Deal Category..','message_type'=>'err'));
            
        redirect('admin/deal_category');
    }
    
    
    /**
    * function to show edit category page
    * 
    * @param int $id
    */
    function edit_category($id=-1)
    {
        $this->check_user_page_access('registered');

        if(!$id||!is_numeric($id)||$id==-1 || !$this->deal_category_model->is_valid_category($id))
        {
            $this->session->set_userdata(array('message'=>'Data not found for this category..','message_type'=>'err'));
            redirect($this->get_redirect_url());
        }
        $this->menu_id  = 5;
        
        $this->data['title'] = 'Edit Deal Category Page';
        $this->data['table_title'] = 'Edit Deal Category';
        $this->data['category']=$this->deal_category_model->get_category_list(1,0,$id);
       
        $this->data['redirect_url']=$this->get_redirect_url();
    
        $this->add_js(array('ajax_helper','fromvalidation'));
        $this->set_include_files(array('common/admin_menu','deal_category/edit_category'));
        $this->render();
    }
    
    
    /**
    * function to update the db
    */
    function update_category()
    {
        $this->check_user_page_access('registered');
        $arr= array("cat_name"=>htmlspecialchars($this->input->post('name'), ENT_QUOTES, 'utf-8'),
                    "status"=>intval($this->input->post('status')),
                    "update_by"=>$this->session->userdata('user_id'),
                    "update_date"=>time()
                            
        );
        if($this->deal_category_model->set_category_update($arr,intval($this->input->post('id'))))
            $this->session->set_userdata(array('message'=>'Deal category update successfully..','message_type'=>'succ'));
        else
            $this->session->set_userdata(array('message'=>'Unable to update deal category..','message_type'=>'err'));
        redirect($this->get_redirect_url());
    }
    
    
}