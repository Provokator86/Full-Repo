<div class="page-content page-content2">
    <?php /*?><h2><img src="images/fe/category-title-icon.png" /> <span id="cat_head">Everything</span></h2><?php */?>
    <?php if($category_menu_available) { ?>
      <?php 
		if($book_category)
		{
			if($total_cat>10)
			{
				$arr_split  =   array_chunk($book_category,20);					
			}
			else
			{
				$arr_split  =   array_chunk($book_category,$total_cat);
			}
			
			if($arr_split[1]=='' && $arr_split[2]=='')
			{
				//$width = 'style="width:175px;"';
				$width = 'style="width:212px;"';
			}
			else if($arr_split[1]!='' && $arr_split[2]=='')
			{
				//$width = 'style="width:350px;"';
				$width = 'style="width:424px;"';
			}
			else if($arr_split[1]!='' && $arr_split[2]!='')
			{
				//$width = 'style="width:525px;"';
				$width = 'style="width:636px;"';
			}
			
		?> 	
        <?php
		// class="selected-cat"
		$sel_class = '';$sel_cat_class = ''; $sel_popular_class='';
		if($type=='category'){ $sel_cat_class = 'class="selected-cat"';}
		else if($type=='popular'){ $sel_popular_class = 'class="selected-cat"';}
		else { $sel_class = 'class="selected-cat"';}
		
		?>
      <div class="left-menu left-menu2">
        <ul>
          
              <li><a href="<?php echo base_url(); ?>" <?php echo $sel_class ?>>Everything</a></li>
              <li><a id="popular" href="javascript:void(0);" <?php echo $sel_popular_class ?>>Popular</a>
                    <div>
                          <ul id="popular_choice">
                                <?php /*?><li><a rel="view" href="javascript:void(0);">Most Viewed</a></li>
                                <li><a rel="sparkle" href="javascript:void(0);">Most Sparkled</a></li>
                                <li><a rel="comment" href="javascript:void(0);">Most Commented</a></li><?php */?>
                                <li><a rel="view" href="<?php echo base_url().'most-viewed' ?>">Most Viewed</a></li>
                                <li><a rel="sparkle" href="<?php echo base_url().'most-sparkled' ?>">Most Sparkled</a></li>
                                <li><a rel="comment" href="<?php echo base_url().'most-commented' ?>">Most Commented</a></li>
                          </ul>
                    </div>
              </li>
              
              
              <li><a href="javascript:void(0);" <?php echo $sel_cat_class ?>>Category</a>
                <div class="category-menu" <?php echo $width ?>>
                	                	
                
                      <ul>
                      		<?php
							if(!empty($arr_split[0]))
							{
							 foreach($arr_split[0] as $value){
							?>                            
                            <li class="sub"><a class="arr_cat" rel="<?php echo $value['id'];?>" href="<?php echo base_url().'category/'.my_show_text($value["s_category_link"]) ?>"><?php echo $value['s_category'] ?></a></li>
                            <?php } } ?>                            
                      </ul>
                      
                      <?php 
					  	if(!empty($arr_split[1]))
							{ 
						?>
                      <ul class="odd">
                      		<?php
							
							 foreach($arr_split[1] as $value){
							?>
                            <li class="sub"><a class="arr_cat" rel="<?php echo $value['id'];?>" href="<?php echo base_url().'category/'.my_show_text($value["s_category_link"]) ?>"><?php echo $value['s_category'] ?></a></li>
                            <?php  } ?>
                           
                      </ul>
                      <?php } ?>
                      
                      <?php if(!empty($arr_split[2]))
							{ ?>
                      <ul>
                      		 <?php							
							 foreach($arr_split[2] as $value){
							?>
                            <li class="sub"><a class="arr_cat" rel="<?php echo $value['id'];?>" href="<?php echo base_url().'category/'.my_show_text($value["s_category_link"]) ?>"><?php echo $value['s_category'] ?></a></li>
                            <?php  } ?>                            
                      </ul>
                      <?php } ?>
                      
                      
                      <?php } ?>
                </div>
          </li>
        </ul>
      </div>
      
      <?php } ?>
    
    
    <?php if($srch_category) { ?>
    <h2 style=" float:none !important;"><img src="images/fe/category-title-icon.png" /> <?php echo $srch_category ?></h2>
    <?php } else if($srch_type) { ?>
    <h2><img src="images/fe/category-title-icon.png" /> <?php echo $srch_type ?></h2>
    
    <?php } else if($srch_keyword) { ?>
    <h2><img src="images/fe/category-title-icon.png" /> <?php echo $srch_keyword ?></h2>
    
    <?php } else { ?>
    <h2><img src="images/fe/category-title-icon.png" /> Everything </h2>
    <?php } ?>
    
    
    <div id="book_list">
    	<?php echo $book_list; ?>
    </div>
    
   <!-- <span id="loading_container">
    <div class="loader">&nbsp;</div>
    </span>-->
</div>
<script type="text/javascript">
	////////////////////////////////////
	//enable_lazy_loading_in_ajax_pagination('book_list','loading_container');
</script>




