<div class="sign_up">
                                   	<h1>Forgot Password </h1>
                                        <div class="margin15"></div>
                                       
                                        <div class="margin15"></div>
                                        <!--Left Part-->
                                        <div class="signup_left">
                                        <h3>Forgot Password </h3>
                                        <div class="margin15"></div>
                                        <form action="<?=base_url().'user/forget_password'?>" method="post">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        	<tr>
                                             <td colspan="2"><h5>Please enter your email address to get new password. </h5></td>
                                             </tr>
                                          <tr>
										  <tr>
											<td colspan="2">
											  <?php
											   $this->load->view('admin/common/message_page.tpl.php');
											  ?>
											</td>
										  </tr>
                                            <td align="right">Email</td>
                                            <td><input style="width:200px;"  type="text" name="email" /></td>
                                          </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td height="40"><input class="button_02" type="submit" value="Submit >>" name="submit_button" /></td>
                                          </tr>
                                        </table>
                                        </form>
                                        <div class="margin15"></div>
                                        </div>
                                        <div class="signup_right">
                                        	
                                             <div class="margin15"></div>
                                             
                                        </div>
                                        
                                        <div class="clear"></div>
                                        <div class="margin15"></div>
                                       
                                   	<div class="margin15"></div>
                                       
                                   </div>