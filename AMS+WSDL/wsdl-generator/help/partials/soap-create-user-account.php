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
									<span class="param">customername <span>optional</span></span>
									<p>Customer Name</p>
									<p><strong>Example Values</strong>: <code>John Matthews</code></p>
								</div>
								<div class="parameter">
									<span class="param">companyname <span>optional</span></span>
									<p>Company Name</p>
									<p><strong>Example Values</strong>: <code>ABC Ltd.</code></p>
								</div>
								<div class="parameter">
									<span class="param">companyfeinnumber <span>optional</span></span>
									<p>Company Fein Number</p>
									<p><strong>Example Values</strong>: <code>XXX</code></p>
								</div>
								<div class="parameter">
									<span class="param">companyaddress <span>optional</span></span>
									<p>Company Address</p>
									<p><strong>Example Values</strong>: <code>23A, South Boulevard CA</code></p>
								</div>
								<div class="parameter">
									<span class="param">companycity <span>optional</span></span>
									<p>Company City</p>
									<p><strong>Example Values</strong>: <code>Tampa</code></p>
								</div>
								<div class="parameter">
									<span class="param">companystate <span>optional</span></span>
									<p>Company State</p>
									<p><strong>Example Values</strong>: <code>CA</code></p>
								</div>
								<div class="parameter">
									<span class="param">companyzip <span>optional</span></span>
									<p>Company Zip</p>
									<p><strong>Example Values</strong>: <code>45092</code></p>
								</div>
								<div class="parameter">
									<span class="param">companyphone <span>optional</span></span>
									<p>Company Phone-Number</p>
									<p><strong>Example Values</strong>: <code>(999)-999-9999</code></p>
								</div>
								<div class="parameter">
									<span class="param">useremail <span>optional</span></span>
									<p>User Email</p>
									<p><strong>Example Values</strong>: <code>test@test.com</code></p>
								</div>
								<div class="parameter">
									<span class="param">autoemail <span>optional</span></span>
									<p>Automail ID</p>
									<p><strong>Example Values</strong>: <code>test@test.com</code></p>
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
														<code class="php string">'createUserAccount'</code>
														<code class="php plain">, </code>
													</div>
													<div class="line number2 index1 alt1">
														<code class="php plain tab-24">array(</code><code class="php string">'username'</code><code class="php plain">=></code><code class="php string">'XXXX'</code><code class="php plain">,</code>
													</div>
													<div class="line number2 index1 alt1">
														<code class="php string tab-28">'password'</code><code class="php plain">=></code><code class="php string">'XXXX'</code><code class="php plain">,</code>
													</div>
													<div class="line number2 index1 alt1">
														<code class="php string tab-28">'customername'</code><code class="php plain">=></code><code class="php string">'XXXX'</code><code class="php plain">,</code>
													</div>
													<div class="line number2 index1 alt1">
														<code class="php string tab-28">'companyname'</code><code class="php plain">=></code><code class="php string">'XXXX'</code><code class="php plain">,</code>
													</div>
													<div class="line number2 index1 alt1">
														<code class="php string tab-28">'companyfeinnumber'</code><code class="php plain">=></code><code class="php string">'XXXX'</code><code class="php plain">,</code>
													</div>
													<div class="line number2 index1 alt1">
														<code class="php string tab-28">'companyaddress'</code><code class="php plain">=></code><code class="php string">'XXXX'</code><code class="php plain">,</code>
													</div>
													<div class="line number2 index1 alt1">
														<code class="php string tab-28">'companycity'</code><code class="php plain">=></code><code class="php string">'XXXX'</code><code class="php plain">,</code>
													</div>
													<div class="line number2 index1 alt1">
														<code class="php string tab-28">'companystate'</code><code class="php plain">=></code><code class="php string">'XXXX'</code><code class="php plain">,</code>
													</div>
													<div class="line number2 index1 alt1">
														<code class="php string tab-28">'companyzip'</code><code class="php plain">=></code><code class="php string">'XXXX'</code><code class="php plain">,</code>
													</div>
													<div class="line number2 index1 alt1">
														<code class="php string tab-28">'companyphone'</code><code class="php plain">=></code><code class="php string">'XXXX'</code><code class="php plain">,</code>
													</div>
													<div class="line number2 index1 alt1">
														<code class="php string tab-28">'useremail'</code><code class="php plain">=></code><code class="php string">'XXXX'</code><code class="php plain">)</code>
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
									<span class="param">User-ID </span>
									<p><strong>Example Values</strong>: <code>1</code></p>
								</div>
								<div class="parameter">
									<span class="param">FullName </span>
									<p><strong>Example Values</strong>: <code>John Reese</code></p>
								</div>
								<div class="parameter">
									<span class="param">Email</span>
									<p><strong>Example Values</strong>: <code>john@reese.com</code></p>
								</div>
								<div class="parameter">
									<span class="param">ResponseCode </span>
									<p><strong>Example Values</strong>: <code>100</code></p>
								</div>
								<div class="parameter">
									<span class="param">ResponseDetail </span>
									<p><strong>Example Values</strong>: <code class="php string">Information saved successfully</code></p>
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
														<code class="jscript string tab-8">"id_user"</code>
														<code class="jscript plain">: </code>
														<code class="jscript keyword">1</code>
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
														<code class="jscript string">'Batch information displayed successfully.'</code>
														<code class="jscript plain"></code>
													</div>
													<div class="line alt1">
														<code class="jscript string tab-8">"fullname"</code>
														<code class="jscript plain">: </code>
														<code class="jscript string">'John Reese'</code>
														<code class="jscript plain">,</code>
													</div>
													<div class="line alt1">
														<code class="jscript string tab-8">"email"</code>
														<code class="jscript plain">: </code>
														<code class="jscript string">'john@reese.com'</code>
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
					include_once 'error-pages/createUserAccount-error-codes.php';
				?>
			</div>
		</div>
	</div>
</div>
