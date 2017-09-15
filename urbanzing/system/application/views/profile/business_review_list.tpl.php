<?
/*echo "<pre>";
print_r($rows);
echo "</pre>";exit;*/
if(isset($rows) && isset($rows[0]))
{
    foreach($rows as $k=>$v)
    {
        $style  = '';
        if($k%2==0)
            $style  = 'style="background:#f3f3f3;"';
        ?>
<div class="box03" <?=$style?>>
   
		<div class="edit_activity">
		<a href="<?=base_url()?>business/update_review/<?=$v['id']?>" style="cursor: pointer;color:#FF0000;text-decoration:underline">Edit</a>
		&nbsp;|&nbsp;
	<a href="<?=base_url()?>business/delete_review/<?=$v['id']?>" style="cursor: pointer;color:#FF0000;text-decoration:underline" onclick="return confirm_deletion();">Delete</a>
	</div>
    <div class="cont_box02" style="float:left;">
        <h6>
            <a style="color:#FA8717;" href="<?=base_url().'business/'.$v['business_id']?>">
            <?=$v['b_name']?>
            </a>
        </h6>
        <em><?=$v['ct_name']?>, <?=$v['c_name']?></em><br />
        <em>
            <?
            for($i=1;$i<=$v['review_avg'];$i++)
            {
            ?><img src="<?=base_url()?>images/front/star.png" alt=""/><?
            }
            ?>
           <?=date('d/m/Y',$v['cr_date'])?>
        </em>
    </div>
	
    <div class="clear"></div>
    <p style="font-weight: bold;"><?=$v['review_title']?></p>
    <p><?=$v['comment']?></p>

</div>
        <?
    }
}

?>
<script type="text/javascript">
/*This function is for deletion confirmation of reviews*/
function confirm_deletion()
{
	var confirm_del = confirm("Do you realy want to Delete");
	//alert(confirm_del);
	return confirm_del;
}


</script>