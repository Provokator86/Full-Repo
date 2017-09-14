<script type="text/javascript">
	var g_controller="<?php echo $pathtoclass;?>";
$(document).ready(function(e) {
    $(".ajax").colorbox();
	
    /*$( ".datepicker" ).datepicker({
        maxDate: '0',		
	});*/
    
   $("#dt_from").datepicker({ 
		dateFormat: 'mm/dd/yy',		
		maxDate: 0,
		onSelect: function(date){

			var selectedDate = new Date(date);
			var msecsInADay = 86400000;
			var endDate = new Date(selectedDate.getTime() + msecsInADay);

			$("#dt_to").datepicker( "option", "minDate", endDate );
			$("#dt_to").datepicker( "option", "maxDate", 0 );
			
			
			var endDate2 	= $('#dt_to').val();
			var startDate 	= $('#dt_from').val();
			
			$.ajax({
				url: g_controller+'ajax_fetch_non_ascii_classified',
				data:{startDate:startDate, endDate:endDate2},
				type: 'post',
				dataType: 'json',
				success: function(res){
					$("#non_ascii_cls").html(res.html);
				} // end success
			});
			

		}
	});

	$("#dt_to").datepicker({ 
		dateFormat: 'mm/dd/yy',		
		maxDate: 0,
	});
	
	$(".dash-search-btn").click(function(){
		var numberRegex = /^\d+$/;
		var txt = $.trim($("#txt_search").val());
		if(txt)
		{
			if(numberRegex.test(txt)) {
			   
				$("#s_name").val('');
				$("#s_batch_id").val(txt);
				$("#frm_search_2").attr('action', '<?php echo base_url('web_master/batches/show_list')  ?>')
				//s_batch_id
				$("#frm_search_2").submit();
			}  
			else
			{
				$("#s_name").val(txt);
				$("#s_batch_id").val('');
				//s_batch_id
				$("#frm_search_2").submit();
			}
		}
		else
			return false;
	});
	
	// calendar date change non classified ascii
	$('#dt_to').change(function(){
		var endDate 	= $('#dt_to').val();
		var startDate 	= $('#dt_from').val();
		
		$.ajax({
			url: g_controller+'ajax_fetch_non_ascii_classified',
			data:{startDate:startDate, endDate:endDate},
			type: 'post',
			dataType: 'json',
			success: function(res){
				$("#non_ascii_cls").html(res.html);
			} // end success
		});
		
	});
	
	
});

</script>

<div class="row">
    <div class="col-md-12">
			<?php if($this->user_type<2) { ?>
       <form class="" id="frm_search_2" name="frm_search_2" method="get" action="<?php echo base_url('web_master/customers/show_list') ?>" >
			<input type="hidden" id="h_search" name="h_search" value="advanced" />  
			<input type="hidden" id="s_payer_tin" name="s_payer_tin" value="" />  
			<input type="hidden" id="s_name" name="s_name" value="" />  
			<input type="hidden" id="s_batch_id" name="s_batch_id" value="" />  
        </form>
			<div class="search-box">
				<input type="text" name="txt_search" id="txt_search" placeholder="Customer Search" class="form-control">
				<button type="button" class="dash-search-btn"><i class="fa fa-search" aria-hidden="true"></i></button>
			</div>
			<?php } ?>
			<div class="clearfix"></div>
        <div class="box box-info">
            <?php show_all_messages(); ?>
            <div class="box-header">
                <i class="fa fa-dashboard"></i>
                <h3 class="box-title"><?php echo addslashes(t("Welcome"))?> <?php echo $admin_details['s_first_name'].' '.$admin_details['s_last_name'];?></h3>  
            </div>
			
			
			<div class="box-body">
				<div class="row">
					
					<div class="col-md-3">
						<div class="color_box blue-box">
							<div class="color_box_lt">
								<i class="fa fa-user" aria-hidden="true"></i>
							</div>
							
							<div class="color_box_rt">
								<span><?php echo $total_user ? $total_user :0; ?></span>
								<em>Total Users</em>
							</div>
						</div>
					</div>
					
					<div class="col-md-3">
						<div class="color_box light-blue-box">
							<div class="color_box_lt">
								<i class="fa fa-folder" aria-hidden="true"></i>
							</div>
							
							<div class="color_box_rt">
								<span><?php echo $ytd_batch_received ? $ytd_batch_received :0; ?></span>
								<em>YTD Batch Received</em>
							</div>
						</div>
					</div>					
					
					<div class="col-md-3">
						<div class="color_box green-box">
							<div class="color_box_lt">
								<i class="fa fa-check" aria-hidden="true"></i>
							</div>
							
							<div class="color_box_rt">
								<span><?php echo $ytd_batch_accepted?$ytd_batch_accepted :0; ?></span>
								<em>YTD Batch Accepted</em>
							</div>
						</div>
					</div>
					
					<div class="col-md-3">
						<div class="color_box light-green-box">
							<div class="color_box_lt">
								<i class="fa fa-download" aria-hidden="true"></i>
							</div>
							
							<div class="color_box_rt">
								<span><?php echo $ytd_file_downloaded ? $ytd_file_downloaded : 0; ?></span>
								<em>YTD Files Downloaded</em>
							</div>
						</div>
					</div>
					
					
				</div>
			</div>
			<!-- END OF BOXES -->
			
			<!-- START TABLES -->
			<div class="box-body">
          <div class="row">
					
                    <div class="col-md-6">
						<div class="shadow_back">
							<label style="font-size: 16px;">Forms awaiting for submission</label>
							<table border="0" cellpadding="2" cellspacing="2" width="100%" class="table table-bordered">	
								<tr>
									<th width="50%" align="center">Form</th>
									<th width="50%" style="text-align: right;">Count</th>
								</tr>    
								<?php 
								if(!empty($subMissionArr)){
									foreach($subMissionArr as $key => $val){
								?>                        
								<tr>
									<td><?php echo _form_title($key) ?></td>
									<td align="right"><?php echo $val; ?></td>
								</tr> 
								<?php }
								} else {
								?>                       
								<tr>
									<td>N/A</td>
									<td align="right">-</td>
								</tr>  
								
								<?php } ?>                     
							</table>
						</div>
                    </div>
                    
                    <div class="col-md-6">
						<div class="shadow_back">
							<label style="font-size: 16px;">Non classified ASCII</label>
							<div class="calendar-part clearfix">
								<div class="calender-box">
									<input class="form-control datepicker" type="text" name="dt_from" id="dt_from" value="<?php echo date('m/d/Y') ?>">
									<i class="fa fa-calendar" aria-hidden="true"></i>
								</div>
								<div class="calender-box">
									<input class="form-control datepicker" type="text" name="dt_to" id="dt_to" value="<?php echo date('m/d/Y') ?>">
									<i class="fa fa-calendar" aria-hidden="true"></i>
								</div>
							</div>
							<div class="clearfix"></div>
							
							<table border="0" id="non_ascii_cls" cellpadding="2" cellspacing="2" width="100%" class="table table-bordered">	
								<tr>
									<th width="50%" align="center">Form</th>
									<th width="50%" style="text-align: right;">Count</th>
								</tr>  
								<?php 
								if(!empty($nonClsAsciiArr)){
									foreach($nonClsAsciiArr as $key => $val){
								?>                        
								<tr>
									<td><?php echo _form_title($key) ?></td>
									<td align="right"><?php echo $val; ?></td>
								</tr> 
								<?php }
								} else {
								?>                       
								<tr>
									<td>N/A</td>
									<td align="right">-</td>
								</tr>  
								
								<?php } ?>                              
							</table>
						</div>
                    </div>                    
                    
				</div>
			</div>
			<!-- END TABLES -->
			
			<!-- START GRAPHS -->
			<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
			<div class="box-body">
				<div class="row"> 	
					
								
					<script type="text/javascript">
					  google.charts.load('current', {'packages':['corechart']});
					  google.charts.setOnLoadCallback(drawMultSeries);

					  function drawMultSeries() {
						// Some raw data (not necessarily accurate)
						var data = google.visualization.arrayToDataTable([
						 ['Month', 'Received', 'Accepted'],	
						 //['JAN',  165, 546],	
						 <?php echo $finalStr; ?>
					  ]);

					var options = {
					  title : 'Batch received vs accepted - Last 12 months',
					  vAxis: {title: 'Count', titleTextStyle: {color: '#505458', fontSize: 12, 	fontName: "Source Sans Pro"}, TextStyle: {color: '#505458', fontSize: 12, 	fontName: "Source Sans Pro"}},
					  hAxis: {title: 'Month', titleTextStyle: {color: '#505458', fontSize: 12, 	fontName: "Source Sans Pro"}, TextStyle: {color: '#505458', fontSize: 12, 	fontName: "Source Sans Pro"}},
					  seriesType: 'bars',
					  colors: ['#f42d22','#176da7'],	
						  titleTextStyle: {
							color: '#505458', 
							fontSize: 16, 
							//fontWeight: 'normal',
							bold: false,
							fontName: "Source Sans Pro",
						  },			
					  legend: { position: 'top', alignment: 'end', textStyle: {color: '#505458', fontSize: 10, 	fontName: "Source Sans Pro"} },
					  series: {12: {type: 'line'}}
					};

					var chart = new google.visualization.ComboChart(document.getElementById('columnchart_material'));
					chart.draw(data, options);
				  }
						
                    if (document.addEventListener) {
                        window.addEventListener('resize', drawMultSeries);
                    }
                    else if (document.attachEvent) {
                        window.attachEvent('onresize', drawMultSeries);
                    }
                    else {
                        window.resize = drawMultSeries;
                    }     
                    
                    </script> 
                    <div class="col-md-6">
						<div id="columnchart_material" class="shadow_back" style="width: 100%; height: 250px; margin: 0 auto;"></div>
                    </div>	
						
                    <script type="text/javascript">
						
					  google.charts.load('current', {'packages':['corechart']});
					  google.charts.setOnLoadCallback(drawBasic);

					  function drawBasic() {
						// Some raw data (not necessarily accurate)
						var data = google.visualization.arrayToDataTable([
						 ['Month', 'Earning'],
						 //['JAN',  165],
						 <?php echo $earningStr; ?>
					  ]);

					var options = {
					  title : 'Earning - Last 12 months',
					  titleTextStyle: {
						color: '#505458', 
						fontSize: 16, 
							bold: false,
							fontName: "Source Sans Pro",
						  },			
					  legend: { position: 'top', alignment: 'end', textStyle: {color: '#505458', fontSize: 10, 	fontName: "Source Sans Pro"} },
					  vAxis: {title: 'Amount', titleTextStyle: {color: '#505458', fontSize: 12, 	fontName: "Source Sans Pro"}, TextStyle: {color: '#505458', fontSize: 12, 	fontName: "Source Sans Pro"}},
					  hAxis: {title: 'Month', titleTextStyle: {color: '#505458', fontSize: 12, 	fontName: "Source Sans Pro"}, TextStyle: {color: '#505458', fontSize: 12, 	fontName: "Source Sans Pro"}},
					 
					  seriesType: 'bars',
					  colors: ['#ee502a'],
						 
					  series: {12: {type: 'line'}}
					};

					var chart = new google.visualization.ComboChart(document.getElementById('columnchart_values'));
					chart.draw(data, options);
				  }

                    if (document.addEventListener) {
                        window.addEventListener('resize', drawBasic);
                    }
                    else if (document.attachEvent) {
                        window.attachEvent('onresize', drawBasic);
                    }
                    else {
                        window.resize = drawBasic;
                    }     
                    
					  </script>
                    <div class="col-md-6">
						<div id="columnchart_values" class="shadow_back" style="width: 100%; min-height: 250px; margin: 0 auto;"></div>
                    </div>                              
                    
				</div>
			</div>
			<!-- END GRAPHS -->
						

            
        <?php echo $table_view;?><!-- content ends -->
    </div>
</div>
