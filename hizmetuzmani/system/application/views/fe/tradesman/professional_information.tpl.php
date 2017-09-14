<!--<script type="text/javascript" src="js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="js/tinymce/tinymce_load_fe.js"></script>-->
<script type="text/javascript">
var max_allow_open 	= 5;	
var cnt 			= parseInt('<?php echo ($counter_place)?$counter_place:1; ?>');
var cnt_pay 		= parseInt('<?php echo ($count_pay_unit)?$count_pay_unit:1; ?>');
var count_pay_time 	= parseInt('<?php echo ($count_pay_time)?$count_pay_time:1; ?>');
var working_exp		= parseInt('<?php echo ($cnt_working)?$cnt_working:1; ?>');
//var working_exp		= cnt_category;

var dropdown    =   function(){

    
     var category_id;

                        $('.category').each(function()
                        {

                            category_id =   $(this).attr('id');
                            $('#'+category_id).msDropDown();
                            $('#'+category_id).hide();
                            $('#'+category_id+'_msdd').css("background-image", "url(images/fe/select.png)");
                            $('#'+category_id+'_msdd').css("background-repeat", "no-repeat");
                            $('#'+category_id+'_msdd').css("width", "269px");
                            $('#'+category_id+'_msdd').css("margin-top", "0px");
                            $('#'+category_id+'_msdd').css("padding", "0px");
                            $('#'+category_id+'_msdd').css("height", "38px");
                            $(this).removeClass('category');
                            
                        });
                        
                        
                        $('.experience').each(function()
                        {
                            experience_id =   $(this).attr('id');
                            $('#'+experience_id).msDropDown();
                            $('#'+experience_id).hide();
                            $('#'+experience_id+'_msdd').css("background-image", "url(images/fe/select-small02.png)");
                            $('#'+experience_id+'_msdd').css("background-repeat", "no-repeat");
                            $('#'+experience_id+'_msdd').css("width", "57px");
                            $('#'+experience_id+'_msdd').css("margin-top", "0px");
                            $('#'+experience_id+'_msdd').css("padding", "0px");
                            $('#'+experience_id+'_msdd').css("height", "38px");
                            $('#'+experience_id+'_msdd').css("margin-right", "10px");
                            $(this).removeClass('experience');
                         
                            
                        });
						
						/* for payment method */
						$('.pay_unit').each(function()
                        {

                            pay_unit_id =   $(this).attr('id');
                            $('#'+pay_unit_id).msDropDown();
                            $('#'+pay_unit_id).hide();
                            $('#'+pay_unit_id+'_msdd').css("background-image", "url(images/fe/select.png)");
                            $('#'+pay_unit_id+'_msdd').css("background-repeat", "no-repeat");
                            $('#'+pay_unit_id+'_msdd').css("width", "269px");
                            $('#'+pay_unit_id+'_msdd').css("margin-top", "0px");
                            $('#'+pay_unit_id+'_msdd').css("padding", "0px");
                            $('#'+pay_unit_id+'_msdd').css("height", "38px");
                            $(this).removeClass('pay_unit');
                            
                        });
						/* for payment method */
}

$(document).bind('ready',dropdown);

$(document).ready(function(){

    	
		
	/*** START GENERATE WORKING PLACE ***/	
	$("#place_add_more").click(function(){
			var str = '';
			
			var close_str = '<div class="close_multi" id="close_multi_'+parseInt(cnt+1)+'"><a href="javascript:void(0)" id="closecat_'+parseInt(cnt+1)+'" onclick ="close_cat(this.id);"><img src="images/fe/close_small.png" /></a></div>';
			
			str += '<div id="parent_place_'+parseInt(cnt+1)+'"><div class="textfell06" style=" margin-left:140px;"><input name="txt_work_place[]" id="txt_work_place_'+parseInt(cnt+1)+'" class="work_place" type="text"/></div>'+close_str+'</div>';
			
			$("#parent_place_"+cnt).parent().append(str);		
			
			cnt++;			
			
			if(cnt>=max_allow_open)
			{
				$("#place_add_more").hide();
			}
		});
	/*** END GENERATE WORKING PLACE ***/
	
	/*** START GENERATE PAYMENT UNIT  ***/
	$("#pay_add_more").click(function(){
			var str = '';
			
			var close_str = '<div class="close_multi" id="close_payunit_'+parseInt(cnt_pay+1)+'"><a href="javascript:void(0)" id="closepayunit_'+parseInt(cnt_pay+1)+'" onclick ="close_payunit(this.id);"><img src="images/fe/close_small.png" /></a></div>';
			
			str += '<div id="parent_pay_'+parseInt(cnt_pay+1)+'"><div class="textfell06 nobg" style=" margin-left:140px;"><select class="pay_unit" name="txt_pay_unit[]" id="pay_unit_'+parseInt(cnt_pay+1)+'" style="width:269px; height:38px;"><option value="">'+"<?php echo addslashes(t('select'))?>"+'</option>'+"<?php echo makeOptionPayMethod(" ",""); ?>"+'</select></div>'+close_str+'</div>';
			
			
			//$("#parent_pay_"+cnt_pay).parent().append(str);	
			$("#parent_pay_"+cnt_pay).parent().append(str);		
			dropdown();
			cnt_pay++;	
			
			if(cnt_pay>=(max_allow_open-1))
			{
				$("#pay_add_more").hide();
			}
		});
	/*** END GENERATE PAYMENT UNIT  ***/
	
	/*** START GENERATE PAYMENT TIME  ***/
	$("#pay_time_multi").click(function(){
			var str = '';
			
			var close_str = '<div class="close_multi" id="close_paytime_'+parseInt(count_pay_time+1)+'"><a href="javascript:void(0)" id="closepaytime_'+parseInt(count_pay_time+1)+'" onclick ="close_paytime(this.id);"><img src="images/fe/close_small.png" /></a></div>';
			
			str += '<div id="pay_time_'+parseInt(count_pay_time+1)+'"><div class="textfell06" style=" margin-left:140px;"><input name="txt_when_to_pay[]" class="pay_time" type="text" value="" /></div>'+close_str+'</div>';
			
			
			$("#pay_time_"+count_pay_time).parent().append(str);	
			
			count_pay_time++;			
			
			if(count_pay_time>=max_allow_open)
			{
				$("#pay_time_multi").hide();
			}
		});
	/*** END GENERATE PAYMENT TIME  ***/
	
	/*** START GENERATE CATEGORY , WITH EXPERIENCE ***/	
	//var working_exp = cnt_category;	
	
	$("#work_exp").click(function(){
			var str = '';
			
			var close_exp = '<div class="close_workexp" id="close_workexp_'+parseInt(working_exp+1)+'"><a href="javascript:void(0)" id="closeworkexp_'+parseInt(working_exp+1)+'" onclick ="close_workexp(this.id);"><img src="images/fe/close_small.png" /></a></div>';
			
			str += '<div id="cat_exp_'+parseInt(working_exp+1)+'"><div class="div_inner" ><div class="textfell06 nobg" style="margin-left:140px;"><select class="category" name="working[]" id="working_'+parseInt(working_exp+1)+'" style="width:269px; height:38px;"><option value="">select category</option>'+"<?php echo makeOptionCategory(" c.i_status=1 ",""); ?>"+'</select></div><div class="textfell10 nobg"><select class="experience" name="experience[]" id="experience_'+parseInt(working_exp+1)+'" style="width:57px;">'+"<?php echo makeOptionExperience(); ?>"+'</select> <?php echo addslashes(t('Year(s) Experience'))?></div>'+close_exp+'</div></div>';
			
			
			$("#cat_exp_"+working_exp).parent().append(str);		
			dropdown();
			working_exp++;
			
			if(working_exp>=max_allow_open)
			{
				$("#work_exp").hide();
			}
		});
	/*** END GENERATE CATEGORY , WITH EXPERIENCE ***/
	
	
	// onblur content for about section
	
	var var1 = '<?php echo t('Let the users know about\nyou,\nyour work,\nyour experiences or\nreferences, so increase your chance to win more jobs...\n\nNever type any contact information, email or website, it will cause you loose your membership.')?>';
	<?php if(empty($info['s_about_me'])) { ?>
	$("#ta_about").val(var1).css({'opacity':'0.5'});
	<?php } ?>
	$("#ta_about").focus(function() {
		if ($(this).attr("value")==var1) 
			{
			   $(this).val('');
			}  
		
			});
	
	$("#ta_about").blur(function() {
		if ($(this).attr("value")=="") 
			{
			   //$(this).val(var1).css({'color': "#666", 'font-style': 'italic', 'font-weight': 'normal'});
			   $(this).val(var1).css({'opacity':'0.5'});
			}  
		
			});
	
     
	///////////Submitting the form/////////
$("#btn_confirm").click(function(){	
    var b_valid=true;   
	var keys = $.trim($("#txt_keyword").val());
	var key_len = keys.split(',');
	
	
	if($.trim($("input.work_place").val())=="") 
    {
        $("#err_txt_work_place").text('<?php echo addslashes(t('Please provide work place'))?>').slideDown('slow');
		b_valid  =  false;
    }
	else
	{
		$("#err_txt_work_place").slideUp('slow').text('<?php echo addslashes(t(''))?>');
	} 
	/*if($.trim($("input.pay_unit").val())=="") 
    {
        $("#err_txt_pay_unit").text('<?php echo addslashes(t('Please provide payment unit'))?>').slideDown('slow');
		b_valid  =  false;
    }*/
	if($.trim($("#pay_unit_1").val())=="") 
    {
        $("#err_txt_pay_unit").text('<?php echo addslashes(t('Please provide payment unit'))?>').slideDown('slow');
		b_valid  =  false;
    }
	else
	{
		$("#err_txt_pay_unit").slideUp('slow').text('<?php echo addslashes(t(''))?>');
	}
	if($.trim($("input.pay_time").val())=="") 
    {
        $("#err_txt_pay_time").text('<?php echo addslashes(t('Please provide payment time'))?>').slideDown('slow');
		b_valid  =  false;
    }
	else
	{
		$("#err_txt_pay_time").slideUp('slow').text('<?php echo addslashes(t(''))?>');
	}
	/*if($.trim($("input.working").val())=="") 
    {
        $("#err_txt_working").text('<?php echo addslashes(t('Please provide category with experience'))?>').slideDown('slow');
		b_valid  =  false;
    }*/
	if($.trim($("#working_1").val())=="") 
    {
        $("#err_txt_working").text('<?php echo addslashes(t('Please provide category with experience'))?>').slideDown('slow');
		b_valid  =  false;
    }
	else
	{
		$("#err_txt_working").slideUp('slow').text('<?php echo addslashes(t(''))?>');
	}
	if($.trim($("#txt_keyword").val())=="") 
    {
        $("#err_txt_keyword").text('<?php echo addslashes(t('Please provide keywords'))?>').slideDown('slow');
		b_valid  =  false;
    }
	else if(key_len.length>8 || key_len.length<4)
	{
		 $("#err_txt_keyword").text('<?php echo addslashes(t('Please provide at least 4 keywords and maximum 8 keywords'))?>').slideDown('slow');
		b_valid  =  false;
	}
	else
	{
		$("#err_txt_keyword").slideUp('slow').text('<?php echo addslashes(t(''))?>');
	}
	if($.trim($("#ta_about").val())=="" || $.trim($("#ta_about").val())==var1) 
    {
        $("#err_ta_about").text('<?php echo addslashes(t('Please provide about you'))?>').slideDown('slow');
		b_valid  =  false;
    }
	else
	{
		$("#err_ta_about").slideUp('slow').text('<?php echo addslashes(t(''))?>');
	}
    /////////validating//////

	if(b_valid)
	{
	$("#prof_info").submit();
	}
	else
    {
		$('html, body').stop().animate({
			scrollTop: 0 //160
		   }, 2000,'easeInOutExpo');  
		
    }
	return b_valid;
    
}); 

///////////end Submitting the form/////////  
       

});
</script>
<script type="text/javascript">
// close work place on click cross image
function close_cat(param)
	{			
	  var div_id=param.split('_')[1];  	 
	  
	  $("#parent_place_"+div_id).remove();
	  var i=parseInt(div_id)+1;
	  
	  while(i<=cnt)
	  {
		   $("#close_multi_"+i+" a[id^=closecat_]").attr('id','closecat_'+(i-1)); 
		   $("#close_multi_"+i).attr('id','close_multi_'+(i-1));
		   $("#parent_place_"+i).attr('id','parent_place_'+(i-1));
		 
		 i++;  
	  }
	  cnt=cnt-1;	  
	  $("#place_add_more").show();
    } 
	
// close pay unit on click cross image
function close_payunit(param)
	{			
	  var div_id=param.split('_')[1];  	 
	  
	  $("#parent_pay_"+div_id).remove();
	  var i=parseInt(div_id)+1;
	  
	  while(i<=cnt_pay)
	  {
		   $("#close_payunit_"+i+" a[id^=closepayunit_]").attr('id','closepayunit_'+(i-1)); 
		   $("#close_payunit_"+i).attr('id','close_payunit_'+(i-1));
		   $("#parent_pay_"+i).attr('id','parent_pay_'+(i-1));
		 
		 i++;  
	  }
	  cnt_pay=cnt_pay-1;	  
	  $("#pay_add_more").show();
    } 	
	
// close pay time on click cross image
function close_paytime(param)
	{			
	  var div_id=param.split('_')[1];  	 
	  
	  $("#pay_time_"+div_id).remove();
	  var i=parseInt(div_id)+1;
	  
	  while(i<=count_pay_time)
	  {
		   $("#close_paytime_"+i+" a[id^=closepaytime_]").attr('id','closepaytime_'+(i-1)); 
		   $("#close_paytime_"+i).attr('id','close_paytime_'+(i-1));
		   $("#pay_time_"+i).attr('id','pay_time_'+(i-1));
		 
		 i++;  
	  }
	  count_pay_time=count_pay_time-1;	  
	  $("#pay_time_multi").show();
    } 	
	
// close specialist category on click cross image
function close_workexp(param)
	{			
	  var div_id=param.split('_')[1];  	 
	 
	  $("#cat_exp_"+div_id).remove();
	  var i=parseInt(div_id)+1;
	  
	  while(i<=working_exp)
	  {
		   $("#close_workexp_"+i+" a[id^=closeworkexp_]").attr('id','close_workexp_'+(i-1)); 
		   $("#close_workexp_"+i).attr('id','close_workexp_'+(i-1));
		   $("#cat_exp_"+i).attr('id','cat_exp_'+(i-1));
		 
		 i++;  
	  }
	  working_exp=working_exp-1;	  
	  $("#work_exp").show();
    } 		
</script>
<style>
.err{ margin-left:140px;}
</style>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="job_categories">
	<div class="top_part"></div>
	<div class="midd_part height02">
	  <div class="username_box">
		<div class="right_box03">
		<?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>
			<div id="div_err">
					
			</div>	
		
			  <h4><?php echo addslashes(t('Professional Information'))?></h4>
						  
			  <div class="div01">
					<div class="required"><span>*</span> <?php echo addslashes(t('Required field'))?></div>
					<div class="spacer"></div>
				  
			  </div>
		 
			  <form action="<?php echo base_url().'tradesman/professional-information' ?>" id="prof_info" name="prof_info" method="post" enctype="multipart/form-data">
			  <div class="registration_box"> 
			  <h5><?php echo addslashes(t('Working Info'))?></h5>
			 
			 <!-- WORKING PLACE FOR TRADESMAN , CAN BE MULTIPLE -->
			  <div class="lable02"><?php echo addslashes(t('Working Place'))?><span>*</span></div>
			  <div>
			  <?php 
			  if(!empty($work_place)) 
			  {	
			  	$i = 1;
				foreach($work_place as $value)
				{
					$str_style = '';
					if($i>1)
					{
					$str_style.= 'style=" margin-left:140px;"';
					}
			  
			   ?>
			   <div id="parent_place_<?php echo $i; ?>">
			  <div class="textfell06" <?php echo $str_style; ?>>
				<input name="txt_work_place[]" id="txt_work_place_<?php echo $i ?>"  class="work_place" type="text" value="<?php echo $value["s_work_place"] ?>" />	
			 		
			  </div>
			   <?php 
			  if($i>1) { 
			  ?> 
			  <div class="close_multi" id="close_multi_<?=$i?>">
			   	<a href="javascript:void(0)" id="closecat_<?=$i?>" onclick ="close_cat(this.id);">
				<img src="images/fe/close_small.png" />
				</a>
			  </div>	
				<!-- <div class="close02"><img src="images/fe/close_small.png" alt="close_icon" /></div>-->
              <?php } ?>	
			  </div>
			  
			  
			  <?php  $i++; ?>
			  <?php } } else { ?>
			  <div id="parent_place_1">
			  <div class="textfell06">
					<input name="txt_work_place[]" id="txt_work_place" class="work_place" type="text" value="" />
			  </div>
			  </div>
			  <?php } ?>
			  </div>
			  <div class="spacer"></div>
			  <div id="err_txt_work_place" class="err"><?php echo form_error('txt_work_place') ?></div>
			 
			  <div class="textfell07" style="float:right; margin-right:150px; margin-top:-15px;">
			  <a href="javascript:void(0);" id="place_add_more"><?php echo addslashes(t('Add more'))?></a>
			  </div>
			   <!-- END WORKING PLACE FOR TRADESMAN , CAN BE MULTIPLE -->
			  
			  
			  <div class="spacer"></div>			  
			  
			  
				<div class="spacer"></div>
			   <div class="lable02"><?php echo addslashes(t('Working Hours'))?><span>*</span></div>
			   <div class="textfell07" style="padding-top:10px;">
			   <input name="workdays[]" checked="checked" type="checkbox" value="1" <?php foreach($work_days as $val){if($val['i_work_days']==1) echo 'checked="checked"';} ?> id="workdays1" /><?php echo addslashes(t('Weekdays Only'))?> 
			   <input name="workdays[]" type="checkbox" value="2" <?php foreach($work_days as $val){if($val['i_work_days']==2) echo 'checked="checked"';} ?> id="workdays2"/><?php echo addslashes(t('Weekend Only'))?>
			   <input name="workdays[]" type="checkbox" value="3" <?php foreach($work_days as $val){if($val['i_work_days']==3) echo 'checked="checked"';} ?> id="workdays3"/><?php echo addslashes(t('Holidays'))?>
			   </div>
			   <div class="spacer"></div>
			 
			  <div class="spacer"></div>
			  
			  <!-- PAYMENT UNIT OF TARDESMAN CAN BE MULTIPLE -->
			  <div class="lable02"><?php echo addslashes(t('Payment method'))?>:<span>*</span></div>
			 
			  <div>  <!-- div for payment method -->
			  <?php 
			  if(!empty($pay_unit)) 
			  {
			  	$i = 1;
			  	foreach($pay_unit as $key=>$val)
				{ 
					$str_style = '';
					if($i>1)
					{
					$str_style.= 'style=" margin-left:140px;"';
					}
			  		
			   ?>
			    <div id="parent_pay_<?php echo $i ?>">
			  <div class="textfell06 nobg" <?php echo $str_style ?>>			  
			  <select id="pay_unit_<?php echo $i ?>" class="pay_unit" name="txt_pay_unit[]" style="width:269px;">
			  <option value=""><?php echo addslashes(t('Select'))?></option>
			  <?php echo makeOptionPayMethod(" ", encrypt($val['i_payment_unit']));?>
			  </select>
			
			  </div>
			  
			  <?php 
			  if($i>1) { 
			  ?> 
			 <div class="close_multi" id="close_payunit_<?=$i?>">
			   	<a href="javascript:void(0)" id="closepayunit_<?=$i?>" onclick ="close_payunit(this.id);">
				<img src="images/fe/close_small.png" />
				</a>
			  </div>					
              <?php } ?>			   		  
			  </div>
			  
			  <?php $i++;} } else { ?>
              <div id="parent_pay_1">
			  <div class="textfell06 nobg">			  
			  <select id="pay_unit_1" class="pay_unit" name="txt_pay_unit[]" style="width:269px;">
			  <option value=""><?php echo addslashes(t('select'))?></option>
			  <?php echo makeOptionPayMethod(" c.i_status=1 ", encrypt($val['i_payment_unit']));?>
			  </select>			  	
				
			  </div>
              
              </div>
			  <?php } ?>
			  </div>
			  
			  <div class="spacer"></div>
			   <div id="err_txt_pay_unit" class="err"><?php echo form_error('txt_pay_unit') ?></div>
			  <div class="textfell07" style="float:right; margin-right:150px;margin-top:-15px;">
			  <a href="javascript:void(0);" id="pay_add_more"><?php echo addslashes(t('Add more'))?></a>
			  </div>
			   <!-- PAYMENT UNIT OF TARDESMAN CAN BE MULTIPLE -->
			  
			  <div class="spacer"></div>
			  
			   <!-- PAYMENT TIME OF TARDESMAN CAN BE MULTIPLE -->
			   <div class="lable02"><?php echo addslashes(t('When to pay'))?>?:<span> *</span></div>
			   <div>
			    <?php 
			  if(!empty($pay_time)) 
			  {	
			  	$i = 1;
				foreach($pay_time as $value)
				{
			  		$str_style = '';
					if($i>1)
					{
					$str_style.= 'style=" margin-left:140px;"';
					}
			  
			   ?>
			   <div id="pay_time_<?php echo $i; ?>">
			   <div class="textfell06" <?php echo $str_style ?>>
					<input name="txt_when_to_pay[]" class="pay_time tTip" title="<?php echo addslashes(t('Ex: pre-payment required, after work done, etc.'))?>" type="text" value="<?php echo $value['s_pay_time'] ?>" />
			  </div> 
			  <?php 
			  if($i>1) { 
			  ?> 
			  <div class="close_multi" id="close_paytime_<?=$i?>">
			   	<a href="javascript:void(0)" id="closepaytime_<?=$i?>" onclick ="close_paytime(this.id);">
				<img src="images/fe/close_small.png" />
				</a>
			  </div>	
				
              <?php } ?>
			  </div>
			  <?php $i++; } } else { ?>
			  <div id="pay_time_1">
			   <div class="textfell06">
					<input name="txt_when_to_pay[]" class="pay_time tTip" type="text" title="<?php echo addslashes(t('Ex: pre-payment required, after work done, etc.'))?>"  value="" />
			  </div>
			  </div>
			  <?php } ?>
			  </div>
			  <div class="spacer"></div>
			  <div id="err_txt_pay_time" class="err"><?php echo form_error('txt_when_to_pay') ?></div>
			  <div class="textfell07" style="float:right; margin-right:150px;margin-top:-15px;">
			  <a href="javascript:void(0);" id="pay_time_multi"><?php echo addslashes(t('Add more'))?></a>
			  </div>
			  <!-- PAYMENT TIME OF TARDESMAN CAN BE MULTIPLE -->
			  <?php if($info['i_type']==2){ ?>
			  <div class="spacer"></div>
			   <div class="lable02"><?php echo addslashes(t('Logo')).'/'.addslashes(t('Profile Image')); ?>:<span></span></div>
				  <input type="file" class="width05 fist brows02" name="f_logo" id="f_logo" /> 
				  <div class="spacer"></div>
				   <?php if($info['s_image']!='') 
				    { 				    
					echo '<img style=" margin-left:140px;" src="'.$this->thumbDisplayPath.'thumb_'.$info["s_image"].'" height="100" width="100">';								
					echo '<input type="hidden" name="h_logo" id="h_logo" value="'.$info["s_image"].'" />';
					} 
					?>
			  <div class="spacer"></div>
			  <?php } else if($info['i_type']==1) { ?>
			  <div class="spacer"></div>
				 <div class="lable02"><?php echo addslashes(t('Photo'))?>:<span></span></div>
				  <input type="file" class="width05 fist brows02" name="f_logo" id="f_logo"/> 
				 
				  <div class="spacer margin10"></div>
				   <?php if($info['s_image']!='') 
				    { 
				    //echo $this->thumbDisplayPath.'thumb_'.$info["s_profile_pic"];									
					echo '<img style=" margin-left:140px;" src="'.$this->thumbDisplayPath.'thumb_'.$info["s_image"].'" height="100" width="100">';
					echo '<input type="hidden" name="h_logo" id="h_logo" value="'.$info["s_image"].'" />';
					} 
					?>
			  <div class="spacer margin10"></div>			  
				<?php } ?>
			  <div class="spacer"></div>
			  <div class="border margin10"></div>
			
			
			<h5><?php echo addslashes(t('Working Info'))?></h5>
			<div class="spacer"></div>
			  <!-- SPECIALIST CATEGORY OF TARDESMAN CAN BE MULTIPLE -->
			  <div class="lable02"><?php echo addslashes(t('Specialist Category'))?><span>*</span></div>
			  <div>  <!-- div for category and experience block together -->
			  <?php 
			  if(!empty($cat_exp["working"])) 
			  {
			  	$i = 1;
			  	foreach($cat_exp["working"] as $key=>$val)
				{ 
					$str_style = '';
					if($i>1)
					{
					$str_style.= 'style=" margin-left:140px;"';
					}
			  		
			   ?>
			    <div id="cat_exp_<?php echo $i ?>">
			  <div class="div_inner">
			  <div class="textfell06 nobg" <?php echo $str_style ?>>			  
			  <select id="working_<?php echo $i ?>" class="category" name="working[]" style="width:269px;">
			  <option value=""><?php echo addslashes(t('Specialist Category'))?></option>
			  <?php echo makeOptionCategory(" c.i_status=1 ", $cat_exp["working"][$i-1]);?>
			  </select>
			
			  </div>
			  <div class="textfell10 nobg"> 
				   <select id="experience_<?php echo $i ?>" class="experience" name="experience[]" style="width:57px;">
				   <?php echo makeOptionExperience('',$cat_exp["experience"][$i-1]) ?>
				   </select> <?php echo addslashes(t('Year(s) Experience'))?>
			  </div>
			  <?php 
			  if($i>1) { 
			  ?> 
			  <div class="close_workexp" id="close_workexp_<?=$i?>">
			   	<a href="javascript:void(0)" id="closeworkexp_<?=$i?>" onclick ="close_workexp(this.id);">
				<img src="images/fe/close_small.png" />
				</a>
			  </div>					
              <?php } ?>			 		  
			  </div>				   		  
			  </div>
			  
			  <?php $i++;} } else { ?>
              <div id="cat_exp_1">
			  <div class="div_inner">
			  <div class="textfell06 nobg">			  
			  <select id="working_1" class="category" name="working[]" class="category" style="width:269px;">
			  <option value=""><?php echo addslashes(t('Specialist Category'))?></option>
			  <?php echo makeOptionCategory(" c.i_status=1 ", $posted['working']);?>
			  </select>			  	
				
			  </div>
			  <div class="textfell10 nobg"> 
				   <select id="experience_1" class="experience" name="experience[]" style="width:57px;">
				   <?php echo makeOptionExperience() ?>
				   </select>
						<?php echo addslashes(t('Year(s) Experience'))?>
			  </div>
              
			  </div>
              </div>
			  <?php } ?>
			  </div>
			  <div class="spacer"></div>
			  <div id="err_txt_working" class="err"><?php echo form_error('working') ?></div>
			  <!-- END div OF CATEGORY AND EXPERIENCE BLOCK TOGETHER -->
			  <div class="spacer"></div>
			   <div class="textfell07" style="float:right; margin-right:150px;margin-top:-15px;">
			  <a href="javascript:void(0);" id="work_exp"><?php echo addslashes(t('Add more'))?></a>
			  </div>
			   <!-- SPECIALIST CATEGORY OF TARDESMAN CAN BE MULTIPLE -->
			  
			  
			  <div class="spacer"></div>
			  
			  
				<div class="spacer"></div>
			   <div class="lable02"><?php echo addslashes(t('Keywords'))?><span>*</span></div>
			   <div class="textfell06">				   
				<input type="text" name="txt_keyword" id="txt_keyword" class="tTip" title="<?php echo addslashes(t('keywords will help you appear more on search results.At least 4 keywords required.'))?>" value="<?php echo $info['s_keyword'] ?>"/>					
			  </div>
			   <div class="spacer"></div>
			   <div id="err_txt_keyword" class="err"><?php echo form_error('txt_keyword') ?></div>
			 
			  <div class="spacer"></div>
			  
			  <!-- content for about me -->			 
			  
			  <div class="lable02"><?php echo addslashes(t('About'))?>:<span>*</span></div>
			  <div class="textfell80">
				   <textarea  name="ta_about" id="ta_about" class="ta_about" ><?php echo $info['s_about_me'] ?></textarea>
			  </div>
			  <div class="spacer"></div>
			   <div id="err_ta_about" class="err"><?php echo form_error('ta_about') ?></div>
			   <!-- content for about me -->
			
			  <div class="spacer"></div>
			  <div class="lable02"></div>
			 <div class="textfell07">
			 	<input class="small_button" id="btn_confirm" type="button" value="<?php echo addslashes(t('Submit'))?>"/>
			 </div>
			  <div class="spacer"></div>

		</div>
			  </form>
			  </div>
			<!-- END OF DIV right_box03 -->			  
			<?php include_once(APPPATH."views/fe/common/tradesman_left_menu.tpl.php"); ?>
		<div class="spacer"></div>
  </div>
			  <div class="spacer"></div>
		</div>
	<div class="spacer"></div>
	<div class="bottom_part"></div>
</div>