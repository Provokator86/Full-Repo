<script type="text/javascript">
var g_controller, add_info_link = '', edit_info_link = '', remove_info_link = '';
$(document).ready(function(){
	g_controller="<?php echo $s_controller_name;?>";//controller Path
	add_info_link       = "<?php echo $this->add_info_link?>";
	edit_info_link      = "<?php echo $this->edit_info_link?>";
	remove_info_link    = "<?php echo $this->remove_info_link?>";

	

	//Click Delete//
	$("a[id^='btn_team_delete_']").each(function(i){	
        var team_url = g_controller+'team_list/'+'<?php echo $action_allowed["region_id"];?>';
        
	   $(this).click(function(e){
	   		e.preventDefault();
            
			$("#error_massage").hide();
			$('#myModal_delete_team').modal('show');
			var temp_id = $(this).attr('value');
	
			$('#team_delete_yes').click(function(){
				$.ajax({
					type: "POST",
					async: false,
					url: g_controller+(remove_info_link != '' ? remove_info_link : 'ajax_remove_team_information/'),
					data: "temp_id="+temp_id,
					success: function(msg){
					   if(msg=="ok")
                       window.location.href = team_url;
					   //window.location.reload(true);
					   
					}
			   });
			});
	
	   });
	});
	//end Click Delete//
    
    //Click Delete//
    $("a[id^='btn_partner_delete_']").each(function(i){    
        var team_url = g_controller+'partners_list/'+'<?php echo $action_allowed["region_id"];?>';
        
       $(this).click(function(e){
               e.preventDefault();
            
            $("#error_massage").hide();
            $('#myModal_delete_team').modal('show');
            var temp_id = $(this).attr('value');
    
            $('#team_delete_yes').click(function(){
                $.ajax({
                    type: "POST",
                    async: false,
                    url: g_controller+(remove_info_link != '' ? remove_info_link : 'ajax_remove_partner_information/'),
                    data: "temp_id="+temp_id,
                    success: function(msg){
                       if(msg=="ok")
                       window.location.href = team_url;
                       //window.location.reload(true);
                       
                    }
               });
            });
    
       });
    });
    //end Click Delete//

	
    // Call to colorbox
	$(".ajax").colorbox();
});
</script>

<?php
//pr($action_allowed,1);
#$action_allowed["region_id"];

$i_action_add       = $action_allowed["Add"];
$i_action_edit      = $action_allowed["Edit"];
$i_action_delete    = $action_allowed["Delete"];
//$i_action_view=$action_allowed["View Detail"];
//end Removing Add//
//end Removing Controls as per access rights//
$extra_param = $this->session->userdata('teamRegionId');
?>
<div class="box">
    <div class="box-body table-responsive">
        <div class="col-md-8 pull-left no-padding">
            <div class="dataTables_paginate paging_bootstrap">
                <ul class="pagination text-center" style="margin: 0;">
                    <?php echo $pagination;?>
                </ul>
            </div>
        </div>
        <div class="col-md-4 pull-right no-padding">
        <?php echo $MOREACTION;?>
        <?php 
        if($i_action_add)
        { 
            //Access Control for add
        ?>
            <a class="btn btn-primary pull-right" title="Add"  id="btn_add_record" href="javascript:void(0);"><?php echo addslashes(t('Add'))?></a>
            <div class="clearfix"></div><br />
        <?php 
        } 
        else if($MOREACTION!= '')
        {
            echo '<div class="clearfix"></div><br />';
        } ?>
        </div>
        

	
         <!--<table id="example1" class="table table-striped scroll" style="clear: both;">-->
          <table id="acs_admin_table" class="table table-striped scroll" style="clear: both;">
            <thead>
              <tr class="info">
                <?php 
				$index_ = 1;
				foreach($headers as $k=>$head)
				{
					$head_val = ucfirst($head["val"]);
					$class[$index_++] = $c = $head["align"];
					
					/* this block for sorting with field */					
                    $arr_sort = isset($head["sort"])?$head["sort"]:"";
                    $image = "";
                    
                    if(is_array($arr_sort) )
                    {
                        $image = ($order_name == $arr_sort['field_name']  && $order_by=='asc')? '<span class="glyphicon glyphicon-arrow-down"></span>':(( $order_name == $arr_sort['field_name']  && $order_by=='desc')? '<span class="glyphicon glyphicon-arrow-up"></span>':'');
                        $orderby = (($order_name == $arr_sort['field_name'] &&$order_by=='asc') ? 'desc' : 'asc');
                        $label = (($order_name == $arr_sort['field_name']) ? "<strong>$head_val</strong>" : "$head_val");
                        #$head_val = "<a class='grey_link' href='".$src_action.'/'.$arr_sort['field_name'].'/'.$orderby."'>".$label." ".$image."</a>";
                        $head_val = "<a class='grey_link' href='".$src_action.'/'.$extra_param.'/'.$arr_sort['field_name'].'/'.$orderby."'>".$label." ".$image."</a>";
                    }
			
			   ?>
               <th width="<?php echo $head["width"];?>" class="<?php echo $c?>"><?php echo $head_val;?></th>
               <?php
			   }
			   unset($k,$head);

			  //end Looping the headers//
			  /*if($this->uri->segment(3)!='team_list')
			  {*/
				  if(!empty($action_allowed) || !empty($rows_action))//Access Control for edit
				  {
					echo '<th class="text-center" width="8%">'.($action_header?$action_header:addslashes(t("Actions"))).'</th>';
				  }
			 /* }*/
			  ?>
              </tr>
            </thead>
            <tbody>
            <?php
			//Looping the Rows and Columns For Displaying the result//
            if(!empty($tablerows))
            { 
                $s_temp="";
                foreach($tablerows as $k=>$row)
                {
                    //$s_temp="<tr>";  //Starting drawing the row
                    $s_temp="<tr id=".'tableSort-row-'.$row[0].">";
                    foreach($row as $c=>$col)
                    {
                        switch($c)
                        {
                            case 0:
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
                    
                    if($this->uri->segment(3)!='team_ajax_list')
                    {
                        if($i_action_edit || $i_action_delete || $i_action_view || !empty($rows_action))
                        {
                            $s_temp.='<td class="center" >';

                            if($i_action_view && $hide_view_action[$k]!=true)//Access Control for edit
                            {
                                $s_temp .='<a class="ajax btn btn-mini btn-success" href="'.$this->pathtoclass.'view_detail/'.decrypt($row[0]).'"><i class="icon-zoom-in icon-white"></i>'.addslashes(t('View')).'</a>&nbsp;';
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
                    }
                    
                    $s_temp.= "</tr>";
                    echo $s_temp;
                } // end foreaach
                unset($s_temp,$k,$row,$c,$col);
            }
            else//empty Row
                echo '<tr><td class="center"   width="8%" colspan="'.(count($headers)+2).'">'.addslashes(t("No information found")).'</td></tr>';
			?>
          </tbody>
      </table>
    </div>
</div>

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
        
<!-- Modal box -->
<div class="modal fade"  id="myModal_delete_team">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">        
            <button type="button" class="close" data-dismiss="modal">x</button>
            <h3 class="text-yellow"><?php echo addslashes(t("Confirmation"))?></h3>
        </div>
        <div class="modal-body">
            <p><?php echo get_message("confirmation")?>?</p>
        </div>
        <div class="modal-footer">
            <a href="javascript:void(0);" class="btn btn-success" id="team_delete_yes"><?php echo addslashes(t("Yes"))?></a>
            <a href="javascript:void(0);" class="btn btn-danger" id="team_delete_no" data-dismiss="modal"><?php echo addslashes(t("No"))?></a>
        </div>
	  </div>
	</div>
</div>