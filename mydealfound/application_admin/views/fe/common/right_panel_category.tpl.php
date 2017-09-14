					<div class="select_cat2">
                    
                        <h2>Select a<span> Category</span></h2>
                        <ul>
                        <?php 
							if(!empty($category))
							{
								foreach($category as $key=>$val)
									{
						?>
                                <li><a href="<?php echo base_url().'category/detail/'.$val['s_url']?>"><div class="item"><img src="<?php echo $category_image_path.$val['s_image']?>"><br><span><?php echo $val['s_category'];?></span></div></a></li>
    						<?php
									}
								}
							?>
    
                        </ul>
                    </div>