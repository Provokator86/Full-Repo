	<div class="sorting_box"><span style="font-size:14px;color:#FA8818;">Sort Results By </span>:
			<select id="short_by" name="short_by" onchange="submit_short_archieve_page(this.value);">
				<option value="cr_date"<?php echo ($order_name == 'cr_date') ? ' selected' : ''?>>Date</option>
				<option value="title"<?php echo ($order_name == 'title') ? ' selected' : ''?>>Page Title</option>
				
			</select>
		</div>
<div class="archieve">
                    <?php
                       
						
                                            
					if($archieve_list)
                      {
                      ?>
						
                    <table class="archieve" width="100%">
                        <tr>
                            <td align="left" style="padding-top:5px;">
                                <table width="30%" cellpadding="3" cellspacing="0" border="0">
                                    <tr>
                                        <td>
                                            <h4 class="archieve_header">Archieve List </h4>
                                        </td>
                                    </tr>
                                </table>
                                <table width="98%" cellpadding="0" cellspacing="0" >
								<thead>
                                    <tr>
                                       <th  class="td_tab_main">Date</th>  
										<th class="td_tab_main">Home text title</th>
                                     								 
									</tr>
									</thead>

								<tbody>
                           <?
						   /*echo "<pre>";
						   print_r($archieve_list);
						   echo "</pre>";*/
                            foreach($archieve_list as $key=>$value)
                            {
                            
                            ?>
                                    <tr bgcolor="#e6e6e6">
                                       <td  class="columnDataGrey"> <?=date('d-m-Y',$value['cr_date'])?></td>
                                      <td  class="columnDataGrey"><a href="<?=base_url()?>archieve/show/<?=$value['id']?>/<?=$value['url']?>" target="_blank"> <?=$value['url']?></a></td>
										
										
									
                               
                                    </tr>
                                <?

                            }
                            ?>
							</tbody>
                                </table>
                            </td>
                    </tr>
                    <tr>
                        <td align="right" style="padding-right:50px;">
                            <?php echo $pagination_link;?>
							
                        </td>
  
                </table>
                            <?
                        }
                        else
                        {
                        ?>
                <table width="100%">
                    <tr>
                        <td align="center" style="padding-top:100px;">
                            No data found in database
                        </td>
                    </tr>
                </table>
                        <?
                        }
                    ?>
                </div>
			<script type="text/javascript">
			function submit_short_archieve_page(val)
			{
			 	window.location=base_url + 'archieve/index/' + val;
			
			
			}
			</script>
			