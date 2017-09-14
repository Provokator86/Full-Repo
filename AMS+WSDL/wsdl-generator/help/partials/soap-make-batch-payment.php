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
									<span class="param">username </span>
									<p>Unique (and secret) <code>Username</code> user-specific.</p>
									<p><strong>Example Values</strong>: <code>xxx</code></p>
								</div>
								<div class="parameter">
									<span class="param">password </span>
									<p>Unique (better to be keep as secret) <code>Password</code> which is provided to the user.</p>
									<p><strong>Example Values</strong>: <code>xxxx</code></p>
								</div>
								<div class="parameter">
									<span class="param">batchId</span>
									<p>Batch ID</p>
									<p><strong>Example Values</strong>: <code>100001</code></p>
								</div>
								<div class="parameter">
									<span class="param">cardNumber</span>
									<p>Card Number</p>
									<p><strong>Example Values</strong>: <code>xxxx-xxxx-xxxx-xxxx</code></p>
								</div>
								<div class="parameter">
									<span class="param">expiryMonthYear</span>
									<p>Card Expired Month &amp; Year</p>
									<p><strong>Example Values</strong>: <code>xx/xx</code></p>
								</div>
								<div class="parameter">
									<span class="param">cvvNumber</span>
									<p>Unique (better to be keep as secret) <code>cvv</code> which is in card of the user.</p>
									<p><strong>Example Values</strong>: <code>xxx</code></p>
								</div>
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
														<code class="php comments">// an example SOAP call that'll fetch your required set of results</code><br />
													</div>
													<div class="line number2 index1 alt1">
														<code class="php plain">$result = $client->call(</code>
														<code class="php string">'makeBatchPayment'</code>
														<code class="php plain">, </code>
													</div>
													<div class="line number2 index1 alt1">
														<code class="php plain tab-24">array(</code><code class="php string">'username'</code><code class="php plain">=></code><code class="php string">'XXXX'</code><code class="php plain">,</code>
													</div>
													<div class="line number2 index1 alt1">
														<code class="php string tab-28">'password'</code><code class="php plain">=></code><code class="php string">'XXXX'</code><code class="php plain">,</code>
													</div>
													<div class="line number2 index1 alt1">
														<code class="php string tab-28">'batchId'</code><code class="php plain">=></code><code class="php string">'XXXXXXX'</code><code class="php plain">,</code>
													</div>
													<div class="line number2 index1 alt1">
														<code class="php string tab-28">'cardNumber'</code><code class="php plain">=></code><code class="php string">'XXXXXXXXXXXXXXXX'</code><code class="php plain">,</code>
													</div>
													<div class="line number2 index1 alt1">
														<code class="php string tab-28">'expiryMonthYear'</code><code class="php plain">=></code><code class="php string">'XXXX'</code><code class="php plain">,</code>
													</div>
													<div class="line number2 index1 alt1">
														<code class="php string tab-28">'cvvNumber'</code><code class="php plain">=></code><code class="php string">'XXX'</code><code class="php plain">,</code>
													</div>
													<div class="line number2 index1 alt1">
														<code class="php plain tab-24">);</code>
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
									<span class="param">Customer Name </span>
									<p><strong>Example Values</strong>: <code>John Reese</code></p>
								</div>
								<div class="parameter">
									<span class="param">Customer Address </span>
									<p><strong>Example Values</strong>: <code>#609 Road</code></p>
								</div>
								<div class="parameter">
									<span class="param">Customer City </span>
									<p><strong>Example Values</strong>: <code>Tampa</code></p>
								</div>
								<div class="parameter">
									<span class="param">Customer State </span>
									<p><strong>Example Values</strong>: <code>Florida</code></p>
								</div>
								<div class="parameter">
									<span class="param">Customer Zip </span>
									<p><strong>Example Values</strong>: <code>33675</code></p>
								</div>
								<div class="parameter">
									<span class="param">Paid Amount </span>
									<p><strong>Example Values</strong>: <code>2.75</code></p>
								</div>
								<div class="parameter">
									<span class="param">Transaction Code</span>
									<p><strong>Example Values</strong>: <code>111</code></p>
								</div>
								<div class="parameter">
									<span class="param">Transaction ID </span>
									<p><strong>Example Values</strong>: <code>234tran234</code></p>
								</div>
								<div class="parameter">
									<span class="param">Transaction Description </span>
									<p><strong>Example Values</strong>: <code>Payment made successfully</code></p>
								</div>
								<div class="parameter">
									<span class="param">ResponseCode </span>
									<p><strong>Example Values</strong>: <code>100</code></p>
								</div>
								<div class="parameter">
									<span class="param">ResponseDetail </span>
									<p><strong>Example Values</strong>: <code class="php string">Payment successfull.</code></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
				////////////// NEW BLOCK - FOR RETURN VALUES [END] ////////////
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
														<code class="jscript string tab-8">"customerName"</code>
														<code class="jscript plain">: </code>
														<code class="jscript string">Wes Tebo</code>
														<code class="jscript plain">,</code>
													</div>
													<div class="line alt2">
														<code class="jscript string tab-8">"customerAddress"</code>
														<code class="jscript plain">: </code>
														<code class="jscript string">#609 raod</code>
														<code class="jscript plain">,</code>
													</div>
													<div class="line alt2">
														<code class="jscript string tab-8">"customerCity"</code>
														<code class="jscript plain">: </code>
														<code class="jscript string">Tampa</code>
														<code class="jscript plain">,</code>
													</div>
													<div class="line alt2">
														<code class="jscript string tab-8">"customerState"</code>
														<code class="jscript plain">: </code>
														<code class="jscript string">Florida</code>
														<code class="jscript plain">,</code>
													</div>
													<div class="line alt2">
														<code class="jscript string tab-8">"customerZip"</code>
														<code class="jscript plain">: </code>
														<code class="jscript string">33675</code>
														<code class="jscript plain">,</code>
													</div>
													<div class="line alt2">
														<code class="jscript string tab-8">"invoiceNo"</code>
														<code class="jscript plain">: </code>
														<code class="jscript string">1000000001</code>
														<code class="jscript plain">,</code>
													</div>
													<div class="line alt2">
														<code class="jscript string tab-8">"paidAmount"</code>
														<code class="jscript plain">: </code>
														<code class="jscript string">BATCH-1000000001</code>
														<code class="jscript plain">,</code>
													</div>
													<div class="line alt2">
														<code class="jscript string tab-8">"transactionCode"</code>
														<code class="jscript plain">: </code>
														<code class="jscript string">111</code>
														<code class="jscript plain">,</code>
													</div>
													<div class="line alt2">
														<code class="jscript string tab-8">"transactionId"</code>
														<code class="jscript plain">: </code>
														<code class="jscript string">234TRAN234</code>
														<code class="jscript plain">,</code>
													</div>
													<div class="line alt2">
														<code class="jscript string tab-8">"transactionDescription"</code>
														<code class="jscript plain">: </code>
														<code class="jscript string">Payment successfull</code>
														<code class="jscript plain">,</code>
													</div>
													<div class="line alt1">
														<code class="jscript string tab-8">"ResponseCode"</code>
														<code class="jscript plain">: </code>
														<code class="jscript keyword">100</code>
														<code class="jscript plain">,</code>
													</div>
													<div class="line alt1">
														<code class="jscript string tab-8">"ResponseDetail"</code>
														<code class="jscript plain">: </code>
														<code class="jscript string">'Payment SUccessfull.'</code>
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
					include_once 'error-pages/makeBatchPayment-error-codes.php';
				?>
			</div>
		</div>
	</div>
</div>
