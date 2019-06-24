<?php






function neg_cmp($a, $b)
{
    if ($a[1] == $b[1]) {
        return 0;
    }
    return ($a[1] < $b[1]) ? -1 : 1;
}

function pos_cmp($a, $b)
{
    if ($a[1] == $b[1]) {
        return 0;
    }
    return ($a[1] > $b[1]) ? -1 : 1;
}
$neg_array=array();
$pos_array=array();
function calculate($event_name)
{
	
	require "database_connection.php";
	$select= "SELECT * from events where event='{$event_name}' and amount_due < 0;";
	$negative_result= mysqli_query($con, $select) or die(mysqli_error($con));
	$i=0;
			while($row=mysqli_fetch_row($negative_result))
		{
			$neg_array[0][$i]=$row[3];
			$neg_array[1][$i]=$row[6];
			$i++;
		}
	
	$select= "SELECT * from events where event='{$event_name}' and amount_due > 0;";
	$positive_result= mysqli_query($con, $select) or die(mysqli_error($con));
	$j=0;
			while($row=mysqli_fetch_row($positive_result))
		{
			$pos_array[0][$i]=$row[3];
			$pos_array[1][$i]=$row[6];
			$j++;
		}
	
	
usort($neg_array,"neg_cmp"); //i number of elements

usort($pos_array,"pos_cmp");  //j number of elements
	
	
	
	$x=0;
	$y=0;	
while($x<$i)
{
	while($y<$j)
	{
		if($neg_array[1][$x] + $pos_array[1][$y] <1 && $neg_array[1][$x] + $pos_array[1][$y] > -1)
					{
						payment($neg_array[0][$x],$pos_array[0][$y],$pos_array[1][$y]);
						$x++;
						$y++;
					}
		
		else if($neg_array[1][$x] + $pos_array[1][$y] >= 1)
					{
						payment($neg_array[0][$x],$pos_array[0][$y],abs($neg_array[1][$x]));
						$x++;
						
					}
		else if($neg_array[1][$x] + $pos_array[1][$y] <= -1)
					{
						payment($neg_array[0][$x],$pos_array[0][$y],abs($pos_array[1][$y]));
						$y++;		
					}
					
									
	}
}
	
	

	
}


function payment( $a , $b, $amt)
{
	
	$insert="INSERT INTO debts VALUES ('{$a}','{$b}',{$amt});";
	
	mysqli_query($con,$insert)
    or die("Error in inserting value".mysqli_error($con));
}
?>