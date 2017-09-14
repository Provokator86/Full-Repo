<?php
/*********
* Author: Acumen CS
* Date  : 24 Jan 2014
* Modified By: 
* Modified Date: 
* Purpose:
*  View For Admin access control Edit
* @package General
* @subpackage country
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/access_control/
*/
?>
<?php //Javascript For List View//?>
<script language="javascript">
$(document).ready(function(){
    var g_controller="<?php echo $pathtoclass;?>";//controller Path 
    /*$('[data-rel="chosen"]').chosen();*/
});   
</script>  

<div class="container-fluid">
	<div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-unlock-alt"></i>
                    <h3 class="box-title"><?php echo $posted["txt_user_type"]?></h3>
                </div>
            </div>
        
		    <?php show_all_messages(); /*echo validation_errors();*/ ?>
                        
            <?php
            /*if(!empty($menu_action))
            {
                foreach($menu_action as $k => $v)
                {
                    $tmp[$v['first_label_id']][$v['second_label_id']] = $v;
                }
                
                foreach($tmp as $key => $value)
                {
                    echo '<div class="box box-danger">
                            <div class="box-header">
                                <i class="fa fa-th"></i>
                                <h3 class="box-title">'.$value['first_label_menu'].'</h3>
                            </div>
                            <form class="form-horizontal" name="frm_actions" method="post" action="" role="form">
                                <div class="box-body">';
                                 foreach($value AS $kk => $vv)
                                 {
                                     
                                 }   
                    echo        '</div>
                                <div class="box-footer">
                                    
                                </div>
                            </form>';
                            
                            
                    echo '</div>';
                }
            }*/
            //pr($menu_action);
            if(!empty($menu_action))
            { 
                $count_box = 0 ;    
                $first_label_id = -1;
                ?>
                <?php
                foreach($menu_action as $key => $value) 
                {
                    $wrappr_class= "box-warning"; $inner_div = $inner_div_end = $form_start = $form_end = '';
                    if($first_label_id != $value['first_label_id'])
                    {
                        if($first_label_id!=-1)
                        {
                            $wrappr_class= "box-info";
                            $inner_div = '<div class="col-md-4">';
                            $inner_div_end = '</div>';
                        }
                        
                    }// End if
                    else
                    {
                        $form_start = '<form class="form-horizontal" name="frm_actions" method="post" action="" role="form">
                                                <input type="hidden" name="h_first_label_menu_id" value="'.$value['first_label_id'].'">';
                        $form_end = '<div class="box-footer">
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                        <button class="btn btn-warning">Cancel</button>
                                    </div>
                                    </form>';
                    }
                    /*if($first_label_id != $value['first_label_id'])
                    {
                        //if($first_label_id != -1)
                        $wrappr_class = 'box-info';
                    }
                    else
                    {
                        
                    }*/
                    ?>
                    <!-- Main block start-->
                    <?php echo $inner_div;?>
                    <div class="box <?php echo $wrappr_class?>">
                        <div class="box-header">
                            <i class="fa fa-th"></i>
                            <h3 class="box-title"><?php echo $first_label_id != $value['first_label_id'] ? $value['first_label_menu'] : $value['second_label_menu']?></h3>
                        </div>
                        <?php echo $form_start?>
                        <div class="box-body">
                            <input type="hidden" value="<?php echo $value['second_label_id']; ?>" name="h_action_permit[]" >
                            <select id="select<?php echo '_'.$value['first_label_id'].'_'.$value['second_label_id']; ?>" name="opt_actions[<?php echo $value['second_label_id']; ?>][]" multiple data-rel="chosen" class="form-control">
                            <?php 
                            $arr_action = explode('||',$value['s_action_permit']) ;
                            $selected_action = explode('##',$value['actions']);

                            if(!empty($arr_action))
                            {
                                foreach($arr_action as $key_1 => $value_1)
                                {    
                                    $selected = '';
                                    if(in_array($value_1,$selected_action))
                                        $selected = "selected='selected'";
                                    echo "<option ".$selected." value='".$value_1."'>".$value_1."</option>";
                                }
                            }
                            ?>
                            </select>    
                        </div>
                        <?php echo $form_start?>
                    </div> <!-- End main block -->
                    <?php echo $inner_div;?>
                    <?php 
                    
                    $first_label_id = $value['first_label_id'];
                    
                } // End foreach
            } // End main if
            
            ?>
            
		    <?php
		    if($menu_action)
		    { 
			    $count_box = 0 ;	
			    $first_label_id	= -1;
			    foreach($menu_action as $key=>$value) 
			    {
				    if($first_label_id != $value['first_label_id'])
				    {
					    if($first_label_id != -1)
					    {
					    ?>
                                        
						                <div class="box-footer">
							                <button type="submit" class="btn btn-primary"><?php echo t('Save Changes')?></button>
							                <button class="btn btn-warning"><?php echo t('Cancel')?></button>
						                </div>	
                                        <!--<div class="clearfix"></div>-->
					                </form>                  
				                </div>
			                </div><!--/span-->

			                <?php
                                if($count_box%2==0)
                                    echo '</div>'; // End of row
                        }
                        if($count_box%2==0)
                            echo '<div class="row-fluid">' ;
                        $count_box	+= 1;
                        ?>
			            <div class="box box-danger">
				            <div class="box-header" data-original-title>
                                <i class="fa fa-th"></i> 
					            <h2 class="box-title"><?php echo $value['first_label_menu']; ?></h2>
				            </div>
                            
                            <div class="box-body">   
                  	        <form class="form-horizontal" name="frm_actions" method="post" action="" role="form">
						        <input type="hidden" name="h_first_label_menu_id" value="<?php echo $value['first_label_id'] ?>">
			        <?php		
				    }
			        ?>				
                    <div class="col-md-4">
                        <div class="box box-primary">
                            <div class="box-header">
                                <i class="fa fa-hand-o-down"></i>
                                <h3 class="box-title"><?php echo $value['second_label_menu']; ?></h3>
                            </div>
                            <div class="box-body">
                                <input type="hidden" value="<?php echo $value['second_label_id']; ?>" name="h_action_permit[]" >
                                <select id="select<?php echo '_'.$value['first_label_id'].'_'.$value['second_label_id']; ?>" name="opt_actions[<?php echo $value['second_label_id']; ?>][]" multiple data-rel="chosen" class="form-control">
                                <?php 
                                $arr_action    =    explode('||',$value['s_action_permit']) ;
                                $selected_action    =    explode('##',$value['actions']);

                                if(!empty($arr_action))
                                {
                                    foreach($arr_action as $key_1=>$value_1)
                                    {    
                                        $selected    =    '';
                                        if(in_array($value_1,$selected_action))
                                        $selected    =    "selected='selected'";                                                    
                                        echo "<option ".$selected." value='".$value_1."'>".$value_1."</option>";
                                    }
                                }
                                ?>
                                </select>
                            </div>
                        </div>
                    </div>
                            
                            <?php /* ?>
						    <div class="form-group col-md-4">
							    <label class="control-label"><?php echo $value['second_label_menu']; ?></label>
								<input type="hidden" value="<?php echo $value['second_label_id']; ?>" name="h_action_permit[]" >
								<select id="select<?php echo '_'.$value['first_label_id'].'_'.$value['second_label_id']; ?>" name="opt_actions[<?php echo $value['second_label_id']; ?>][]" multiple data-rel="chosen" class="form-control">
									    <?php 
										    $arr_action	=	explode('||',$value['s_action_permit']) ;
										    $selected_action	=	explode('##',$value['actions']);
										    
										    if(!empty($arr_action))
										    {
											    foreach($arr_action as $key_1=>$value_1)
											    {	
												    $selected	=	'';
												    if(in_array($value_1,$selected_action))
													    $selected	=	"selected='selected'";													
												    echo "<option ".$selected." value='".$value_1."'>".$value_1."</option>";
											    }
										    }
									    ?>
								      </select>
								    
						  	    </div><?php */ ?>
							    
				<?php            
                        $first_label_id	=	$value['first_label_id'];
                    }
                
                ?>		
                                <!--<div class="clearfix"></div>-->
                            
						    </form>
                           </div>  
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Save changes</button>
                                <button class="btn btn-warning">Cancel</button>
                            </div>                     
				        </div><!--/box box-danger-->
			        </div>			
		    <?php
	        }
	        ?>	

<!-- content ends -->
</div>
<style type="text/css">
.col-md-12{margin-left: 0px !important;}
</style>