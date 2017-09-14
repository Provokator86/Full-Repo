<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * This controller contains the functions related to seller management
 * @author Teamtweaks
 *
 */

class Brands extends MY_Controller {

	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form'));
		$this->load->library(array('encrypt','form_validation'));
		$this->load->model('brands_model');
		if ($this->checkPrivileges('brands',$this->privStatus) == FALSE){
			redirect('admin');
		}
    }
    
    /**
     * 
     * This function loads the seller requests page
     */
   	public function index(){	
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			redirect('admin/brands/display_seller_dashboard');
		}
	}
	
	/**
	 * 
	 * This function loads the sellers dashboard
	 */
	public function display_seller_dashboard(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Sellers Dashboard';
			$condition = array('group'=>'Seller');
			$this->data['sellerList'] = $this->brands_model->get_all_details(USERS,$condition);
			$Query = "select p.sell_id,MAX(p.total) as topAmt,sum(p.quantity) as totQty, u.user_name,u.full_name from ".PAYMENT." p 
						LEFT JOIN ".USERS." u on u.id=p.sell_id
						Where p.status='Paid'
						group by p.dealCodeNumber
						order by p.total+0 desc";
			$this->data['topSellDetails'] = $this->brands_model->ExecuteQuery($Query);
			$condition = array('request_status'=>'Pending','group'=>'User');
			$this->data['pendingList'] = $this->brands_model->get_all_details(USERS,$condition);
			$this->load->view('admin/brands/display_seller_dashboard',$this->data);
		}
	}	
	
	
	public function display_seller_requests(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Claim Requests';
			$condition = array('status' => 'pending');
			//$this->data['sellerRequests'] = $this->brands_model->get_all_details(STORE_CLAIMS,$condition);
			//$Query = "select c.*,s.store_url from ".STORE_CLAIMS." c LEFT JOIN ".SHOPS." s on(c.store_id=s.id) and c.status='pending'";
			$Query = "select c.*,s.store_url from ".STORE_CLAIMS." c LEFT JOIN ".SHOPS." s on(c.store_id=s.id) where c.status='pending'";
			$this->data['storeDetails'] = $this->brands_model->ExecuteQuery($Query);
			
			$this->data['getuserDetails'] = $this->brands_model->get_all_details(USERS,array('id'=>$this->data['storeDetails']->row()->user_id));
			$this->load->view('admin/brands/display_seller_requests',$this->data);
		}
	}
	
	/**
	 * 
	 * This function loads the brands list page
	 */
	public function display_brand_list(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		} else {
			$this->data['heading'] = 'Brand List';
            //$this->data['sellersList'] = $this->brands_model->get_all_details(SHOPS,$condition);
			$this->data['sellersList'] = $this->brands_model->get_all_details(BRANDS,$condition);
			$this->load->view('admin/brands/display_sellerlist',$this->data);
		}
	}	
	
	
	public function insertEditBrand(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			
			$brand_name = $this->input->post('brand_name');
			$brand_id   = $this->input->post('brand_id');
			$condition1 = array('i_id' => $brand_id);
			$excludeArr = array("brand_id");
			
            $dataArr = array();
            
			if ($brand_id == ''){
				$this->setErrorMessage('success','Brand added successfully');
			}else {
				
				$config['overwrite'] = FALSE;
				$config['allowed_types'] = 'jpg|jpeg|gif|png';
				$config['max_size'] = 2000;
				$config['upload_path'] = './images/brand';
				$this->load->library('upload', $config);
				if ( $this->upload->do_upload('brand_logo')){
					$imgDetails = $this->upload->data();
					$dataArr['brand_logo'] = $imgDetails['file_name'];
				}
				
                //$excludeArr = array('address','city','state','country','postal_code','phone_no','seller_id','store_id');	
				$dataArr['brand_name'] =$brand_name;				
				//print_r($dataArr); die;
                $this->product_model->commonInsertUpdate(BRANDS,'update',$excludeArr,$dataArr,array('i_id'=>$brand_id),$condition1);
				
				$this->setErrorMessage('success','Brand updated successfully');
			}
			redirect('admin/brands/display_brand_list');
		}
	}
    
    public function view_brand(){
        if ($this->checkLogin('A') == ''){
            redirect('admin');
        }else {
            $this->data['heading'] = 'View Brand';
            $seller_id = $this->uri->segment(4,0);
            $condition = array('id' => $seller_id);
            
            $query_shop = "select * from ".BRANDS." where i_id='".$seller_id."'";
            $this->data['storeDetails'] = $this->brands_model->ExecuteQuery($query_shop);
            /*
            if($this->data['storeDetails']->row()->user_id>0) {
                $this->data['storeDetails'] = $this->brands_model->ExecuteQuery($query);
            } else {
                $this->data['storeDetails'] = $this->brands_model->ExecuteQuery($query_shop);
            }
            */
            
            $this->data['getuserDetails'] = $this->brands_model->get_all_details(USERS,array('id'=>$this->data['storeDetails']->row()->user_id));
            $this->load->view('admin/brands/view_brand',$this->data);
        }
    }    
    
    public function edit_brand_form(){
        if ($this->checkLogin('A') == ''){
            redirect('admin');
        }else {
            
            $this->data['heading'] = 'Edit Brand Details';
            $seller_id = $this->uri->segment(4,0);
            $condition = array('id' => $seller_id);            
            
            /*$query = "select c.*,s.store_url,s.products_count,s.followers_count,s.store_logo from ".STORE_CLAIMS." c join ".SHOPS." s on(c.store_id=s.id) where c.store_id=".$seller_id." and status='approved'"; */
            
            //$query_shop = "select * from ".SHOPS." where id='".$seller_id."'";
            $query_shop = "select * from ".BRANDS." where i_id='".$seller_id."'";
            $this->data['storeDetails'] = $this->brands_model->ExecuteQuery($query_shop);
            //pr($this->data['storeDetails']->row());
            
            /*if($this->data['storeDetails']->row()->user_id>0)
            {
                $this->data['storeDetails'] = $this->brands_model->ExecuteQuery($query);
            }
            else
            {
                $this->data['storeDetails'] = $this->brands_model->ExecuteQuery($query_shop);
            }*/
            
            /*$this->data['getuserDetails'] = $this->brands_model->get_all_details(USERS,array('id'=>$this->data['storeDetails']->row()->user_id));*/
            $this->load->view('admin/brands/edit_brand',$this->data);
        }
    }
    
    /**
     * 
     * This function delete the seller record from db
     */
    public function delete_brand(){
        if ($this->checkLogin('A') == ''){
            redirect('admin');
        }else {
            $seller_id = $this->uri->segment(4,0);
            $condition = array('i_id' => $seller_id);
            $this->brands_model->commonDelete(BRANDS,$condition);
            
            /*$condition1 = array('store_id' => $seller_id);
            $this->brands_model->commonDelete(STORE_CLAIMS,$condition1);*/
            
            $this->setErrorMessage('success','Brand deleted successfully');
            redirect('admin/brands/display_seller_list');
        }
    }
    
    // used till here	
		
	
}

/* End of file seller.php */
/* Location: ./application/controllers/admin/seller.php */