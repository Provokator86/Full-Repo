<table width="100%" cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                      <tr>
                                                            <th   align="center" valign="middle"  class="margin00"><?php echo addslashes(t('Type')) ; ?> </th>
                                                            <th   align="center" valign="middle"  class="margin00"><?php echo addslashes(t('Price')) ; ?>(TL) </th>
                                                            <th   align="center" valign="middle"  class="margin00"><?php echo addslashes(t('Date')) ; ?></th>
                                                            <th   align="center" valign="middle" class="margin00"><?php echo addslashes(t('Expiry date')) ; ?></th>
                                                            <th   align="center" valign="middle" class="margin00"><?php echo addslashes(t('Receipt')) ; ?></th>
                                                      </tr>
<?php 
if(!empty($membership_history))
{
    foreach($membership_history as $val)
    { ?>
         <tr class="bgcolor">
            <td valign="middle" align="center" class="leftboder"><?php echo $val['s_plan_type'] ; ?></td>
            <td valign="middle" align="center" ><?php echo $val['d_price'] ; ?></td>
            <td valign="middle" align="center" ><?php echo $val['dt_created_on'] ; ?></td>
            <td valign="middle" align="center" ><?php echo $val['dt_expired_date'] ; ?></td>
            <td valign="middle" align="center" ><?php  if($val['s_invoice_pdf_name']) { ?>
             <a href="<?php echo base_url().'tradesman/download_it/'.encrypt($val['s_invoice_pdf_name']).'/'.$download_path; ?>"><img src="images/fe/pdf_icon.gif" alt="download" title="<?php echo addslashes(t('Download')) ; ?>" /></a>
             <?php }  ?> </td>
         </tr>
         
    
    <?php    
    }
}
?>
	</tbody>
 </table>
 