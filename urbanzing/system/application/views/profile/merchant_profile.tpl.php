<div class="user_logded">
    <h1>Hello <?=$this->session->userdata('user_username')?></h1>
    <div class="margin10"></div>
	<h2><?=$content_text[0]['title']?></h2>
    <div class="margin15"></div>
    <?=html_entity_decode($content_text[0]['description'])?>
    <div class="margin15"></div>
    <h5>What do you want to do today?</h5>
    <ul>
        <li><a href="<?=base_url().'business/add'?>">add a business</a></li>
        <li>|</li>
        <li><a href="<?=base_url().'business/claim'?>">claim a business</a></li>
        <li>|</li>
        <!--<li><a href="admin_coupons_deals.html">Administer Coupons/Deals</a></li>
        <li>|</li>-->
        <li><a href="<?=base_url().'profile/edit'?>">Edit/Update Profile</a></li>
        <li>|</li>
        <li><a href="<?=base_url().'business/claimed_business'?>">Claimed business</a></li>
        
    </ul>
    <br />
    <div class="margin5"></div>
    <div class="border"></div>
    <div class="margin10"></div>
	
    <h2>Manage your Business</h2>
    <div class="margin15"></div>
    <?
    $this->load->view('admin/common/message_page.tpl.php');
    ?>
    <div class="border"></div>
    <div class="margin15"></div>
    <div class="margin10"></div>

    <div id="div_business_list">
    </div>

    <script type="text/javascript">
        autoload_ajax('<?=base_url().'profile/business_list_ajax'?>','div_business_list');
        function unlock_business(id)
        {
            var code    = document.getElementById('code'+id).value;
            if(code=='')
            {
               alert('You have to give the code');
               return false;
            }
            window.location.href='<?=base_url().'business/unlock_business/'?>'+id+'/'+code;
        }
    </script>
    
</div>