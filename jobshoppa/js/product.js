

/*
 * Image Gallery Popup methods
 */
function imagePopup(show)
{
    var divPopup = document.getElementById("featureImg");
    var imgShow = document.getElementById(show);
    if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)){ //test for MSIE x.x;
        var ieversion=new Number(RegExp.$1) // capture x.x portion and store as a number
        if (ieversion==6)
        {   //swap png with jpg
            show = show.replace(/png/, "jpg");
        }
    }
    divPopup.innerHTML = "<img src='" + show + "' />";
}
function imagePopupHide()
{
    var divPopup = document.getElementById("popup");
    divPopup.innerHTML = "";
}

/*
 * Tab Toggle
 */
function tabToggle(show, hide, color)
{
    var tabShow = document.getElementById("img" + show);
    var tabShowOff = document.getElementById("img" + show + "0");
    var tabHide = document.getElementById("img" + hide);
    var tabHideOff = document.getElementById("img" + hide + "0");
    tabShow.style.display = "block";
    tabShowOff.style.display = "none";
    tabHide.style.display = "none";
    tabHideOff.style.display = "block";
    //tabShow.src = "/media/css/images/product/product" + show + "_" + color + ".gif";
    //tabHide.src = "/media/css/images/product/product" + hide + ".gif";

    var contentShow = document.getElementById("content" + show);
    var contentHide = document.getElementById("content" + hide);
    contentShow.style.display = "block";
    contentHide.style.display = "none";
}

/*
sfHover = function() {
    var sfEls = document.getElementById("lists").getElementsByTagName("a");
    for (var i = 0; i < sfEls.length; i++) {
        sfEls[i].onmouseover = productPopup("popup", sfEls[i]);
    }
}
if (window.attachEvent) window.attachEvent("onload", sfHover);
*/

function productPopup(theUL, current) {
    var ul = document.getElementById(theUL);
    var content = current.getElementsByTagName("div")[0];
    var pt = content.getElementsByTagName("div")[0];
    var dTop = productPopup_getTopPos(current) - 270;
    content.style.display = "block";
    if (productPopup_getTopPos(current) > 425 && content.offsetHeight > 525)
    {
        dTop -= 150;
        pt.style.top = 430 + 'px';
        //alert(content.offsetHeight);
    }
    if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)) { //test for MSIE x.x;
        var ieversion = new Number(RegExp.$1) // capture x.x portion and store as a number
        if (ieversion == 6) {
            if (productPopup_getTopPos(current) > 425 && content.offsetHeight > 475) {
                dTop = productPopup_getTopPos(current) - 270 - 100;
                pt.style.top = 380 + 'px';
            }
        }
    }
    var dLeft = productPopup_getLeftPos(ul) + ul.offsetWidth - 35;    
    
    content.style.top = dTop + 'px';
    content.style.left = dLeft + 'px';
}



function productPopupR(theUL, current) {
    var ul = document.getElementById(theUL);
    var content = current.getElementsByTagName("div")[0];
    var pt = content.getElementsByTagName("div")[0];
    var dTop = productPopup_getTopPos(current) - 270;
    content.style.display = "block";
    if (productPopup_getTopPos(current) > 425 && content.offsetHeight > 525)
    {
        //alert(content.offsetHeight);
        dTop -= 150;
        pt.style.top = 430 + 'px';
    }
    if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)) { //test for MSIE x.x;
        var ieversion = new Number(RegExp.$1) // capture x.x portion and store as a number
        if (ieversion == 6) {
            if (productPopup_getTopPos(current) > 425 && content.offsetHeight > 475) {
                dTop = productPopup_getTopPos(current) - 270 - 100;
                pt.style.top = 380 + 'px';
            }
        }
    }
    var dLeft = productPopup_getLeftPos(ul) - ul.offsetWidth - 190;

    content.style.top = dTop + 'px';
    content.style.left = dLeft + 'px';
}

function productPopupHide(current) {
    var content = current.getElementsByTagName("div")[0];
    content.style.display = "none";
}
function productPopup_getTopPos(inputObj) {
    var returnValue = inputObj.offsetTop;
    while ((inputObj = inputObj.offsetParent) != null) {
        if (inputObj.tagName != 'HTML') returnValue += inputObj.offsetTop;
    }
    return returnValue;
}

function productPopup_getLeftPos(inputObj) {
    var returnValue = inputObj.offsetLeft;
    while ((inputObj = inputObj.offsetParent) != null) {
        if (inputObj.tagName != 'HTML') returnValue += inputObj.offsetLeft;
    }
    return returnValue;
}


/*
	Developed by Robert Nyman, http://www.robertnyman.com
	Code/licensing: http://code.google.com/p/getelementsbyclassname/
*/	
var getElementsByClassName = function (className, tag, elm){
	if (document.getElementsByClassName) {
		getElementsByClassName = function (className, tag, elm) {
			elm = elm || document;
			var elements = elm.getElementsByClassName(className),
				nodeName = (tag)? new RegExp("\\b" + tag + "\\b", "i") : null,
				returnElements = [],
				current;
			for(var i=0, il=elements.length; i<il; i+=1){
				current = elements[i];
				if(!nodeName || nodeName.test(current.nodeName)) {
					returnElements.push(current);
				}
			}
			return returnElements;
		};
	}
	else if (document.evaluate) {
		getElementsByClassName = function (className, tag, elm) {
			tag = tag || "*";
			elm = elm || document;
			var classes = className.split(" "),
				classesToCheck = "",
				xhtmlNamespace = "http://www.w3.org/1999/xhtml",
				namespaceResolver = (document.documentElement.namespaceURI === xhtmlNamespace)? xhtmlNamespace : null,
				returnElements = [],
				elements,
				node;
			for(var j=0, jl=classes.length; j<jl; j+=1){
				classesToCheck += "[contains(concat(' ', @class, ' '), ' " + classes[j] + " ')]";
			}
			try	{
				elements = document.evaluate(".//" + tag + classesToCheck, elm, namespaceResolver, 0, null);
			}
			catch (e) {
				elements = document.evaluate(".//" + tag + classesToCheck, elm, null, 0, null);
			}
			while ((node = elements.iterateNext())) {
				returnElements.push(node);
			}
			return returnElements;
		};
	}
	else {
		getElementsByClassName = function (className, tag, elm) {
			tag = tag || "*";
			elm = elm || document;
			var classes = className.split(" "),
				classesToCheck = [],
				elements = (tag === "*" && elm.all)? elm.all : elm.getElementsByTagName(tag),
				current,
				returnElements = [],
				match;
			for(var k=0, kl=classes.length; k<kl; k+=1){
				classesToCheck.push(new RegExp("(^|\\s)" + classes[k] + "(\\s|$)"));
			}
			for(var l=0, ll=elements.length; l<ll; l+=1){
				current = elements[l];
				match = false;
				for(var m=0, ml=classesToCheck.length; m<ml; m+=1){
					match = classesToCheck[m].test(current.className);
					if (!match) {
						break;
					}
				}
				if (match) {
					returnElements.push(current);
				}
			}
			return returnElements;
		};
	}
	return getElementsByClassName(className, tag, elm);
};

function init() 
{
/*    var hOffset = 0;
    //if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)) hOffset=40;
    var h=0;
    var ls = getElementsByClassName("lists", "div");
    var lists = getElementsByClassName("list", "div");
    if (ls.length > 0) h = ls[0].offsetHeight; // - hOffset;
    if (lists.length > 4) { h = (h + hOffset) / 2; hOffset = 10; }
    for(var i=0, l=lists.length; i<l; i++){
        var list = lists[i];
        if (list.offsetHeight-hOffset > h) h=list.offsetHeight-hOffset;
    }
    for (var i = 0, l = lists.length; i < l; i++) {
        lists[i].style.height = h + 'px';
        //lists[i].style.styleFloat = 'left';
    }
*/
	//Fixed the bug for extra height: Suvendu Patra
    var hOffset = 0;
    //if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)) hOffset=40;
    var h=0;
    var ls = getElementsByClassName("lists", "div");
    var lists = getElementsByClassName("list", "div");
    if (ls.length > 0) h = ls[0].offsetHeight; // - hOffset;
    if (lists.length > 4) { 
		h = (h + hOffset) / 2; 
		hOffset = 10;
		
		for(var i=0, l=4; i<l; i++){
			var list = lists[i];
			if (list.offsetHeight-hOffset > h) h=list.offsetHeight-hOffset;
			//alert(h);
		}
		for (var i = 0, l = 4; i < l; i++) {
			lists[i].style.height = h + 'px';
			//lists[i].style.styleFloat = 'left';
		}
		for(var i=4, l=lists.length; i<l; i++){
			var list = lists[i];
			if (list.offsetHeight-hOffset > h) h=list.offsetHeight-hOffset;
		}
		for (var i = 4, l = lists.length; i < l; i++) {
			lists[i].style.height = h + 'px';
			//lists[i].style.styleFloat = 'left';
		}		
	}else{
		for(var i=0, l=lists.length; i<l; i++){
			var list = lists[i];
			if (list.offsetHeight-hOffset > h) h=list.offsetHeight-hOffset;
		}
		for (var i = 0, l = lists.length; i < l; i++) {
			lists[i].style.height = h + 'px';
			//lists[i].style.styleFloat = 'left';
		}		
	}
}

function addEvent(obj, evType, fn){ 
 if (obj.addEventListener){ 
   obj.addEventListener(evType, fn, false); 
   return true; 
 } else if (obj.attachEvent){ 
   var r = obj.attachEvent("on"+evType, fn); 
   return r; 
 } else { 
   return false; 
 } 
}
addEvent(window, 'load', init);