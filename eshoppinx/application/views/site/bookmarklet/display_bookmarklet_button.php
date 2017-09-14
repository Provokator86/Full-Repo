<?php
$this->load->view('site/templates/header');
?>
<style>

.bookmarkCon {
	background: #f0f3f6;
	border-top: 1px solid #e2e8ed;
	line-height: 67px;
	display: inline-block;
	min-width: 602px;
	padding: 0 14px;
	font-size: 16px;
	color: #373d48;
	margin-bottom: 28px;
}
.intro {
	border-bottom: 1px solid #ebecef;
	padding-bottom: 40px;
}
.intro h3 {
	font-size: 30px;
	color: #22324e;
	padding-bottom: 12px;
	text-align: left;
	margin-bottom: 0;
}
.intro p {
	color: rgb(113, 118, 126);
	font-size: 18px;
	line-height: 26px;
}
.bookmarkTop {
	padding-bottom: 40px;
	border-bottom: 1px solid #ebecef;
}
.bookmarkTop h4 {
	font-size: 20px;
	color: #22324e;
	padding: 40px 0 27px;
	margin:0;
}
.bookmarkCon a{
	display: inline-block;
	background: #558cc9;
	border-radius: 5px;
	box-shadow: 0 3px 0 #3b5c8b;
	border: 0;
	padding: 0 20px;
	line-height: 40px;
	color: #fff;
	font-size: 18px;
	font-weight: bold;
	text-shadow: 0 -1px 0 #3b5c8b;
	margin: -7px 18px 0 0;
	cursor: move;
	vertical-align: middle;
	text-decoration:none;
}
.bookmarkTop p {
	line-height: 20px;
	padding-bottom: 10px;
}
.bookmarkTop ol {
	padding: 30px 0 10px;
}
.bookmarkTop li {
	position: relative;
	line-height: 20px;
	padding: 0 0 25px 33px;
}
.no {
	display: inline-block;
	width: 20px;
	height: 20px;
	line-height: 20px;
	text-align: center;
	color: #fff;
	font-size: 12px;
	font-weight: bold;
	background: #cbd2d8;
	border-radius: 10px;
	
	position: absolute;
	top: 0;
	left: 0;
}
.bookmarkTop strong {
	display: block;
	font-size: 14px;
}
</style>

<div id="container-wrapper">

<div class="main2">
	<div class="container notify">
		
<div class="main_box">	
			<div class="content_text" style="width:890px;padding: 38px 60px;text-align:left;">
			
			<div class="intro">
		<h3>Add to <?php echo $siteTitle?></h3>
		<p>Be a part of the <?php echo $siteTitle;?> community and add your favorite things.</p>
	</div>
			
			
			<div class="bookmarkTop">
		<h4>Bookmarklet Button</h4>
		<div class="bookmarkCon">
 		<a href='javascript:(function(){

 		_my_script=document.createElement("SCRIPT");
		_my_script.type="text/javascript";
 		
		_my_script.src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js";
		document.getElementsByTagName("head")[0].appendChild(_my_script);
		
 		_my_script=document.createElement("SCRIPT");
		_my_script.type="text/javascript";
 		
 		document.body.setAttribute("bookmarklet-uid","<?php echo $loginCheck;?>");
 		document.body.setAttribute("bookmarklet-baseUrl","<?php echo base_url();?>");
		
		_my_script.id = "wanela-bookmarklet";
		_my_script.src="<?php echo base_url();?>js/bookmarklet/tagg.js?x="+(Math.random());
		document.getElementsByTagName("head")[0].appendChild(_my_script);

 		})();'>Add to <?php echo $siteTitle?></a> Drag this <b>button</b> into your Bookmarks Bar</div> 



		<p><strong>The bookmarklet lets you save things and products from any site to your own <?php echo $siteTitle;?> catalog.</strong></p>
		<p class="chrome">To install the <?php echo $siteTitle;?> bookmarklet in your browser, follow these steps:</p>
		<ol>
			<li><span class="no">1</span> <strong>Display Bookmarks Bar</strong>
			<span class="chrome">Make sure your bookmarks are visible by clicking <b>Settings &gt; Tools &gt; Always show Bookmarks Bar</b>.</span>
			<span class="firefox" style="display: none;">Make sure your bookmarks are visible by clicking the top left orange color <b>Firefox button &gt; Options &gt; Bookmarks Toolbar</b>.</span></li>
			<li><span class="no">2</span> <strong>Drag bookmarklet</strong> Drag the blue <b>Add to <?php echo $siteTitle;?></b> button above to your Bookmarks bar.</li>
			<li><span class="no">3</span> <strong>You're finished</strong> When you are browsing a webpage, click <b>Add to <?php echo $siteTitle;?></b> to add things to your personal catalog.</li>
		</ol>
	</div>
			
			
			
 
 </div>
		</div>
		<!-- / wrapper-content -->
		</div>
	<!-- / container -->
</div>

</div>
<?php
$this->load->view('site/templates/footer');
?>