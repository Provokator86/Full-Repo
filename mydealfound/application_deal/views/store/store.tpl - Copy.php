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
					
					<div id="store_list">
							<?php echo $result?>                   
                    </div>
				</div>
				<div class="clear"></div>
			</div>			
			   <div class="clear"></div>
				
			   <div class="clear"></div>
			</div>

            

            

            





