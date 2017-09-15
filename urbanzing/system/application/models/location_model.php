<?php

class Location_model extends Model
{
    public function __construct()
    {
	parent::__construct();
    }

    function get_country_list($toshow=-1,$page=0,$arr=array(),$order_name='name',$order_type='asc')
    {
        $sucond = ' WHERE 1 ';
        $pageLimit	= '';
        if(isset($arr['id']) && $arr['id']!=-1 && is_numeric($arr['id']) && $arr['id']>0)
            $sucond .= " AND id={$arr['id']} ";
        if(isset($arr['name']) && $arr['name']!='')
            $sucond .= " AND name LIKE '%{$arr['name']}%' ";
        if(isset($arr['ext_cond']) && $arr['ext_cond']!='')
            $sucond .= $arr['ext_cond'];
        $sql    = "SELECT * FROM {$this->db->dbprefix}country ";

        if($toshow>0)

        	$pageLimit	= ' LIMIT '.$page.','.$toshow;

        $sql    .= $sucond.' ORDER BY '.$order_name.' '.$order_type.$pageLimit;

        $query = $this->db->query($sql);

        $result_arr = $query->result_array();

        return $result_arr;
    }
    function get_country_list_count($arr=array())
    {
        $sucond = ' WHERE 1 ';
        if(isset($arr['id']) && $arr['id']!=-1 && is_numeric($arr['id']) && $arr['id']>0)
            $sucond .= " AND id={$arr['id']} ";
        if(isset($arr['name']) && $arr['name']!='')
            $sucond .= " AND name LIKE '%{$arr['name']}%' ";
        if(isset($arr['ext_cond']) && $arr['ext_cond']!='')
            $sucond .= $arr['ext_cond'];
        $sql    = "SELECT * FROM {$this->db->dbprefix}country ";
        $sql    .= $sucond;
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    function get_country_duplicate($databaseTbl,$id=-1)
    {
        foreach($databaseTbl as $key=>$value)
        {
            $sub_cond = $key."='".htmlentities($value)."'";
            if($id && $id!='' && $id!=-1)
                $sub_cond   .= " AND id!='{$id}'";
            $sql = $this->db->query("SELECT * FROM {$this->db->dbprefix}country WHERE $sub_cond");
            $total  = $sql->num_rows();
            if($total>0)
                return 'Duplicate '.$value;
        }
    }


    function set_country_insert($arr,$salt)
    {
        if( count($arr)==0 && $salt!=get_salt() )
			return false;
		if($this->db->insert('country', $arr))
            return $this->db->insert_id();
        else
            return false;
    }


    function is_valid_country($id)
    {
        $sql = "SELECT * FROM {$this->db->dbprefix}country WHERE id = '$id' ";
        $query = $this->db->query($sql);
        if($query->num_rows()==0)
            return false;
        else
            return true;
    }
    function set_country_update($arr,$code)
    {
        if( count($arr)==0 || !$code || $code=='')
            return false;
        if($this->db->update('country', $arr, array('id'=>$code)))
            return true;
        else
            return false;
    }
    function delete_country($id)
    {
        if(!$id || !is_numeric($id))
            return false;
        $sql    = "delete from {$this->db->dbprefix}country where id= $id";
        return $this->db->query($sql);
    }
    function get_country_list_option($id=-1)
    {
        $sql    = "SELECT * FROM {$this->db->dbprefix}country ";
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        $html   = '';
        foreach($result_arr as $k=>$v)
        {
            $selected   = '';
            if($id==$v['id'])
                $selected   = 'selected';
            $html   .= '<option value="'.$v['id'].'" '.$selected.'>'.$v['name'].'</option>';
        }
        return $html;
    }

    function get_state_list($toshow=-1,$page=0,$arr=array(),$order_name='s.name',$order_type='asc')
    {
        $sucond = ' WHERE 1 ';
        $pageLimit	= '';
        if(isset($arr['id']) && $arr['id']!=-1 && is_numeric($arr['id']) && $arr['id']>0)
            $sucond .= " AND s.id={$arr['id']} ";
        if(isset($arr['country']) && $arr['country']!=-1 && is_numeric($arr['country']) && $arr['country']>0)
            $sucond .= " AND country_id={$arr['country']} ";
        if(isset($arr['name']) && $arr['name']!='')
            $sucond .= " AND s.name LIKE '%{$arr['name']}%' ";
        if(isset($arr['ext_cond']) && $arr['ext_cond']!='')
            $sucond .= $arr['ext_cond'];
        $sql    = "SELECT s.*,c.name c_name 
                    FROM {$this->db->dbprefix}state s INNER JOIN {$this->db->dbprefix}country c ON s.country_id=c.id";
        if($toshow>0)
        	$pageLimit	= ' LIMIT '.$page.','.$toshow;
        $sql    .= $sucond.' ORDER BY '.$order_name.' '.$order_type.$pageLimit;

        $query = $this->db->query($sql);

        $result_arr = $query->result_array();

        return $result_arr;

    }



    function get_state_list_count($arr=array())

    {

        $sucond = ' WHERE 1 ';
        if(isset($arr['id']) && $arr['id']!=-1 && is_numeric($arr['id']) && $arr['id']>0)
            $sucond .= " AND s.id={$arr['id']} ";
        if(isset($arr['country']) && $arr['country']!=-1 && is_numeric($arr['country']) && $arr['country']>0)
            $sucond .= " AND country={$arr['country']} ";
        if(isset($arr['name']) && $arr['name']!='')
            $sucond .= " AND s.name LIKE '%{$arr['name']}%' ";
        if(isset($arr['ext_cond']) && $arr['ext_cond']!='')
            $sucond .= $arr['ext_cond'];
        $sql    = "SELECT s.*,c.name c_name
                    FROM {$this->db->dbprefix}state s INNER JOIN {$this->db->dbprefix}country c ON s.country_id=c.id";
        $sql    .= $sucond;
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
    function set_state_insert($arr)
    {
        if( count($arr)==0 )
            return false;
        if($this->db->insert('state', $arr))
            return $this->db->insert_id();
        else
            return false;
    }
    function is_valid_state($id)
    {
        $sql = "SELECT * FROM {$this->db->dbprefix}state WHERE id = '$id' ";
        $query = $this->db->query($sql);
        if($query->num_rows()==0)
            return false;
        else
            return true;
    }
    function set_state_update($arr,$code)
    {
        if( count($arr)==0 || !$code || $code=='')
            return false;
        if($this->db->update('state', $arr, array('id'=>$code)))
            return true;
        else
            return false;
    }
    function delete_state($id)
    {
        if(!$id || !is_numeric($id))
            return false;
        $sql    = "delete from {$this->db->dbprefix}state where id= $id";
        return $this->db->query($sql);
    }

    function get_state_list_option($id=-1,$country=-1)
    {
        $subcond;
        if (isset ($country) && $country>0)
            $subcond    = " AND country_id=$country ";
        $sql    = "SELECT * FROM {$this->db->dbprefix}state WHERE 1 $subcond";
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        $html   = '';
        foreach($result_arr as $k=>$v)
        {
            $selected   = '';
            if($id==$v['id'])
                $selected   = 'selected';
            $html   .= '<option value="'.$v['id'].'" '.$selected.'>'.$v['name'].'</option>';
        }
        return $html;
    }

    function get_city_list($toshow=-1,$page=0,$arr=array(),$order_name='c.name',$order_type='asc')
    {
        $sucond = ' WHERE 1 ';
        $pageLimit	= '';
        if(isset($arr['id']) && $arr['id']!=-1 && is_numeric($arr['id']) && $arr['id']>0)
            $sucond .= " AND c.id={$arr['id']} ";
        if(isset($arr['state']) && $arr['state']!=-1 && is_numeric($arr['state']) && $arr['state']>0)
            $sucond .= " AND state={$arr['state']} ";
        if(isset($arr['country']) && $arr['country']!=-1 && is_numeric($arr['country']) && $arr['country']>0)
            $sucond .= " AND s.country={$arr['country']} ";
        if(isset($arr['name']) && $arr['name']!='')

            $sucond .= " AND c.name LIKE '%{$arr['name']}%' ";

        if(isset($arr['ext_cond']) && $arr['ext_cond']!='')

            $sucond .= $arr['ext_cond'];

        $sql    = "SELECT c.*,s.name s_name,cn.name c_name,cn.id c_id

                    FROM {$this->db->dbprefix}city c INNER JOIN {$this->db->dbprefix}state s ON s.id=c.state_id

                    INNER JOIN {$this->db->dbprefix}country cn ON cn.id=s.country_id

                    ";

        if($toshow>0)

        	$pageLimit	= ' LIMIT '.$page.','.$toshow;

        $sql    .= $sucond.' ORDER BY '.$order_name.' '.$order_type.$pageLimit;

        $query = $this->db->query($sql);

        $result_arr = $query->result_array();

        return $result_arr;

    }



    function get_city_list_count($arr=array())
    {
        $sucond = ' WHERE 1 ';
        if(isset($arr['id']) && $arr['id']!=-1 && is_numeric($arr['id']) && $arr['id']>0)
            $sucond .= " AND c.id={$arr['id']} ";
        if(isset($arr['state']) && $arr['state']!=-1 && is_numeric($arr['state']) && $arr['state']>0)
            $sucond .= " AND state={$arr['state']} ";
        if(isset($arr['country']) && $arr['country']!=-1 && is_numeric($arr['country']) && $arr['country']>0)
            $sucond .= " AND s.country={$arr['country']} ";
        if(isset($arr['name']) && $arr['name']!='')
            $sucond .= " AND c.name LIKE '%{$arr['name']}%' ";
        if(isset($arr['ext_cond']) && $arr['ext_cond']!='')
            $sucond .= $arr['ext_cond'];
        $sql    = "SELECT c.*,s.name s_name,cn.name c_name,cn.id c_id

                    FROM {$this->db->dbprefix}city c INNER JOIN {$this->db->dbprefix}state s ON s.id=c.state

                    INNER JOIN {$this->db->dbprefix}country cn ON cn.id=s.country

                    ";

        $sql    .= $sucond;
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    function set_city_insert($arr)

    {

        if( count($arr)==0 )

            return false;

        if($this->db->insert('city', $arr))

            return $this->db->insert_id();

        else

            return false;

    }



    function is_valid_city($id)

    {

        $sql = "SELECT * FROM {$this->db->dbprefix}city WHERE id = '$id' ";

        $query = $this->db->query($sql);

        if($query->num_rows()==0)

            return false;

        else

            return true;

    }



    function set_city_update($arr,$code)

    {

        if( count($arr)==0 || !$code || $code=='')

            return false;

        if($this->db->update('city', $arr, array('id'=>$code)))

            return true;

        else

            return false;

    }



    function delete_city($id)

    {

        if(!$id || !is_numeric($id))

            return false;

        $sql    = "delete from {$this->db->dbprefix}city where id= $id";

        return $this->db->query($sql);

    }



    function get_city_list_option($id=-1,$state=-1)
    {
		
        $sql    = "SELECT * FROM {$this->db->dbprefix}city WHERE state_id=$state";

        $query = $this->db->query($sql);

        $result_arr = $query->result_array();

        $html   = '';

        foreach($result_arr as $k=>$v)

        {

            $selected   = '';

            if($id==$v['id'])

                $selected   = 'selected';

            $html   .= '<option value="'.$v['id'].'" '.$selected.'>'.$v['name'].'</option>';

        }

        return $html;

    }

 	function get_region_list($toshow=-1,$page=0,$arr=array(),$order_name='region',$order_type='asc')
    {
        $sucond = ' WHERE 1 ';
        $pageLimit	= '';
        if(isset($arr['id']) && $arr['id']!=-1 && is_numeric($arr['id']) && $arr['id']>0)
            $sucond .= " AND id={$arr['id']} ";
        if(isset($arr['v']) && $arr['region']!='')
            $sucond .= " AND region LIKE '%{$arr['region']}%' ";
        if(isset($arr['ext_cond']) && $arr['ext_cond']!='')
            $sucond .= $arr['ext_cond'];
        $sql    = "SELECT * FROM {$this->db->dbprefix}region ";

        if($toshow>0)

        	$pageLimit	= ' LIMIT '.$page.','.$toshow;

        $sql    .= $sucond.' ORDER BY '.$order_name.' '.$order_type.$pageLimit;

        $query = $this->db->query($sql);

        $result_arr = $query->result_array();

        return $result_arr;
    }
	
    function get_region_list_option($id=-1)
    {
        $sql    = "SELECT * FROM {$this->db->dbprefix}region ";
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        $html   = '';
        foreach($result_arr as $k=>$v)
        {
            $selected   = '';
            if($id==$v['id'])
                $selected   = 'selected';
            $html   .= '<option value="'.$v['id'].'" '.$selected.'>'.$v['region'].'</option>';
        }
        return $html;
    }
	
	/*rubel
	*/
	

	/**
	 *
	 * @param int $id
	 * @param int $city
	 * @param string $format => "list" | "input" | "text"
	 * @return string
	 * @author Anutosh Ghosh
	 */
	function get_zip_code_list_option($id = -1, $city = -1, $format = 'list') {
		if (!empty($id) && $id != -1) {
			$sql = "SELECT * FROM {$this->db->dbprefix}zipcode WHERE id = $id";
		}
		else if (!empty($city) && $city != -1) {
			$sql = "SELECT * FROM {$this->db->dbprefix}zipcode WHERE city_id = $city";
		}
		
		
		$query = $this->db->query($sql);
		$result_arr = $query->result_array();
		$html = '';

		if ($format == 'list') {
			foreach($result_arr as $k => $v) {
				$selected = '';
				if($id == $v['id'])
					$selected = ' selected';

				$html .= '<option value="'.$v['id'].'"'.$selected.'>'.$v['zipcode'].'</option>';
			}
		}
		else if ($format == 'input') {
			$html .= '<input type="text" name="zipcode" id="zipcode" value="'.$result_arr[0]['zipcode'].'" style="width: 370px;" />';
		}
		else {
			$html .= $result_arr[0]['zipcode'];
		}
		
		return $html;
	}

	
	
	
	
	
	
	// Iman //
	function get_country_name_by_id($id='')
	{
		if($id=='' || $id<1)
			return false;
		$sql = "SELECT name FROM {$this->db->dbprefix}country WHERE id={$id}";	
		$query = $this->db->query($sql);
        $result_arr = $query->result_array();
		return $result_arr[0]['name'];

	}
	
	function get_state_name_by_id($id='')
	{
		if($id=='' || $id<1)
			return false;
		$sql = "SELECT name FROM {$this->db->dbprefix}state WHERE id={$id}";	
		$query = $this->db->query($sql);
        $result_arr = $query->result_array();
		return $result_arr[0]['name'];
	}	
	function get_city_name_by_id($id='')
	{
		if($id=='' || $id<1)
			return false;
		$sql = "SELECT name FROM {$this->db->dbprefix}city WHERE id={$id}";	
		$query = $this->db->query($sql);
        $result_arr = $query->result_array();
		return $result_arr[0]['name'];
	}	
	
    function get_city_list_option_party($id=-1)
    {
        $sql    = "SELECT * FROM {$this->db->dbprefix}city";
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        $html   = '';
        foreach($result_arr as $k=>$v)
        {
            $selected   = '';
            if($id==$v['id'])
                $selected   = 'selected';
            $html   .= '<option value="'.$v['id'].'" '.$selected.'>'.$v['name'].'</option>';
        }
        return $html;
    }	
	
    function get_location_list($toshow=-1,$page=0,$arr=array(),$order_name='zipcode',$order_type='asc')
    {
        $sucond = ' WHERE 1 ';
        $pageLimit	= '';
        if(isset($arr['id']) && $arr['id']!=-1 && is_numeric($arr['id']) && $arr['id']>0)
            $sucond .= " AND id={$arr['id']} ";
        if(isset($arr['zipcode']) && $arr['zipcode']!='')
            $sucond .= " AND zipcode LIKE '%{$arr['zipcode']}%' ";
        if(isset($arr['ext_cond']) && $arr['ext_cond']!='')
            $sucond .= $arr['ext_cond'];
        $sql    = "SELECT * FROM {$this->db->dbprefix}zipcode ";

        if($toshow>0)

        	$pageLimit	= ' LIMIT '.$page.','.$toshow;

        $sql    .= $sucond.' ORDER BY '.$order_name.' '.$order_type.$pageLimit;

        $query = $this->db->query($sql);

        $result_arr = $query->result_array();

        return $result_arr;
    }
	
}
