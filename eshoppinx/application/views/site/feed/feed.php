<?php
$feedHead =  "<?xml version='1.0' encoding='UTF-8'?> 
<rss version='2.0'>
<channel>
<title>".$heading." </title>
<link>".$sitelink." </link>
<description>".$sitedescription." </description>
<language>en-us</language>
<Products>"; 
if ($productDetails != '' && count($productDetails)>0){
	foreach ($productDetails as $datafeed)
	{
	$id=$datafeed->seller_product_id;
	$title=$datafeed->product_name; 
	$link=$datafeed->created; 
	$img = array_filter(explode(',', $datafeed->image));
	$imgLink = base_url().'images/product/'.$img[0];
	if (isset($datafeed->web_link)){
		$prodLink = base_url().'user/'.$userProfileDetails->row()->user_name.'/things/'.$id.'/'.url_title($title,'-');
		$price=$currencySymbol.$datafeed->price; 
	}else {
		$prodLink = base_url().'things/'.$id.'/'.url_title($title,'-');
		$price=$currencySymbol.$datafeed->sale_price; 
	}
	
	 $feedHead .=  "
<Product>
<id>".$id."</id>
<title>".$title."</title>
<ProductImage>".$imgLink."</ProductImage>
<Price>".$price."</Price>
<link>".$prodLink."</link>
</Product>
"; 
	} 
}
$feedHead .=  "
</Products>
</channel>
</rss>";
header("Content-Type: application/rss+xml"); 
echo $feedHead;
?>

