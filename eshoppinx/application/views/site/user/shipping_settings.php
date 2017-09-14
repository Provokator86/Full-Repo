<?php
$this->load->view('site/templates/header',$this->data);
$this->load->view('site/templates/popup_templates.php');
?>
    <!-- Section_start -->
    <div id="mid-panel">
        <div class="wrapper">        
                <div class="container set_area" style="padding:30px 0 20px">
		<?php if($flash_data != '') { ?>
		<div class="errorContainer" id="<?php echo $flash_data_type;?>">
			<script>setTimeout("hideErrDiv('<?php echo $flash_data_type;?>')", 3000);</script>
			<p><span><?php echo $flash_data;?></span></p>
		</div>
        <div class="clear"></div>
		<?php } ?>
                
        <?php $this->load->view('site/user/user_sidebar_menu'); ?>                

        <div id="content">
		<h2 class="ptit"><?php if($this->lang->line('shipping_address') != '') { echo stripslashes($this->lang->line('shipping_address')); } else echo "Shipping Address"; ?></h2>
	<?php if ($shippingList->num_rows() == 0){?>
		<div class=" section shipping no-data">
			
			<span class="icon"><i class="ic-ship"></i></span>
			<p><?php if($this->lang->line('shipping_no_shipaddr') != '') { echo stripslashes($this->lang->line('shipping_no_shipaddr')); } else echo "You haven't added any shipping address yet."; ?></p>
			
			<button onclick="shipping_address_cart();" class="add_addr btn-shipping add_"><i class="ic-plus"></i> <?php if($this->lang->line('shipping_add_ship') != '') { echo stripslashes($this->lang->line('shipping_add_ship')); } else echo "Add Shipping Address"; ?></button>
		</div>
	<?php 
	}else {
	?>
	<div class="section shipping">
            <h3><?php if($this->lang->line('shipping_saved_addrs') != '') { echo stripslashes($this->lang->line('shipping_saved_addrs')); } else echo "Your Saved Shipping Addresses"; ?></h3>
                	<div class="chart-wrap">
            <table class="chart">
                <thead>
                    <tr>
                        <th class="shipping_default"><?php if($this->lang->line('shipping_default') != '') { echo stripslashes($this->lang->line('shipping_default')); } else echo "Default"; ?></th>
                        <th class="shipping_name"><?php if($this->lang->line('shipping_nickname') != '') { echo stripslashes($this->lang->line('shipping_nickname')); } else echo "Nick Name"; ?></th>
                        <th class="shipping_address"><?php if($this->lang->line('shipping_address_comm') != '') { echo stripslashes($this->lang->line('shipping_address_comm')); } else echo "Address"; ?></th>
                        <th class="shipping_phone"><?php if($this->lang->line('shipping_phone') != '') { echo stripslashes($this->lang->line('shipping_phone')); } else echo "Phone"; ?></th>
                        <th class="shipping_option"><?php if($this->lang->line('purchases_option') != '') { echo stripslashes($this->lang->line('purchases_option')); } else echo "Option"; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($shippingList->result() as $row){?>
                    <tr aid="<?php echo $row->id;?>" isdefault="<?php if($row->primary == 'Yes'){echo TRUE; }else {echo FALSE;}?>" id="address<?php echo $row->id;?>" >
                        <td class="shipping_default"><?php if($row->primary == 'Yes'){?><i class="ic-check"></i><?php }?></td>
                        <td><?php echo $row->nick_name;?></td>
                        
                        <td><?php echo $row->address1.', '.$row->address2.'<br/>'.$row->city.'<br/>'.$row->state.'<br/>'.$row->country.'-'.$row->postal_code;?></td>
                        <td  class="shipping_phone"><?php echo $row->phone;?></td>
                        
                        <td><a style="cursor:pointer" aid="<?php echo $row->id;?>" onclick="return EditShippingAddress('<?php echo $row->id;?>');" class="edit_addr edit_"><?php if($this->lang->line('shipping_edit') != '') { echo stripslashes($this->lang->line('shipping_edit')); } else echo "Edit"; ?></a> / <a style="cursor:pointer" class="remove_"  onclick="return UserDetailsDelete('<?php echo $row->id;?>','<?php if($row->primary == 'Yes'){echo '1'; }else {echo '2';}?>');"><?php if($this->lang->line('shipping_delete') != '') { echo stripslashes($this->lang->line('shipping_delete')); } else echo "Delete"; ?></a></td>
                    </tr>
                    <?php }?>
                    
                </tbody>
            </table>
			</div>
            	<button onclick="shipping_address_cart();" class="add_addr btn-shipping add_"><i class="ic-plus"></i> <?php if($this->lang->line('shipping_add_ship') != '') { echo stripslashes($this->lang->line('shipping_add_ship')); } else echo "Add Shipping Address"; ?></button>
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
$this->load->view('site/templates/footer',$this->data);
?>
