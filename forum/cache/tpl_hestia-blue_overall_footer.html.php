<?php if (!defined('IN_PHPBB')) exit; if (! $this->_rootref['S_IS_BOT']) {  echo (isset($this->_rootref['RUN_CRON_TASK'])) ? $this->_rootref['RUN_CRON_TASK'] : ''; } if ($this->_tpldata['DEFINE']['.']['CA_SHOW_COPYRIGHT_COMMENT']) {  ?>

<pre>
	We request you retain the full copyright notice below including the link to www.phpbb.com.
	This not only gives respect to the large amount of time given freely by the developers
	but also helps build interest, traffic and use of phpBB3. If you (honestly) cannot retain
	the full copyright we ask you at least leave in place the "Powered by phpBB" line, with
	"phpBB" linked to www.phpbb.com. If you refuse to include even this then support on our
	forums may be affected.

	The phpBB Group : 2006

	//
	//	From Vjacheslav Trushkin:
	//

	You are allowed to use this phpBB style only if you agree to the following conditions:
	- You cannot remove my copyright notice from style without my permission.
	- You cannot use images from this style anywhere else without my permission.
	- You cannot convert this style to another software without my permission.
	- If you want to create new phpBB style based on this style you must ask my permission (unless its for your own use only).
	- If you modify this style it still should have my copyright notice because it is based on my work. Modified style should not be available for download without my permission.

	If you don't like these conditions, don't use this style.

	For support visit http://www.stsoftware.biz/forum
</pre>
<?php } ?>


<div id="wrapfooter">
	<?php if ($this->_rootref['U_ACP']) {  ?><span class="gensmall">[ <a href="<?php echo (isset($this->_rootref['U_ACP'])) ? $this->_rootref['U_ACP'] : ''; ?>"><?php echo ((isset($this->_rootref['L_ACP'])) ? $this->_rootref['L_ACP'] : ((isset($user->lang['ACP'])) ? $user->lang['ACP'] : '{ ACP }')); ?></a> ]</span><br /><br /><?php } ?>

	<span class="copyright">
	Powered by <a href="http://www.phpbb.com/">phpBB</a> &copy; phpBB Group.
	<br />Designed by <a href="http://www.stsoftware.biz/">Vjacheslav Trushkin</a> for <a href="http://www.freeforums.org" title="Free Forum Hosting">Free Forum</a>/<a href="http://www.divisioncore.com">DivisionCore</a>.
	<?php if ($this->_rootref['TRANSLATION_INFO']) {  ?><br /><?php echo (isset($this->_rootref['TRANSLATION_INFO'])) ? $this->_rootref['TRANSLATION_INFO'] : ''; } if ($this->_rootref['DEBUG_OUTPUT']) {  ?><br /><bdo dir="ltr">[ <?php echo (isset($this->_rootref['DEBUG_OUTPUT'])) ? $this->_rootref['DEBUG_OUTPUT'] : ''; ?> ]</bdo><?php } ?></span>
</div>

	</td>
</tr>
</table>

</div>
<!-- HotLog -->
<script type="text/javascript"> var hot_s = document.createElement('script');
hot_s.type = 'text/javascript'; hot_s.async = true;
hot_s.src = 'http://js.hotlog.ru/dcounter/2324227.js';
hot_d = document.getElementById('hotlog_dyn');
hot_d.appendChild(hot_s);
</script>
<noscript>
<a href="http://click.hotlog.ru/?2324227" target="_blank"><img
src="http://hit25.hotlog.ru/cgi-bin/hotlog/count?s=2324227&amp;im=302" border="0"
alt="HotLog"></a>
</noscript>
<!-- /HotLog -->
</body>
</html>