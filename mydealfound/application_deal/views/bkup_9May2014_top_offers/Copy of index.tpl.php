<script type="text/javascript" src="<?php echo base_url() ?>js/ModalDialog.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/fe/lazy_loading_pagination.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/scrollbar.js"></script>
<script type="text/javascript">

  $(document).ready(function(){
        $('.mainScroll').tinyscrollbar();		
    });

</script>
<script type="text/javascript">
var base_url = '<?php echo base_url();?>';
$(document).ready(function(){
	var cat_checkboxes 	= new Array();
	var store_checkboxes 	= new Array();
	var d_discount =     '';
	var discount_checkboxes = new Array();
	
	$(".prod_discount li input[type='radio']").click(function(){
		d_discount = $(this).val();
		ajax_sending();
	});
	
	$("input[id^=cat_chk_]").click(function(){
		cat_checkboxes = [];
		$("input[id^=cat_chk_]:checked").each(function(i){
           cat_checkboxes[i]   =   $(this).attr('id').split('_').pop();           
        });
		
		ajax_sending();
	});
	
	$("input[id^=store_chk_]").click(function(){
		store_checkboxes = [];
		$("input[id^=store_chk_]:checked").each(function(i){
           store_checkboxes[i]   =   $(this).attr('id').split('_').pop();           
        });
		
		ajax_sending();
	});
	
	$("input[id^=discount_chk_]").click(function(){
		discount_checkboxes = [];
		$("input[id^=discount_chk_]:checked").each(function(i){
           discount_checkboxes[i]   =   $(this).attr('id').split('_').pop();           
        });
		
		ajax_sending();
	});
	
	/********** start click clear  *******/
   $('a[class=clear_checked]').click(function(e){
   
   		e.preventDefault();
		var checked_type =   $(this).attr('title');
		if(checked_type== "store")
		{
			clear_all_checked('store_chk_');
			store_checkboxes  =   new Array();		
			ajax_clear_srch_store_session();
		}
		if(checked_type== "discount")
		{
			clear_all_checked('discount_chk_');
			discount_checkboxes  =   new Array();
		}
		if(checked_type== "category")
		{
			clear_all_checked('cat_chk_');
			cat_checkboxes  =   new Array();
		}
		
		
	   ajax_sending();
   
   });
   
   /********** function to clear all checked  *******/
   function clear_all_checked(id_name)
   {
       $("input[id^="+id_name+"]:checked").each(function(){
           $(this).removeAttr('checked');
       });
	   
   }
	
	/************* Start Function ajax sending *********/
   function ajax_sending()
   {    
	   showBusyScreen();
			   
       $.ajax({
                type: "POST",
                async: false,
                url: base_url+'top_offers/ajax_pagination_offer_list/',
                data: "str_cat="+cat_checkboxes+"&arr_store="+store_checkboxes+"&d_discount="+d_discount+"&discount_checkboxes="+discount_checkboxes+"&type=where",
                success: function(data){
							
							hideBusyScreen();
							var wrapper_div_part = '<div id="offer_ajax">'+ data +'</div>';
							$("#div_search_offer").html(wrapper_div_part);
							$('.product').show();
							enable_lazy_loading_in_ajax_pagination('offer_ajax','loading_container_offers');    
						
							       
                		}
                
                });//End of ajax call
       
   };
   
   /************* End Function ajax sending *********/
   
   function ajax_clear_srch_store_session()
   {    
       $.ajax({
                type: "POST",
                async: false,
                url: base_url+'top_offers/ajax_clear_srch_store_session/',
                data: "type=where",
                success: function(data){
							
                		}
                
                });//End of ajax call
       
   };
   

});

</script>
    <div class="prodct1">
	
		<!-- LEFT PANEL START -->
		
		<div class="search_panel">			
	
				<form name="srch_form" id="srch_form" action="" method="post">
				<!-- Category START -->	
				<?php if($main_category) { ?>		
				<div class="boxes">
					<h3>Category</h3>		
					<a href="javascript:void(0);" title="category" class="clear_checked" >Clear</a>		
					<div class="boxes_content">
						<div class="mainScroll">
							<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
							<div class="viewport">
								<div class="overview">						
									<ul class="offer_cat">
										<?php foreach($main_category as $key=>$val) { 
												if($val["s_category"]!=''){
										?>
										<li><input type="checkbox" name="offer_cat[]" id="cat_chk_<?php echo $val["i_id"] ?>" ><?php echo $val["s_category"] ?></li>
										
										<?php  } } ?>
										
									</ul>
								</div>
							</div>
						</div>
					</div> 
				</div> 			
				<?php } ?>	
				<!-- Category END -->                 
				
				<!-- Store START-->
				<?php if($all_store) { ?>	
                <div class="boxes">
					<h3>Stores</h3>		
					<a href="javascript:void(0);" title="store" class="clear_checked" >Clear</a>		
					<div class="boxes_content">
						<div class="mainScroll">
							<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
							<div class="viewport">
								<div class="overview">
									<ul class="offer_store">
										<?php foreach($all_store as $key=>$val) { ?>
										<li><input type="checkbox" name="offer_store[]" id="store_chk_<?php echo $val["i_id"] ?>" <?php if($str_store*1==$val['i_id']){ ?> checked="checked" <?php } ?> ><?php echo $val["s_store_title"] ?></li>
										
										<?php } ?>
									</ul>
								</div>
							</div>
						</div>
					</div> 
				</div>
                <?php } ?>
				<!-- Store END -->		
				
				<!-- DISCOUNTS START -->
				<div class="boxes">
					<h3>Discounts</h3>			
					<a href="javascript:void(0);" title="discount" class="clear_checked" >Clear</a>	
					<div class="boxes_content">
						<div class="mainScroll">
							<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
							<div class="viewport">
								<div class="overview">
									<ul class="prod_discount">	
										<?php /*?><li><input type="radio" name="d_discount" value="70" <?php if($str_discount=='70'){ ?> checked="checked" <?php } ?>>70% and above </li>
										<li><input type="radio" name="d_discount" value="60" <?php if($str_discount=='60'){ ?> checked="checked" <?php } ?>>60% and above </li>				
										<li><input type="radio" name="d_discount" value="50" <?php if($str_discount=='50'){ ?> checked="checked" <?php } ?>> 50% and above</li>
										<li><input type="radio" name="d_discount" value="40" <?php if($str_discount=='40'){ ?> checked="checked" <?php } ?>> 40% and above </li>
										<li><input type="radio" name="d_discount" value="30" <?php if($str_discount=='30'){ ?> checked="checked" <?php } ?>> 30% and above </li>							
										<li><input type="radio" name="d_discount" value="20" <?php if($str_discount=='20'){ ?> checked="checked" <?php } ?>> 20% and above </li>
										<li><input type="radio" name="d_discount" value="10" <?php if($str_discount=='10'){ ?> checked="checked" <?php } ?>> 10% and above </li>
										<li><input type="radio" name="d_discount" value="none" <?php if($str_discount=='none'){ ?> checked="checked" <?php } ?>> None </li><?php */?>
										<li><input type="checkbox" name="prod_discount[]" id="discount_chk_70" value="70" <?php if($str_discount=='70'){ ?> checked="checked" <?php } ?>>70% and above </li>
										<li><input type="checkbox" name="prod_discount[]" id="discount_chk_60"value="60" <?php if($str_discount=='60'){ ?> checked="checked" <?php } ?>>60% and above </li>				
										<li><input type="checkbox" name="prod_discount[]" id="discount_chk_50" value="50" <?php if($str_discount=='50'){ ?> checked="checked" <?php } ?>> 50% and above</li>
										<li><input type="checkbox" name="prod_discount[]" id="discount_chk_40" value="40" <?php if($str_discount=='40'){ ?> checked="checked" <?php } ?>> 40% and above </li>
										<li><input type="checkbox" name="prod_discount[]" id="discount_chk_30" value="30" <?php if($str_discount=='30'){ ?> checked="checked" <?php } ?>> 30% and above </li>							
										<li><input type="checkbox" name="prod_discount[]" id="discount_chk_20" value="20" <?php if($str_discount=='20'){ ?> checked="checked" <?php } ?>> 20% and above </li>
										<li><input type="checkbox" name="prod_discount[]" id="discount_chk_10" value="10" <?php if($str_discount=='10'){ ?> checked="checked" <?php } ?>> 10% and above </li>
										<li><input type="checkbox" name="prod_discount[]" id="discount_chk_none" value="none" <?php if($str_discount=='none'){ ?> checked="checked" <?php } ?>> None </li>
									</ul>
								</div>
							</div>
						</div>
						
					</div>
				</div>				
				<!-- DISCOUNTS END -->		
				
				</form>
				
		</div> 
		<!-- LEFT PANEL END -->
		<!-- PRODUCT BLOCK START -->
		<div class="mid_panel">

			<div class="breadcrumb">
			<a href="<?php echo base_url();?>">Home &raquo; </a>
			<span id="bread_crumb"><?php echo $title ?></span>
			<?php //echo '<a href="'.base_url().'">Home</a> &raquo; '.$category_breadcrumb //echo getCategoryName($category_id); ?>
			</div>				
			<div class="product_box">
            	<div id="div_search_offer">
                    <div id="offer_ajax">
						<?php echo $offer_list; ?>
                    </div>
                </div>
                
				<?php //if(!empty($offer_list) && count($offer_list)>20) { ?>
                 <span id="loading_container_offers" style="padding:10px;">
                    <div class="loader" align="center" style="background-color:#f2f2f2; padding:5px 0 5px 0;border-radius:4px; border:1px solid #ccc;">
					<div style="color:#666; font-weight:bold;">Please Wait</div>
					<img src="<?php echo base_url(); ?>images/bx_loader.gif" />					
					</div>
                </span>
				<?php //} ?>
			
			
				<div class="clear"></div>			
			</div>	
		</div>

	
	

	<div class="clear"></div>
    </div> 


<?php $this->load->view('common/social_box.tpl.php'); ?>
<script type="text/javascript">

	enable_lazy_loading_in_ajax_pagination('offer_ajax','loading_container_offers');

</script>