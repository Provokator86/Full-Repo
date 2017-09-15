<script type="text/javascript">
$(document).ready(function(){

	//hide message_body after the first one
	$(".message_list .message_body:gt(0)").hide();

	//hide message li after the 5th
	$(".message_list div:gt(4)").hide();


	//toggle message_body
	$(".message_head").click(function(){
		$(this).next(".message_body").slideToggle(500)
		return false;
	});

	//collapse all messages
	$(".collpase_all_message").click(function(){
		$(".message_body").slideUp(500)
		return false;
	});

	//show all messages
	$(".show_all_message").click(function(){
		$(this).hide()
		$(".show_recent_only").show()
		$(".message_list div:gt(4)").slideDown()
		return false;
	});

	//show recent messages only
	$(".show_recent_only").click(function(){
		$(this).hide()
		$(".show_all_message").show()
		$(".message_list div:gt(4)").slideUp()
		return false;
	});

});
</script>
<div class="user_logded">
    <h1>Hello <?=$this->session->userdata('user_username')?></h1>
    <div class="margin10"></div>
    <?
    $this->load->view('admin/common/message_page.tpl.php');
    ?>
    <h5>What do you want to do today?</h5>
    <ul>
        <!--<li><a href="deals.html">View Active Deals</a></li>
        <li>|</li>-->
        <li><a href="<?=base_url().'party/add_party'?>">Plan a party</a></li>
        <li>|</li>
		 <li><a href="<?=base_url().'business/add'?>">Add a business</a></li>
        <li>|</li>
        <li><a href="<?=base_url().'profile/write_review'?>">Write a review</a></li>
        <li>|</li>
        <li><a href="<?=base_url().'profile/upload_business_image'?>">Upload picture/menu</a></li>
        <li>|</li>
        <li><a href="<?=base_url().'profile/edit'?>">Edit/Update Profile</a></li>
    </ul>
    <br />
    <div class="margin5"></div>
    <div class="border"></div>
    <div class="margin10"></div>
    <h2><?=$content_text[0]['title']?></h2>
    <div class="margin15"></div>
    <?=html_entity_decode($content_text[0]['description'])?>
    <div class="margin15"></div>
    <div class="border"></div>
    <div class="margin15"></div>
    <h2>Your Activities
        <div class="description">click on each item to expand</div></h2>
    <div class="margin15"></div>
    <div class="message_head">
        <h3><img align="absmiddle" src="<?=base_url()?>images/front/icon_07.png" alt="" /> Interests shown in business </h3>
    </div>
    <div class="message_body" style="display:none;">
        <div id="div_interest_list">
		
        </div>
    </div>

    <div class="margin15"></div>
    <div class="message_head"><h3><img align="absmiddle" src="<?=base_url()?>images/front/icon_08.png" alt="" /> Parties Planned</h3></div>
    <div class="message_body" style="display:none">
        <div id="div_planed_party_list">

        </div>
    </div>
    <!--<div class="margin15"></div>
    <div class="message_head"><h3><img align="absmiddle" src="images/icon_17.png" alt="" /> Deals Purchased</h3></div>
    <div class="message_body" style="display:none">
     Lorem ipsum
    </div>-->
	<div class="margin15"></div>
    <div class="message_head"><h3><img align="absmiddle" src="<?=base_url()?>images/front/icon_17.png" alt="" /> Uploaded Business</h3></div>
    <div class="message_body" style="display:none">
    <div id="div_user_business_list">

     </div>
    </div>
    <div class="margin15"></div>
    <div class="message_head">
        <h3><img align="absmiddle" src="<?=base_url()?>images/front/icon_09.png" alt="" /> Reviews Written</h3>
    </div>
    <div class="message_body" style="display:none">
        <div id="div_business_review_list">

        </div>
    </div>
    <div class="margin15"></div>
    <div class="message_head"><h3><img align="absmiddle" src="<?=base_url()?>images/front/icon_10.png" alt="" /> Pictures Uploaded</h3></div>
    <div class="image_box message_body" style="display:none">
        <div id="div_picture_uploaded_list">

        </div>
    </div>
    <div class="margin15"></div>
    <div class="message_head"><h3><img align="absmiddle" src="<?=base_url()?>images/front/icon_11.png" alt="" /> Address book</h3></div>
    <div class="message_body" style="display:none">
        <h4 style="padding-left: 50px;">
            <a onclick="tb_show('Import contact','<?=base_url()?>ajax_controller/ajax_show_import_contact?height=500&width=600');" style="color: #FF790A;cursor: pointer;">Add to address book</a>
        </h4>
        <div id="div_address_book_list">

        </div>
    </div>
     <!--<div class="margin15"></div>
     <div class="message_head"><h3><img align="absmiddle" src="images/icon_18.png" alt="" /> Add Business</h3></div>
     <div class="message_body" style="display:none">fdgdfg</div>-->
</div>
<script type="text/javascript">
    autoload_ajax('<?=base_url().'profile/interest_list_ajax'?>','div_interest_list');
    autoload_ajax('<?=base_url().'profile/planed_party_ajax'?>','div_planed_party_list');
    autoload_ajax('<?=base_url().'profile/user_uploaded_business'?>','div_user_business_list');
    autoload_ajax('<?=base_url().'profile/business_review_ajax'?>','div_business_review_list');
    autoload_ajax('<?=base_url().'profile/picture_uploaded_ajax'?>','div_picture_uploaded_list');
    autoload_ajax('<?=base_url().'profile/address_book_ajax'?>','div_address_book_list');
</script>