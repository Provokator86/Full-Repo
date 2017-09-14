<div class="filter_section">
<form onsubmit="return false;" id="filter_form">
	<input type="hidden" name="chk_post" value="1" />
        <div class="bannaer_cataroies">
			<div class="cat_sec">
					<div class="cat_heading">Filter by:</div>
					<!--Tab Start-->
					<div class="cat_box" index="0" >
									Catagories
							<span class="caret"></span>
					</div>
					<div class="cat_box" index="1">
									Stores
							<span class="caret mar_crrot"></span>
					</div>
					<div class="cat_box" index="2">
									Discount
							<span class="caret mar_crrot_3"></span>
					</div>                            
					<div class="cat_box" index="3">
									Date
							<span class="caret mar_crrot_2"></span>
					</div>
					<!--Tab End-->

					<div class="ban_chk_box">
					<?php
						if(!empty($_SESSION['posted_filter']['show_expired']))
						{
							$chk	= 'checked="checked"';
						}
						else
							$chk	= "";
					?>
						   <div> <span class="ban_chk">
						   <input name="show_expired" id="show_expired" type="checkbox" value="1" class="expired_checkbox" <?php echo $chk;?>  /></span>

							<span class="chk_info">Show Expired</span></div>
							<div class="clear"></div>
							
							<?php
								if(isset($_SESSION['posted_filter']['chk_post']) && ($_SESSION['posted_filter']['chk_post']==1))
								{
							?>
							<div id="crl_filter" style="display:block;">
							<span class="cross_smbl"><img src="<?php echo base_url();?>images/cross-symbol.png" /></span> <span class="chk_info"><a href="javascript:void(0)" onclick="clear_filter();">Clear Filter</a></span>
							 </div>
						   <?php
								}
								else
								{
							?>
								 <div id="crl_filter" style="display:none;">
							<span class="cross_smbl"><img src="<?php echo base_url();?>images/cross-symbol.png" /></span> <span class="chk_info"><a href="javascript:void(0)" onclick="clear_filter();">Clear Filter</a></span>
							 </div>
							<?php
								}
							?>
					   
					</div>

					<div class="clear"></div>

			</div>

            </div>
         
         <div class="filter_categories" index="0">

                    <span class="close_btn">&times;</span>

                    <div class="filter_heading1">

                            <div class="filter_headingleft bold_font">Select Categories</div>

                            <div class="filter_headingmid bold_font">Categories you selected</div>

                            <div class="filter_headingright"></div>

                    </div>

                    <div class="clear"></div>



                    <div class="filter_heading1">

                            <div class="filter_headingleft">

                                <div>Filter by Category</div>

                                <div class="clear"></div>

                                <div class="fil_bycat mar_20">

                                    <input class="filter_input_category filter_input" type="text" />

                                </div>

                                <div class="clear"></div>

                                <div class="fil_cat_box">

                                        <div class="form-item category_option_container">

                                            <div class="form-item_group">

                                                <div class="frm_item_ckh">
                                                <input name="" class="chk_all" type="checkbox" value="" checked="checked"  /></div>

                                                <div class="frm_item_name">All Categories</div>

                                                <div class="clear"></div>

                                            </div>

                                            <? 
												//print_r($categoryData);exit;
												
												$chk_cat	= "";
												foreach ($categoryData as $categoryMeta):
												if(!empty($_SESSION['posted_filter']['selected_categories']))	
												{
													if(in_array($categoryMeta['i_id'],$_SESSION['posted_filter']['selected_categories']))
														$chk_cat	= "checked";
													else
														$chk_cat	= "";
												}
													
											?>

                                                 <div class="form-item_group" id="filter_cat_<?=$categoryMeta['s_url']?>">

                                                    <div class="frm_item_ckh">

                                                        <input name="selected_categories[]" type="checkbox" value="<?=$categoryMeta['i_id']?>"  <?php echo $chk_cat;?> />
                                                    </div>

                                                    <div class="frm_item_name"><?=$categoryMeta['s_category']?></div>

                                                    <div class="clear"></div>

                                                </div>

                                            <? endforeach;?>                                       

                                        </div>
                                </div>

                                <div class="apply_fld">

                                        <div class="apply"><input class="apply_btn" name="Apply" type="button" value="Apply" /></div>

                                        <!--<div class="cancel"><input class="apply_btn" name="Cancel" type="button" value="Cancel" /></div>-->

                                </div>

                                <div class="clear"></div>

                            </div>

                            <div class="slave_column_two" id="category_checked_list" >

                                <ul>

                                    <li>All Categories</li>

                                </ul>

                            </div>

                            <div class="clear"></div>

                    </div>





                    <div class="clear"></div>

            </div>   

        <div class="filter_categories" index="1">

                    <span class="close_btn">&times;</span>

                    <div class="filter_heading1">

                            <div class="filter_headingleft bold_font">Select Store</div>

                            <div class="filter_headingmid bold_font">Store you selected</div>

                            <div class="filter_headingright"></div>

                    </div>

                    <div class="clear"></div>



                    <div class="filter_heading1">

                            <div class="filter_headingleft">

                                <div>Filter by Store</div>

                                <div class="clear"></div>

                                <div class="fil_bycat mar_20">

                                    <input class="filter_input_store filter_input" type="text" />

                                </div>

                                <div class="clear"></div>
                                
                                <div class="fil_cat_box ">

                                        <div class="form-item store_option_container">

                                            <div class="form-item_group">

                                                <div class="frm_item_ckh">
                                                <input name="" class="chk_all" type="checkbox" value="" checked="checked"  /></div>

                                                <div class="frm_item_name">All Stores</div>

                                                <div class="clear"></div>

                                            </div>

                                            <? 
												$chk_store = "";
												foreach ($store_list as $store_meta):
												if(!empty($_SESSION['posted_filter']['selected_stores']))	
												{
													if(in_array($store_meta['i_id'],$_SESSION['posted_filter']['selected_stores']))
														$chk_store	= "checked";
													else
														$chk_store	= "";
												}
											?>

                                                 <div class="form-item_group" id="filter_class_<?=$store_meta['s_url']?>">

                                                    <div class="frm_item_ckh">

                                                        <input name="selected_stores[]" type="checkbox" value="<?=$store_meta['i_id']?>" <?php echo $chk_store;?>  />

                                                    </div>

                                                    <div class="frm_item_name"><?=$store_meta['s_store_title']?></div>

                                                    <div class="clear"></div>

                                                </div>

                                            <? endforeach;?>                          

                                        </div>

                                </div>



                                <div class="apply_fld">

                                        <div class="apply"><input class="apply_btn" name="Apply" type="button" value="Apply" /></div>

                                        <!--<div class="cancel"><input class="apply_btn" name="Cancel" type="button" value="Cancel" /></div>-->

                                </div>

                                <div class="clear"></div>

                            </div>

                            <div class="slave_column_two" id="store_checked_list" >

                                <ul>

                                    <li>All Store</li>

                                </ul>

                            </div>

                            <div class="clear"></div>

                    </div>

                    <div class="clear"></div>

            </div>

        <div class="filter_categories" index="2">

                <span class="close_btn">&times;</span>

                <div class="layout-slider">                    

                    <!--<input id="price_slider" type="slider" name="price_range" value="0;30000"  />-->
                    
                    <!--<input id="price_slider" type="slider" name="discount_range" value="0;100"  />-->
                    <?php 
						if(!empty($_SESSION['posted_filter']['discount_range']))
						{	
							$range	= $_SESSION['posted_filter']['discount_range'];
							$range_val	= explode(',',$range);
							$min_val	= $range_val[0].'%';
							$max_val	= $range_val[1].'%';
							$min		= $range_val[0];
							$max		= $range_val[1];
						}
						else
						{
							$range	= '0,100';
							$min_val	= '0%';	
							$max_val	= '100%';
							$min		= 0;
							$max		= 100;
						}			
					?>
                    
                     <input type="text" id="discount-price-slider-value" style="border: 0; color: #f6931f; font-weight: bold; display: none"  />
                                <div id="discount-price-slider"></div>
                            
                            <p class="min">
                                <input type="text" id="discount-price-slider-amount-min" class="input-slider-amount" value="<?php echo $min_val;?>"/>
                            </p>
                            <p class="max">
                                <input type="text" id="discount-price-slider-amount-max" class="input-slider-amount" value="<?php echo $max_val;?>"/>
                            </p>
                            <input type="hidden" id="min-val" value="<?php echo $min;?>" />
                            <input type="hidden" id="max-val" value="<?php echo $max;?>" />
                    		<input type="hidden" name="discount_range" id="discount_range" value="<?php echo $range;?>" />

                    	<div class="apply_fld mar_top" style="margin-left: 200px">

                        <div class="apply"><input class="apply_btn " name="Apply" type="button" value="Filter Search" /></div>    

                    </div>

                </div>

                <div class="clear"></div>

            </div>
            
            <div class="filter_categories" index="3">

                    <span class="close_btn">&times;</span>

                    <div class="filter_heading1">

                            <div class="filter_headingleft bold_font">Enter Dates to see the deals</div>

                            <div class="filter_headingmid bold_font"></div>

                            <div class="filter_headingright"></div>

                    </div>

                    <div class="clear"></div>



                    <div class="filter_heading1">

                            <div class="filter_headingleft">

                                <div>Filter by Past Date</div>

                                <div class="clear"></div>

                                <div class="fil_bycat mar_20">
                                <?php
									if(!empty($_SESSION['posted_filter']['dt_date_of_entry']))									
										$val = $_SESSION['posted_filter']['dt_date_of_entry'];									
									else
										$val = "";
								?>

                                    <input class="filter_input_date filter_input" type="text" id="dt_date_of_entry" name="dt_date_of_entry"  value="<?php echo $val;?>" />

                                </div>

                                <div class="clear"></div>   

                                <div class="apply_fld">

                                        <div class="apply"><input class="apply_btn" name="Apply" type="button" value="Apply" /></div>

                                        <!--<div class="cancel"><input class="apply_btn" name="Cancel" type="button" value="Cancel" /></div>-->
                                </div>

                                <div class="clear"></div>
                            </div>

                            <div class="slave_column_two" id="category_checked_list" >
                            </div>
                           <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
            </div>
</form>

</div>

<script>

    function clear_filter()
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>home/clear_sess/",
			//data: { name: "John", location: "Boston" }
			})
			.success(function( msg ) {
				window.location.href='<?php echo base_url();?>';
		});
	}


	$(document).ready(function(){
	
		 /*if(($('.category_option_container input[type="checkbox"]:checked').length >0) || $('.store_option_container input[type="checkbox"]:checked').length >0)
		 {
		 	$(".chk_all").prop('checked','');
		 }*/
	
	
		$("input[name='dt_date_of_entry']").datepicker({dateFormat: 'yy-mm-dd',
                                               changeYear: true,
                                               changeMonth:true,
											   maxDate: '0'
                                              });
											  
		 $( '#discount-price-slider' ).slider({
                    range: true,
                    values: [0,100],
					//values: [$('#min-val').val(),$('#max-val').val()],
                    /*min: $('#min-val' ).val(),
                    max: $('#max-val' ).val(),*/
					min:0,
                    max: 100,
                    slide: function( event, ui ) {
                        $( '#discount-price-slider-amount-min' ).val( ui.values[0]+'%' );
                        $( '#discount-price-slider-amount-max' ).val( ui.values[1]+'%' );
                    },
                    change: function(event, ui){
                       	var values = $( "#discount-price-slider" ).slider( "option", "values" );
						// setter
						//$( ".selector" ).slider( "option", "values", [ 10, 25 ] );						
						$('#discount_range').val(values);					
                    }
                });				
				
	})

    $('.apply_btn,.expired_checkbox').click(function(){

        $.post('<?=  base_url()?>home/filter_list',$('#filter_form').serialize(),function(resData){

            $('#deal_list').html(resData);

        },'html');		
		
		if ((($('.category_option_container input[type="checkbox"]:not(.chk_all)').length==0) || ($('.store_option_container input[type="checkbox"]:not(.chk_all)').length==0))&& ($('.expired_checkbox').prop('checked')==false))
		{
						
			$('#crl_filter').hide();
		}
		else
		{
			
			$('#crl_filter').show();
		}
    });    

    $('.filter_input_store').keyup(function(){

        keyToFilter = $(this).val().toLowerCase();

        if($.trim(keyToFilter)=='')
        {
          $('[id^="filter_class_"]').css('display','block');  

          $('.store_option_container').parent().scrollTop(1);

        }else{

            $('[id^="filter_class_"]').css('display','none');

            $('[id^="filter_class_"]').parent().find($('[id*="'+keyToFilter+'"]')).css('display','block');
        }

     });

 $('.store_option_container input[type="checkbox"]:not(.chk_all)').change(function(){ 	
 
     $('.store_option_container .chk_all').removeAttr('checked');   

     $('#store_checked_list ul').html('');

     $('.store_option_container input[type="checkbox"]:not(.chk_all)').each(function(){

         if($(this).is(':checked')){

             $('#store_checked_list ul').append('<li store-id="'+$(this).val()+'">'+$(this).parent().parent().children('.frm_item_name').html()+'</li>');

             $('#store_checked_list ul li').bind('click',function(){

                 $(this).remove();

                 $('.store_option_container input[value="'+$(this).attr('store-id')+'"]').removeAttr('checked');

                 if($('.store_option_container input[type="checkbox"]:checked').length==0){

					$('#store_checked_list ul').html('');
                    $('#store_checked_list ul').append('<li>'+'All Store'+'</li>');
					$(".chk_all").prop('checked','checked');	
                 } 
				                
            });		
			
        }  	
		  
     });     

     if($('.store_option_container input[type="checkbox"]:checked').length==0){
         $('#store_checked_list ul').append('<li>'+'All Store'+'</li>');
     }     

 });
 
 $('.category_option_container input[type="checkbox"]:not(.chk_all)').change(function(){

     $('.category_option_container .chk_all').removeAttr('checked');   

     $('#category_checked_list ul').html('');

     $('.category_option_container input[type="checkbox"]:not(.chk_all)').each(function(){

         if($(this).is(':checked')){

             $('#category_checked_list ul').append('<li category-id="'+$(this).val()+'">'+$(this).parent().parent().children('.frm_item_name').html()+'</li>');

             $('#category_checked_list ul li').bind('click',function(){

                 $(this).remove();

                 $('.category_option_container input[value="'+$(this).attr('category-id')+'"]').removeAttr('checked');



                 if($('.category_option_container input[type="checkbox"]:checked').length==0){

					$('#category_checked_list ul').html('');
                    $('#category_checked_list ul').append('<li>'+'All Categories'+'</li>');
					$(".chk_all").prop('checked','checked');	
                 }               

            });
        }     

     });
     

     if($('.category_option_container input[type="checkbox"]:checked').length==0){

         $('#category_checked_list ul').append('<li>'+'All Categories'+'</li>');
     }    

 });
 
 $('.filter_input_category').keyup(function(){

        keyToFilter = $(this).val().toLowerCase();

        if($.trim(keyToFilter)=='')
        {

          $('[id^="filter_cat_"]').css('display','block');  

          $('.category_option_container').parent().scrollTop(1);

        }else{

            $('[id^="filter_cat_"]').css('display','none');

            $('[id^="filter_cat_"]').parent().find($('[id*="'+keyToFilter+'"]')).css('display','block');
        }

     });
 

</script>