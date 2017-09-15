<div class="edit_details">
    <h1>Write review for <?=$business_detail[0]['name']?>,restaurant  in <?=$business_detail[0]['place']?>
        <div class="back_btn"><a href="<?=base_url().'business/'.$business_id?>">Back</a></div></h1>
    <div class="margin15"></div>
    <h2>Lorem Ipsum</h2>
    <div class="margin15"></div>
    <?
    $this->load->view('admin/common/message_page.tpl.php');
    ?>
    <div style="width: 700px;">
        <?
        if(isset($menu_list) && count($menu_list)>0)
        {
            foreach($menu_list as $k=>$v)
            {
                ?>
        <div style="width:70px;height: 95px;border:1px dotted #cccccc;float: left;margin: 5px;text-align: center;">
        <div style="min-height: 75px;background: url(<?=base_url().'images/uploaded/business/thumb/'.$v['img_name']?>) center no-repeat;">
                
            </div>
            <a style="color: #FF790A;" href="<?=base_url().'business/delete_menu/'.$v['business_id'].'/'.$v['id']?>">Delete</a>
            </div>
                <?
            }
        }
        ?>
    </div>
    <div class="clear"></div>
    <div class="margin15"></div>
    <h5>take some time and fill out the form below </h5>
    <div class="margin15"></div>
    <form action="<?=base_url().'business/upload_business_menu'?>" method="post" name="frm_review" id="frm_review" enctype="multipart/form-data" >
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            
            <tr>
                <td height="40" align="right">Upload menu</td>
                <td><input type="file" id="img" name="img" /></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td style="padding-top:10px;"><input class="button_02" type="submit" value="Submit >>" />&nbsp;
                    <input onclick="window.location.href='<?=base_url().'profile'?>'" class="button_02" type="button" value="Cancel >>" />
                    <input type="hidden" id="business_id" name="business_id" value="<?=$business_id?>"/>
                </td>
            </tr>
        </table>
        
    </form>
    <div class="margin15"></div>
    <div class="margin15"></div>
</div>