<?php 
$this->load->view('site/templates/header');
$this->load->view('site/templates/popup_product_detail.php');
?>
 <!-- Section_start -->
    	<script type="text/javascript">
function showView(val){
	if($('#showlist'+val).css('display')=='block'){
		$('#showlist'+val).hide();	
	}else{
		$('#showlist'+val).show();
	}	
}
function load_collection_products(cid,evt){
	$('.stories-new-saves').html('Loading...');
	$('.products-selected-collection-name').text($(evt).text());
	if(cid != ''){
		$.ajax({
			type:'post',
			url:baseURL+'site/stories/get_collection_products',
			data:{cid:cid},
			dataType:'json',
			success:function(json){
				$('.stories-new-saves').html(json.content);
			},
			complete:function(){
				$('#showlist2').hide();	
			}
		});
	}
}
function select_product(evt){
	var pid = $(evt).data('pid');
	var curDiv = $(evt).find('span');
	var pcount = $('.stories-new-form').data('pcount');
	if(pcount>8){
		alert('9 <?php if ($this->lang->line('lg_prod_alr_aded')!=''){echo $this->lang->line('lg_prod_alr_aded');}else {?>products already added<?php }?>');
	}else{
		if(curDiv.hasClass('selector-active')){
			curDiv.removeClass('selector-active');
			$('.stories-new-form-reorder-products').find('.imgCnt'+pid).remove();
			pcount--;
			if(pcount<0)pcount=0;
		}else{
			curDiv.addClass('selector-active');
			var imgCnt = $(evt).html();
			$('.stories-new-form-reorder-products').append('<div style="float:left;margin:5px;position:relative;" class="imgCnt'+pid+' imgCntCon" data-pid="'+pid+'"><input type="hidden" name="story_pid[]" value="'+pid+'"><a href="javascript:removeImgCnt(\''+pid+'\');" style="float:right;position:absolute;top:5px;right:5px;color:#000;font-weight:bold;">X</a>'+imgCnt+'</div>');
			pcount++;
			if(pcount<0)pcount=0;
		}
		$('.stories-new-form').data('pcount',pcount);
		if(pcount>8){
			$('.stories-new-product-add').hide();
		}
	}
}
function removeImgCnt(pid){
	var pcount = $('.stories-new-form').data('pcount');
	$('.stories-new-form-reorder-products').find('.imgCnt'+pid).remove();
	pcount--;
	if(pcount<0)pcount=0;
	$('.stories-new-form').data('pcount',pcount);
	if(pcount<9){
		$('.stories-new-product-add').show();
	}
}
</script>
     	<section>
        
        	<div class="section_main" style="background:#FFF">
            
            	<div class="main2">
                <?php if($flash_data != '') { ?>
		<div class="errorContainer" id="<?php echo $flash_data_type;?>">
			<script>setTimeout("hideErrDiv('<?php echo $flash_data_type;?>')", 3000);</script>
			<p><span><?php echo $flash_data;?></span></p>
		</div>
		<?php } 
		?>
                	<div class="left_side">                   
                            <div id="outer" class="container push-body" style="margin-top: 50px;">
                                    <div id="inner">
                                    <div class="stories-new-container">
                                    <div class="stories-new-header">
                                    <h2><?php if($this->lang->line('lg_edit_story') != '') { echo stripslashes($this->lang->line('lg_edit_story')); } else echo "Edit story"; ?></h2>
                                    </div>
                                    <div class="stories-new-form" data-pcount="<?php echo count($prodImgDetails);?>">
                                    <form method="post" id="new_story" class="new_story" action="site/stories/edit_story" accept-charset="UTF-8">
                                    <input type="hidden" name="sid" value="<?php echo $this->uri->segment(2);?>"/>
                                    <input type="hidden" name="next" value="<?php echo $this->input->get('next');?>"/>
                                    <div class="control-group">
                                    <textarea rows="20" placeholder="<?php if($this->lang->line('story_whatdowant') != '') { echo stripslashes($this->lang->line('story_whatdowant')); } else echo "What do you want to say"; ?>?"  name="story_body" maxlength="500" id="story_body" cols="40" ><?php echo $story_details->row()->description;?></textarea>
                                    </div>
                                    <div class="stories-new-form-reorder-products stories-product-selector-products">
                                    <?php 
                                    if (count($prodImgDetails)>0){
                                    	foreach ($prodImgDetails as $key=>$val){
                                    		$imgArr = explode(',', $val);
                                    		if (count($imgArr)>0){
                                    			foreach ($imgArr as $row){
                                    				if ($row!=''){
                                    					$prodImg = $row;break;
                                    				}
                                    			}
                                    		}
                                    ?>		
                                    	<div style="float:left;margin:5px;position:relative;" class="imgCnt<?php echo $key;?> imgCntCon" data-pid="<?php echo $key;?>">
	                                    	<input type="hidden" name="story_pid[]" value="<?php echo $key;?>">
	                                    	<a href="javascript:removeImgCnt('<?php echo $key;?>');" style="float:right;position:absolute;top:5px;right:5px;color:#000;font-weight:bold;">X</a>
	                                    		<img width="200" height="200" src="images/product/<?php echo $prodImg;?>" itemprop="image" class="product-image product-x200" alt="">
                                    	</div>
                                    <?php 		
                                    	}
                                    }
                                    ?>
                                    </div>
                                    
                                    <div class="stories-new-product-add example25" style="display:<?php if (count($prodImgDetails)<9){?>block<?php }else {?>none<?php }?>;">
                                    <a href="#"><span class="image-plus"></span>
                                    <?php if($this->lang->line('story_addprod') != '') { echo stripslashes($this->lang->line('story_addprod')); } else echo "add products"; ?>
                                    </a></div>
                                    
                                    <div class="clearfix"></div>
                                    <div class="control-group centered stories-new-form-submit">
                                    <input type="submit" value="<?php if($this->lang->line('cart_update') != '') { echo stripslashes($this->lang->line('cart_update')); } else echo "Update"; ?>" name="commit" class="button large wb-primary disabled">
                                    </div>
                                    </form>
                                    </div>
                                    </div>
                                    
                                    
                                    
                                    </div>
            
        		    </div>
                        
                      </div>
                
                </div>
            
            
            
            </div>
           
		</section>
        
        
   <!-- Section_end -->
   
<?php 
$this->load->view('site/templates/footer');
?>