<?php
$this->load->view('site/templates/header');
?>
    <!-- Section_start -->
    <div id="mid-panel">
        <div class="wrapper">        
            <div class="container set_area" style="padding:30px 0 20px"> 
                            
                <?php $this->load->view('site/user/user_sidebar_menu'); ?>                
                      
         	    <div id="content">
                <h2 class="ptit"><?php if($this->lang->line('purchases_common') != '') { echo stripslashes($this->lang->line('purchases_common')); } else echo "Purchases"; ?></h2>
                <?php 
                if($purchasesList->num_rows()>0){
    //            	echo "<pre>";print_r($purchasesList->result());
                ?>	
                <div class=" section gifts">
            <h3><?php if($this->lang->line('purchases_history') != '') { echo stripslashes($this->lang->line('purchases_history')); } else echo "Your purchased history."; ?></h3>
            <div class="chart-wrap">
            <table class="chart">
                <thead>
                    <tr>
                        <th class="shipping_default"><?php if($this->lang->line('purchases__invoice') != '') { echo stripslashes($this->lang->line('purchases__invoice')); } else echo "Invoice"; ?></th>
                        <th><?php if($this->lang->line('purchases__paystatus') != '') { echo stripslashes($this->lang->line('purchases__paystatus')); } else echo "Payment Status"; ?></th>
                        <th class="shipping_phone"><?php if($this->lang->line('purchases_shipstatus') != '') { echo stripslashes($this->lang->line('purchases_shipstatus')); } else echo "Shipping Status"; ?></th>
                        <th><?php if($this->lang->line('purchases_total') != '') { echo stripslashes($this->lang->line('purchases_total')); } else echo "Total"; ?></th>
                        <th  class="shipping_default"><?php if($this->lang->line('purchases_orddate') != '') { echo stripslashes($this->lang->line('purchases_orddate')); } else echo "Order-Date"; ?></th>
                        <th><?php if($this->lang->line('purchases_option') != '') { echo stripslashes($this->lang->line('purchases_option')); } else echo "Option"; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($purchasesList->result() as $row){?>
                    <tr>
                        <td  class="shipping_default">#<?php echo $row->dealCodeNumber;?></td>
                        <td><?php echo $row->status;?></td>
                        
                        <td class="shipping_phone"><?php echo $row->shipping_status;?></td>
                        <td><?php echo $row->total;?></td>
                        
                        <td class="shipping_default"><?php echo $row->created;?></td>
<!--                         <td><a target="_blank" href="view-purchase/<?php echo $row->user_id;?>/<?php echo $row->dealCodeNumber;?>"><?php if($this->lang->line('purchases_view') != '') { echo stripslashes($this->lang->line('purchases_view')); } else echo "View"; ?></a></td>
 -->                        <td>
	 						<a style="color:green;" target="_blank" href="view-purchase/<?php echo $row->user_id;?>/<?php echo $row->dealCodeNumber;?>"><?php if($this->lang->line('user_view_invoice') != '') { echo stripslashes($this->lang->line('user_view_invoice')); } else echo "View Invoice"; ?></a><br/>
	                       	<?php if ($row->status == 'Paid'){?>
 	                       	<a style="color:red;" href="order-review/<?php echo $row->user_id;?>/<?php echo $row->sell_id;?>/<?php echo $row->dealCodeNumber;?>"><?php if($this->lang->line('user_seller_discus') != '') { echo stripslashes($this->lang->line('user_seller_discus')); } else echo "Seller Discussion"; ?></a>
 	                       	<?php }?>
                       	</td>
                    </tr>
                    <?php }?>
                    
                </tbody>
            </table>
			</div>
			</div>
                <?php	
                }else {
                ?>
                <div class=" section purchases no-data">
                        <span class="icon"><i class="ic-pur"></i></span>
                        <p><?php if($this->lang->line('purchases_not_purchase') != '') { echo stripslashes($this->lang->line('purchases_not_purchase')); } else echo "You haven't made any purchases yet."; ?></p>
                </div>
                <?php 
                }
                ?>
        </div>            
                    
            </div>    
        </div>
    </div>
    <div class="clear"></div>
    <!-- Section_end -->
<?php 
$this->load->view('site/templates/footer');
?>
