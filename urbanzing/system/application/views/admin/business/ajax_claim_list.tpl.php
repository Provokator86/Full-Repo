<?php
if($business[0]['status']==1){
 $color = ($business[0]['claim']) ? 'green':'#8B0000';
?>
<a href="<?=base_url().'admin/business/business_claim/'.$business[0]['id']?>" style="cursor:pointer;color:<?=$color?> ">Claim</a>(<?=$business[0]['claim']?>)
<?php } else {?>
Claim(<?=$business[0]['claim']?>)
<?php }?>