<?php
class MyCallback{
    private $users_list;

    function __construct($users_list) {
        $this->users_list = $users_list;
    }

    public function make_user_link($matches) {
	    if (in_array($matches[1], $this->users_list)){
			return '<a href="'.base_url().'user/'.$matches[1].'">'.$matches[0].'</a>';
		}else {
			return $matches[0];
		}
    }
}

?>
