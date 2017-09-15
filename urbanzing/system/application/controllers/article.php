<?php
include BASEPATH.'application/controllers/admin/MY_Controller'.EXT;
class article extends MY_Controller
{
    public 	$dir_name = '';
    public  $dir_thumb_name = '';
    function __construct()
    {
		parent::__construct();
		$this->check_user_page_access('registered');
        $this->load->model('article_model');
        $this->dir_name = BASEPATH.'../images/uploaded/article/';
		$this->dir_thumb_name = BASEPATH.'../images/uploaded/article/thumb/';
		$this->menu_id  = 4;
	}

	function index($order_name='title',$order_type='asc',$page=0)
    {
        $sessArrTmp = array();
        $this->data['title'] = 'Article Page';
        if($this->input->post('go'))
        {
            $sessArrTmp['src_article_title']=$this->input->post('title');
            $sessArrTmp['src_article_status']=$this->input->post('status');
            $sessArrTmp['src_article_category']=$this->input->post('category_id');
        }
        else
        {
            $sessArrTmp['src_article_title']=$this->get_session_data('src_article_title');
            $sessArrTmp['src_article_status']=$this->get_session_data('src_article_status');
            $sessArrTmp['src_article_category']=$this->get_session_data('src_article_category');
        }

        $this->data['txtArray']   = array("title"=>"Title");
        $this->data['txtValue']   = array($sessArrTmp['src_article_title']);
        $this->data['optArray']   = array("status"=>"Status",'category_id'=>'Category');
        $this->data['optValue']   = array(
            makeOption(array("1"=>"Enable","0"=>"Disable"),$sessArrTmp['src_article_status']),
            makeOption($this->article_model->article_category,$sessArrTmp['src_article_category'])
        );

        $this->data['article']=$this->article_model->get_article_list($this->admin_page_limit,($page)?$page:0,-1,$sessArrTmp['src_article_title'],$sessArrTmp['src_article_status'],$sessArrTmp['src_article_category'],$order_name,$order_type);
        $totRow = $this->article_model->get_article_list_count(-1,$sessArrTmp['src_article_title'],$sessArrTmp['src_article_status'],$sessArrTmp['src_article_category']);
        if(!$this->data['article'])
        {
            if($page>=$totRow && $page!=0)
            {
                $page=$totRow-$this->admin_page_limit;
                if($page<0)
                    $page=0;
                header('location:'.base_url().'admin/article/index/'.$order_name.'/'.$order_type.'/'.$page);
                exit;
            }
        }
        paggingInitialization($this,
            array('base_url'=>base_url().'admin/article/index/'.$order_name.'/'.$order_type,
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
        $this->data['article_category'] = $this->article_model->article_category;
        $sessArrTmp['redirect_url']=base_url().'admin/article/index/'.$order_name.'/'.$order_type.'/'.$page;
        $this->session->set_userdata(array('model_session'=>$sessArrTmp));
        $this->add_js('ajax_helper');
        $this->set_include_files(array('common/admin_menu','article/article_list'));
		$this->render();
	}

    function ajax_change_status()
    {
        $status   = $this->input->post('status');
        $id   = $this->input->post('id');
        if($this->article_model->change_article_status($id,$status))
        {
            $txt     = " Disable";
            $style='';
            $status=1-$status;
            if($status==1)
            {
                $style  = "color:green;";
                $txt     = " Enable";
            }
            $jsnArr = json_encode(array('id'=>$id,'status'=>$status));
            echo "<a onclick='call_ajax_status_change(\"".base_url()."admin/article/ajax_change_status\",".$jsnArr.",\"status".$id."\");' style='cursor:pointer; ".$style."'> ".$txt."</a>";
        }
    }

    function delete_article($id)
    {
        if($this->article_model->delete_article($id))
            $this->session->set_userdata(array('message'=>'Article deleted successfully..','message_type'=>'err'));
        else
            $this->session->set_userdata(array('message'=>'Unable to delete article..','message_type'=>'err'));
        header('location:'.$this->get_redirect_url());
        exit;
    }

    function add_article()
    {
        $this->data['title'] = 'Add Article Page';
        $this->data['table_title'] = 'Add Article';
        $this->data['article_category_option'] = makeOption($this->article_model->article_category);

        $this->add_js(array('tinymce/jscripts/tiny_mce/tiny_mce','tinymce_load','fromvalidation'));
        $this->set_include_files(array('common/admin_menu','article/add_article'));
		$this->render();
    }

    function edit_article($id=-1)
    {
        if(!$id||!is_numeric($id)||$id==-1 || !$this->article_model->is_valid_article($id))
        {
            $this->session->set_userdata(array('message'=>'Data not found for this article..','message_type'=>'err'));
            header("Location: ".$this->get_redirect_url());
            exit(0);
        }

        $this->data['article']=$this->article_model->get_article_list(1,0,$id);
        $this->data['article_category_option'] = makeOption($this->article_model->article_category,$this->data['article'][0]['category_id']);
        $img_path=$img_path = $this->dir_thumb_name.$this->data['article'][0]['img'];
        $this->data['img_thumb_path']='';
        if(file_exists($img_path) && $this->data['article'][0]['img'])
        	$this->data['img_thumb_path'] = base_url().'images/uploaded/article/thumb/'.$this->data['article'][0]['img'];
        
        $this->data['title'] = 'Edit Article Page';
        $this->data['table_title'] = 'Edit Article';
        $this->data['redirect_url']=$this->get_redirect_url();
	
        $this->add_js(array('tinymce/jscripts/tiny_mce/tiny_mce','tinymce_load','fromvalidation','ajax_helper','common_js'));
        //$this->add_js(array('ajax_helper','fromvalidation','common_js'));
        $this->set_include_files(array('common/admin_menu','article/edit_article'));
		$this->render();
    }

    function insert_article()
    {
        $imgPath	= '';
    	if( isset($_FILES['img']['name']) && $_FILES['img']['name']!='') 
		{
			$max_file_size    =$this->site_settings_model->get_site_settings('max_image_file_size');
			$img_details = upload_file($this,
							array('upload_path' => $this->dir_name,
								  'file_name'	=> 'article'.time(),
								  'allowed_types' => $this->config->item('image_support_extensions'),
								  'max_size' => '0',
								  'max_width' => '0',
								  'max_height' => '0',
								  ), 'img'
							);
			if(is_array($img_details))
			{	
				$config['image_library'] = 'gd2';
				$config['source_image'] = $img_details['full_path'];
				$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = TRUE;
				$config['thumb_marker'] = '';
				$config['width'] = 86;
				$config['height'] = 100;
				$config['new_image'] = $this->dir_thumb_name.$img_details['orig_name'];
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();	
				$imgPath	= $img_details['orig_name'];
			}  
			else
			{
				$err=explode('|',$img_details);
	   			$this->session->set_userdata(array('message'=>$err[0],'message_type'=>'err'));
				header('location:'.base_url().'admin/article/add_article');
				exit;
			} 
		}
        $arr= array("category_id"=>htmlspecialchars($this->input->post('category_id'), ENT_QUOTES, 'utf-8'),
                            "title"=>htmlspecialchars($this->input->post('title'), ENT_QUOTES, 'utf-8'),
                            "description"=>htmlspecialchars($this->input->post('description'), ENT_QUOTES, 'utf-8'),
        					"img"=>$imgPath,
                            "status"=>1,
                            "creation_dt"=>time()
        );
        if($this->article_model->set_article_insert($arr))
            $this->session->set_userdata(array('message'=>'Article add successfully..','message_type'=>'succ'));
        else
            $this->session->set_userdata(array('message'=>'Unable to add article..','message_type'=>'err'));
        header('location:'.base_url().'admin/article');
        exit;
    }

    function update_article()
    {
        $arr= array("category_id"=>htmlspecialchars($this->input->post('category_id'), ENT_QUOTES, 'utf-8'),
                            "title"=>htmlspecialchars($this->input->post('title'), ENT_QUOTES, 'utf-8'),
                            "description"=>htmlspecialchars($this->input->post('description'), ENT_QUOTES, 'utf-8')
        );
    	if($this->input->post('change_image') == 1) 
    	{
    		if( isset($_FILES['img']['name']) && $_FILES['img']['name']!='') 
    		{
	    		$max_file_size    =$this->site_settings_model->get_site_settings('max_image_file_size');
				$img_details = upload_file($this,
								array('upload_path' => $this->dir_name,
									  'file_name'	=> 'article'.time(),
									  'allowed_types' => $this->config->item('image_support_extensions'),
									  'max_size' => '0',
									  'max_width' => '0',
									  'max_height' => '0',
									  ), 'img'
								);
				if(is_array($img_details))
				{
					$create_thumb = create_thumb($this, 
										array('image_library'=> 'gd2',
										  'source_image' => $img_details['full_path'],
										  'create_thumb' => TRUE,
										  'maintain_ratio' => TRUE,
										  'thumb_marker' => '',
										  'width' => 86,
										  'height' => 100,
										  'new_image'=> $this->dir_thumb_name.$img_details['orig_name']	
										  ) 
									);
					if($create_thumb) 
					{
					   	$article = $this->article_model->get_article_list(1,0,$this->input->post('id'));
					   	if($article[0]['img'])
					   	{
						   	$img_path = $this->dir_name.$article[0]['img'];
						   	$img_full_path = $this->dir_thumb_name.$article[0]['img'];
						   	if(file_exists($img_path))
								unlink($img_path);
						   	if(file_exists($img_full_path))
								unlink($img_full_path);	
					   	}					
						$this->article_model->set_article_update(array("img"=>$img_details['orig_name']),$this->input->post('id'));
					}	
				}
				else
				{
					$err=explode('|',$img_details);
		   			$this->session->set_userdata(array('message'=>$err[0],'message_type'=>'err'));
					header('location:'.base_url().'admin/article/edit_article/'.$this->input->post('id'));
					exit;
				} 
    		}
		}
        if($this->article_model->set_article_update($arr,$this->input->post('id')))
            $this->session->set_userdata(array('message'=>'Article update successfully..','message_type'=>'succ'));
        else
            $this->session->set_userdata(array('message'=>'Unable to update article..','message_type'=>'err'));
        header('location:'.$this->get_redirect_url());
        exit;
    }
    
	function delete_image()
	{
		$this->check_user_page_access('registered');
		$id= $this->input->post('id');
		$article_img_name=$this->article_model->get_article_list(1,0,$id);
	 	if($article_img_name && $article_img_name[0]['img'])
	 	{
	 		$img_name = $article_img_name[0]['img'];
			$job_id = $article_img_name[0]['id'];
			$img_path = $this->dir_name.$img_name;
			$img_thumb_path = $this->dir_thumb_name.$img_name;
			
			if(file_exists($img_path))
				unlink($img_path);
			if(file_exists($img_thumb_path))
				unlink($img_thumb_path);	

			if($this->article_model->delete_image($id)) 
			{
				echo 'Image deleted successfully<br>|';
			}	
			else
				echo 'Not deleted successfully<br>|0';					 
		 } 
		 else 
			echo 'Not deleted successfullyaaa<br>|0';	 	
		 
	}
}
