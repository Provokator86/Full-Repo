<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of cashback_model
 *
 * @author user
 */

class Cashback_model extends MY_Model {

    public $table_name, $tbl_coupon, $tbl_cat, $tbl_matrix;
	
	//put your code here
    public function __construct() {

        parent::__construct();
        $this->table_name 	= '';
		$this->tbl_cat 		= 'cd_category';
		$this->tbl_matrix 	= 'cd_cashback_matrix';
		$this->tbl_coupon 	= 'cd_coupon';
    }
	
	public function fetch_cashback_matrix($s_where="")
    {
        try
        {
          	$ret_=array();
          	////Using Prepared Statement///	
			$s_query="SELECT n.*,c.s_category FROM ".$this->tbl_matrix." AS n "
					."LEFT JOIN ".$this->tbl_cat." AS c ON c.i_id = n.i_cat_id "
					.($s_where!=""?$s_where:"" );
			//echo $s_query;exit;
			$rs=$this->db->query($s_query); 
			return ($rs->result_array());
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }

    }
	
	
	public function fetch_categorywise_cashback_matrix()
    {
        try
        {
          	$ret_=array();
          	////Using Prepared Statement///	
			$s_query="SELECT n.*,c.s_category FROM ".$this->tbl_cat." AS c "
					."LEFT JOIN ".$this->tbl_matrix." AS n ON c.i_id = n.i_cat_id "
					."WHERE c.i_parent_id =0 ORDER BY c.s_category ASC ";
			//echo $s_query;exit;
			$rs=$this->db->query($s_query); 
			return ($rs->result_array());
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
	
	public function update_matrix_data($dataToInsert, $condition = NULL, $target_field = NULL) 
	{

        if ($target_field) {
            return $this->db->update_batch($this->tbl_matrix, $dataToInsert, $target_field);
        } else {
            return $this->db->update($this->tbl_matrix, $dataToInsert, $condition);
        }

    }
	
public function update_product_cashback_txt($cat_id, $info = array()) 
{
	if(intval($cat_id)>0 && !empty($info))
	{		
		foreach($info as $key=>$val)
		{			
			$sql = '';
			$rs = '';
			$cat_str='';
			$cat_str = select_chain_category_ids($cat_id);
			
			
			switch($key)
			{
				case "0-499":
					$sql = "UPDATE cd_coupon SET i_cashback='".$val."' WHERE i_cat_id IN({$cat_str}) AND d_selling_price BETWEEN 0 AND 499 ";					
					$rs = $this->db->query($sql);
					break;
				case "500-999":
					$sql = "UPDATE cd_coupon SET i_cashback='".$val."' WHERE i_cat_id IN({$cat_str}) AND d_selling_price BETWEEN 500 AND 999 ";
					$rs = $this->db->query($sql);
					break;	
				case "1000-1499":
					$sql = "UPDATE cd_coupon SET i_cashback='".$val."' WHERE i_cat_id IN({$cat_str}) AND d_selling_price BETWEEN 1000 AND 1499 ";
					$rs = $this->db->query($sql);
					break;	
				case "1500-1999":
					$sql = "UPDATE cd_coupon SET i_cashback='".$val."' WHERE i_cat_id IN({$cat_str}) AND d_selling_price BETWEEN 1500 AND 1999 ";
					$rs = $this->db->query($sql);
					break;	
				case "2000+":
					$sql = "UPDATE cd_coupon SET i_cashback='".$val."' WHERE i_cat_id IN({$cat_str}) AND d_selling_price >=2000 ";
					$rs = $this->db->query($sql);
					break;		
				default :	
					$sql = "";
			}
		}		
		return true;
	}
	else
	 return false;
}
    

}

?>