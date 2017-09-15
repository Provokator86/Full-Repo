<?php
class Deal_category_model extends Model
{
	public function __construct()
    {
        parent::__construct();
    }

    /**
    * function to retrieve the category listing..
    * 
    * @param int $toshow
    * @param int $page
    * @param int $item_id
    * @param string $name
    * @param string $order_name
    * @param string $order_type
    */
    function get_category_list($toshow=-1,$page=0, $item_id=-1, $name='', $order_name='cr_date',$order_type='desc')
    {
        $sucond       = ' where 1 ';
		$pageLimit	= '';
        if($item_id>0)
            $sucond   .= " and id='{$item_id}'";
        if($name!='')
        $sucond   .= " AND cat_name like '%".$this->db->escape_str($name)."%' ";
        
        $sql    = "SELECT *
                        FROM {$this->db->dbprefix}deals_category ";
        if($toshow>0)
        	$pageLimit	= ' limit '.$page.','.$toshow;
        $sql    .= $sucond.' order by '.$order_name.' '.$order_type.$pageLimit;
         $query = $this->db->query($sql);
		$result_arr = $query->result_array();
		return $result_arr;
    }

    /**
    * function to count the category listing
    * 
    * @param int $item_id
    * @param string $name
    */
    function get_category_list_count($item_id=-1,$name='')
    {
         $sucond = ' where 1 ';
        if($item_id>0)
            $sucond   .= " and id='{$item_id}'";
        if($name!='')
            $sucond   .= " AND cat_name like '%".$this->db->escape_str($name)."%' ";
                    
        $sql    = "SELECT id
                        FROM {$this->db->dbprefix}deals_category ";
        $sql    .= $sucond;

        $query = $this->db->query($sql);
		return $query->num_rows();
    }

    /**
    * function to insert deal categories into db
    * 
    * @param mixed $arr
    */
    function set_category_insert($arr)
    {
        if( count($arr)==0 )
			return false;
		if($this->db->insert('deals_category', $arr))
            return $this->db->insert_id();
        else
            return false;
    }
    
    /**
    * function to find out the category id exists or not
    * 
    * @param int $id
    * @returns boolean
    */
    function is_valid_category($id)
    {
        $sql = "SELECT *  from {$this->db->dbprefix}deals_category where id= $id";;
        $query = $this->db->query($sql);
        if($query->num_rows()==0)
            return false;
        else
            return true;
    }
    
    /**
    * function to update db
    * 
    * @param mixed $arr
    * @param int $id
    */
    function set_category_update($arr,$id)
    {
        if( count($arr)==0 || !$id || !is_numeric($id) || $id=='' || $id<1)
            return false;

        if(!$this->is_valid_category($id))
            return false;
        if($this->db->update('deals_category', $arr, array('id'=>$id)))
            return true;
        else
            return false;
    }
    
    
    /*
    function delete_category($id)
    {
        if(!$id || !is_numeric($id))
            return false;
        $sql    = "delete from {$this->db->dbprefix}business_type where id= $id";
        return $this->db->query($sql);
    }
    
    function get_cat_selectlist($item_type='',$current_cat_id=0, $count=0,$show_child=-1)
    {
        if (!isset($current_cat_id))
            $current_cat_id =0;
        $sub_cond   = '';
        if($item_type && $item_type!='-1')
            $sub_cond   .= " and item_type='$item_type'";
        $count = $count+1;

        $sql = "SELECT id, name from {$this->db->dbprefix}business_type where parent_id = $current_cat_id $sub_cond order by name";

        $query = $this->db->query($sql);
        $num_options = $query->num_rows();
        if ($num_options > 0)
        {
            $result_arr = $query->result_array();
            foreach ($result_arr as $k=>$v)
            {
                if ($current_cat_id!=0)
                {
                    $indent_flag = "";
                    for ($x=2; $x<=$count; $x++)
                        $indent_flag .= "&nbsp;&nbsp;&nbsp;";
                }
                $cat_name = (isset($indent_flag))?$indent_flag:'';
                $cat_name.=$v['name'];
                $this->option_results["{$v['id']}"] = $cat_name;
                if($show_child>0)
                    $this->get_cat_selectlist($item_type,$v['id'], $count,$show_child );
            }
        }
        return $this->option_results;
    }
    */

}