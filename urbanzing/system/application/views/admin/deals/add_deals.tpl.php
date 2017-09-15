<table id="tbl_content_area" width="100%" border="0" cellspacing="0" cellpadding="5">
    
	<tr><td height="1px"></td></tr>
	<tr>
      <td align="left" valign="middle" bgcolor="#FFFFFF" style="border:1px dotted #999999;" height="100%">
      
	  	 <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
		  <tr>
		  	<td style="border-right:1px dotted #999999; width:25%; background:#F3F3F3;" valign="top" align="left">
			   <?php $this->load->view('admin/common/menu_deals.tpl.php');	?>
			</td>
			<td style="width:75%;" valign="top" align="center">
				<?php
				$this->load->view('admin/common/message_page.tpl.php'); 
				?>
				<table width="90%" border="0" cellspacing="0" cellpadding="0" style="margin-top:40px;">
					  <tr>
						<td width="110" class="td_tab_main" align="center" valign="middle"><?=$table_title?></td>
						<td>&nbsp;</td>
					  </tr>
				</table>
			    <table width="90%" border="0" cellspacing="0" cellpadding="10" style="border:1px solid #999999;">
					  <tr>
						<td align="center" valign="middle">
        <form id="frm_deals" name="frm_deals" method="post" action="<?=base_url().'admin/deals/insert_deals'?>" enctype="multipart/form-data">
                            
                            
<table width="100%" border="0" cellspacing="0" cellpadding="7">
    <tr>
        <td width="140" align="right" valign="middle" class="field_title">
        <span style="color:#8B0000;">*</span>&nbsp;<strong>Headline : </strong>
        </td>
        <td align="left" valign="middle">
        <input id="headline" name="headline" type="text" class="textfield" style="width:200px;" value="" />
        </td>
    </tr>
    <tr>
    <td width="140" valign="middle" align="right" class="field_title">
    <span style="color: rgb(139, 0, 0);">*</span>&nbsp;<strong>Type : </strong>
    </td>
    <td valign="middle" align="left">

    <input type="radio" checked="checked" value="1" name="type" onclick="showWebUrl()" /> Online
    <input type="radio" value="0" name="type" onclick="showAddTabs()" /> Offline
    
    <input type="hidden" name="hdn_type" id="hdn_type" value="1" /> 
    </td>
    </tr> 
      
    <tr class="offline">
        <td align="right"><span style="color:#8B0000;">*</span>&nbsp;<strong>Country :</strong></td>
        <td>
            <select id="country_id" name="country_id" onchange="fun_country(this.value);">
                <?=$country_option?>
            </select>        </td>
      </tr>
    <tr class="offline">
    <td align="right"><span style="color:#8B0000;">*</span>&nbsp;<strong>State :</strong></td>
    <td>
        <div id="div_state">
            <select id="state_id" name="state_id" onchange="fun_state(this.value);">
                <option value="">Select a state</option>
                <?=$state_option?>
            </select>
        </div>        
    </td>
    </tr>
    <tr class="offline">
    <td  align="right"><span style="color:#8B0000;">*</span>&nbsp;<strong>City :</strong></td>
    <td>
        <div id="div_city">
            <select id="city_id" name="city_id" onchange="fun_city(this.value);">
                <option value="">Select a city</option>
                <?=$city_option?>
            </select>
        </div>        
    </td>
    </tr>
    <tr class="offline">
    <td  align="right"><span style="color:#8B0000;">*</span>&nbsp;<strong>Street Address :</strong></td>
    <td align="left" valign="middle">
        <input id="street" name="street" type="text" class="textfield" style="width:200px;" value="" />
    </td>
    </tr>
    <tr class="offline">
    <td align="right"><span style="color:#8B0000;">*</span>&nbsp;<strong>Pincode :</strong></td>
    <td>
        <div id="div_zipcode">
            <select id="zipcode" name="zipcode">
                <option value="">Select a pincode</option>
                <?=$zipcode_option?>
            </select>
        </div>        
    </td>
    </tr>
    
    <tr class="online">
    <td width="140" align="right" valign="middle" class="field_title"><strong>Website Url : </strong></td>
    <td align="left" valign="middle">
    <input id="website_url" name="website_url" type="text" class="textfield" style="width:200px;" value="" /></td>
    </tr>
    
    <tr>
    <td width="140" align="right" valign="middle" class="field_title"><strong>Phone no. : </strong></td>
    <td align="left" valign="middle">
    <input id="phone_no" name="phone_no" type="text" class="textfield" style="width:200px;" value="" /></td>
    </tr>
    
    <tr>
    <td width="140" align="right" valign="middle" class="field_title"><strong>Big Picture Url : </strong></td>
    <td align="left" valign="middle">
    <input id="big_image_url" name="big_image_url" type="text" class="textfield" style="width:200px;" value="" /></td>
    </tr>
    <tr>
    <td width="140" align="right" valign="middle" class="field_title"><strong>Small Picture Url : </strong></td>
    <td align="left" valign="middle">
    <input id="small_image_url" name="small_image_url" type="text" class="textfield" style="width:200px;" value="" /></td>
    </tr>
    <tr>
    <td width="140" align="right" valign="middle" class="field_title"><strong>Source Name : </strong></td>
    <td align="left" valign="middle">
    <input id="source_name" name="source_name" type="text" class="textfield" style="width:200px;" value="" /></td>
    </tr>
    <tr>
    <td width="140" align="right" valign="middle" class="field_title"><span style="color:#8B0000;">*</span>&nbsp;<strong>Category : </strong></td>
    <td align="left" valign="middle">
    <select id="category_id" name="category_id">
    <option value="">Select a category</option>
    <?php  echo $category_option?>
    </select>
    </td>
    </tr>
    <tr>
    <td width="140" align="right" valign="top" class="field_title"><strong>Deal Description : </strong></td>
    <td align="left" valign="middle">
    <textarea id="description" name="description" cols="10" rows="10"></textarea>
    </td>
    </tr>
    <tr>
    <td width="140" align="right" valign="top" class="field_title"><strong>Fine Prints : </strong></td>
    <td align="left" valign="middle">
    <textarea id="description" name="fine_prints" cols="10" rows="10"></textarea>
    </td>
    </tr>
    <tr>
        <td width="140" align="right" valign="middle" class="field_title">
        <strong>Start Date : </strong></td>
        <td class="rm_sel" style="padding:0px; vertical-align: middle;">
            <div style="width:200px;float: left;" >
                <?=$start_date?>
            </div>
            
                <select name="start_hour" style="width:50px;">
                    <?=$hour_option?>
                </select>  
                <span>Hr</span> &nbsp;&nbsp;
                <select name="start_min" style="width:50px;">
                    <?=$min_option?>
                </select> 
                <span>Min</span>
            
        </td>
    </tr>
    <tr>
        <td width="140" align="right" valign="middle" class="field_title">
        <strong>End Date : </strong></td>
        <td class="rm_sel" style="padding:0px; vertical-align: middle;">
            <div style="width:200px; float: left;">
                <?=$end_date?>
            </div>
            
                <select name="end_hour" style="width:50px;">
                    <?=$hour_option?>
                </select>  
                <span>Hr</span> &nbsp;&nbsp;
                <select name="end_min" style="width:50px;">
                    <?=$min_option?>
                </select> 
                <span>Min</span>
            
        </td>
    </tr>
    <tr>
    <td width="140" align="right" valign="middle" class="field_title"><strong>Link for purchasing the deal : </strong></td>
    <td align="left" valign="middle">
    <input id="title" name="purchase_link" type="text" class="textfield" style="width:200px;" value="" />
    </td>
    </tr>	
    <tr>
    <td width="140" align="right" valign="middle" class="field_title"><strong>Actual Price : </strong></td>
    <td align="left" valign="middle">
    <input id="title" name="actual_price" type="text" class="textfield" style="width:200px;" value="" /></td>
    </tr>		
    <tr>
    <td width="140" align="right" valign="middle" class="field_title"><strong>Offer Price : </strong></td>
    <td align="left" valign="middle">
    <input id="title" name="offer_price" type="text" class="textfield" style="width:200px;" value="" /></td>
    </tr>  
    <tr>
    <td width="140" valign="middle" align="right" class="field_title">
    <span style="color: rgb(139, 0, 0);">*</span>&nbsp;<strong>Status : </strong>
    </td>
    <td valign="middle" align="left">

    <input type="radio" checked="checked" value="1" name="status"> Active
    <input type="radio" value="0" name="status"> Inactive

    </td>
    </tr>  		    							
</table>
                            
<table width="100%" border="0" cellspacing="0" cellpadding="7">
    <tr>
    <td width="140" align="right" valign="middle">&nbsp;</td>
    <td width="80" align="left" valign="middle">
    <input name="change_id" type="button" class="button" value="Submit" onclick="ck_page()" /></td>
    <td align="left" valign="middle">
    <input name="reset1" type="reset" class="button" value="Back" onclick="window.location.href='<?=base_url().'admin/deals'?>';" /></td>
    </tr>
</table>
                            
<script type="text/javascript">
function ck_page()
{
    var flag = 1;
    
    var cntrlArr1   = new Array('headline');
    var cntrlMsg1   = new Array('Please enter a headline');
    if(ck_blank(cntrlArr1,cntrlMsg1)!=true)
        flag = 0;
        
    if(flag && $('#hdn_type').val()==1)
    {
        var cntrlArr2   = new Array('website_url');
        var cntrlMsg2   = new Array('Please enter a website url');
        if(ck_blank(cntrlArr2,cntrlMsg2)!=true)
        flag = 0;
    }
    else
    {
        var cntrlArr2    = new Array('country_id', 'state_id', 'city_id', 'street', 'zipcode');
        var cntrlMsg2   = new Array('Please select a country', 'Please select a state','Please select a city', 'Please enter a street address', 'Please select a pincode');
        if(ck_blank(cntrlArr2,cntrlMsg2)!=true)
        flag = 0;
    }
    
    if(flag)
    {
        var cntrlArr1   = new Array('category_id');
        var cntrlMsg1   = new Array('Please select a category');
        if(ck_blank(cntrlArr1,cntrlMsg1)!=true)
        flag = 0;
    }
    
        
        
        
    if(flag)
        document.frm_deals.submit();
}
</script>
                             
						  </form>
						</td>
					  </tr>
				</table>
			</td>
		  </tr>
		 </table>
         
	  </td>
    </tr>
	<tr><td height="1px;"></td></tr>
  </table>
  
  <script type="text/javascript">
            function fun_country(cat)
            {
                get_ajax_option_common('<?=base_url().'business/get_state_ajax'?>',cat,'div_state');
                get_ajax_option_common('<?=base_url().'business/get_city_ajax'?>',-1,'div_city');
                get_ajax_option_common('<?=base_url().'business/get_zipcode_ajax'?>',-1,'div_zipcode');
                get_ajax_option_common('<?=base_url().'business/get_price_ajax'?>',cat,'div_price');

            }

            function fun_state(cat)
            {
                get_ajax_option_common('<?=base_url().'business/get_city_ajax'?>',cat,'div_city');
                get_ajax_option_common('<?=base_url().'business/get_zipcode_ajax'?>',-1,'div_zipcode');
            }

            function fun_city(cat)
            {
                get_ajax_option_common('<?=base_url().'business/get_zipcode_ajax'?>',cat,'div_zipcode');
            }
            
            /**
            * added by Arnab Chattopadhyay
            * @date: 04-05-2011
            */
            $(function(){
                $('.offline').css('display', 'none');
            });
            function showWebUrl()
            {
                $('.online').fadeIn('slow');
                $('.offline').fadeOut();
                $('#hdn_type').val(1);
                
                $('#country_id').val('');
                $('#state_id').val('');
                $('#city_id').val('');
                $('#street').val('');
                $('#zipcode').val('');
            }
            function showAddTabs()
            {
                $('.online').fadeOut();
                $('.offline').fadeIn('slow');
                $('#hdn_type').val(0);
                
                $('#website_url').val('');
            }
        </script>