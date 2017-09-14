<?php
function get_year_html($sel_year=0)
{
	$html	=	'';
	
	for($i=2000;$i<=date('Y')+1;$i++)
	{
		$sel	=	$sel_year==$i?'selected':'';

	  $html	.=	"<option value='".$i."'  '".$sel."' >".$i."</option>";
	} 
	
	return $html;
}
?>
<?php
function mk_month_option($id=0)
{
 $arr_alphabet = array(
        '01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr',
        '05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug',
        '09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec'
        );
 $html='';
 foreach($arr_alphabet as $k=>$v)
 {
  $selected ='';
  if($id == $k)
   $selected = 'selected';
  $html .= "<option value='{$k}' $selected>".$v."</option>";
 }

 return $html;
}

function checking_value($value)
{
	return trim($value);
}

function showing_value($value)
{
	return htmlspecialchars($value);
}

function inserting_value($value)
{
	return addslashes($value);
}

function get_username_by_id($user_id)
{
		global $database;
		$sql='SELECT * FROM user WHERE i_id= '.$user_id.'';
		$result=$database->get_query($sql);
		$row = mysql_fetch_assoc($result);
		return $row['s_fname'].' '.$row['s_lname'];
}
	
	
function get_role_name_by_id($role_id)
{	
		global $database;
		$sql='SELECT * FROM role WHERE i_id= '.$role_id.'';
		$result=$database->get_query($sql);
		$row = mysql_fetch_assoc($result);
		return $row['s_name'];
}

function get_user_detail_by_id($user_id)
{
		global $database;
		$sql='SELECT * FROM user WHERE i_id= '.$user_id.'';
		$result=$database->get_query($sql);
		$row = mysql_fetch_assoc($result);
		return $row;
}
		
?>




