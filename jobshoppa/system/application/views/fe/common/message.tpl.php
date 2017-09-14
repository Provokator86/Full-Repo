<?php
if(isset($this->message) && $this->message!='')
{
	if($this->message_type=='err')
		echo '<div class="error_massage">'.$this->message.'</div>';
	if($this->message_type=='succ')
		echo '<div class="success_massage">'.$this->message.'</div>';
}
?>