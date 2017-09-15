function ck_blank(field,msg)
{
    var i;
    for(i=0; i<field.length;i++)
   {
       if(strTrim(document.getElementById(field[i]).value)=='')
       {
           alert(msg[i]);
           document.getElementById(field[i]).focus();
           return false;
           break;
       }
   }
    return true;
}

function validateEmail(field,msg)
{
   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
   var i;
    for(i=0; i<field.length;i++)
   {
        if(reg.test(document.getElementById(field[i]).value) == false) 
        {
           alert(msg[i]);
           document.getElementById(field[i]).focus();
           return false;
           break;
        }
   }
   return true;
}

function strTrim(value)
{
    return value.replace(/(^\s+|\s+$)/g,'');
}

function compareValue(field,msg)
{
    var i;
    for(i=0; i<field.length;i=i+2)
   {
        if(strTrim(document.getElementById(field[i]).value) !=strTrim(document.getElementById(field[i+1]).value))
        {
           alert(msg[parseInt((i+1)/2)]);
           document.getElementById(field[i]).focus();
           return false;
           break;
        }
   }
   return true;
}

function isCurrency (field,msg)
{
    var reg    = /^(\+|-)?((\d+(\.\d\d)?)|(\.\d\d))$/;
    var i;
    for(i=0; i<field.length;i++)
   {
        if(reg.test(document.getElementById(field[i]).value) == false)
        {
            alert(msg[i]);
           document.getElementById(field[i]).focus();
           return false;
           break;
        }
   }
   return true;
}

function isInt (field,msg)
{
    var reg    = /^(\d)+$/;
    var i;
    for(i=0; i<field.length;i++)
   {
        if(reg.test(document.getElementById(field[i]).value) == false)
        {
            alert(msg[i]);
           document.getElementById(field[i]).focus();
           return false;
           break;
        }
   }
   return true;
}

function ckCkeckBox(field,msg)
{
     var i;
    for(i=0; i<field.length;i++)
    {
       if(document.getElementById(field[i]).checked==false)
       {
           alert(msg[i]);
           document.getElementById(field[i]).focus();
           return false;
           break;
       }
    }
    return true;
}

function isUrl (field,msg)
{
    var reg    = /http:\/\/[A-Za-z0-9\.-]{3,}\.[A-Za-z]{3}/;
    var i;
    for(i=0; i<field.length;i++)
   {
        if(reg.test(document.getElementById(field[i]).value) == false)
        {
            alert(msg[i]);
           document.getElementById(field[i]).focus();
           return false;
           break;
        }
   }
   return true;
}
function isNumberKey(evt)
{ //this function will not allow decimal point

	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode != 46 && (charCode < 48 || charCode > 57)))
		return false;

	return true;
}