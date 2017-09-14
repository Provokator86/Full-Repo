 <?php
/*********
* Author: Koushik Rout
* Date  : 18 Nov 2011
* Modified By: 
* Modified Date: 
* 
* Purpose:
*  View For customer support  fe
*
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/fe/home/customer_support/
*/

?>
<script>
$(document).ready(function(){
    
    $("#txt_contact").numeric();
///////////Submitting the form/////////
$("#detail_form").submit(function(){    
    var b_valid=true;
    var s_err="";
    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	var reg_contact = /^(\+447\d{9})|(07\d{9})$/;
	
    var address = $.trim($("#txt_email").val());
    if($.trim($("#txt_subject").val())== '') 
    {
        s_err +='<div class="error_massage"><strong>Please fill in the Subject of your query or feedback.</strong></div>';
        b_valid=false;
    } 
    
    if($.trim($("#txt_fname").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please Provide your first name.</strong></div>';
        b_valid=false;
    }
    if($.trim($("#txt_lname").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please provide your last name.</strong></div>';
        b_valid=false;
    }
    /*if($.trim($("#txt_contact").val())== '')  
    {
        s_err +='<div class="error_massage"><strong>Please provide contact number.</strong></div>';
        b_valid=false;
    } */
	 if($.trim($("#txt_contact").val())!='' && reg_contact.test($.trim($("#txt_contact").val())) == false)
    {
        s_err +='<div class="error_massage"><strong>Please provide valid contact number.</strong></div>';
        b_valid=false;
        
    }
    if(address== '')
    {
        s_err +='<div class="error_massage"><strong>Please provide your email address.</strong></div>';
        b_valid=false;
    }
    else if(reg.test(address) == false)  
    {
        s_err +='<div class="error_massage"><strong>Please provide a valid email address.</strong></div>';
        b_valid=false;
    }        
    
    if($.trim($("#txt_msg").val())== '') 
    {
        s_err +='<div class="error_massage"><strong>Please provide your comments.</strong></div>';
        b_valid=false;
    }
      
    
    /////////validating//////
    if(!b_valid)
    {
       // $.unblockUI();  
        $("#div_err").html(s_err).show("slow");
    }
    
    return b_valid;
}); 


///////////end Submitting the form///////// 
    /*$('#btn_reg').click(function(){
        $("#form_buyer_reg").submit();
    }); */

});
</script>
 <div id="banner_section">
    <?php
    include_once(APPPATH."views/fe/common/header_top.tpl.php");
    ?>
</div>
<!-- /BANNER SECTION -->
<!-- SERVICES SECTION -->
    <?php
    //include_once(APPPATH."views/fe/common/common_search.tpl.php");
    ?>
<?php if(decrypt($loggedin['user_type_id'])==2){ ?>
           
	  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>

<?php } else if(decrypt($loggedin['user_type_id'])==1) { ?>

	  <?php include_once(APPPATH.'views/fe/common/common_buyer_search.tpl.php'); ?>

<?php } else {?>

	  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>

<?php } ?>
<!-- /SERVICES SECTION -->
<!-- CONTENT SECTION -->

<div id="content_section"> 
    <div id="content"> 
        <div id="inner_container02">
             <div class="title">
                <h3><span>Customer </span> Support</h3>
            </div>
            <div class="clr"></div>
            <div id="support_left">
                <p class="big_txt15"><?php echo $contents[0]['s_full_description'] ?> </p>
                <p>&nbsp;</p>
                 <?php /*?><?php $cnt=1; 
                  foreach($category as $key=>$val)
                  {                                           
                  ?>
                <div class="heading_box"><?php echo $key;?></div> 
                 <div class="text_box">      
                    <ul class="accordion">
                         <?php 
                        // pr($val['qus']);
                     foreach($val["qus"] as $key=>$value){ 
                     ?>
                        <li> <a href="javascript:void(0)" rel="accordion<?php echo $cnt;?>"><?php echo $value; ?></a>
                            <ul>
                                <li><?php echo $val["qus_ans"][$key]; ?></li>
                               
                            </ul>
                        </li>
                        <?php 
                         $cnt++;
                         } 
                         ?>
                    </ul>

                 </div> 
                  <?php
                  }
                  ?><?php */?>
                  <div class="clr"></div>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                 
                <h6>Please take a moment and fill the form out below.</h6>
            <div id="div_err">
             <?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>   
                     <?php
                        //show_msg("error");  
                        echo validation_errors();
                        //pr($posted);
                    ?>
             </div>
                <p style="text-align:right;"><span class="red_txt">*</span> Required field</p>
                <div id="form_box02">
                <form id="detail_form" action="" method="post"  >    
                    <div class="label01">What type of help do you have? <span class="red_txt">*</span> :</div>
                    <div class="field01">
                        <input type="text"  name="txt_subject" id="txt_subject" value="<?php echo $_POST["txt_subject"] ?>" size="48" />
                    </div>
                    <div class="clr"></div>
                    <div class="label01">First Name <span class="red_txt">*</span> :</div>
                    <div class="field01">
                        <input type="text" name="txt_fname" id="txt_fname" value="<?php echo $_POST["txt_fname"] ?>" size="48"/>
                    </div>
                    <div class="clr"></div>
                    <div class="label01">Last Name <span class="red_txt">*</span> :</div>
                    <div class="field01">
                        <input type="text" name="txt_lname" id="txt_lname" value="<?php echo $_POST["txt_lname"] ?>" size="48"/> 
                    </div>
                    <div class="clr"></div>
                    <div class="label01">Contact No  :</div>
                    <div class="field01">
                        <input type="text" name="txt_contact" id="txt_contact" value="<?php echo $_POST["txt_contact"] ?>" size="50"/>
                    	(Provide numbers only)
					</div>
                    <div class="clr"></div>
                    <div class="label01">Email Address <span class="red_txt">*</span> :</div>
                    <div class="field01">
                        <input type="text" name="txt_email" id="txt_email" value="<?php echo $_POST["txt_email"] ?>" size="50"/> 
                    </div>
                    <div class="clr"></div>
                    <div class="label01">Type your question/request here <span class="red_txt">*</span> :</div>
                    <div class="field01">
                        <textarea  name="txt_msg" id="txt_msg"  cols="" rows="6" ><?php echo $_POST["txt_msg"] ?></textarea>
                    </div>
                    <div class="clr"></div>
                    <div class="label01">&nbsp;</div>
                    <div class="field01">
                        <input type="submit" value="Submit" />   
                    </div>
                    <div class="clr"></div> 
                    </form> 
                    </div>
 
             </div>
            <div id="support_right">
                <div class="img_box"><img src="images/fe/img-10.jpg" alt="" width="355" height="418" /></div>
                <!--<div class="txt_box">
                    <p class="big_txt152">Customer Support</p>
                    <p class="big_txt15">24 hrs, 7 days a week, 365 days a year.</p>
                    <p>&nbsp;</p>
                    <p class="big_txt152">Phone: 800-845-8569 UK</p>
                    <p class="big_txt152">Email  : <a href="mailto:support@jobshoppa.com">support@jobshoppa.com</a></p>
                    <p class="big_txt152">Fax: 480.449.8820</p>
                </div>--> 
            </div>
         </div>
           <!-- /INNER CONTAINER02 --> 
        <div class="clr"></div>  
        </div>
             <!-- /CONTENT-->   
    <div class="clr"></div>             
 </div>
  <!-- /CONTENT SECTION -->       


