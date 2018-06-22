<?php

namespace App\Helpers;
use DB;

class Utility {

    /**
    * Returns salted encrypted password
    *
    * @param $string
    * @return string
    */
    public static function get_salted_password($password)
    {
        $salt = config('app.salt');
    	//$salt = 'iws_app';

        return sha1($salt.$password);
    }


    /**
     * Function to format input string
     *
     * @param $string
     * @return string
     */
    public static function get_formatted_string($str)
    {
        try
        {
            return htmlspecialchars(trim($str),ENT_QUOTES, 'UTF-8');
        } catch(Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }


    /**
     * Function to fetch unformatted string
     *
     * @param $string
     * @return string
     */
    public static function get_unformatted_string($str)
    {
        try
        {
            return trim($str);
        } catch(Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

}
