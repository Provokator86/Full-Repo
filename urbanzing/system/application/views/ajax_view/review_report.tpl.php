<script type="text/javascript">
        function show_red(id)
        {
            for(var i=1;i<=id;i++)
                document.getElementById('img'+i).src='<?=base_url()?>images/front/rating_star.png';
        }

        function hied_red(id)
        {
            var select_now  = document.getElementById('rating').value;
            if((select_now*1)>0)
                id  = select_now;
            for(var i=5;i>id;i--)
                document.getElementById('img'+i).src='<?=base_url()?>images/front/rating_star03.png';
    //        if(id==1)
    //            document.getElementById('img1').src='rating_star03.png';
        }

        function fix_pointer(id)
        {
            document.getElementById('rating').value    = id;
        }
        
    $(document).ready(function() {
	$('form#ajax_report_review').ajaxForm({
//		dataType:  'script'
		beforeSubmit: report_review_before_ajaxform,
		success:      report_review_after_ajaxform
	});

	$('form#ajax_report_review').submit(function() {
		// inside event callbacks 'this' is the DOM element so we first
		// wrap it in a jQuery object and then invoke ajaxSubmit
		//$(this).ajaxSubmit();

		// !!! Important !!!
		// always return false to prevent standard browser submit and page navigation
		return false;
	});
});

function report_review_before_ajaxform()
{
    document.getElementById('tbl_msg').style.display    = 'none';
}

function report_review_after_ajaxform(responseText)
{
    if(responseText!='')
    {
        document.getElementById('tbl_msg').style.display    = 'block';
        document.getElementById('td_message').innerHTML     = responseText;
    }
    else
    {
        window.location.reload();
    }

}
</script>
<div class="sign_up" style="width: 375px;">
        <div class="margin15"></div>
        <div class="signup_left" style="border: 0px;">
        <form name="ajax_report_review" id="ajax_report_review" class="ajax_report_review" action="<?=base_url().'ajax_controller/ajax_report_review'?>" method="post">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
             <td colspan="2"><h5>Please give report this review. </h5></td>
             </tr>
             <tr>
                <td colspan="2">
                    <table id="tbl_msg" style="display: none;"  width="97%" cellspacing="0" cellpadding="5" border="0" class="msg_error">
                        <tr>
                            <td id="td_message" style="padding-left: 25px;"></td>
                        </tr>
                    </table>
                </td>
            </tr>
          <tr>
            <td align="right">Type: </td>
            <td>
                <select id="type" name="type">
                    <option value="I">Inaccurate</option>
                    <option value="O">Offensive</option>
					<option value="T">Other</option>
                </select>
            </td>
          </tr>
		  <tr>
            <td align="right">Comment: </td>
            <td>
                <input type="text" name="comment" id="comment" />
            </td>
          </tr>
          <!--<tr>
                <td align="right" width="180">Rating </td>
                <td height="30">
                    <img style="cursor: pointer;" onclick="fix_pointer('1');" onmouseover="show_red('1');" onmouseout="hied_red('1');" src="<?=base_url()?>images/front/rating_star03.png" id="img1" alt=""/>
                    <img style="cursor: pointer;" onclick="fix_pointer('2');" onmouseover="show_red('2');" onmouseout="hied_red('2');" src="<?=base_url()?>images/front/rating_star03.png" id="img2" alt=""/>
                    <img style="cursor: pointer;" onclick="fix_pointer('3');" onmouseover="show_red('3');" onmouseout="hied_red('3');" src="<?=base_url()?>images/front/rating_star03.png" id="img3" alt=""/>
                    <img style="cursor: pointer;" onclick="fix_pointer('4');" onmouseover="show_red('4');" onmouseout="hied_red('4');" src="<?=base_url()?>images/front/rating_star03.png" id="img4" alt=""/>
                    <img style="cursor: pointer;" onclick="fix_pointer('5');" onmouseover="show_red('5');" onmouseout="hied_red('5');" src="<?=base_url()?>images/front/rating_star03.png" id="img5" alt=""/>
                    <input type="hidden" name="rating" id="rating" value="0"/>
                </td>
            </tr>-->
          <tr>
            <td>&nbsp;</td>
            <td height="40">
                <input type="hidden" name="is_posted" value="1" />
                <input type="hidden" name="item_type" value="<?=$item_type?>" />
                <input type="hidden" name="item_id" value="<?=$item_id?>" />
                <input class="button_02" type="button" value="Submit >>" onclick="$('#ajax_report_review').submit();" /></td>
          </tr>
        </table>
        </form>
        </div>
   </div>