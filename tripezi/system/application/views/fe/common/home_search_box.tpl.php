 <script language="javascript" type="text/javascript" src="js/jquery/ui/jquery-ui-1.8.4.custom.js"></script>
 <script type="text/javascript">
 <!--
jQuery(function($){
$(document).ready(function(){

$( "#i_check_in" ).datepicker({
            dateFormat: 'dd-mm-yy',
            minDate : 0,
            changeYear: true,
            changeMonth: true,
			 onSelect: function( selectedDate ) {
                $( "#i_check_out" ).datepicker( "option", "minDate", selectedDate );
               
            }
        });

$( "#i_check_out" ).datepicker({
            dateFormat: 'dd-mm-yy',            
            minDate : 0,
            changeYear: true,
            changeMonth: true,
			 onSelect: function( selectedDate ) {
                $( "#i_check_in" ).datepicker( "option", "maxDate", selectedDate );
                
              
            }
        });

$('#ui-datepicker-div').hide();   // to hide the ui-datepicker-div 	
		
		
		

	$("#btn_home_search").click(function(){
			var b_valid =   true ;
			
			var d1 = document.getElementById('i_check_in').value;
			var d2 = document.getElementById('i_check_out').value;
			var p1 = d1.split("-");
			var p2 = d2.split("-");	
			var str1 = new Date(p1[2], p1[1] - 1, p1[0]);
			var str2 = new Date(p2[2], p2[1] - 1, p2[0]);
			
			
			if($.trim($("#search").val())=='' || $.trim($("#search").val())=='City, State, Country')
			{
				$("#search").next().next(".err").html('<strong>Please provide location.</strong>').slideDown('slow'); 
				b_valid  =  false;
			}
			
			
			/*if(($.trim($("#i_check_in").val())=="" || $.trim($("#i_check_in").val())=="dd-mm-yyyy") && ($.trim($("#i_check_out").val())=="" || $.trim($("#i_check_out").val())=="dd-mm-yyyy"))
			{
				$("#guests").parents(".textfell02").next(".err").html('<strong>Please select check in, check out .</strong>').slideDown('slow');  			    		
				b_valid  =  false;
			}
			else if($.trim($("#i_check_in").val())=="" || $.trim($("#i_check_in").val())=="dd-mm-yyyy") 
			{               
				$("#guests").parents(".textfell02").next(".err").html('<strong>Please select check in .</strong>').slideDown('slow');  	
				b_valid  =  false;
			}
		
			else if($.trim($("#i_check_out").val())=="" || $.trim($("#i_check_out").val())=="dd-mm-yyyy") 
			{               
				$("#guests").parents(".textfell02").next(".err").html('<strong>Please select check out .</strong>').slideDown('slow'); 
				b_valid  =  false;
			}
			else if(str2 < str1)
			{
				$("#guests").parents(".textfell02").next(".err").html('<strong>Please select check out greater than check in .</strong>').slideDown('slow'); 
				b_valid  =  false;
			}
			else
			{
				$("#guests").parents(".textfell02").next(".err").slideUp('slow').html('');
			}*/	
			
			if(b_valid)
			{
			   $("#home_property_search").submit();
			}
	});
			/* end submitting the form */
		
			/*autocomplete suggestion box*/
			
			$("#search").autocomplete2('<?php echo base_url().'auto-suggest/search' ?>', 
				{
				width: 250,
				multiple: false,
				matchContains: true,
				mustMatch: false,
				formatItem: function(data, i, n, value) {
					return value ;
				},
				formatResult: formatResult
				
			});
			
			function formatResult(row) {
				return row[0].replace(/(<.+?>)/gi, '');
			}
			
			$('input[type=text]').attr('autocomplete', 'off');
			$('form').attr('autocomplete', 'off');
			
			
			/************ When list box click *********/ 
			$(".ac_input").change(function(){
				//alert('hi');    
			});
			
	});
				
});

		
-->					
                            
</script>
<div class="search-box">
	<form name="home_property_search" id="home_property_search" action="<?php echo base_url().'search' ?>" method="post">
		  <div class="inner-box">
				<h2>Find a place to stay?</h2>
				<div class="search-bg">
					  <input type="text" name="txt_search"  size="12" id="search"/>
					  <input  type="button" value="" class="search" />
					  <div class="err"><?php echo form_error('search'); ?></div>
				</div>
				
				
				<div class="lable01">Check-in</div>
				<div class="lable01 marginleft02">Check-out</div>
				<div class="lable01 marginleft03">Guests</div>
				<div class="small-textfell">
					  <input type="text" size="12" name="i_check_in" id="i_check_in" readonly="readonly" value="<?php echo ($i_check_in)?$i_check_in:"dd-mm-yyyy" ; ?>"/>
					  
				</div>
				
				<div class="small-textfell">
					  <input type="text" size="12" name="i_check_out" id="i_check_out" readonly="readonly" value="<?php echo ($i_check_out)?$i_check_out:"dd-mm-yyyy" ; ?>"/>	
					  				  
				</div>
				
				<div class="textfell02">
					  <select id="guests" name="guests" style=" width:63px;">
						   <?php for($i=1;$i<=10;$i++) { ?>
						   <option value="<?php echo $i ?>"><?php echo $i ?></option>
						   <?php } ?>
					  </select>
					  
				</div>
				<div class="err"><?php echo form_error('i_check_out'); ?></div>
				<br class="spacer" />          
				<input class="big-search-button"  type="button" value="" id="btn_home_search"/>
		  </div>
	</form>	  
</div>