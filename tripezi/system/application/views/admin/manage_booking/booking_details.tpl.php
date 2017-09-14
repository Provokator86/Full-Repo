  <table  border="0" cellspacing="0" cellpadding="0" width="100%">
            <tr><td colspan="2" style="background-color: #D0D0D0;"><strong>Booking Details</strong></td></tr>
            <tr><td width="130px"><strong>Booking ID :</strong></td><td><?php echo $info_booking['s_booking_id']; ?></td></tr>
            <tr><td><strong>Booked By :</strong></td><td><?php echo ucfirst($info_booking['s_first_name']).' '.ucfirst($info_booking['s_last_name']); ?></td></tr>  
            <tr><td><strong>Check In Date :</strong></td><td><?php echo $info_booking['dt_booked_from']; ?></td></tr>
            <tr><td><strong>Check Out Date :</strong></td><td><?php echo $info_booking['dt_booked_to']; ?></td></tr>
            <tr><td colspan="2">&nbsp;<td></tr>
            <tr><td colspan="2" style="background-color: #D0D0D0;"><strong>Number Of Guest(<?php echo $info_booking['i_total_guest']; ?>)</strong></td></tr>
            <?php if(!empty($info_guest))
                    {
                        foreach($info_guest as $val)
                        {
            ?>
            <tr><td colspan="2"><?php echo $val['s_name']; ?></td></tr>
            <?php
                        }
                    }
            ?>
            <tr><td colspan="2">&nbsp;<td></tr>  
            <tr><td colspan="2" style="background-color: #D0D0D0;"><strong>Amount in <?php echo $info_booking['s_currency_code']; ?></strong></td></tr>
           <?php /*  <tr><td><strong>Booking Price :</strong></td><td><?php echo number_format($info_booking['d_amount_paid'],2); ?></td></tr>  */ ?>
            <tr><td><strong>Service Charge :</strong></td><td><?php echo number_format($info_booking['d_service_charge_amount'],2); ?></td></tr>
            <tr><td><strong>Site Commission :</strong></td><td><?php echo number_format($info_booking['d_site_commission_amount'],2); ?></td></tr>
            <tr><td><strong>Paid to Host :</strong></td><td><?php echo number_format($info_booking['d_host_amount'],2); ?></td></tr>
            <tr><td><strong>Amount Paid :</strong></td><td><?php echo number_format($info_booking['d_amount_paid'],2); ?></td></tr>
            
            <tr><td colspan="2">&nbsp;<td></tr>  
            <tr><td colspan="2" style="background-color: #D0D0D0;"><strong>Amount in GBP</strong></td></tr>
            <?php /*  <tr><td><strong>Booking Price :</strong></td><td><?php echo number_format($info_booking['d_currency_rate_gbp']*($info_booking['d_amount_paid']/$info_booking['d_currency_rate']),2); ?></td></tr>   */ ?>
            <tr><td><strong>Service Charge :</strong></td><td><?php echo number_format($info_booking['d_currency_rate_gbp']*($info_booking['d_service_charge_amount']/$info_booking['d_currency_rate']),2); ?></td></tr>
             <tr><td><strong>Site Commission :</strong></td><td><?php echo number_format($info_booking['d_currency_rate_gbp']*($info_booking['d_site_commission_amount']/$info_booking['d_currency_rate']),2); ?></td></tr>
            <tr><td><strong>Paid to Host :</strong></td><td><?php echo number_format($info_booking['d_currency_rate_gbp']*($info_booking['d_host_amount']/$info_booking['d_currency_rate']),2); ?></td></tr>
            <tr><td><strong>Amount Paid :</strong></td><td><?php echo number_format($info_booking['d_currency_rate_gbp']*($info_booking['d_amount_paid']/$info_booking['d_currency_rate']),2); ?></td></tr>
  </table>