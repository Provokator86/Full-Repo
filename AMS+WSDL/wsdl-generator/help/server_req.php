<?php
	# loading utils & functions...
	require_once 'includes/config.php';
	require_once 'includes/functions.php';
	
	$CURRENT_MENU = 'server-req';
	
	# Header
	include_once 'layouts/doc_header.php';
?>

<header>
	<h1>Server-Requirement(s)</h1>
</header>
<div id="div-oauth">
<div class="region region-content">
	<div class="SystemBlock">
		<div id="Node--172" class="Node node node-documentation clearfix  Node--documentation ">
			<div class="Node-content">
				<div class=" Field FieldName-body FieldType-textWithSummary FieldLabel-hidden ">
					<div class="Field-items">
						<div class="Field-items-item even ">
							<div class="section introduction">
								<h2>for SOAP API</h2>
								<p><code>Server API</code> needs to be <strong>Apache 2.0 Handler</strong> (ref. fig# 1)</p>
								<p class="center">
									<img src="<?= base_url() ?>resources/images/server-req-fig1.png" alt="" /><br />
									<span style="text-align:center;display:block;">Fig. 1</span>
								</p>
								<p>PHP <code>Curl</code> & <code>Hash</code> module(s) needs to be pre-installed over the server (ref. fig# 2 and 3)</p>
								<p class="center">
									<img src="<?= base_url() ?>resources/images/server-req-fig2.png" alt="" /><br />
									<span style="text-align:center;display:block;">Fig. 2</span>
								</p>
								<p class="center">
									<img src="<?= base_url() ?>resources/images/server-req-fig3.png" alt="" /><br />
									<span style="text-align:center;display:block;">Fig. 3</span>
								</p>
								<p>PHP <code>allow_url_fopen</code> setting needs to be <strong>On</strong> over the server (ref. fig# 4)</p>
								<p class="center">
									<img src="<?= base_url() ?>resources/images/server-req-fig4.png" alt="" /><br />
									<span style="text-align:center;display:block;">Fig. 4</span>
								</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>	

<?php
	# Footer
	include_once 'layouts/doc_footer.php';
?>
