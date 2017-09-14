<?php if($property_list) {
       $i =1;
        foreach($property_list as $value)
            {
				$class = ($i%2==0)?"manage-property-box no-border":"manage-property-box";
                $image = $value["s_property_image"][0]["s_property_image"];
				
		$traveler_url = encrypt($value['i_traveler_user_id']).'/'.make_my_url($value['s_first_name'].' '.$value['s_last_name']);
		$property_url	=	encrypt($value['i_property_id']).'/'.make_my_url($value['s_accommodation']).'/'.make_my_url($value['s_property_name']) ;
				
 ?>
<div class="<?php echo $class ?>">
            <?php echo showThumbImageDefault('property_image',$image,'small',226,150); ?>
            <?php /*?> <h3><a href="<?php echo base_url().'property/details/'.encrypt($value["i_property_id"]) ; ?>"><?php echo $value['s_property_name']; ?></a></h3><?php */?>
			 <h3><a href="<?php echo base_url().'property/details/'.$property_url; ?>"><?php echo $value['s_property_name']; ?></a></h3>
             <?php 
             
             if($value['e_status']=='Amount paid' || $value['e_status']=='Cancelled') // ammount paid and prorety is booked
             {
                 $onclick   =   'onclick="show_booking_details(\''.encrypt($value['id']).'\');"' ;
             }
             else
             {
                 $onclick   =   '';
             }
             ?>
             <p><?php echo $value['s_accommodation']; ?>(
             <?php if($onclick!='')
             {?> <a href="javascript:void(0);" <?php  echo $onclick; ?> >
             <?php
             }
             ?>
                Guest <?php echo $value['i_total_guests']; ?>
            <?php if($onclick!='')
             {?>
             </a>
              <?php
             }
             ?>
             ) </p>
            <p><?php echo show_star(round($value["rate"][0]["avg_rating"])); ?> <?php echo $value["rate"][0]["i_total"] ?> reviews </p>
             <ul>
			 <li>Booked On: <span><?php echo $value['dt_booked_on']; ?></span></li>
            <?php /*?> <li>Check In: <span><?php echo $value['dt_booked_from']; ?></span></li>
             <li>Check Out: <span><?php echo $value['dt_booked_to']; ?></span></li><?php */?>
			  <li>Check In: <span><?php echo $value['dt_booked_from']; ?></span>
			  Check Out: <span><?php echo $value['dt_booked_to']; ?></span></li>
             <li>Property Booked By:<span><a href="<?php echo base_url().'profile/'.$traveler_url; ?>"><?php echo $value['s_first_name']; ?></a></span>
            <?php /*?> <?php 
             if($value['e_status']=='Amount paid' && time()<$value['t_booked_to'])
             { ?>
              <em><a href="<?php echo base_url().'write-a-message/'.encrypt($value['id']); ?>">Write Message</a></em>
             <?php 
             } ?><?php */?>
			  <?php 
             if(time()<$value['t_booked_to'] && $value['e_status']!='Cancelled' && $value['e_status']!='Cancelled and Approved by admin')
             { ?>
              <em><a href="<?php echo base_url().'write-a-message/'.encrypt($value['id']); ?>">Write Message</a></em>
             <?php 
             } ?>
              </li>
             <li>Status: <span><?php 
             if($value['e_status']=='Request sent')
             {
                 echo 'Requested '.'<a href="javascript:void(0);" style="cursor:pointer;" onclick="approveBookingRequest(\''.encrypt($value['id']).'\',this);">Click Here to approve</a>';
             }
             else if($value['e_status']=='Approve by user')
             {
                 echo 'Approved';
                 
             }
             else if($value['e_status']=='Amount paid')
             {
                 echo 'Amount paid';
                 
             }
             else if($value['e_status']=='Cancelled')
             {
                 echo 'Awaiting for admin response';
                 
             }
             else if($value['e_status']=='Cancelled and Approved by admin')
             {
                 echo 'Cancelled';
                 
             } ?></span></li>
             </ul>
             <h4><?php echo showAmountCurrency(getAmountByCurrency($value["d_standard_price"],$value["i_currency_id"])) ?>/night</h4>
             <br class="spacer" />
             </div>
             <?php  $i++; } } else { ?>
			 <div class="manage-property-box no-border">
				<p>No property found.</p>
			</div>
			<?php } ?>
 <div class="page-number">
     <?php echo $page_links; ?>
 </div>
