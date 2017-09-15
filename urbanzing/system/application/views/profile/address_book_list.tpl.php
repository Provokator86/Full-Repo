<div class="box01">
<?
if(isset($rows) && isset($rows[0]))
{
    $str1   = $str2 = '';
    foreach($rows as $k=>$v)
    {
//        if($k%2==0)
//        {
            $str1   .= '<tr>
                <td>'.$v['f_name'].'</td>
                <td>'.$v['email'].'</td>
            </tr>';
//        }
//        else
//        {
//            $str2   .= '<tr>
//                <td>'.$v['f_name'].'</td>
//                <td>'.$v['email'].'</td>
//            </tr>';
//        }
    }
}

?>
    <div class="address_div" style="max-height: 500px;overflow: auto;width: 600px;">
        <table width="100%" cellpadding="0" cellspacing="4" border="0">
            <tr>
                <td style="font-weight: bold;">Name</td>
                <td style="font-weight: bold;">E-mail</td>
            </tr>
            <?=$str1?>
        </table>
    </div>
    <!--<div class="address_div" style="float: right;">
        <table width="100%" cellpadding="0" cellspacing="4" border="0">
            <tr>
                <td style="font-weight: bold;">Name</td>
                <td style="font-weight: bold;">E-mail</td>
            </tr>
            <?=$str2?>
        </table>
    </div>-->
    <div class="clear"></div>
</div>