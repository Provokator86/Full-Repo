<html>
<head>
<title>LinkedIn JavaScript API Hello World</title>
<input type="text" id="aaa" name="aa" />
<!-- 1. Include the LinkedIn JavaScript API and define a onLoad callback function -->
<script type="text/javascript" src="http://platform.linkedin.com/in.js">
  api_key: eg5mg32wzpt1
  onLoad: onLinkedInLoad
  authorize: true
</script>

<script type="text/javascript">
  // 2. Runs when the JavaScript framework is loaded

  function onLinkedInLoad() {
    
    IN.Event.on(IN, "auth", onLinkedInAuth);
  }

  // 2. Runs when the viewer has authenticated

  var not_found_linkedin_address  = false ;
  function onLinkedInAuth() {
    
	var pub_url	=	document.getElementById('aaa').value;
   
    IN.API.Profile("me",pub_url).result(displayProfiles);
     setTimeout(function(){
        if(not_found_linkedin_address==false)
        {
           alert(not_found_linkedin_address); 
        }},5000);
   
   
  }

  // 2. Runs when the Profile() API call returns successfully
  /*
  function displayProfiles(profiles) {
        
    member = profiles.values[0];
    for(var propertyName in member)
    {
        alert(propertyName+":   :"+member[propertyName]) ;
    } 
    document.getElementById("profiles").innerHTML = 
      "<p id=\"" + member.id + "\">Hello " +  member.firstName + " " + member.lastName+"   "+member.id +"</p>";
       
  }
  */
  
    function displayProfiles(profiles) {
       not_found_linkedin_address  = true ; 
       var profilesDiv = document.getElementById("profiles");
        IN.User.logout();
  var members = profiles.values;
  for (var member in members) {
    profilesDiv.innerHTML += "<p>Welcome " + members[member].firstName + " " + members[member].lastName + "</p>";
  }
  }
  
  
</script>
</head>
<body>
<!-- 3. Displays a button to let the viewer authenticate -->

<script type="IN/Login"></script>

<!-- 4. Placeholder for the greeting -->

<div id="profiles"></div>

</body>
</html>
