<?php
/*********
* Author: Koushik
* Date  : 17 July 2012
* Modified By:
* Modified Date: 
* 
* It is a tpl for the booking and payment
* one can provide number of guest and guest name
* also card detail it take to payment page for the booking done. 
* 
* @view fe/account/booking_details.php
* @controller account.php
*/
?>
<script language="javascript" type="text/javascript" src="js/jquery/ui/jquery-ui-1.8.4.custom.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    
     $( "#txt_expire_date" ).datepicker({
            dateFormat: 'dd-mm-yy',
            changeYear: true,
            changeMonth: true
        });
        
        $('#ui-datepicker-div').hide();   // to hide the ui-datepicker-div     
        
    
    
    
    var total_guest =   0 ;
    $("#opt_total_guest_child a").click(function(){
           var  total_guest_tmp  =   $("#opt_total_guest").val();
           
           if(total_guest_tmp==0)
           {
               $("#parent_guest_name .guest_name").remove();
           }
           else if(total_guest<total_guest_tmp)
           {
                for(var i=0;i<(total_guest_tmp - total_guest);i++)
               {
                   $("#parent_guest_name").append('<div class="guest_name"><label class="text">Name</label><div class="text-box02"><input name="txt_guest_name[]" type="text"  value=""/></div><br class="spacer" /></div>') ;
                   
               }
               
               
               
           }
           else if(total_guest>total_guest_tmp)
           {
               $("#parent_guest_name .guest_name").filter(":gt("+(total_guest_tmp-1)+")").remove();
               
           }
           total_guest  =   total_guest_tmp ;

    });
    
    $("#btn_payment").click(function(){
      
        var b_valid =   true;
        
        var name_field  =   true;       
        $("#parent_guest_name .guest_name").each(function(i){
            if($(this).find('input').val()!='')
            {
                name_field  =   false ;
            }
            
        });
        
        
        if($("#opt_total_guest").val()==0)
        {
            $("#opt_total_guest").parent().next().next(".err").html('<strong>Please select total number guest.</strong>').slideDown('slow');
            b_valid =   false;
            
        }
        else if(name_field)
        {
             $("#opt_total_guest").parent().next().next(".err").html('<strong>Please provide guest name.</strong>').slideDown('slow');
            b_valid =   false;
            
        }
        else
        {
            $("#opt_total_guest").parent().next().next(".err").slideUp('slow').html('');
        }
        
        
       /* 
       // THIS CODE IS FOR PAYPAL PRO
       if($.trim($("#txt_card_number").val())=="") 
        {               
            $("#txt_card_number").parent().next().next(".err").html('<strong>Please provide Card number .</strong>').slideDown('slow');
            b_valid  =  false;
        }
        else
        {
            $("#txt_card_number").parent().next().next(".err").slideUp('slow').html('');
        }
        if($.trim($("#txt_expire_date").val())=="") 
        {               
            $("#txt_expire_date").parent().next().next(".err").html('<strong>Please provide expire date .</strong>').slideDown('slow');
            b_valid  =  false;
        }
        else
        {
            $("#txt_expire_date").parent().next().next(".err").slideUp('slow').html('');
        }
        if($.trim($("#txt_cvv_number").val())=="") 
        {               
            $("#txt_cvv_number").parent().next().next(".err").html('<strong>Please provide cvv number .</strong>').slideDown('slow');
            b_valid  =  false;
        }
        else
        {
            $("#txt_cvv_number").parent().next().next(".err").slideUp('slow').html('');
        }*/
        if(b_valid)
        {
            $("#frm_payment").submit();
            
        }
        
        
    });
    
});
</script>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="container-box">
<?php include_once(APPPATH."views/fe/common/message.tpl.php"); ?>
<?php include_once(APPPATH."views/fe/common/account_left_menu.tpl.php"); ?>
    <div class="right-part02">
      <div class="text-container">
        <div class="inner-box03">
          <div class="page-name02">Provide Booking Details</div>
          <div class="spacer">&nbsp;</div>
              
              <div class="quick-overview-box">
              <form action="" method="post" id="frm_payment" name="frm_payment">
              <!--<input type="hidden" name="h_property_id" value="<?php echo $h_property_id; ?>"/> -->  
              <div class="green-bar">Guest Details</div>
                    <div class="form-left-box">
                    <label class="text">Total Guest</label>
                    <select name="opt_total_guest" id="opt_total_guest" style="width:273px;">
                    <option value="0">Select Total Guest</option>
                    <?php echo makeOptionNoEncrypt($arr_guest); ?>
                    </select>
                    <div class="err"></div>
                     <br class="spacer" />
                 <div id="parent_guest_name">   
                 
                  </div>
              </div>
                    <!--End of form-left-box-->
              <!--<div class="spacer">&nbsp;</div>   
              <div class="green-bar">Payment Details</div>
                    <div class="form-left-box">
                       
                        <label class="text">Card Number</label>
                        <div class="text-box02">
                        <input name="txt_card_number" id="txt_card_number" type="text"  value=""/>
                        </div>
                         <br class="spacer" />
                         <div class="err"></div>
                         <div class="spacer"></div>    
                      
                        
                        <label class="text">Expire date</label>
                        <div class="text-box02">
                        <input name="txt_expire_date" id="txt_expire_date" type="text" readonly="readonly"  value=""/>
                        </div>
                         <br class="spacer" />
                         <div class="err"></div>
                         <div class="spacer"></div> 
                        
                        <label class="text">cvv Number</label>
                        <div class="text-box02">
                        <input name="txt_cvv_number" id="txt_cvv_number" type="text"  value=""/>
                        </div>
                         <br class="spacer" />
                         <div class="err"></div>
                         <div class="spacer"></div> 

                    </div> -->
                   
              <div class="spacer">&nbsp;</div>         
              <input  class="button-blu" type="button" value="Pay Now" id="btn_payment"/>
              <div class="spacer">&nbsp;</div>
              <p>You will be redirected to Paypal's website for Payment</p>        
              </form>
                   
              </div>
              
              <!--End of quick-overview-box-->
           
              <div class="spacer">&nbsp;</div>
        </div>
      </div>
    </div>
    <br class="spacer" />
</div>