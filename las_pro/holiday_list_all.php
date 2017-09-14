<?php 
include('layout/header.php');
include('layout/sidebar.php');
include('layout/top_content.php');

// Get values from query string
$day = $_GET["day"];
$month = $_GET["month"];
$year = $_GET["year"];

if($day == "") $day = date("j")*1;

if($month == "") $month = date("m")*1;

if($year == "") $year = date("Y");

$currentTimeStamp = strtotime("$year-$month-$day");
$monthName = date("F", $currentTimeStamp);
$numDays = date("t", $currentTimeStamp);
$counter = 0;



$sql="SELECT d_date,s_for FROM holidays WHERE d_date BETWEEN '".$year."-".$month."-01' AND  '".$year."-".$month."-".$numDays."'";
$result	=	$database->get_query($sql);
while($row=mysql_fetch_assoc($result))
{
	$sel_day_arr[$row['d_date']]	= $row['s_for'];	
	
}

?>
<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					<div class="left_corner"></div>
                    <div class="mid_section">
						<h2>Holiday List</h2>	
					</div>
                    <div class="right_corner"></div>
										
				</div> <!-- End .content-box-header -->
				
				<div class="content-box-content">
					
					<div class="tab-content default-tab" id="tab1"> <!-- This is the target div. div's tab -->
		
<form action="" method="post">
	<table width='175' cellspacing='0' cellpadding='0' class="body123" border="0" align="center">	
	<tr align="center">
			
        <td width='20' colspan='1'>
        <input type='button' class='button' value=' <<?php echo date('M',strtotime($year.'-'.($month-1).'-'.$day)); ?> ' onclick='<?php echo "goLastMonth($month,$year)"; ?>'>
        </td>
		<td width='20' colspan='2'>
        <input type='button' class='button' value=' <<<?php echo $year-1; ?> ' onclick='<?php echo "goLastYear($month,$year)"; ?>'>
        </td>
        <td width='95' align="center" colspan='2'>
        <span class='title'><?php echo $monthName . " " . $year; ?></span><br>
        </td>
		<td width='20' colspan='1'>
        <input type='button' class='button' value=' <?php echo $year+1; ?>>> ' onclick='<?php echo "goNextYear($month,$year)"; ?>'>
        </td>
        <td width='20' colspan='1' align='right'>
        <input type='button' class='button' value=' <?php if($month==12) $month=0; echo date('M',strtotime($year.'-'.($month+1).'-'.$day)); ?>> ' onclick='<?php echo "goNextMonth($month,$year)"; ?>'>
        </td>
		
    </tr>
    <tr>
        <td class='head' align="center" width='25'>SUN</td>
        <td class='head' align="center" width='25'>MON</td>
        <td class='head' align="center" width='25'>TUE</td>
        <td class='head' align="center" width='25'>WED</td>
        <td class='head' align="center" width='25'>THU</td>
        <td class='head' align="center" width='25'>FRI</td>
        <td class='head' align="center" width='25'>SAT</td>
    </tr>
	<tr>
<?php
    for($i = 1; $i < $numDays+1; $i++, $counter++)
    {
        $timeStamp = strtotime("$year-$month-$i");
        if($i == 1)
        {
        // Workout when the first day of the month is
        $firstDay = date("w", $timeStamp);
       
        for($j = 0; $j < $firstDay; $j++, ++$counter)
        echo "<td class='tr123' align='center'>  &nbsp;</td>";
        }
      
        if($counter % 7 == 0)
        echo "</tr><tr>";
       
        if(date("w", $timeStamp) == 0)

        $class = "weekend";
        else
        if($i == date("d") && $month == date("m") && $year == date("Y"))
        $class = "today";
        else
        $class = "normal";		
		
			
			if(!empty($sel_day_arr))
			{
				foreach($sel_day_arr as $key=>$val)
				{
					if($i<10)
						$i	=	'0'.$i;
					if($month<10)
						$month	=	'0'.$month;
					//echo $key.'=='.$year.'-'.$month.'-'.$i;	
					if($key==$year.'-'.$month.'-'.$i)
					{
						$class = "weekend";
						$reson[$i*1]	=	$val;
						
					}
					
					$i	=	$i*1;
					$month	=	$month*1;
				}
			}
		
		
       
        echo "<td class='tr123 ".$class."' align='center'>$i<div class='reson'>$reson[$i]</div></td>";
    }
	//echo $counter;
	for($k=$counter;$k<42;$k++)
	{      
		if($k % 7 == 0)  
		echo "</tr><tr>";
		
		echo "<td class='tr123 ".$class."' align='center' > &nbsp;</td>";
		
	}
	
	
?>
    </tr>
	</table>
</form>


	</div> <!-- End #tab1 -->				
				  					
		</div> <!-- End .content-box-content -->
				
		  </div>
	
<?php
include('layout/footer.php');
?>