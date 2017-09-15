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
            <div class="heading"><h5>Member's Total Payout</h5></div>
             <div class="details" >
                 <table width="100%" class="table_border" border="0" cellspacing="5" cellpadding="0" >
                     <?
                     if(isset($pay))
                     {
                         ?>
                     <tr>
                         <td align="center" style="background-color: #614C33;" >Payout date</td>
                         <td align="center" style="background-color: #614C33;" >Payout number</td>
                         <td align="center" style="background-color: #614C33;">Amount</td>
                    </tr>
                         <?
                         foreach($pay as $k=>$v)
                         {
                             ?>
                    <tr>
                         <td align="center"><?=date('d-m-Y',$v['payout_date'])?></td>
                         <td align="center"><?=$v['level_for']?></td>
                         <td align="center"><?=$v['pay_amount']?></td>
                    </tr>
                             <?
                         }
                     }
                     else
                     {
                         ?>
                     <tr>
                        <td align="right" width="100%" colspan="3">No payout generate for this user</td>
                    </tr>
                         <?
                     }
                     ?>
                    
                    <tr>
                        <td align="right" style="padding-right:50px;" colspan="3">
                            <?=$this->pagination->create_links()?>
                        </td>
                    </tr>

                  </table>
             </div>
             
</div>

   <!--Logged Panel End-->
   <div class="clear"></div>
   <div id="toottipDiv" style="font-size: 12px;display:none; position:absolute; border:2px solid #BEBABA; background-color: white; padding: 3px;">
    </div>
</div>

