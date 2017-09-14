<script type="text/javascript">
   <!--
(function($){    
$(document).ready(function()
{
 $("#firstpane2 div.menu_head2").css({background:"url(images/fe/next.png) no-repeat right"}); 
  $("#firstpane2 div.menu_head2").click(function() { 
  $("#firstpane2 div.menu_head2").css({background:"url(images/fe/next.png) no-repeat right"})  
  if(($(this).next().css('display'))=='none') 
  {
   $(this).css({background:"url(images/fe/down.png) no-repeat right"});  
   }
  else 
  {
   $(this).css({background:"url(images/fe/next.png) no-repeat right"});  
   }
  
    $(this).next("div.menu_body2").slideToggle(300).siblings("div.menu_body2").slideUp("slow");  

 });
 
});
})(jQuery); 

 //-->
</script>
<div class="category_left_box">
	<h5>Jobs by Category</h5>
	
	<div id="firstpane2">
		<?php if($category_parent_arr) {
				foreach($category_parent_arr as $key=>$val)
					{
					
		 ?>
			<div class="menu_head2"><a href="javascript:void(0)"><?php echo $key ?></a></div>
			<?php if($val){
			?>
			<div class="menu_body2" style="display:none;">
			  <ul>
			  <?php 
				foreach($val as $k=>$v)
					{
			   ?>
				
				<li><a  href="javascript:void(0);"><?php echo $v["sub_category"] ?></a></li>
				<?php }  ?>
			  </ul>
			</div>
			<?php }  ?>
			<div class="spacer"></div>
		<?php } } ?>
	</div> <!-- end div firstpane2 -->
	
</div>