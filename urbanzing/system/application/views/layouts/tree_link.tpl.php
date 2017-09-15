<?
if($tree_link)
{
?>
<div style="padding-left:15px;" class="page_tr">
	<p><?=WD('You are here')?> : <a href="<?=base_url()?>" style="color: #000000;text-decoration:none;" ><?=WD('Homepage')?></a>&nbsp;&raquo;&nbsp;
	
    <?
        $total  = count($tree_link);
        $x=1;
        foreach($tree_link as $key=>$value)
        {
            if($x==$total)
            {
?>
                <span style="color: #F08609;"><strong><?=WD($key)?></strong></span>
<?
            }
            else
            {
?>
        		<a href="<?=$value?>" style="text-decoration:none;"  class="nor_links"><?=WD($key)?></a> &raquo; 
<?
            }
            $x++;
        }
    ?>
    </p>
</div>
<?
}
?>
			