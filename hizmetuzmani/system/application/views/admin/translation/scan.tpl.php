<div id="right_panel">

    <h2><?php echo $heading;?></h2>
	<div class="info_box">From here Admin can create date-wise backup and scan for new pages here.</div>
	<div class="clr"></div>

    <div id="tab_search">

    <?php /*?><div id="tabbar">

      <ul><?php //javascript:void(0)?>

        <li id="test"><a href="#div1" <?php echo ($h_search=="basic"?'class="select"':'') ?> id="1"><span>Basic Search</span></a></li>

        <li><a href="#div2" <?php echo ($h_search=="advanced"?'class="select"':'') ?> id="2"><span>Search</span></a></li>

      </ul>      

    </div><?php */?>
 <div id="tabcontent" style=" height:50px;">
 
   <div id="div2" <?php //echo ($h_search=="advanced"?"":'style="display: none;"') ?> >
	<?php
			if( $this->session->flashdata('backup_msg') != '' ) :
		?>
				<span style="display:block;color:#ff0000"><?=$this->session->flashdata('backup_msg')?></span><br />
		<?php
			endif;
		?>	
				<div style="width:31%;float:left;text-align:center">
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="backup" value="Backup XML" onclick="javascript:window.location='<?=admin_base_url()?>language_home/backup_this'"/>
				</div>
				
				<div style="width:31%;float:right;text-align:center">
					<input type="button" name="scan" onclick="javascript:window.location='<?=admin_base_url()?>language_home/delete_scan'" value="Delete All and Scan" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				</div>

				<div style="width:31%;float:right;text-align:center">
					<input type="button" name="scan" onclick="javascript:window.location='<?=admin_base_url()?>language_home/scan_this'" value="Scan for new pages" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				</div>
				<div style="clear:both;height:20px;"></div>
				<div class="entry" style=" font-size:12px;">
					<p>
						N.B. Backup will be created with a suffix of date.
					</p>
				</div>
			</div>
	</div>
  </div>
