  <form action="<?=base_url()?>search" method="post" name="head_srch_form" id="head_srch_form">

    <?php /*?><div class="location">
		<div class="location_box">
			<select name="location" id="fev_select" onchange="get_city_deal()">
					<option value="">Select Location</option>
					<? foreach ($deal_location as $value):?>
						<option value="<?=$value['i_id']?>"><?=$value['s_name']?></option>
					<? endforeach; ?>
			</select>
		</div>
    </div><?php */?>

    <div class="search">
            <div class="search_field">
                <!--<input name="keyword" autocomplete="off" class="search_input" name="Type in a store or product, e.g. Yatra, tickets" type="text" placeholder="Search for stores e.g. Snapdeal,Yatra" />-->
				<?php
				/*if($this->session->userdata('srch_key')!='')
				{
					$srch_key = $this->session->userdata('srch_key');
				}*/
				?>
				<input name="keyword" class="search_input" id="search_input" name="search_input" type="text" placeholder="Search for Stores, Products or Brands" autocomplete="off" value="<?php echo $srch_key ?>"/>
            </div>
            <div class="search_field search_hints" >
                <ul class="sugg_list"></ul>
            </div>
            <div class="search_btn"><input src="<?=base_url()?>images/sarch_btn.jpg" name="" type="image" /></div>
    </div>

  </form>

<script type="text/javascript">

$(document).ready(function(){

    var requestOnProcessing = null;
    var requestToProcess = null;
   <?php /*?> $('.search_input').keyup(function(){
        requestToProcess = $.ajax({
                                url: "<?=  base_url()?>home/store_suggest/",
                                type: 'POST',

                                data: {'keyword':$(this).val()},
                                dataType:'json',
                                beforeSend: function(){
                                   // requestSuggets.abort()
                                   if(requestOnProcessing!= null)
                                       requestOnProcessing.abort();
                                }

                            }).done(function(responceData){
                                requestOnProcessing = null;
                                requestToProcess = null;
                                if(responceData.status=='success'){
                                    $('.sugg_list').html('');
                                    $(responceData.store_data).each(function(){
                                        //console.log(this.s_cash_back);
                                        $this_li = $('<li/>');
                                        $this_a = $('<a/>');    
                                        $this_img = $('<img/>');
                                        $this_img.attr('src','<?= base_url()?>uploaded/store/'+this.s_store_logo);
                                        $this_span = $('<span/>');										
										$this_span2 = $('<span/>');										
										if(this.txt_off!="")
										{
											var txt_off = this.txt_off;
											$this_span2.html(txt_off);
										}
										
										if((this.deal_count) <= 1)
											deal_text	= " deal";
										else
											deal_text	= " deals";
							
										if((this.deal_count) >= 1)
                                        	$this_span.html(this.deal_count+deal_text+" found");                                     

                                        $this_a.html($this_img);
                                        $this_a.append($this_span);		
										$this_a.append($this_span2);
                                        $this_a.attr('href','<?= base_url()?>'+this.s_url );
                                        $this_li.html($this_a);
                                        $('.sugg_list').append($this_li);                                       

                                    });

                                }

                            });

         requestOnProcessing = requestToProcess;                   

  });<?php */?>
  
  $('.search_input').keyup(function(){
  
  		var keywords = $(this).val();
		var lenth = keywords.length;
		
		if(lenth>2)
		{
			requestToProcess = $.ajax({
									url: "<?=  base_url()?>home/product_suggest/",
									type: 'POST',	
									data: {'keyword':$(this).val()},
									dataType:'json',
									beforeSend: function(){
									   // requestSuggets.abort()
									   if(requestOnProcessing!= null)
										   requestOnProcessing.abort();
									}
	
								}).done(function(responceData){
									requestOnProcessing = null;
									requestToProcess = null;
									if(responceData.status=='success'){
										$('.sugg_list').html('');
										$(responceData.product_data).each(function(){
											//console.log(this.s_cash_back);
											
											//console.log(this);
											$this_li = $('<li/>');
											$this_a = $('<a/>');    
											$this_span = $('<span/>');	
											//$this_span.html(this.s_title); 
											var sTitle = this.s_title;
											//console.log(keywords);
											var r =  new RegExp(keywords, 'ig');
											sTitle = sTitle.replace(r,'<font style="color:#F07317;">'+keywords+'</font>');
											/*sTitle = sTitle.replace(keywords,'<span style="color:red;">'+keywords+'</span>');		
											console.log(sTitle);*/
											
											$this_span.html(sTitle); 
																
											//$this_span2 = $('<span/>');	
											$this_span.css({float:'left'});
											$this_span.addClass('suggest_item');								
											
	
											$this_a.html($this_span);
											$this_a.append($this_span);		
											//$this_a.append($this_span2);
											if(this.store_url)
											{
												//$this_a.attr('href','<?= base_url()?>'+this.store_url );
											}
											//$this_a.attr('href','<?= base_url()?>'+this.s_url );
											$this_li.html($this_a);
											$('.sugg_list').append($this_li);                                       
  
	
										});
	
									}
									
									$('.suggest_item').click(function(){
										var prod = $(this).html();
										//console.log(prod);
										prod = prod.replace('<font style="color:#F07317;">','');
										prod = prod.replace('</font>','');
										$("#search_input").val(prod);
									});
	
								});
	
			 requestOnProcessing = requestToProcess;      
		 
		}             

  });
  
 
  
  

  $("body:not(.sugg_list)").click(function(){

    $('.sugg_list').html('');

  });
  
 
 }); // end document ready
  
 /* $(document).ready(function(){
  		//$("#fev_select option:first").attr('selected','selected');
		var oHandler = $('#fev_select').msDropDown().data("dd");
		if(oHandler) {
			oHandler.set("selectedIndex", 0);
		}
  })*/
  
  function get_city_deal()
  {
  		var	city = $('#fev_select option:selected').text();
		
		if(city=='Select Location')
			return false;
		else		
  			window.location.href	= '<?php echo base_url();?>'+city+'-deals';
  }
</script>