<div class="rsvp">
<div class="rsvp_left">
                              	<h1>
									<?=$party_details[0]['event_title']?>
									<div class="print_box" style="width:120px; float:right; text-align:right; font-size:12px">
										<a href="<?php echo $session_back_url_from_preview; ?>">BACK</a>
									</div>
								</h1>
                                   <br />
								 <?
   								    $this->load->view('admin/common/message_page.tpl.php');
   								 ?>
                                   <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                     <tr>
                                       <td align="right" width="10%"><strong>Host :</strong></td>
                                       <td width="50%"><?=$party_details[0]['f_name']?></td>
                                       <td valign="top" rowspan="5" align="right" width="40%">
                                      	<div class="image_box" id="image_box">
										<img src="<?=($party_details[0]['img_name']) ? $this->config->item('view_image_folder_plan').$this->config->item('image_folder_thumb').$party_details[0]['img_name'] : base_url().'images/front/no_image_272.jpg'?>" alt="" style="border:1px solid #cccccc;" /></div>
										 </td>
                                     </tr>
                                     <tr>
                                     	<td valign="top" align="right"><strong>Location :</strong></td>
                                        <td><?=($party_details[0]['street_address']!='')?$party_details[0]['street_address'].'<br />':''?>
                                            <?=$party_details[0]['location_name']?><br />
                                            <?=$party_details[0]['city']?><br />
                                            <?=$party_details[0]['state']?>, <?=$party_details[0]['india']?>  <?=$party_details[0]['zipcode']?>  <a href="javascript:void(0)"  onclick="tb_show('Google map','<?=base_url()?>ajax_controller/ajax_show_map/party_view/<?=$party_details[0]['id']?>?height=250&width=400&KeepThis=true&TB_iframe=true');">  View Map</a>							    </td>
                                     </tr>
                                     <tr>
                                     	<td  align="right"><strong>When :</strong></td>
                                        <td><?=date("l, F d, h:iA", $party_details[0]['start_date'])?></td>
                                     </tr>
                                     <tr>
                                     	<td  align="right"><strong>Phone :</strong></td>
                                        <td><?=$party_details[0]['phone_no']?></td>
                                     </tr>
                                     <tr>
                                     	<td  align="right">&nbsp;</td>
                                        <td>
                                        <?=$party_details[0]['message']?>
                                             <div class="margin15"></div>
                                            <!-- <a href="#">Remove me from Guest List</a>  -->
                                             <div class="margin15"></div>   
                                             <!--<a href="#"><img align="absmiddle" src="<?=base_url()?>images/front/face_book02.png" /></a> -->
                                              <div class="margin10"></div>                              
                                        </td>
                                     </tr>
                                     
                                   </table>
					  <!--Reply Here-->
					  <?php
					  if($party_details[0]['cr_by']!=$this->session->userdata('user_id') && $invite_id!='')
					  {
					  ?>
					  			<form name="frm_reply" action="<?=base_url().'party/save_plan_reply'?>" method="post">
                              	<div class="reply">
                                   	<h5>REPLY HERE</h5>
                                        <div class="reply_cont">
                                        	<p>Will you attend, (email id) ? </p>
                                            <!-- <p><a href="#">not (email id)?</a></p>-->
                                             <p><input type="radio" name="status" value="1" onclick="showTotalGuest();" /> Yes &nbsp;&nbsp;
												 <input type="radio" name="status" value="2" onclick="hideTotalGuest();" /> No &nbsp;&nbsp;
											 <input type="radio" name="status" value="3" checked="checked" onclick="showTotalGuest();"/> Maybe</p>
											 <div id="divTotalGuest"><p>Total Guest &nbsp;&nbsp;
                                               <input type="text" name="no_of_guest" />&nbsp;&nbsp; ( including yourself )</p>
											 </div>
											  <p>Show my email ID 
										<input type="checkbox" name="chk_email" id="chk_email" onclick="show_email()" value="1" checked="checked" />
											<span id="show_chk_mail" style="display:none">
											 <input type="text" name="guest_name" id="guest_name" style="width:200px;" />
											 Enter a sceen name that the host can identify you by
											 </span>
											  </p> 
                                             <p>Add a comment (optional)</p>
                                             <textarea name="comment"></textarea>&nbsp;&nbsp; <!--<input type="checkbox" /> <span>Notify me when guests reply</span>-->
                                        </div>
                                        <div class="reply_btn">
										<input type="hidden" name="invite_id" value="<?=$invite_id?>" />
										<input class="button_05" type="submit" value="Reply Now >>" /></div>
                                   </div>
								   </form>
						<?php } ?>		   
                               <!--Guest List-->
                               <br />
							   <?php
							   
							   if($party_details[0]['guest_cansee_each_other']=='Y' || ($party_details[0]['cr_by']==$this->session->userdata('user_id'))){
							   ?>
                               	<div class="guest_list">
                                   	<div class="list_header">
                                        	<div class="left_part"><h5>Guest List</h5></div>
                                             <div class="right_part">
                                              
                                              <img align="absmiddle" src="<?=base_url()?>images/front/icon_15.png" alt="" /> <span>No (<?=count($party_no_list)?>)</span>
                                              <img align="absmiddle" src="<?=base_url()?>images/front/icon_13.png" alt="" /> <span>Yes (<?=count($party_yes_list)?>)</span>
                                              <img align="absmiddle" src="<?=base_url()?>images/front/icon_14.png" alt="" /> <span>Undecided (<?=count($party_undecided_list)?>)</span>
                                              <img align="absmiddle" src="<?=base_url()?>images/front/icon_16.png" alt="" /> <span>No Reply (<?=count($party_no_reply_list)?>)</span>
                                              </div>
                                             <br />
                                        </div>
                                        <div class="list_cont">
                                        	<p>Who's Coming? As of <?=date("F d,Y ,h:iA", $party_details[0]['cr_date'])?></p>
                                             <div class="reply_yes" style="cursor:pointer;" onclick="show_reply_div(1)">
                                             	<img align="absmiddle" src="<?=base_url()?>images/front/icon_13.png" alt="" /> <span>Yes (<?=count($party_yes_list)?>)</span>
                                             </div>
											 <div id="show1" style="display:none">
                                             <div class="margin10"></div>
											 <?php
											 if($party_yes_list){
											  foreach($party_yes_list as $value) {
										
											 ?>
                                             <p><span style="color:#FF0000"><?=$value['guest_name']?>
											 <?php echo '('.$value['no_of_guest'].' guest(s) )';?> </span> &nbsp;&nbsp;
											 <?=($value['comment'])?$value['comment']:''?></p>
                                             <div class="margin10" style="border-bottom:#CCCCCC 1px dotted"></div>
											 <?php } } ?>
											 </div>
                                             <div class="reply_undeside" style="cursor:pointer;"  onclick="show_reply_div(2)">
                                             	<img align="absmiddle" src="<?=base_url()?>images/front/icon_14.png" alt="" /> <span>Undecided (<?=count($party_undecided_list)?>)</span>
                                             </div>
											 <div id="show2" style="display:none">
											  <div class="margin10"></div>
											 <?php
											 if($party_undecided_list){
											  foreach($party_undecided_list as $value) {
											 ?>
                                             <p><span style="color:#FF0000"><?=$value['guest_name']?><?php echo ' ('.$value['no_of_guest'].' guest(s))';?></span> &nbsp;&nbsp;
											 <?=($value['comment'])?$value['comment']:''?></p>
                                             <div class="margin10" style="border-bottom:#CCCCCC 1px dotted"></div>
											 <?php } } ?>
											 </div>
                                             <div class="reply_not" style="cursor:pointer;"  onclick="show_reply_div(3)">
                                             	<img align="absmiddle" src="<?=base_url()?>images/front/icon_15.png" alt="" /> <span>No (<?=count($party_no_list)?>)</span>
                                             </div>
											 <div id="show3" style="display:none">
											 <div class="margin10"></div>
											 <?php
											 if($party_no_list){
											  foreach($party_no_list as $value) {
											 ?>
                                             <p><span style="color:#FF0000"><?=$value['guest_name']?></span> &nbsp;&nbsp;
											 <?=($value['comment'])?$value['comment']:''?></p>
                                             <div class="margin10" style="border-bottom:#CCCCCC 1px dotted"></div>
											 <?php } } ?>
											 </div>	

											<div class="not_reply message_head" style="cursor:pointer;"  onclick="show_reply_div(4)" >
											 <img align="absmiddle" src="<?=base_url()?>images/front/icon_16.png" alt="" /> <span>
											 Not Yet Replied(<?=count($party_no_reply_list)?>)</span>
										
										     </div>
											 	<div id="show4" style="display:none">
													 <div class="margin10"></div>
													 <?php
													
													 if($party_no_reply_list){
													  foreach($party_no_reply_list as $value) {
													  
													 ?>
													 <p>
													 <span style="color:#FF0000;">
													 	<?=$value['email_id']?>
													  </span> &nbsp;&nbsp;
													 </p>
													 
													 <?php } } ?>
											</div>	
                                             <div class="message_body" style="display:none;">
                                               <div class="margin10"></div>
                                               <p><img align="absmiddle" src="<?=base_url()?>images/front/img_13.jpg" alt="" />  Alex</p>
                                             </div>
                                        </div>
                                        <div class="margin15"></div>
                                        <!--<div class="button_box">
                                        	<div class="left_sction"> <input class="button_06" type="button" value="View by Reply Date >>" />  <input class="button_06" type="button" value="View Alphabetically >>" /></div>
                                             <div class="right_sction"> <input class="button_05" type="button" value="View all >>" /></div>
                                             <br />
                                        </div>-->
                                   
                                   </div>
                                   <?php } ?>
                                   
                                   
                              </div>
</div>		
								  
<script>
function show_reply_div(id)
{
	for(i=1;i<=4;i++)
	{
		if(i==id)
			$("#show"+i).show("slow");
		else	
			$("#show"+i).hide("slow");
	}
}
function show_email()
{
	if($('#chk_email').is(':checked'))
		$('#show_chk_mail').hide();
	else
		$('#show_chk_mail').show();	
	
}
function hideTotalGuest()
{

	jQuery("#divTotalGuest").hide();

}
function showTotalGuest()
{

	jQuery("#divTotalGuest").show();

}
</script>