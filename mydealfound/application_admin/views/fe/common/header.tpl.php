

<script type="text/javascript">

function form_submit(frm_id)

{	

	var search=$('#s_search').val();

	if(search=='Type a Store or Product name here' || search=='')

	{

		return false;

	}

	else

	{

		$(frm_id).submit();

	}

}

</script>

<div class="head_banner">

                <div class="header">

                    <div class="menu">

                    

                        <nav>

                            <ul class="menu2" id="menu">

                                <li <?php if($header==1){ echo 'class="first"'; }?>><a href="<?php echo base_url();?>">Home</a></li>

                            	<li  <?php if($header==5){ echo 'class="first"'; }?>><a href="<?php echo base_url();?>new-coupon">New Coupons</a></li>

                            	<li <?php if($header==6){ echo 'class="first"'; }?>><a href="<?php echo base_url();?>top-coupon">Top Coupons</a></li>

                            	<li <?php if($header==3){ echo 'class="first"'; }?>><a href="<?php echo base_url().'store';?>">Stores</a></li>

                                <li class="dd-menu"><a href="javascript:void(0)" class="menulink">Category</a>

                                	<ul>

                                    	<h2>Select a <span>Category</span></h2>

                                    	<?php 

											if(!empty($category_header))

											{

												foreach($category_header as $key=>$val)

												{

										?>

                                    				<li><a href="<?php echo base_url().'category/detail/'.$val['s_url']?>"><?php echo $val['s_category'];?></a></li>

                                        <?php

												}

											}

										?>

                                       <!-- <li><a href="#">Category2</a></li>-->

                                    </ul>

                                </li>

                                <li class="dd-menu"><a href="javascript:void(0)" class="menulink">Offers</a>

                                	<ul>

                                    	<h2>Select a <span>offer</span></h2>

                                    	<?php if($offer_header)

										{

											foreach($offer_header as $val )

											 {

											?>

                                    	<li><a href="<?php echo base_url().'offer/detail/'.$val['s_url']?>"><?php echo $val['s_offer'];?></a></li>

                                        <?php 

											}

										}

										?>

                                        

                                    </ul>

                                </li>

                                <li <?php if($header==2){ echo 'class="first"'; }?>><a href="<?php echo base_url().'contact';?>">Contact Us</a></li>

								<li><a href="<?php echo base_url();?>blog">Blog</a></li>
								
                                <?php if($festive_offer_header) {?>

                                <li class="new-offer-tab"><a href="<?php echo base_url().'offer/detail/'.$festive_offer_header[0]['s_url']?>"><?php echo $festive_offer_header[0]['s_offer'];?></a></li>

                                <?php }?>

                                

                                <div class="clear"></div>

                            </ul>

                             

                        </nav>

                        <div class="clear"></div>

                    </div>

                    <div class="logo_search">

                        <div class="logo">

                            <h1><a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>images/fe/logo.png" alt="logo"/></a></h1>

                        </div>

                        <div class="search">

                        <?php echo $search_error;?>

                            <form method="post" action="<?php echo base_url()."home/search"?>" id="search">

                                <input type="text" value="Type a Store or Product name here" onclick="if(this.value=='Type a Store or Product name here')this.value='';" onblur="if(this.value=='')this.value='Type a Store or Product name here';" name="s_search" id="s_search"/>

                                <input type="button" onclick="form_submit(search)"/>

                            </form>

                        </div>

                    </div>

                     

                    <div class="clear"></div>

                    

                </div>  

                

                	

            </div>

            

<script>



/* $("#s_search").autocomplete("<?php echo base_url();?>common_ajax/auto_store", {

    width: 228,

    selectFirst: true,

    minChars: 1,

    multiple: false,

    matchContains: false,

    formatItem: formatItem

   }).result(function(event, item) {      

   var ss = item+'';

   var aa = ss.split(",");

   //$("#s_search").val(aa[1]);     

    });

function setTextToSearch(passesParam){

	$('#s_search').val(passesParam);

	}

function formatItem(row) 

{

 if(row[0]!="No match found")

  return  "<span style='font-size:16px; width:512px; font-family:KalingaRegular; font-weight:normal; margin:0px; padding: 3px 5px ;    cursor: pointer; display:block;' onclick='setTextToSearch(\""+row[0]+"\");'>" + row[0]+"</span>";

 else

  return " (<span style='font-size:14px; width:512px; font-family:Trebuchet MS, Arial, sans-serif;font-weight:bold; onclick='setTextToSearch(\'"+row[0]+"\');'>" +row[0]+"</span>)";

}

*/



</script>

<!--GA Code by Sandip-->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-39710937-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<!--GA Code by Sandip-->