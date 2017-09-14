<div class="region region-content">
	<div class="SystemBlock">
		<div id="Node--730" class="Node node node-api-doc clearfix  Node--apiDoc ">
			<div class="Node-content">
				<div class="Node-content-field Node-apiDocsBody">
					<div class=" Field FieldName-body FieldType-textWithSummary FieldLabel-hidden ">
						<div class="Field-items">
							<div class="Field-items-item even ">
								<!--<p>Returns all "daysales" data for the authenticating &quot;erply-account-number&quot; for a particular date OR date-range given. </p>-->
								<p>This method can only return designated set of records that gets filtered through supplied parameters (by the user).</p>
							</div>
						</div>
					</div>
				</div>
				<div class="Node-content-field Node-apiDocsUrl">
					<h3>SOAP Endpoint</h3>
					<code>
					<div class=" Field FieldName-fieldDocResourceUrl FieldType-text FieldLabel-hidden ">
						<div class="Field-items">
							<div class="Field-items-item even "><?= project_url() ?>wsdl_server.php?wsdl</div>
						</div>
					</div>
					</code></div>
				<div class="Node-content-field Node-apiDocsResourceInfomation">
					<h3>Resource Information</h3>
					<div class=" Field FieldName-fieldDocResponseFormats FieldType-listText FieldLabel-above ">
						<div class="Field-label">Response formats</div>
						<div class="Field-items">
							<div class="Field-items-item even">Object</div>
						</div>
					</div>
					<div class="Field FieldName-fieldDocRequiredAuth FieldType-listText FieldLabel-above ">
						<div class="Field-label">Requires authentication?</div>
						<div class="Field-items">
							<div class="Field-items-item even ">No</div>
						</div>
					</div>
				</div>
				<div class="Node-content-field Node-apiDocsParams">
					<div class=" Field FieldName-fieldDocParams FieldType-textLong FieldLabel-above ">
						<h3 class="Field-label"> Parameters</h3>
						<div class="Field-items">
							<div class="Field-items-item even ">
								<div class="parameter">
									<span class="param">xml-string </span>
									<p>an <code>XML request</code> provided by the user</p>
									<p><strong>Example Values</strong>: 
									<code>&lt;?xml version="1.0" encoding="UTF-8"?&gt;<br />
											&lt;item&gt;<br />
											&lt;userName&gt;shieldwatch&lt;/userName&gt;<br />
											&lt;passWord&gt;test123&lt;/passWord&gt;<br />
											&lt;dataProcessFor&gt;1&lt;/dataProcessFor&gt;<br />
											&lt;Company FormType='1099A'&gt;<br />
												<span class="tab-4">&lt;PayerInfo&gt;</span><br />
													<span class="tab-8">&lt;TIN&gt;56679988&lt;/TIN&gt;</span><br />
													<span class="tab-8">&lt;Year&gt;2015&lt;/Year&gt;</span><br />
													<span class="tab-8">&lt;TypeOfTIN&gt;4&lt;/TypeOfTIN&gt;</span><br />
													<span class="tab-8">&lt;TransferAgentIndicator&gt;0&lt;/TransferAgentIndicator&gt;</span><br />
													<span class="tab-8">&lt;CompanyName&gt;ABC Company&lt;/CompanyName&gt;</span><br />
													<span class="tab-8">&lt;CompanyNameLine2&gt;ABC Company&lt;/CompanyNameLine2&gt;</span><br />
													<span class="tab-8">&lt;CompanyAddress&gt;123 Some Street&lt;/CompanyAddress&gt;</span><br />
													<span class="tab-8">&lt;City&gt;Some City&lt;/City&gt;</span><br />
													<span class="tab-8">&lt;State&gt;ST&lt;/State&gt;</span><br />
													<span class="tab-8">&lt;Zipcode&gt;123445&lt;/Zipcode&gt;</span><br />
													<span class="tab-8">&lt;Phone&gt;8152264352&lt;/Phone&gt;</span><br />
												<span class="tab-4">&lt;/PayerInfo&gt;</span><br />...
									</code></p>
								</div>
								<div class="parameter">&nbsp;</div>
							</div>
						</div>
					</div>
				</div>
				<div class="Node-content-field Node-apiDocsRequest">
					<h3>Example Calling</h3>
					<p class="note">Please Note: The following sample call is implemented using PHP. Syntax and SOAP-call will change accordingly depending upon the language (e.g. C#, Delphi etc.) you're using.</p>
					<?php ///////////////// Sample SOAP Call [Begin] //////////////// ?>
						<div>
							<div id="" class="syntaxhighlighter nogutter  php">
								<table border="0" cellpadding="0" cellspacing="0">
									<tbody>
										<tr>
											<td class="code">
												<div class="container">
													<div class="line number2 index1 alt1">
														<code class="php plain">$XML_STR = &lt;&lt;&lt;</code>
														<code class="php string">
															&lt;?xml version="1.0" encoding="UTF-8"?&gt;<br />
														&lt;item&gt;<br />
														&lt;userName&gt;shieldwatch&lt;/userName&gt;<br />
														&lt;passWord&gt;test123&lt;/passWord&gt;<br />
														&lt;dataProcessFor&gt;1&lt;/dataProcessFor&gt;<br />
														&lt;Company FormType='1099A'&gt;<br />
															<span class="tab-4">&lt;PayerInfo&gt;</span><br />
																<span class="tab-8">&lt;TIN&gt;56679988&lt;/TIN&gt;</span><br />
																<span class="tab-8">&lt;Year&gt;2015&lt;/Year&gt;</span><br />
																<span class="tab-8">&lt;TypeOfTIN&gt;4&lt;/TypeOfTIN&gt;</span><br />
																<span class="tab-8">&lt;TransferAgentIndicator&gt;0&lt;/TransferAgentIndicator&gt;</span><br />
																<span class="tab-8">&lt;CompanyName&gt;ABC Company&lt;/CompanyName&gt;</span><br />
																<span class="tab-8">&lt;CompanyNameLine2&gt;ABC Company&lt;/CompanyNameLine2&gt;</span><br />
																<span class="tab-8">&lt;CompanyAddress&gt;123 Some Street&lt;/CompanyAddress&gt;</span><br />
																<span class="tab-8">&lt;City&gt;Some City&lt;/City&gt;</span><br />
																<span class="tab-8">&lt;State&gt;ST&lt;/State&gt;</span><br />
																<span class="tab-8">&lt;Zipcode&gt;123445&lt;/Zipcode&gt;</span><br />
																<span class="tab-8">&lt;Phone&gt;8152264352&lt;/Phone&gt;</span><br />
															<span class="tab-4">&lt;/PayerInfo&gt;</span><br />...
														</code>
													</div>
													<div class="line number2 index1 alt1">
														<code class="php plain">XML;</code>
													</div><br />
													<div class="line number2 index1 alt1">
														<code class="php comments">// an example SOAP call that'll fetch your required set of results</code><br />
													</div>
													<div class="line number2 index1 alt1">
														<code class="php plain">$result = $client->call(</code>
														<code class="php string">'transmit'</code>
														<code class="php plain">, array(</code><code class="php string">'xmlstring'</code><code class="php plain">=>$XML_STR));</code>
													</div>
													<div class="line number11 index10 alt2">&nbsp;</div>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					<?php ///////////////// Sample SOAP Call [End] //////////////// ?>
				</div><br />
			<?php
				////////////// NEW BLOCK - FOR RETURN VALUES [BEGIN] //////////////
			?>
				<div class="Node-content-field Node-apiDocsParams">
					<div class=" Field FieldName-fieldDocParams FieldType-textLong FieldLabel-above ">
						<h3 class="Field-label"> Return Values</h3>
						<div class="Field-items">
							<div class="Field-items-item even ">
								<div class="parameter">
									<span class="param">Batch-ID </span>
									<p><strong>Example Values</strong>: <code>100998</code></p>
								</div>
								<div class="parameter">
									<span class="param">Number-of-Forms </span>
									<p><strong>Example Values</strong>: <code>20</code></p>
								</div>
								<div class="parameter">
									<span class="param">Total-Payer </span>
									<p><strong>Example Values</strong>: <code>99</code></p>
								</div>
								<div class="parameter">
									<span class="param">Total-Payee</span>
									<p><strong>Example Values</strong>: <code>99</code></p>
								</div>
								<div class="parameter">
									<span class="param">Total-Cost</span>
									<p><strong>Example Values</strong>: <code>1735.85</code></p>
								</div>
								<div class="parameter">
									<span class="param">ResponseCode </span>
									<p><strong>Example Values</strong>: <code>100</code></p>
								</div>
								<div class="parameter">
									<span class="param">ResponseDetail </span>
									<p><strong>Example Values</strong>: <code class="php string">Batch information displayed successfully.</code></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
				////////////// NEW BLOCK - FOR RETURN VALUES [END] //////////////
			?>
				<div class="Node-content-field Node-apiDocsResult">
				<div class=" Field FieldName-fieldDocExamples FieldType-textLong FieldLabel-above ">
					<h3 class="Field-label"> Example Response</h3>
					<div class="Field-items">
						<div class="Field-items-item even ">
							<div>
								<div id="highlighter_650105" class="syntaxhighlighter nogutter  jscript">
									<table border="0" cellpadding="0" cellspacing="0">
										<tbody>
											<tr>
												<td class="code">
												<!-- ====== Start Code [Begin] ====== -->
												<div class="container">
													<div class="line alt1">
														<code class="jscript plain tab-4">{</code>
													</div>
													<div class="line alt2">
														<code class="jscript string tab-8">"batch_id"</code>
														<code class="jscript plain">: </code>
														<code class="jscript keyword">100001</code>
														<code class="jscript plain">,</code>
													</div>
													<div class="line alt1">
														<code class="jscript string tab-8">"responseCode"</code>
														<code class="jscript plain">: </code>
														<code class="jscript keyword">100</code>
														<code class="jscript plain">,</code>
													</div>
													<div class="line alt2">
														<code class="jscript string tab-8">"responseDetail"</code>
														<code class="jscript plain">: </code>
														<code class="jscript string">'Information saved successfully'</code>
														<code class="jscript plain">,</code>
													</div>
													<div class="line alt1">
														<code class="jscript string tab-8">"NoofForms"</code>
														<code class="jscript plain">: </code>
														<code class="jscript keyword">99</code>
														<code class="jscript plain"></code>
													</div>
													<div class="line alt1">
														<code class="jscript string tab-8">"totalPayer"</code>
														<code class="jscript plain">: </code>
														<code class="jscript keyword">99</code>
														<code class="jscript plain"></code>
													</div>
													<div class="line alt1">
														<code class="jscript string tab-8">"totalPayee"</code>
														<code class="jscript plain">: </code>
														<code class="jscript keyword">99</code>
														<code class="jscript plain"></code>
													</div>
													<div class="line alt1">
														<code class="jscript string tab-8">"total_cost"</code>
														<code class="jscript plain">: </code>
														<code class="jscript keyword">9999.99</code>
														<code class="jscript plain"></code>
													</div>
													<div class="line alt2">
														<code class="jscript plain tab-4">}, ...</code>
													</div>
												</div>
												<!-- ====== End Code [End] ======= -->
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div><br />
			</div>
				<?php
					include_once 'error-pages/transmit-error-codes.php';
				?>
			</div>
		</div>
	</div>
</div>
