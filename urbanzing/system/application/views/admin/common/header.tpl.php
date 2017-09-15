<script type="text/javascript">
    <!--
function startclock()
{
    var time=new Date();
    var hours=time.getHours();
    var mins=time.getMinutes();
    var sec=time.getSeconds();
    var AandP="";

    if (hours>=12)
        AandP="P.M.";
    else
        AandP="A.M.";

    if (hours>=13)
        hours-=12;

    if (hours==0)
        hours=12;

    if (sec<10)
        sec="0"+sec;

    if (mins<10)
        mins="0"+mins;
    document.getElementById('clock').innerHTML=hours+":"+mins+":"+sec+" "+AandP;

    setTimeout('startclock()',1000);
}
//-->
</script>
<table id="tbl_header" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="450" align="left" valign="middle" class="header_caption">
	 <img src="images/admin/acumen_logo_big.gif" border="0" width="150" height="50" style="vertical-align:middle;" /> ADMIN Panel
	</td>
    <td align="right" valign="bottom">
	 <table id="tbl_welcome" width="80%" border="0" cellspacing="0" cellpadding="5">
        <tr>
          <td align="right" valign="middle"><span id='clock' style="position:relative;"></span>
            <?php
            if($this->session->userdata('user_type_id')==true )
            {
                ?>
           |&nbsp; <span class="headerLinks">Welcome <?=$this->session->userdata('user_username')?></span> &nbsp;|&nbsp;<a href="<?=base_url().'admin/home/display'?>" class="headerLinks">Admin Home</a> &nbsp;|&nbsp; <a href="<?=base_url().'user/logout'?>" class="headerLinks">Logout</a>
            <?
            }
            ?>
        </td>
        </tr>
      </table>
	</td>
  </tr>
</table>
<script language="javascript" type="text/javascript">
 startclock();
</script>