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
		
		jQuery('#mycarousel').jcarousel();
		
		$(".mar_9").click(function(){
			var red_url = $(this).attr('rel');
			//alert(red_url);
			window.location.href=red_url;
		});

	})

</script>
<script type="text/javascript">
	
	$(document).ready(function () {
 

  if ($('html').hasClass('csstransforms3d')) {
  
  
   $('.thumb').removeClass('scroll').addClass('flip');  
   $('.thumb.flip').mouseenter(
    function () {
     $(this).find('.thumb-wrapper').addClass('flipIt');
    }
   );
   
   $('.thumb.flip').mouseleave(function(){
     $(this).find('.thumb-wrapper').removeClass('flipIt');   
   });
   
  } else {

   $('.thumb').mouseenter(
    function () {
     $(this).find('.thumb-detail').stop().animate({bottom:0}, 500, 'easeOutCubic');
    }
   );
   
   $('.thumb').mouseleave(function(){
    $(this).find('.thumb-detail').stop().animate({bottom: ($(this).height() * -1) }, 500, 'easeOutCubic');
   });

  }
 
 });
</script>
<script type="text/javascript">
$(document).ready(function() {

	
	$('.flipslide').bxSlider({
    slideWidth: 121,
    minSlides: 6,
    maxSlides: 10,
    slideMargin: 12,
	//auto:true,
	pager:false
  });
  
  $(".storecashback").each(function(){
  		$(this).click(function(){
			var redUrl = $(this).attr('rel');
			window.location.href = redUrl;
		});
  })
	
});
</script>
 <div class="clear"></div>
<div class="content">
			
				<div class="store_listing">
				<div class="prodct_heading">All Stores</div>
				<div class="store_listing_box">
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
                            <a href="javascript:void(0)" onclick="window.location.href='<?php echo base_url();?>store'">Show all</a>
							<div class="clear"></div>
                    	</div>
					<div class="clear"></div>
                    
				<?php if(!empty($popular_store)) { ?>
                   <div class="bandfld">
                    <ul class="flipslide">
						<?php
						foreach($popular_store as $store_key=>$store_val)
						{
						?>
						<li rel="<?php echo base_url().$store_val['s_url']?>" class="storecashback">
							<div class="store_cash_back">
								<span><?php echo $store_val['s_cash_back'];?></span>
							</div>
							<div class="store_cash_back_logo">
								<span>
									<img src="<?php echo base_url()?>uploaded/store/<?php echo $store_val['s_store_logo']?>" />
								</span>
							</div>
						</li>
						
						<?php
						}
						?>
						
						<!--<li><div class="store_cash_back"><span>Upto 6.4% Cashback</span></div><div class="store_cash_back_logo"><span><img src="http://mydealfound.com/uploaded/store/naaptol_1388244674.jpg" /></span></div></li>
						-->
					</ul>
					<div class="clear"></div>
                 </div>
				<?php } ?>
					
						<!-- STORE SLIDER START -->
						<?php /*?><?php if(!empty($popular_store)) { ?>
						<div class="thumbslider">
						<div class="slider_store">
							<?php foreach($popular_store as $key=>$val) {
									if($val["s_store_logo"]!='')
										{
							 ?>
							<div class="slide">
								<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%" align="center">
								<tr>
								<td align="center" valign="middle" height="100%"><img src="<?php echo base_url().'uploaded/store/'.$val['s_store_logo'] ?>"></td>
								</tr>
								</table>				
							</div>
							
							<?php 		} 
									} 
							
							?>
						</div>
						
						</div>
						</div>
						<?php } ?><?php */?>
						<!-- STORE SLIDER END -->
					
                    
					
					<div id="store_list">
                      		<?php echo $result?>                   
                    </div>
				</div>
				<div class="clear"></div>
			</div>			
			   <div class="clear"></div>
				
			   <div class="clear"></div>
			</div>
