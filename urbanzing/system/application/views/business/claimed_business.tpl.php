<div class="plan_party">
    <h1>My claimed business <div class="back_btn"><a href="<?=base_url().'profile'?>">Back</a></div>
      </h1>
    <div class="margin15"></div>
    <h5><?=$business_claim_page_text[0]['title']?></h5>
     <?=html_entity_decode($business_claim_page_text[0]['description'])?>
    <div class="margin10"></div>
    <div class="border"></div>
    <div class="margin15"></div>
    <?
    $this->load->view('admin/common/message_page.tpl.php');
    ?>
    <div id="div_claimed_business_list">
    </div>

    <script type="text/javascript">
        autoload_ajax('<?=base_url().'business/claimed_business_list_ajax'?>','div_claimed_business_list');
        
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
    
    <br />
    <div class="clear"></div>
</div>