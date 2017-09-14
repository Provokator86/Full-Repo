<script type="text/javascript">
// start document ready
jQuery(function($) {
$(document).ready(function() {
    
      $(".ddChild a[id^=selectmonth_]").click(function(){
        
            $("#frm_month").submit();
        });
        
      
      $("#tab_calender td:not(.white-box)").click(function(){
          var current_obj   =   $(this) ;
          var date          =   $.trim($(current_obj).text()) ; 
          var current_month =   $("#selectmonth").val();
          var i_status      =   $(current_obj).hasClass("select") ;
          var property_id   =   '<?php echo  $property_id ?>' ;
          if(date!="")
          {
               $.ajax({
                    type: "POST",
                    async: false,
                    url: base_url+'account/ajax_property_block_date',
                    data: "date="+date+"&current_month="+current_month+'&i_status='+i_status+'&property_id='+property_id,
                    success: function(msg){
                       if(msg=="ok") 
                       {
                           if(i_status)
                           {
                               $(current_obj).removeClass("select");
                           }
                           else
                           {
                               $(current_obj).addClass("select");
                           }
                           
                       }

                }  // end success
            });  // end of ajax
              
          }
      })  ;
    
	
    
    
      // If server side validation false occur 
        <?php if($posted)
        {
            ?>
            $(".err").show();
        <?php
        } 
            ?>
        
        //var h_id    =   '<?php echo $posted['h_id']; ?>';    
        /*$(".remove").click(function(){
        var file_name   =   $("#h_image").val();   
            $.ajax({
                    type: "POST",
                    async: false,
                    url: base_url+'account/ajax_delete_image',
                    data: "h_id="+h_id+"&file_name="+file_name,
                    success: function(msg){
                   if(msg=="ok") 
                   {
                        $(".remove").remove(); 
                        $("#h_image").val(''); 
                        $(".left-photo02 img").attr('src','uploaded/default/no_image.jpg');          
                   }

                }  // end success
            });  // end of ajax
            
            
        })  ;*/
        
  
   
        
    });
});
</script>
<style>
#tab_calender th {width: 80px;}
</style>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="container-box">
	<?php include_once(APPPATH."views/fe/common/account_left_menu.tpl.php"); ?>
	<div class="right-part02">
	  <div class="text-container">
	  
		<div class="inner-box03">
			  <div class="page-name02">Manage My Property Calendar </div>
              <form action="" method="post" name="frm_month" id="frm_month">
			  <div class="select-month">Select Month</div>
               
			  <div class="select-month-dropdown">
              
					<select id="selectmonth" name="selectmonth" style="width:146px;" >
						  <!--<option value="5_2012">May 2012</option>-->
						  <?php echo makeOptionMonthYear($selected_month); ?>
					</select>
               </form>
					<ul>
						  <li><img src="images/fe/available-icon.png" alt="available" />Avaible </li>
						  <li><img src="images/fe/booked-icon.png" alt="" />Booked </li>
						  <li><img src="images/fe/booked-icon02.png" alt="" />Blocked </li>
					</ul>
			  </div>
			  <div class="spacer"></div>
			  <div class="calendar-box">
					<table id="tab_calender"  width="100%" border="0" cellspacing="0" cellpadding="0">
						  <tr>
								<th align="center" valign="middle">Mon</th>
								<th align="center" valign="middle" class="white-box"></th>
								<th align="center" valign="middle">Tue</th>
								<th align="center" valign="middle" class="white-box"></th>
								<th align="center" valign="middle">Wed</th>
								<th align="center" valign="middle" class="white-box"></th>
								<th align="center" valign="middle">Thu </th>
								<th align="center" valign="middle" class="white-box"></th>
								<th align="center" valign="middle">Fri</th>
								<th align="center" valign="middle" class="white-box"></th>
								<th align="center" valign="middle">Sat</th>
								<th align="center" valign="middle" class="white-box"></th>
								<th align="center" valign="middle">Sun</th>
						  </tr>
						   <?php
                                        $start_date =   $start_day ; 
                                        $start_date =   ($start_date==0)?7:$start_date ;
                                        $end_date   =   $total_days;
                                        $tmp      =     ($start_date+$end_date)%7 ;  
                                        //$tmp." tmp " ;
                                        $loop_end   =   $start_date+$end_date+(7-$tmp);
                                        //$loop_end." loppend " ;                                      
                                        $i  = 1;
										
                                    
                                        while($i<=$loop_end)
                                        {
                                            if($i==$start_date)
                                            {
                                                $date   =   1;
                                              
                                            }
                                            else if($i<$start_date )
                                            {
                                                 $date   =   "&nbsp;";
                                            }
                                            else 
                                            {
                                                $date   += 1;
                                               
                                            }
                                           // for those dates which are booked
                                           if(in_array($date,$info_blocked))
                                           {
                                               $class = "class='select'";
                                           }
                                           else if(in_array($date,$info_booked))
                                           {
                                               $class = "class='booked'";
                                           }
                                           else
                                           {
                                                $class  =   '';
                                           }
										   
                                            ?> 
											
                                                 <td align="center" valign="middle" <?php echo $class ?>><?php echo ($date<=$end_date)?$date:"&nbsp;"; ?></td>
                                                 <td align="center" valign="middle" class="white-box">&nbsp;</td>
                                           <?php     
                                           if($i%7==0)
                                            { ?>
                                                </tr>
                                            <?php
                                            }
                                            $i++;
                                            ?>
                                            
                                        <?php
                                        }
                                        ?>
					
						 
					</table>
			  </div>
			<!--  <input class="button-blu marginleft" type="button" value="Submit" id="btn_calender" />-->
				<div class="spacer">&nbsp;</div>
			</div>
		
		</div>
	</div>
 <br class="spacer" />
</div>