<form method=post action=https://api-3t.sandbox.paypal.com/nvp>
<input type=hidden name=USER value="acumen_1315912442_biz_api1.gmail.com">
<input type=hidden name=PWD value="1315912478">
<input type=hidden name=SIGNATURE value="AEHcRbYl-a7Jjp3401BP7o9AN3.XAM7OAepTrQuaOQJHU36qrefFUm3J">
<input type=hidden name=VERSION value=82.0>
<input type=hidden name=PAYMENTREQUEST_0_PAYMENTACTION
value=Sale>
<input name=PAYMENTREQUEST_0_AMT value=19.95>
<input type=hidden name=RETURNURL value="<?php echo base_url().'home/test_payment'?>">
<input type=hidden name=CANCELURL
value=https://www.YourCancelURL.com>
<input type=submit name=METHOD value=SetExpressCheckout>
</form>
<img src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" align="left" style="margin-right:7px;">