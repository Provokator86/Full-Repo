<?php 
$this->load->view('site/templates/header',$this->data);
$this->load->view('site/templates/popup_product_detail.php',$this->data);
?>  
   <!-- Section_start -->
    
     	<section>
        
        	<div class="section_main">
            
            	<div class="main2">
                <div class="main_box">
                <?php 
                $this->data['followingUserDetails'] = $userProfileDetails;
		       	$this->load->view('site/user/display_user_header',$this->data);
		        ?>
                    
                		<div class="tab_product">
                        
                        	<ul class="tab_box">
                            
                            	<li><a href="javascript:void(0);" class="tab_active"><?php if($this->lang->line('user_things') != '') { echo stripslashes($this->lang->line('user_things')); } else echo "Things"; ?><strong><?php echo $totalProducts;?></strong></a></li>
                                
                                <li><a href="user/<?php echo $user_profile_details->row()->user_name;?>/lists/<?php echo $list_details->row()->id;?>/followers"><?php if($this->lang->line('display_followers') != '') { echo stripslashes($this->lang->line('display_followers')); } else echo "Followers"; ?><strong><?php echo $list_details->row()->followers_count;?></strong></a></li>
                            
                            
                            </ul>
                            
                            
                            <!--<ul class="right_tab">
                            
                            	<li><a class="find_btn" href="people">Find People</a></li>
                                
                                <li><a class="find_btn" href="stores">Find Stores</a></li>
                            
                            
                            </ul>-->
                        
                        
                        </div>
                        
                        <div class="product_main">
                        
                           <?php 
		if (($product_details != '' && $product_details->num_rows()>0) || ($notsell_product_details != '' && $notsell_product_details->num_rows()>0)){
		?>
                            	<ul class="product_main_thumb">
                			<?php 
			if ($product_details != '' && $product_details->num_rows()>0){
			foreach ($product_details->result() as $productRow){
				$imgArr = array_filter(explode(',', $productRow->image));
          		$img = 'dummyProductImage.jpg';
          		foreach ($imgArr as $imgVal){
          			if ($imgVal != ''){
						$img = $imgVal;
						break;
          			}
          		}
          		$fancyClass = 'fancy';
          		$fancyText = LIKE_BUTTON;
          		if (count($likedProducts)>0 && $likedProducts->num_rows()>0){
          			foreach ($likedProducts->result() as $likeProRow){
          				if ($likeProRow->product_id == $productRow->seller_product_id){
          					$fancyClass = 'fancyd';$fancyText = LIKED_BUTTON;break;
          				}
          			}
          		}
			?>
                                        <li class="boxgrid captionfull"><a href="javascript:void(0);"><img src="images/product/<?php echo $img;?>" /></a>
                                        
                                        	<div class="cover boxcaption">
                                                    <div class="deal_tag">
                                                      
                                                      <div class="tag <?php if ($loginCheck==''){echo 'sign_box';}else {echo 'tag_box';}?>" data-pid="<?php echo $productRow->seller_product_id;?>">
                                                      
                           	                           		<strong><?php if($this->lang->line('product_tag') != '') { echo stripslashes($this->lang->line('product_tag')); } else echo "Tag"; ?></strong>
                                                            
                                                            <span><?php if($this->lang->line('product_afreiend') != '') { echo stripslashes($this->lang->line('product_afreiend')); } else echo "a friend"; ?></span>
                                                      
                                                      </div>
                                                      
                                                      <div class="save <?php if ($loginCheck==''){echo 'sign_box';}?>" data-pid="<?php echo $productRow->seller_product_id;?>">
                                                      
                           	                           		<strong><?php if($this->lang->line('header_save') != '') { echo stripslashes($this->lang->line('header_save')); } else echo "Save"; ?></strong>
                                                            
                                                            <span><?php echo $productRow->likes;?> <?php if($this->lang->line('product_saves') != '') { echo stripslashes($this->lang->line('product_saves')); } else echo "saves"; ?></span>
                                                      
                                                      </div>
                                                      
                                                      <div class="deal_tag_title">
                                                      
                                                      	<h2> <a class="example16" data-pid="<?php echo $productRow->seller_product_id;?>" href="things/<?php echo $productRow->id;?>/<?php echo url_title($productRow->product_name,'-');?>"><?php echo $productRow->product_name;?></a></h2>
                                                        
                                                        <p>posted by <a href="<?php if ($productRow->user_id != '0'){echo base_url().'user/'.$productRow->user_name;}else {echo base_url().'user/administrator';}?>"><?php if ($productRow->user_id != '0'){echo $productRow->full_name;}else {echo 'administrator';}?></a>  + <?php echo $productRow->likes;?> <span> <?php echo $currencySymbol;?><?php echo $productRow->sale_price;?> </span></p>
                                                        
                                                      </div>
                                                      
                                                      
                                                    </div>
                                             </div>
                                        
                                        </li>
                         <?php 
                			}
                         ?>               
                
                			</ul>
                            
                           <?php 
                            }else {
                           ?> 
							<h3><?php if($this->lang->line('product_noavail') != '') { echo stripslashes($this->lang->line('product_noavail')); } else echo "No products available"; ?></h3>
							<?php 
                            }}
							?>                        
                        </div>
                
                </div>
                </div>
            
            
            
            </div>
        
        	
        	
        
		</section>
        
        
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
</script>   
<?php 
$this->load->view('site/templates/footer',$this->data);
?>
