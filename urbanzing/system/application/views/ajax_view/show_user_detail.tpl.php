<div class="sign_up" style="width: 375px;">
    <div class="margin15"></div>
    <div class="signup_left" style="border: 0px;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td rowspan="3">
                    <?
                    if($row[0]['img_name']!='')
                    {
                        ?>
                    <img alt="" src="<?=base_url().'images/uploaded/user/thumb/'.$row[0]['img_name']?>"/>
                        <?
                    }
                    else
                    {
                        ?>
                    <img alt="" src="<?=base_url().'images/front/img_03.jpg'?>"/>
                        <?
                    }
                    ?>
                    </td>
            </tr>
<!--            <tr>
                <td colspan="2">
                    <?=($row[0]['screen_name']!='')?$row[0]['screen_name']:$row[0]['f_name'].' '.$row[0]['l_name']?>
                </td>
            </tr>
-->            
            <tr>
                <td colspan="2">
					<table cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td><strong>Member Status:</strong></td>
						<td><?=$user_type[$row[0]['user_type_id']]?>
				
						</td>
					</tr>
					<tr>
						<td><strong>Member Since:</strong></td>
						<td><?=date('Y-m-d',$row[0]['date_created'])?>
				
						</td>
					</tr>
					<tr>
						<td><strong>About Yourself:</strong></td>
						<td><?=(isset($row[0]['about_yourself'])&& !empty($row[0]['about_yourself']))? $row[0]['about_yourself']:'Not provided'?>
				
						</td>
					</tr>
					</table>
                    
                </td>
            </tr>
        </table>
    </div>
</div>