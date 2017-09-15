<?php

function get_salt() {
	$ci = get_instance();
	return $ci->config->item('salt');
} 

function get_salted_password($password) {
	$ci = get_instance();
	$salt = $ci->config->item('salt');
	return sha1($salt.trim($password));
}