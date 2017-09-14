<div class="page-content">
    <h2><img src="images/fe/folower.png" alt="" /> Follower's Feed</h2>
    
    <div id="feeds_list">
    	<?php echo $feeds_list ?>
    </div>
    <!--<div class="loader">&nbsp;</div>-->
     <span id="loading_container_feeds">
    	<div class="loader">&nbsp;</div>
    </span>
    
</div>
<script type="text/javascript">
	enable_lazy_loading_in_ajax_pagination('feeds_list','loading_container_feeds');
</script>

<script type="text/javascript">
function merge_further_duplicate_entries()
{
	var comment_containers = new Array();
	$('.comment_container').each(function(){
		comment_containers.push($(this)[0]);
	});
	
	for(var i=0;i<comment_containers.length;i++)
	{
		var comment_container = comment_containers[i];
		if(typeof $(comment_container).attr('processed') != "undefined")
			continue;

		var arr_comments = new Array();
		arr_comments.push({
			by_name:$(comment_container).find('.by_name').html(),
			comment_content:$(comment_container).find('.comment_content').html(),
			all_name:$(comment_container).find('.by_name').children('a').html()
		});
		$(comment_container).attr('arr_comments',jQuery.stringify(arr_comments));

		var article_id = $(comment_container).attr('rel').split('article_')[1];
		
		var merge_to_comment_container = $('.comment_container[rel="article_'+article_id+'"][processed="processed"]:first');
		
		if(merge_to_comment_container.length==0){}
		else
		{
			merge_to_comment_container = merge_to_comment_container[0];
			var arr_merged_comments =
			decode_json($(merge_to_comment_container).attr('arr_comments')).
			concat(decode_json($(comment_container).attr('arr_comments')));
			
			$(merge_to_comment_container).attr('arr_comments',jQuery.stringify(arr_merged_comments));
			
			var by_names = '';
			var comment_content = '';
			var sep = '';
			var comnt_sep = '';
			for(var j=0;j<arr_merged_comments.length;j++)
			{
				
				if(by_names.indexOf(arr_merged_comments[j].all_name)==-1){
					
				if(j==arr_merged_comments.length-1)
					sep = ' and ';
				
				by_names += sep+arr_merged_comments[j].by_name;
				sep = ', ';
				}
				comment_content += comnt_sep+arr_merged_comments[j].comment_content;
				comnt_sep = '<br /> ';
			}
			$(merge_to_comment_container).find('.by_name').html(by_names);
			$(merge_to_comment_container).find('.comment_content').html(comment_content);
			
			$(comment_container).html('');
			$(comment_container).css({border:'none'});
		}
		
		$(comment_container).attr('processed','processed')
	}
	
	
	/*************** SPARKLE PART START **************/
	var sparkle_containers = new Array();
	$('.sparkle_container').each(function(){
		sparkle_containers.push($(this)[0]);
	});
	
	for(var k=0;k<sparkle_containers.length;k++)
	{
		var sparkle_container = sparkle_containers[k];
		if(typeof $(sparkle_container).attr('processed') != "undefined")
			continue;

		var arr_sparkle = new Array();
		arr_sparkle.push({
			by_name:$(sparkle_container).find('.by_name').html()
		});
		$(sparkle_container).attr('arr_sparkle',jQuery.stringify(arr_sparkle));

		var article_id = $(sparkle_container).attr('rel').split('article_')[1];
		
		var merge_to_sparkle_container = $('.sparkle_container[rel="article_'+article_id+'"][processed="processed"]:first');
		
		if(merge_to_sparkle_container.length==0){}
		else
		{
			merge_to_sparkle_container = merge_to_sparkle_container[0];
			var arr_merged_sparkle =
			decode_json($(merge_to_sparkle_container).attr('arr_sparkle')).
			concat(decode_json($(sparkle_container).attr('arr_sparkle')));
			
			$(merge_to_sparkle_container).attr('arr_sparkle',jQuery.stringify(arr_merged_sparkle));
			
			var by_names = '';
			var sep = '';
			for(var jj=0;jj<arr_merged_comments.length;jj++)
			{
				if(jj==arr_merged_sparkle.length-1)
					sep = ' and ';
				
				by_names += sep+arr_merged_sparkle[jj].by_name;
				sep = ', ';
				
				
			}
			$(merge_to_sparkle_container).find('.by_name').html(by_names);
			
			
			$(sparkle_container).html('');
			$(sparkle_container).css({border:'none'});
		}
		
		$(sparkle_container).attr('processed','processed')
	}
	
	/*************** SPARKLE PART END **************/
	
}
</script>