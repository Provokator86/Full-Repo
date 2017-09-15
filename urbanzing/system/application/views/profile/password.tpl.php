<div class="cont_part">
    <div class="margin10"></div>
    <!--Logged Panel-->
    <div class="logged_page" style="text-align: center;">
            <form id="frm_user" name="frm_user" method="post" action="<?=base_url().'profile/change_password'?>" onsubmit="ck_page();return false;">
            <h1>:: Welcome to FLTT. ::</h1>
            <div class="heading"><h5>Change password</h5></div>
             <div class="details" >
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="left"><span style="color: #8B0000;">*</span>&nbsp;Old password:</td>
                        <td align="left">
                            <input type="password" class="txt_cls" id="o_password" name="o_password" value=""/>
                        </td>
                    </tr>
                    <tr>
                      <td align="left"><span style="color: #8B0000;">*</span>&nbsp;New password:</td>
                        <td align="left">
                            <input type="password" class="txt_cls" id="password" name="password" value=""/>
                        </td>
                    </tr>
                    <tr>
                      <td align="left"><span style="color: #8B0000;">*</span>&nbsp;Confirm password:</td>
                        <td align="left">
                            <input type="password" class="txt_cls" id="c_password" name="c_password" value=""/>
                        </td>
                    </tr>
                  </table>
             </div>
            <div id="contact" style="margin: 10px;">
                <input name="change_id" type="submit" value="Submit" /> 
            </div>
            <script type="text/javascript">
                function ck_page()
                {
                    var cntrlArr    = new Array('o_password','password','c_password');
                    var cntrlMsg    = new Array('Please give the old password','Please give the new password','Please rewrite new password');
                    if(ck_blank(cntrlArr,cntrlMsg)==true)
                    {
                        cntrlArr    = new Array('password','c_password');
                        cntrlMsg    = new Array('Two new password does not match');
                        if(compareValue(cntrlArr,cntrlMsg)==true)
                            document.frm_user.submit();
                    }
                }
            </script>
            </form>

</div>

   <!--Logged Panel End-->
   <div class="clear"></div>
</div>

