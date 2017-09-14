<script type="text/javascript">
jQuery(function($){
	$(document).ready(function(){
			$(".chake-box .checkbox-select").click(
					function() { 
						$(this).prev().attr("checked","checked");
						var str = return_selected('user_type');	
									
						$("#h_str_type").val(str);						
						$("#form_cheked_type").submit();	
						
					}
				);
				
				$(".chake-box .checkbox-deselect").click(
					function() { 
						$(this).prev().attr("checked","");
						var str = return_selected('user_type');
						
						$("#h_str_type").val(str);						
						$("#form_cheked_type").submit();	
						
					}
				);
				
			
			// function that return the string
				var return_selected = function(class_name){
				var str = '';
									$("."+class_name+":checked").each(function(i){									
												str+=$(this).val()+',';					
											});
											return str;
										};
												
	});
});
</script>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="container-box">
    <?php include_once(APPPATH."views/fe/common/message.tpl.php"); ?> 
    <?php include_once(APPPATH."views/fe/common/account_left_menu.tpl.php"); ?>
    <div class="right-part02">
          <div class="text-container">
          <div class="chake-box">
          <form name="form_cheked_type" id="form_cheked_type" action="<?php echo base_url().'dashboard' ?>" method="post" enctype="multipart/form-data">
		  <input type="hidden" name="h_str_type" id="h_str_type" value="<?php echo $posted["h_str_type"] ?>" />
		  <?php //$str_type = explode(',',$posted["src_user_type"]); //pr($str_room); ?>
					 <div class="checklist margin08">
							<div class="checkbox_list <?php echo ($i_am_owner==1)?"selected":""; ?>">
								  <input class="user_type" <?php echo ($i_am_owner==1)?"checked":""; ?> name="i_owner_checked" value="1" type="checkbox" id="choice_contact_01"/>
								  <a class="checkbox-select" href="javascript:void(0);">Select</a> 
								  <a class="checkbox-deselect" href="javascript:void(0);">Cancel</a>
								  <div class="checkbox_txt">I am Property Owner </div>
								  <div class="spacer"></div>
							</div>
							
					  </div>
						<div class="checklist">
						<div class="checkbox_list <?php echo ($i_am_traveler==1)?"selected":""; ?>">
							  <input class="user_type" <?php echo ($i_am_traveler==1)?"checked":""; ?> name="i_traveler_checked" value="2" type="checkbox" id="choice_contact_02"/>
							  <a class="checkbox-select" href="javascript:void(0);">Select</a> 
							  <a class="checkbox-deselect" href="javascript:void(0);">Cancel</a>
							  <div class="checkbox_txt">I am Traveler</div>
							  <div class="spacer"></div>
						</div>
                            
                      </div>
                      </form>
                      </div>
                      <br class="spacer" />
          
                <div class="inner-box03 margin-bottom0">
                      <div class="page-name02">My Listed Property  Booking</div>
	  <?php if($property_booking) {
			$i = 1;					  
			foreach($property_booking as $value)
				{
				$class = ($i==count($property_booking))?"class='property-boking-box bordernone'":"class='property-boking-box'";
				//pr($value); 				
			$traveler_url=encrypt($value["i_traveler_user_id"]).make_my_url($value["s_first_name"].' '.$value["s_last_name"]);
			
			$property_url	=	encrypt($value['i_property_id']).'/'.make_my_url($value['s_accommodation']).'/'.make_my_url($value['s_property_name']) ;
				
				if($value["t_booked_from"] > strtotime('-1 day'))
				{
				
	   ?>
                      
                      <div <?php echo $class ?>>
                      <div class="property-name">
					  <?php /*?><a href="<?php echo base_url().'property/details/'.encrypt($value["i_property_id"]) ?>"><?php echo $value["s_property_name"] ?></a><?php */?>
					  <a href="<?php echo base_url().'property/details/'.$property_url ?>"><?php echo $value["s_property_name"] ?></a>
					  </div>
                      <div class="small-text">Booked By  <span>
					  <a href="<?php echo base_url().'profile/'.$traveler_url ?>"><?php echo $value["s_first_name"].' '.$value["s_last_name"] ?></a></span>
					  </div>
                      <div class="spacer"></div>
                       <div class="small-text margin00">Check-in:  <span><em><?php echo $value["dt_booked_from"] ?> </em></span></div>
                        <div class="small-text"> Check-out:  <span><em><?php echo $value["dt_booked_to"] ?> </em></span></div>
                        <div class="small-text"> Guests:<span><em><?php echo $value["i_total_guests"] ?> </em></span></div>
						
						<div class="small-text"> Status:<span><em><?php echo ($value["e_status"]=='Request sent')?"Request received":""; ?> </em></span></div>
                      
                      </div>
  <?php $i++; } } } else { ?>
  <div class="property-boking-box bordernone">
	<p>No booking found</p>
  </div>
  <?php } ?>
                </div>
                
                
                
                <div class="inner-box03">
                      <div class="page-name02">My Travel Booking </div>
	  <?php if($travel_booking) {
			$i = 1;					  
			foreach($travel_booking as $value)
			{
				$class = ($i==count($property_booking))?"class='property-boking-box bordernone'":"class='property-boking-box'";
				
				$property_url	=	encrypt($value['i_property_id']).'/'.make_my_url($value['s_accommodation']).'/'.make_my_url($value['s_property_name']) ;
	   ?>
                      
                      <div <?php echo $class ?>>
                      <div class="property-name">
					 <?php /*?> <a href="<?php echo base_url().'property/details/'.encrypt($value["i_property_id"]) ?>"><?php echo $value["s_property_name"] ?></a><?php */?>
					  <a href="<?php echo base_url().'property/details/'.$property_url?>"><?php echo $value["s_property_name"] ?></a>
					  </div>
                      <div class="small-text">Booked By  <span>Me</span></div>
                      <div class="spacer"></div>
                       <div class="small-text margin00">Check-in:  <span><em><?php echo $value["dt_booked_from"] ?> </em></span></div>
                        <div class="small-text"> Check-out:  <span><em><?php echo $value["dt_booked_to"] ?> </em></span></div>
                        <div class="small-text"> Guests:<span><em><?php echo $value["i_total_guests"] ?> </em></span></div>
						
						<div class="small-text"> Status:<span><em><?php echo $value["e_status"]; ?> </em></span></div>
                      
                      </div>
					   <?php $i++; } } else { ?>
					   <div class="property-boking-box bordernone">
					  	<p>No booking found</p>
					  </div>
					  <?php } ?>
					  
                </div>
          </div>
    </div>
    <br class="spacer" />
</div>
