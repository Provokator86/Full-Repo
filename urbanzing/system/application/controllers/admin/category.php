<?php
include BASEPATH.'application/controllers/admin/MY_Controller'.EXT;
class category extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('category_model');
    }

    function index($order_name='name',$order_type='asc',$page=0)
    {
        $this->check_user_page_access('registered');
        $sessArrTmp = array();
        $this->menu_id  = 3;
        $this->data['title'] = 'Business Type Page';
        
        if($this->input->post('go'))
        {
            $sessArrTmp['src_category_name']= trim(htmlentities($this->input->post('name'),ENT_QUOTES, 'utf-8'));
            //$sessArrTmp['src_category_item_type']=$this->input->post('item_type');
            $sessArrTmp['src_category_parent']=$this->input->post('parent_id');
			$page = 0;
        }
        else
        {
            $sessArrTmp['src_category_name']=$this->get_session_data('src_category_name');
            //$sessArrTmp['src_category_item_type']=$this->get_session_data('src_category_item_type');
            $sessArrTmp['src_category_parent']=$this->get_session_data('src_category_parent');
        }

        $this->data['txtArray']   = array("name"=>"Name");
        $this->data['txtValue']   = array($sessArrTmp['src_category_name']);
        $this->data['optArray']   = array("parent_id"=>"Parent");
        $this->data['optValue']   = array(makeOption($this->category_model->get_cat_selectlist($sessArrTmp['src_category_item_type']),$sessArrTmp['src_category_parent'])

            );

        $this->data['category']=$this->category_model->get_category_list($this->admin_page_limit,($page)?$page:0,-1,$sessArrTmp['src_category_item_type'],$sessArrTmp['src_category_name'],$sessArrTmp['src_category_parent'],$order_name,$order_type);
        $totRow = $this->category_model->get_category_list_count(-1,$sessArrTmp['src_category_item_type'],$sessArrTmp['src_category_name'],$sessArrTmp['src_category_parent']);
        $this->session->set_userdata(array('model_session'=>$sessArrTmp));
        if(!$this->data['category'])
        {
            if($page>=$totRow && $page!=0)
            {
                $page=$totRow-$this->admin_page_limit;
                if($page<0)
                    $page=0;
                header('location:'.base_url().'admin/category/index/'.$order_name.'/'.$order_type.'/'.$page);
                exit;
            }
        }
        paggingInitialization($this,
            array('base_url'=>base_url().'admin/category/index/'.$order_name.'/'.$order_type,
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

        $sessArrTmp['redirect_url']=base_url().'admin/category/index/'.$order_name.'/'.$order_type.'/'.$page;
       // $this->session->set_userdata(array('model_session'=>$sessArrTmp));
        $this->add_js('ajax_helper');
        $this->set_include_files(array('common/admin_menu','category/category_list'));
        $this->render();
    }

    function delete_category($id)
    {
        if($this->category_model->delete_category($id))
            $this->session->set_userdata(array('message'=>'Category deleted successfully..','message_type'=>'err'));
        else
            $this->session->set_userdata(array('message'=>'Unable to delete category..','message_type'=>'err'));
        header('location:'.$this->get_redirect_url());
        exit;
    }

    function add_category()
    {
        $this->check_user_page_access('registered');
        $this->menu_id  = 3;

        $this->data['title'] = 'Add Business Type Page';
        $this->data['table_title'] = 'Add Business Type';
       // $this->data['item_type'] = makeOption($this->category_model->category_type);
	    $this->data['parent_id'] = makeOption($this->category_model->get_cat_selectlist(0,0,0,1));

        $this->add_js(array('ajax_helper','fromvalidation'));
        $this->set_include_files(array('common/admin_menu','category/add_category'));
		$this->render();
    }

    function ajax_change_parent_event()
    {
        $item_type  = $this->input->post('item_id');
        $parent_detail_option=makeOption($this->category_model->get_cat_selectlist((isset($item_type))?$item_type:'',0,0,1));
        echo '<select id="parent_id" name="parent_id" style="width:200px;">
                                    <option value="0">---None---</option>'.$parent_detail_option.'</select>';
    }

    function edit_category($id=-1)
    {
        $this->check_user_page_access('registered');

        if(!$id||!is_numeric($id)||$id==-1 || !$this->category_model->is_valid_category($id))
        {
            $this->session->set_userdata(array('message'=>'Data not found for this category..','message_type'=>'err'));
            header("Location: ".$this->get_redirect_url());
            exit(0);
        }
        $this->menu_id  = 3;
        
        $this->data['title'] = 'Edit Business Type Page';
        $this->data['table_title'] = 'Edit Business Type';
        $this->data['category']=$this->category_model->get_category_list(1,0,$id);
        //$this->data['item_type'] = makeOption($this->category_model->category_type,$this->data['category'][0]['item_type']);
        $this->data['parent_id'] = makeOption($this->category_model->get_cat_selectlist(0,0,0,1),$this->data['category'][0]['parent_id']);
		$this->data['redirect_url']=$this->get_redirect_url();
	
        $this->add_js(array('ajax_helper','fromvalidation'));
        $this->set_include_files(array('common/admin_menu','category/edit_category'));
		$this->render();
    }

    function insert_category()
    {
        $this->check_user_page_access('registered');
        $arr= array("name"=>htmlspecialchars($this->input->post('name'), ENT_QUOTES, 'utf-8'),
                    "parent_id"=>htmlspecialchars($this->input->post('parent_id'), ENT_QUOTES, 'utf-8'),
					"cr_by"=>$this->session->userdata('user_id'),
                    "cr_date"=>time()
        );
        if($this->category_model->set_category_insert($arr))
            $this->session->set_userdata(array('message'=>'Business Type add successfully..','message_type'=>'succ'));
        else
            $this->session->set_userdata(array('message'=>'Unable to add Business Type..','message_type'=>'err'));
        header('location:'.base_url().'admin/category');
        exit;
    }

    function update_category()
    {
        $this->check_user_page_access('registered');
        $arr= array("name"=>htmlspecialchars($this->input->post('name'), ENT_QUOTES, 'utf-8'),
                    "parent_id"=>htmlspecialchars($this->input->post('parent_id'), ENT_QUOTES, 'utf-8'),
					"update_by"=>$this->session->userdata('user_id'),
					"update_date"=>time()
							
        );
        if($this->category_model->set_category_update($arr,$this->input->post('id')))
            $this->session->set_userdata(array('message'=>'Business Type update successfully..','message_type'=>'succ'));
        else
            $this->session->set_userdata(array('message'=>'Unable to update Business Type..','message_type'=>'err'));
        header('location:'.$this->get_redirect_url());
        exit;
    }
}