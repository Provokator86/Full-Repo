<?php
if(is_array($filename))
{
    foreach ($filename as $value)
    {
    ?>
    <script type="text/javascript" src="<?=base_url() . 'js/' . $value . '.js' ?>"></script>
    <?
    }
}
else
{
    ?>
    <script type="text/javascript" src="<?=base_url() . 'js/' . $filename . '.js' ?>"></script>
    <?
}
?>