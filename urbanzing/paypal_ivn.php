<?php
$system_folder = "system";

/*
|---------------------------------------------------------------
| APPLICATION FOLDER NAME
|---------------------------------------------------------------
|
| If you want this front controller to use a different "application"
| folder then the default one you can set its name here. The folder
| can also be renamed or relocated anywhere on your server.
| For more info please see the user guide:
| http://codeigniter.com/user_guide/general/managing_apps.html
|
|
| NO TRAILING SLASH!
|
*/
	$application_folder = "application";

/*
|===============================================================
| END OF USER CONFIGURABLE SETTINGS
|===============================================================
*/


/*
|---------------------------------------------------------------
| SET THE SERVER PATH
|---------------------------------------------------------------
|
| Let's attempt to determine the full-server path to the "system"
| folder in order to reduce the possibility of path problems.
| Note: We only attempt this if the user hasn't specified a
| full server path.
|
*/
if (strpos($system_folder, '/') === FALSE)
{
	if (function_exists('realpath') AND @realpath(dirname(__FILE__)) !== FALSE)
	{
		$system_folder = realpath(dirname(__FILE__)).'/'.$system_folder;
	}
}
else
{
	// Swap directory separators to Unix style for consistency
	$system_folder = str_replace("\\", "/", $system_folder);
}

/*
|---------------------------------------------------------------
| DEFINE APPLICATION CONSTANTS
|---------------------------------------------------------------
|
| EXT		- The file extension.  Typically ".php"
| SELF		- The name of THIS file (typically "index.php")
| FCPATH	- The full server path to THIS file
| BASEPATH	- The full server path to the "system" folder
| APPPATH	- The full server path to the "application" folder
|
*/
define('EXT', '.php');
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('FCPATH', str_replace(SELF, '', __FILE__));
define('BASEPATH', $system_folder.'/');
//echo BASEPATH;
if (is_dir($application_folder))
{
	define('APPPATH', $application_folder.'/');
}
else
{
	if ($application_folder == '')
	{
		$application_folder = 'application';
	}

	define('APPPATH', BASEPATH.$application_folder.'/');
}

include('system/application/config/database.php');
echo 1;
mysql_connect($db['default']['hostname'], $db['default']['username'], $db['default']['password']);
mysql_select_db($db['default']['database']);

$sql    = "SELECT * FROM {$db['default']['dbprefix']}user_tmp WHERE username='{$_REQUEST['custom']}'";
echo $sql;
$rs = mysql_query($sql);
$data   = mysql_fetch_array($rs);
if(isset($data) && isset($data[0]))
{
    $sql    = "INSERT INTO {$db['default']['dbprefix']}user 
                SET username='{$data[0]['username']}',
                name='{$data[0]['name']}',
                postal_address='{$data[0]['postal_address']}',
                city='{$data[0]['city']}',
                state='{$data[0]['state']}',
                country='{$data[0]['country']}',
                sex='{$data[0]['sex']}',
                dob='{$data[0]['dob']}',
                m_status='{$data[0]['m_status']}',
                phone='{$data[0]['phone']}',
                phone_1='{$data[0]['phone_1']}',
                email='{$data[0]['email']}',
                password='{$data[0]['password']}',
                pan_no='{$data[0]['pan_no']}',
                user_code='{$data[0]['user_code']}',
                p_id='{$data[0]['p_id']}',
                level='{$data[0]['level']}',
                restricted='{$data[0]['restricted']}',
                join_date='{$data[0]['join_date']}'
                ";
                echo $sql;
    mysql_query($sql);
    $sql     = "SELECT * FROM {$db['default']['dbprefix']}site_settings";
    $rs= mysql_query($sql);
    $site_settings  = mysql_fetch_array($rs);
    $charge = $site_settings[0]['registration_charge']+$site_settings[0]['paypal_charge'];
    $sql    = "INSERT INTO {$db['default']['dbprefix']}uesr_payment 
                    SET pay_type='Paypal',
                    amount='".$charge."',
                    p_date='".time()."',
                    user_code='{$data[0]['username']}'
                    ";
   mysql_query($sql);

   if($data[0]['p_status']=='L')
        $subcond    .= " left_child='$child_code' ";
    else
        $subcond    .= " right_child='$child_code' ";
   $sql = "UPDATE {$db['default']['dbprefix']}user SET $subcond WHERE user_code='{$data[0]['p_id']}'";
   mysql_query($sql);
    send_registration_money_recipt($data[0],$charge);
    $sql    = "SELECT * FROM {$db['default']['dbprefix']}sms WHERE status=1";
    $rs= mysql_query($rs);
    $sms    = mysql_fetch_array($rs);
    if(isset($sms) && isset($sms[0]) && isset($data[0]['phone_1']) && $data[0]['phone_1']!='')
    {
            $ph = '91'.$data[0]['phone_1'];
            $url    = "http://bulksms.mysmsmantra.com:8080/WebSMS/SMSAPI.jsp?username=fltt&password=823618669&sendername=fltt&mobileno=".$ph."&message=".urlencode($sms[0]['description']);
            file_get_contents($url);
        }
}
    function send_registration_money_recipt($arr,$amount)
    {
        $html   ='sujit1176@gmail.com
                <div style="text-align: center;border:1px solid #95754e; padding-bottom:25px;">

                    <div style="width:670px; margin:0 auto; margin-top:50px; padding-top:10px; min-height:30px; background:#614c33;"><img alt="" src="'.base_url().'images/front/logo.png"/> <h5 style="font-size:13px; color:#FFFFFF; text-align:center;">Money recipt</h5></div>
                <div style="width:670px; margin:0 auto; background:#bc9666; min-height:75px; font-size:12px; color:#FFFFFF;">
                 <table width="100%" cellspacing="5" cellpadding="0" border="0" style="border-collapse: collapse;">
                    <tr>
                        <td width="50%" align="right" colspan="2" style="border:1px solid #614c33">Name:</td>
                        <td width="50%" align="left" colspan="2" style="border:1px solid #614c33">'.$arr['name'].'</td>
                    </tr>
                    <tr>
                        <td width="50%" align="right" colspan="2">Date of join:</td>
                        <td width="50%" align="left" colspan="2" style="border:1px solid #614c33">'.date('d-m-Y').'</td>
                    </tr>
                    <tr>
                        <td width="50%" align="right" colspan="2" style="border:1px solid #614c33">User code:</td>
                        <td width="50%" align="left" colspan="2" style="border:1px solid #614c33">'.$arr['user_code'].'</td>
                    </tr>
                    <tr>
                        <td width="50%" align="right" colspan="2" style="border:1px solid #614c33">User name:</td>
                        <td width="50%" align="left" colspan="2" style="border:1px solid #614c33">'.$arr['username'].'</td>
                    </tr>
                    <tr>
                        <td width="50%" align="right" colspan="2" style="border:1px solid #614c33">Parrent id:</td>
                        <td width="50%" align="left" colspan="2" style="border:1px solid #614c33">'.$arr['p_id'].'</td>
                    </tr>
                    <tr>
                        <td width="50%" align="right" colspan="2" style="border:1px solid #614c33">Amount:</td>
                        <td width="50%" align="left" colspan="2" style="border:1px solid #614c33">'.$amount.'</td>
                    </tr>

                  </table>
                </div>
                </div>';
        mail($arr['email'], 'Registration email', $html);
    }
?>
