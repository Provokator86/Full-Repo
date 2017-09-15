// JavaScript Document

	function show_hide_tab_left_content(id)
	{
		var tabcount	=	5;
		var objTab	=	document.getElementById('#'+id);
        if(objTab)
        {
		for(var i=1; i<=tabcount; i++)	{
			if(id == i)	{
				if(id==1){
					objTab.className	=	'tab_leftend_selected';
				}
				else if(id==2){
					objTab.className	=	'tab_leftend_selected';
				}
				else if(id==4){
					objTab.className	=	'tab_leftend_selected';
				}
				else	{
					objTab.className	=	'tab_right_selected';
				}
				document.getElementById('div#'+id).style.display	=	'block';
			}else {
				if(document.getElementById('#'+i))
				{
					if(i==1)	{
						document.getElementById('#'+i).className	=	'tab_leftend';
					}
					else if(i==2)	{
						document.getElementById('#'+i).className	=	'tab_leftend';
					}
					else if(i==4)	{
						document.getElementById('#'+i).className	=	'tab_leftend';
					}else	{
						document.getElementById('#'+i).className	=	'tab_right';
					}
					document.getElementById('div#'+i).style.display	=	'none';
				}
			}	
		}
        }
	}
	//-----
	show_hide_tab_left_content('1');
	//================================================================
	//================================================================
	
	