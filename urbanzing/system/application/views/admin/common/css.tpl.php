<?php
if(is_array($filename))
{
    foreach ($filename as $value)
    {
    ?>
	<link href="<?=base_url() . 'css/' . $value . '.css' ?>" rel="stylesheet" type="text/css" />
    <?
    }
}
else
{
    ?>
	<link href="<?=base_url() . 'css/' . $filename . '.css' ?>" rel="stylesheet" type="text/css" />
    <?
}
?>