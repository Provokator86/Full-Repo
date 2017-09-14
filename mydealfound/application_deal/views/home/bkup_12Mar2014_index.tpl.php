<?php

/*

 * To change this template, choose Tools | Templates

 * and open the template in the editor.

 */

?>

        <div class="banner_section">

                <div>

                    <div class="banner">

                        <? $this->load->view('elements/feature_deal.tpl.php');?>

                    </div>

                </div>


                <div class="ban_tab">

                     <? $this->load->view('elements/popular_store.tpl.php');?>

                </div>

                 <div class="clear"></div>

        </div>

         <div class="clear"></div>

        <div class="content">


                <div class="product_section">

                     <? $this->load->view('elements/filter_box.tpl.php');?>

                 <div class="clear"></div>

                 <div id="deal_list">
												
                      <?=$display_homepage_listing?>

                 </div>

                       <? $this->load->view('common/social_box.tpl.php');?>

                </div>


                <div class="right_pan">

                    <? $this->load->view('elements/subscribe.tpl.php');?>

                    <? $this->load->view('elements/most_popular.tpl.php');?>

                    <? $this->load->view('elements/facebook_like_box.tpl.php');?>

                    <? $this->load->view('elements/latest_deal.tpl.php');?>

                    <? $this->load->view('elements/forum.tpl.php');?>

                    <? $this->load->view('common/ad.tpl.php');?>

                        <div class="clear"></div>

                </div>





                 <div class="clear"></div>

        </div>



</div>

	

