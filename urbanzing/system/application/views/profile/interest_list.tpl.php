<?
if(isset($rows) && isset($rows[0]))
{
    //var_dump($rows);exit;

	foreach($rows as $k=>$v)
    {
        $style  = '';
        if($k%2==0)
            $style  = 'style="background:#f3f3f3;"';
        ?>
<div class="box01" <?=$style?>>
    	<div class="edit_activity">
		
	<a style="color:#FF0000;text-decoration:underline;" href="<?=base_url()?>profile/delete_interest_shown/<?=$v['id']?>" style="cursor: pointer;" onclick="return confirm_deletion();">Delete</a>
	</div>

	<div class="img_box">
        <a href="<?=base_url().'business/'.$v['business_id']?>">
    <?
    if(isset($v['img_name']) && $v['img_name']!='')
    {
    ?>
        <img src="<?=base_url()?>images/uploaded/business/thumb/<?=$v['img_name']?>" width="77" height="77" alt="" />
    <?
    }
    else
    {
    ?>
        <img src="<?=base_url()?>images/front/img_03.jpg" alt="" />
    <?php
    }
    ?>
        </a>
    </div>
    <div class="cont_box">
        <h4><a style="color:#FF790A;" href="<?=base_url().'business/'.$v['business_id']?>"><?=$v['name']?></a></h4>
        <?php if(isset($v['address']) && !empty($v['address'])) { ?>
        <p><?php echo $v['address']?></p>
        <?php } ?>
        <div class="margin15"></div>
    </div>
    <div class="clear"></div>
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