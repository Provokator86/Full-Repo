<table id="tbl_content_area" width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr><td height="1px"></td></tr>
	<tr>
	  
	  <form action="<?php echo base_url()?>admin/business_review/delete_review" id="form1" method="post">
	 	 <input type="hidden" value="" name="id" id="review_id" />
	  </form>
	  
      <td align="center" valign="middle" bgcolor="#FFFFFF" style="border:1px dotted #999999;" height="100%">
	  	 <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
		  <tr>
		  	<td style="border-right:1px dotted #999999; width:25%; background:#F3F3F3;" valign="top" align="left">
			  <?php
                    $this->load->view('admin/common/menu_general.tpl.php');
                ?>
			</td>
            <td style="width:75%;" valign="top" align="left">
                <div class="sub_heading">
                    <?php
                        $this->load->view('admin/common/message_page.tpl.php');
                        $this->load->view('admin/common/admin_filter.tpl.php');
                        if($business)
                        {
                            ?>
                    <table width="100%">
                        <tr>
                            <td align="left" style="padding-top:10px;">
                                <table width="30%" cellpadding="3" cellspacing="0" border="0">
                                    <tr>
                                        <td class="td_tab_main">
                                            Business Reviews
                                        </td>
                                    </tr>
                                </table>
                                <table width="100%" style="border: 1px solid rgb(153, 153, 153);" cellpadding="3" cellspacing="0" >
                                    <tr>                                        
										<td class="td_tab_main" align="center" style="padding-left:0px;">User</td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;" width="20%">Date</td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">Business</td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">Full Review</td>
									    <td class="td_tab_main" align="center" style="padding-left:0px;">Action</td>
                                    </tr>


                           <?
                            foreach($business as $key=>$value)
                            {
                                $style  = '';
                                
                                ?>
                                    <tr id="<?php echo 'row'.$value['id']?>">
									<td align="center" class="columnDataGrey"><?=$value['f_name']?></td>
									<td align="center" class="columnDataGrey"><?=date('d-m-Y', $value['cr_date'])?></td>
                                    <td align="center" class="columnDataGrey"><?=$value['name']?></td>
                                    <td align="center" class="columnDataGrey">
                                            <a onclick="tb_show('','<?=base_url()?>admin/business_review/ajax_show_review/<?=$value['id']?>?height=250&amp;width=450')" style="cursor: pointer;">Show Review</a>
                                     </td>
									<td align="center" class="columnDataGrey"><img src="<?=base_url()?>images/admin/icon_delete.png" onclick="delete_review(<?php echo $value['id']?>)" title="delete this review"/></td>
                                    </tr>
                                <?

                            }
                            ?>
                                </table>
                            </td>
                    </tr>
                    <tr>
                        <td align="right" style="padding-right:50px;">
                            <?=$this->pagination->create_links()?>
                        </td>
                    </tr>
                </table>
                            <?
                        }
                        else
                        {
                        ?>
                <table width="100%">
                    <tr>
                        <td align="center" style="padding-top:100px;">
                            No data found in database
                        </td>
                    </tr>
                </table>
                        <?
                        }
                    ?>
                </div>
            </td>
		  </tr>
		 </table>
	  </td>
    </tr>
	<tr><td height="1px;"></td></tr>
  </table>
  
  <script type="text/javascript" language="javascript">
  
  function delete_review(id)
  {
  	
	var del = confirm('Do you really want to delete this review');	
	if(!del)
	{
		return false;
	
	}
 	else
	{
		
		$("#review_id").val(id);
		$("#form1").submit();
	
	}
  
  
  }
  
  function delete_review1(id)
  {
  		
	var del = confirm('Do you really want to delete this review');	
	if(!del)
	{
		return false;
	
	}
 	else
	{
		
		$.ajax({
				type: "POST",
				url: base_url + "admin/business_review/delete_review",
				data: "id=" + id,
				success: function(msg){
				if(msg)
				{
					$("#row"+id).remove();
					alert('review deleted successfully');
				}
				
		 }
		});


	} 
  
  }
  </script>
  
  