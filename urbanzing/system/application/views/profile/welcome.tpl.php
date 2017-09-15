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
        </div>
   <div class="clear"></div>
</div>