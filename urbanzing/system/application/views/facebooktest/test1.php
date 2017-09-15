<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>Kent is Learning CodeIgniter - Test 1</title>
</head>
<body>
        
<fb:login-button autologoutlink="true" 
                        onlogin="window.location.reload(true);"></fb:login-button>

<?
        if(isset($user)){
?>
                <p style='background-color:yellow;'>Right click and view page
                source to see a more readable screen</p>
<?
                print_r($user);         
        }
        else{
?>
                <p>If you don't log in, you can't see the magic</p>
                
<?
        }
?>



<div id="fb-root"></div>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<script>
  FB.init({appId: '131334533555448', status: true, cookie: true, xfbml: true});
  FB.Event.subscribe('auth.sessionChange', function(response) {
    if (response.session) {
      // A user has logged in, and a new cookie has been saved
        window.location.reload(true);
    } else {
      // The user has logged out, and the cookie has been cleared
    }
  });
</script>
</body>
</html>