<div class="clear"></div>
<div class="top_add_de"><img src="<?=base_url();?>images/ad_top.jpg"></div>
<div class="clear"></div>

<div class="content">
    <div class="account_section">
        <div class="pro">
            <div class="account_left">
                <!--<div class="pro_left_heading">My Account</div>-->
            <?php echo $this->load->view('elements/left_account_block_tpl.php');?>

            </div>

            <div class="account_right">

            <?php /*?><div id="container22">    
                <div id="tab1" class="tab_content22"><?php */?> 
                    
                      <?php /*?>  <div id="deal_list">
                            <?php echo $favourite_list;?>
                        </div>   <?php */?>
                        
                        <div class="product_box">            
                            <div id="div_search_result">
                                <div id="product_ajax">
                                    <?php echo $favourite_list; ?>
                                </div>
                            </div>                                  
                            <!-- Loading Div -->
                                <div id="infscr-loading"><img src="<?= base_url() ?>images/scrolling_content_loader.gif" alt="Loading..."><div>Loading</div></div>
                            <!-- /Loading Div -->  
                        
                            <div class="clear"></div>            
                        </div>    
                         
                    
                 <?php /*?></div>        
            </div><?php */?>            

            </div>
            <div class="clear"></div>
        </div>

        <div class="clear"></div>
        <?php //echo $this->load->view('common/social_box.tpl.php');?>
        <div class="clear"></div>
    </div>    

   <?php /*?> <div class="right_pan">
            <div class="clear"></div>
        <?php echo $this->load->view('elements/subscribe.tpl.php');?>
        <?php echo $this->load->view('elements/facebook_like_box.tpl.php');?>
           <?php //echo $this->load->view('elements/latest_deal.tpl.php');?>
        <?php echo $this->load->view('elements/forum.tpl.php');?>
        <?php echo $this->load->view('common/ad.tpl.php');?>
        <div class="clear"></div>
    </div>    <?php */?>
    <div class="clear"></div>
</div>
<?php echo $this->load->view('common/social_box.tpl.php');?>
<div class="clear"></div>
<script type="text/javascript">
$(document).ready(function() {
           

});
</script>