<?php
class Date_time_model extends My_model
{
    public $day_text    = '';
    public function __construct()
    {
        parent::__construct();
        $this->day_text = array('1'=>'Monday','2'=>'Tuesday','3'=>'Wednesday','4'=>'Thursday','5'=>'Friday','6'=>'Saturday','7'=>'Sunday');
    }

    function get_text_day_week_option($day='')
    {
        $arr    = array('1'=>'Monday','2'=>'Tuesday','3'=>'Wednesday','4'=>'Thursday','5'=>'Friday','6'=>'Saturday','7'=>'Sunday');
        $html   = '';
        foreach($arr as $k=>$v)
        {
            $selected   = '';
            if($v==$day)
                $selected   = ' selected ';
            $html   .= '<option value="'.$v.'" '.$selected.'>'.$v.'</option>';
        }
        return $html;
    }

    function get_time_detail_option($hour='')
    {
        $arr    = array('01:00','02:00','03:00','04:00','05:00','06:00','07:00','08:00','09:00','10:00','11:00','12:00');
        $arr_ap = array('am','pm');
        $html   = '';
        foreach($arr_ap as $v1)
        {
            foreach($arr as $v)
            {
                $item   = $v.' '.$v1;
                $selected   = '';
                if($hour==$item)
                    $selected   = ' selected ';
                $html   .= '<option value="'.$item.'" '.$selected.'>'.$item.'</option>';
            }
        }
        return $html;
    }

    function generate_business_hour_html($old_values,$business_id=-1)
    {
        if((!isset($old_values) || $old_values['hour']=='') && isset($business_id) && $business_id>0)
        {
            $sql    = "SELECT * FROM {$this->db->dbprefix}business_hour WHERE business_id=$business_id";
            $query = $this->db->query($sql);
            $result_arr = $query->result_array();
            foreach ($result_arr as $k=>$v)
            {
                $old_values['hour_from'.$v['day']]  = $v['hour_from'];
                $old_values['hour_to'.$v['day']]    = $v['hour_to'];
            }
        }
        $html   = '<table width="100%" cellpadding="0" cellspacing="0" border="0">';
        foreach($this->day_text as $k=>$v)
        {
            $html   .= '<tr>
                            <td align="left" width="20%">'.$v.'</td>
                            <td align="left" width="40%">
                                <select id="hour_from'.$v.'" name="hour_from'.$v.'" style="width:121px;" >
                                    <option value="">---</option>
                                    <option ';
            if($old_values['hour_from'.$v]=='closed')
                $html   .= ' selected ';
            $html   .= 'value="closed">Closed</option>';
            $html   .= $this->get_time_detail_option($old_values['hour_from'.$v]);
            $html   .=          '</select></td>
                            <td align="left">
                                <select style="width:121px; ';
            $html   .= '"  id="hour_to'.$v.'" name="hour_to'.$v.'">
                <option value="">---</option>
                ';
            $html   .= $this->get_time_detail_option($old_values['hour_to'.$v]);
            $html   .=          '</select></td>
                        </tr>';
        }
        $html   .= '</table>';
        return $html;
    }
	
	
	
	
	
	
	
	
	// added by Iman  //
	
	function generate_hour_option($hour='')
	{
		for($i=0;$i<=23;$i++)
		{
			$selected   = '';
			$i = (strlen($i)>1)?$i:'0'.$i;
			if($hour==$i)
				$selected   = ' selected ';
			$html   .= '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';			
		}
		return $html;
	}
	
	function generate_min_option($min='')
	{
		for($i=0;$i<=59;$i++)
		{
			$selected   = '';
			$i = (strlen($i)>1)?$i:'0'.$i;
			if($min==$i)
				$selected   = ' selected ';
			$html   .= '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';			
		}
		return $html;
	}
}                    