<?php



class Auto_suggest extends My_Controller {

	function __construct()
	{
		parent::__construct();
	}

    /*	
	function option($e_type='')
	{
		$data=$this->data;
		//pr($data,1);
        
		$q = strtolower($_GET["q"]);
		if (!$q) return;
		
		$result	=	$this->options_model->get_options($e_type,$q);
		
		$shaparetor	=	"|".get_random_value()."|";
		echo $shaparetor."\n";
		
		foreach($result as $value)
		{
			$value	=	$value['s_name'];
			$key	=	strtolower($value);
			echo $value.$shaparetor.$key."\n";
		}
		
	}
	
	function country()
	{
		$data=$this->data;
		$this->load->model('country_model');
		$q = strtolower($_GET["q"]);
		if (!$q) return;
		
		$result	=	$this->country_model->get_country($q);
		
	    $shaparetor	=	"|".get_random_value()."|";
		echo $shaparetor."\n";
		

		foreach($result as $value)
		{
			$value	=	$value['s_name'];
			$key	=	strtolower($value);
			echo $value.$shaparetor.$key."\n";
		}
		
	}
	
	function state($country_name)
	{
		$data=$this->data;
		$this->load->model('state_model');
		$q = strtolower($_GET["q"]);
		if (!$q) return;
		
		$result	=	$this->state_model->get_state($country_name,$q);
		
		$shaparetor	=	"|".get_random_value()."|";
		echo $shaparetor."\n";
		
		foreach($result as $value)
		{
			$value	=	$value['s_name'];
			$key	=	strtolower($value);
			echo $value.$shaparetor.$key."\n";
		}
		
	}
	*/
	function city($state_id)
	{
        $state_id = decrypt($state_id);
        
		$data=$this->data;
		$this->load->model('city_model');
		$q = strtolower($_GET["q"]);
		if (!$q) return;
		
        $s_where=" where c.i_state_id='".get_formatted_string($state_id)."' AND c.s_city Like '".get_formatted_string($q)."%'";
		$result	=	$this->city_model->fetch_multi($s_where,$i_start=0,$i_limit=10);
		
		$shaparetor	=	"|".rand(1111111,9999999)."|";
		echo $shaparetor."\n";
		
		foreach($result as $value)
		{
			$value	=	$value['s_city'];
			$key	=	strtolower($value);
			echo $value.$shaparetor.$key."\n";
		}
		
	}
    
    function search()
    {
        //echo 'i m here';
        //$state_id =  $state_id;
        
        $data=$this->data;
        $this->load->model('city_model');
        $q = strtolower($_GET["q"]);
        if (!$q) return;
        
        $temp = explode(',',$q,3);
        
        foreach($temp as $key=> $val)
        {
            $temp[$key]=trim($val);
        }
        
        if(count($temp)==3)
        {
            $search_city = $temp[0];
            $search_state = $temp[1];
            $search_country = $temp[2];
            
            $s_where=   " where 1 
                            AND c.s_city Like '".get_formatted_string($search_city)."%'
                            AND s.s_state Like '".get_formatted_string($search_state)."%'
                            AND country.s_country Like '".get_formatted_string($search_country)."%'
                        ";
        }
        else if(count($temp)==2)
        {
            $search_city = $temp[0];
            $search_state = $temp[1];
            
            $search_state2 = $temp[0];
            $search_country2 = $temp[1];
            
            $search_city3 = $temp[0];
            $search_country3 = $temp[1];
            
            $s_where=   " where 1 
                            AND ( 
                                    (
                                        c.s_city Like '".get_formatted_string($search_city)."%'
                                        AND s.s_state Like '".get_formatted_string($search_state)."%'
                                    )
                                    OR
                                    (
                                        s.s_state Like '".get_formatted_string($search_state2)."%'
                                        AND country.s_country Like '".get_formatted_string($search_country2)."%'
                                    )
                                    OR
                                    (
                                        c.s_city Like '".get_formatted_string($search_city3)."%'
                                        AND country.s_country Like '".get_formatted_string($search_country3)."%'
                                    )
                                )
                        ";
            
        }
        else if(count($temp)==1)
        {
            $search_city = $temp[0];
            $search_state = $temp[0];
            $search_country = $temp[0];

            $s_where=   " where 1 
                            AND ( 
                                        c.s_city Like '".get_formatted_string($search_city)."%'
                                        OR s.s_state Like '".get_formatted_string($search_state)."%'
                                        OR country.s_country Like '".get_formatted_string($search_country)."%'
                                )
                        ";

        
        }
        else
            return;
        /*
        $s_where=' where 1 ';
        /////////////////////////////
        foreach($search_city as $key => $val)
        {
            $search_city[$key] = " c.s_city Like '".$val."%' ";
        }
        $tmp = implode(' OR ',$search_city);
        if($tmp)
            $s_where.=" AND ($tmp) ";
        /////////////////////////////
        foreach($search_state as $key => $val)
        {
            $search_state[$key] = " s.s_state Like '".$val."%' ";
        }
        $tmp = implode(' OR ',$search_state);
        if($tmp)
            $s_where.=" AND ($tmp) ";
        /////////////////////////////
        foreach($search_country as $key => $val)
        {
            $search_country[$key] = " country.s_country Like '".$val."%' ";
        }
        $tmp = implode(' OR ',$search_country);
        if($tmp)
            $s_where.=" AND ($tmp) ";
        /////////////////////////////
        */
        
        
        
        //echo $s_where;
        
        //$s_where=" where 1 AND c.s_city Like '".$q."%'";
        $result    =    $this->city_model->fetch_multi($s_where,$i_start=0,$i_limit=10);
        
        $shaparetor    =    "|".rand(1111111,9999999)."|";
        echo $shaparetor."\n";
        
        foreach($result as $value)
        {
            $value    =    $value['s_city'].', '.$value['s_state'].', '.$value['s_country'];
            $key    =    strtolower($value);
            echo $value.$shaparetor.$key."\n";
        }
        
    }	
}