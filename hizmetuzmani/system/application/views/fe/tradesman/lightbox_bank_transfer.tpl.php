<p>To complete your payment with bank wire, </p>   
     <div class="spacer"></div>
    <h2><?php echo $unique_code; ?></h2>
    
    <ol>
    <li>Please write down this code generated for you</li>
    <li>On your bank wire details please provide this code, to match your payment with your account</li>
    <li><span class="orange">Total amount that you need to transfer </span><span class="highlight"><?php echo $price; ?>TL</span> <span class="orange">for <?php echo $s_plan ?> subscription</span>  </li>
    <li>Please transfer the amount on our following bank account details</li>
    <li>After we receive your payment, your account will be updated within 24 hours</li>
    </ol>
    <p>Thank You</p>
    <div class="spacer"></div>  
    <div class="inner_box">
    <p class="margin05"><strong>Our Bank Wire Details:</strong></p>
<p>Hizmetuzmani Internet Hizmetleri</p>
<p> Garanti Bank  Eminönü Şubesi - İstanbul</p>
<p>643-55544333   Acount Number  (TL)</p>
<p>IBAN: TR26 2000 003333 0033 033333 03333333 99</p>
 </div>
 <div class="spacer"></div>

  
   <input  class="small_button marginright" value="<?php echo addslashes(t('Close'))?>"  type="button" onclick="reload_window();"/>

    