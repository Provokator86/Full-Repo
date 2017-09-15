
<script src="<?=base_url()?>js/js_cal/jscal2.js"></script>
<script src="<?=base_url()?>js/js_cal/lang/en.js"></script>
<link rel="stylesheet" href="<?=base_url()?>css/jscal2.css" media="screen" type="text/css">
<?php //echo "<pre>";print_r($business_details);echo "</pre>";?>
<div class="sign_up" style="width: 375px;">
	<div class="margin10"></div>
	<div class="signup_left" style="border: 0px;">
        <form name="ajax_frm_login" id="ajax_frm_login" class="ajax_frm_login" action="<?=base_url().'facebook_test/index/'?>" method="post">
			<img src="<?=base_url()?>images/front/fb_checkin.png" />
				<span> 
			   <input type="hidden" name="business_id" value="<?=$business_details[0]['id']?>" />
			<table>
				 <?php //var_dump($business_details);?>
				<tr> <td> </td> <td>I Plan to be @ <?=$business_details[0]['name']?>, <?=$business_details[0]['address']?>,
				<?php if($business_details[0]['land_mark'] != '') echo $business_details[0]['land_mark'].', '; ?><?=$business_details[0]['ct_name']?></td></tr>
				 <div class="margin5"></div>
		 
		 <tr> <td align="right"> On </td> <td> <input style="border:1px solid #ccc; width:150px; height:20px;" id="visiting_date" name="visiting_date" class="textfield" value="" readonly/>
         <img src="<?=base_url()?>images/front/calender.jpg" id="f_rangeEnd_trigger" align="absmiddle" /></td>
		<script type="text/javascript">
				var LEFT_CAL = Calendar.setup({
				   //cont: "cont",
				   weekNumbers: true,
				   selectionType: Calendar.SEL_MULTIPLE,
				   showTime: 12
	   // titleFormat: "%B %Y"
	 })
				  new Calendar({
								  inputField: "visiting_date",
								  dateFormat: "%d-%m-%Y",
								  trigger: "f_rangeEnd_trigger",
								  bottomBar: false,
								  onSelect: function() {
												  var dt = Calendar.intToDate(this.selection.get());
												  LEFT_CAL.args.min = dt;
												  LEFT_CAL.redraw();
												  this.hide();
								  }
				  });
										
		   </script>  
	   
	   <tr> <td align="right">  at </td>
			<td> <span style="color:#FF9900">hr:&nbsp;</span><select style="width:50px;" id="hour" name="hour"> <?php for($h =1;$h<=12;$h++) {?><option value="<?=$h?>"> <?php echo $h;?> </option> <? }?></select>
		   <span style="color:#FF9900">minute:&nbsp;</span><select style="width:50px;" id="minute" name="minute"> <?php for($m =0;$m<=59;$m++) {?><option value="<?=$m?>"> <?php echo $m;?> </option> <? }?></select>
		   <select style="width:50px;" id="am_pm" name="am_pm" > <option value="AM"> AM </option><option value="PM">PM </option> </select>
		   </td>
		   
		</span>
			<div class="margin10"></div>
			
				<tr>
					<td valign="top" align="right">Wall Message</td>
					<td><textarea cols="80" rows="6" name="wallMessage"></textarea></td>
				</tr>
				<tr><td> </td> <td> <input class="button_02" type="submit" value="Submit >>" />&nbsp;<input class="button_02" type="button" value="cancel >>" onclick="tb_remove()" /></td>
				</tr>
				
			</table>
        </form>
	</div>
	