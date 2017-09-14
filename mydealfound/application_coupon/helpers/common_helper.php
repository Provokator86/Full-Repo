<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function pr($param,$is_exit = FALSE) {
    echo '<pre>';
    print_r($param);
    echo '</pre>';
    if($is_exit)
        exit();
}

?>


