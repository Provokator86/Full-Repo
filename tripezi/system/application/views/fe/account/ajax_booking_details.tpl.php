<div class="lable07">Property Name:</div>
<div class="lable08"><?php echo $info_booking['s_property_name']; ?></div>
<div class="lable07">Property Id:</div>
<div class="lable08"><?php echo $info_booking['s_property_id']; ?></div>

<div class="lable07">Property Address:</div>
<div class="lable08"><?php echo $info_booking['property_city'].', '.$info_booking['property_state'].'<br/>'.$info_booking['property_country'].','.$info_booking['property_zipcode']; ?></div>
<div class="lable07">Property Type:</div>
<div class="lable08"><?php echo $info_booking['s_accommodation']; ?></div>

<div class="spacer"></div>

<div class="lable07">Owner name:</div>
<div class="lable08"><?php echo ucfirst($info_owner['s_first_name']).' '.ucfirst($info_booking['s_last_name']); ?></div>
<div class="lable07">&nbsp;</div>
<div class="lable08">&nbsp;</div>
<div class="lable07">Owner Email:</div>
<div class="lable08"><?php echo $info_owner['s_email']; ?></div>
<div class="lable07">Owner Ph. Number:</div>
<div class="lable08"><?php echo $info_owner['s_phone_number']; ?></div>
<div class="lable07">Owner Address:</div>
<div class="lable08"><?php echo $info_owner['s_address'].'<br/>'.$info_owner['s_city'].', '.$info_owner['s_state'].'<br/>'.$info_owner['s_country']; ?></div>
<div class="lable07">&nbsp;</div>
<div class="lable08">&nbsp;</div>

<div class="spacer"></div>

<div class="lable07">Booking Id:</div>
<div class="lable08"><?php echo $info_booking['s_booking_id']; ?></div>
<div class="lable07">Booked By:</div>
<div class="lable08"><?php echo ucfirst($info_traveler['s_first_name']).' '.ucfirst($info_traveler['s_last_name']); ?></div>
<div class="lable07">Traveler Email:</div>
<div class="lable08"><?php echo $info_traveler['s_email']; ?></div>
<div class="lable07">Traveler Ph. Number:</div>
<div class="lable08"><?php echo $info_traveler['s_phone_number']; ?></div>

<div class="lable07">Traveler Address:</div>
<div class="lable08"><?php echo $info_traveler['s_address'].'<br/>'.$info_traveler['s_city'].', '.$info_traveler['s_state'].'<br/>'.$info_traveler['s_country']; ?></div>
<div class="lable07">&nbsp;</div>
<div class="lable08">&nbsp;</div>

<div class="spacer"></div>

<div class="lable07">Check In Date:</div>
<div class="lable08"><?php echo $info_booking['dt_booked_from']; ?></div>
<div class="lable07">Check Out Date:</div>
<div class="lable08"><?php echo $info_booking['dt_booked_to']; ?></div>

<div class="spacer"></div>
<div class="lable07">Booking Price:</div>
<div class="lable08"><?php echo $info_booking['s_currency_symbol'].$info_booking['d_host_amount']; ?></div>
<div class="lable07">Amount Paid:</div>
<div class="lable08"><?php echo $info_booking['s_currency_symbol'].$info_booking['d_amount_paid']; ?></div>
<div class="lable07">Service Charges:</div>
<div class="lable08"><?php echo $info_booking['s_currency_symbol'].$info_booking['d_service_charge_amount']; ?></div>

<div class="lable07">&nbsp;</div>
<div class="lable08">&nbsp;</div>

<div class="lable07">Total Guests :</div>
<div class="lable08"><?php echo count($info_guest); ?></div>
<div class="lable07">&nbsp;</div>
<div class="lable08">&nbsp;</div>
<div class="lable07">Guests Name:</div>
<div class="lable09">
<?php 
$str=   '';
if(!empty($info_guest))
{
    foreach($info_guest as $val)
    {

       $str .=   $val['s_name'].' ,';  

    }
}
echo trim($str,','); 
?>

</div>
