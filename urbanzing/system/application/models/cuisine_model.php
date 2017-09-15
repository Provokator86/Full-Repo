<?php
class Cuisine_model extends My_model
{

  public function __construct()
    {
		parent::__construct();
	}	

    function get_cuisine_list($arr=array(),$toshow=-1,$page=0,$order_by='cuisine',$order_type='asc')
    {
		$limit		= "";
		$subcond	= " where 1 ";
		if(isset($arr['id']) && $arr['id']!='')
			$subcond	.= " and id='{$arr['id']}' ";
		if(isset($arr['cuisine']) && $arr['cuisine']!='')
			$subcond	.= " and cuisine LIKE '%{$arr['cuisine']}%' ";
		if(isset($arr['status']) && $arr['status']!='' && $arr['status']!=-1)
			$subcond	.= " and status='{$arr['status']}' ";					
		$sql		= " select *
						from {$this->db->dbprefix}cuisine 
						$subcond
						order by $order_by $order_type
							";
		if($toshow>0)
		{
			$limit	= " limit $page,$toshow ";
		}
		$sql .= $limit; 
		
	//echo $sql;
	
		$query = $this->db->query($sql);
		//die();
		$result = $query->result_array();	
		return $result;
	}	
	
    function get_cuisine_list_count($arr=array())
    {
       $subcond	= " where 1 ";
		if(isset($arr['cuisine']) && $arr['cuisine']!='')
			$subcond	.= " and cuisine LIKE '%{$arr['cuisine']}%' ";
		if(isset($arr['status']) && $arr['status']!='' && $arr['status']!=-1)
			$subcond	.= " and status='{$arr['status']}' ";					
			
         $sql		= " select *
						from {$this->db->dbprefix}cuisine 
						";

         $sql    .= $subcond;

        $query = $this->db->query($sql);
		return $query->num_rows();
    }	
	
	
	 /*
     * By rubel
     */

    function get_cuisine_option($id=-1)
    {
        $sql    = " SELECT *
                    FROM {$this->db->dbprefix}cuisine
                    WHERE status='1' 
                    ORDER BY cuisine";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $html   = '';
        if($result)
        {
            foreach($result as $k=>$v)
            {
                $selected   = '';
                if(is_array($id))
                {
                    if(in_array($v['id'], $id))
                        $selected   = ' selected ';
                }
                elseif($v['id']==$id)
                    $selected   = ' selected ';
                $html   .= '<option value="'.$v['id'].'" '.$selected.'>'.$v['cuisine'].'</option>';
            }
        }
        return $html;
    }
    function get_cuisine_id_arr($business_id)
    {
        if(!isset($business_id) || $business_id<1)
            return false;
        $sql    = "SELECT * FROM {$this->db->dbprefix}business_cuisine WHERE business_id=$business_id";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $arr    = array();
        foreach($result as $k=>$v)
            $arr[$k]    = $v['cuisine_id'];
        return $arr;
    }

    function set_delete_cuisine($id=-1,$business_id=-1)
    {
        $subcond    = '';
        if($id>0)
            $subcond    .= " AND id=$id ";
        if($business_id>0)
            $subcond    .= " AND business_id=$business_id ";
        $sql        = "DELETE FROM {$this->db->dbprefix}business_cuisine WHERE 1 $subcond";
        $this->db->query($sql);
    }	
	                                                        
}