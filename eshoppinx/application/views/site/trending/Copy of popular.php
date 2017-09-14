<?php 
$this->load->view('site/templates/header',$this->data);
$this->load->view('site/templates/popup_product_detail.php',$this->data);
?> 

<style>
.brand_product li img{
    width: 172px;
    height: 204px;
}
</style> 

   <!-- Section_start -->
   
   <div id="mid-panel">
        <div class="wrapper">
            <h1><?php if($this->lang->line('lg_most_popular') != '') { echo stripslashes($this->lang->line('lg_most_popular')); } else echo "Most Popular";?>:</h1>
            
            <div class="brand_product">
                <?php 
                if (count($products_list) > 0){
                ?>
                <ul>
                    <?php 
                    foreach ($products_list as $products_list_row){
                    
                        $prodImg = 'dummyProductImage.jpg';
                        $prodImgArr = array_filter(explode(',', $products_list_row->image));
                        if (count($prodImgArr)>0){
                            foreach ($prodImgArr as $prodImgArrRow){
                                if (file_exists('images/product/thumb/'.$prodImgArrRow)){
                                    $prodImg = $prodImgArrRow;
                                    break;    
                                }
                            }
                        }
                        $userName = 'administrator';
                        $fullName = 'administrator';
                        if ($products_list_row->user_id > 0){
                            $userName = $products_list_row->user_name;
                            $fullName = character_limiter($products_list_row->full_name,20);
                            if (strlen($fullName)>20){
                                $fullName = substr($fullName, 0,20).'..';    
                            }
                        }
                        if ($fullName == ''){
                            $fullName = $userName;
                        }
                        $userImg = 'default_user.jpg';
                        if ($products_list_row->thumbnail != ''){
                            $userImg = $products_list_row->thumbnail;
                        } 
                        if (isset($products_list_row->web_link)){
                            $prod_link = 'user/'.$userName.'/things/'.$products_list_row->seller_product_id.'/'.url_title($products_list_row->product_name,'-');
                        }else {
                            $prod_link = 'things/'.$products_list_row->id.'/'.url_title($products_list_row->product_name,'-');
                        }
                    ?>
                    <!--<li>
                        <img src="images/product/thumb/<?php echo $prodImg;?>" alt="">
                        <div class="overlay">
                            <a href="<?php echo $prod_link;?>"><h3><span>&#8377;</span> <?php echo $products_list_row->price;?></h3></a>
                            <h4><a href="<?php echo $prod_link;?>"><?php echo $products_list_row->product_name;?></a> <span><a href="user/<?php echo $userName;?>">By <?php echo $fullName;?></a></span> </h4>
          <span class="brand"><a href="javascript:">Arrow</a></span>
          
                            
                            <div class="butn-overlay save <?php if ($loginCheck==''){echo 'sign_box';}?>" data-pid="<?php echo $products_list_row->seller_product_id;?>">
                                                      
                              <strong><?php if($this->lang->line('header_save') != '') { echo stripslashes($this->lang->line('header_save')); } else echo "Save"; ?></strong>
                                
                                <span><?php echo $products_list_row->likes;?> <?php if($this->lang->line('product_saves') != '') { echo stripslashes($this->lang->line('product_saves')); } else echo "saves"; ?></span>                          
                          </div>
                            
                        </div>
                    </li>-->
                    
                    <li>
                        <div class="main-box2">
                            <img src="images/product/thumb/<?php echo $prodImg;?>" alt="">
                            <div class="overlay">
                                <a href="<?php echo $prod_link;?>"><h3><span>&#8377;</span> <?php echo $products_list_row->price;?></h3></a>
                                <h4><a href="<?php echo $prod_link;?>"><?php echo $products_list_row->product_name;?></a> </h4> 
                            </div>
                        </div>
                        <div class="article2">
                            <h4><span><a href="user/<?php echo $userName;?>">By <?php echo $fullName;?></a></span>  </h4>
                              <span class="brand"><a href="javascript:">Arrow</a></span>
                        </div>
                    </li>
                    
                    
                    <?php 
                        }
                     ?>
                </ul>
                 <div id="infscr-loading" style="display:none;">
                    <!--img alt='Loading...' src="/_ui/images/site/common/ajax-loader.gif"-->
                    <span class="loading">Loading...</span>
                   </div>
                    
                     <div class="pagination" style="display:none">
                            <?php echo $paginationDisplay; ?>
                </div>
               <?php 
                }else {
               ?> 
                <h3><?php if($this->lang->line('product_noavail') != '') { echo stripslashes($this->lang->line('product_noavail')); } else echo "No products available"; ?></h3>
                <?php 
                }
                ?>                        
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    
     	        
        
   <!-- Section_end -->
<script type="text/javascript">
$('.example16').click(function(){
	$('#inline_example11 .popup_page').html('<div class="cnt_load"><img src="images/ajax-loader.gif"/></div>');
	var pid = $(this).data('pid');
	var pname = $(this).text();
	var purl = baseURL+$(this).attr('href');
	$.ajax({
		type:'get',
		url:baseURL+'site/product/get_product_popup',
		data:{'pid':pid},
		dataType:'html',
		success:function(data){
			window.history.pushState({"html":data,"pageTitle":pname},"", purl);
			$('#inline_example11 .popup_page').html(data);
		}
	});
});
var loading=false;
var $win     = $(window),
$stream  = $('ul.product_main_thumb');
$(window).scroll(function() { //detect page scroll
	if($(window).scrollTop() + $(window).height() == $(document).height())  //user scrolled to bottom of the page?
	{
		var $url = $('.btn-more').attr('href');
		if(!$url) $url='';
		if($url != '' && loading==false) //there's more data to load
		{
			loading = true; //prevent further ajax loading
			$('#infscr-loading').show(); //show loading image
			//var vmode = $('.figure.classic').css('display');
			//load data from the server using a HTTP POST request
			
			$.ajax({
					type:'post',
					url:$url,
					success:function(html){
//						alert(data);	
				
				
						var $html = $($.trim(html)),
					    $more = $('.pagination > a'),
					    $new_more = $html.find('.pagination > a');

					if($html.find('ul.product_main_thumb').text() == ''){
						//$stream.append('<ul class="product_main_thumb"><li style="width: 100%;"><p class="noproducts">No more products available</p></li></ul>');
					}else {
						$stream.append( $html.find('ul.product_main_thumb').html());
					}
					if($new_more.length) $('.pagination').append($new_more);
					$more.remove();
				
				
				//hide loading image
				$('#infscr-loading').hide(); //hide loading image once data is received
				
				loading = false; 
				after_ajax_load();
			
				},
				fail:function(xhr, ajaxOptions, thrownError) { //any errors?
					
					alert(thrownError); //alert with HTTP error
					$('#infscr-loading').hide(); //hide loading image
					loading = false;
				
				}
			});
			
		}
	}
});
</script>   
<?php 
$this->load->view('site/templates/footer',$this->data);
?>
