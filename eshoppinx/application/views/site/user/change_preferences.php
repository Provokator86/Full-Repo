<?php
$this->load->view('site/templates/header');
?>
    
    <!-- Section_start -->
    <div id="mid-panel">
        <div class="wrapper">       
            <div class="container set_area" style="padding:30px 0 20px">   
                
                <?php if($flash_data != '') { ?>
		        <div class="errorContainer" id="<?php echo $flash_data_type;?>">
			        <script>setTimeout("hideErrDiv('<?php echo $flash_data_type;?>')", 3000);</script>
			        <p><span><?php echo $flash_data;?></span></p>
		        </div>
                <div class="clear"></div>
		        <?php } ?>	
        
                <?php $this->load->view('site/user/user_sidebar_menu'); ?> 
                
                <div id="content">
		    <h2 class="ptit"><?php if($this->lang->line('prference_edit') != '') { echo stripslashes($this->lang->line('prference_edit')); } else echo "Edit Preferences"; ?></h2>
		    <div style="display:none" class="notification-bar"></div>
  		    <form method="post" action="site/user_settings/update_preferences" class="myform">

    <!-- 		<div class="section localization">
			    <h3 class="stit"><?php if($this->lang->line('prference_localization') != '') { echo stripslashes($this->lang->line('prference_localization')); } else echo "Localization"; ?></h3>
			    <fieldset class="frm">
				    <label><?php if($this->lang->line('prference_language') != '') { echo stripslashes($this->lang->line('prference_language')); } else echo "Language"; ?></label>				
				    <select data-langcode="en" id="lang" name="language">
				    <?php 
                    $selectedLangCode = $userDetails->row()->language;
                    if ($selectedLangCode == ''){
                	    $selectedLangCode = 'en';
                    }
                    if (count($activeLgs)>0){
                	    foreach ($activeLgs as $activeLgsRow){
                    ?>	
					    <option value="<?php echo $activeLgsRow['lang_code'];?>" <?php if ($selectedLangCode == $activeLgsRow['lang_code']){echo 'selected="selected"';}?>><?php echo $activeLgsRow['name'];?></option>
				    <?php 
                	    }
                    }
				    ?>	
				    <?php 
    /*				if ($languages->num_rows()>0){
					    foreach ($languages->result() as $row){
						    if ($row->name != ''){
				    ?>
				    <option <?php if ($userDetails->row()->language == $row->id){echo 'selected="selected"';}?> value="<?php echo $row->id;?>"><?php echo $row->name;?></option>
				    <?php 
						    }
					    }
				    }
    */				?>
				    
				    </select>
				    <small class="comment"><?php if($this->lang->line('prference_lang_not') != '') { echo stripslashes($this->lang->line('prference_lang_not')); } else echo "Can't find your language on"; ?> <?php echo $siteTitle;?>? <a href="mailto:<?php echo $siteContactMail;?>"><?php if($this->lang->line('prference_letus') != '') { echo stripslashes($this->lang->line('prference_letus')); } else echo "Let us know"; ?></a>.</small>
			    </fieldset>
		    </div>
     -->		<div class="section privacy">
			    <h3 class="stit"><?php if($this->lang->line('prference_privacy') != '') { echo stripslashes($this->lang->line('prference_privacy')); } else echo "Privacy"; ?></h3>
			    <fieldset class="frm">
				    <label><?php if($this->lang->line('prference_prof_visible') != '') { echo stripslashes($this->lang->line('prference_prof_visible')); } else echo "Profile visibility"; ?></label>
				    <span class="description"><?php if($this->lang->line('prference_mange_acti') != '') { echo stripslashes($this->lang->line('prference_mange_acti')); } else echo "Manage who can see your activity, things you"; ?> <?php echo LIKE_BUTTON;?>, <?php if($this->lang->line('prference_search_res') != '') { echo stripslashes($this->lang->line('prference_search_res')); } else echo "your followers, people you follow or in anyone's search results."; ?></span>
				    <input type="radio" <?php if ($userDetails->row()->visibility == "Everyone"){echo 'checked="checked"';}?> value="Everyone" id="visibility1" name="visibility">
				    <label class="label" for="visibility1"><?php if($this->lang->line('prference_everyone') != '') { echo stripslashes($this->lang->line('prference_everyone')); } else echo "Everyone"; ?></label>
				    <input type="radio" <?php if ($userDetails->row()->visibility == "Only you"){echo 'checked="checked"';}?> value="Only you" id="visibility2" name="visibility">
				    <label class="label" for="visibility2"><i class="ic-lock"></i> <?php if($this->lang->line('prference_onlyu') != '') { echo stripslashes($this->lang->line('prference_onlyu')); } else echo "Only you"; ?></label>
			    </fieldset>
		    </div>
    <!-- 		<div class="section content">
			    <h3 class="stit"><?php if($this->lang->line('prference_content') != '') { echo stripslashes($this->lang->line('prference_content')); } else echo "Content"; ?></h3>
			    <fieldset class="frm">
				    <label><?php if($this->lang->line('prference_disp_list') != '') { echo stripslashes($this->lang->line('prference_disp_list')); } else echo "Display lists"; ?></label>
				    <span class="description"><?php if($this->lang->line('prference_show_list') != '') { echo stripslashes($this->lang->line('prference_show_list')); } else echo "Show list options for organizing your things when you"; ?> <?php echo LIKE_BUTTON;?> <?php if($this->lang->line('prference_something') != '') { echo stripslashes($this->lang->line('prference_something')); } else echo "something."; ?></span>
				    <input type="radio" <?php if ($userDetails->row()->display_lists == "Yes"){echo 'checked="checked"';}?> value="Yes" id="display1" name="display_lists">
				    <label class="label" for="engines1"><?php if($this->lang->line('prference_yes') != '') { echo stripslashes($this->lang->line('prference_yes')); } else echo "Yes"; ?></label>
				    <input type="radio" <?php if ($userDetails->row()->display_lists == "No"){echo 'checked="checked"';}?> value="No" id="display2" name="display_lists">
				    <label class="label" for="engines2"><?php if($this->lang->line('prference_no') != '') { echo stripslashes($this->lang->line('prference_no')); } else echo "No"; ?></label>
			    </fieldset>
		    </div>
     -->		<div class="btn-area">
			    <button id="save_preferences" class="btn-save"><?php if($this->lang->line('prference_save_prefer') != '') { echo stripslashes($this->lang->line('prference_save_prefer')); } else echo "Save Preferences"; ?></button>
			    <span style="display:none" class="checking"><i class="ic-loading"></i></span>
		    </div>
		    </form>
	    </div>

		
        	 </div>   
        </div>
    </div>
    <div class="clear"></div>
    <!-- Section_end -->
		
<?php $this->load->view('site/templates/footer');?>