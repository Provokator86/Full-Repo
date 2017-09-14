<script type="text/javascript" src="<?php echo base_url() ?>js/fe/lazy_loading_pagination.js"></script>
<script type="text/javascript">
var base_url = '<?php echo base_url();?>';
$(document).ready(function(){
	var brand_checkboxes 	= new Array();
	var store_checkboxes 	= new Array();
	var search_by_cat =     '';
	var price_range =     '';
	var priceFrom = '';
	var priceTo = '';
	var d_discount =     '';
	
	
	$(".catTreeLvl2 a").click(function(){
		search_by_cat = $(this).attr('rel');
		setBreadCrumb(search_by_cat);
       	ajax_sending();
	});
	
	$(".catTreeLvl1 a").click(function(){
		search_by_cat = $(this).attr('rel');		
		setSecondCategorySub(search_by_cat);
       	ajax_sending();
	});
	
	$(".catTreeLvl0 a").click(function(){
		search_by_cat = $(this).attr('rel');
		setFirstCategorySub(search_by_cat);
       	ajax_sending();
	});
	
	$(".prod_price li input[type='radio']").click(function(){
		price_range = $(this).val();
		ajax_sending();
	});
	
	$(".prod_discount li input[type='radio']").click(function(){
		d_discount = $(this).val();
		ajax_sending();
	});
	
	
	$("#btn_go").bind('click',function(){
		priceFrom = $("#price_from").val();
		priceTo   = $("#price_to").val();
		if( parseInt(priceTo) > parseInt(priceFrom))
		{
			ajax_sending();
		}
		else
		{
			alert('Provide proper range value');
		}
		return false;
	});
	
	$("input[id^=brand_chk_]").click(function(){
		brand_checkboxes = [];
		$("input[id^=brand_chk_]:checked").each(function(i){
           brand_checkboxes[i]   =   $(this).attr('id').split('_').pop();           
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
	
	/************* Start Function ajax sending *********/
   function ajax_sending()
   {       
       str_category = search_by_cat;  
	   str_price_range	= price_range;
	   str_price_from	= priceFrom;
	   str_price_to		= priceTo;
	   
			   
       $.ajax({
                type: "POST",
                async: false,
                url: base_url+'category/ajax_pagination_product_list/',
                data: "str_category="+str_category+"&arr_brand="+brand_checkboxes+"&arr_store="+store_checkboxes+"&str_price_range="+str_price_range+"&str_price_from="+str_price_from+"&str_price_to="+str_price_to+"&d_discount="+d_discount+"&type=where",
                success: function(data){
							//$(".product_box").html('');
                  			$("#product_ajax").html(data);
							$('.product').show();    
							/*$('.product_box').html('');
							$('.product_box').html(data);
							$('.product_box').attr('id','product_ajax');
							enable_lazy_loading_in_ajax_pagination('product_ajax','loading_container_products'); */
							       
                		}
                
                });//End of ajax call
       
   };
   
   /************* End Function ajax sending *********/
   
   
   /************* Start Function category changing *********/
   
   function setFirstCategorySub(catId)
   {
   		//alert(catId);	
		 $.ajax({
                type: "POST",
                async: false,
				dataType: 'json',
                url: base_url+'category/ajax_generate_sub_category_label_one/',
                data: "catId="+catId,
                success: function(res){
					//console.log(res);
                  		if(res.status=='success')
						{
							$("#catLabel1").html(res.html);
							$("#catLabel0").html(res.main_cat);
							$("#catLabel2").html('');	
							$("#bread_crumb").html(res.breadcrumb);						
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
                url: base_url+'category/ajax_generate_sub_category_list/',
                data: "catId="+catId,
                success: function(res){
					
                  		if(res.status=='success')
						{
							$("#catLabel2").html(res.html);
							$("#catLabel1").html(res.main_cat);	
							$("#bread_crumb").html(res.breadcrumb);							
						}
						
						$(".catTreeLvl0 a").click(function(){
							search_by_cat = $(this).attr('rel');
							setFirstCategorySub(search_by_cat);
							ajax_sending();
						});
						
						<?php /*?>$(".catTreeLvl1 a").click(function(){
							search_by_cat = $(this).attr('rel');		
							setSecondCategorySub(search_by_cat);
							ajax_sending();
						});<?php */?>
						
						$(".catTreeLvl2 a").click(function(){
							search_by_cat = $(this).attr('rel');
							setBreadCrumb(search_by_cat);
							ajax_sending();
						});
						              
                	}
                
                });	
   }
   
   function setBreadCrumb(catId)
   {
   		//alert(catId);	
		 $.ajax({
                type: "POST",
                async: false,
				dataType: 'json',
                url: base_url+'category/ajax_fetch_breadcrumb/',
                data: "catId="+catId,
                success: function(res){
						$("#bread_crumb").html(res.breadcrumb);	
						console.log(res);
						$(".catTreeLvl0 a").click(function(){
							search_by_cat = $(this).attr('rel');
							setFirstCategorySub(search_by_cat);
							ajax_sending();
						});
						
						$(".catTreeLvl1 a").click(function(){
							search_by_cat = $(this).attr('rel');		
							setSecondCategorySub(search_by_cat);
							ajax_sending();
						});
						
						$(".catTreeLvl2 a").click(function(){
							search_by_cat = $(this).attr('rel');
							ajax_sending();
						});
						              
                	}
                
                });	
   }
   /************* Start Function category changing *********/

});

</script>
    <div class="prodct1">
		<!-- LEFT PANEL START -->
		
		<div class="search_panel">
				
				<!--<div> Narrow your Search<span></span></div>-->
				<form name="srch_form" id="srch_form" action="" method="post">
				<!-- CATEGORY START -->
				<!--<div class="boxes">
					<h3>Category</h3>
					<div class="boxes_content"> 
						<ul>
							<li><input type="checkbox"> All Clothing  </li>
							<li><input type="checkbox"> All Ethnic Wear   </li>
							<li><input type="checkbox"> Kurtas &amp; Kurtis  </li>
						</ul>
						
					</div>	                    
				</div>-->
				<div class="boxes">
                <h3>Category</h3>
                	<div class="category_content"> 	
							
					<div id="catLabel0">			
					<div class="catTreeLvl0">
						<a rel="<?php echo $category_id ?>" href="<?php echo base_url().'category/'.getCategoryUrl($category_id); ?>" onclick="return false;"><?php echo getCategoryName($category_id); ?></a>        
					</div>
					</div>
						
					 
					 <div id="catLabel1">
						<?php if($sub_category) { 
							foreach($sub_category as $k=>$v){
						?>          
							<div class="catTreeLvl1"> 
								<a rel="<?php echo $v["i_id"] ?>" href="<?php echo base_url().'category/'.$v["s_url"]; ?>" onclick="return false;"><?php echo $v["s_category"] ?></a >
							</div>
						<?php } } ?>
					</div>
					
					<!--<div class="catTreeLvl2"><a href="javascript:void(0);">Crew Neck T-Shirts</a>  </div>
					<div class="catTreeLvl2"><a href="javascript:void(0);">Polo T-Shirts </a></div>-->
					
					<div id="catLabel2">
						
					</div>
					
					
				</div>
				</div>
				
				
				<!-- CATEGORY END -->
										
				<!-- PRICE RANGE START-->
				<div class="boxes"> 	 			
					<h3>Price</h3>				
					<div class="boxes_content"> 
					<ul class="prod_price">				
						<li><input type="radio" name="price-range" value="0-700">below Rs. 700 </li>
						<li><input type="radio" name="price-range" value="700-1000"> Rs. 700 - Rs. 1000 </li>				
						<li><input type="radio" name="price-range" value="1001-2000"> Rs. 1001 - Rs. 2000 </li>
						<li><input type="radio" name="price-range" value="2001-2500"> Rs. 2001 - Rs. 2500 </li>
						<li><input type="radio" name="price-range" value="2501"> above Rs. 2500 </li>
					</ul>
                    <div class="price_range">
						<form class="price_range" method="post" action="">
							<legend>Enter a Price range in Rs.</legend>		
							<input type="text" maxlength="6" name="price_from" id="price_from" value="299" >- 
							<input type="text" maxlength="6" name="price_to" id="price_to" value="5299" >						
							<input type="submit" id="btn_go" value="GO" >
						</form>
                        </div>					
					</div>					             
				</div>
				<!-- PRICE RANGE END -->
				
				<!-- DISCOUNTS START -->
				<div class="boxes">
					<h3>Discounts</h3>				
					<div class="boxes_content">
						<ul class="prod_discount">		
							<!--<li><input type="checkbox"> Non-Discounted items </li>
							<li><input type="checkbox"> Discounted items </li>-->
							<li><input type="radio" name="d_discount" value="70">70% and above </li>
							<li><input type="radio" name="d_discount" value="60">60% and above </li>				
							<li><input type="radio" name="d_discount" value="50"> 50% and above</li>
							<li><input type="radio" name="d_discount" value="40"> 40% and above </li>
							<li><input type="radio" name="d_discount" value="30"> 30% and above </li>							
							<li><input type="radio" name="d_discount" value="20"> 20% and above </li>
							<li><input type="radio" name="d_discount" value="10"> 10% and above </li>
							<li><input type="radio" name="d_discount" value="none"> None </li>
						</ul>
					</div>
				</div>				
				<!-- DISCOUNTS END -->
							
				<!-- BRAND START -->	
				<?php if($all_brand) { ?>		
				<div class="boxes">
					<h3>Brand</h3>				
					<div class="boxes_content" style="max-height:200px; overflow-y:scroll;">
						<?php /*?><input type="text" placeholder="Search brand..." autocomplete="off" class="search_box" ><?php */?>						
						<ul class="prod_brand">
							<!--<li><input type="checkbox">18 Fire</li>
							<li><input type="checkbox">Aabroo</li>
							<li><input type="checkbox">Aapno Rajasthan</li>
							<li><input type="checkbox">Aashima</li>-->
							<?php foreach($all_brand as $key=>$val) { ?>
							<li><input type="checkbox" name="prod_brand[]" id="brand_chk_<?php echo $val["i_id"] ?>"><?php echo $val["s_brand_title"] ?></li>
							
							<?php } ?>
							
						</ul>
					</div> 
				</div> 			
				<?php } ?>	
				<!-- BRAND END --> 
                
				<?php if($all_store) { ?>	
                <div class="boxes">
					<h3>Stores</h3>				
					<div class="boxes_content" style="max-height:200px; overflow-y:scroll;">
						<ul class="prod_store">
							<!--<li><input type="checkbox">18 Fire</li>
							<li><input type="checkbox">Aabroo</li>
							<li><input type="checkbox">Aapno Rajasthan</li>
							<li><input type="checkbox">Aashima</li>-->
							<?php foreach($all_store as $key=>$val) { ?>
							<li><input type="checkbox" name="prod_store[]" id="store_chk_<?php echo $val["i_id"] ?>"><?php echo $val["s_store_title"] ?></li>
							
							<?php } ?>
						</ul>
					</div> 
				</div>
                <?php } ?>
				</form>
				
		</div>
		<!-- LEFT PANEL END -->
		<!-- PRODUCT BLOCK START -->
		<div class="mid_panel">
			<div class="breadcrumb">
			<a href="<?php echo base_url();?>">Home &raquo; </a>
			<span id="bread_crumb"><?php echo $category_breadcrumb ?></span>
			<?php //echo '<a href="'.base_url().'">Home</a> &raquo; '.$category_breadcrumb //echo getCategoryName($category_id); ?>
			</div>				
			<div class="product_box">
			
				<div id="product_ajax">
					<?php echo $product_list; ?>
				</div>
				
				<span id="loading_container_products">
					<div class="loader"><?php /*?><img src="<?php echo base_url(); ?>images/ajax-loader.gif" /><?php */?></div>
				</span>
			
				<div class="clear"></div>			
			</div>	
		</div>
		<!-- PRODUCT BLOCK END -->
	<!--<div class="right_pan right_pan_margin">&nbsp;</div>-->
	<!-- RIGHT PANEL START -->
	
	
	<!-- RIGHT PANEL END -->
	<div class="clear"></div>
    </div>


<?php $this->load->view('common/social_box.tpl.php'); ?>
<script type="text/javascript">
	enable_lazy_loading_in_ajax_pagination('product_ajax','loading_container_products');
</script>