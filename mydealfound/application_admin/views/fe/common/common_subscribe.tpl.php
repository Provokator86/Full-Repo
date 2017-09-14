<div class="subscribe" >
    <h2>Subscribe for<span>good deals</span></h2>
    <div id="msg"></div>
        <form name="newsletter_subscribe" id="newsletter_subscribe" method="post">
        <input type="text" value="Provide Your Email Address"  id="email_id" onclick="if(this.value=='Provide Your Email Address')this.value='';" onblur="if(this.value=='')this.value='Provide Your Email Address';"/>
        
        <input type="button" value="submit" onclick="subscribe('newsletter_subscribe')"/>
        </form>
    <div class="clear"></div>
</div>




<script>

function subscribe(frmid)
{
	var frm_data	= $('#'+frmid).serialize();
	var email_id= $('#email_id').val();
	if(email_id!='')
	{
			var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
				if(reg.test($.trim($("#email_id").val())) == false) 
					{
						$("#msg").html('<div class="error_massage">Please provide proper email</div>');	
					}
				else
					{		
					$.ajax({
							type: 'POST',
							url : '<?php echo base_url()?>home/newsletter_subscribe',
							data: 'email_id='+email_id,
							dataType: 'text',
							success: function(msg)
							{
								$("#msg").html(msg);
								$("#email_id").val("");
							}			
						});
					}
	}
	else
	{
		$("#msg").html('<div class="error_massage">Please provide your email</div>');
	}
}

</script>    
