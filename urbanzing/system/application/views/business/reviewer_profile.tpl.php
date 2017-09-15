<script type="text/javascript">
<!--
var timeout         = 500;
var closetimer		= 0;
var ddmenuitem      = 0;

// open hidden layer
function mopen(id)
{
	// cancel close timer
	mcancelclosetime();

	// close old layer
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';

	// get new layer and show it
	ddmenuitem = document.getElementById(id);
	ddmenuitem.style.visibility = 'visible';

}
// close showed layer
function mclose()
{
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';
}

// go close timer
function mclosetime()
{
	closetimer = window.setTimeout(mclose, timeout);
}

// cancel close timer
function mcancelclosetime()
{
	if(closetimer)
	{
		window.clearTimeout(closetimer);
		closetimer = null;
	}
}

// close layer when click-out
document.onclick = mclose;
// -->
</script>

<script type="text/javascript">
  $(function() {
	 $('#container-4').tabs({ fxFade: true, fxSpeed: 'fast' });
	 $('#container-5').tabs({ fxFade: true, fxSpeed: 'fast' });
  });


</script>
						 
<div class="main_content">
<!--Profile start-->
<div class="profile">
<div class="cell_01">
	<div class="img_frame">
	 <?php if($row[0]['img_name'] != '') { ?>
	 <img src="<?=base_url()?>images/uploaded/user/thumb/<?=$row[0]['img_name']?>" alt="" />
	 <?php } else { ?>
	 <img src="<?=base_url()?>images/front/img_04.jpg" alt="" />
	 <?php }?>
	 
	 
	 </div>
   </div>
   <div class="cell_02">
	<h2><?php if( $row[0]['screen_name'] != '') echo $row[0]['screen_name']; else echo $row[0]['f_name']; ?></h2>
	<span style="font-size:12px"> <?=$user_type?></span>
	 <img align="absmiddle" src="<?=base_url()?><?=$user_type_icon?>"  />
		
		
   </div>
   <div class="cell_03">
	<h5>About<?php if( $row[0]['screen_name'] != '') echo ' '.$row[0]['screen_name']; else echo ' '.$row[0]['f_name']; ?></h5>
		<p><?php if( $row[0]['about_yourself'] == '')
				    echo 'Data  is not provided.';
				  else
					  echo $row[0]['about_yourself'];
		?></p>
   </div>
<div class="clear"></div>
<h6><?=$facebook_url?>&nbsp;&nbsp;<a href="http://facebook.com/share.php?u=<?=$facebook_url?>"  target="_blank"><img src="<?=base_url()?>images/front/face_book_icon.png" alt="" /> Share</a></h6>
</div>
<?php //echo "<pre>"; print_r($review_details);echo "</pre>";exit;?>
<!--Profile End-->
<div class="search_review_box">
<form action="<?=base_url()?>business/show_profile/<?php echo $row[0]['id'];?>" method="post">
<input type="text" name="search_text" id="search_text"/> <input class="button_03" type="submit" value="Search reviews" />
</form>
</div>
<div class="profile_section_02">
<div class="profile_left">
	<h5>Accomplishments :</h5>
		<ul>
			<li><img align="absmiddle" src="<?=base_url()?>images/front/icon_23.png" alt="i" />&nbsp;&nbsp;<?php echo $total_review;?>&nbsp;&nbsp;Reviews</li>
			 <li><img align="absmiddle" src="<?=base_url()?>images/front/icon_20.png" alt="" />&nbsp;&nbsp;<?php echo $no_of_first_review;?> First to review</li>
			 <li><img align="absmiddle" src="<?=base_url()?>images/front/add_business.png" alt="" />&nbsp;&nbsp;<?php echo $no_of_business_added;?> Business added</li> 
			 <!--<li><img align="absmiddle" src="images/icon_20.png" alt="" />&nbsp;&nbsp;1 Place added</li>-->
		</ul>
		<!--<ul style="border:none;">
			<li><img align="absmiddle" src="images/icon_22.png" alt="" />&nbsp;&nbsp;Burpping since <br /><span>19 13 july 2010</span></li>
			 <li><img align="absmiddle" src="images/icon_21.png" alt="" />&nbsp;&nbsp;6 First to review</li>
		</ul>-->
   </div>
<div class="profile_right">
		<div>
			<ul >
				  <li>Review</li>
			</ul>
			<div class="clear"></div>
			 <div>
				<?php 
                if( $review_details[0]['tot_row'] != 0)
                {
					  foreach($review_details as $key=>$value)
                      {
                ?>
				 <div class="profile_review">
					 <div class="img_box"><a href="<?=base_url()?>business/<?=$value['business_details'][0]['id'];?>"><img style="width:60px;height: auto;" <?php if($value['business_img'][0]['img_name'] != ''){ ?> src="<?=base_url()?>images/uploaded/business/thumb/<?=$value['business_img'][0]['img_name'];?>" <?php } else { ?> src="<?=base_url()?>images/front/img_04.jpg" <?php }?>alt="" /></a></div>
					<div class="review_text_box">
					<?php  $txtshow = str_replace(" ", "_", $value['b_name']);	?>
						<h6><a href="<?=base_url()?>business/<?=$value['business_details'][0]['id'];?>/<?=$txtshow?>"><?=$value['b_name']?></a></h6>
							<em><?php echo $value['business_details'][0]['address'];
								echo "<br>".'Kolkata-'.$value['business_details'][0]['zipcode'];?></em><br />
							<em> <?php while($value['star_rating'] >0 ){?><img src="<?=base_url()?>images/front/star.png" />  <?php  $value['star_rating']--;}?>
							
							<?=date('d-m-Y',$value['cr_date'])?></em> &nbsp;&nbsp;
							<br/><font color="orange" style="font-size: 14px;"><?php echo $value['review_title'];?> </font>
					   </div>
					   <div class="clear"></div>
					   <p><?=$value['comment']?></p>
				  </div>
				 <?php }} else {?>
				 <span> No result found</span> <?php }?>

			 </div>
			<div class="clear"></div>
			<div id="fragment-11" style="display:block;"></div>
		</div>

                                   </div>
                                   <div class="clear"></div>
                              </div>

 </div>

                             
      