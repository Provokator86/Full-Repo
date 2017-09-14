<?php
 /*********
* Author:Koushik Rout
* Date  : 25 April 2012
* Modified By: Jagannath Samanta 
* Modified Date: 28 June 2011
* 
* Purpose:
*  View For help front end
* 
* @subpackage help
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/fe/home/help/
*/ 
?>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="job_categories">
            <div class="top_part"></div>
            <div class="midd_part height02">
                  <div class="spacer"></div>
                  <h2><?php echo $article['s_title'] ?> </h2>
                  <div class="content_box">
				  	<?php echo $article['s_description'] ?>                 
                  </div>
				  
				  <!-- facebook share -->
				  <script>
				  function fbs_click() {
							u='<?php echo base_url() ?>article-details/<?php echo encrypt($article['id']); ?>';
							t='Camera';window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;}</script>
							<a href="http://www.facebook.com/share.php?u=%3Curl%3E" onclick="return fbs_click()" target="_blank"><img src="<?php echo base_url() ?>images/fe/btn-f-share.gif" alt="Share on Facebook"></a>
							
					 <!-- facebook share -->
					 <!-- For Twietter share button-->
		<a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
					<!-- End -->		
                  
            </div>
			
	<div class="spacer"></div>
	<div class="bottom_part"></div>
</div>
