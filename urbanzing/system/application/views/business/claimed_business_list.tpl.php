<?
if($rows)
{
foreach($rows as $k=>$v)
{
?>
<div class="ressult_cont">
      <div class="cont_img">
          <?
          if(isset($v['cover_image']) && $v['cover_image'] && $v['cover_image']!='')
          {
          ?>
          <a href="<?=base_url().'business/'.$v['id']?>"><img width="77" height="77" src="<?=base_url()?>images/uploaded/business/thumb/<?=$v['cover_image']?>" alt="" /></a>
          <?
          }
          else
          {
              ?>
          <a href="<?=base_url().'business/'.$v['id']?>"><img src="<?=base_url()?>images/front/img_03.jpg" alt="" /></a>
              <?
          }
          ?>
      </div>
    <div class="cont_mid" style="width: 300px;">
         <h3><a href="<?=base_url().'business/'.$v['id']?>"><?=$v['name']?></a></h3>
         <div class="margin5"></div>
         <p> <?=($v['all_cuisine'] && $v['all_cuisine']!='')?'Cuisine:'.$v['all_cuisine'].' ...':''?></p>
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
   </div>
    <div class="cont_right" style="width: 300px;" >
        <!--<p style="padding: 0px;" class="color_text">In order to make sure you are the true owner of this business we will send you a secret code in the mail in 4-5 business days.Enter the code here to unlock your business.</p>-->
		<p style="padding: 0px;" class="color_text">In order to make sure you are the true owner of this business we will either call you or send you a secret code in the mail in 4-5 business days. Enter the code here to unlock your business.</p>
		
            <div class="margin10"></div>
            <label>Enter Code Here :</label> <input style="width: 185px;height: 18px;" type="text" id="code<?=$v['id']?>" name="code<?=$v['id']?>"/> <br />
            <div class="margin10"></div>
            <input class="button_06" type="submit" value="unlock your business >>" onclick="unlock_business('<?=$v['id']?>')"/>
              <div class="margin10"></div>
              
   </div>
         <br />
 </div>
<?
}
}
if($tot_data>$toshow)
{
?>
<div class="paging_ajax">
    <table border="0" cellspacing="0" cellpadding="0" style=" margin:auto;" width="15%">
        <tr>
            <td align="center" >
            <?php
            if($business_page>0)
            {
            ?>
            <a onclick='autoload_ajax("<?=base_url().'business/claim_business_list_ajax'?>","div_claim_business_list",<?=$jsnArr?>,"business_page","<?=($business_page-1)?>");' style="cursor:pointer;">
                <img alt="" src="<?=base_url()?>images/front/arrow_left.png" style="vertical-align: middle;"></a>
            <?php
            }
            ?>
        </td>
        <td align="center" width="50" valign="top">
            <?=($business_page+1)?>
                /
                <?=ceil($tot_data/$toshow)?>
            
        </td>
        <td align="center" >
        <?php
            if( $toshow<$tot_data && (($business_page+1)*$toshow)<$tot_data)
            {
        ?>
            <a onclick='autoload_ajax("<?=base_url().'business/claim_business_list_ajax'?>","div_claim_business_list",<?=$jsnArr?>,"business_page","<?=($business_page+1)?>");' style="cursor:pointer;">
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
