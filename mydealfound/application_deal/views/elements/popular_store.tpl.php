<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
 <div id="container">
    <div class="ppulr_str_heading">Popular Stores</div>
                <div class="ppulr_str"> 
                     
                           <? foreach ($popular_store as $storeMeta):?>
                              <?php /*?><span class="padding">
                                  <a href="<?=  base_url().$storeMeta['s_url']?>">
                                      <img alt="<?=$storeMeta['s_store_title']?>"  src="<?=base_url()?>uploaded/store/main_thumb/thumb_<?=$storeMeta['s_store_logo']?>" />
                                  </a>
                              </span><?php */?>
							  <a href="<?=  base_url().$storeMeta['s_url']?>">
							  <div class="holder holder2 smooth">
								   
                                      <img alt="<?=$storeMeta['s_store_title']?>"  src="<?=base_url()?>uploaded/store/main_thumb/thumb_<?=$storeMeta['s_store_logo']?>" />
                                 
									
							</div>
							 </a>
							
                           <? endforeach;?>
                              <div class="clear"></div>

            
               </div> 

</div> 