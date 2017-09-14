




//FROM HERE GIVEN CALENDER.PHP.............

function goLastMonth(month,year)
    {
        // If the month is January, decrement the year.
        if(month == 1)
    {
    --year;
    month = 13;
    }       
        document.location.href = 'holiday_list_all.php?month='+(month-1)+'&year='+year;
    }
   
 function goNextMonth(month,year)
    {
        // If the month is December, increment the year.
        if(month == 12)
    {
    ++year;
    month = 0;
    }   
        document.location.href = 'holiday_list_all.php?month='+(month+1)+'&year='+year;
    }
 function goLastYear(month,year) 
 {
	 --year;
	  document.location.href = 'holiday_list_all.php?month='+month+'&year='+year;
 }	
	
 function goNextYear(month,year) 
 {
	 ++year;
	  document.location.href = 'holiday_list_all.php?month='+month+'&year='+year;
 }
