<script>
$(document).ready(function(){
		 $("#alpha a").click(function(){
				var data = $(this).attr('rel');
				//alert(data);
				//console.log(data);
				$.ajax({
							data: 'data='+data,
							type:'post',
							url: '<?php echo base_url()?>store/ajax_store_list/',
							success: function(data){
													//alert(data);
													if( data)
													{
														$("#store_list").html(data);	
													}
													
								
								}	
				});

		});
	})
</script>

<div id="body_container">
            <div class="separator"></div>
        	<div class="f_body">
            	<div class="clear">&nbsp;</div>
                <div class="left_part">
                    <div class="all_stores">
                        <h2><a class="all_store_h" href="<?php echo base_url()."store"?>">All<span>stores</span></a></h2> 
                        <div class="select_by_alp" id="alpha">
                    		<a href="javascript:void(0)" rel="a">A</a>
                            <a href="javascript:void(0)" rel="b">B</a>
                            <a href="javascript:void(0)" rel="c">C</a>
                            <a href="javascript:void(0)" rel="d">D</a>
                            <a href="javascript:void(0)" rel="e">E</a>
                            <a href="javascript:void(0)" rel="f">F</a>
                            <a href="javascript:void(0)" rel="g">G</a>
                            <a href="javascript:void(0)" rel="h">H</a>
                            <a href="javascript:void(0)" rel="i">I</a>
                            <a href="javascript:void(0)" rel="j">J</a>
                            <a href="javascript:void(0)" rel="k">K</a>
                            <a href="javascript:void(0)" rel="l">L</a>
                            <a href="javascript:void(0)" rel="m">M</a>
                            <a href="javascript:void(0)" rel="n">N</a>
                            <a href="javascript:void(0)" rel="o">O</a>
                            <a href="javascript:void(0)" rel="p">P</a>
                            <a href="javascript:void(0)" rel="q">Q</a>
                            <a href="javascript:void(0)" rel="r">R</a>
                            <a href="javascript:void(0)" rel="s">S</a>
                            <a href="javascript:void(0)" rel="t">T</a>
                            <a href="javascript:void(0)" rel="u">U</a>
                            <a href="javascript:void(0)" rel="v">V</a>
                            <a href="javascript:void(0)" rel="w">W</a>
                            <a href="javascript:void(0)" rel="x">X</a>
                            <a href="javascript:void(0)" rel="y">Y</a>
                            <a href="javascript:void(0)" rel="z">Z</a>
                            <a href="javascript:void(0)" rel="1">0-9</a>
                    	</div>
                        <div class="clear"></div>
                        <div id="store_list">
                      	<?php echo $result?>
                        
                        </div>
                        
                      <div class="clear"></div>
                     
                       
                    </div>
                    
                </div>
                <div class="right_part">
                	<div class="clear"></div>
                     <!--JOIN US-->
                	 <?php include_once(APPPATH."views/fe/common/right_panel_join_us.tpl.php"); ?>
                	 <!--JOIN US-->
                    
                     <!--Category-->
                     <?php include_once(APPPATH."views/fe/common/right_panel_category.tpl.php"); ?>
                     <!--Category-->
                     
                     
                    <div class="clear"></div>
                   <!-- <div class="ad left_mar">
                        <img src="<?php //echo base_url()?>images/fe/ad3.png" alt="advertisement"/>
                    </div>
                    <div class="clear"></div>
                     <div class="ad left_mar">
                        <img src="<?php //echo base_url()?>images/fe/ad3.png" alt="advertisement"/>
                    </div>-->
                    <?php if($google_adds){?>
                       <div class="google_ad">
                        	<?php echo $google_adds[0]['s_description'];?>
                        </div>
                        <?php }?>
                    
                    <?php if($banner){ foreach($banner as $val) {?>
                    	<div class="ad ">
                        	<a href="<?php echo make_valid_url($val['s_url']);?>" target="_blank"><img src="<?php echo base_url().'uploaded/banner/thumb/thumb_'.$val['s_image']; ?>" alt="advertisement"/></a>
                        
                        </div>
                         <div class="clear"></div>
                        <?php } ?><?php }?>  
                   
                </div>
              <div class="clear">&nbsp;</div>  
            </div>
            </div>
            
            
            


