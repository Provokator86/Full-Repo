<?php 
if(isset($productDetails) && $this->uri->segment(1) == 'things'){
?>
<div style='display:none'>

  	<div id='contact_seller_popup' class="contact_frm" style='background:#fff;'>
    
    	<div class="popup_page">
        
            <div class="" style="border-right:none; text-align:center; padding:10px 10px 15px 10px">
            
            <ul class="popup_login_box">
        	<li>
            	<label style="font-weight: bold;"><?php if($this->lang->line('product_questions') != '') { echo stripslashes($this->lang->line('product_questions')); } else echo "Question"; ?><font color="red">*</font></label>
				<textarea name="question" id="question" style="width:92%;"></textarea>
                <span id="div_question" style="width: 100%;float: left;position: relative;bottom: 10px;color: red;"></span>
			</li>
            <li>
            	<ul>
                <li style="margin-bottom: 10px;">
                    <label style="font-weight: bold;width: 120px;float: left;"><?php if($this->lang->line('signup_full_name') != '') { echo stripslashes($this->lang->line('signup_full_name')); } else echo "Name"; ?><font color="red">*</font></label>
                    <input type="text" style="width: 67%;float: left;" name="name" class="fullname" <?php if ($loginCheck != ''){?>value="<?php if ($userDetails->row()->full_name != ''){echo $userDetails->row()->full_name;}else {echo $userDetails->row()->user_name;}?>"<?php }?> id="name" />
                     <span id="div_name" style="width: 100%;float: left;position: relative;bottom: 5px;color: red;"></span>
                </li>
                <li style="margin-bottom: 10px;">
                	<label style="font-weight: bold;width: 120px;float: left;"><?php if($this->lang->line('signup_emailaddrs') != '') { echo stripslashes($this->lang->line('signup_emailaddrs')); } else echo "Email Address"; ?><font color="red">*</font></label>
                    <input type="text" style="width: 67%;float: left;" name="emailaddress" class="email" <?php if ($loginCheck!=''){?>value="<?php echo $userDetails->row()->email;?>"<?php }?> id="emailaddress" />
                     <span id="div_emailaddress" style="width: 100%;float: left;position: relative;bottom: 5px;color: red;"></span>
				</li>
               
			
            <li style="margin-bottom: 10px;">
            		<label style="font-weight: bold;width: 120px;float: left;"><?php if($this->lang->line('checkout_phone_no') != '') { echo stripslashes($this->lang->line('checkout_phone_no')); } else echo "Phone No"; ?></label>
                    <input type="text" style="width: 67%;float: left;" name="phoneNumber" class="phoneNumber" id="phoneNumber" />
                    <span id="div_phoneNumber" style="width: 100%;float: left;position: relative;bottom: 10px;color: red;"></span>
            </li>
             </ul>
             </li>
            <li style="float: left;width: 100%;text-align: center;margin-top: 10px;">
            <input type="hidden" name="selleremail" id="selleremail" value="<?php echo $productDetails->row()->selleremail; ?>" />
            <input type="hidden" name="productId" id="productId" value="<?php echo $productDetails->row()->id;?>">
            <input type="hidden" name="sellerid" id="sellerid" value="<?php echo $productDetails->row()->sellerid; ?>" />
				<button class="start_btn_1" style="width: 150px;" onclick="javascript:ContactSeller();" from_popup="true" ><?php if($this->lang->line('product_submit') != '') { echo stripslashes($this->lang->line('product_submit')); } else echo "Submit"; ?></button>
                <div id="loadingImgContact" style="display:none;"><img src="images/loading.gif" alt="Loading..." /></div>
            </li>
            </ul>
            
            
            
            </div>
            
        
        </div>
        
        
    </div>
    
</div>
<?php }?>