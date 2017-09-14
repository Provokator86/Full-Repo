<?php if (!defined('IN_PHPBB')) exit; ?></div>
    
</div><!-- /contentpadding -->



</div><!-- /wrap -->

<div style="clear: both;"></div>

<div class="footer" style='width: <?php echo (isset($this->_tpldata['DEFINE']['.']['ABSOLUTION_BOARD_WIDTH'])) ? $this->_tpldata['DEFINE']['.']['ABSOLUTION_BOARD_WIDTH'] : ''; ?>;'>
	<!-- Please do not remove the following credit line. This style is free, and attribution such as this helps to keep it in development. Thanks -->
         &copy; Absolution design by <a href="http://www.christianbullock.com">Christian Bullock</a> for <a href="http://www.bbdigest.com">phpBB Review</a>. 
    <!-- Please do not remove the above credit line. This style is free, and attribution such as this helps to keep it in development. Thanks -->
    <br /><?php echo (isset($this->_rootref['CREDIT_LINE'])) ? $this->_rootref['CREDIT_LINE'] : ''; ?>

    <?php if ($this->_rootref['TRANSLATION_INFO']) {  ?><br /><?php echo (isset($this->_rootref['TRANSLATION_INFO'])) ? $this->_rootref['TRANSLATION_INFO'] : ''; } if ($this->_rootref['DEBUG_OUTPUT']) {  ?><br /><?php echo (isset($this->_rootref['DEBUG_OUTPUT'])) ? $this->_rootref['DEBUG_OUTPUT'] : ''; } if ($this->_rootref['U_ACP']) {  ?><br /><strong><a href="<?php echo (isset($this->_rootref['U_ACP'])) ? $this->_rootref['U_ACP'] : ''; ?>"><?php echo ((isset($this->_rootref['L_ACP'])) ? $this->_rootref['L_ACP'] : ((isset($user->lang['ACP'])) ? $user->lang['ACP'] : '{ ACP }')); ?></a></strong><?php } ?>

</div>


</div><!-- /noise -->

    <script type='text/javascript'>
    // <![CDATA[
       $(function() {
          $('.tip').tipsy({fade: true, gravity: 's'});
       });
    // ]]>
    </script>
<div>
	<a id="bottom" name="bottom" accesskey="z"></a>
	<?php if (! $this->_rootref['S_IS_BOT']) {  echo (isset($this->_rootref['RUN_CRON_TASK'])) ? $this->_rootref['RUN_CRON_TASK'] : ''; } ?>

</div>
</body>
</html>