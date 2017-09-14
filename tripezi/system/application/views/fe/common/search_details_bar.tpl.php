<!--search bar-->
<script type="text/javascript" src="http://apis.google.com/js/plusone.js"></script>
<?php //pr($info) ;
$property_link = base_url().'property/details/'.encrypt($info["id"]);
?>
<div class="search-bg">
	  <div class="back"><a href="<?php echo base_url().'search' ?>">Back to search results</a></div>
	  <div class="icon-box02">
	 
		  <div style="float:left;">
		 	<a href="https://twitter.com/share" class="twitter-share-button" data-lang="en" data-count="none">Tweet</a>
		  </div>
	  
		  <div style="float:left;margin-left:5px; margin-right:5px;">
		  <a href="http://pinterest.com/pin/create/button/?url=<?php echo $property_link ?>&media=<?php base_url()?>&description=<?php echo $info["s_property_name"]; ?>" count-layout="none" style="background:none;"><img src="images/fe/pinit-icon.png" alt="pinit" /></a>
		  </div>
        
		  <div style="float:left;margin-right:5px;">
		  
		  	<!-- Place this tag where you want the +1 button to render. -->
			<div class="g-plusone" data-size="medium" data-annotation="none"></div>
			
			<!-- Place this tag after the last +1 button tag. -->
			<script type="text/javascript">
			  (function() {
				var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
				po.src = 'https://apis.google.com/js/plusone.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
			  })();
			</script>
		  
		  
		  
							 
		  </div>
	  
		  <div style="float:left;">
		  <a href="mailto:?subject=<?php echo $info["s_property_name"] ?>&body=type your message here"><img src="images/fe/mail-icon.png" alt="mail" /></a>
		  </div>
	  
		  <div style="float:left;margin-right:5px; margin-left:-3px !important; width:45px !important;">
		 <!--<a href="javascript:void(0);"><img src="images/fe/facebook-icon.png" alt="facebook" class="no-right-margin" /></a>--> 
		 <div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
			<div class="fb-like" data-href="<?php echo $property_link; ?>" data-send="false" data-layout="button_count" data-width="200" data-show-faces="false"></div>
		 
		  </div>
	  	
	  </div>  <!--END div icon-box02-->
	   <script type="text/javascript" src="http://assets.pinterest.com/js/pinit.js"></script>
	   <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	  <br class="spacer" />
</div>
<!--search bar-->

										