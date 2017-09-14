<?php

/*********

* Author: Jagannath Samanta

* Date  : 28 Oct 2012

* Modified By: 

* Modified Date:

* 

* Purpose:

*  View For Admin Dashboard Edit

* 

* @package Dashboard

* @subpackage Dashboard

* 

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

<div id="right_panel">

    <h2><?php echo $heading;?></h2>

    <div class="info_box">From here Admin can see the site summary</div>

    <div class="left_dashboard">

        <div class="left_inside_box">

            <div class="title">Latest Coupons</div>

            

                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding:4px">

                    <tr style="padding-bottom:20px">

                       <th class="dash_th" align="left">Coupon</th>
                       <th class="dash_th" align="left">Store</th>                      

                    </tr>

                    <?php //pr($coupon);

                    if(!empty($coupon))

                    {   

						$i=0;$class='';

                        foreach($coupon as $val)

                        {	

							$i=$i+1;

							$type=($val["i_type"]==1)?'Coupon':($val["i_type"]==2)?'Offer':'Store Offer';

							$class = $class == 'class="no-color"'? 'class = "bg-color"' : 'class="no-color"';

                            echo '<tr '.$class.'>

                                    <td>'.string_part($val["s_title"],30).'</td>

									<td>'.$val["s_store_title"].'</td>

									

                                    

                                 </tr>';

								 if($i==5)

								 break;	

                        } 

                    }

                    else

                    {

                        echo '<tr><td>No Coupons yet</td></tr>'; 

                    }

                    ?>

                </table>

           

        </div>

        

        <!--<div class="clr"></div><div class="view_all2"><a  href="<?php //echo admin_base_url()?>manage_startup/show_list/">View All</a></div>-->

    </div>

    

	<!--END OF DIV-left_dashboard -->

		

    <div class="right_dashboard">

        <div class="dashboard_box">

            <div class="title">Top Hit Coupons</div>

            <div class="content">

               <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding:4px">

                    <tr>

                        <th class="dash_th" align="left">Coupon</th>

                        <th class="dash_th" align="left">No. of hits</th>

                        

                    </tr>

                    <?php

                    if(!empty($coupon_latest))

                    {	

						$i=0;

						$class = '';

						//pr($coupon_latest);//exit;

                        foreach($coupon_latest as $val)

                        {	

							$i=$i+1;

							

							$class = $class == 'class="no-color"'? 'class = "bg-color"' : 'class="no-color"';

                            echo '<tr '.$class.'>

                                    <td>'.string_part($val["s_title"],30).'</td>

									<td>'.$val["TOT"].'</td>

                                    

                                 </tr>';

								 if($i==5)

								 break;	

                        } 

                    }

                    else

                    {

                        echo '<tr><td>No Top Coupon yet</td></tr>'; 

                    }

                    ?>

            </table>

            </div>

            

        </div>

        <div class="clr"></div>

        

        

        

            <!--</div> <div class="view_all" ><a  href="<?php //echo admin_base_url()?>">View All</a></div>-->

        </div><!-- END OF DIV-dashboard_box -->

       

    </div><!--END OF DIV-right_dashboard -->

</div>