<script type="text/javascript">
$(document).ready(function(){
   $('.add_friends').keyup(function(){
	   var value = $(this).val();
	       url= "<?php echo base_url();?>/site/face_book/friend_list";
	   if(value != ''){
	       $.post(url,{'search':value},function(html){
               $("#result").html(html).show();
	       });
	   }else{
	   $("#result").hide();
	   }return false;
   });
   jQuery("#result").live("click",function(e){ 
       var $clicked = $(e.target);
	   var $name = $clicked.find('.name').html();
	   if(!$name){
			$name = $clicked.html();
	   }
       var decoded = $("<div/>").html($name).text();
       $('#searchid').val(decoded);
   });
   jQuery(".show").live("click", function(e) { 
       var $clicked = $(e.target);
	   if (! $clicked.hasClass("add_friends")){
		  jQuery("#result").fadeOut(); 
       }
   });
   $('.tag_done').click(function(){
      var id = $('#searchid').val();
	      product_url = $('#product_tag_id').val();
	      url = "<?php echo base_url();?>site/face_book/fb_friend_notification";
	  $.post(url,{'fri_id':id,'pr_url':product_url},function(data){
	  });
   });
});
</script> 
<style type="text/css">
.content{ width:900px; margin:0 auto;}
#searchid{ width:300px; border:solid 1px #000; padding:10px; font-size:14px; }
#result { position:absolute; width:320px; padding:0px; display:none; margin-top:-5px; margin-left:73px; border-top:0px;
          overflow:hidden; border:1px #CCC solid; background-color: white; }
.show{ padding:10px; border-bottom:1px #999 dashed; font-size:15px; height:10px;}
.show:hover { background:#4c66a4; color:#FFF; cursor:pointer;}
</style>

<?php 
$this->load->view('site/popup/buy_info');
$this->load->view('site/popup/collection');
$this->load->view('site/popup/login');
$this->load->view('site/popup/post');
$this->load->view('site/popup/register');
$this->load->view('site/popup/report');
$this->load->view('site/popup/shipping');
$this->load->view('site/popup/stories');
$this->load->view('site/popup/tag');
$this->load->view('site/popup/contact_seller');
$this->load->view('site/popup/edit_comment');
?>