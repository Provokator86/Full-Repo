<?php
/*********
* Author: Jagannath Samanta
* Date  : 28 Oct 2012
* Modified By: 
* Modified Date:
* Purpose:
*  View For Admin Dashboard Edit
* @package Dashboard
* @subpackage Dashboard
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/dashboard/
*/
?>

<script type="text/javascript">
$(document).ready(function(){
	//$(".left_dashboard, .right_dashboard").draggable();
});
</script>
<style type="text/css">
.left_inside_box h3{margin:10px 0 10px 0px; color:#000000; font-size:12px;font-weight:bold; }
.dashboard_box h3{margin:10px 0 10px 0px; color:#000000; font-size:12px;font-weight:bold; }
.view_more{float:right; margin:0 5px 0 0;font-size:12px; font-weight:bold;}
.view_more a{color:#000; text-decoration:none; margin-bottom:10px;}
.view_more a:hover{ text-decoration:underline;}
table th{ font-size:12px;}
table td{padding:2px 0;font-size:12px;}
.left_inside_box table td{ width:33%;}
.dashboard_box table td{ width:25%;}
.view_all{ margin-bottom:5px;}
.left_inside_box .title span{ float:left; padding:2px 5px; }
.dashboard_box .title span{ float:left; padding:2px 5px; }
</style>
<div id="right_panel">
    <h2><?php echo $heading;?></h2>
    <div class="info_box">From here Admin can see the site summary</div>
    <div class="left_dashboard">
        <div class="left_inside_box" style="height:auto; min-height:220px;">
            <!--<div class="title">Users Snapshot</div> -->   
			<div class="title"> 
				<span>Top 10 New Users </span>
				<span style="float:right;">Active Users: <?php echo $user_count; ?></span>
			</div>         	
				
				<!--<div class="clr"></div>
				<h3>Total Active Users: <?php echo $user_count; ?></h3>				
				<div class="clr"></div>
				<h3>Top 10 New Users <span class="view_more">
				<a id="active_1" href="<?php echo admin_base_url().'manage_user'?>">View All</a></span>
				</h3>-->
				<div style="height:auto; clear:both; min-height:180px;">
                	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding:4px">
                    <tr style="padding-bottom:20px">
                       <th class="dash_th" align="left" >User Name</th>
					   <th class="dash_th" align="left" >Referral Id</th>
                       <th class="dash_th" align="right" >Registrarion Date</th>    
                    </tr>
                    <?php //pr($coupon);
                    if(!empty($user))
                    {   
						$i=0;$class='';
                        foreach($user as $val)
                        {	
							$i=$i+1;							
							$class = $class == 'class="no-color"'? 'class = "bg-color"' : 'class="no-color"';
                            echo '<tr>
                                    <td>'.string_part($val["s_name"],30).'</td>
									<td>'.$val["s_uid"].'</td>
									<td align="right">'.date("F d, Y H:i",strtotime($val["t_timestamp"])).'</td>  
                                 </tr>';
							 if($i==10)
							 break;	
                        } 

                    }
                    else
                    {
                        echo '<tr><td>No user found</td></tr>'; 
                    }
                    ?>
                </table>  
				</div>
				
				<div class="div_more">
					<span class="view_more"><a id="active_1" href="<?php echo admin_base_url().'manage_user'?>">View All</a></span>
				</div>

        </div>
        <!--<div class="clr"></div><div class="view_all2"><a  href="<?php //echo admin_base_url()?>manage_startup/show_list/">View All</a></div>-->
    </div>

	<!--END OF DIV-left_dashboard -->		

    <div class="right_dashboard">
        <div class="dashboard_box" style="height:auto; min-height:220px;">
            <!--<div class="title">Last 30 Days Store Report</div>-->
			<div class="title"> 
				<span>Last 30 Days Store Report </span>
				<span style="float:right;">Total Stores: <?php echo $store_count; ?></span>
			</div> 
				<!--<div class="clr"></div>
				<h3>Total Stores: <?php echo $store_count; ?> <span class="view_more">
				<a id="active_8" href="<?php echo admin_base_url().'store_performance_report'?>">View All</a></span>
				</h3>-->
            <div class="content" style="height:auto; clear:both; min-height:180px;">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding:4px">
                    <tr style="padding-bottom:20px">
                       <th class="dash_th" align="left">Store</th>
					   <th class="dash_th" align="left">Sell Amount</th>
                       <th class="dash_th" align="left">Commission</th>   
                       <th class="dash_th" align="left">Cashback</th>  
                    </tr>
                    <?php //pr($coupon);
                    if(!empty($store_report))
                    {   
						$i=0;$class='';
                        foreach($store_report as $val)
                        {	
							$i=$i+1;							
							
                            echo '<tr>
                                    <td>'.string_part($val["s_merchant_name"],30).'</td>
									<td>Rs. '.number_format($val["total_amount"],2).'</td>
									<td>Rs. '.number_format($val["total_commission_amount"],2).'</td>
									<td>Rs. '.number_format($val["total_cashback_amount"],2).'</td>
                                 </tr>';
							 if($i==10)
							 break;	
                        } 

                    }
                    else
                    {
                        echo '<tr><td>No store found</td></tr>'; 
                    }
                    ?>
                </table>
				
            </div>
			
			<div class="div_more">
				<span class="view_more"><a id="active_8" href="<?php echo admin_base_url().'store_performance_report'?>">View All</a></span>
			</div>
			
        </div>
        <div class="clr"></div>     
		<?php /*?><div class="view_all" ><a  href="<?php //echo admin_base_url()?>">View All</a></div><?php */?>
        </div><!-- END OF DIV-dashboard_box -->

    </div><!--END OF DIV-right_dashboard -->

</div>