<?php
/*********
* Author: ACS
* Date  : 31 March 2014
* Modified By: 
* Modified Date:
* 
* Purpose:
* Model For User
* 
* @package User
* @subpackage User
* 
* @link MY_Model.php
* @link controllers/project.php
* @link views/web_master/project/
*/



class Project_model extends MY_Model
{
    private $conf,$tbl_u,$tbl_ut,$tbl_pr,$tbl_pr_c,$tbl_pr_m,$tbl_pr_p,$tbl_pr_st,$tbl_pr_t,$tbl_pr_tm, $tbl_pr_d, $tbl_cl,
            $tbl_cl_r, $tbl_ag, $tbl_cert, $tbl_pl, $tbl_ar, $tbl_con, $tbl_permit_ag, $tbl_permit, $tbl_per, $tbl_mst, $tbl_pr_u;

    public function __construct()
    {
        try
        {
            parent::__construct();
            $this->tbl_u        = $this->db->USER;
            $this->tbl_ut        = $this->db->USER_TYPE;
            $this->tbl_pr        = $this->db->PROJECTS;
            $this->tbl_pr_u        = $this->db->PROJECT_USER;
            $this->tbl_pr_c        = $this->db->PROJECT_CERTIFICATES;
            $this->tbl_pr_d        = $this->db->PROJECT_DOCUMENTS;
            $this->tbl_pr_m        = $this->db->PROJECT_MILESTONE;
            $this->tbl_pr_p        = $this->db->PROJECT_PERMITTING;
            $this->tbl_pr_st    = $this->db->PROJECT_STAKEHOLDERS;
            $this->tbl_pr_t        = $this->db->PROJECT_TEAM;
            $this->tbl_pr_tm    = $this->db->PROJECT_TEAM_MEMBER;
            $this->tbl_cl        = $this->db->CLIENT;
            $this->tbl_cl_cp    = $this->db->CLIENT_CONTACT;
            $this->tbl_cl_r        = $this->db->CONTACT_ROLL;
            $this->tbl_ag        = $this->db->AGENCY;
            $this->tbl_cert        = $this->db->CERTIFICATIONS;
            $this->tbl_pl        = $this->db->PLANER;
            $this->tbl_ar        = $this->db->ARCHITECT;
            $this->tbl_mst        = $this->db->MILESTONE_MASTER;
            $this->tbl_con        = $this->db->CONTRACTOR;
            $this->tbl_permit    = $this->db->PERMITS;
            $this->tbl_permit_ag= $this->db->PERMITS_AGENCY;
            
            $this->conf            = & get_config();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }

    /******
    * This method will fetch all records from the db. 
    * 
    * @param string $s_where, ex- " status=1 AND deleted=0 " 
    * @param int $i_start, starting value for pagination
    * @param int $i_limit, number of records to fetch used for pagination
    * @returns array
    */
    public function fetch_multi($s_where = NULL, $i_start = NULL, $i_limit = NULL, $order_by = 'p.s_mei_file', $sort_type = 'desc')
    {
        try
        {
            $admin_loggedin = $this->session->userdata('admin_loggedin');
                $user_type_id = decrypt($admin_loggedin['user_type_id']);
            $user_id = decrypt($admin_loggedin['user_id']);
            if($user_type_id !== '0')
                $team_id = $this->get_project_team($user_id);
            if($team_id != '' || $user_type_id == 0 || $user_type_id == 4)
            {
                $this->db->select('p.*, c.s_client_name, cp.s_contact_person, cp.s_client_email, pl.s_name AS s_planner,  ar.s_name AS s_architect,  con.s_name AS s_contractor,mst.s_milestone, CONCAT_WS(" ", emp.s_employee_first_name, emp.s_employee_last_name) AS POINT, (SELECT dt_due_date FROM '.$this->tbl_pr_m.' WHERE i_project_id = p.i_id AND status < 100 ORDER BY dt_due_date ASC LIMIT 0,1) AS critical_milestone_date', false)
                            ->join($this->tbl_cl_cp.' AS cp', 'cp.i_id = p.CONTACT', 'left')
                            ->join($this->tbl_cl.' AS c', 'c.i_id = p.CLIENT', 'left')
                            ->join($this->tbl_pl.' AS pl', 'pl.i_id = p.PLANNER', 'left')
                            ->join($this->tbl_ar.' AS ar', 'ar.i_id = p.ARCHITECT', 'left')
                            ->join($this->tbl_con.' AS con', 'con.i_id = p.CONTRACTOR', 'left')
                            ->join($this->tbl_mst.' AS mst', 'mst.i_id = p.i_project_status', 'left')
                            ->join($this->db->EMPLOYEE.' AS emp', 'emp.i_id = p.POINT', 'left')
                            ->where($s_where, '', false);
                if($user_type_id !== '0' && $user_type_id != 4)
                   $this->db->where("p.i_project_team_id IN ({$team_id})", '', false);    
                $tmp = $this->db->order_by($order_by, $sort_type)
                                ->get($this->tbl_pr.' AS p', $i_limit, $i_start)
                                ->result_array();   /*echo $this->db->last_query();*/
                for($i = 0; $i < count($tmp); $i++)
                {
                    $project_user_id = $this->db->select('GROUP_CONCAT(DISTINCT(i_contact_id)) AS pr_u_id', false)->get_where($this->tbl_pr_u,array('i_project_id' => $tmp[$i]['i_id']))->result_array();
                    if($project_user_id[0]['pr_u_id'] != '')
                    {
                        $t = $this->db->select('GROUP_CONCAT(s_contact_person SEPARATOR ", ") AS con', false)->where("i_id IN ({$project_user_id[0]['pr_u_id']})",'', false)->get($this->tbl_cl_cp)->result_array();
                    }
                    $tmp[$i]['project_user'] = $t[0]['con'];
                    unset($t, $project_user_id);
                }
                return $tmp;
            } 
            else return array();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }   //End of function fetch_multi
    
    // Fetch project certifications
    public function fetch_project_certifications($s_where = NULL, $i_start = NULL, $i_limit = NULL)
    {
        try
        {
            return $this->db->select('c.*, cert.s_certifications, ag.s_agency_name')
                            ->join($this->tbl_ag.' AS ag', 'ag.i_id = c.i_agency_id', 'left')
                            ->join($this->tbl_cert.' AS cert', 'cert.i_id = c.CERT', 'left')
                            ->where($s_where, '', false)
                            ->order_by('c.i_order', 'ASC')
                             ->order_by('c.i_id', 'ASC')
                             ->get($this->tbl_pr_c.' AS c', $i_limit, $i_start)
                             ->result_array();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    } 
    
    // Fetch project permitting
    public function fetch_project_permitting($s_where = NULL, $i_start = NULL, $i_limit = NULL)
    {
        try
        {
            return $this->db->select('p.*, a.s_agency_name, a.s_agency_email,s_permits')
                            ->join($this->tbl_permit_ag.' AS a', 'a.i_id = p.i_agency_id', 'left')
                            ->join($this->tbl_permit.' AS per', 'per.i_id = p.i_permit_id', 'left')
                            ->where($s_where, '', false)
                            ->order_by('p.i_order', 'ASC')
                             ->order_by('p.i_id', 'ASC')
                             ->get($this->tbl_pr_p.' AS p', $i_limit, $i_start)
                             ->result_array();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }  
    
    public function fetch_multi_sorted_list($s_where = NULL, $order_name, $order_by, $i_start = NULL, $i_limit = NULL)
    {
        try
        {
            if($s_where) $this->db->where($s_where, '', false);
            if($order_name !='' && $order_by != '') $this->db->order_by($order_name, $order_by);
            return $this->db->get($this->tbl_pr, $i_limit, $i_start)->result_array();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
    
    public function gettotal_info($s_where = NULL)
    {
        try
        {
            $admin_loggedin = $this->session->userdata('admin_loggedin');
                $user_type_id = decrypt($admin_loggedin['user_type_id']);
            $user_id = decrypt($admin_loggedin['user_id']);
            if($user_type_id !== '0')
                $team_id = $this->get_project_team($user_id);
            if($team_id != '' || $user_type_id == 0 || $user_type_id == 4)
            {
                $this->db->select('p.i_id')
                                ->join($this->tbl_cl_cp.' AS cp', 'cp.i_id = p.CLIENT', 'left')
                                //->join($this->tbl_cl.' AS c', 'c.i_id = cp.i_client_id', 'left')
                                ->join($this->tbl_cl.' AS c', 'c.i_id = p.CLIENT', 'left')
                                ->where($s_where, '' , false);
                if($user_type_id !== '0' && $user_type_id != 4)
                    $this->db->where("p.i_project_team_id IN ({$team_id})", '', false);    
                $tmp = $this->db->get($this->tbl_pr.' AS p')
                                ->result_array();
            }
            return count($tmp);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    }  //End of function gettotal_info        
    
    /*******
    * Fetches One record from db for the id value.
    * 
    * @param int $i_id
    * @returns array
    */
    public function fetch_this($i_id)
    {
        try
        {
            $tmp = $this->db->select('p.*, c.s_client_name, cp.s_contact_person, cp.s_client_email, pl.s_name AS s_planner,  ar.s_name AS s_architect,  con.s_name AS s_contractor, mst.s_milestone, CONCAT_WS(" ", emp.s_employee_first_name, emp.s_employee_last_name) AS POINT_NAME, prt.s_team_name, ag.s_agency_name', false)
                            ->join($this->tbl_cl_cp.' AS cp', 'cp.i_id = p.CONTACT', 'left')
                            ->join($this->tbl_cl.' AS c', 'c.i_id = p.CLIENT', 'left')
                            ->join($this->tbl_pl.' AS pl', 'pl.i_id = p.PLANNER', 'left')
                            ->join($this->tbl_ar.' AS ar', 'ar.i_id = p.ARCHITECT', 'left')
                            ->join($this->tbl_con.' AS con', 'con.i_id = p.CONTRACTOR', 'left')
                            ->join($this->tbl_mst.' AS mst', 'mst.i_id = p.i_project_status', 'left')
                            ->join($this->tbl_pr_t.' AS prt', 'prt.i_id = p.i_project_team_id', 'left')
                            ->join($this->tbl_ag.' AS ag', 'ag.i_id = p.i_jurisdiction', 'left')
                            ->join($this->db->EMPLOYEE.' AS emp', 'emp.i_id = p.POINT', 'left')
                            ->get_where($this->tbl_pr.' AS p', array('p.i_id'=>$i_id))->result_array();
            #pr($tmp);
            return $tmp[0];
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }  
    //End of function fetch_this    
    
    public function fetch_all_user_type()
    {
        $ret = array();
        $tmp = $this->db->select('id,s_user_type')->get_where($this->tbl_ut, array('i_status' => 1))->result_array();
        for($i = 0; $i < count($tmp); $i++)
            $ret[$tmp[$i]['id']] = $tmp[$i]['s_user_type'];
        unset($tmp);
        return $ret;
    } 
    
    //fetch all client
    public function fetch_all_client($st = true)
    {
        $ret = array();
        $where = array('i_status'=>1);
        if($st) $this->db->where($where);
        $ret[0] = 'Select';
        $tmp = $this->db->select('i_id, s_client_name')
                        ->order_by('s_client_name', 'asc')
                        ->get($this->tbl_cl)
                        ->result_array();
        for($i = 0; $i < count($tmp); $i++)
            $ret[$tmp[$i]['i_id']] = $tmp[$i]['s_client_name'];
        unset($tmp);
        return $ret;
    }
    
    //fetch all client
    public function fetch_all_client_contact_old($where = array(), $flag = true)
    {
        $ret = array();
        if($flag) $ret[0] = 'Select';
        $this->db->select('i_id, s_contact_person');
        if(!empty($where))
            $this->db->where($where);
        $tmp = $this->db->order_by('s_contact_person', 'asc')->get($this->tbl_cl_cp)->result_array();
        for($i = 0; $i < count($tmp); $i++)
            $ret[$tmp[$i]['i_id']] = $tmp[$i]['s_contact_person'];
        unset($tmp);
        return $ret;
    }
    
    public function fetch_all_client_contact($where = array(), $flag = true)
    {
        $sql = "SELECT i_id, s_contact_person FROM {$this->tbl_cl_cp} WHERE i_id IN (SELECT i_client_id FROM {$this->db->CLIENT_CONTACT_COMPANY}";

        if($where['i_client_id'] > 0)
            $sql .=" WHERE i_client_contact_id = {$where['i_client_id']} " ;
        $sql .=" ) ORDER BY s_contact_person ASC";
        $tmp = $this->db->query($sql)
                        ->result_array();
                        
        $ret = array();
        if($flag) $ret[0] = 'Select';
        /*$this->db->select('i_id, s_contact_person');
        if(!empty($where))
            $this->db->where($where);
        $tmp = $this->db->order_by('s_contact_person', 'asc')->get($this->tbl_cl_cp)->result_array();*/
        for($i = 0; $i < count($tmp); $i++)
            $ret[$tmp[$i]['i_id']] = $tmp[$i]['s_contact_person'];
        unset($tmp);
        return $ret;
    }
    
    //fetch all agency
    public function fetch_all_agency()
    {
        $ret = array();
        $ret[0] = 'Select';
        $tmp = $this->db->select('i_id, s_agency_name')->order_by('s_agency_name', 'asc')->get_where($this->tbl_ag, array('i_status'=>1))->result_array();
        for($i = 0; $i < count($tmp); $i++)
            $ret[$tmp[$i]['i_id']] = $tmp[$i]['s_agency_name'];
        unset($tmp);
        return $ret;
    }
    
    //fetch all planner
    public function fetch_all_planner()
    {
        $ret = array();
        $ret[0] = 'Select';
        $tmp = $this->db->select('i_id, s_name')->order_by('s_name', 'asc')->get($this->tbl_pl)->result_array();
        for($i = 0; $i < count($tmp); $i++)
            $ret[$tmp[$i]['i_id']] = $tmp[$i]['s_name'];
        unset($tmp);
        return $ret;
    }
    
    //fetch all architect
    public function fetch_all_architect()
    {
        $ret = array();
        $ret[0] = 'Select';
        $tmp = $this->db->select('i_id, s_name')->order_by('s_name', 'asc')->get($this->tbl_ar)->result_array();
        for($i = 0; $i < count($tmp); $i++)
            $ret[$tmp[$i]['i_id']] = $tmp[$i]['s_name'];
        unset($tmp);
        return $ret;
    }
    
    //fetch all contractor
    public function fetch_all_contractor()
    {
        $ret = array();
        $ret[0] = 'Select';
        $tmp = $this->db->select('i_id, s_name')->order_by('s_name', 'asc')->get($this->tbl_con)->result_array();
        for($i = 0; $i < count($tmp); $i++)
            $ret[$tmp[$i]['i_id']] = $tmp[$i]['s_name'];
        unset($tmp);
        return $ret;
    }
    
    
    //fetch all certifications
    public function fetch_all_certifications()
    {
        $ret = array();
        $ret[0] = 'Select';
        $tmp = $this->db->select('i_id, s_certifications')->order_by('s_certifications', 'asc')->get($this->tbl_cert)->result_array();
        for($i = 0; $i < count($tmp); $i++)
            $ret[$tmp[$i]['i_id']] = $tmp[$i]['s_certifications'];
        unset($tmp);
        return $ret;
    }
    
    //fetch all certifications
    public function fetch_all_permits_agency()
    {
        $ret = array();
        $ret[0] = 'Select';
        $tmp = $this->db->select('i_id, s_agency_name')->order_by('s_agency_name', 'asc')->get_where($this->tbl_permit_ag, array('i_status'=>1))->result_array();
        for($i = 0; $i < count($tmp); $i++)
            $ret[$tmp[$i]['i_id']] = $tmp[$i]['s_agency_name'];
        unset($tmp);
        return $ret;
    }
    
    //fetch all project team
    public function fetch_all_project_team()
    {
        $ret = array();
        $ret[-1] = 'Select';
        $ret[0] = 'No Team';
        $tmp = $this->db->select('i_id, s_team_name')->order_by('s_team_name', 'asc')->get_where($this->tbl_pr_t, array('i_status'=> 1))->result_array();
        for($i = 0; $i < count($tmp); $i++)
            $ret[$tmp[$i]['i_id']] = $tmp[$i]['s_team_name'];
        unset($tmp);
        return $ret;
    }
    
    //fetch all milestone
    public function fetch_all_milestone()
    {
        $ret = array();
        $tmp = $this->db->select('i_id, s_milestone', false)
                        ->where('i_id NOT IN(4,10,11,12,13)')
                        ->get($this->tbl_mst)
                        ->result_array();
        
        for($i = 0; $i < count($tmp); $i++)
            $ret[$tmp[$i]['i_id']] = $tmp[$i]['s_milestone'];
        unset($tmp);
        return $ret;
    }
    
    public function fetch_project_team($where = array(), $offset = NULL, $limit = NULL)
    {
        $tmp = $this->db->where($where,'', false)->get($this->tbl_pr_t, $limit, $offset)->result_array();
        for($i = 0; $i< count($tmp); $i++)
            $tmp[$i]['team_member'] = $this->get_project_member_name(" pt.i_project_team_id = {$tmp[$i]['i_id']} ");
        return $tmp;
    }
    
    public function get_project_member_name($where = '')
    {
        return $this->db->select("u.i_id AS id, CONCAT(u.s_employee_first_name,' ',u.s_employee_last_name) AS name",false)
                        ->join($this->tbl_u.' AS u','u.i_id = pt.i_emplyee_id','left')
                        ->where($where,'',false)
                        ->get($this->tbl_pr_tm.' AS pt')
                        ->result();
    }
    
    public function get_employee_name($where = '')
    {
        return $this->db->query("SELECT i_id AS id, CONCAT(s_employee_first_name,' ',s_employee_last_name) AS name FROM {$this->tbl_u} {$where} ORDER BY name ASC LIMIT 0,15")->result();
    }
    
    public function fetch_project_team_details($project_team_id)
    {
        $ret = array();
        
        // Get team info
        if(intval($project_team_id) > 0)
        {
            $sql = "SELECT pt.*, 
                        (
                            SELECT GROUP_CONCAT(i_emplyee_id) 
                                FROM {$this->tbl_pr_tm} 
                            WHERE i_project_team_id = pt.i_id
                        ) AS emplyee_id 
                        FROM {$this->tbl_pr_t} AS pt 
                        WHERE pt.i_id = {$project_team_id}";
            
            $tmp = $this->db->query($sql)->result_array();
            $ret['project_team_details'] = $tmp[0];
            unset($sql,$tmp);
        }
        
        // Get employee information 
        if($ret['project_team_details']['emplyee_id']!='')
        {
            $tmp = $this->db->select('u.*, ut.s_user_type')
                             ->join($this->tbl_ut.' AS ut', 'ut.id = u.i_user_type', 'left')
                            ->order_by('u.s_employee_first_name','asc')
                             ->get_where($this->tbl_u.' AS u', "u.i_id IN ({$ret['project_team_details']['emplyee_id']}) ")
                             ->result_array();
            $ret['team_member_details'] = $tmp;
            unset($tmp);
        }
        return $ret;
    }
    
    // Get project client information
    public function fetch_project_client($contact_id, $client = '')
    {
        if($contact_id > 0)
        {
            return $this->db->select('cp.*, s_client_name, s_email, cl.s_address AS client_address, cl.s_city AS client_city, cl.s_state AS client_state, cl.s_country AS client_country, cl.s_zip  AS client_zip, cl.s_phone AS client_phone')
                            ->join($this->tbl_cl.' AS cl', 'cl.i_id = cp.i_client_id', 'left')
                            ->get_where($this->tbl_cl_cp.' AS cp', array('cp.i_id'=>$contact_id))
                            ->result_array();
                            
            /*$sql = "SELECT cp.* FROM {$this->tbl_cl_cp} AS cp 
                    WHERE i_id IN (SELECT i_client_id FROM {$this->db->CLIENT_CONTACT_COMPANY} WHERE i_client_contact_id = {$client_id})";*/
        }
        else if($client > 0)
        {
            return $this->db->select('s_client_name, s_email, cl.s_address AS client_address, cl.s_city AS client_city, cl.s_state AS client_state, cl.s_country AS client_country, cl.s_zip  AS client_zip, cl.s_phone AS client_phone')->get_where($this->tbl_cl.' AS cl',array('i_id' => $client))->result_array();
        }
        return array();
    }
    
    /*
    +-------------------------------------------------------------------------------------------------------+
    | Used for dashboard                                                                                    |
    +-------------------------------------------------------------------------------------------------------+
    */
    public function get_last_30_days_project($admin_loggedin = '')
    {
        return $this->db->select('p.i_id, p.PROJECTNAME, p.i_project_status, t.s_team_name, cl.s_client_name')
                        ->join($this->tbl_pr_t.' AS t', 't.i_id=p.i_project_team_id', 'left')
                        ->join($this->tbl_cl.' AS cl', 'cl.i_id=p.CLIENT', 'left')
                        ->where('p.dt_created_on  >= (DATE_SUB(CURDATE(), INTERVAL 30 DAY))', '', false)
                        ->order_by('p.i_id', 'desc')
                        ->get($this->tbl_pr.' AS p')
                        ->result_array();
    }
    
    public function get_total_project_against_each_milestone($admin_loggedin = array())
    {
        $user_type_id = decrypt($admin_loggedin['user_type_id']);
        $user_id = decrypt($admin_loggedin['user_id']);
        if($user_type_id !== '0')
            $team_id = $this->get_project_team($user_id);
        if($team_id != '' || $user_type_id == 0)
        {
            $this->db->select('count(p.i_id) AS total, mst.s_milestone , p.i_project_status')
                     ->join($this->tbl_mst.' AS mst', 'mst.i_id = p.i_project_status', 'left')
                     ->group_by('p.i_project_status');
            if($user_type_id !== '0')
                $this->db->where("p.i_project_team_id IN ({$team_id})", '', false);
            return $this->db->get($this->tbl_pr.' AS p')->result_array();
        }
        else return array();
    }
    
    public function get_total_project_against_each_team($admin_loggedin = '')
    {
        $user_type_id = decrypt($admin_loggedin['user_type_id']);
        $user_id = decrypt($admin_loggedin['user_id']);
        if($user_type_id !== '0')
            $team_id = $this->get_project_team($user_id);
        if($team_id != '' || $user_type_id == 0)
        {    
            $this->db->select('count(p.i_id) AS total, t.s_team_name, p.i_project_team_id , SUM(CASE WHEN p.i_project_status != 10 THEN 1 ELSE 0 END) AS open, SUM(CASE WHEN p.i_project_status = 10 THEN 1 ELSE 0 END) AS closed', false)
                     ->join($this->tbl_pr_t.' AS t', 't.i_id=p.i_project_team_id', 'left');
                     //->where('p.i_project_status != 10','', false);
            #echo $this->db->last_query();
            if($user_type_id !== '0')
                $this->db->where("p.i_project_team_id IN ({$team_id})", '', false);
            return     $this->db->group_by('p.i_project_team_id')
                             ->order_by('t.s_team_name','ASC')
                             ->get($this->tbl_pr.' AS p')
                             ->result_array();

        }
        else return array();
    }
    
    public function get_project_total_separately($admin_loggedin = '', $FIELD)
    {
        $user_type_id = decrypt($admin_loggedin['user_type_id']);
        $user_id = decrypt($admin_loggedin['user_id']);
        if($user_type_id !== '0')
            $team_id = $this->get_project_team($user_id);
        if($team_id != '' || $user_type_id == 0)
        {    
            $this->db->select('count(p.i_id) AS total, p.'.$FIELD.' , SUM(CASE WHEN p.i_project_status != 10 THEN 1 ELSE 0 END) AS open, SUM(CASE WHEN p.i_project_status = 10 THEN 1 ELSE 0 END) AS closed', false);
            if($user_type_id !== '0')
                $this->db->where("p.i_project_team_id IN ({$team_id})", '', false);
            return $this->db->group_by('p.'.$FIELD)
                             ->order_by('p.'.$FIELD,'ASC')
                             ->get($this->tbl_pr.' AS p')
                             ->result_array();
        }
        else return array();
    }
    
    public function get_upcomming_milestone($admin_loggedin = '')
    {
        $user_type_id = decrypt($admin_loggedin['user_type_id']);
        $user_id = decrypt($admin_loggedin['user_id']);
        if($user_type_id !== '0')
            $team_id = $this->get_project_team($user_id);
        
        if($team_id != '' || $user_type_id == 0)
        {    
            $this->db->select("pm.i_project_id, GROUP_CONCAT(pm.dt_due_date) AS date, p.PROJECTNAME, GROUP_CONCAT(mst.s_milestone) AS milestone" , false)
                    ->join($this->tbl_pr.' AS p','p.i_id = pm.i_project_id', 'left')
                    ->join($this->tbl_mst.' AS mst','mst.i_id = pm.i_milestone_id', 'inner')
                    ->where('pm.dt_due_date <= DATE_ADD(CURDATE(),INTERVAL 30 DAY) AND pm.dt_due_date >=  CURDATE()');
            if($user_type_id !== '0')
                $this->db->where("p.i_project_team_id IN ({$team_id})", '', false);
            return $this->db->group_by('pm.i_project_id')
                            ->order_by('p.PROJECTNAME', 'ASC')
                            ->get($this->tbl_pr_m.' AS pm')
                            ->result_array();
        }
        else return array();
    }
    
    protected function get_project_team($user_id)
    {
        if(intval($user_id) == 0) return '';
        $tmp = $this->db->select('GROUP_CONCAT(t.i_id) AS team_id')
                        ->join($this->tbl_pr_tm.' AS tm','tm.i_project_team_id = t.i_id', 'left')
                        ->get_where($this->tbl_pr_t.' AS t',array('tm.i_emplyee_id'=>$user_id))
                        ->result_array();
        return $tmp[0]['team_id'];
    }
    
    public function get_total_project_of_client($admin_loggedin)
    {
        $user_id = decrypt($admin_loggedin['user_id']);
        if(intval($user_id) == 0) return array();
        
        $project_id = $this->get_project_id($user_id);
        if($project_id !='')
        {
            return $this->db->select('pr.PROJECTNAME, pr.f_milestone_percentage, pr.i_id,(
                                SELECT GROUP_CONCAT(m.s_milestone SEPARATOR "#") 
                                    FROM '.$this->tbl_pr_m.' AS pm
                                    LEFT JOIN '.$this->tbl_mst.' AS m ON m.i_id = pm.i_milestone_id
                                    WHERE pm.i_project_id = pr.i_id 
                                ) AS milestone',false)
                            ->where('pr.i_id IN('.$project_id.')', '', false)
                            ->order_by('pr.i_id','desc')
                            ->get_where($this->tbl_pr.' AS pr')
                            ->result_array();
        }
        return array();
    }
    
    public function get_project_count()
    {
        $ret = array();
        $ret['open'] = $this->db->select('count(i_id) as total')->where_in('i_project_status', array(1,2,3,4,5,6,7,8,9))->get($this->tbl_pr)->result_array();
        $ret['Total'] = $this->db->select('count(i_id) as total')->where('i_project_status != 0')->get($this->tbl_pr)->result_array();
        $ret['openTotal'] = $this->db->select('count(i_id) as total')->where('i_project_status = 13')->get($this->tbl_pr)->result_array();
        $ret['hold'] = $this->db->select('count(i_id) as total')->where('i_project_status = 11')->get($this->tbl_pr)->result_array();
        $ret['close'] = $this->db->select('count(i_id) as total')->where('i_project_status = 10')->get($this->tbl_pr)->result_array();
        
        $ret['count'] = $this->db->select("CONCAT_WS('#', COUNT(i_id), i_project_status) AS status", false)
                        ->group_by('i_project_status')
                        ->order_by('i_project_status', 'asc')
                        ->get_where($this->tbl_pr, 'i_project_status != 10 ')
                        ->result_array();
        /*$sql = "SELECT CONCAT_WS('#',COUNT(i_id),i_project_status) AS status 
                    FROM mc_project 
                    WHERE i_project_status != 10
                    GROUP BY i_project_status  
                    ORDER BY i_project_status";*/
 
        return $ret;
    }
    /*
    +-------------------------------------------------------------------------------------------------------+
    | End                                                                                                    |
    +-------------------------------------------------------------------------------------------------------+
    */
    
    public function fetch_project_user($project_id)
    {
        return $this->db->select('clcp.i_id, clcp.s_contact_person, clcp.s_client_email, clcp.s_password, clr.s_roll_name, cl.s_client_name, cl.s_email, com.s_client_name AS company_name')
                        ->join($this->tbl_cl_r.' AS clr','clr.i_id = pru.i_roll_id','left')
                        ->join($this->tbl_cl_cp.' AS clcp','clcp.i_id = pru.i_contact_id','left')
                        ->join($this->tbl_cl.' AS cl','cl.i_id = pru.i_client_id','left')
                        ->join($this->tbl_cl.' AS com','com.i_id = pru.i_company_id','left')
                        ->get_where($this->tbl_pr_u.' AS pru', array('pru.i_project_id' => $project_id))
                        ->result_array();
    }
    
    public function get_project_id($user_id)
    {
        $ret = '';
        if($user_id > 0)
        {
            $tmp = $this->db->select('GROUP_CONCAT(DISTINCT(i_project_id)) AS project_id', false)
                            ->get_where($this->tbl_pr_u, array('i_contact_id' => $user_id))
                            ->result_array();
            $ret = $tmp[0]['project_id'];
        }
        return $ret;
    }
    
    public function get_company_contact($client_id = 0, $flag = true)
    {
        $ret = array();
        if($flag) $ret[0] = 'Select';
        $tmp = $this->db->query("SELECT i_id, s_contact_person FROM {$this->tbl_cl_cp} WHERE i_status = 1 AND i_id IN (SELECT i_client_id FROM {$this->db->CLIENT_CONTACT_COMPANY} WHERE i_client_contact_id = {$client_id})")
                        ->result_array();
        
        for($i = 0; $i < count($tmp); $i++)
            $ret[$tmp[$i]['i_id']] = $tmp[$i]['s_contact_person'];
        unset($tmp);
        return $ret;
    }
   
    public function get_project_clicnt_by_project_name($where = '')
    {
        $res = array();
        $tmp = $this->db->select('p.i_id, p.PROJECTNAME, p.s_mei_file, cl.s_client_name')
                        ->join($this->tbl_cl.' AS cl','cl.i_id = p.CLIENT','left')
                        ->limit(1)
                        ->get_where($this->tbl_pr.' AS p', $where)
                        ->result_array();
        if(intval($tmp[0]['i_id']) > 0)
        {
            $res['project_info'] = $tmp[0];
            
            // Get project user details
            $res['project_user'] = $this->fetch_project_user($tmp[0]['i_id']);
        }
        unset($tmp, $where);
        return $res;
    }
    
    // Get last 10 project and its milestone
    public function get_latest_project_milestone()
    {
        return $this->db->select('p.i_id, p.f_milestone_percentage, p.PROJECTNAME')
                        ->where('p.i_project_status != 10')
                        ->order_by('p.dt_created_on' ,'DESC')
                        ->limit(10)
                        ->get($this->tbl_pr.' AS p')
                        ->result_array();
    }
    
    public function get_all_employee_list()
    {
        $ret = array();
        $ret[0] = 'Select';
        $tmp = $this->db->query("SELECT i_id, CONCAT(s_employee_first_name,' ',s_employee_last_name) AS name FROM {$this->db->EMPLOYEE}  ORDER BY name ASC")->result_array();
        for($i = 0; $i < count($tmp); $i++)
            $ret[$tmp[$i]['i_id']] = $tmp[$i]['name'];
        return $ret;
    }
   
    public function __destruct()
    {}                 
}
///end of class
?>