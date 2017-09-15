<table id="tbl_content_area" width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr><td height="1px"></td></tr>
	<tr>
      <td align="center" valign="middle" bgcolor="#FFFFFF" style="border:1px dotted #999999;" height="100%">
	  	 <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
		  <tr>
		  	<td style="border-right:1px dotted #999999; width:25%; background:#F3F3F3;" valign="top" align="left">
			  <?php
                    $this->load->view('admin/common/menu_master.tpl.php');
                ?>
			</td>
            <td style="width:75%;" valign="top" align="left">
                <div class="sub_heading">
                    <?php
                        $this->load->view('admin/common/message_page.tpl.php');
                        if($user)
                        {
                            ?>
                    <table width="100%">
                        <tr>
                            <td align="left" style="padding-top:10px;">
                                <table width="30%" cellpadding="3" cellspacing="0" border="0">
                                    <tr>
                                        <td class="td_tab_main">
                                            Tree of user 
                                        </td>
                                    </tr>
                                </table>
                                <?
                                if(isset($user_detail))
                                {
                                ?>
                                <table width="65%" style="border: 1px solid rgb(153, 153, 153);" cellpadding="3" cellspacing="0" >
                                    <tr>
                                        <td align="left" width="15%" style="color:#000000;font-weight: normal;">Name:</td>
                                        <td align="left" width="35%" style="color:#000000;"><b><?=$user_detail[0]['name']?></b></td>
                                        <td align="left" width="15%" style="border-left: 1px solid gray;padding-left: 5px;color:#000000;font-weight: normal;">User Id:</td>
                                        <td align="left"  style="color:#000000;"><b><?=$user_detail[0]['user_code']?></b></td>
                                    </tr>
                                    <tr>
                                        <td align="left"  style="color:#000000;font-weight: normal;">Email:</td>
                                        <td align="left"  style="color:#000000;"><b><?=$user_detail[0]['email']?></b></td>
                                        <td align="left"  style="border-left: 1px solid gray;padding-left: 5px;color:#000000;font-weight: normal;">Join date:</td>
                                        <td align="left"  style="color:#000000;"><b><?=date("d-m-Y",$user_detail[0]['join_date'])?></b></td>
                                    </tr>
                                    <tr>
                                        <td align="left"  style="color:#000000;font-weight: normal;">Total left side:</td>
                                        <td align="left"  style="color:#000000;"><b><?=$user_detail[0]['left_total']?> Members</b></td>
                                        <td align="left"  style="border-left: 1px solid gray;padding-left: 5px;color:#000000;font-weight: normal;">Total Income:</td>
                                        <td align="left"  style="color:#000000;"><b><?=$user_detail[0]['total_income']?></b></td>
                                    </tr>
                                    <tr>
                                        <td align="left"  style="color:#000000;font-weight: normal;">Total right side:</td>
                                        <td align="left"  style="color:#000000;"><b><?=$user_detail[0]['right_total']?> Members</b></td>
                                        <td align="left"  style="border-left: 1px solid gray;padding-left: 5px;color:#000000;font-weight: normal;">&nbsp;</td>
                                        <td align="left"  style="color:#000000;"><b>&nbsp;</b></td>
                                    </tr>
                                    
                                </table>
                                <?
                                }
                                if(isset($user['name']))
                                {
                                ?>
                                <table width="98%" style="border: 1px solid rgb(153, 153, 153);" cellpadding="3" cellspacing="0" >
                                    <tr>
                                        <td>
                                            <div>
                                                <?=(isset($user['p_id'])&& $user['p_id']!='')?'<a href="'.base_url().'admin/user/tree/'.$user['p_id'].'/'.($user['level']-1).'">Back to parrent</a>':''?>
                                            </div>
                                            <div class="member_level">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td colspan="4">
                                                            <div class="level_01">
                                                                <?=$user['htm']?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?
                                                    $left_child = $user['left_child'];
                                                    $right_child = $user['right_child'];
                                                    ?>
                                                    <tr>
                                                        <td colspan="4" class="level_02">
                                                            <div class="cell_05">
                                                                <?=(isset($left_child))?$left_child['htm']:vacant_node_html($user['user_code'])?>
                                                            </div>
                                                            <div class="cell_06">
                                                                <?=(isset($right_child))?$right_child['htm']:vacant_node_html($user['user_code'])?>
                                                            </div>
                                                            <div class="clear"></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    <?
                                                    if($left_child)
                                                    {
                                                        $left_left_child    = $left_child['left_child'];
                                                        $left_right_child    = $left_child['right_child'];
                                                        $clss   =   'class="level_03"';
                                                    }
                                                    ?>
                                                        <td valign="top" colspan="2" <?=$clss?>>
                                                            <div class="cell_03">
                                                                <?=(isset($left_left_child))?$left_left_child['htm']:((isset($left_child))?vacant_node_html($left_child['user_code']):'')?>
                                                            </div>
                                                            <div class="cell_04">
                                                                <?=(isset($left_right_child))?$left_right_child['htm']:((isset($left_child))?vacant_node_html($left_child['user_code']):'')?>
                                                            </div>
                                                            <div class="clear"></div>
                                                        </td>
                                                    <?
                                                    $clss='';
                                                    if($right_child)
                                                    {
                                                        $right_left_child    = $right_child['left_child'];
                                                        $right_right_child    = $right_child['right_child'];
                                                        $clss   =   'class="level_03"';
                                                    }
                                                    ?>
                                                        <td valign="top" colspan="2" <?=$clss?>>
                                                            <div class="cell_03">
                                                                <?=(isset($right_left_child))?$right_left_child['htm']:((isset($right_child))?vacant_node_html($right_child['user_code']):'')?>
                                                            </div>
                                                            <div class="cell_04">
                                                                <?=(isset($right_right_child))?$right_right_child['htm']:((isset($right_child))?vacant_node_html($right_child['user_code']):'')?>
                                                            </div>
                                                            <div class="clear"></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    <?
                                                    $clss='';
                                                    if($left_left_child)
                                                    {
                                                        $left_left_left_child    = $left_left_child['left_child'];
                                                        $left_left_right_child    = $left_left_child['right_child'];
                                                        $clss   =   'class="level_04"';
                                                    }
                                                    ?>
                                                        <td width="25%" <?=$clss?>>
                                                            <div class="cell_01">
                                                                <?=(isset($left_left_left_child))?$left_left_left_child['htm']:((isset($left_left_child))?vacant_node_html($left_left_child['user_code']):'')?>
                                                            </div>
                                                            <div class="cell_02">
                                                                <?=(isset($left_left_right_child))?$left_left_right_child['htm']:((isset($left_left_child))?vacant_node_html($left_left_child['user_code']):'')?>
                                                            </div>
                                                            <div class="clear"></div>
                                                        </td>
                                                    <?
                                                    $clss='';
                                                    if($left_right_child)
                                                    {
                                                        $left_right_left_child    = $left_right_child['left_child'];
                                                        $left_right_right_child    = $left_right_child['right_child'];
                                                        $clss   =   'class="level_04"';
                                                    }
                                                    ?>
                                                        <td width="25%" <?=$clss?>>
                                                            <div class="cell_01">
                                                                <?=(isset($left_right_left_child))?$left_right_left_child['htm']:((isset($left_right_child))?vacant_node_html($left_right_child['user_code']):'')?>
                                                            </div>
                                                            <div class="cell_02">
                                                                <?=(isset($left_right_right_child))?$left_right_right_child['htm']:((isset($left_right_child))?vacant_node_html($left_right_child['user_code']):'')?>
                                                            </div>
                                                            <div class="clear"></div>
                                                        </td>
                                                    <?
                                                    $clss='';
                                                    if($right_left_child)
                                                    {
                                                        $right_left_left_child    = $right_left_child['left_child'];
                                                        $right_left_right_child    = $right_left_child['right_child'];
                                                        $clss   =   'class="level_04"';
                                                    }
                                                    ?>
                                                        <td width="25%" <?=$clss?>>
                                                            <div class="cell_01">
                                                                <?=(isset($right_left_left_child))?$right_left_left_child['htm']:((isset($right_left_child))?vacant_node_html($right_left_child['user_code']):'')?>
                                                            </div>
                                                            <div class="cell_02">
                                                                <?=(isset($right_left_right_child))?$right_left_right_child['htm']:((isset($right_left_child))?vacant_node_html($right_left_child['user_code']):'')?>
                                                            </div>
                                                            <div class="clear"></div>
                                                        </td>
                                                   <?
                                                    $clss='';
                                                    if($right_right_child)
                                                    {
                                                        $right_right_left_child    = $right_right_child['left_child'];
                                                        $right_right_right_child    = $right_right_child['right_child'];
                                                        $clss   =   'class="level_04"';
                                                    }
                                                    ?>
                                                        <td width="25%" <?=$clss?>>
                                                            <div class="cell_01">
                                                                <?=(isset($right_right_left_child))?$right_right_left_child['htm']:((isset($right_right_child))?vacant_node_html($right_right_child['user_code']):'')?>
                                                            </div>
                                                            <div class="cell_02">
                                                                <?=(isset($right_right_right_child))?$right_right_right_child['htm']:((isset($right_right_child))?vacant_node_html($right_right_child['user_code']):'')?>
                                                            </div>
                                                            <div class="clear"></div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <?
                                }
                                ?>
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