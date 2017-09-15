<?
 if(isset($txtArray) || isset($optArray))
 {
?>
<form name="frm" action="" method="post">
    <table width="98%" border="0" cellpadding="5" cellspacing="0" style="border: 1px solid rgb(153, 153, 153);" >
        <tr>
        <?
        if(isset($txtArray))
        {
            $i=0;
            foreach ($txtArray as $key => $value)
            {
            ?>
            <td class="columnDataGrey" align="left">
                <?=$value?>:&nbsp;<input style="width:80px;" type="text" name="<?=$key?>" value="<?=$txtValue[$i]?>"/>
            </td>
            <?
                $i++;
            }
        }
        if(isset($optArray))
        {
            $i=0;
            foreach ($optArray as $key => $value)
            {
            ?>
            <td class="columnDataGrey" align="left">
                <?=$value?>:&nbsp; 
                <select style="width:100px;" name="<?=$key?>">
                    <option value="-1">Select <?=$value?></option>
                    <?=$optValue[$i]?>
                </select>
            </td>
            <?
                $i++;
            }
        }
 		if(isset($dateArray))
        {
            $i=0;
            foreach ($dateArray as $key => $value)
            {
            ?>
            <td class="columnDataGrey" align="left">
                <?=$dateCaption[$i]?>:&nbsp; 
                <?=$value?>
            </td>
            <?
                $i++;
            }
        }
        ?>
            <td class="columnDataGrey"><input type="submit" name="go" value="Go" class="button_small"></td>
        </tr>
    </table>
</form>
<?
 }
?>