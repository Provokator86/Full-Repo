

<script type="text/javascript">
    function request_coupon(id)
    {
        tb_show('Request coupon','<?=base_url()?>ajax_controller/ajax_request_coupon/'+id+'?height=50&width=400');
        setTimeout('tb_remove()',5000);
		//        autoload_ajax_request_coupon('<?=base_url()?>ajax_controller/ajax_request_coupon/<?=$this->session->userdata('user_id')?>/'+id,'','');
		//        window.location.reload();
    }

	$(document).ready(function() {
		$('form#frm_serach_review').ajaxForm({
			//		dataType:  'script',
			beforeSubmit: search_review_before_ajaxform,
			success:      search_review_after_ajaxform
		});

		$('form#frm_serach_review').submit(function() {
			// inside event callbacks 'this' is the DOM element so we first
			// wrap it in a jQuery object and then invoke ajaxSubmit
			//$(this).ajaxSubmit();

			// !!! Important !!!
			// always return false to prevent standard browser submit and page navigation
			return false;
		});
	});

	function search_review_before_ajaxform()
	{
	}

	function search_review_after_ajaxform(responseText)
	{
		document.getElementById('review_list').innerHTML = responseText;
	}

    $(function() {
        $('#gallery a').lightBox();
    });
    $(function() {
        $('#gallery_menu a').lightBox();
    });
</script>
<style type="text/css">
	/* jQuery lightBox plugin - Gallery style */
	#gallery {

	}
	#gallery ul { list-style: none; }
	#gallery ul li { display: inline; }
	#gallery ul img {
		border: 5px solid #3e3e3e;
		border-width: 5px 5px 20px;
	}
	#gallery ul a:hover img {
		border: 5px solid #fff;
		border-width: 5px 5px 20px;
		color: #fff;
	}
	#gallery ul a:hover { color: #fff; }
	#gallery_menu {

	}
	#gallery_menu ul { list-style: none; }
	#gallery_menu ul li { display: inline; }
	#gallery_menu ul img {
		border: 5px solid #3e3e3e;
		border-width: 5px 5px 20px;
	}
	#gallery_menu ul a:hover img {
		border: 5px solid #fff;
		border-width: 5px 5px 20px;
		color: #fff;
	}
	#gallery_menu ul a:hover { color: #fff; }
</style>
<div class="club_pub">
    <div class="right_cell_02">
		<?
		$this->load->view('admin/common/message_page.tpl.php');
		?>
        <div class="comment_box">
            <h2><?=$row[0]['name']?></h2>
			<?
			for($i=1;$i<=$row[0]['avg_review'];$i++) {
				?><img src="<?=base_url()?>images/front/star.png" alt=""/><?
			}
			?>
			<em>( Based on <?=$row[0]['tot_review']?> reviews)</em>
			<div class="margin5"></div>
			 <div>
			 <div style="float:left;margin-right:10px;"><a onclick="tb_show('','<?=base_url()?>ajax_controller/ajax_checkin/<?=$row[0]['id']?>?height=260&amp;width=450');" style="cursor: pointer;"><img src="<?=base_url()?>images/front/check_in.png" /></a>
			 </div>
			<div ><iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo rawurlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>&amp;layout=standard&amp;show_faces=true&amp;width=450&amp;action=like&amp;show_faces=false&amp;colorscheme=light&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:40px;" allowTransparency="true"></iframe>
		  </div>
		 </div>

<!--<iframe scrolling="no" frameborder="0" allowtransparency="true" style="border: medium none; overflow: hidden; width: 450px; height: 50px;" src="http://www.facebook.com/plugins/like.php?href=http://www.facebook.com/pages/urbanzing.com/<?=$this->config->item('facebook_app_id')?>&amp;layout=standard&amp;show_faces=false&amp;width=450&amp;action=like&amp;font=verdana&amp;colorscheme=light&amp;height=50"></iframe>-->

<!-- 	<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.acumencs.com%2Furbanzing%2F&amp;layout=standard&amp;show_faces=false&amp;width=450&amp;action=like&amp;font=arial&amp;colorscheme=light&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:39px;" allowTransparency="true"></iframe>-->

			<!--<div id="fb-root"></div>
	<script>
						  window.fbAsyncInit = function() {
							FB.init({appId: '<?=$this->config->item('facebook_app_id')?>', status: true, cookie: true,
									 xfbml: true});
						  };
						  (function() {
							var e = document.createElement('script'); e.async = true;
							e.src = document.location.protocol +
							  '//connect.facebook.net/en_US/all.js';
							document.getElementById('fb-root').appendChild(e);
						  }());
						</script>


						<fb:like href="http://www.urbanzing.com" show_faces="false"></fb:like>-->

<!--<a href="#"><img align="absmiddle" src="<?=base_url()?>images/front/check_in.png" alt="" /></a><a href="#"><img align="absmiddle" src="<?=base_url()?>images/front/like.png" alt="" /></a>&nbsp;&nbsp;
<span><img  align="absmiddle"src="<?=base_url()?>images/front/face_book_icon.png" alt="" /> 39 people like this</span>-->
			<a style="float:right;" href="javascript:void(0)" onclick="tb_show('Location','<?=base_url()?>ajax_controller/ajax_show_map/business/<?=$row[0]['id']?>?height=250&width=400&KeepThis=true&TB_iframe=true');">
				<img align="absmiddle" src="<?=base_url()?>images/front/map_icon.png" alt="" />&nbsp;View map</a><br />
        </div>
        <div class="comment_edit">
            <div class="edit_left">
<?
				if($row[0]['cuisine'] && $row[0]['cuisine']!='') {
					?>
                <p><b>Cuisine:</b> <span><?=$row[0]['cuisine']?></span></p>
					<?
	if($row[0]['other_cuisine']!='') {
						?>
                <p>Other cuisine: <span><?=$row[0]['other_cuisine']?></span></p>
						<?
					}
}
				?>
                <div class="margin15"></div>
                <p><?=$row[0]['address']?><br />
				<?=$row[0]['ct_name']?>, <?=$row[0]['zipcode']?><br />
                    Locality: <?=$row[0]['place']?><br />
					 Phone #:<?=$row[0]['phone_number']?>
					<?php if(!empty($row[0]['tags'])) { ?>
					<br/><b>Tags:</b> <span><?=$row[0]['tags']?></span>
					<?php } ?>
                </p>
                <div class="margin15"></div>
					<?
if($row[0]['website']!='') {
	?>
                <p><a target="_BLANK" href="<?=$row[0]['website']?>"><?=$row[0]['website']?></a></p>
					<?
				}
				?>
                <div class="margin10"></div>
                <span><img align="absmiddle" src="<?=base_url()?>images/front/icon_01.png" alt="" />
				<?
				if($this->session->userdata('user_id')!='') {
	?>
                    <a style="cursor: pointer;" onclick="tb_show('Incorrect business','<?=base_url()?>ajax_controller/ajax_show_incorrect_business/incorrct_business/<?=$row[0]['id']?>?height=300&width=450');">Incorrect Business Info</a>
						<?
					}
					else {
						?>
                    <a style="cursor: pointer;" onclick="tb_show('Login','<?=base_url()?>ajax_controller/ajax_show_login/incorrect_business/<?=$row[0]['id']?>?height=250&width=400');">Incorrect Business Info</a>
						<?
					}
					?>
				</span>
                <span><img align="absmiddle" src="<?=base_url()?>images/front/icon_02.png" alt="" />
                    <a style="cursor: pointer;" onclick="tb_show('Message','<?=base_url()?>ajax_controller/ajax_message/is_your_business/?height=150&width=400');">Is this your buisness?</a>
                </span>

					<?php /*?><span><img align="absmiddle" src="<?=base_url()?>images/front/icon_02.png" alt="" />
                <?
                if($this->session->userdata('user_id')!='')
                {
                    if($this->session->userdata('user_type_id')!=4)
                    {
                        ?>
                    <a style="cursor: pointer;" onclick="tb_show('Message','<?=base_url()?>ajax_controller/ajax_message/is_your_business/?height=150&width=400');">Is this your buisness?</a>
                        <?
                    }
                    else
                    {

                ?>
                        <a style="cursor: pointer;" href="<?=base_url().'business/claim_my_business/'.$row[0]['id']?>">Is this your buisness?</a>
                <?
                    }
                }
                else
                {
                  
                ?>
                    <a style="cursor: pointer;" onclick="tb_show('Login','<?=base_url()?>ajax_controller/ajax_show_login/is_your_business/<?=$row[0]['id']?>?height=250&width=400');">Is this your buisness?</a>
                <?
                }
                ?>
                </span><?php */?>
				<?
				if($row[0]['business_category']==1) {
					?>
                <span><img align="absmiddle" src="<?=base_url()?>images/front/icon_03.png" alt="" />
					<?
					if(isset($menu_list) && count($menu_list)>0) {
						?>
                    <span id="gallery_menu" style="width:">
                        <a href="<?php echo $this->config->item('view_image_folder_biz').$this->config->item('image_folder_view').$menu_list[0]['img_name'];?>" style="cursor: pointer;" title="<?php echo $menu_list[0]['full_name'];?>">View Menu</a>
						<?
		foreach($menu_list as $k=>$v) {
								if($k>0) {
									?>

						<div style="display: none;" class="thumb_menu">
							<a href="<?php echo $this->config->item('view_image_folder_biz').$this->config->item('image_folder_view').$v['img_name']; ?>" title="<?php echo $v['full_name'];?>"> </a>

						</div>

										<?
									}
								}
								?>
					</span>
		<?
	}
	else {
		if($this->session->userdata('user_id')!='') {
			?>
					<a style="cursor: pointer;" onclick="tb_show('Upload menu','<?=base_url()?>ajax_controller/ajax_show_upload_menu/upload_menu/<?=$row[0]['id']?>?height=250&width=450');">Upload menu</a>
									<?
								}
								else {
			?>
					<a style="cursor: pointer;" onclick="tb_show('Login','<?=base_url()?>ajax_controller/ajax_show_login/upload_menu/<?=$row[0]['id']?>?height=250&width=400');">Upload menu</a>
								<?
							}
						}
						?>

                </span>
	<?php
					}
					?>
            </div>
			<div class="edit_right" >
				<div id="gallery">
                    <div id="containing_div">
                        <div class="photo_frame" >
					<?php
					if(isset($row[0]['img_name']) && !empty($row[0]['img_name'])) {
						?>
                            <a href="<?php echo $this->config->item('view_image_folder_biz').$this->config->item('image_folder_view').$row[0]['img_name']; ?>" title="<?php echo $row[0]['full_name'];?>" >
                                <img style="border:2px solid #cccccc;" src="<?php echo $this->config->item('view_image_folder_biz').$this->config->item('image_folder_thumb').$row[0]['img_name']; ?>" alt="" />
                            </a>
					<?
				}
else {
	?>
                            <img style="border:2px solid #cccccc;" width="150" height="93" src="<?=base_url()?>images/front/img_03.jpg" alt="" />
	<?
}
							?>


                        </div>
                    </div>
                    <div class="margin5"></div>
                    <br />
							<?php
							if(isset($row[0]['business_picture'][0]['img_name'])) {
								foreach($row[0]['business_picture'] as $k=>$v) {
									if($k<4) {
										?>
					<div class="thumb">
						<a href="<?php echo $this->config->item('view_image_folder_biz').$this->config->item('image_folder_view').$v['img_name']; ?>" title="<?php echo $v['full_name'];?>">
							<img width="29" height="28" src="<?php echo $this->config->item('view_image_folder_biz').$this->config->item('image_folder_thumb').$v['img_name']; ?>" alt=""/></a></div>
										<?
		}
		else {
			?>
					<div class="thumb" style="display: none;">
						<a href="<?php echo $this->config->item('view_image_folder_biz').$this->config->item('image_folder_view').$v['img_name']; ?>" title="<?php echo $v['full_name'];?>">
							<img width="29" height="28" src="<?php echo $this->config->item('view_image_folder_biz').$this->config->item('image_folder_thumb').$v['img_name']; ?>" alt=""/></a></div>
								<?
							}
						}
					}
					?>

                    <br />
				</div>
				<h3>
<?
if($this->session->userdata('user_id')!='') {
						?>
					<a style="cursor: pointer;" onclick="tb_show('Upload business photo','<?=base_url()?>ajax_controller/ajax_show_upload_business_photo/upload_business_photo/<?=$row[0]['id']?>?height=200&width=450');">Add Photo</a>
						<?
					}
					else {
	?>
					<a style="cursor: pointer;" onclick="tb_show('Login','<?=base_url()?>ajax_controller/ajax_show_login/add_photo/<?=$row[0]['id']?>?height=250&width=400');">Add Photo</a>
	<?
					}
					?>
				</h3>
			</div>
			<div class="clear"></div>
		</div>
		<div class="party_details">
			<div class="margin10"></div>
			<div class="request_coupon">
					<?
					if($this->session->userdata('user_id')!='') {
						?>
				<a style="cursor: pointer;padding-right: 12px;" onclick="request_coupon('<?=$row[0]['id']?>');">Request Coupon</a>
	<?
					}
					else {
						?>
				<a style="cursor: pointer;padding-right: 12px;" onclick="tb_show('Login','<?=base_url()?>ajax_controller/ajax_show_login/request_coupon/<?=$row[0]['id']?>?height=250&width=400');">request coupons</a>
						<?
}
					?>
				<a rel="imgtip[0]"  href="#" style="padding-left:7px;"><img align="absmiddle" src="<?=base_url()?>images/front/icon_06.png" alt="" /></a>
			</div>
			<div class="plan_party">
<?
if($this->session->userdata('user_id')!='') {
	?>
				<a href="<?=base_url()?>party/add_party/<?=$row[0]['id']?>">Plan A Party</a>
	<?
}
				else {
					?>
				<a style="cursor: pointer;" onclick="tb_show('Login','<?=base_url()?>ajax_controller/ajax_show_login/plan_a_party/<?=$row[0]['id']?>?height=260&width=450');">Plan A Party</a>
					<?
}
				?>
				<a rel="imgtip[1]"  href="#" style="padding:0px 0px 0px 0px;"><img align="absmiddle" src="<?=base_url()?>images/front/icon_06.png" alt="" /></a>
			</div>
			<br />
			<div class="cell_13">
				<p>Hours:</p>
				<p>
				<?
				if(isset($row[0]['business_hour'])) {
	foreach ($row[0]['business_hour'] as $k=>$v) {
		if($v['hour_from']!='') {
			echo substr($v['day'], 0,3).' '.$v['hour_from'].(($v['hour_from']!='closed')?' - '.$v['hour_to']:'').'<br/>';
						}
					}
				}
				?>
				</p>
				<p><?=$row[0]['hour_comment']?></p>
			</div>
				<?php
				if($row[0]['business_category'] ==1) {
					?>
			<div class="cell_14">
				<p>Average Entree Price <br /><?=$row[0]['price_from']?>-<?=$row[0]['price_to']?></p>
				<div class="margin15"></div>
				<p>Takes Reservations: <?=($row[0]['take_reservation']==1)?'Yes':''?></p>
				<p>Delivery: <?=($row[0]['delivery']==1)?'Yes':''?></p>
			</div>
	<?php } ?>
			<div class="cell_15">
<?php
					if($row[0]['business_category'] ==1) {
						?>
				<p>Vegetarian: <?=($row[0]['vegetarian']==1)?'Yes':''?> </p>
						<?php } ?>
				<p>Accepts Credit Cards: <?=($row[0]['credit_card']==1)?'Yes':''?> </p>
				<p>Parking: <?=($row[0]['parking']==1)?'Yes':''?></p>
				<div class="margin15"></div>
				<p>Air Conditioned: <?=($row[0]['air_conditioned']==1)?'Yes':''?> </p>
					<?php
					if($row[0]['business_category'] ==1) {
						?>
				<p>Serving Alcohol: <?=($row[0]['serving_alcohol']==1)?'Yes':''?></p>
	<?php } ?>
			</div>
			<br />
			<div class="margin10"></div>
		</div>
		<div class="review_box">
			<div class="review_top">
				<div class="cell_07">
<?
if($this->session->userdata('user_id')!='') {
	?>
					<input onClick="window.location.href='<?=base_url().'business/write_review/'.$row[0]['id']?>'" class="button_03" type="button" value="write a Review" />
	<?
			}
else {
					?>
					<input onclick="tb_show('Login','<?=base_url()?>ajax_controller/ajax_show_login/write_review/<?=$row[0]['id']?>?height=250&width=400');" class="button_03" type="button" value="write a Review" />
					<?
}
				?>
					<input class="button_03" type="button" value="Send to phone" onclick="tb_show('Send to Phone', '<?php echo base_url()?>business/show_send_2_phone/<?php echo $row[0]['id']; ?>?height=215&width=450');" />
				</div>
				<div class="review_botm" style="border: 0px;padding: 0px;">
                    <div class="cell_12">
                        <form id="frm_serach_review" name="frm_serach_review" class="frm_serach_review" method="post" action="<?=base_url().'ajax_controller/review_list_ajax/'.$business_id?>">
							<input type="text" name="search_str" id="search_str" value="<?=$search_str?>" />&nbsp;
							<input onclick="$('#frm_serach_review').submit();" class="button_03" type="button" value="Search reviews" />
						</form>
                    </div>
				</div>

				<div id="review_list" style="margin-top: 25px;">
				</div>
				<script type="text/javascript">
					autoload_ajax('<?=base_url().'ajax_controller/review_list_ajax/'.$row[0]['id']?>','review_list');

					function like_review(url,trgtId)
					{
						like_review_ajax(url,trgtId);
					}
				</script>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>