<?php
session_start();
$token = $_REQUEST['token'];

if(! isset($token))
{
    $_SESSION['message']    = 'There are some problem at the time of payment.';
    $_SESSION['message_type']    = 'err';
    header('location:../user/aa');
}
else
{
    $_SESSION['paypal_return']  = $_REQUEST;
    header('location:../user/paypal_return');
}
?>