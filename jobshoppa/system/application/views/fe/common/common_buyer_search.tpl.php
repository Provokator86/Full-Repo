<script>
/*$(document).ready(function(){
	$('#btn_sub').click(function(){
		$('#frm_category').submit();
	});
	
}); */
</script>
<form name="frm_category" id="frm_category" method="post" action="<?php echo base_url().'find_tradesman'?>"><div id="service_section">
    <div id="service">
        <div class="field01" style="width:950px; text-align:center;">
            <input style="width:380px;" type="text" name="txt_fulltext_src" id="txt_fulltext_src" value="<?php echo ($posted['src_tradesman_fulltext_src'])?$posted['src_tradesman_fulltext_src']:'What local service do you need?'?>" onfocus="if(this.value=='What local service do you need?')this.value='';" onblur="if(this.value=='')this.value='What local service do you need?';" /><input type="image" src="images/fe/search_wht.png"  style="vertical-align:middle; margin-left:10px;"  onclick="javascript:void(0);"/>
        </div>
       <!-- <div class="field01">
            <input type="text" value="Category" onfocus="if(this.value=='Category')this.value='';" onblur="if(this.value=='')this.value='Category';" />
        </div>-->
       <!-- <div class="field01">
            <input style="margin-left:40px;" type="submit" id="btn_sub" value="Search"  onclick="javascript:void(0);"/>
			
        </div>-->
    </div>
</div>
</form>