<script type="text/javascript" src="<?php echo base_url() ?>js/ModalDialog.js"></script>
<?php /*?><script type="text/javascript" src="<?php echo base_url() ?>js/fe/lazy_loading_pagination.js"></script><?php */?>
<script type="text/javascript" src="<?php echo base_url() ?>js/scrollbar.js"></script>

<script type="text/javascript" src="<?php echo base_url() ?>js/scrolling/jquery.infinitescroll.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/fe/page_infinite_scroller.js"></script>

<link href="<?php echo base_url() ?>css/ui.totop.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.ui.totop.js"></script>

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
	var brand_checkboxes 	= new Array();
	
	var str_category = '';
	var str_store = '';
	var str_discount = '';
	$('.search_data_box ul li').hide();
   	$('div[id=display_searches]').hide();
	
	store_checkboxes = [];
	$("input[id^=store_chk_]:checked").each(function(i){
	   store_checkboxes[i]   =   $(this).attr('id').split('_').pop();           
	});
	
	
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
	
	$("input[id^=brand_chk_]").click(function(){
		brand_checkboxes = [];
		$("input[id^=brand_chk_]:checked").each(function(i){
           brand_checkboxes[i]   =   $(this).attr('id').split('_').pop();           
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
			//ajax_clear_srch_store_session();
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
		if(checked_type== "brand")
		{
			clear_all_checked('brand_chk_');
			brand_checkboxes  =   new Array();		
			//ajax_clear_srch_store_session();
		}
		
		
	   ajax_sending();
   
   });
   
   /********** start click cross button added on 9May 2014 from below *******/
   var fn_clear_cross = function(){
	   $('.cross_srch').click(function(){
			
		   var checked_type =   $(this).attr('title');
		   var _id	=	$(this).attr('rel');
		   //console.log(_id);
		   if(checked_type== "brand")
		   {
			   clear_cross_checked('brand_chk_',_id);
			   brand_checkboxes = new Array();	
				$("input[id^=brand_chk_]:checked").each(function(i){
				   brand_checkboxes[i]   =   $(this).attr('id').split('_').pop();           
				}); 
		   }
		   if(checked_type== "category")
		   {
			   clear_cross_checked('cat_chk_',_id);
			   cat_checkboxes = new Array();	
				$("input[id^=cat_chk_]:checked").each(function(i){
				   cat_checkboxes[i]   =   $(this).attr('id').split('_').pop();           
				}); 
		   }
		   if(checked_type== "store")
		   {
			   clear_cross_checked('store_chk_',_id);
			   store_checkboxes = new Array();	
				$("input[id^=store_chk_]:checked").each(function(i){
				   store_checkboxes[i]   =   $(this).attr('id').split('_').pop();           
				}); 
		   }
		   if(checked_type== "discount")
		   {
			   clear_cross_checked('discount_chk_',_id);
			   discount_checkboxes = new Array();	
				$("input[id^=discount_chk_]:checked").each(function(i){
				   discount_checkboxes[i]   =   $(this).attr('id').split('_').pop();           
				}); 
		   }
		   
		 
		   ajax_sending();
		   
	   });   
	   
	   $(".all_filter").click(function(){
			//window.location.reload();
			$("#head_srch_form").submit();
	   });
	   
   };
   /********** start click cross button added on 9May 2014 from below *******/
   
   
   function clear_cross_checked(id_name,val)
   {
   		//console.log(id_name+val);
		return $("#"+id_name+val).removeAttr('checked');		
   }
   /********** end click cross button added on 9May 2014 *******/
   
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
	   
	   	/************** added on 9May 2014 from below ******************/
		$('.search_data_box ul li').hide();
		str_brand =   '';
		$.each(brand_checkboxes,function(i,value){   
				
			   str_brand +=   ' '+$("input[id=brand_chk_"+value+"]").parent().text()+'<a href="javascript:void(0);" title="brand" class="cross_srch" rel="'+value+'"><img src="<?php echo base_url() ?>images/cross-symbol.png" alt="" /></a>'; 
		});
		str_brand =   str_brand.substring(1,str_brand.length);
		
		str_category =   '';
		$.each(cat_checkboxes,function(i,value){    
			   str_category +=   ' '+$("input[id=cat_chk_"+value+"]").parent().text()+'<a href="javascript:void(0);" title="category" class="cross_srch" rel="'+value+'"><img src="images/cross-symbol.png" alt="" /></a>'; 
		});
		str_category =   str_category.substring(1,str_category.length);
		
		str_store =   '';
		$.each(store_checkboxes,function(i,value){    
			   str_store +=   ' '+$("input[id=store_chk_"+value+"]").parent().text()+'<a href="javascript:void(0);" title="store" class="cross_srch" rel="'+value+'"><img src="images/cross-symbol.png" alt="" /></a>'; 
		});
		str_store =   str_store.substring(1,str_store.length);
		
		str_discount =   '';
		$.each(discount_checkboxes,function(i,value){    
			   str_discount +=   ' '+$("input[id=discount_chk_"+value+"]").parent().text()+'<a href="javascript:void(0);" title="discount" class="cross_srch" rel="'+value+'"><img src="images/cross-symbol.png" alt="" /></a>'; 
		});
		str_discount =   str_discount.substring(1,str_discount.length);
		/************** added on 9May 2014 from below ******************/   
			   
       $.ajax({
                type: "POST",
                async: false,
                url: base_url+'home/ajax_pagination_search_list/',
                data: "str_cat="+cat_checkboxes+"&arr_store="+store_checkboxes+"&arr_brand="+brand_checkboxes+"&d_discount="+d_discount+"&discount_checkboxes="+discount_checkboxes+"&type=where",
                success: function(data){
				
							hideBusyScreen();
							
							var wrapper_div_part = '<div id="srch_list">'+ data +'</div>';
							$("#div_search_result").html(wrapper_div_part);
							$('.product').show();
							
							//enable_lazy_loading_in_ajax_pagination('srch_list','loading_container_srch_products'); 
							  
							/************** added on 9May 2014 from below ******************/
							$('div[id=display_searches]').show();
							if(brand_checkboxes!='')
							{
								$('li[id=str_brand]').show().children('span').html(str_brand);
								$("input[id^=brand_chk_]").removeAttr('checked');
								fn_clear_cross();
								$.each(brand_checkboxes,function(i,value){    
								if($("input[id=brand_chk_"+value+"]").length)
								{
									$("input[id=brand_chk_"+value+"]").prop('checked','checked');
								}
									 
								});
							}
							if(cat_checkboxes!='')
							{
								$('li[id=str_category]').show().children('span').html(str_category);
								$("input[id^=cat_chk_]").removeAttr('checked');
								fn_clear_cross();
								$.each(cat_checkboxes,function(i,value){    
								if($("input[id=cat_chk_"+value+"]").length)
								{
									$("input[id=cat_chk_"+value+"]").prop('checked','checked');
								}
									 
								});
							} 
							if(store_checkboxes!='')
							{
								$('li[id=str_store]').show().children('span').html(str_store);
								$("input[id^=store_chk_]").removeAttr('checked');
								fn_clear_cross();
								
								$.each(store_checkboxes,function(i,value){    
								if($("input[id=store_chk_"+value+"]").length)
								{
									$("input[id=store_chk_"+value+"]").prop('checked','checked');
								}
									 
								});
							} 
							if(discount_checkboxes!='')
							{
								$('li[id=str_discount]').show().children('span').html(str_discount);
								$("input[id^=discount_chk_]").removeAttr('checked');
								fn_clear_cross();
								
								$.each(discount_checkboxes,function(i,value){    
								if($("input[id=discount_chk_"+value+"]").length)
								{
									$("input[id=discount_chk_"+value+"]").prop('checked','checked');
								}
									 
								});
							} 
							/************** added on 9May 2014 to above ******************/
							//// NEW - for infinite-scroller
							infinite_scroll_init();							
						
							       
                		}
                
                });//End of ajax call
       
   };
   
   /************* End Function ajax sending *********/
   
   function ajax_clear_srch_store_session()
   {    
       $.ajax({
                type: "POST",
                async: false,
                url: base_url+'home/ajax_clear_srch_store_session/',
                data: "type=where",
                success: function(data){
							
                		}
                
                });//End of ajax call
       
   };
   

});

</script>
<div class="clear"></div>
 <div class="content">
 	
	
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
			
			<!-- BRAND START -->	
			<?php if($all_brand) { ?>		
			<div class="boxes">
				<h3>Brand</h3>		
				<a href="javascript:void(0);" title="brand" class="clear_checked" >Clear</a>		
				<div class="boxes_content">
					<div class="mainScroll">
						<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
						<div class="viewport">
							<div class="overview">
								<ul class="prod_brand">
									<?php foreach($all_brand as $key=>$val) { 
											if($val["s_brand_name"]!=''){
									?>
									<li><input type="checkbox" name="prod_brand[]" id="brand_chk_<?php echo make_my_url($val["s_brand_name"]) ?>" <?php if(make_my_url($str_brand)==make_my_url($val["s_brand_name"])){ ?> checked="checked" <?php } ?> ><?php echo $val["s_brand_name"] ?></li>
									
									<?php  } } ?>
									
								</ul>
							</div>
						</div>
					</div>
				</div> 
			</div> 			
			<?php } ?>	
			<!-- BRAND END --> 
			
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
 	
	 <div class="product_section">
	 	
		<div class="breadcrumb">
			<a href="<?php echo base_url();?>">Home &raquo; </a>
			<span id="bread_crumb"><?php echo 'Search'; ?></span>
		</div>
	 
	 	<div class="clear"></div>
	 	<div class="search_data_box" id="display_searches" style="display: none;">
			<a class="all_filter" style="float:right;" href="javascript:">Clear All Filters</a>
			<ul>
				<li id="str_category"><strong>Category:</strong> <span id="list_search_category"></span></li>					
				<li id="str_store"><strong>Stores:</strong> <span id="list_search_store"></span></li>
				<li id="str_discount"><strong>Discount:</strong> <span id="list_search_discount"></span></li>	
				<li id="str_brand"><strong>Brand:</strong> <span id="list_search_brand"></span></li>						
			</ul>
			<div class="clear"></div>		
		</div>
		<div class="clear"></div>
		
		<div id="div_search_result">
			<div class="lst_vw" id="srch_list">
				<?php echo $search_list; ?>
			</div>
		</div>
		
		<!-- Loading Div -->
                    <div id="infscr-loading"><img src="<?= base_url() ?>images/scrolling_content_loader.gif" alt="Loading..."><div>Loading</div></div>
                <!-- /Loading Div -->
		
		<?php /*?><?php if(!empty($search_list)) { ?>
		 <span id="loading_container_srch_products" style="padding:10px;">
			<div class="loader" align="center" style="background-color:#f2f2f2; padding:5px 0 5px 0;border-radius:4px; border:1px solid #ccc;">
			<div style="color:#666; font-weight:bold;">Please Wait</div>
			<img src="<?php echo base_url(); ?>images/bx_loader.gif" />					
			</div>
		</span>
		<?php } ?><?php */?>
	</div>
	
	 <?php /*?><div class="right_pan">
				<?php //echo $this->load->view('elements/subscribe.tpl.php');?>
				<?php //echo $this->load->view('elements/most_popular.tpl.php');?>
				<?php //echo $this->load->view('elements/facebook_like_box.tpl.php');?>
				<?php // echo $this->load->view('elements/latest_deal.tpl.php');?>
				<?php //echo $this->load->view('elements/forum.tpl.php');?>
				<?php //echo $this->load->view('common/ad.tpl.php');?>
		</div><?php */?>
   <div class="clear"></div>
	
<div class="clear"></div>
<?php echo $this->load->view('common/social_box.tpl.php');?>

<script type="text/javascript">
	//enable_lazy_loading_in_ajax_pagination('srch_list','loading_container_srch_products');
</script>

