<?php
	# loading utils & functions...
	require_once 'includes/config.php';
	require_once 'includes/functions.php';
	
	$CURRENT_MENU = 'overview';
	
	# Header
	include_once 'layouts/doc_header.php';
?>


<header>
	<h1>Documentation</h1>
</header>
<div id="div-overview">
	<div class="region region-content">
		<div class="SystemBlock">
			<div id="Node--1057" class="  Node node node-documentation clearfix  Node--documentation ">
				<div class="Node-content">
					<div class=" Field FieldName-body FieldType-textWithSummary FieldLabel-hidden ">
						<div class="Field-items">
							<div class="Field-items-item even ">
								<p>This SOAP API Platform connects your website or application with the data that resides in our secured server.</p>
									<h2>
										<a href="<?= base_url() ?>documentation/public-api-calls" title="SOAP API">SOAP APIs</a>
									</h2>
									<p>
										SOAP – Simple Object Access Protocol – is probably the better known of the two models.
										<br /><br />
										SOAP relies heavily on XML, and together with schemas, defines a very strongly typed messaging framework. Every operation the service provides is explicitly defined, along with the XML structure of the request and response for that operation. Each input parameter is similarly defined and bound to a type: for example an integer, a string, or some other complex object.
										<br /><br />
										All of this is codified in the WSDL – Web Service Description (or Definition, in later versions) Language. The WSDL is often explained as a contract between the provider and the consumer of the service. In programming terms the WSDL can be thought of as a method signature for the web service.
									</p>
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
