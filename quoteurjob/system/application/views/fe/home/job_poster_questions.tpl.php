<!--<script type="text/javascript">

var g_last_div = -1;
//===================================
//===================================
function slide_down (id)
{
	if(g_last_div == id) return;
	
	document.getElementById('accordian'+id+'_div1').style.display = 'none';
	
	$('#accordian'+id+'_div2').hide();
	$('#accordian'+id+'_div2').slideDown(500);
	
	if (g_last_div > 0 && g_last_div != id)	slide_up(g_last_div);
	g_last_div = id;
}
//===================================
//===================================
function slide_up (id)
{
	document.getElementById('accordian'+id+'_div1').style.display = 'block';
	document.getElementById('accordian'+id+'_div2').style.display = 'none';
	g_last_div = -1;
}

</script>-->
<script type="text/javascript">
<!--
var g_last_div = -1;
var already_open = 1;
var sl_new_not_called = false;
//===================================
//===================================
function slide_down (id)
{

 if(sl_new_not_called)
 {
  sl_new_not_called =false;
 }
 else
 {
  if(g_last_div == id) return;
  
  document.getElementById('accordian'+id+'_div1').style.display = 'none';
  
  $('#accordian'+id+'_div2').hide();
  $('#accordian'+id+'_div2').slideDown(500);
  if (g_last_div > 0 && g_last_div != id) slide_up(g_last_div);
  g_last_div = id;
 }
 
}
//===================================
//===================================
function slide_up (id)
{

 document.getElementById('accordian'+id+'_div1').style.display = 'block';
 document.getElementById('accordian'+id+'_div2').style.display = 'none';
 g_last_div = -1;
}

function slide_up_new (id)
{
 
 slide_up(id);
 sl_new_not_called = true;
 g_last_div = -1;
}
//-->
</script>

<div class="body_bg">
            <div class="banner">
                  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>
            </div>
            <div class="static_content">
                 
                        <h1><?php echo get_title_string(t('Buyer FAQ'))?> </span></h1>
                  
                              <div class="" id="firstpane">
                                    <div>
									<?php $cnt=1; 
										  foreach($category as $val)
										  {										   
										  
									?>
                                          <h3 style="padding-top:0px; border:0px;"><?php echo $val["s_category_name"];?></h3>
										  
										  
										  <?php 
										  	  foreach($val["ques_ans"] as $key=>$value){ 
											?>
                                          <div onclick="slide_down(<?php echo $cnt ?>)" class="accrdian">
                                                <div id="accordian<?php echo $cnt ?>_div1">
                                                      <h6><?php echo $value["s_question"] ?></h6>
                                                </div>
                                                <div id="accordian<?php echo $cnt ?>_div2" class="open_accor">
                                                      <h6 onclick="slide_up_new('<?=$cnt?>')" style="cursor:pointer;"><?php echo $value["s_question"] ?></h6>
													  <?php echo $value["s_answer"] ?>                                                      
                                          </div>
										  
                                       
                                    	</div>
										<?php 
											$cnt++;
											} 
										?>
										 <?php /*?><div style="padding-top:15px;"></div>
										<h3 style="padding-top:0px;></h3>
										<div style="padding-top:15px;"></div><?php */?>
										
                                    <?php }  ?>
									
                              </div>
							  
                  
            </div>
       
      </div>
</div>	  