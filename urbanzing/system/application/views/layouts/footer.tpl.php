<div id="footer_section">
    <div class="margin15"></div>
    <div class="footer_cont">
        <div class="footer_left">
            <div id="footer_menu">
                <?
                if($this->session->userdata('end_user_username')=='')
                {
                ?>
                <a href="<?=base_url()?>" <?=($this->menu_id==1)?'class="current"':''?>><?=WD('Home')?></a> |
                <a href="<?=base_url().'home/company'?>" <?=($this->menu_id==2)?'class="current"':''?>><?=WD('Company')?></a> |
                <a href="<?=base_url().'home/opportunity'?>" <?=($this->menu_id==3)?'class="current"':''?>><?=WD('Opportunity')?></a> | 
                <a href="<?=base_url().'user'?>" <?=($this->menu_id==4)?'class="current"':''?>>Join Now</a>| 
                <a href="<?=base_url().'home/business_plan'?>" <?=($this->menu_id==5)?'class="current"':''?>>Business Plan</a> |
                <a href="<?=base_url().'home/take_a_tour'?>" <?=($this->menu_id==6)?'class="current"':''?>>Take a tour</a> |
                <a href="<?=base_url().'home/testimonials'?>" <?=($this->menu_id==7)?'class="current"':''?>>Testimonials</a>|
                <a href="<?=base_url().'home/contact_us'?>" <?=($this->menu_id==8)?'class="current"':''?>>Contact us</a>
                <?
                }
                ?>
                      <p>Disclaimer . Privacy Policy . Spam Policy  . Terms of Use, Copyright © 2010 by FLTT, All Rights Reserved.</p>
                    </div>
            </div>
               <!--<div class="footer_right">
               	<p>Site designed by Acumen Consultancy Services</p>
               </div>-->
               <div class="clear"></div>
          </div>
     </div>