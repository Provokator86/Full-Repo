<?php
/*********
* Author: ACS
* Date  : 04 June 2014
* Modified By: 
* Modified Date:
* Purpose:
* Controller For manage travel category
* @package Travel
* @subpackage Manage Category
* @link InfController.php 
* @link My_Controller.php
* @link model/food_dining_model.php
* @link views/admin/food_dining_store/
*/
?>
<script type="text/javascript" language="javascript" >
$(document).ready(function(){


	$("input[name='txt_expiry_dt']").datepicker({dateFormat: 'yy-mm-dd',
												   changeYear: true,
												   changeMonth:true
												  });
	
	
	$("#tab_search").tabs({
	   cache: true,
	   collapsible: false,
	   fx: { "height": 'toggle', "duration": 500 },
	
	
	   show: function(clicked,show){ 
			$("#btn_submit").attr("search",$(show.tab).attr("id"));
			$("#tabbar ul li a").each(function(i){
			   $(this).attr("class","");
			});
	
			$(show.tab).attr("class","select");
	   }
	
	});


	$("#tab_search ul").each(function(i){
		$(this).removeClass("ui-widget-header");
		$("#tab_search").removeClass("ui-widget-content");
	});

//////////end Clicking the tabbed search/////     
/////////Submitting the form//////    

$("#btn_submit").click(function(){
    $.blockUI({ message: 'Just a moment please...' });
    var formid=$(this).attr("search");
    $("#frm_search_"+formid).attr("action","<?php echo $search_action;?>");
    $("#frm_search_"+formid).submit();
});                                              
/////////Submitting the form//////   

/////////clearing the form//////    
	
	$("#btn_clear").click(function(){
		var formid=$("#btn_submit").attr("search"); 
		//clear_form("#frm_search_"+formid);   
		$(':input',"#frm_search_"+formid)
	 .not(':button, :submit, :reset, :hidden')
	 .val('')
	 .removeAttr('checked')
	 .removeAttr('selected');
	
	});        


	function clear_form(formid)
	{
		///////Clearing input fields///
		$(formid).find("input")
	
		.each(function(m){
			switch($(this).attr("type"))
			{
	
				case "text":
					$(this).attr("value",""); 
				break;
	
				case "password":
					$(this).attr("value",""); 
				break;     
	
				case "radio":
					 $(this).find(":checked").attr("checked",false);
				break;    
	
				case "checkbox":
					 $(this).find(":checked").attr("checked",false);
				break;  
	
			}
		});
	
		///////Clearing select fields///
		$(formid).find("select")
		.each(function(m){
			$(this).find("option:selected").attr("selected",false); 
		}); 
		///////Clearing textarea fields///
	
		$(formid).find("textarea")
		.each(function(m){
			$(this).text(""); 
		});     
	
	}

/////////clearing the form////// 

///////////Submitting the form2/////////
$("#frm_search_2").submit(function(){

    var b_valid=true;
    var s_err="";
    $("#frm_search_2 #div_err_2").hide("slow"); 
    if(!b_valid)
    {
        $.unblockUI();  
        $("#frm_search_2 #div_err_2").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
    }
    return b_valid;
});    
///////////end Submitting the form2/////////

////////Submitting search all///
$("#btn_srchall").click(function(){
 $("#frm_search_3").submit();
});
////////end Submitting search all///

});

function hot_status_check(coupon_id)
{
	jQuery.ajax({
					type: "POST",
					url: "<?php echo base_url().'admin_panel/manage_coupon/get_coupon_hot_status/'?>",
					data: "current_coupon_id="+escape(coupon_id),
					success: function(status)
					{
						if(status==0)
						{
							alert('Inactive Deal cannot be check as Top Deal');
							location.reload();
						}
						else
						{
							var status=status.split('+');
							//alert(status[1]);	
							if(status[0]<20 )
							{
								if(status[1] ==1)
								{
									change_status(coupon_id,status[1]);
									alert ('The Deal is no more a TOP DEAL');
								}
								else
								{
									change_status(coupon_id, status[1]);
									alert('You have make this Deal as TOP DEAL');
								}

							}
							else
							{	
								if(status[1] ==1 && status[0]==20)
								{
									change_status(coupon_id, status[1]);
									alert ('The Deal is no more a TOP DEAL');
								}
								else{
								alert ('Maximum 12 Deal can be marked as TOP DEAL');
								location.reload();
								}

							}

						}

					} 

	});  // end ajax
}


function popular_status_check(coupon_id)
{

	jQuery.ajax({

            type: "POST",
            url: "<?php echo base_url().'admin_panel/manage_coupon/get_coupon_popular_status/'?>",
            data: "current_coupon_id="+escape(coupon_id),
            success: function(status)
            {
                if(status==0)
                {
                        alert('Inactive deal cannot be check as Popular Deal');
                        location.reload();
                }
                else
                {
                    var status=status.split('+');
                    //alert(status[1]);	
                    if(status[1] ==1)
					{
							change_popular_status(coupon_id,status[1]);
							alert ('The Deal is no more a POPULAR DEAL');

					}
					else
					{
							change_popular_status(coupon_id, status[1]);
							alert('You have make this deal as POPULAR DEAL');
					}

                }

            }

	});

	

}

function change_status(coupon_id, status)
{
	jQuery.ajax({
		type: "POST",
		url: "<?php echo base_url().'admin_panel/manage_coupon/change_hot_status/'?>",
		data: "current_coupon_id="+escape(coupon_id)+"&current_coupon_status="+status,
		success: function(response){
			//window.location.reload();
		}
	});
}

function change_popular_status(coupon_id, status)
{
	jQuery.ajax({
		type: "POST",
		url: "<?php echo base_url().'admin_panel/manage_coupon/change_popular_status/'?>",
		data: "current_coupon_id="+escape(coupon_id)+"&current_coupon_status="+status,
		success: function(response){
			//window.location.reload();
		}
	});
}

</script>

<div id="right_panel">
    <h2><?php echo $heading;?></h2>
	<div class="info_box">From here Admin can manage the travel list.</div>
	<div class="clr"></div>
    <div id="tab_search">
    <div id="tabbar">
      <ul><?php //javascript:void(0)?>
        <?php /*?><li id="test"><a href="#div1" <?php echo ($h_search=="basic"?'class="select"':'') ?> id="1"><span>Basic Search</span></a></li><?php */?>
        <li><a href="#div2" <?php echo ($h_search=="advanced"?'class="select"':'') ?> id="2"><span>Search</span></a></li>
      </ul> 
    </div>
    <div id="tabcontent">
      <div id="div2" <?php //echo ($h_search=="advanced"?"":'style="display: none;"') ?> >
      <form id="frm_search_2" name="frm_search_2" method="post" action="" >
        <input type="hidden" id="h_search" name="h_search" value="basic" />
        <div id="div_err_2"></div>     
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="15%">Travel Name: </td>
            <td width="10%">
            <input id="s_coupon" name="s_coupon" value="<?php echo $s_coupon;?>" type="text" size="28" />
            </td>
            <td width="15%">Status: </td>
            <td width="10%">
            <select name="s_is_active">
            		<option value="">select</option>
            		<option value="1" <?php if($s_is_active=='1') echo 'selected=selected'?>>Active</option>
            		<option value="0" <?php if($s_is_active.'a'=='0a') echo 'selected=selected'?>>Inactive</option>
            </select>
            </td>
            <td colspan="4">
            </td>
          </tr>

          <tr>
          
            <td>Store</td>
            <td><!--<input type="text" name="s_store" id="s_store" size="28" value="<?php echo $s_store;?>"/>-->
			<select name="s_store" id="s_store">
			<option value="">Select</option>
			<?php echo makeOptionNoEncrypt($store,$s_store);?>
			</select>
			</td>
			<td>Expiry date</td>
            <td><input type="text" name="txt_expiry_dt" id="txt_expiry_dt" size="28" value="<?php echo $txt_expiry_dt;?>"/></td>
          </tr>

		  <?php /*?><tr>
		  		<td>Category</td>
            <td><input type="text" name="s_category" id="s_category" size="28" value="<?php echo $s_category;?>"/></td>
          	<td>Expiry date</td>
            <td><input type="text" name="txt_expiry_dt" id="txt_expiry_dt" size="28" value="<?php echo $txt_expiry_dt;?>"/></td>
          </tr><?php */?>

        </table>
      </form>  
      </div>
      <form id="frm_search_3" name="frm_search_3" method="post" action="<?php echo $search_action;?>"><input type="hidden" id="h_search" name="h_search" value=""></form>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="search_button">
        <tr>
          <td width="250">
          <input id="btn_submit" name="btn_submit" type="button" value="Search" title="Click to search information." search="<?php echo ($h_search!="advanced"?1:2); ?>"/>&nbsp;<input id="btn_clear" name="btn_clear" type="reset" value="Clear" title="Clear all values within the fields." />&nbsp;<input id="btn_srchall" name="btn_srchall" type="submit" value="Show all" title="Show all information." />
          </td>  
        </tr>
      </table>  

      <?php /*?><table width="100%" border="0" cellspacing="0" cellpadding="0" class="search_button">

        <tr>
          <td width="250">
          <form action="<?php echo admin_base_url().'manage_coupon/upload_csv'; ?>" name="upload_csv" id="upload_csv" enctype="multipart/form-data" method="post">
          <input type="file" name="csv_file" id="csv_file" />
          <input id="btn_csv" name="btn_csv" type="submit" value="Upload CSV" />
          </form>
          </td>  
        </tr>
      </table><?php */?> 

    </div>
    </div>
    <?php
    echo $table_view;
    ?>
  </div>