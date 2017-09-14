<script type="text/javascript">
$(document).ready(function() {
    $('.col_book').click(function(evnt){
		evnt.preventDefault();
		<?php if(empty($loggedin)) { ?>
			requested_url = $(this).attr('href');
			$('#login').click();
		<?php } else { ?>
		var loc = $(this).attr('href');
		window.location.href = loc;
		<?php }?>
			
	});
	$('.user_prof').click(function(evnt){
		evnt.preventDefault();
		<?php if(empty($loggedin)) { ?>
			requested_url = $(this).attr('href');
			$('#login').click();
		<?php } else { ?>
		var loc = $(this).attr('href');
		window.location.href = loc;
		<?php }?>
			
	});
});

</script>
<?php if($book_list) { 
	$i = 1;	
	/*if($type=='')
	{
		shuffle($book_list);
	}*/
	foreach($book_list as $key=>$value)
	{
			//$value=$book_list[rand(0,count($book_list))];
			
			$total_pages = $value['i_pages'];
			
			$most_likes_page_no = $value['i_most_likes']['i_most_liked_page_no'];
			$most_comment_page_no = $value['i_most_comments']['i_most_comment_page_no'];
			
			$open_page_no = rand(3,($total_pages-1));
			
			if($i_sparkled)
			{
				$open_page_no = $most_likes_page_no?$most_likes_page_no:$open_page_no;
			}
			if($i_commented)
			{
				$open_page_no = $most_comment_page_no?$most_comment_page_no:$open_page_no;
			}
			
			$ex_class = ($i%2==0)?'even_book_list':"odd_book_list";
			
?>
<style type="text/css">
.even_book_list{ margin-left:48px;}
.odd_book_list{ margin-left:10px;}
.book-list h4,h5{ text-align:center;}
</style>
<div class="book-list book-list2 <?php echo $ex_class ?>" style="width:450px; height:435px; margin-bottom:10px; ">
      
      <h4><a class="col_book" id="book_id_<?php echo $value['id'] ?>" href="<?php echo base_url().'collection/'.$value['i_user_id'].'/'.$value['id'].'/'.$open_page_no ?>"><?php echo string_chopped(my_show_text($value['s_name']),25); ?></a></h4>
      <h5>By <span><a class="user_prof" href="<?php echo base_url().'profile/'.$value['i_user_id'];?>"><?php echo my_show_text($value['s_username']); ?></a></span></h5>
      <!--<div class="book-thumb"> </div>-->
      
      <div id="book_container_<?php echo $value['id'] ?>" style="width:350px; height:360px; border:0px blue solid;">
                    	
      </div>
                    
      <h5 class="h5-fnt-sml">Category <span><?php echo my_show_text($value['s_category']); ?></span></h5>
      <h5 class="h5-fnt-sml">
      Comments <span><?php echo my_show_text($value['i_comments']); ?></span>
      , Sparkled <span><?php echo my_show_text($value['i_likes']); ?></span>
      , Views <span><?php echo my_show_text($value['i_most_view']); ?></span>
      </h5>
</div>

<script type="text/javascript">

	function show_book_<?php echo $value['id'] ?>()
	{
					
					var start_page = <?php echo $open_page_no; ?>;
					/*var start_page = 3;*/
					var book = new Book({dragable:false,editable:false,showPageNo:true,startPage:parseInt(start_page),zoom:64});
					
					book.page_displayed = function(book_leftPage,book_rightPage)
					{
						var leftPageNo = (book_leftPage!=null)?book_leftPage.pageNo:'';
						var rightPageNo = (book_rightPage!=null)?book_rightPage.pageNo:'';	
						var last_open_page_no = (rightPageNo!='')?rightPageNo:leftPageNo;
						
						if(last_open_page_no!='')
						{
							$('#book_id_<?php echo $value['id'] ?>').attr('href',base_url+'collection/'+<?php echo $value['i_user_id'] ?>+'/'+<?php echo $value['id'] ?>+'/'+last_open_page_no);
						}
						
					}
					
					$('#book_container_<?php echo $value['id'] ?>').append(book);
					
						<?php if($value['pages']) {
						foreach($value['pages'] as $k=>$val)	 
						{
						 ?>
						 
							 var pageNo = <?php echo $k+1;?>;
							 var page  = book.addPage("<?php echo my_receive_text($val['s_json']); ?>","<?php echo my_receive_text($val['s_path']); ?>",pageNo);
						
						 
						 <?php }
						 } ?>
	
	
	}

	$(document).ready(function(){
	
		var container = $('#book_container_<?php echo $value['id'] ?>');
		var dom = $(window);
		var tmp_function;
		//dom.scroll(tmp_function = function(){
		is_element_scrollingTop(dom,tmp_function = function(){
		
		
				if(typeof curl_done_flag == "undefined" || !curl_done_flag)
				{
					setTimeout(function(){
					
						tmp_function();
					
					},100);
					return;
				}
		
				var top = getTopPos(container[0]);
				var viewport_height = $(window).height();
				var scroll_pos = dom.scrollTop();
				
				/*
				var offset_to_check = top + container.height()/3;
				
				if(offset_to_check<viewport_height+scroll_pos)
				
				
				{
				*/
				var offset_to_check = top*1 + container.height()*0.3;
				var offset_to_check_end = top*1 + container.height()*0.6;
				
				//alert(scroll_pos +'<' + offset_to_check +'&&'+ offset_to_check_end +'<'+ (viewport_height+scroll_pos));
				
				if(scroll_pos < offset_to_check && offset_to_check_end < viewport_height+scroll_pos)
				{
					if(typeof container[0].book_loaded == "undefined")
					{
						container[0].timer=
						setTimeout(function(){
							container[0].book_loaded = true;
							show_book_<?php echo $value['id'] ?>();
						},200);
						
					}
				}
				else
				{
					try{
						clearTimeout(container[0].timer);
					}catch(e){}	
				}
		});
		tmp_function();
	
		
	
	
	});
	
</script>
<?php $i++; }
	  
	} else {
 ?>
 

 <div class="book-list" style="min-height:300px;">
 	<h5>No book found.</h5>
 </div>
 
 <?php } ?>
<div class="clear"></div>
<div class="pagination">
	<?php echo $page_links ?>     
</div>