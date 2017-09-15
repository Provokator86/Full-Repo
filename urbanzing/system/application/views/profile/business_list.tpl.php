<?
foreach($rows as $k=>$v)
{
?>
<div class="cafe_details" id="div_business_list">
    <div class="cafe_left">
        <h2><?=$v['name']?></h2>
        <div class="margin5"></div>
        <p>
            <?
            if(isset($v['review_avg']))
            {
                for($i=0;$i<$v['review_avg'];$i++)
                {
                ?>
                <img src="<?=base_url()?>images/front/star.png" alt="" />
                <?
                }
                ?>
                <em>( Based on <?=$v['review_tot']?> reviews)</em>
                <?
            }
            else
            {
                ?>
                <em>( No review)</em>
                <?
            }
                ?>
        </p>
            <div class="margin5"></div>
            <p><?=$v['address']?>, <?=$v['city_name'].' - '.$v['zipcode_code']?><br />
                  Locality: <?=$v['region_name']?> <br />
                  <?=$v['phone_number']?>
            </p>
            <div class="margin10"></div>
            <span><a target="_BLANK" href="<?=$v['website']?>"><?=$v['website']?></a></span> &nbsp;
            <?
            if((!isset($v['business_owner_id']) || $v['business_owner_id']==0) && $v['my_claim']==false)
            {
            ?>
            <a class="link_text" href="<?=base_url().'business/claim_my_business/'.$v['id']?>">Claim business</a>
            <?
            }
            elseif($cur_user_id==$v['business_owner_id'])
            {
            ?>
            <a class="link_text" href="<?=base_url().'business/edit/'.$v['id']?>">Edit details</a><?php /*?>&nbsp;&nbsp;
            <a class="link_text" href="<?=base_url().'business/manage_menu/'.$v['id']?>">Manage menu</a><?php */?>
            <?
            }
            ?>
        </div>
        <div class="cafe_right">
            <h5>Status: <span><?=$messageList[$v['status']]?></span></h5>
            <div class="margin10"></div>
            <?
            if((!isset($v['business_owner_id']) || $v['business_owner_id']==0) && $v['my_claim']==true)
            {
            ?>
            <!--<p class="color_text">In order to make sure you are the true owner of this business we will send you a secret code in the mail in 4-5 business days.Enter the code here to unlock your business.</p>-->
			<p class="color_text">In order to make sure you are the true owner of this business we will either call you or send you a secret code in the mail in 4-5 business days. Enter the code here to unlock your business.</p>
            <div class="margin10"></div>
            <label>Enter Code Here :</label> <input type="text" id="code<?=$v['id']?>" name="code<?=$v['id']?>"/> <br />
            <div class="margin10"></div>
            <input class="button_06" type="submit" value="unlock your business >>" onclick="unlock_business('<?=$v['id']?>')"/>
            <?
            }
            ?>
        </div>
        <br />
        </div>
<?
}
if($tot_data>$toshow)
{
?>
<div class="paging_ajax">
    <table border="0" cellspacing="0" cellpadding="0" style=" margin:auto;" width="10%">
        <tr>
            <td align="center" style="padding-top: 10px;">
            <?php
            if($business_page>0)
            {
            ?>
            <a onclick='autoload_ajax("<?=base_url().'profile/business_list_ajax'?>","div_business_list",<?=$jsnArr?>,"business_page","<?=($business_page-1)?>");' style="cursor:pointer;">
                <img alt="" src="<?=base_url()?>images/front/arrow_left.png" style="vertical-align: middle;"></a>
            <?php
            }
            ?>
        </td>
        <td align="center" width="50" valign="top">
            <ul class="paging">
                <li><?=($business_page+1)?></li>
                <li>/</li>
                <li><?=ceil($tot_data/$toshow)?></li>
            </ul>
        </td>
        <td align="center" style="padding-top: 10px;">
        <?php
            if( $toshow<$tot_data && (($business_page+1)*$toshow)<$tot_data)
            {
        ?>
            <a onclick='autoload_ajax("<?=base_url().'profile/business_list_ajax'?>","div_business_list",<?=$jsnArr?>,"business_page","<?=($business_page+1)?>");' style="cursor:pointer;">
                <img alt="" src="<?=base_url()?>images/front/arrow_right.png" style="vertical-align: middle;"></a>
        <?php
            }
        ?>
              	</td>
            </tr>
       	</table>
   	</div>
<?
}
?>