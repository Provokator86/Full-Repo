<table  width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td align="center">
            <div id="pointermenu">
            <ul>
                <li><a href="<?=base_url()?>admin/home/display" <?=($this->menu_id ==1 ? 'id="selected"' : '')?>>Home</a></li>
                <li><a href="<?=base_url()?>admin/home/general" <?=($this->menu_id ==2 ? 'id="selected"' : '')?>>General</a></li>
                <li><a href="<?=base_url()?>admin/home/master" <?=($this->menu_id ==3 ? 'id="selected"' : '')?>>Master</a></li>
                <li><a href="<?=base_url()?>admin/home/cms" <?=($this->menu_id == 4 ? 'id="selected"' : '')?>>CMS</a></li>
                <li><a href="<?=base_url()?>admin/home/deals" <?=($this->menu_id == 5 ? 'id="selected"' : '')?>>DEALS</a></li>
<!--                <li><a href="<?=base_url()?>admin/home/report"  <?=($this->menu_id == 5 ? 'id="selected"' : '')?>>Report</a></li>
-->                <li ><a href="#" id="rightcorner">&nbsp;</a></li>
            </ul>
        </div>
        <br style="clear: left" />
		</td>
	</tr>
</table>