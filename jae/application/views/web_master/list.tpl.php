<script type="text/javascript">
var g_controller, add_info_link = '', edit_info_link = '', remove_info_link = '';
$(document).ready(function(){
	g_controller="<?php echo $s_controller_name;?>";//controller Path
	add_info_link       = "<?php echo $this->add_info_link?>";
	edit_info_link      = "<?php echo $this->edit_info_link?>";
	remove_info_link    = "<?php echo $this->remove_info_link?>";

	//Click Aff//
	$("#btn_add_record").click(function(){
        var url=g_controller+((add_info_link=='')?'add_information/':add_info_link);
        window.location.href = url;
	});
	//end Click Add//

	//Click Edit//
	$("a[id^='btn_edit_']").each(function(i){
        $(this).click(function(){
            var url = g_controller+((edit_info_link=='')?'modify_information/':edit_info_link)+$(this).attr("value");
            window.location.href = url;
        });
	});
	//end Click Edit//

	//Click Delete//
	$("a[id^='btn_delete_']").each(function(i){	
	   $(this).click(function(e){
	   		e.preventDefault();
			$("#error_massage").hide();
			$('#myModal_delete').modal('show');
			var temp_id = $(this).attr('value');
	        
			$('#btn_delete_yes').click(function(){
				$.ajax({
					type: "POST",
					async: false,
					url: g_controller+(remove_info_link != '' ? remove_info_link : 'ajax_remove_information/'),
					data: "temp_id="+temp_id,
					success: function(msg){
                        window.location.reload(true);
					   /*if(msg=="ok")
							window.location.reload(true);
					   else if(msg=="user_exist")
					   {
						   $('#myModal_delete').modal('hide');
						   $("#error_massage").show();
					   }
					   else if(msg=="task_exist")
					   {
						   $('#myModal_delete').modal('hide');
						   $("#error_massage").show();
					   }*/
					}
			   });
			});
	
	   });
	});
	//end Click Delete//

	//Admin change status by ajax//
	$("a[id^='approve_img_id_']").click(function(){
		var arr_arg,temp_id,temp_class;
		temp_class=$(this).attr('class');
		temp_id = $(this).attr('id');
		arr_arg = temp_id.split('_');
		var i_status   = (arr_arg[4]=="active")?1:0;
	
		$.ajax({
				type: "POST",
				async: false,
				url: g_controller+'ajax_change_status',
				data: "i_status="+i_status+"&h_id="+arr_arg[3]+"&class="+temp_class,
				success: function(msg){           
					if(msg == "ok")
					{
					   if(i_status)
						{
							$("span[id='status_row_id_"+arr_arg[3]+"']").text("Active") ;
							$("span[id='status_row_id_"+arr_arg[3]+"']").addClass("label-success");
							$("#"+temp_id).attr('id','approve_img_id_'+arr_arg[3]+'_inactive');
							
							var newId = 'approve_img_id_'+arr_arg[3]+'_inactive';
							$("#"+newId).removeClass('glyphicon glyphicon-ban-circle');
							$("#"+newId).addClass('glyphicon glyphicon-ok');
							$("#"+newId).attr('data-toggle','tooltip');
							$("#"+newId).attr('data-placement','bottom');
							$("#"+newId).attr('data-original-title','Make Inactive');
						}
						else
						{
							$("span[id='status_row_id_"+arr_arg[3]+"']").text("Inactive");
							$("span[id='status_row_id_"+arr_arg[3]+"']").removeClass("label-success");
							$("span[id='status_row_id_"+arr_arg[3]+"']").addClass("label-warning");
							$("#"+temp_id).attr('id','approve_img_id_'+arr_arg[3]+'_active');
							
							var newId = 'approve_img_id_'+arr_arg[3]+'_active';
							
							$("#"+newId).removeClass('glyphicon glyphicon-ok');
							$("#"+newId).addClass('glyphicon glyphicon-ban-circle');
							$("#"+newId).attr('data-toggle','tooltip');
							$("#"+newId).attr('data-placement','bottom');
							$("#"+newId).attr('data-original-title','Make Active');
						}
				   }
				}
		   });
	});
	//Admin change status by ajax//
	
    // Alphabate pagination
    $('.alphabate-pagination').click(function(e){
        e.preventDefault();
        var alpha = $(this).attr('rel');
        $('#frm_search_2 > #alphabate_pagination').val(alpha);
        $('#btn_submit').click();
    });
    
    $(".alphabate-pagination-all").click(function(e){
        e.preventDefault();
        var url=g_controller+'show_list?h_search=';
        window.location.href = url;
    });
    // End
    
    // Press enter to submit search form
    $('#frm_search_2 input[type="text"]').on('keyup', function(e){
        var key = e.which || e.keyCode;
        if(key == 13)
           $('#frm_search_2').submit(); 
    });
    
    // Call to colorbox
	//$(".ajax").colorbox();
	
});
</script>

<?php
//end Javascript For List View//
//Removing Controls as per access rights//
//Removing Add//
//pr($controllers_selected,1);
//pr($action_allowed,1);

$i_action_add       = $action_allowed["Add"];
$i_action_edit      = $action_allowed["Edit"];
$i_action_delete    = $action_allowed["Delete"];
$i_action_stat   	= $action_allowed["Status"];
$i_action_download  = $action_allowed["Download"];
$i_action_reset  	= $action_allowed["Reset"];
//$i_action_view=$action_allowed["View Detail"];
//end Removing Add//
//end Removing Controls as per access rights//
?>
<div class="box">
    <div class="box-body table-responsive">
        <?php if($pagination != ''){?>
        <div class="col-md-6 pull-left no-padding">
            <div class="dataTables_paginate paging_bootstrap">
                <ul class="pagination text-center" style="margin: 0;">
                    <?php echo $pagination;?>
                </ul>
            </div>
        </div>
        <?php }?>
        
        <div class="col-md-2 pull-right no-padding">
			<?php 
			// see @batch information 29 September, 2016
			$chkbox = ($chkbox_view===TRUE)?TRUE:FALSE;
			if($chkbox && $i_action_download)
			{ ?>
				<a class="btn btn-primary pull-right" title="Download ASCII"  id="btn_down_ascii" href="javascript:void(0);">Download ASCII</a>
				<div class="clearfix"></div>
				<span>&nbsp;</span>
			<?php } ?>
			
            <?php echo $MOREACTION;?>
            
            <?php
            // see @forms_price information 01 March, 2017            
            $reset_fomr_counter = ($reset_fomr_counter===TRUE)?TRUE:FALSE;
            if($reset_fomr_counter && $i_action_reset)
            {
            ?>
				<a class="btn btn-primary pull-left" title="Reset Forms Counter"  id="reset_forms_counter" href="javascript:void(0);">Reset Forms Counter</a>
            <?php 
			}
            if($i_action_add)
            {  //Access Control for add
            ?>            
				<a class="btn btn-primary pull-right" title="Add"  id="btn_add_record" href="javascript:void(0);">Add</a>
				<div class="clearfix"></div><br />
            <?php 
            } 
            else if($MOREACTION!= '')
                echo '<div class="clearfix"></div><br />';
            ?>
        </div>
        <?php if($show_alphabate_pagination == 'yes'){?>
        <div class="<?php echo $pagination != ''? 'col-md-12 center' : 'col-md-10'?> no-padding">
            <ul class="pagination alphabate-pagination-wrapper text-center" style="margin: 0;"><!--ul-alphabate-pagination-->
                <?php for($i = 'A'; $i < 'Z'; $i++){
                    $selected = $alphabate_pagination == $i ? 'selected' : '';
                    echo '<li><a class="alphabate-pagination '.$selected.'" href="javascript:;" rel="'.$i.'" >'.$i.'</a></li>';
                }?>
                <li><a class="alphabate-pagination <?php echo $alphabate_pagination == 'Z' ? 'selected' : ''?>" href="javascript:;" rel="Z">Z</a></li>
                <li><a class="alphabate-pagination alphabate-pagination-all" href="javascript:;" rel="ALL">ALL</a></li>
            </ul>
        </div>
        <?php }?>
        

	
         <!--<table id="example1" class="table table-striped scroll table-hover" style="clear: both;">-->
          <table id="acs_admin_table" class="table table-striped scroll" style="clear: both;">
            <thead>
              <tr class="info">
                <?php 
				$index_ = 1;
				// see @batch information 29 September, 2016
				$chkbox = ($chkbox_view===TRUE)?TRUE:FALSE;
				if($chkbox)
				{
				echo '<th>';
				echo '<input id="chk_sel_all" name="chk_sel_all" type="checkbox" value="" data-no-uniform="true"/>'; 
				echo '</th>';
				}
				
				foreach($headers as $k=>$head)
				{
					$head_val = ucfirst($head["val"]);
					$class[$index_++] = $c = $head["align"];
					
					/* this block for sorting with field */
					/*
					$arr_sort = isset($head["sort"])?$head["sort"]:"";
                	$image = "";
					
					if(is_array($arr_sort) )
				    {
				        $image = ($order_name == $arr_sort['field_name']  && $order_by=='asc')? '<img src="resource/admin/img/shorting_up.png" />':(( $order_name == $arr_sort['field_name']  && $order_by=='desc')? '<img src="resource/admin/img/shorting_down.png" />':'');
				        $orderby = (($order_name == $arr_sort['field_name'] &&$order_by=='asc') ? 'desc' : 'asc');
				        $label = (($order_name == $arr_sort['field_name']) ? "<strong>$head_val</strong>" : "$head_val");
				        $head_val = "<a class='grey_link' href='".$src_action.'/'.$arr_sort['field_name'].'/'.$orderby."'>".$label."</a>";
				    }
					*/
                    $arr_sort = isset($head["sort"])?$head["sort"]:"";
                    $image = "";
                    
                    if(is_array($arr_sort) )
                    {
                        $image = ($order_name == $arr_sort['field_name']  && $order_by=='asc')? '<span class="glyphicon glyphicon-arrow-down"></span>':(( $order_name == $arr_sort['field_name']  && $order_by=='desc')? '<span class="glyphicon glyphicon-arrow-up"></span>':'');
                        $orderby = (($order_name == $arr_sort['field_name'] &&$order_by=='asc') ? 'desc' : 'asc');
                        $label = (($order_name == $arr_sort['field_name']) ? "<strong>$head_val</strong>" : "$head_val");
                        $head_val = "<a class='grey_link' href='".$src_action.'/'.$arr_sort['field_name'].'/'.$orderby."'>".$label." ".$image."</a>";
                    }
			
			   ?>
               <th width="<?php echo $head["width"];?>" class="<?php echo $c?>"><?php echo $head_val;?></th>
               <?php
			   }
			   unset($k,$head);

			  //end Looping the headers//
			  if(!empty($action_allowed) && !empty($rows_action)) //Access Control for edit
			  {
				echo '<th class="text-center" width="8%">'.($action_header?$action_header:"Actions").'</th>';
			  }
              else
                echo '<th class="text-center" width="8%">&nbsp;</th>';
			 ?>
              </tr>
            </thead>
            <tbody>
            <?php
			//Looping the Rows and Columns For Displaying the result//
            if(!empty($tablerows))
            { 
                $s_temp="";
                $chk_c = 0;
                foreach($tablerows as $k=>$row)
                {
                    //$s_temp="<tr>";  //Starting drawing the row
                    $s_temp="<tr id=".'tableSort-row-'.$row[0].">";
                    
                    foreach($row as $c=>$col)
                    {
                        switch($c)
                        {
                            case 0:
								// see @batch information 29 September, 2016
								$chkbox = ($chkbox_view===TRUE)?TRUE:FALSE;
								if($chkbox)
								{
									$s_temp.='<td>'; 
									$s_temp.='<input class="chkbox_batch" id="chk_bacth_sel_'.$k.'" name="chk_bacth_sel_[]" type="checkbox" value="'.$row[0].'" data-no-uniform="true"/>'; 
									$s_temp.='</td>';
								}
					
                                if($i_action_delete)//Access Control for delete
                                {
                                } // end of  i_action_delete
                                break;
                            case 1:
                                $view = ($detail_view===FALSE)?FALSE:TRUE;
                                if($view)
                                {
                                    //$s_temp.= '<td class="center"><a href="javascript:void(0);" id="disp_det_1_'.$row[0].'" value="'.$row[0].'" >'.$col.'</a></td>';
                                    $s_temp.= '<td class="'.$class[$c].'" width="'.$headers[$c-1]['width'].'" >'.$col.'</td>';
                                }
                                else
                                {
                                    $s_temp.= '<td class="'.$class[$c].'"  width="'.$headers[$c-1]['width'].'">'.$col.'</td>';
                                }
                                break;
                            default:
                                $s_temp.= '<td class="'.$class[$c].'"  width="'.$headers[$c-1]['width'].'">'.$col.'</td>';
                                break;
                        }
                    }//end for
                    //if($this->uri->segment(3)!='team_list')
                    //{
                        if($i_action_edit || $i_action_delete || $i_action_view || !empty($rows_action))
                        {
                            $s_temp.='<td class="center" >';

                            if($i_action_view && $hide_view_action[$k]!=true)//Access Control for edit
                            {
                                $s_temp .='<a class="ajax btn btn-mini btn-success" href="'.$this->pathtoclass.'view_detail/'.decrypt($row[0]).'"><i class="icon-zoom-in icon-white"></i>'.'View'.'</a>&nbsp;';
                            }
                            if($i_action_edit && $hide_edit_action[$k]!=true)//Access Control for edit
                            {
                                $s_temp.='<a data-toggle="tooltip" data-placement="bottom" title="Edit" class="glyphicon glyphicon-edit" href="javascript:void(0);" id="btn_edit_'.$k.'" value="'.$row[0].'" ></a>&nbsp;';
                            }
                            if($i_action_delete && $hide_delete_action[$k]!=true)//Access Control for delete
                            {
                                $s_temp.='<a data-toggle="tooltip" data-placement="bottom" title="Delete" class="glyphicon glyphicon-remove" href="javascript:void(0);" id="btn_delete_'.$k.'" value="'.$row[0].'" ></a>&nbsp;';
                            }

                            //$s_temp.='<a class="btn btn-danger" href="javascript:void(0);" id="btn_delete_'.$k.'" value="'.$row[0].'" ><i class="icon-plus-sign icon-white"></i>Add</a>&nbsp;';

                            if($rows_action[$k])
                            {
                                $s_temp.=$rows_action[$k];
                            }
                            $s_temp.='</td>';
                        }
                    
                    //}

                    $s_temp.= "</tr>";
                    echo $s_temp;
                    $chk_c++;
                } // end foreaach
                unset($s_temp,$k,$row,$c,$col);
            }
            else//empty Row
                echo '<tr><td class="center"   width="8%" colspan="'.(count($headers)+2).'">'."No information found".'</td></tr>';
			?>
          </tbody>
      </table>
    </div>
    <div class="box-footer">
        <div class="col-md-12 pull-left no-padding">
            <div class="dataTables_paginate paging_bootstrap">
                <ul class="pagination text-center">
                    <?php echo $pagination;?>
                </ul>
            </div>
        </div> 
    </div>
</div>
<?php /*?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-12 pull-left no-padding">
            <div class="dataTables_paginate paging_bootstrap">
                <ul class="pagination text-center">
                    <?php echo $pagination;?>
                </ul>
            </div>
        </div>
    </div>
</div>
 <?php */?>       
<!-- Modal box -->
<div class="modal fade"  id="myModal_delete">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">        
            <button type="button" class="close" data-dismiss="modal">x</button>
            <h3 class="text-yellow">Confirmation</h3>
        </div>
        <div class="modal-body">
            <p><?php echo get_message("confirmation")?>?</p>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-success" id="btn_delete_yes">Yes</a>
            <a href="#" class="btn btn-danger" id="btn_delete_no" data-dismiss="modal">No</a>
        </div>
	  </div>
	</div>
</div>
