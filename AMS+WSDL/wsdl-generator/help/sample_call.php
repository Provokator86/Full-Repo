<?php
	# loading utils & functions...
	require_once 'includes/config.php';
	require_once 'includes/functions.php';
	
	$CURRENT_MENU = 'sample-call';
	
	# Header
	include_once 'layouts/doc_header.php';
?>

<header>
	<h1>Sample API Call(s)</h1>
</header>
<div id="div-oauth">
	<div class="region region-content">
		<div class="region region-content">
			<div class="SystemBlock">
				<div id="Node--102" class="  Node node node-documentation clearfix  Node--documentation ">
					<div class="Node-content">
						<div class=" Field FieldName-body FieldType-textWithSummary FieldLabel-hidden ">
							<div class="Field-items">
								<div class="Field-items-item even ">
									<h3> - PHP</h3>
									<p>Sample code using using PHP's nuSOAP library.</p>
									<div>
										<div id="" class="syntaxhighlighter nogutter  php">
											<table border="0" cellpadding="0" cellspacing="0">
												<tbody>
													<tr>
														<td class="code">
															<div class="container">
																<div class="line number1 index0 alt2">
																	<code class="php comments"># using 3-rd party NuSoap...</code>
																</div>
																<div class="line number2 index1 alt1">
																	<code class="php plain">require_once</code>
																	<code class="php string"> 'lib/nusoap.php';</code>
																</div><br />
																<div class="line number1 index0 alt2">
																	<code class="php comments"># This is your webservice server WSDL URL address...</code>
																</div>
																<div class="line number2 index1 alt1">
																	<code class="php plain">$wsdl = </code>
																	<code class="php string">"<?= project_url() ?>wsdl_server.php?wsdl";</code>
																</div><br />
																<div class="line number1 index0 alt2">
																	<code class="php comments"># create client object...</code>
																</div>
																<div class="line number2 index1 alt1">
																	<code class="php plain">$client = new nusoap_client($wsdl, </code><code class="php string">'wsdl'</code><code class="php plain">);</code>
																</div><br />
																<div class="line number2 index1 alt1">
																	<code class="php plain">$err = $client->getError(); </code>
																</div>
																<div class="line number2 index1 alt1">
																	<code class="php plain">if ($err) {</code>
																</div>
																<div class="line number2 index1 alt1">
																	<code class="php comments tabcontent">// Display the error</code>
																</div>
																<div class="line number2 index1 alt1">
																	<code class="php plain tabcontent">echo </code>
																	<code class="php string">'&lt;h2&gt;Constructor error&lt;/h2&gt;'</code><code class="php plain"> . $err;</code>
																</div>
																<div class="line number2 index1 alt1">
																	<code class="php plain tabcontent">exit(); </code>
																</div>
																<div class="line number2 index1 alt1">
																	<code class="php plain">}</code>
																</div>
																<br />
																<div class="line number2 index1 alt1">
																	<code class="php comments">// an example SOAP call that'll fetch your required set of results</code><br />
																</div>
																<div class="line number2 index1 alt1">
																	<code class="php plain">$result3 = $client->call(</code>
																	<code class="php string">'getPayerRecipientDetails'</code>
																	<code class="php plain">, array(</code><code class="php string">'username'</code><code class="php plain">=></code><code class="php string">'shieldwatch'</code><code class="php plain">,</code> <code class="php string">'password'</code><code class="php plain">=></code><code class="php string">'test123'</code><code class="php plain">,</code> <code class="php string">'batchid'</code><code class="php plain">=></code> <code class="php string">'100025'</code><code class="php plain">));</code>
																</div>
																<div class="line number11 index10 alt2">&nbsp;</div>
															</div>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
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
