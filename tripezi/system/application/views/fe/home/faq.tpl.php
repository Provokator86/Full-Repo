<script type="text/javascript" src="js/fe/faq.js"></script>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="container-box">
	<h2>Faq</h2>
	<div class="faq-box">
	  <div class="firstpane">
	  	<?php if($faqs) {
				foreach($faqs as $value)
					{			
		 ?>
            <div class="menu-head">
				<a href="javascript:void(0)"><?php echo $value["s_question"] ?></a>
			</div>
            <div class="menu-body-faq" style="display:none;">              
				<p><?php echo $value["s_answer"] ?>.</p>
            </div>
		<?php } } else { ?>	
			<div class="menu-head">
				<a href="javascript:void(0)">No FAQ found.</a>
			</div>
            <div class="menu-body" style="display:none;">              
				<p>No FAQ found. </p>
            </div>
		<?php } ?>	
      
          </div>
	</div>
</div>