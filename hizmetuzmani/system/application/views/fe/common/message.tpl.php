<script type="text/javascript">

jQuery(function($){
$(document).ready(function(){
           setTimeout(function () {
          $('.success_massage').slideUp(1000);
          $('.error_massage').slideUp(1000);  
            }, 5000);

})  ;

});
</script>
<?php
if(isset($this->message) && $this->message!='')
{
	if($this->message_type=='err')
		echo '<div class="error_massage">'.$this->message.'</div>';
	if($this->message_type=='succ')
		echo '<div class="success_massage">'.$this->message.'</div>';
}
?>