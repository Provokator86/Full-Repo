<div class="result_search">
            <div class="search_cell_01"><h5><?=$tot_data?> result found</h5></div>
         <br />
    </div>
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
   <div class="cont_mid">
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
         <div class="cont_right">
              <div class="margin10"></div>
              <input type="checkbox" id="ck_clim_business<?=$v['id']?>" name="ck_clim_business<?=$v['id']?>" /> I certify that I’m the Owner of this Business <br />
              <div class="margin10"></div>
              <input class="button_04" type="submit" value="Claim this business >>" onclick="claim_business('<?=$v['id']?>')"/>
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
