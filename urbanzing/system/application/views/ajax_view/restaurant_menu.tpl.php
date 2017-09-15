<div style="width: 100%" align="center" >
    <?
    if(isset($business[0]['menu_image_name']) && $business[0]['menu_image_name']!='' && file_exists($file_path.'/'.$business[0]['menu_image_name']))
    {
    ?>
    <img id="thickbox_menu" alt="" src="<?=base_url().'images/uploaded/business/'.$business[0]['menu_image_name']?>"/>
    <?
    }
    else
    {
    ?>
    <span><b>No menu found for this restaurant</b></span>
    <?
    }
    ?>
</div>