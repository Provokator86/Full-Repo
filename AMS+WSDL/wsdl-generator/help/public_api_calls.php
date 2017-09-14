<?php
	# loading utils & functions...
	require_once 'includes/config.php';
	require_once 'includes/functions.php';
	
	$CURRENT_MENU = 'public-api-calls';
		
	# Header
	include_once 'layouts/doc_header.php';
?>

<?php
	$default_selection = 'soap-transmit-response';
?>
<header>
	<h1>function "<label id="h1_header"><?= $menu_sub_links[$default_selection] ?></label>"</h1>
</header>
<!-- ////////////// SOAP API View Parts [Begin] ////////////// -->
	
	<?php
		$loop_index = 0;
		foreach($menu_sub_links as $key=>$value) :
			
			$div_id = "div-{$key}";
			$view_file = "partials/{$key}.php";
			$div_css = ( !empty($loop_index) )? 'class="no-show"': '';
	?>
		<div id="<?= $div_id ?>" <?= $div_css ?>>
			<?php
				// loading the partial view part...
				include_once $view_file;
			?>
		</div>
	<?php
			$loop_index++;
	
		endforeach;
	?>
	
<!-- ////////////// SOAP API View Parts [End] ////////////// -->

<?php
	# Footer
	include_once 'layouts/doc_footer.php';
?>
