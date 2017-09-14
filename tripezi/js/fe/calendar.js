 window.onload = function(){
        new JsDatePick({
            useMode:2,
            target:"inputField01",
            dateFormat:"%d-%M-%Y"
        });
        new JsDatePick({
            useMode:2,
            target:"inputField02",
            dateFormat:"%d-%M-%Y"
        });
        $(".JsDatePickBox").css('z-index',100); 
        
       $("#inputField01").focus(function(){
            
        $(".JsDatePickBox").css('display','none');
        });
         $("#inputField02").focus(function(){
            $(".JsDatePickBox").css('display','none');
        });
        
       
    };
    
    
    
     $(document).ready(function(){
        $('#inputField01').autofill({value: 'mm/dd/yyyy'});
        $('#inputField02').autofill({value: 'mm/dd/yyyy'});
        //$('#search').autofill({value: 'e.g. Berlin, Manhattan, Eiffel Tower'});

    });
