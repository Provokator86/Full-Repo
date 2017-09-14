<div id="right_panel">

    <h2><?php echo $heading;?></h2>
	<div class="info_box">From here Admin can view and translate words in different language.</div>
	<div class="clr"></div>

    <div id="tab_search">

    <?php /*?><div id="tabbar">

      <ul><?php //javascript:void(0)?>

        <li id="test"><a href="#div1" <?php echo ($h_search=="basic"?'class="select"':'') ?> id="1"><span>Basic Search</span></a></li>

        <li><a href="#div2" <?php echo ($h_search=="advanced"?'class="select"':'') ?> id="2"><span>Search</span></a></li>

      </ul>      

    </div><?php */?>
	<div id="search_translation" style="margin-bottom:5px; padding-top:5px;">
			<form action="" method="post" id="search" name="search" class="search_form" >
              <label style="font-size:12px; font-weight:bold; color:#333; margin-right:10px; float:left;">Full Text Search </label><input id="txt_fulltext_src" name="txt_fulltext_src" value="<?php echo $txt_fulltext_src;?>" type="text" /> 
			  <input id="btn_sub" class="button03" type="button" onClick="search_word('search');" value="Search"/>
            </form>
			<div class="view_all02"><a href="<?php echo admin_base_url()?>language_home/translations">View all</a></div>
			<div class="clr"></div>
	</div>

    <div id="tabcontent">

   <div id="div2" <?php //echo ($h_search=="advanced"?"":'style="display: none;"') ?> >
   
		<div style="border:1px solid red; overflow:scroll; height:500px; width:946px;" id="translation_box">
      		<?php echo $translation_list;?>
		</div>
		
		
		<div id="alphaBar">
		<ul>
		<?php
			foreach($alphabets as $key=>$values)
			{
		?>
				<li><a onclick="translation_by_letter('<?php echo encrypt($values); ?>')"><?php echo $values;?></a></li>
		<?php
			}
		?>
			<li><a onclick="translation_by_letter('<?php echo encrypt('others')?>')">Others</a></li>
		</ul>
		</div>
	</div>
  </div>
  
<script type="text/javascript">

function translation_by_letter(letter)
{

  	var letter_code	= base64_decode(base64_decode((letter))).split('#');
	var actual_letter	= letter_code[0];
	
	jQuery.ajax({
        type: "POST",
        url: '<?php echo admin_base_url()?>language_home/letter_search/',
        data: "letter="+actual_letter,
        success: function(msg){
			document.getElementById('translation_box').innerHTML=msg;
        }
    });
}

function search_word(frmid)
{	
	var frm_data	= jQuery('#'+frmid).serialize();
	
	jQuery.ajax({
			type: 'POST',
			url : '<?php echo admin_base_url()?>language_home/search/',
			data: frm_data,
			//dataType: 'json',
			
			success: function(msg)
			{
				document.getElementById('translation_box').innerHTML=msg;
			}			
	});
}
</script>