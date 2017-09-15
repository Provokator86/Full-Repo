<div class="cont_part">
    <div class="margin10"></div>
    <!--Logged Panel-->
    <div class="logged_page" style="text-align: center;">
            <h1>:: Welcome to FLTT. ::</h1>
            <div class="heading"><h5>Member's Current Status</h5></div>
             <div class="details" >
                 <table width="100%" class="table_border" border="0" cellspacing="5" cellpadding="0" >
                    <tr>
                        <td align="right" width="50%" colspan="2">User Id:</td>
                        <td align="left" width="50%" colspan="2"><?=$user_detail[0]['username']?></td>
                    </tr>
                    <tr>
                        <td align="right" width="50%" colspan="2">Date of join:</td>
                        <td align="left" width="50%" colspan="2"><?=date("d-m-Y",$user_detail[0]['join_date'])?></td>
                    </tr>
                    <tr>
                        <td align="right" width="50%" colspan="2" >Total Income:</td>
                        <td align="left" width="50%" colspan="2" ><?=$user_detail[0]['total_income']?></td>
                    </tr>
                    <tr>
                        <td align="right" width="25%" >Total left side:</td>
                        <td align="left" width="25%" ><?=$user_detail[0]['left_total']?> Members</td>
                        <td align="right" width="25%" >Total right side:</td>
                        <td align="left" width="25%" ><?=$user_detail[0]['right_total']?> Members</td>
                    </tr>
                    
                  </table>
             </div>
            
            <div class="heading" style="width: 100%"><h5></h5></div>
             <div class="details_1" style="width: 100%;">
                 <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding:5px;" >
                    <tr>
                      <td align="left">
                          <div style="padding:5px;">
                            <?=(isset($user['p_id'])&& $user['p_id']!='')?'<a style="color: #000000;" href="'.base_url().'profile/geneology/'.$user['p_id'].'/'.($user['level']-1).'">Back to parrent</a>':''?>
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
             </div>
</div>

   <!--Logged Panel End-->
   <div class="clear"></div>
   <div id="toottipDiv" style="font-size: 12px;display:none; position:absolute; border:2px solid #BEBABA; background-color: white; padding: 3px;">
    </div>
</div>

