<?php
if(isset($this->message) && $this->message!='')
{
    if($this->message_type=='err' )
    {
    ?>
    <table width="97%" border="0" cellpadding="5" cellspacing="0" class="msg_error"  >
        <tr>
            <td style="padding-left: 25px;color: #FF0000;"><?=$this->message?></td>
        </tr>
      </table>
    <?php
    }
    else
    {
        ?>
        <table width="100%" border="0" cellpadding="5" cellspacing="0" class="msg_success"  >
        <tr>
          <td style="padding-left: 25px;color: #990000;"><?=$this->message?></td>
        </tr>
      </table>
        <?php
    }
    unset($this->message);
    unset($this->message_type);
}
    ?>
