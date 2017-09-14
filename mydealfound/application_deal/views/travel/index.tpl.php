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
	var discount_checkboxes = new Array();
	var zone_checkboxes = new Array();
	var bank_checkboxes = new Array();
	
	var search_by_cat =     '';
	var srch_cat_str = '';
	var newCatStr	 = '';
	
	var str_category = '';	
	var str_store = '';
	var str_discount = '';
	$('.search_data_box ul li').hide();
   	$('div[id=display_searches]').hide();
	var str_zone = '';
	var str_bank = '';
	
	/*** category related works here ***/
	$(".catTreeLvl0 a").click(function(){
		search_by_cat = $(this).attr('rel');
		setFirstCategorySub(search_by_cat);
		//setCategoryStr(search_by_cat);
       	ajax_sending();
	});
	
	$(".catTreeLvl1 a").click(function(){
		search_by_cat = $(this).attr('rel');		
		setSecondCategorySub(search_by_cat);
		//setCategoryStr(search_by_cat);
       	ajax_sending();
	});
	
	$(".catTreeLvl2 a").click(function(){
		search_by_cat = $(this).attr('rel');
		//setBreadCrumb(search_by_cat);
		//setCategoryStr(search_by_cat);
       	ajax_sending();
	});
	/*** end here ***/
	
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
	
	$("input[id^=zone_chk_]").click(function(){
		zone_checkboxes = [];
		$("input[id^=zone_chk_]:checked").each(function(i){
           zone_checkboxes[i]   =   $(this).attr('id').split('_').pop();           
        });
		
		ajax_sending();
	});
	
	$("input[id^=bank_chk_]").click(function(){
		bank_checkboxes = [];
		$("input[id^=bank_chk_]:checked").each(function(i){
           bank_checkboxes[i]   =   $(this).attr('id').split('_').pop();           
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
		if(checked_type== "category")
		{
			clear_all_checked('cat_chk_');
			cat_checkboxes  =   new Array();
		}
		if(checked_type== "discount")
		{
			clear_all_checked('discount_chk_');
			discount_checkboxes  =   new Array();
		}
		if(checked_type== "zone")
		{
			clear_all_checked('zone_chk_');
			zone_checkboxes  =   new Array();
		}
		if(checked_type== "bank")
		{
			clear_all_checked('bank_chk_');
			bank_checkboxes  =   new Array();
		}		
		
	   ajax_sending();
   
   });
   
   /********** start click cross button added on 9May 2014 from below *******/
   var fn_clear_cross = function(){
	   $('.cross_srch').click(function(){
			
		   var checked_type =   $(this).attr('title');
		   var _id	=	$(this).attr('rel');
		   //console.log(_id);
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
		   if(checked_type== "zone")
		   {
			   clear_cross_checked('zone_chk_',_id);
			   zone_checkboxes = new Array();	
				$("input[id^=zone_chk_]:checked").each(function(i){
				   zone_checkboxes[i]   =   $(this).attr('id').split('_').pop();           
				}); 
		   }
		   
		   if(checked_type== "bank")
		   {
			   clear_cross_checked('bank_chk_',_id);
			   bank_checkboxes = new Array();	
				$("input[id^=bank_chk_]:checked").each(function(i){
				   bank_checkboxes[i]   =   $(this).attr('id').split('_').pop();           
				}); 
		   }		   
		 
		   ajax_sending();
		   
	   });   
	   
	   $(".all_filter").click(function(){
			window.location.reload();
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
		
		str_category =   '';
		$.each(cat_checkboxes,function(i,value){    
			   str_category +=   ' '+$("input[id=cat_chk_"+value+"]").parent().text()+'<a href="javascript:void(0);" title="category" class="cross_srch" rel="'+value+'"><img src="<?php echo base_url() ?>images/cross-symbol.png" alt="" /></a>'; 
		});
		str_category =   str_category.substring(1,str_category.length);
		
		srch_cat_str = search_by_cat; // new value from tree structure
		
		if(newCatStr!='')
		{
			newCatStr = newCatStr+'<a href="javascript:void(0);" title="category" class="cross_srch" rel="'+srch_cat_str+'"><img src="<?php echo base_url() ?>images/cross-symbol.png" alt="" /></a>';
		}
		
		
		str_store =   '';
		$.each(store_checkboxes,function(i,value){    
			   str_store +=   ' '+$("input[id=store_chk_"+value+"]").parent().text()+'<a href="javascript:void(0);" title="store" class="cross_srch" rel="'+value+'"><img src="<?php echo base_url() ?>images/cross-symbol.png" alt="" /></a>'; 
		});
		str_store =   str_store.substring(1,str_store.length);
		
		str_discount =   '';
		$.each(discount_checkboxes,function(i,value){    
			   str_discount +=   ' '+$("input[id=discount_chk_"+value+"]").parent().text()+'<a href="javascript:void(0);" title="discount" class="cross_srch" rel="'+value+'"><img src="<?php echo base_url() ?>images/cross-symbol.png" alt="" /></a>'; 
		});
		str_discount =   str_discount.substring(1,str_discount.length);
		
		str_zone =   '';
		$.each(zone_checkboxes,function(i,value){    
			   str_zone +=   ' '+$("input[id=zone_chk_"+value+"]").parent().text()+'<a href="javascript:void(0);" title="zone" class="cross_srch" rel="'+value+'"><img src="<?php echo base_url() ?>images/cross-symbol.png" alt="" /></a>'; 
			   
		});
		str_zone =   str_zone.substring(1,str_zone.length);
		
		str_bank =   '';
		$.each(bank_checkboxes,function(i,value){    
			   str_bank +=   ' '+$("input[id=bank_chk_"+value+"]").parent().text()+'<a href="javascript:void(0);" title="bank" class="cross_srch" rel="'+value+'"><img src="<?php echo base_url() ?>images/cross-symbol.png" alt="" /></a>'; 
			   
		});
		str_bank =   str_bank.substring(1,str_bank.length);
		
		/************** added on 9May 2014 from below ******************/   
			   
       $.ajax({
                type: "POST",
                async: false,
                url: base_url+'travel/ajax_pagination_travel/',
                data: "str_cat="+cat_checkboxes+"&arr_store="+store_checkboxes+"&discount_checkboxes="+discount_checkboxes+"&str_zone="+zone_checkboxes+"&str_bank="+bank_checkboxes+"&srch_cat_str="+srch_cat_str+"&type=where",
                success: function(data){
				
							hideBusyScreen();
							
							var wrapper_div_part = '<div id="travel_ajax">'+ data +'</div>';
							$("#div_search_travel_list").html(wrapper_div_part);
							$('.product').show();
							//console.log(data);
							//enable_lazy_loading_in_ajax_pagination('offer_ajax','loading_container_offers',data); 
							  
							/************** added on 9May 2014 from below ******************/
							$('div[id=display_searches]').show();
							/*
							if(newCatStr!='')
							{
								$('li[id=str_category]').show().children('span').html(newCatStr);
								fn_clear_cross();
							}
							*/
							
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
							if(zone_checkboxes!='')
							{
								$('li[id=str_zone]').show().children('span').html(str_zone);
								$("input[id^=zone_chk_]").removeAttr('checked');
								fn_clear_cross();
								
								$.each(zone_checkboxes,function(i,value){    
								if($("input[id=zone_chk_"+value+"]").length)
								{
									$("input[id=zone_chk_"+value+"]").prop('checked','checked');
								}
									 
								});
							}
							
							if(bank_checkboxes!='')
							{
								$('li[id=str_bank]').show().children('span').html(str_bank);
								$("input[id^=bank_chk_]").removeAttr('checked');
								fn_clear_cross();
								
								$.each(bank_checkboxes,function(i,value){    
								if($("input[id=bank_chk_"+value+"]").length)
								{
									$("input[id=bank_chk_"+value+"]").prop('checked','checked');
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
                url: base_url+'travel/ajax_clear_srch_store_session/',
                data: "type=where",
                success: function(data){
							
                		}
                
                });//End of ajax call
       
   };
   

   function setFirstCategorySub(catId)
   {
   		//alert(catId);	
		 $.ajax({
                type: "POST",
                async: false,
				dataType: 'json',
                url: base_url+'travel/ajax_generate_category_label_one/',
                data: "catId="+catId,
                success: function(res){
					//console.log(res);
                  		if(res.status=='success')
						{
							$("#catLabel1").html(res.html);
							//$("#catLabel0").html(res.main_cat);
							$("#catLabel2").html('');	
							//$("#bread_crumb").html(res.breadcrumb);						
						}
							
						$(".catTreeLvl1 a").click(function(){
							search_by_cat = $(this).attr('rel');		
							setSecondCategorySub(search_by_cat);
							ajax_sending();
						});
								  
                	}
                
                });	
   }
		
   function setSecondCategorySub(catId)
   {
   		//alert(catId);	
		 $.ajax({
                type: "POST",
                async: false,
				dataType: 'json',
                url: base_url+'travel/ajax_generate_sub_category_list/',
                data: "catId="+catId,
                success: function(res){
					
                  		if(res.status=='success')
						{
							$("#catLabel2").html(res.html);
							$("#catLabel1").html(res.main_cat);	
							//$("#bread_crumb").html(res.breadcrumb);							
						}
						$(".catTreeLvl2 a").click(function(){
							search_by_cat = $(this).attr('rel');
							//setBreadCrumb(search_by_cat);
							ajax_sending();
						});
						
						/*$(".catTreeLvl0 a").click(function(){
							search_by_cat = $(this).attr('rel');
							setFirstCategorySub(search_by_cat);
							ajax_sending();
						});
						
						$(".catTreeLvl2 a").click(function(){
							search_by_cat = $(this).attr('rel');
							setBreadCrumb(search_by_cat);
							ajax_sending();
						});
						*/
						              
                	}
                
                });	
   }
   
   function setCategoryStr(catId)
   {
   		//alert(catId);	
		 $.ajax({
                type: "POST",
                async: false,
				dataType: 'json',
                url: base_url+'travel/ajax_fetch_category/',
                data: "catId="+catId,
                success: function(res){
						//console.log(res.catName);
						if(res.catName!='')
						{
							newCatStr = res.catName;
						}					              
                	}
                
                });	
   }

});

</script>
    <div class="prodct1">
	
		<!-- LEFT PANEL START -->
		
		<div class="search_panel">			
	
				<form name="srch_form" id="srch_form" action="" method="post">
				<!-- CATEGORY START -->	
				<?php /*
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
				*/	
				?>
				<!-- CATEGORY END --> 
				
				<!-- CATEGORY START TREE LEVEL -->	
				<div class="boxes">
                	<h3>Category</h3>
                	<div class="category_content"> 	
												
					<div id="catLabel0">			
						<div class="catTreeLvl0">
							<a rel='0' href="#" onclick="return false;">All category</a>        
						</div>
					</div>						
					 
					<div id="catLabel1">
					 	<?php  if($main_category) { 
							foreach($main_category as $k=>$v){
						?>          
							<div class="catTreeLvl1"> 
								<a rel="<?php echo $v["i_id"] ?>" href="#" onclick="return false;"><?php echo $v["s_category"] ?></a >
							</div>
						<?php } } ?>
					</div>
					
					<div id="catLabel2">
						<?php 
						if($sub_sub_category) { 
							foreach($sub_sub_category as $k=>$v){
						?>  
						        
							<div class="catTreeLvl2"> 
							<a rel="<?php echo $v["i_id"] ?>" href="#" onclick="return false;"><?php echo $v["s_category"] ?></a >
							</div>
							
						<?php 
							} 
						} 
						?>
						
					</div>
					
					
					</div>
				</div> 	
				
				<!-- CATEGORY END TREE LEVEL--> 				
				  
								
				<!-- STORE START-->
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
				<!-- STORE END -->	
				
				<!-- OFFER ZONE START-->
				<?php if($offer_zone) { ?>	
                <div class="boxes">
					<h3>Offer Zone</h3>		
					<a href="javascript:void(0);" title="zone" class="clear_checked" >Clear</a>		
					<div class="boxes_content">
						<div class="mainScroll">
							<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
							<div class="viewport">
								<div class="overview">
									<ul class="offer_zone">
										<?php foreach($offer_zone as $key=>$val) { ?>
										<li><input type="checkbox" name="offer_zone[]" id="zone_chk_<?php echo $val["i_id"] ?>" <?php if($str_zone*1==$val['i_id']){ ?> checked="checked" <?php } ?> ><?php echo $val["s_offer"] ?></li>
										
										<?php } ?>
									</ul>
								</div>
							</div>
						</div>
					</div> 
				</div>
                <?php } ?>
				<!-- OFFER ZONE END -->  
				
				
				<!-- BANK OFFER START-->
				<?php if($bank_offer) { ?>	
                <div class="boxes">
					<h3>Bank Offer</h3>		
					<a href="javascript:void(0);" title="bank" class="clear_checked" >Clear</a>		
					<div class="boxes_content">
						<div class="mainScroll">
							<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
							<div class="viewport">
								<div class="overview">
									<ul class="bank_offer">
										<?php foreach($bank_offer as $key=>$val) { ?>
										<li><input type="checkbox" name="bank_offer[]" id="bank_chk_<?php echo $val["i_id"] ?>" <?php if($str_bank*1==$val['i_id']){ ?> checked="checked" <?php } ?> ><?php echo $val["s_bank"] ?></li>
										
										<?php } ?>
									</ul>
								</div>
							</div>
						</div>
					</div> 
				</div>
                <?php } ?>
				<!-- BANK OFFER END -->   	
				
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
										<li><input type="checkbox" name="prod_discount[]" id="discount_chk_70" value="70" <?php if($str_discount=='70'){ ?> checked="checked" <?php } ?>>70% and above </li>
										<li><input type="checkbox" name="prod_discount[]" id="discount_chk_60" value="60" <?php if($str_discount=='60'){ ?> checked="checked" <?php } ?>>60% and above </li>				
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
			
			
			<div class="search_data_box" id="display_searches" style="display: none;">
				<a class="all_filter" style="float:right;" href="javascript:">Clear All Filters</a>
				<ul>	
					<li id="str_category"><strong>Category:</strong> <span id="list_search_category"></span></li>
					<li id="str_zone"><strong>Offer Zone:</strong> <span id="list_search_zone"></span></li>				
					<li id="str_bank"><strong>Bank:</strong> <span id="list_search_bank"></span></li>				
					<li id="str_store"><strong>Stores:</strong> <span id="list_search_store"></span></li>
					<li id="str_discount"><strong>Discount:</strong> <span id="list_search_discount"></span></li>				
				</ul>
				<div class="clear"></div>		
			</div>
			<div class="clear"></div>
					
			<?php /*?><div class="product_box"><?php */?>
            	<div id="div_search_travel_list" class="top_offer_srch">
                    <div id="travel_ajax">
						<?php echo $travel_list; ?>
                    </div>
                </div>
                
			
                <!-- Loading Div -->
                    <div id="infscr-loading"><img src="<?= base_url() ?>images/scrolling_content_loader.gif" alt="Loading..."><div>Loading</div></div>
                <!-- /Loading Div -->
                
				<div class="clear"></div>			
			<?php /*?></div><?php */?>	
		</div>

	
	

	<div class="clear"></div>
    </div> 


<?php $this->load->view('common/social_box.tpl.php'); ?>