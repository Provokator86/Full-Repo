<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>You Peel</title>
<link type="text/css" href="css/style.css" rel="stylesheet" />
<link href="css/jquery.tabs.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery.js"></script>
<script src="js/jquery.tabs.pack.js" type="text/javascript"></script>
<script type="text/javascript">
<!--
var timeout         = 500;
var closetimer		= 0;
var ddmenuitem      = 0;

// open hidden layer
function mopen(id)
{	
	// cancel close timer
	mcancelclosetime();

	// close old layer
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';

	// get new layer and show it
	ddmenuitem = document.getElementById(id);
	ddmenuitem.style.visibility = 'visible';

}
// close showed layer
function mclose()
{
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';
}

// go close timer
function mclosetime()
{
	closetimer = window.setTimeout(mclose, timeout);
}

// cancel close timer
function mcancelclosetime()
{
	if(closetimer)
	{
		window.clearTimeout(closetimer);
		closetimer = null;
	}
}

// close layer when click-out
document.onclick = mclose; 
// -->
</script>

<script type="text/javascript">
  $(function() {
	 $('#container-4').tabs({ fxFade: true, fxSpeed: 'fast' });
	 $('#container-5').tabs({ fxFade: true, fxSpeed: 'fast' });
  });
  
 
</script>
</head>

<body>
	<div id="global">
     	<!--Header Section Start-->
     	<div id="header">
          	<div class="header_top"></div>
               <div class="header_mid">
               	<div class="header_left">
                    	<a href="index.html"><img src="images/logo.png" alt="" /></a>
                    </div>
                    <div class="header_right">
                    	<div class="login">
                         	<a href="login.html">login</a>&nbsp;&nbsp;  |   &nbsp;&nbsp;<a href="signup.html">Signup</a>&nbsp;&nbsp;&nbsp; <a href="#"><img align="absmiddle" src="images/face_book.png" alt="" /></a>                         
                          </div>
    					<div class="search_box">
                         <form action="search_result_general.html" method="post">
                         	<div class="cell_01">
                              	<h1>Search for <span>(e.g. taco, cheap dinner, Max's)</span></h1>
                                   <input type="text" />
                              </div>
                         	<div class="cell_02">
                              	<h1>In <span>(Address, Neighborhood, City, State or Zip)</span></h1>
                                   <input type="text" />
                              </div>
                              <div class="cell_03">
                              	<input class="button_01" type="submit" value="GO >>" />
                              </div>
                              <div class="clear"></div>
                              </form>
                         </div>
                         
                         <div class="margin10"></div>
                    </div>
                    <div class="clear"></div>
               </div>
               <div class="header_botm">
               	<div class="botm_left">
                    	<div class="drop_down">
                         	<ul id="sddm">
                              	<li><a href="#" onmouseover="mopen('m1')" onmouseout="mclosetime()">Kolkata</a>
                                   <div id="m1" onmouseover="mcancelclosetime()" onmouseout="mclosetime()">
                                        <a href="#">Delhi</a>
                                        <a href="#">Chenni</a>
                                        <a href="#">Mumbai </a>
                                        <a href="#">London</a>
                                        <a href="#">Washington, D.C.</a>
                              	</div>
                                   </li>
                              </ul>
                         </div>
                    </div>
                    <div class="botm_right">
                    <form name=form1 method=post >
                    	<div class="cell_04">Invite friends</div>
                         <div class="cell_05"><input id="abc" type=text name=type value='Friend’s Email Address' onclick="if(this.value=='Friend’s Email Address') document.getElementById('abc').value ='';" onblur="if(this.value=='') document.getElementById('abc').value ='Friend’s Email Address';"></div>
                         <div class="cell_06"><input id="xyz" type="text" name="type" value="Your Name" onclick="if(this.value=='Your Name') document.getElementById('xyz').value ='';" onblur="if(this.value=='') document.getElementById('xyz').value ='Your Name';" /></div>
                         <div class="cell_07"><input class="button_01" type="submit" value="GO >>" /></div>
                      </form>
                    </div>
                    <div class="clear"></div>
               </div>
          </div>
          <!--Header Section End-->
          	
               <!--Body Section Start-->
          	<div id="body_part">
               	<div class="top_sction">
                    	<div class="menu">
                         	<ul>
                                <li><a href="index.html"><span>Home</span></a></li>
                                <li><a href="restaurants.html"><span>Restaurants</span></a></li>
                                <li><a href="club_pub.html"><span> Clubs &amp; Bars</span></a></li>
                                <li><a href="parks_recreation.html"><span>Fun &amp; Entertainment</span></a></li>
                                <li><a href="salon_spa.html"><span>Health &amp; Beauty</span></a></li>
                                <li><a href="add_edit_party.html"><span>Plan a party</span></a></li>
                                <li><a href="deals.html"><span>View deals</span></a></li>
                                <li><a href="get-listed.html"><span>Promote your business</span></a></li>
                           </ul>
                              <div class="clear"></div>
                         </div>
                    </div>
                    <!--Menu Section End-->
                    <div class="cont_sction">
                    	<div class="margin15"></div>
                         <div class="main_content">
                         <!--Profile start-->
                         	<div class="profile">
                              	<div class="cell_01">
                                   	<div class="image_frame"><img src="images/img_15.jpg" alt="" /></div>
                                   </div>
                                   <div class="cell_02">
                                   	<h2>Purnendu</h2>
                                        <h6><a href="#">www.urbanzing.com</a></h6>
                                        <img src="images/face_book_icon.png" alt="" /><a href="#"> Share</a>
                                   </div>
                                   <div class="cell_03">
                                   	<h5>Purnendu</h5>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                   </div>
                              	<div class="clear"></div>
                              </div>
                        <!--Profile End-->
                        		<div class="search_review_box">
                              	<input type="text" /> <input class="button_03" type="submit" value="Search reviews" />
                              </div>
                              <div class="profile_section_02">
                              	<div class="profile_left">
                                   	<h5>Accomplishments :</h5>
                                        <ul>
                                        	<li><img align="absmiddle" src="images/icon_23.png" alt="" />&nbsp;&nbsp;19 Reviews</li>
                                             <li><img align="absmiddle" src="images/icon_19.png" alt="" />&nbsp;&nbsp;6 First to review</li>
                                             <li><img align="absmiddle" src="images/icon_20.png" alt="" />&nbsp;&nbsp;1 Place added</li>
                                        </ul>
                                        <ul style="border:none;">
                                        	<li><img align="absmiddle" src="images/icon_22.png" alt="" />&nbsp;&nbsp;Burpping since <br /><span>19 13 july 2010</span></li>
                                             <li><img align="absmiddle" src="images/icon_21.png" alt="" />&nbsp;&nbsp;6 First to review</li>
                                        </ul>
                                   </div>
                              	<div class="profile_right">
                                   	<div id="container-4">
                                        	<ul >
                                                  <li><a style="font-size:14px;" href="#fragment-10">Review</a></li>
                                                  <li style="font-size:14px;">&nbsp;&nbsp;|&nbsp;&nbsp;</li>
                                                  <li><a style="font-size:14px;" href="#fragment-11">Business</a></li>
                                            </ul>
                                            <div class="clear"></div>
                                             <div id="fragment-10" style="display:block;">
                                             	<div class="profile_review">
                                                  	<div class="img_box"><a href="#"><img src="images/img_04.jpg" alt="" /></a></div>
                                                  	<div class="review_text_box">
                                                       	<h6><a href="#">jason g.</a></h6>
                                                 			<em>San Francisco, CA</em><br />
                                                       	<em><img src="images/star.png" alt="" /><img src="images/star.png" alt="" /><img src="images/star.png" alt="" /> 29/06/2010</em> &nbsp;&nbsp;<img align="absmiddle" src="images/like_btn.png" alt="" /> <a class="link_text" href="#">Like this</a> &nbsp;<img align="absmiddle" src="images/flag_icon.png" alt="" /> <a class="link_text" href="#">Review Report</a>
                                                       </div>
                                                       <div class="clear"></div>
                                                       <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                                  </div>
                                             
                                             </div>
                                             <div id="fragment-11">sdfsdffs</div>
                                        </div>
                                   
                                   </div>
                                   <div class="clear"></div>
                              </div>
                              
                             
                         </div>
                    </div>
                    
                    <div class="botm_section"></div>
               </div>
               <!--Body Section End-->
          <!--Footer Start-->
          <div id="footer">
          	<p>© Copyright 2010 All Rights Reserved You Peel</p>
               <p>Designed &amp; Developed by: Acumen Consultancy Services</p>
          </div>
          
          
     </div>
</body>
</html>
