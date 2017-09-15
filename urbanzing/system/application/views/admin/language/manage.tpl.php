<table id="tbl_content_area" width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr><td height="1px"></td></tr>
	<tr>
      <td align="center" valign="middle" bgcolor="#FFFFFF" style="border:1px dotted #999999;" height="100%">
	  	 <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
		  <tr>
		  	<td style="border-right:1px dotted #999999; width:25%; background:#F3F3F3;" valign="top" align="left">
			  <?php
                    $this->load->view('admin/common/menu_general.tpl.php');
                ?>
			</td>
            <td style="width:75%;" valign="top" align="left">
                <div class="sub_heading">
                    <?php
                        $this->load->view('admin/common/message_page.tpl.php');
                    ?>
  					<br/>
 
     				<form name="frm" action="<?=base_url()?>/admin/language/update_language" method="post">
						<div id=mydiv style="width:700px;height:405px;overflow:auto;
													scrollbar-face-color : #E0E0E0;
													scrollbar-shadow-color : #E0E0E0;
													scrollbar-highlight-color : #E0E0E0;
													scrollbar-3dlight-color : #655d60;
													scrollbar-darkshadow-color : #655d60;
													scrollbar-track-color : #989093;
													scrollbar-arrow-color : #655d60;
													border:0px black solid;
													"
										>
					  		<table width="98%" cellpadding="3" cellspacing="0" style="border-collapse :collapse" align="center">
								<tr>
									<td width="8%" align="center" class="columnHeadings" nowrap>
											Delete
								  	</td>
						<?
					  		foreach($lang_arr as $k => $lang)
							{
								if(!$lang['id'] || !(isset($onlylang)&& $onlylang) || ($lang['id']==$onlylang)) 
								{ 
						?>
									<td width="40%" align="center" class="columnHeadings" title="">
										<?=$lang['name']?>
										<input name="lang_ids[]" type="hidden" value="<?=$lang['id']?>" checked>
								  </td>
						<? 
								} 
							}
			  			?>
						</tr>
							<?
							foreach($word_arr as $key=>$value)
							{
                            	$color="#EEEEEE";
								if($color=="#EEEEEE")
									$color="#CFDAF3";
							?>
						<tr bgcolor="<?=$color?>" valign="middle">
					  		<td align="center" class="header" style="font-size:9px" nowrap>
								<input name="delete[]" type="checkbox" value="<?=$value['id']?>">
                         	</td>
						  <?
					  			foreach($value['lang'] as $k => $lang)
								{
									if(!$lang['id'] || !(isset($onlylang)&&$onlylang) || ($lang['id']==$onlylang)) 
									{ 
										if(!$lang['id']) 
										{ 
							?>
							<td height="25" class="header" align="center" title="<?=$value['word']?>">
								<b><?=$value['word']?></b>
								<input name="word_ids[]" type="hidden" value="<?=$value['id']?>" checked>
							</td>
							<? 
										} 
										else 
										{ 
							?>
							<td height="25" class="header" align="center">
                            	<input type="text" name="tword_<?=$value['id']?>_<?=$lang['id']?>" class="inptbox" style="width:150px;" value="<?=$lang['tword']?>">
							</td>
							<? 
										} 
									}
								}
							  ?>
							</tr>
							<?
							}
						 ?>
									  </table>
									 </div>
								 <table width="98%">
									<tr>
									  <td align="right" height="35" valign="bottom" width="56%">
									  	<input type="submit" name="submit" value="Submit" class="button">
										<input type="button" value="Back" class="button" onClick="location.href='<?=base_url()?>admin/language'">
										<input type="hidden" name="letter" value="<?=$letter?>">
										<input type="hidden" name="onlylang" value="<?=$onlylang?>">
									  </td>
									  <td width="42%" class="header" align="right">&nbsp;</td>
									</tr>
									<tr>
									  <td colspan="2">
                                          <a  href="<?=base_url()?>/admin/language/manage/a/<?=$onlylang?>" class="link2">A</a>&nbsp;|
                                          <a href="<?=base_url()?>/admin/language/manage/b/<?=$onlylang?>" class="link2">B</a>&nbsp;|
                                          <a href="<?=base_url()?>/admin/language/manage/c/<?=$onlylang?>" class="link2">C</a>&nbsp;|
                                          <a href="<?=base_url()?>/admin/language/manage/d/<?=$onlylang?>" class="link2"> D</a>&nbsp;|
                                          <a href="<?=base_url()?>/admin/language/manage/e/<?=$onlylang?>" class="link2">E</a>&nbsp;|
                                          <a href="<?=base_url()?>/admin/language/manage/f/<?=$onlylang?>" class="link2">F</a>&nbsp;|
                                          <a href="<?=base_url()?>/admin/language/manage/g/<?=$onlylang?>" class="link2">G</a>&nbsp;|
                                          <a href="<?=base_url()?>/admin/language/manage/h/<?=$onlylang?>" class="link2">H</a>&nbsp;|
                                          <a href="<?=base_url()?>/admin/language/manage/i/<?=$onlylang?>" class="link2">I | </a>&nbsp;
                                          <a href="<?=base_url()?>/admin/language/manage/j/<?=$onlylang?>" class="link2">J</a>&nbsp;|
                                          <a href="<?=base_url()?>/admin/language/manage/k/<?=$onlylang?>" class="link2">K</a>&nbsp;|
                                          <a href="<?=base_url()?>/admin/language/manage/l/<?=$onlylang?>" class="link2">L</a>&nbsp;|
                                          <a href="<?=base_url()?>/admin/language/manage/m/<?=$onlylang?>" class="link2">M</a>&nbsp;|
                                          <a href="<?=base_url()?>/admin/language/manage/n/<?=$onlylang?>" class="link2">N</a>&nbsp;|
                                          <a href="<?=base_url()?>/admin/language/manage/o/<?=$onlylang?>" class="link2">O</a>&nbsp;|
                                          <a href="<?=base_url()?>/admin/language/manage/p/<?=$onlylang?>" class="link2">P</a>&nbsp;|
                                          <a href="<?=base_url()?>/admin/language/manage/q/<?=$onlylang?>" class="link2">Q</a>&nbsp;|
                                          <a href="<?=base_url()?>/admin/language/manage/r/<?=$onlylang?>" class="link2">R</a>&nbsp;|
                                          <a href="<?=base_url()?>/admin/language/manage/s/<?=$onlylang?>" class="link2">S</a>&nbsp;|
                                          <a href="<?=base_url()?>/admin/language/manage/t/<?=$onlylang?>" class="link2">T</a>&nbsp;|
                                          <a href="<?=base_url()?>/admin/language/manage/u/<?=$onlylang?>" class="link2">U</a>&nbsp;|
                                          <a href="<?=base_url()?>/admin/language/manage/v/<?=$onlylang?>" class="link2">V</a>&nbsp;|
                                          <a href="<?=base_url()?>/admin/language/manage/w/<?=$onlylang?>" class="link2">W</a>&nbsp;|
                                          <a href="<?=base_url()?>/admin/language/manage/x/<?=$onlylang?>" class="link2">X</a>&nbsp;|
                                          <a href="<?=base_url()?>/admin/language/manage/y/<?=$onlylang?>" class="link2">Y</a>&nbsp;|
                                          <a href="<?=base_url()?>/admin/language/manage/z/<?=$onlylang?>" class="link2">Z</a>&nbsp;|
                                          <a href="<?=base_url()?>/admin/language/manage/other/<?=$onlylang?>" class="link2">Others</a>
                                      </td>
									</tr>
								 </table>
								 </form>
								 <script language="JavaScript">
									document.getElementById('mydiv').style.display='none';
									setTimeout("document.getElementById('mydiv').style.display='block'",100);
								 </script>
									<!---------------page html data end --------------->

<script language="JavaScript">
function changeAF(id)
{
	location.href="to_list_language.php?change=af&id="+id;
}
function changeFF(id)
{
	location.href="to_list_language.php?change=ff&id="+id;
}
</script>



                    
                    
                </div>
            </td>
		  </tr>
		 </table>
	  </td>
    </tr>
	<tr><td height="1px;"></td></tr>
  </table>