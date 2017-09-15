<?
if(isset($rows) && isset($rows[0]))
{
   //echo "<pre>";var_dump($rows);echo "</pre>";exit;
	foreach($rows as $k=>$v)
    {
        //print_r($v);
		?>
	<div style="display: block; margin: 3px 3px 3px 3px;float: left;" id="pic_view_image_container_<?php echo $v['id']; ?>"><img src="<?=base_url()?>images/uploaded/business/thumb/<?php echo $v['img_name'];?>" alt="" />&nbsp;&nbsp;

	<div>
		<input type="hidden" name="img_name" id="img_name" value="<?=$v['img_name']?>"/>
		<div style="margin-left:2px;font-size:12px;color:#0033FF"><?php echo  "business:".$v['name'];?></div>
		<img title ="delete this picture" onclick="delete_uploaded_image('pic', '<?php echo $v['id']; ?>', 'pic_view_image_container_<?php echo $v['id']; ?>');" src="<?php echo base_url().'images/admin/trash.gif'; ?>" alt="Delete" style="cursor:pointer;" />
	</div>
	
	
	</div>
<?
    }
}

?>
<div style="clear: both" ></div>
<script type="text/javascript">
		function delete_uploaded_image(target, id, container_name)
			{
				//alert(container_name);exit;
				get_ajax_delete_picture('<?php echo base_url().'ajax_controller/delete_users_uploaded_picture/';?>' + target, id, container_name);
				$("#" + container_name).children().remove();
			}
		
</script>