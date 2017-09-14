<?php
$this->load->view('site/templates/header');
?>
    <!-- Section_start -->
    <div id="mid-panel">
        <div class="wrapper">
                <div class="container set_area" style="padding:30px 0 20px">
                
                <?php $this->load->view('site/user/user_sidebar_menu'); ?>                
        
				<div id="content">
		<h2 class="ptit"><?php if($this->lang->line('referrals_common') != '') { echo stripslashes($this->lang->line('referrals_common')); } else echo "Referrals"; ?></h2>
        
        
        
        <?php 
                if(!empty($getReferalList)){
    //            	echo "<pre>";print_r($purchasesList->result());
                ?>	
                <div class=" section gifts">
            <h3><?php if($this->lang->line('referrals_history') != '') { echo stripslashes($this->lang->line('referrals_history')); } else echo "Your referrals history."; ?></h3>
                	<div class="chart-wrap">
            <table class="chart">
                <thead>
                    <tr>
                        <th><?php if($this->lang->line('referrals_thumbnail') != '') { echo stripslashes($this->lang->line('referrals_thumbnail')); } else echo "Thumbnail"; ?></th>
                        <th><?php if($this->lang->line('signup_full_name') != '') { echo stripslashes($this->lang->line('signup_full_name')); } else echo "Full Name"; ?></th>
                        <th><?php if($this->lang->line('signup_user_name') != '') { echo stripslashes($this->lang->line('signup_user_name')); } else echo "Username"; ?></th>
                        <th><?php if($this->lang->line('referrals_email') != '') { echo stripslashes($this->lang->line('referrals_email')); } else echo "Email"; ?></th>                       
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($getReferalList as $referalList){
                    	$img = 'user-thumb1.png';
                    	if ($referalList['thumbnail'] != ''){
                    		$img = $referalList['thumbnail'];
                    	}
                    ?>
                    <tr>
                        <td><img src="images/users/<?php echo $img;?>" width="50px"/></td>
                        <td><?php echo $referalList['full_name'];?></td>
                        <td><?php echo $referalList['user_name'];?></td>                        
                        <td><?php echo $referalList['email'];?></td>
                        
                    </tr>
                    <?php }?>
                    
                </tbody>
            </table>
            
			</div>
             <?php echo $paginationLink; ?>
			</div>
           
                <?php	
                }else {
                ?>
               <div class="section referral no-data">
            <span class="icon"><i class="ic-referral"></i></span>
            <p><?php if($this->lang->line('referrals_not_invite') != '') { echo stripslashes($this->lang->line('referrals_not_invite')); } else echo "You havn't invited anyone yet."; ?><br><!-- <a href="#">Invite Friends</a>--></p>
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
