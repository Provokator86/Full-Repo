<div class="cont_part">
    <div class="margin10"></div>
    <!--Logged Panel-->
            <div class="logged_page">
            <h1>:: Welcome to FLTT. ::</h1>
            <div id="about_us" style="margin-top: 20px;width: 800px;text-align: center;" align="center">
            <?
            if(isset($cms))
            {
                foreach($cms as $k=>$v)
                {
                    ?>
                    <div class="margin5"></div>
                            <?=html_entity_decode($v['description'])?>
                    <div class="margin15"></div>
                    <?
                }
            }
            ?>
            </div>

            <div class="heading"><h5>Welcome, <?=$user_detail[0]['name']?></h5></div>
             <div class="details">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="left" width="40%">User ID:</td>
                      <td align="left"><?=$user_detail[0]['user_code']?></td>
                    </tr>
                    <tr>
                      <td align="left">Introducer ID:</td>
                        <td align="left"><?=$user_detail[0]['p_id']?></td>
                    </tr>
                  </table>

             </div>
            <div class="heading"><h5>DOWN LINE</h5></div>
             <div class="details">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="left" width="40%">Total Left Side:</td>
                        <td align="left"><?=$user_detail[0]['left_total']?> Members</td>
                    </tr>
                    <tr>
                        <td align="left">Total Right Side:</td>
                        <td align="left"><?=$user_detail[0]['right_total']?> Members</td>
                    </tr>
                  </table>

             </div>
        </div>


   <!--Logged Panel End-->
   <div class="clear"></div>
</div>

