<img src="./images/lighter.png" alt="Sign in with Twitter" onclick="myWindow=window.open('http://acumencs.com/tripezi/twitt/redirect.php','Twitter varification','width=600,height=300')"/>

<script type="text/javascript">
function test(qqq)
{
	alert(qqq);
}
</script>
<?php
if(isset($_SESSION['twitter_return_data']))
{
	print_r($_SESSION['twitter_return_data']);
}
?>