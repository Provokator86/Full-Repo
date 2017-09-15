<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<base href="<?=base_url()?>">
<title><?=$title?></title>
<script type="text/javascript">
var base_url = '<?=base_url()?>';
</script>
<?=$css?>
<?=$js?>

</head>

<body>
    <div id="page">
        <div id="page_header">
            <?php
            if($show_header!='off')
                $this->load->view('admin/common/header.tpl.php');
                ?>
        </div>
        <div>
        <?php
        foreach( $this->include_files as $value ) :
            $this->load->view('admin/'.$value.'.tpl.php');
        endforeach;
        ?>
        </div>
        <div id="footer">
            <table id="tbl_footer" width="100%" border="0" cellspacing="0" cellpadding="5">
            <tr>
               <td width="50%" align="left" valign="middle" height="30">&copy; <?=date('Y')?> urbanzing.com. All rights reserved </td>
               <td align="right" valign="middle">Powerd By <a target="_BLANK" href="http://www.acumensofttech.com" style="color:#CCFF33">Acumen Consultancy Services Pvt. Ltd.</a></td>
            </tr>
          </table>
        </div>

    </div>
    <div id="toottipDiv" style="display:none; position:absolute; border:2px solid #BEBABA; background-color: white; padding: 3px;">
    </div>
</body>
</html>
<?php	$this->load->view('admin/common/page_resize.tpl.php');	?>