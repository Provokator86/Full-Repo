<script type="text/javascript">
	$(document).ready(function(){
		setTimeout(function(){
			merge_further_duplicate_entries();
			
		},1000);
		
	});
</script>

<?php if($feeds) {
	
foreach($feeds as $key=>$val)	
	{
	
		$owner_image = $val['owner_details']['s_image']?'uploaded/user_profile/small_thumb/'.$val['owner_details']['s_image']:"images/man.png";
		$owner_id =  $val['i_activity_owner_id'];
		$owner_username = $val['owner_details']['s_username'];
		
		if($val['book_details'])
		{
			$book_title = $val['book_details']['s_name'];
			$book_cat = $val['book_details']['s_category'];
			$book_cat_link = $val['book_details']['s_category_link'];
			$book_author = $val['book_details']['author_name'];
			$author_id = $val['book_details']['i_book_author'];
			$tot_book_comments = $val['book_details']['total_comments'];
			$tot_book_sparkles = $val['book_details']['total_sparkles'];
		}
	
		$open_page_no = $val['focus_page_no']?$val['focus_page_no']:3;
		
		
 ?>
 
 <?php if($val['e_type']!='started_following') { 
 
 $book_container_no = $val['id'];//rand(time(),time()+3600).'_'.$val['misc2'];
 ?>
 
 
<div class="followers-list <?php echo $val['e_type'];?>_container" rel="article_<?php echo $val['misc1'];?>">
      <div class="user-img">
          <a href="<?php echo base_url().'profile/'.$owner_id ?>">
          <img src="<?php echo $owner_image ?>" height="60" width="60" alt="" /></a>
      </div>
      
      <div class="user-details">
            <h4>
            	<span class="by_name">
                <a href="<?php echo base_url().'profile/'.$owner_id ?>">
                <strong><?php echo $owner_username ?></strong>
                </a> 
                </span>
                <?php if($val['e_type']=='sparkle') { ?>
                sparked on <a href="<?php echo base_url().'collection/'.$author_id.'/'.$val['misc2'].'/'.$open_page_no;?>"><?php echo $val['article_heading'] ?></a>
                <?php } else if($val['e_type']=='comment') { ?>
                commented on <a href="<?php echo base_url().'collection/'.$author_id.'/'.$val['misc2'].'/'.$open_page_no;?>"><?php echo $val['article_heading'] ?></a>
                <?php } else if($val['e_type']=='article_create') { ?>
                created a book <a href="<?php echo base_url().'collection/'.$author_id.'/'.$val['misc2'];?>"><?php echo $book_title ?></a>
                <?php } ?>
           </h4>
           
           	<?php if($val['owner_comments'] && $val['e_type']=='comment') { ?>
            <div class="user-des comment_content">            
            <span class="grey-heading"> Comment by <?php echo $owner_username ?>:</span>
            	<?php if(strlen($val['owner_comments'])<=50) { ?>
                  <span ><?php echo $val['owner_comments']; ?></span>
                <?php } else if(strlen($val['owner_comments'])>50){ ?>
                <span ><?php echo string_chopped($val['owner_comments']); ?> 
                <a style="color:#FE4E00;" href="<?php echo base_url().'collection/'.$author_id.'/'.$val['misc2'].'/'.$open_page_no;?>"> Read more</a>
                </span>
                <?php } ?>
                  
            </div>
            <?php }  ?>
            
            <div class="clear"></div>
            <!--<div class="book-img"></div>-->
            <div style="height:244px; width:332px; float:left;" id="book_container_<?php echo $book_container_no ?>">
            
            </div>
            
                        
            <script type="text/javascript">
				function show_book_<?php echo $book_container_no ?>()
				{
					var start_page = <?php echo $open_page_no ?>;					
                    var book=new Book({dragable:false,editable:false,showPageNo:true,startPage:parseInt(start_page),zoom:44});
                    book.page_displayed = function(book_leftPage,book_rightPage)
					{
						var leftPageNo = (book_leftPage!=null)?book_leftPage.pageNo:'';
						var rightPageNo = (book_rightPage!=null)?book_rightPage.pageNo:'';	
						var last_open_page_no = (rightPageNo!='')?rightPageNo:leftPageNo;
						
						if(last_open_page_no!='')
						{
							$('#book_no_<?php echo $val['id'] ?>').attr('href',base_url+'collection/'+<?php echo $author_id ?>+'/'+<?php echo $val['misc2'] ?>+'/'+last_open_page_no);
						}
						
					}
					
					$('#book_container_<?php echo $book_container_no ?>').append(book);
                    
                        <?php if($val['book_pages']) {
                        foreach($val['book_pages'] as $k=>$v)	 
                        {
                         ?>
                         
                             var pageNo = <?php echo $k+1;?>;
                             var page  = book.addPage("<?php echo my_receive_text($v['s_json']); ?>","<?php echo my_receive_text($v['s_path']); ?>",pageNo);
                        
                         
                         <?php }
                         } ?>
				}
			
                <?php /*?>$(document).ready(function(){
                    show_book_<?php echo $book_container_no ?>();
                });<?php */?>
				
				
				$(document).ready(function(){
				
					var container = $('#book_container_<?php echo $book_container_no ?>');
					var dom = $(window);
					var tmp_function;
					
						//dom.scroll(tmp_function = function(){
  						is_element_scrollingTop(dom,tmp_function = function(){
						
							if(container.length==0) return;
						
							var top = getTopPos(container[0]);
							var viewport_height = $(window).height();
							var scroll_pos = dom.scrollTop();
							
							var offset_to_check = top + container.height()/3;
							
							if(offset_to_check<viewport_height+scroll_pos)
							{
								if(typeof container[0].book_loaded == "undefined")
								{
									container[0].book_loaded = true;
									setTimeout(function(){
										show_book_<?php echo $book_container_no ?>();
									},200);
									
								}
							}
					});
					tmp_function();
				
					
				
				
				});
				
				
				
				
            </script>
                        
            
            
            
            <div class="book-details">
                  <h3><a id="book_no_<?php echo $val['id'] ?>" href="<?php echo base_url().'collection/'.$author_id.'/'.$val['misc2'].'/'.$open_page_no ?>"><?php echo string_chopped($book_title,20) ?></a></h3>
                  <h5>Category <a href="<?php echo base_url().'category/'.$book_cat_link ?>"><?php echo $book_cat ?></a></h5>
                  <h5>By <a href="<?php echo base_url().'profile/'.$author_id ?>">
				  	<?php echo $book_author ?></a>
                   </h5>
                  <h6>
                  <a style="text-decoration:none;"><strong><?php echo $tot_book_comments ?></strong> Comments</a>, 
                  <a style="text-decoration:none;"><strong><?php echo $tot_book_sparkles ?></strong> Sparkles</a>, 
                  <?php echo time_ago($val['dt_activity_date']) ?>
                  </h6>
            </div>
      </div>
      <div class="clear"></div>
</div>
<?php }else { 

if($val['following_details'])
{
	$f_username = $val['following_details']['s_username'];
	
	$f_user_id = $val['following_details']['f_user_id'];
}

?>

<div class="followers-list <?php echo $val['e_type'];?>_container">
  <div class="user-img">
  <a href="<?php echo base_url().'profile/'.$owner_id ?>">
  <img src="<?php echo $owner_image ?>" alt="" width="60" height="60" /></a>
  </div>
  <div class="user-details">
        <h4>
            <a href="<?php echo base_url().'profile/'.$owner_id ?>">
            <strong><?php echo $owner_username ?></strong></a> is now following 
            <a href="<?php echo base_url().'profile/'.$f_user_id ?>"><?php echo $f_username ?></a>
        </h4>
         <?php echo time_ago($val['dt_activity_date']) ?>
  </div>
  <div class="clear"></div>
</div>


<?php } ?>

<?php } 
} 

?>

<div class="pagination">
	<?php echo $page_links; ?>
</div>