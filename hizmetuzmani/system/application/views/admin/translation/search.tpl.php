<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?=base_url()?>" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Multilanguage Home</title>
<link href="css/language_style.css" rel="stylesheet" type="text/css" media="screen" />
<script language="javascript" type="text/javascript" src="js/jquery/jquery-1.4.2.js"></script>
<script type="text/javascript" language="javascript" >
jQuery.noConflict();///$ can be used by other prototype which is not jquery
jQuery(function($) {
$(document).ready(function(){


/////////Submitting the form//////                                              

$("#btn_sub").click(function(){
   // $.blockUI({ message: 'Just a moment please...' });
    //var formid=$(this).attr("search");
    //$("#frm_search_"+formid).attr("action","<?php echo $search_action;?>");
   // alert("hi");
  // alert($('#txt_fulltext_src').val());
   
   
    $("#search").submit();
});                                              

/////////Submitting the form//////     


})});   

</script>

</head>
<body>
<div id="wrapper">
	<?php
	include('header.php');
	?>

	<div id="page">
	<div id="page-bgtop">
	<div id="page-bgbtm">
		<div id="content">
			<div class="post">
				<h2 class="title" style="padding-top: 0px; height: 50px; line-height: 35px;"><a style="float: left;" href="<?=base_url().'language/language_home/search/'.base64_encode($search_page)?>">Search  <?=$search_page?></a> 
                <div style="float: right;">
                <form action="language/language_home/search_process" method="post" id="search" >
                
                 <input id="txt_fulltext_src" name="txt_fulltext_src" value="<?php echo $txt_fulltext_src;?>" type="text" /> <input id="btn_sub" class="button03" type="button" onClick="javacript:void(0);"/>
                 </form> </div>
				</h2> 
			<p>
				<?php
				//if( is_array($languages) && count($languages) ) :
                //echo $txt_fulltext_src;
                 //echo "hiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii";
          /*       echo "<pre>";
                 echo "result";
                 echo "</pre>";
                  echo "<pre>";
                  print_r($result);
                  echo "</pre>";
                  echo "<pre>";
                 echo "languages";
                 echo "</pre>";
                  echo "<pre>";
                  print_r($languages);
                  echo "</pre>";
                  echo "<pre>";
                 echo "translations";
                 echo "</pre>";
                  echo "<pre>";
                  print_r($translations);
                  echo "</pre>";              */
                  
                
                  
				?>
                  <form id="search" method="post" action="">
                <table class="translations" cellpadding="5" cellspacing="1">
                <tbody>
                <tr class="top">
                <?php
                    foreach($languages as $language) :
                ?>
                    <th><?=$language?></th>
                <?php
                    endforeach;
                ?>
                </tr>

                <?php
                    $i = 0;  
                    if(is_array($display_result) && count($display_result))                    
                    foreach($display_result as $id=>$display_result) :
                ?>
                    <tr>
                        <?php
                            foreach($languages as $key=>$language) :
                        ?>
                            <td>
                            <textarea name="text_<?=$i.'_'.$key?>" rows="3" style="background-color:#fbfbfb;border:5px; solid #fbfbfb;width:100%"><?=(isset($display_result[$key]))?$display_result[$key]:''?></textarea>
                            </td>
                        <?php
                            endforeach;
                        ?>
                    </tr>
                        <input type="hidden" name="tuid_<?=$i?>" value="<?=base64_encode($id)?>" />
                <?php
                        $i++;
                    endforeach;
                ?>
                    <tr>
                        <td colspan="<?=count($languages)?>" style="height:30px;;">
                        <input type="hidden" name="counter" value="<?=$i?>" />
                        <input name="submit_translations" type="submit" value="Submit" />
                        </td>
                    </tr>
                </tbody>
                </table>
                </form>        
      
        
              
				<?php
                
                                    //endif;
				?>
				</p>	
				
				

			</div>
            
            <div class="entry" style="">
                    <p>
                        N.B. Search should be case-sensitive.
                    </p>
                </div>
			
			
		<div style="clear: both;">&nbsp;</div>
	 
		</div>

		<?php
			include('left_panel.php');
		?>

		<div style="clear:both;">&nbsp;</div>
	</div>
	</div>
	</div>
	<!-- end #page -->
</div>
	<?php
	include('footer.php');
	?>
</body>
</html>

<div id="right_panel">

    <h2><?php echo $heading;?></h2>
	<div class="info_box">From here Admin can view, add and delete the Trade.</div>
	<div class="clr"></div>

    <div id="tab_search">

    <?php /*?><div id="tabbar">

      <ul><?php //javascript:void(0)?>

        <li id="test"><a href="#div1" <?php echo ($h_search=="basic"?'class="select"':'') ?> id="1"><span>Basic Search</span></a></li>

        <li><a href="#div2" <?php echo ($h_search=="advanced"?'class="select"':'') ?> id="2"><span>Search</span></a></li>

      </ul>      

    </div><?php */?>
	<form action="language/language_home/search_process" method="post" id="search" >
                
                 <input id="txt_fulltext_src" name="txt_fulltext_src" value="<?php echo $txt_fulltext_src;?>" type="text" /> <input id="btn_sub" class="button03" type="button" onClick="javacript:void(0);"/>
                 </form>

    <div id="tabcontent">

   <div id="div2" <?php //echo ($h_search=="advanced"?"":'style="display: none;"') ?> >
	<div style="border:1px solid red; overflow:scroll; height:230px;" id="translation_box">
      <form id="search" method="post" action="">
                <table class="translations" cellpadding="5" cellspacing="1">
                <tbody>
                <tr class="top">
                <?php
                    foreach($languages as $language) :
                ?>
                    <th><?=$language?></th>
                <?php
                    endforeach;
                ?>
                </tr>

                <?php
                    $i = 0;  
                    if(is_array($display_result) && count($display_result))                    
                    foreach($display_result as $id=>$display_result) :
                ?>
                    <tr>
                        <?php
                            foreach($languages as $key=>$language) :
                        ?>
                            <td>
                            <textarea name="text_<?=$i.'_'.$key?>" rows="3" style="background-color:#fbfbfb;border:5px; solid #fbfbfb;width:100%"><?=(isset($display_result[$key]))?$display_result[$key]:''?></textarea>
                            </td>
                        <?php
                            endforeach;
                        ?>
                    </tr>
                        <input type="hidden" name="tuid_<?=$i?>" value="<?=base64_encode($id)?>" />
                <?php
                        $i++;
                    endforeach;
                ?>
                    <tr>
                        <td colspan="<?=count($languages)?>" style="height:30px;;">
                        <input type="hidden" name="counter" value="<?=$i?>" />
                        <input name="submit_translations" type="submit" value="Submit" />
                        </td>
                    </tr>
                </tbody>
                </table>
                </form>
		</div>
		
	</div>
  </div>
