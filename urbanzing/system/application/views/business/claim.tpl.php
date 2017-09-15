<div class="plan_party">
    <h1>Claim a business <div class="back_btn"><a href="<?=base_url().'profile'?>">Back</a></div>
      </h1>
    <div class="margin15"></div>
    <h5><?=$business_claim_page_text[0]['title']?></h5>
    <?=html_entity_decode($business_claim_page_text[0]['description'])?>
    <div class="margin10"></div>
    <div class="border"></div>
    <div class="margin15"></div>
    <span class="search_text">Search Business</span>&nbsp;&nbsp;
    <input id="claim_business" name="claim_business" style="width:252px; height:18px;" type="text" /> &nbsp;
    <input class="button_01" type="submit" value="GO >>" onclick="submit_claim_business_page()"/>
    <div class="margin15"></div>
    <?
    $this->load->view('admin/common/message_page.tpl.php');
    ?>
    <div id="div_claim_business_list">
    </div>

    <script type="text/javascript">
        autoload_ajax('<?=base_url().'business/claim_business_list_ajax'?>','div_claim_business_list');
        
        function submit_claim_business_page()
        {
            var v   = document.getElementById('claim_business').value;
            var j_data  ='search_str='+v+'';
            autoload_ajax_no_jsn('<?=base_url().'business/claim_business_list_ajax'?>','div_claim_business_list',j_data);
        }
        function claim_business(id)
        {
            if(document.getElementById('ck_clim_business'+id).checked==false)
            {
               alert('You have to accept the certification');
               return false;
            }
            window.location.href='<?=base_url().'business/claim_my_business/'?>'+id;
        }
    </script>
    
    <br />
    <div class="clear"></div>
</div>