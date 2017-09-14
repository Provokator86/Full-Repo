<?php
/*********
* Author: SWI DEV
* Date  : 01 June 2015
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
    $('[data-rel="chosen"]').chosen();
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
		    if($menu_action)
		    { 
			    $count_box = 0 ;	
			    $first_label_id	= -1;
			    foreach($menu_action as $key=>$value) 
			    {
				    if($first_label_id!=$value['first_label_id'])
				    {
					    if($first_label_id!=-1)
					    {
					    ?>
						                <div class="col-md-12">
							                <button type="submit" class="btn btn-primary">Save changes</button>
							                <button class="btn btn-warning">Cancel</button>
						                </div>	
                                        <div class="clearfix"></div>						
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
                
			            <div class="box box-info">
				            <div class="box-header" data-original-title>
					            <i class=" fa fa-th"></i> 
                                <h2 class="box-title"><?php echo $value['first_label_menu']; ?></h2>
				            </div>
                            <div class="box-body">
                  	            <form class="form-horizontal" name="frm_actions" method="post" action="">						
						            <input type="hidden" name="h_first_label_menu_id" value="<?php echo $value['first_label_id'] ?>">
						    
			    <?php		
				    }
			    ?>				
						    <div class="col-md-4">
                                <div class="box box-warning">
                                    <div class="box-header">
                                        <i class="fa fa-gears"></i>
                                        <h3 class="box-title"><?php echo $value['second_label_menu']; ?></h3>
                                    </div>
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
								    
						  	    </div>
							</div>  
					    <?php            
                                $first_label_id	=	$value['first_label_id'];
                            }
                        
                        ?>		
							    <div class="col-md-12">
								    <button type="submit" class="btn btn-primary">Save changes</button>
								    <button class="btn btn-warning">Cancel</button>
							    </div>	
                                <div class="clearfix"></div>							
						    </form>                
                    </div>
				</div><!--/span-->
			</div>			
		<?php
		    
	    }
	    ?>	

<!-- content ends -->
</div>
<style type="text/css">
.main-footer{margin-left: 0px !important}
@media (min-width: 768px){
    .main-footer{margin-left: 0px !important;}
}
</style>