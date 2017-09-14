<?php 
$this->load->view('site/templates/header.php');
?>
<link rel="stylesheet" type="text/css" media="all" href="css/site/<?php echo SITE_COMMON_DEFINE ?>timeline.css"/>
<style type="text/css" media="screen">
#edit-details { font-size: 11px; color: #f33; }
.option-area select.option {height:22px;margin:5px 0 12px 0;border:1px solid #D1D3D9;box-shadow:1px 1px 1px #EEE;border-radius:3px;}
a.selectBox.option {margin:5px 0 10px 0;padding:3px 0 3px}
a.selectBox.option .selectBox-label {padding-left:10px;font:inherit !important}
</style>

	<style>::-webkit-scrollbar, ::-webkit-scrollbar-thumb {width:7px;height:7px;border-radius:4px;}::-webkit-scrollbar, ::-webkit-scrollbar-track-piece {background:transparent;}::-webkit-scrollbar-thumb {background:rgba(255,255,255,0.3);}:not(body)::-webkit-scrollbar-thumb {background:rgba(0,0,0,0.3);}::-webkit-scrollbar-button {display: none;}</style>
<style>
.noproducts {
	float: left;
	width: 90%;
	padding: 5%;
	text-align: center;
	font-size: 25px;
	font-family: cursive;
}
</style>
<div class="lang-en wider no-subnav thing signed-out winOS">
<div id="container-wrapper">
	<div class="container shop">
		
<?php if($flash_data != '') { ?>
		<div class="errorContainer" id="<?php echo $flash_data_type;?>">
			<script>setTimeout("hideErrDiv('<?php echo $flash_data_type;?>')", 3000);</script>
			<p><span><?php echo $flash_data;?></span></p>
		</div>
		<?php } ?>
		
		<div class="wrapper-content index" style="width:100%; float:left; text-align:center; margin-top:60px">
			<div class="visual-wrap">
				<div class="visual">
					<div class="slide">
						<div class="slide_item" >
<!-- 							<a href="/things/190403263978277559/Fancy-Box-Subscription" > -->
								<img src="images/site/fancybox_banner.png" />
<!-- 							</a> -->
						</div>
					</div>
					<div class="paging hidden"></div>
				</div>
			</div>
			<div id="content" style="width:97%; float:left">
				
<!-- 				<div class="what-new list">
					<?php 
                       if ($fancyboxList->num_rows()>0){
					?>
					<h3><?php if($this->lang->line('fancy_hand_picked') != '') { echo stripslashes($this->lang->line('fancy_hand_picked')); } else echo "Handpicked For You"; ?></h3>
					<ul class="stream">
                       <?php 
                       	foreach ($fancyboxList->result() as $fancyboxRow){
                       		$image = 'dummyProductImage.jpg';
                       		$imgArr = explode(',', $fancyboxRow->image);
                       		if (count($imgArr)>0){
                       			foreach ($imgArr as $imgRow){
                       				if ($imgRow != ''){
                       					$image = $imgRow;
                       					break;
                       				}
                       			}
                       		}
                       ?>                         
						<li><div class="figure-product-new mini">
							<a id="thing-290347423874683563" class="anchor"></a>
							<a href="fancybox/<?php echo $fancyboxRow->id;?>/<?php echo url_title($fancyboxRow->name,'-');?>">
								<figure>
									<img src="/_ui/images/common/blank.gif" style="background-image:url('images/fancyybox/<?php echo $image;?>')">
								</figure>
								<figcaption><?php echo $fancyboxRow->name;?></figcaption>
							</a>
<!-- 							<a href="#" class="button fancy" tid="<?php echo $fancyboxRow->id;?>" item_img_url="images/fancyybox/<?php echo $image;?>"><span><i></i></span><?php echo LIKE_BUTTON;?></a>
 -->		<!-- 				</div></li>
                       <?php
                       	} 
                       ?>                         
					</ul>
					<?php 
                       }else {
					?>
					<p class="noproducts"><?php if($this->lang->line('fancy_not_avail') != '') { echo stripslashes($this->lang->line('fancy_not_avail')); } else echo "Not available"; ?></p>
					<?php 
                       }
					?>
				</div> -->
				
<?php /**********************design**************************/?>				
				
				<div class="what-new list" style="float:left">
				<h3><?php if($this->lang->line('fancy_hand_picked') != '') { echo stripslashes($this->lang->line('fancy_hand_picked')); } else echo "Handpicked For You"; ?></h3>
					<ul class="stream">
						<li>
							<div class="figure-product-new mini">
								<a id="thing-290347423874683563" class="anchor"></a>
								<a href="fancybox/123/sample">
									<figure>
										<img src="images/product/464332057305160935_054ed6d50b491382159344.jpg" style="background-image:url('images/fancyybox/image')">
									</figure>
									<figcaption><?php if($this->lang->line('fancbox_sample1') != '') { echo stripslashes($this->lang->line('fancbox_sample1')); } else echo "sample1"; ?></figcaption>
								</a>
		 					</div>
						</li>
						<li>
							<div class="figure-product-new mini">
								<a id="thing-290347423874683563" class="anchor"></a>
								<a href="fancybox/123/sample">
									<figure>
										<img src="images/product/464332057305160935_054ed6d50b491382159344.jpg" style="background-image:url('images/fancyybox/image')">
									</figure>
									<figcaption><?php if($this->lang->line('fancbox_sample1') != '') { echo stripslashes($this->lang->line('fancbox_sample1')); } else echo "sample1"; ?></figcaption>
								</a>
		 					</div>
						</li>
						<li>
							<div class="figure-product-new mini">
								<a id="thing-290347423874683563" class="anchor"></a>
								<a href="fancybox/123/sample">
									<figure>
										<img src="images/product/464332057305160935_054ed6d50b491382159344.jpg" style="background-image:url('images/fancyybox/image')">
									</figure>
									<figcaption><?php if($this->lang->line('fancbox_sample1') != '') { echo stripslashes($this->lang->line('fancbox_sample1')); } else echo "sample1"; ?></figcaption>
								</a>
		 					</div>
						</li>
				
				</ul>
				</div>
<?php /**********************design**************************/?>				
				
			</div>

		
		
		
	</div>
	<!-- / container -->


<script type="text/javascript" src="js/site/jquery.validate.js"></script>

<script>
jQuery(function($) {
	var $select = $('select.select-white');
	$select.selectBox();
	$select.each(function(){
		var $this = $(this);
		if($this.css('display') != 'none') $this.css('visibility', 'visible');
	});
});
</script>

<?php 
     $this->load->view('site/templates/footer');
     ?>