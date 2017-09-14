<?php
    $nav_menu = $nav_menu?$nav_menu:1;
?>
<div class="nav">
  <div class="nav-wrapper">
    <div class="navigation1">
        <ul>
            <li><a href="<?php echo base_url();?>" <?php if($nav_menu==1){ ?> class="active" <?php } ?>>HOME</a></li>
            <li><a href="<?php echo base_url('recent');?>" <?php if($nav_menu==2){ ?> class="active" <?php } ?>>NEW STUFF</a></li>
            <li><a href="<?php echo base_url('stores');?>" <?php if($nav_menu==3){ ?> class="active" <?php } ?>>TOP STORE</a></li>
            <li><a href="<?php echo base_url('brands');?>" <?php if($nav_menu==4){ ?> class="active" <?php } ?>>TOP BRAND</a></li>
            <li><a href="<?php echo base_url('people');?>" <?php if($nav_menu==5){ ?> class="active" <?php } ?>>TOP PEOPLE</a></li>
            <li><a href="<?php echo base_url('popular');?>" <?php if($nav_menu==6){ ?> class="active" <?php } ?>>POPULAR</a></li>
            <li><a href="<?php echo base_url('myfeed');?>" <?php if($nav_menu==7){ ?> class="active" <?php } ?>>MY FEED</a></li>
        </ul>
    </div>
    <div class="search">
        <form action="<?php base_url();?>shopby/all" >
          <input type="text" name="q" id="search-query" placeholder="Type Keyword" value="" autocomplete="off">
          <input type="submit" value="<?php if($this->lang->line('templates_go') != '') { echo stripslashes($this->lang->line('templates_go')); } else echo "Go"; ?>" class="search_btn" >
          
            <div class="feed-search" style="display: none;">
                <h4><?php if($this->lang->line('header_suggestions') != '') { echo stripslashes($this->lang->line('header_suggestions')); } else echo "Suggestions"; ?></h4>
                <div class="loading" style="display: block;"><i></i>
                <img class="loader" src="images/site/loading.gif">
                </div>
            </div>
        </form>
    </div>
  </div>
</div>    
