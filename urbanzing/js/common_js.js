function checkAll(varCkAll,varTrg)
{
 var chkAll = document.getElementById(varCkAll);
 var checks = document.getElementsByName(varTrg+'[]');
 var boxLength = checks.length;
 if ( chkAll.checked == true )
 {
  for ( i=0; i < boxLength; i++ )
   checks[i].checked = true;
 }
 else
 {
  for ( i=0; i < boxLength; i++ )
   checks[i].checked = false;
 }
}

function clearControl(cntrl,txt)
{
    if(cntrl.value==txt)
        cntrl.value='';
}

function writeControl(cntrl,txt)
{
    if(cntrl.value=='')
        cntrl.value=txt;
}

function copyText(tag)
{
//    alert('Copy this dynamic item with (Ctrl+c) and \nPaste in the text area with (Ctrl+v)');
    var temp1 = null;
//    var hidden1 = null;
    var s = document.getElementById('item_type').value;
    alert(s);
    document.getElementById('hdn_field').value = s;
//    temp1 = document.getElementById('hdn_field').createTextRange();
//    temp1.select();
//    temp1.execCommand( 'Copy' );
}

function array2json(arr) 
{
    var parts = [];
    var is_list = (Object.prototype.toString.apply(arr) === '[object Array]');

    for(var key in arr) {
     var value = arr[key];
        if(typeof value == "object") { //Custom handling for arrays
            if(is_list) parts.push(array2json(value)); /* :RECURSION: */
            else parts[key] = array2json(value); /* :RECURSION: */
        } else {
            var str = "";
            if(!is_list) str = '"' + key + '":';

            //Custom handling for multiple data types
            if(typeof value == "number") str += value; //Numbers
            else if(value === false) str += 'false'; //The booleans
            else if(value === true) str += 'true';
            else str += '"' + value + '"'; //All other things
            // :TODO: Is there any more datatype we should be in the lookout for? (Functions?)

            parts.push(str);
        }
    }
    var json = parts.join(",");
    
    if(is_list) return '[' + json + ']';//Return numerical JSON
    return '{' + json + '}';//Return associative JSON
}






var cX = 0; var cY = 0; var rX = 0; var rY = 0;
function UpdateCursorPosition(e)
{
  cX = e.pageX;
  cY = e.pageY;
}

function UpdateCursorPositionDocAll(e)
{
  cX = event.clientX;
  cY = event.clientY;
}

if(document.all)
  document.onmousemove = UpdateCursorPositionDocAll;
else
  document.onmousemove = UpdateCursorPosition;
function AssignPosition(d)
{
    if(self.pageYOffset)
    {
        rX = self.pageXOffset;
        rY = self.pageYOffset;
    }
    else if(document.documentElement && document.documentElement.scrollTop)
    {
        rX = document.documentElement.scrollLeft;
        rY = document.documentElement.scrollTop;
    }
    else if(document.body)
    {
        rX = document.body.scrollLeft;
        rY = document.body.scrollTop;
    }
    
    if(document.all)
    {
        cX += rX;
        cY += rY;
    }
    d.style.left = (cX+10) + "px";
    d.style.top = (cY+10) + "px";
}