<script>
/*$(document).ready(function(){
	$('#btn_sub').click(function(){
		$('#frm_category').submit();
	});
	
}); */
</script>
<form name="frm_category" id="frm_category" method="post" action="<?php echo base_url().'job/find_job'?>">
<div id="service_section">
    <div id="service">
	
        <div class="field01" style="width:950px; text-align:center;">
            <input style="width:380px;" type="text" name="txt_fulltext_src" id="txt_fulltext_src" value="<?php echo ($posted['src_job_fulltext_src'])?$posted['src_job_fulltext_src']:'What Local Job do you need?'?>"  onfocus="if(this.value=='What Local Job do you need?')this.value='';" onblur="if(this.value=='')this.value='What Local Job do you need?';" /> <input type="image" src="images/fe/search_wht.png"  style="vertical-align:middle; margin-left:10px;"  onclick="javascript:void(0);"/>
        </div>
       <!-- <div class="field01">
            <input type="text" value="Category" onfocus="if(this.value=='Category')this.value='';" onblur="if(this.value=='')this.value='Category';" />
        </div>-->
        <!--<div class="field01">
            <input style="margin-left:40px;" type="Submit" value="Search"  id="btn_sub"  onclick="javascript:void(0);" />
        </div>-->
    </div>
</div>
</form>