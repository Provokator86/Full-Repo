$(document).ready(function(){
    
    var cat_url = '', search_by_cat='';
    var brand_checkboxes    = new Array();
    var store_checkboxes    = new Array();
    var price_checkboxes    = new Array();
    
    /******************* SEACRH STRATS HERE *******************/
    /******** brand checkbox select **********/
    brand_checkboxes = [];
    $("input[id^=brand_chk_]:checked").each(function(i){
       brand_checkboxes[i]   =   $(this).attr('id').split('_').pop();           
    });
    
    $(".chk_box_brand").click(function(){        
        brand_checkboxes = [];
        $("input[id^=brand_chk_]:checked").each(function(i){
           brand_checkboxes[i]   =   $(this).val();           
        });        
        ajax_sending();
    });
   
   /******** store checkbox select **********/
    store_checkboxes = [];
    $("input[id^=store_chk_]:checked").each(function(i){
       store_checkboxes[i]   =   $(this).attr('id').split('_').pop();           
    });
    
    $(".chk_box_store").click(function(){        
        store_checkboxes = [];
        $("input[id^=store_chk_]:checked").each(function(i){
           store_checkboxes[i]   =   $(this).val();           
        });        
        ajax_sending();
    });
    
    /******** price checkbox select **********/
    price_checkboxes = [];
    $("input[id^=price_chk_]:checked").each(function(i){
       price_checkboxes[i]   =   $(this).attr('id').split('_').pop();           
    });
    
    $(".chk_box_price").click(function(){        
        price_checkboxes = [];
        $("input[id^=price_chk_]:checked").each(function(i){
           price_checkboxes[i]   =   $(this).val();           
        });        
        ajax_sending();
    });
    
    /******** sub category select **********/
    $(".sub_cat").each(function(i){
       $(this).click(function(){
           $(".sub-catog").find('a').removeClass('active');
           var subCat = $(this).attr('id').split('_').pop();
           search_by_cat = parseInt(subCat);
           $(this).addClass('active');
           ajax_sending();
       }) ;
    });
    
    /******************* SEACRH END HERE *******************/
    
    
    /************* Start Function ajax sending *********/
   function ajax_sending()
   { 
        str_category      = search_by_cat;  
        //showBusyScreen();        
        /************** added on 14 Jan 2015 from below ******************/ 
        
        var category_src_id = $('#category_src').val();
        
        if( category_src_id!='' ) {
           
           if( search_by_cat )
              ajax_url = base_url+'category/'+ str_category +'/ajax_pagination_product_list/';
           else
              ajax_url = base_url+'category/'+ category_src_id +'/ajax_pagination_product_list/';
              
        } else
          ajax_url = base_url+'category/ajax_pagination_product_list/';
      
       
       $.ajax({
                type: "POST",
                async: false,
                url: ajax_url,
                /*data: "str_category="+str_category+"&arr_brand="+brand_checkboxes+"&arr_store="+store_checkboxes+"&str_price_from="+str_price_from+"&str_price_to="+str_price_to+"&type=where",*/
                data: "str_category="+str_category+"&arr_store="+store_checkboxes+"&str_brand="+brand_checkboxes+"&arr_price="+price_checkboxes+"&type=where",
                success: function(data){
                            //hideBusyScreen();                            
                            //$("#product_ajax").html(data);							
							//// NEW
							var wrapper_div_part = '<div id="product_ajax">'+ data +'</div>';
							$("div.product-listing").html(wrapper_div_part);
							//// NEW
                            
                            //// For HOVER [BEGIN]
                            $('.article-square').hover(function() {
                                    $(this).children('.cover').stop().animate({ width: '126px' }, fastAnimation, easingMethod);
                                    if ($(this).css('text-align') == 'left') {
                                        $(this).children('img').stop().animate({ left: '30px' }, fastAnimation, easingMethod);
                                    } else {
                                        $(this).children('img').stop().animate({ left: '-30px' }, fastAnimation, easingMethod);
                                    }
                                }, function() {
                                    $(this).children('.cover').stop().animate({ width: '110px' }, fastAnimation, easingMethod);
                                    if ($(this).css('text-align') == 'left') {
                                        $(this).children('img').stop().animate({ left: '0px' }, fastAnimation, easingMethod);
                                    } else {
                                        $(this).children('img').stop().animate({ left: '0' }, fastAnimation, easingMethod);
                                    }
                            });
                        //// For HOVER [END]
                            
                            infinite_scroll_init();
                        }
                
                });//End of ajax call
       
   };
   
   /************* End Function ajax sending *********/
   

}); // end document ready


