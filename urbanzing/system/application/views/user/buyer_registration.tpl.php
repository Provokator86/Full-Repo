<div id="block">
				<div class="inner_top"></div>
	<?php
        $this->load->view('layouts/tree_link.tpl.php');
    ?>					
				<div class="inner_bg">					
					<!--inner right-->
						<div id="inner_right_big">
							<div class="inner_header"><?=WD('Post a job')?></div>
							<div class="link-site">
								<div class="post_job_box">
									<div class="left_r"></div>
									<div class="mid_sec">
										<div class="text_f">
											<p class="need"><?=WD('You\'re almost Done')?>! </p>
											<p class="describe"><?=WD('We have')?> <?=$tradesman?> <span class="b_font"><?=$job_cat_list[0]['name']?></span> <?=WD('near')?> <span class="b_font"><?=$job_city?></span> <?=WD('who will be able to quote for your job')?>. 
<?=WD('Create an account below, or login to post your job')?>.
											</p>											
										</div>										
									</div>
									<div class="right_r"></div>
								</div>	
								<div class="clear"></div>
								<div class="arrow_cell"><img src="<?=base_url()?>images/front/green_arrow.png" alt="" /></div>
								<div class="post_job_box">
									<form method="post" id="frm_user" name="frm_user" action="<?=base_url().'user/save_buyer_registration'?>">
									<table cellpadding="0" cellspacing="1" border="0" width="100%" class="post-job-tbl">
										<tr>
											<td colspan="2" class="p_tble_top"><?=WD('Final Step')?>:  <span class="n_txt"><?=WD('Your details')?>:</span></td>
										</tr>
										<tr>
											<td colspan="2" align="left" class="require"><?=WD('Required fields are indicated with a')?> <span class="star">*</span></td>
										</tr>									
										<tr>
											<td width="66%" valign="top">
												<table cellpadding="0" cellspacing="0" border="0" width="100%">
													<tr>
														<td width="50%" valign="top" class="d_sections">
															<table cellpadding="0" cellspacing="6" border="0">
																<tr>
																	<td class="b_font" colspan="2"><?=WD('Please fill in the request fields')?></td>
																</tr>
																<tr><td height="6px" colspan="2"></td></tr>
																<tr>
																	<td class="b_font"><?=WD('First Name')?><span class="star">*</span> :</td>
																	<td><input type="text" id="f_name" name="f_name" class="input_post_box"  tabindex="1"/></td>
																</tr>
																<tr>
																	<td class="b_font"><?=WD('Last Name')?><span class="star">*</span> :</td>
																	<td><input id="l_name" name="l_name" type="text" class="input_post_box" tabindex="2" /></td>
																</tr>
																<tr>
																	<td class="b_font"><?=WD('Email Address')?><span class="star">*</span> :</td>
																	<td><input type="text" class="input_post_box" id="email" name="email" tabindex="3" /></td>
																</tr>
																<tr>
																	<td class="b_font"><?=WD('Mobile Number')?><span class="star">*</span> :</td>
																	<td><input type="text" class="input_post_box" id="phone" name="phone"  tabindex="4"/></td>
																</tr>
															</table>														</td>
														<td width="50%" valign="top"  class="d_sections">
															<table cellpadding="0" cellspacing="6" border="0">
																<tr>
																	<td class="b_font" colspan="2">&nbsp;</td>
																</tr>
																<tr><td height="6px" colspan="2"></td></tr>
																<tr>
																	<td class="b_font"><?=WD('User Name')?><span class="star">*</span> :</td>
																	<td><input id="username" name="username" type="text" class="input_post_box" tabindex="6" /></td>
																</tr>
																<tr>
																	<td class="b_font"><?=WD('Password')?><span class="star">*</span> :</td>
																	<td><input id="password" name="password" type="password" class="input_post_box" tabindex="7" /></td>
																</tr>
																<tr>
																	<td class="b_font"><?=WD('Confirm 
Password')?><span class="star">*</span> :</td>
																	<td><input type="password" id="cpassword" name="cpassword" class="input_post_box" tabindex="8" /></td>
																</tr>															
															</table>														</td>
													</tr>																									
													<tr>
														<td colspan="2" class="hr"></td>
													</tr>
												</table>											</td>											
											<td width="34%" rowspan="3" valign="top" align="center">
												<table cellpadding="0" cellspacing="0" border="0">
													<tr>
														<td><img src="<?=base_url()?>images/front/talk_top.gif" alt="" /></td>
													</tr>
													<tr>
														<td class="talk" align="center"><div><?=html_entity_decode( $buyer_registration[0]['description'])?></div></td>
													</tr>
													<tr>
														<td><img src="<?=base_url()?>images/front/talk_btm.gif" alt="" /></td>
													</tr>
													<tr><td height="25px"></td></tr>
													<tr><td><img src="<?=base_url()?>images/front/tradesmen.jpg" alt="" /></td></tr>
												</table>											</td>
										</tr>
										<tr>
											<td valign="top">
												<table cellpadding="0" cellspacing="0" border="0" width="100%">
													<tr>
														<td colspan="2" class="require">&nbsp;<input type="checkbox" id="newsletter" name="newsletter" tabindex="14" />&nbsp;&nbsp;<?=WD('Please inform me about latest saving tips and important news.')?></td>
													</tr>
														<tr>
														<td colspan="2" class="require">&nbsp;<input type="checkbox"  id="ckTrms" name="ckTrms" tabindex="15"/>&nbsp;&nbsp;<?=WD('I accept the')?> <a style="cursor:pointer;" onclick="show_light_box('show_terms_and_conditions',0,'','')" class="attach"><?=WD('Terms & Conditions')?></a> <?=WD('and the')?> <a style="cursor:pointer;" onclick="show_light_box('show_privacy_policy',0,'','')"  class="attach"><?=WD('Privacy Policy')?></a>.</td>
													</tr>
												</table>											</td>
										</tr>										
										<tr>
											<td class="require"><input type="button" class="post_my_job_btn"  onclick="ck_page()" /><br /><br /><br /><br /><br /><br /><br /><br /></td>
										</tr>										
									</table>
															<script type="text/javascript">
							 function get_opt_value()
	                         {
	                         	var myOption = -1;
	                         	
	                         	for (i=1; i > -1; i--)
	                         	{
	                         		if (document.frm_user.role[i].checked)
	                         		{
	                         			myOption = i;
	                         			i = -1;
	                         		}
	                         	}
	                         	if(myOption==-1)
		                         	return myOption;
	                         	return document.frm_user.role[myOption].value;
	                         }
                        	function ck_page()
                            {
/*                            	if(get_opt_value()==-1)
                            	{
                                	alert("<?=WD('Please select user type')?>");
                                	return;
                            	}
                            	else
                            	{*/
                                    var cntrlArr    = new Array('f_name','l_name','email','phone','username','password','cpassword');
                                    var cntrlMsg    = new Array("<?=WD('Please give the first name')?>","<?=WD('Please give last name')?>","<?=WD('Please give email address')?>","<?=WD('Please give phone number')?>","<?=WD('Please give the user ID')?>","<?=WD('Please give the password')?>","<?=WD('Please rewrite password')?>");
                                    if(ck_blank(cntrlArr,cntrlMsg)==true)
                                    {
                                        cntrlArr    = new Array('email');
                                        cntrlMsg    = new Array("<?=WD('Please give a proper email ID')?>");
                                        if(validateEmail(cntrlArr,cntrlMsg)==true)
                                        {
                                            cntrlArr    = new Array('password','cpassword');
                                            cntrlMsg    = new Array("<?=WD('Two password does not match')?>");
                                            if(compareValue(cntrlArr,cntrlMsg)==true)
                                            {
                                            	cntrlArr    = new Array('ckTrms');
                                                cntrlMsg    = new Array("<?=WD('You have to accept Terms & Conditions and the Privacy Policy')?>");
                                                if(ckCkeckBox(cntrlArr,cntrlMsg)==true)
                                                {
	                                                var valuArr = new Object;
	                                                valuArr.username=document.getElementById('username').value;
	                                                valuArr.email=document.getElementById('email').value;
	                                                var url= "<?=base_url()?>admin/admin_user/add_new_user_check";
	                                                call_ajax_ck_field_duplicate_submit(url,valuArr,document.frm_user);//it will submit the form if responce true
                                                }
                                            }
                                        }
                                    }
                                //}
                            }

                           
                             </script>
									</form>
								</div>
							</div>
							<p>&nbsp;</p>
							<p>&nbsp;</p>
							<p>&nbsp;</p>
						</div>
					<div class="clear"></div>
					<!--inner right end-->
				</div>				
				<div class="inner_btm"></div>
			</div>