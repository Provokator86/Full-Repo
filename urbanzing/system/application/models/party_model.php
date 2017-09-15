<?php
class Party_model extends My_model
{

  public function __construct()
    {
		parent::__construct();
	}	

	/**
	 * @author Rubel Debnath
	 * @author Arnab
	 */
    function get_party_list($arr=array(),$toshow=-1,$page=0,$order_by='cr_date',$order_type='asc')
    {
		$CI = get_instance();
		$CI->load->model('location_model');
		$limit		= "";
		$subcond	= " where 1";
		if(isset($arr['id']) && $arr['id']!='')
			$subcond	.= " and p.id='{$arr['id']}' ";
		if(isset($arr['event_title']) && $arr['event_title']!='')
			$subcond	.= " and p.event_title LIKE '%{$arr['event_title']}%' ";
		if(isset($arr['status']) && $arr['status'].'a'!='a' && $arr['status']!=-1)
			$subcond	.= " and p.status='{$arr['status']}' ";
		if(isset($arr['host_name']) && $arr['host_name']!='')
			$subcond	.= " and p.host_name LIKE '%{$arr['host_name']}%' ";


		$sql		= " select p.*,u.f_name
						from {$this->db->dbprefix}party p INNER JOIN
						{$this->db->dbprefix}users u ON u.id = p.cr_by
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
		if($result)
		{
			foreach($result as $key=>$value)
			{
				$result[$key]['contry'] = $CI->location_model->get_country_name_by_id($value['country_id']);
				$result[$key]['state'] = $CI->location_model->get_state_name_by_id($value['state_id']);
				$result[$key]['city'] = $CI->location_model->get_city_name_by_id($value['city_id']);
			}
		}
		return $result;
	}

	/**
	 * @param array $arr
	 * @return array
	 *
	 * @author Rubel Debnath
	 * @author Arnab
	 */
    function get_party_list_count($arr=array())
    {

       $subcond	= " where 1 ";
		if(isset($arr['id']) && $arr['id']!='')
			$subcond	.= " and p.id='{$arr['id']}' ";
		if(isset($arr['event_title']) && $arr['event_title']!='')
			$subcond	.= " and p.event_title LIKE '%{$arr['event_title']}%' ";
		if(isset($arr['status']) && $arr['status']!='' && $arr['status']!=-1)
			$subcond	.= " and p.status='{$arr['status']}' ";
		if(isset($arr['host_name']) && $arr['host_name']!='')
			$subcond	.= " and p.host_name LIKE '%{$arr['host_name']}%' ";
		$sql		= " select p.*,u.f_name
						from {$this->db->dbprefix}party p INNER JOIN
						{$this->db->dbprefix}users u ON u.id = p.cr_by

						";

        $sql    .= $subcond;

        $query = $this->db->query($sql);
		return $query->num_rows();
    }
	
	function get_party_invitation_list($toshow=-1,$page=0,$arr=array(),$order_by='cr_date',$order_type='asc')
	{
$limit		= "";
		$subcond	= " where 1 ";
		if(isset($arr['id']) && $arr['id']!='')
			$subcond	.= " and i.id='{$arr['id']}' ";
		if(isset($arr['party_id']) && $arr['party_id']!='')
			$subcond	.= " and i.party_id='{$arr['party_id']}' ";
		if(isset($arr['status']) && $arr['status'].'a'!='a' && $arr['status']!=-1)
			$subcond	.= " and i.status='{$arr['status']}' ";	
							
		$sql		= " select i.*,p.event_title, u.f_name, u.email user_email
						from {$this->db->dbprefix}party p INNER JOIN 
						{$this->db->dbprefix}invites i ON p.id = i.party_id
						INNER JOIN {$this->db->dbprefix}users u ON u.id = p.cr_by
						$subcond
						order by $order_by $order_type
							";
		if($toshow>0)
		{
			$limit	= " limit $page,$toshow ";
		}
		 $sql .= $limit; 
		
		$query = $this->db->query($sql);

		$result = $query->result_array();

		return $result;	
	}
	
	
	                                                        
}