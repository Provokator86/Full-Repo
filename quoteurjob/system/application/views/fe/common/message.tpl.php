<?php
if(isset($this->message) && $this->message!='')
{
	if($this->message_type=='err')
		echo '<div class="error"><span class="left"><strong>'.$this->message.'</strong></span></div>';
	if($this->message_type=='succ')
		echo '<div class="success"><span class="left"><strong>'.$this->message.'</strong></span></div>';
}
?>