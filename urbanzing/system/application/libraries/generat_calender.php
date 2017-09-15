<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Generat_calender
{
	
    function calender($cal_name,$cal_value='')
    {
		$html='';    	
		if( $cal_name)
		{
			$html	.='
					<style type="text/css">
						.calendarDateInput {
							font-family: Verdana, Arial, Helvetica, sans-serif;
							font-size: 10px;
							font-style: normal;
							font-weight: normal;
							color: #000000;
							text-decoration: none;
							height: 20px;
							padding-top: 1px;
							border: 1px solid #999;
                            widht:50px;
						}
					</style>
					<script>
						ImageURL= "'.base_url().'js/jasons_date_input_calendar/calendar.jpg";
						NextURL	= "'.base_url().'js/jasons_date_input_calendar/next.gif";
						PrevURL	= "'.base_url().'js/jasons_date_input_calendar/prev.gif";';
			if( $cal_value)
				$html.='DateInput("'.$cal_name.'", true, "YYYY-MM-DD","'.$cal_value.'");';
			else
				$html.='DateInput("'.$cal_name.'", true, "YYYY-MM-DD");';
			$html	.= '</script>';
		}
		else
			$html.='Error !!!';
		return $html;
    }
}
?>