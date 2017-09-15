<?
$this->load->view('admin/common/admin_filter.tpl.php');
?>
<div style="height: 450px;text-align: center;vertical-align: middle;">
    <span><strong>Click on the code to select</strong></span>
    
    <table cellpadding="5" cellspacing="0" style="border: #cccccc 1px solid;" align="center" >
        <tr >
            <th width="250">User Id</th>
        </tr>
<?php
if(isset ($user) && isset ($user[0]))
{
   
    foreach($user as $k=>$v)
    {
       ?>
        <tr>
            <td><span style="cursor: pointer;" onclick="set_opener_value('<?=$v['user_code']?>')"><?=$v['user_code']?></span></td>
        </tr>
        <?
    }
}
else
{
    echo 'No promoter found in database';
}
?>
        </table>
    <script type="text/javascript">
        function set_opener_value(val)
        {
            opener.document.frm_user.p_id.value=val;
            opener.document.frm_user.serial_code.value='';
            window.close();
        }
    </script>
</div>