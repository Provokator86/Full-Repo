<style type="text/css">
	.stepcarousel{
		position: relative; /*leave this value alone*/
		background:url(images/front/gallery_back.png) no-repeat;
		overflow: scroll; /*leave this value alone*/
		width: 223px; /*Width of Carousel Viewer itself*/
		height:228px;
		color:#000000;
		/*Height should enough to fit largest content's height*/
	}

	.stepcarousel .belt{
		position: absolute; /*leave this value alone*/
		left: 0;
		top: 0;
		color:#000000;
	}

	.stepcarousel .panel{
		float: left; /*leave this value alone*/
		overflow: hidden; /*clip content that go outside dimensions of holding panel DIV*/
		margin: 5px; /*margin around each panel*/
		width: 213px; /*Width of each panel holding each content. If removed, widths should be individually defined on each content DIV then. */
		height:220px;
		color:#000000;
		text-align:center;
	}
</style>

<script type="text/javascript">
	stepcarousel.setup({
		galleryid: 'mygallery', //id of carousel DIV
		beltclass: 'belt', //class of inner "belt" DIV containing all the panel DIVs
		panelclass: 'panel', //class of panel DIVs each holding content
		autostep: {enable:true, moveby:1, pause:3000},
		panelbehavior: {speed:500, wraparound:true, wrapbehavior:'slide', persist:true},
		defaultbuttons: {enable: true, moveby: 1, leftnav: [base_url+'images/front/left_arrow.png', 175, 230], rightnav: [base_url+'images/front/right_arrow.png', -20, 230]},
		statusvars: ['statusA', 'statusB', 'statusC'], //register 3 variables that contain current panel (start), current panel (last), and total panels
		contenttype: ['inline'] //content setting ['inline'] or ['ajax', 'path_to_external_file']
	})
</script>

<div class="left_panel">
    <div class="section_01">
		<?php if($img_list) { ?>
		<div class="left_section">
			<div id="mygallery" class="stepcarousel">
				<div class="belt">
					<?php foreach($img_list as $key=>$value) { ?>
					<div class="panel">
						<div style="height:168px; width:213px;background:url(<?=base_url().'images/archieve/'.$value['img_name']?>) center no-repeat;">&nbsp;</div>
						<div style=" position:absolute; top:180px; left:0px; line-height:16px; font-size:12px; text-align:left"><?=substr( $value['description'],0,80)?></div>
					</div>
					<?php } ?>
				</div>
			</div>

			<p id="mygallery-paginate" style="width: 223px; margin-top:-3px; text-align:left">
				<img src="<?=base_url()?>images/front/opencircle.png" data-over="<?=base_url()?>images/front/graycircle.png" data-select="<?=base_url()?>images/front/closedcircle.png" data-moveby="1" />
			</p>
		</div>
		<?php } ?>
		
		<div class="right_section">
			<h1><?php echo $home_page_text[0]['title']?></h1>
			<?=html_entity_decode( $home_page_text[0]['home_text'])?>
		</div>
		<div class="clear"></div>
	</div>
	
	<?php if($featured_business) { ?>
	<div class="section_02">
		<h1>This Week's Features</h1>
		<!--Event Box Start-->
		<?php
		$i = 0;
		//var_dump($featured_business);
		foreach($featured_business as $key=>$value) {
			$bg = ($i%2) ? '#f3f3f3' : '';
		?>
		<div class="event_box" style="background:<?=$bg?>">
			<div class="cell_01"> <a href="<?=base_url().'business/'.$value['business_id'].'/'.str_replace(' ','_',$value['business_title'])?>">
				<?php $img_name = ($value['image_name'])?'archieve/'.$value['image_name'] : 'front/img_03.jpg'; ?>
				<img src="<?=base_url().'images/'.$img_name?>" alt="" width="77" />
			</a></div>
			<div class="cell_02">
				<h5><a href="<?=base_url().'business/'.$value['business_id'].'/'.str_replace(' ','_',$value['business_title'])?>"><?=$value['business_title']?></a></h5>
				
				<h6> <?=($value['cusine'])? 'Cuisine:' .$value['cusine']:'' ?></h6>
				
				<h5 style="padding-top:8px;">Editors comments</h5>
				<p style="padding-top:2px;">
				<?=($value['editorial_comment']) ? $value['editorial_comment'] : 'Not yet posted.'?>
				</p>
			</div>
			<div class="clear"></div>
		</div>

		<?php
			$i++;
		}
		?>
	</div>
	<?php } ?>
</div>