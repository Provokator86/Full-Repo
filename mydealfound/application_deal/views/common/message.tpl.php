<?php 
//echo 123;$this->message;exit;
if(isset($this->message) && $this->message!='')
{
	if($this->message_type=='err')
		echo '<h3 class="error_massage">'.$this->message.'</h3>';
	if($this->message_type=='succ')
		echo '<h3 class="success_message">'.$this->message.'</h3>';
}
?>
