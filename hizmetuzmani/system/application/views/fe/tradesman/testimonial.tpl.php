<script type="text/javascript" src="js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="js/tinymce/tinymce_load_fe.js"></script>
<script>		
$(document).ready(function(){
var g_controller="<?php echo $pathtoclass;?>";//controller Path 
    
$('input[id^="btn_testi"]').each(function(i){
   $(this).click(function(){
      //$.blockUI({ message: 'Just a moment please...' });
       $("#tradesman_testimonial").submit();
   }); 
});    


///////////Submitting the form/////////
$("#tradesman_testimonial").submit(function(){
    var b_valid=true;
    var s_err="";
    $("#div_err").show("slow"); 

    
	/*if($.trim($("#ta_content").val())=="") 
	{
	  	$("#err_ta_content").text('<?php echo addslashes(t('Please provide testimonial'))?>').slideDown('slow');
		b_valid  =  false;
	}*/	
	if((text = tinyMCE.get('ta_content').getContent())=='') 
	{
		$("#err_ta_content").text('<?php echo addslashes(t('Please provide testimonial'))?>').slideDown('slow');
		b_valid  =  false;
	}		
	else
    {
        $("#err_ta_content").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
    
    /////////validating//////
    if(!b_valid)
    {       
        $("#div_err").html(s_err).show("slow");
    }
    
    return b_valid;
});    
///////////end Submitting the form/////////   

})	
	
</script>
<style>
.err{ margin-left:80px;}
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
		  
		  <h4><?php echo addslashes(t('My Testimonial'))?></h4>
		  <div class="div01">
				<p><?php echo addslashes(t('Please drop a line about our services, we sincerely hope you have had a wonderful experience'))?></p>
				<div class="spacer"></div>
		  </div>
		  <div class="filter_option_box">
		  <form action="<?php echo base_url().'tradesman/testimonial/' ?>" method="post" id="tradesman_testimonial">
				<div class="lable02"><?php echo addslashes(t('Testimonial'))?><span>*</span></div>
				<textarea name="ta_content" id="ta_content"></textarea>			   
				
				<div class="spacer"></div>
                <div id="err_ta_content" class="err"><?php echo form_error('ta_content'); ?></div>
				<div class="spacer"></div>
				<div class="lable02"></div>
				<input type="button" id="btn_testi" value="<?php echo addslashes(t('Submit'))?>" class="small_button flote05" />
			   
				<div class="spacer"></div>
		  </form>		
		  </div>
		  
		  <h4><?php echo addslashes(t('Previous Testimonials'))?></h4>
		  <!-- testimonial list -->
		  <div id="testimonial_list">
		  <?php echo $testimonial ?>
		  </div>
		  <!-- testimonial list -->
		 <div class="spacer"></div>
		  
		  <?php include_once(APPPATH."views/fe/common/symbol_hints.tpl.php"); ?>
		   <div class="spacer"></div>
	</div>
		<?php include_once(APPPATH."views/fe/common/tradesman_left_menu.tpl.php"); ?>
		<div class="spacer"></div>
  </div>
                  <div class="spacer"></div>
            </div>
            <div class="spacer"></div>
            <div class="bottom_part"></div>
      </div>