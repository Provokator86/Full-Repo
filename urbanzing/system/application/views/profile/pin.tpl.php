<div class="cont_part">
    <div class="margin10"></div>
    <!--Logged Panel-->
    <div class="logged_page" style="text-align: center;">
            <h1>:: Welcome to FLTT. ::</h1>
            <div class="heading"><h5>Member's Current Status</h5></div>
             <div class="details" >
                 <table width="100%" class="table_border" border="0" cellspacing="5" cellpadding="0" >
                    <tr>
                        <td align="right" width="50%" colspan="2">Name:</td>
                        <td align="left" width="50%" colspan="2"><?=$user_detail[0]['name']?></td>
                    </tr>
                    <tr>
                        <td align="right" width="50%" colspan="2">Date of join:</td>
                        <td align="left" width="50%" colspan="2"><?=date("d-m-Y",$user_detail[0]['join_date'])?></td>
                    </tr>
                    <tr>
                        <td align="right" width="50%" colspan="2">Email:</td>
                        <td align="left" width="50%" colspan="2"><?=$user_detail[0]['email']?></td>
                    </tr>
                    <tr>
                        <td align="right" width="50%" colspan="2">User Id:</td>
                        <td align="left" width="50%" colspan="2"><?=$user_detail[0]['user_code']?></td>
                    </tr>
                    <tr>
                        <td align="right" width="25%" >Total Income:</td>
                        <td align="left" width="25%" ><?=$user_detail[0]['total_income']?></td>
                        <td align="right" width="25%" >Paid amount:</td>
                        <td align="left" width="25%" ><?=$user_detail[0]['total_paid']?></td>
                    </tr>
                    <tr>
                        <td align="right" width="25%" >Total left side:</td>
                        <td align="left" width="25%" ><?=$user_detail[0]['left_total']?> Members</td>
                        <td align="right" width="25%" >Total right side:</td>
                        <td align="left" width="25%" ><?=$user_detail[0]['right_total']?> Members</td>
                    </tr>
                  </table>
             </div>
            <div class="heading"><h5>Member's Total Prepaid Voucher Detail</h5></div>
             <div class="details" >
                 <table width="100%" class="table_border" border="0" cellspacing="5" cellpadding="0" >
                     <?
                     if(isset($user_pin) && isset($user_pin[0]['pin_code']))
                     {
                         ?>
                     <tr>
                         <td align="center" style="background-color: #614C33;" >Prepaid voucher</td>
                         <td align="center" style="background-color: #614C33;" >Creation date</td>
                         <td align="center" style="background-color: #614C33;">Used user Id</td>
                         <td align="center" style="background-color: #614C33;">Used date</td>
                    </tr>
                         <?
                         foreach($user_pin as $k=>$v)
                         {
                             ?>
                    <tr>
                         <td align="center"><?=$v['pin_code']?></td>
                         <td align="center"><?=date('d-m-Y',$v['date_creation'])?></td>
                         <td align="center"><?=$v['used_code']?></td>
                         <td align="center"><?=($v['used_code'])?date('d-m-Y',strtotime($v['used_date'])):''?></td>
                    </tr>
                             <?
                         }
                     }
                     else
                     {
                         ?>
                     <tr>
                         <td align="center" width="100%" colspan="4">No prepaid voucher found for this user</td>
                    </tr>
                         <?
                     }
                     ?>
                  </table>
             </div>
            <?
            if($amount_in_hand >=$reg_charge)
            {
            ?>
            <div class="heading">
                <form method="post" id="frm_user" name="frm_user" action="<?=base_url().'profile/insert_pin'?>" >
                    <select id="tot_pin" name="tot_pin">
                        <?
                        for($i=1;$i<=10;$i++)
                        {
                            ?>
                        <option value="<?=$i?>"><?=$i?></option>
                            <?
                        }
                        ?>
                    </select>
                    <h5><a style="color:#FFFFFF;" onclick="document.frm_user.submit();">Generate prepaid voucher</a> </h5>
                </form>
            </div>
            <?
            }
            ?>
             
</div>

   <!--Logged Panel End-->
   <div class="clear"></div>
   <div id="toottipDiv" style="font-size: 12px;display:none; position:absolute; border:2px solid #BEBABA; background-color: white; padding: 3px;">
    </div>
</div>

