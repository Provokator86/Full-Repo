<script language="JavaScript" type="text/javascript">
	window.onresize	=	function() {
		var tblheader 			= document.getElementById('tbl_header');
		var tblobj 					= document.getElementById('tbl_content_area');
		tblobj.style.height = (window.innerHeight) ?  (window.innerHeight - tblheader.offsetHeight - tblfooter.offsetHeight - 4) + 'px'	:  (document.documentElement.clientHeight - tblheader.offsetHeight - tblfooter.offsetHeight - 4)+ 'px';
	};

	var tblheader 			= document.getElementById('tbl_header');
	var tblfooter 			= document.getElementById('tbl_footer');
	var tblobj 					= document.getElementById('tbl_content_area');
	tblobj.style.height = (window.innerHeight) ?  (window.innerHeight - tblheader.offsetHeight - tblfooter.offsetHeight - 4) + 'px'	:  (document.documentElement.clientHeight - tblheader.offsetHeight - tblfooter.offsetHeight - 4)+ 'px';
</script>