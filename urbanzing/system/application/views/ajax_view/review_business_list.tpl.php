<div class="review_botm" >
    <div class="cell_11"><h4> <?=$rows[0]['tot_row']?> reviews</h4></div>
    <?
    if(isset($first_review) && isset($first_review[0]))
    {
    ?>
    <div class="cell_08">
        <h3><img align="absmiddle" src="<?=base_url()?>images/front/icon_05.png" alt="" /> First To Review</h3>
    </div>
	 <div class="cell_09">
	 <?php if( $first_review[0]['img_name'] != ''){?>
	 <img align="absmiddle" style="width: 40px;height:30px;" src="<?php echo $image_source.$first_review[0]['img_name'];?>" alt="" />
      <?php } else {?>
	  <img align="absmiddle" style="width: 40px;height:30px;" src="<?=base_url()?>images/front/img_03.jpg" alt="" />
	  <?php }?>
	  
	    <?
        if($first_review[0]['screen_name']!=='')
            $txtShow    = $first_review[0]['screen_name'];
        else
            $txtShow    = $first_review[0]['f_name'].' '.$first_review[0]['l_name'];
			$txt_to_Show  = str_replace(" ", "_",$txtShow);
		
        ?>
        <a style="cursor: pointer;color:#FA8717;font-size:11px;font-weight:bold;font-style:italic;text-decoration:none;" href="<?=base_url();?>business/show_profile/<?=$first_review[0]['id']?>/<?=$txt_to_Show?>"><?=$txtShow?></a>
        
    </div>
    <?
    }
    ?>
   <div class="clear"></div>
</div>
<!--==========================================================================================================================-->
<?php if( $row[0]['editorial_comments'] != '' ):?>
<div class="box03" style="padding-bottom:2px;">
    <div class="img_frame">
        <a><img width="53" src="<?=base_url()?>images/front/UrbanZing_sq_logo.jpg" alt="" /></a>
    </div>
    <div class="cont_box02">
    	 <h6>Editor's Review</h6>
         <em>
			   <?php
				for($i=1;$i<=5;$i++)
				{
				?><img src="<?=base_url()?>images/front/star.png" alt=""/><?
				}
				?>
			  
		   </em> &nbsp;&nbsp;
  			<p style="padding-top:5px;"><?=$row[0]['editorial_comments'];?></p>
    	</div>
		<div class="clear"></div>
</div>
<?php endif;?>	

<!--==========================================================================================================================-->
<?php
if($rows && $rows[0]['id']!='')
{
    /*echo "<pre>";
    print_r($rows);
	echo "</pre>";exit;*/
	foreach($rows as $k=>$v)
    {
?>
<div class="box03">
    <div class="img_frame">
        <?
          if(isset($v['u_img']) && $v['u_img']!='')
          {
          ?>
        <a><img width="53" src="<?=base_url()?>images/uploaded/user/thumb/<?=$v['u_img']?>" alt="" /></a>
          <?
          }
          else
          {
              ?>
          <a ><img src="<?=base_url()?>images/front/img_04.jpg" alt="" /></a>
              <?
          }
          ?>
    </div>
    <div class="cont_box02">
        <?
        if($v['screen_name']!=='')
            $txtShow    = $v['screen_name'];
        else
            $txtShow    = $v['f_name'].' '.$v['l_name'];
			$txt_to_Show  = str_replace(" ", "_",$txtShow);
        ?>
        <h6><a style="cursor: pointer;" href="<?=base_url();?>business/show_profile/<?=$v['cr_by']?>/<?=$txt_to_Show?>"><?=$txtShow?></a></h6>
       <em><?=($v['ct_name']!='' && $v['c_name']!='')?$v['ct_name'].', '.$v['c_name']:''?></em><br />
       <em>
           <?
            for($i=1;$i<=$v['star_rating'];$i++)
            {
            ?><img src="<?=base_url()?>images/front/star.png" alt=""/><?
            }
            ?>
           <?=date('d/m/Y',$v['cr_date'])?></em> &nbsp;&nbsp;
           <img id="img_like_review_<?=$v['id']?>" align="absmiddle" src="<?=base_url()?>images/front/<?=($v['review_like']==1)?'not_like_btn.png':'like_btn.png'?>" alt="" />
           <?
            if($this->session->userdata('user_id')!='')
            {
            ?>

           <a id="a_like_review_<?=$v['id']?>" class="link_text" style="cursor: pointer;" onclick="like_review('<?=base_url().'ajax_controller/ajax_like_review/'.$v['id']?>','<?=$v['id']?>');"><?=($v['review_like']==1)?'Dislike this':'Like this'?></a>
		   <div style="width:100px; float:right;" id="like_review_ajax"></div>
		   
			<?
            }
            else
            {
                ?>
                <a style="cursor: pointer;" onclick="tb_show('Login','<?=base_url()?>ajax_controller/ajax_show_login/default?height=250&width=400');" class="link_text">Like this</a>
                <?
            }
            ?>
            &nbsp;
           <img align="absmiddle" src="<?=base_url()?>images/front/flag_icon.png" alt="" />
           <?
                if($this->session->userdata('user_id')!='')
                {
                ?>
                    <?php if( $v['no_of_times_reported'] == 0 ):?>
					<a class="link_text" style="cursor: pointer;" onclick="tb_show('Report this Review','<?=base_url()?>ajax_controller/ajax_show_review_report/review_report/<?=$v['id']?>?height=200&width=450');">Report this Review</a>
					<?php endif;?>
					<?php if( $v['no_of_times_reported'] >0 ):?>
					<span style="color:#FA8717;font-size:12px;;"> You have reported this review</span>
					<?php endif;?>
					
                <?
                }
                else
                {
                    ?>
                    <a style="cursor: pointer;" onclick="tb_show('Login','<?=base_url()?>ajax_controller/ajax_show_login/review_report/<?=$v['id']?>?height=250&width=400');" class="link_text">Report this review</a>
                    <?
                }
                ?>
	<br /><font color="orange" style="font-size:14px;"><?=$v['review_title']?></font>
	<span style="font-size: 10px;color:#000000"> 
			<?php echo '( '.$v['count_like'];
					if(	$v['count_like'] <=	1) 
						echo " person likes this )";
					else
						 echo " people like this )";	
			?>
	</span>
	</div>
	
    <div class="clear"></div>
    <p style="padding-top:5px;"><?=$v['comment']?></p>
    </div>
<?
    }
}
?>
<div class="margin15"></div>
<div class="paging" style="border:none; padding-top:0px;">
<?
if($rows[0]['tot_row']>$toshow)
{
?>
<div class="paging_ajax">
    <table border="0" cellspacing="0" cellpadding="0" style=" margin:auto;" width="15%">
        <tr>
            <td align="center" >
            <?php
            if($page>0)
            {
            ?>
            <a onclick='autoload_ajax("<?=base_url().'ajax_controller/review_list_ajax/'.$business_id?>","review_list",<?=$jsnArr?>,"page","<?=($page-1)?>");' style="cursor:pointer;">
                <img alt="" src="<?=base_url()?>images/front/arrow_left.png" style="vertical-align: middle;"></a>
            <?php
            }
            ?>
        </td>
        <td align="center" width="50" valign="top">
            <?=($page+1)?>
                /
                <?=ceil($rows[0]['tot_row']/$toshow)?>

        </td>
        <td align="center" >
        <?php
            if( $toshow<$rows[0]['tot_row'] && (($page+1)*$toshow)<$rows[0]['tot_row'])
            {
        ?>
            <a onclick='autoload_ajax("<?=base_url().'ajax_controller/review_list_ajax/'.$business_id?>","review_list",<?=$jsnArr?>,"page","<?=($page+1)?>");' style="cursor:pointer;">
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
</div>