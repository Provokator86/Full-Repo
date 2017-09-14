<?php if ($loginCheck != '' && $this->uri->segment(1,0)=='stories'){?>
<div style='display:none'>

  <div id='inline_example20' style='background:#fff;'>
  
  		<div class="popup_page">
        
        	<!--<a class="close_box" href="javascript:void(0)">x</a>-->   
                                    <div class="modal-body">
                                    <h3 class="stories-remaining-products" style="margin:0 0 15px; font-size:20px;"><?php if($this->lang->line('templates_uptonine') != '') { echo stripslashes($this->lang->line('templates_uptonine')); } else echo "Choose up to 9 products"; ?></h3>
                                    <div class="stories-collection-selection control-group">
                                    <div class="products-select-collection">
                                    <input type="hidden" value="" name="collection_id" id="collection_id">
                                    <input type="hidden" value="false" name="collection_is_new" id="collection_is_new">
                                   <a href="javascript:showView('2');"> 
                                   <div class="products-selected-collection-name-container button wb-light">
                                    <span class="products-selected-collection-name">
                                    <?php if($this->lang->line('templates_chosefrom') != '') { echo stripslashes($this->lang->line('templates_chosefrom')); } else echo "Choose products from"; ?>...
                                    </span>
                                    </div>
                                    </a>
                                    <div class="select-list-inner1" id="showlist2" >
                                        <ul class="products-collections">
                                            <li onclick="javascript:load_collection_products('all');"><a href="javascript:void(0)"><?php if($this->lang->line('templates_all_prods') != '') { echo stripslashes($this->lang->line('templates_all_prods')); } else echo "All Products"; ?></a></li>
                                            <?php 
                                            if ($collectionProducts['list_details'] != '' && $collectionProducts['list_details']->num_rows()>0){
                                            	foreach ($collectionProducts['list_details']->result() as $list_details_row){
                                            ?>
                                            <li onclick="javascript:load_collection_products('<?php echo $list_details_row->id;?>');"><a href="javascript:void(0)"><?php echo $list_details_row->name;?></a></li>
                                            <?php 
                                            	}
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                  
                                    </div>
                                    
                                    </div>
                                    <div class="stories-product-selector-products">
                                    		<div class="stories-new-saves">
                                    		<?php 
                                    		$pid_count = 0;
                                    		if ($collectionProducts['list_products'] != '' && count($collectionProducts['list_products'])>0){
                                    			foreach ($collectionProducts['list_products'] as $list_product_row) {
                                    				$pid_count++; //if ($pid_count>9)break;
                                    				$prodImg = 'dummyProductImage.jpg';
                                    				$prodImgArr = array_filter(explode(',', $list_product_row->image));
                                    				if (count($prodImgArr)>0){
                                    					foreach ($prodImgArr as $prodImgRow){
                                    						if (file_exists('images/product/'.$prodImgRow)){
                                    							$prodImg = $prodImgRow;break;
                                    						}
                                    					}
                                    				}
                                    		?>
                                                <div onclick="javascript:select_product(this)" data-pid="<?php echo $list_product_row->seller_product_id;?>" class="stories-new-save">
	                                                <img width="200" height="200"  src="images/product/<?php echo $prodImg;?>" itemprop="image" class="product-image product-x200" alt="<?php echo $list_product_row->product_name;?>">
	                                                <span class="stories-new-icon round-selector">
	                                               <!-- <i class="icon-ok"></i>
	                                                <i class="icon-remove"></i>-->
	                                                </span>
                                                </div>
                                             <?php 
                                    			}
                                    		}
                                             ?>   
                                                <div class="clearfix"></div>
                                                </div>
                                    </div>
                                    <div class="centered" style="float: left; margin: 20px auto; width: 100%;">
                                    <button class="stories-product-selector-done button large wb-primary"><?php if($this->lang->line('header_done') != '') { echo stripslashes($this->lang->line('header_done')); } else echo "Done"; ?></button>
                                    </div>
                                    </div>
        
        </div>
        
  </div>
  
</div>
<?php }?>