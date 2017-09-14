<?php
/*********
* Author:  Koushik Rout
* Date  :  28 DEC 2011
* Modified By: 
* Modified Date: 
* 
* Purpose:
*  View For Admin Dashboard Edit
* 
* @package Home
* @subpackage News
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/dashboard/
*/

?>


<script language="javascript">
jQuery.noConflict();///$ can be used by other prototype which is not jquery
jQuery(function($) {
$(document).ready(function(){

var g_controller="<?php echo $pathtoclass;?>";//controller Path 
})});    
</script>
<div id="right_panel">
    <h2><?php echo $heading;?></h2>
	<div class="info_box">From here Admin can get the site summary.</div>
	<div class="clr"></div>
 
    <div id="content">   
        <div class="dashboard_box">
            <div class="title">Latest Startup</div>
            <div class="content">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <th class="dash_th" align="left">Startup Name</th>
                        <th class="dash_th" align="left">Email</th>
                        <th class="dash_th" style="text-align:right !important" align="right">Phone</th>
                    </tr>
                    <?php
                    if(!empty($startup))
                    {
                        foreach($startup as $val)
                        {
							$class = $class == ''? 'class = "bg-color"' : '';
                            echo '<tr '.$class.'>
                                    <td>'.$val["s_startup_name"].'</td>
									<td>'.$val["s_email"].'</td>
                                    <td align="right">'.$val["s_telephone"].'</td>
                                 </tr>';	
                        } 
                    }
                    else
                    {
                        echo '<tr><td>No coupons yet</td></tr>'; 
                    }
                    ?>
                </table>
            </div>
            <div class="view_all"><a target="_blank" href="<?php echo admin_base_url()?>manage_startup/show_list">View All</a></div>
        </div>
        
        <div class="dashboard_box float_right">
            <div class="title">Latest Subscribed</div>
            <div class="content">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <th class="dash_th">Name</th>
                        <th class="dash_th" align="left">Email Id</th>
                        <th class="dash_th" style="text-align:right !important" align="right">Date of subscribed</th>
                    </tr>
                    <?php
                    if(!empty($newsletter))
                    {
						$class = '';
						//pr($newsletter);exit;
                        foreach($newsletter as $val)
                        {
							$class = $class == ''? 'class = "bg-color"' : '';
                            echo '<tr '.$class.'>
                                    <td>'.$val["s_name"].'</td>
									<td>'.$val["s_email"].'</td>
                                    <td align="right">'.date('Y-m-d H:i:s', $val["dt_entry_date"]).'</td>
                                 </tr>';	
                        } 
                    }
                    else
                    {
                        echo '<tr><td>No subscribers yet</td></tr>'; 
                    }
                    ?>
            
            </div>
            <div class="view_all"><a target="_blank" href="<?php echo admin_base_url()?>manage_classfd/show_list/">View All</a></div>
        </div>
        <div class="clr"></div>
        
        
        
        
       <!--<div class="dashboard_box">
            <div class="title">Last Five best selling coupons</div>
            <div class="content">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <th class="dash_th">Coupon Name</th>
                        <th class="dash_th">Quantity</th>
                        <th class="dash_th">Original Price</th>
                        <th class="dash_th">Offer Price</th>
                        <th class="dash_th">Saving Per coupon</th>
                        <th class="dash_th" style="text-align:right !important" align="right">Total Earning</th>
                    </tr>
                    <?php
                   /* if(!empty($coupon_details))
                    {
						$class = '';
                        foreach($max_selling_coupon as $val)
                        {
							if($val["f_product_original_price"] > 0)
								$saving	= round((($val["f_product_original_price"]-($val["f_product_offered_price"])/$val["f_product_original_price"]))*100);
							else 
								$saving	 = 0;
									
							$class = $class == ''? 'class = "bg-color"' : '';
                            echo '<tr '.$class.'>
                                    <td>'.$val["s_title"].'</td>
									 <td align="center">'.$val["max_qty"].'</td>
									 <td>'.$val["f_product_original_price"].'</td>
									 <td>'.$val["f_product_offered_price"].'</td>
									 <td align="center">'.$saving.'%</td>
									<td align="right">'.$val["max_qty"]*$val["f_product_offered_price"].'</td>
                                 </tr>';	
                        } 
                    }
                    else
                    {
                        echo '<tr><td>No coupons yet</td></tr>'; 
                    }*/
                    ?>
                </table>
            </div>
            <div class="view_all"><a target="_blank" href="<?php echo admin_base_url()?>manage_coupons/show_list">View All</a></div>
        </div>-->
        <!--<div class="dashboard_box float_right">
            <div class="title">Last five transactions</div>
            <div class="content">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                    	<th class="dash_th">Buyer Name</th>
                        <th class="dash_th">Coupon Name</th>
                        <th class="dash_th">Purchase Date</th>
                        <th class="dash_th" style="text-align:right !important" align="right">Price</th>
                    </tr>
                    <?php
                    /*if(!empty($latest_transactions))
                    {
						$class = '';
                        foreach($latest_transactions as $val)
                        {
							$class = $class == ''? 'class = "bg-color"' : '';
                            echo '<tr '.$class.'>
									<td>'.$val["s_fname"]." ".$val["s_lname"].'</td>
                                    <td>'.$val["s_title"].'</td>
									<td>'.$val["date"].'</td>
                                    <td align="right">'.$val["f_product_offered_price"].'</td>
                                 </tr>';	
                        } 
                    }
                    else
                    {
                        echo '<tr><td>No coupons yet</td></tr>'; 
                    }*/
                    ?>
                </table>
            </div>
            <div class="view_all">&nbsp;</div>
        </div>-->
    </div>
<p>&nbsp;</p>
</div>


