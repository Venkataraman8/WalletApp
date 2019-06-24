<?php

session_start();
if(!($_SESSION["user_name"]))
{
header("Location:index.php");
exit();
}

require "database_connection.php";




$name = trim($_REQUEST["name"]);
$event = trim($_REQUEST["event"]);
$total_cost= trim($_REQUEST["total_cost"]);


//get username
$members = array();
$members = $_SESSION["members"];
$number = count($members);
$amount_split = $total_cost/$number;

//get amount paid

$payments=array();

for($i=0;$i<$number;$i++)
{
	$j= $i+1;
$payments[$i]= $_REQUEST["member".$j];
}

//final insertion in events.sql
for($i=0;$i<$number;$i++)
{
	$user_name=$members[$i];
	$amount_paid=$payments[$i];
	$amount_due=$amount_paid - $amount_split;
	date_default_timezone_set("Asia/Kolkata");
	$date_time = date("y-m-d")." ".date("H:i:s");
	

$select="SELECT * from users where user_name='{$user_name}';";
$result=mysqli_query($con,$select);
$row=mysqli_fetch_row($result);
$user_id=$row[0];
	
$insert="INSERT INTO events VALUES".
"('{$name}','{$event}','{$total_cost}','{$user_name}','{$amount_paid}','{$amount_split}','{$amount_due}');";

mysqli_query($con,$insert)
or die("Error in inserting value".mysqli_error($con));

$insert="INSERT INTO wallet values('{$user_id}','E','{$date_time}','{$event}','{$name}','{$amount_paid}');";

mysqli_query($con,$insert)
or die("Error in inserting value".mysqli_error($con));
}
//calculate



$neg_array=array();
$pos_array=array();


$event_name=$event;
	$select1= "SELECT * from events where event='{$event_name}' and amount_due < 0;";
	$negative_result= mysqli_query($con, $select1) or die(mysqli_error($con));
	$i=0;
			while($row=mysqli_fetch_row($negative_result))
		{
			$neg_array[$i][0]=$row[3];
			$neg_array[$i][1]=$row[6];
			$i++;
		}
	
	$select2= "SELECT * from events where event='{$event_name}' and amount_due > 0;";
	$positive_result= mysqli_query($con, $select2) or die(mysqli_error($con));
	$j=0;
			while($row=mysqli_fetch_row($positive_result))
		{
			$pos_array[$j][0]=$row[3];
			$pos_array[$j][1]=$row[6];
			$j++;
		}



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
usort($neg_array,"neg_cmp"); //i number of elements
usort($pos_array,"pos_cmp");  //j number of elements
	

/*
for($p=0;$p<$i;$p++) echo $neg_array[$p][1];
echo "<br>";
for($q=0;$q<$j;$q++) echo $pos_array[$q][1];	
*/
	$x=0;
	$y=0;	
while($x<$i)
{
	while($y<$j)
	{
		//case 1 Same
		if(($neg_array[$x][1] + $pos_array[$y][1] < 1) && ($neg_array[$x][1] + $pos_array[$y][1]) > -1)
					{
						
						$a=$neg_array[$x][0];
						$b=$pos_array[$y][0];
						$amt=abs($pos_array[$y][1]);
						
						$sel="SELECT * from debts where lender='{$b}' and receiver='{$a}';";
						$res=mysqli_query($con,$sel);
						$row=mysqli_fetch_row($res);
						
						//if previous debt by reverse
						if($row!=NULL && $row[2]!=0)
						{
							$pending_amt=$row[2];
							
							//Simply decrease debt
										if($pending_amt>=$amt)
												{
												$update="UPDATE debts SET amount={$pending_amt}-{$amt} ".
														"where lender='{$b}' and receiver='{$a}';";
														mysqli_query($con,$update)
													   or die("Error in updating value".mysqli_error($con));
												}
										
										//Decrease and New
										else
										{
													$res_amt=$amt-$pending_amt;
													$update="UPDATE debts SET amount=0 ".
														"where lender='{$b}' and receiver='{$a}';";
														mysqli_query($con,$update)
													   or die("Error in updating value".mysqli_error($con));
													   
													   $sel="SELECT * from debts where lender='{$a}' and receiver='{$b}';";
											$res=mysqli_query($con,$sel);
											$row=mysqli_fetch_row($res);
											if($row!=NULL)
											{
												
												$update="UPDATE debts SET amount={$res_amt} ".
												"where lender='{$a}' and receiver='{$b}';";
												mysqli_query($con,$update)
											   or die("Error in updating value".mysqli_error($con));
											}
											
											else
											{
											$insert="INSERT INTO debts VALUES ('{$a}','{$b}',{$res_amt});";
											mysqli_query($con,$insert)
											or die("Error in inserting value".mysqli_error($con));	   
											}
									
						                 }
						}
						//No previous debt by reverse
						else
						{
								$sel="SELECT * from debts where lender='{$a}' and receiver='{$b}';";
								$res=mysqli_query($con,$sel);
								$row=mysqli_fetch_row($res);
								if($row!=NULL)
								{
									
									$update="UPDATE debts SET amount={$row[2]}+{$amt} ".
									"where lender='{$a}' and receiver='{$b}';";
									mysqli_query($con,$update)
								   or die("Error in updating value".mysqli_error($con));
								}
								
								else
								{
								$insert="INSERT INTO debts VALUES ('{$a}','{$b}',{$amt});";
								mysqli_query($con,$insert)
								or die("Error in inserting value".mysqli_error($con));
								}
						}
						
						$neg_array[$x][1]=0;
						$pos_array[$y][1]=0;
						
						$x++;
						$y++;
						
					}
		
		
		//Case 2 Greater Positive
		else if($neg_array[$x][1] + $pos_array[$y][1] >= 1)
					{
						$a=$neg_array[$x][0];
						$b=$pos_array[$y][0];
						$amt=abs($neg_array[$x][1]);
							
					   
						$sel="SELECT * from debts where lender='{$b}' and receiver='{$a}';";
						$res=mysqli_query($con,$sel);
						$row=mysqli_fetch_row($res);
						
						//if previous debt by reverse
						if($row!=NULL && $row[2]!=0)
						{
							$pending_amt=$row[2];
							
							//Simply decrease debt
							if($pending_amt>=$amt)
									{
									$update="UPDATE debts SET amount={$pending_amt}-{$amt} ".
											"where lender='{$b}' and receiver='{$a}';";
											mysqli_query($con,$update)
										   or die("Error in updating value".mysqli_error($con));
									}
							
							//Decrease and New
							else
									{
										$res_amt=$amt-$pending_amt;
										$update="UPDATE debts SET amount=0 ".
											"where lender='{$b}' and receiver='{$a}';";
											mysqli_query($con,$update)
										   or die("Error in updating value".mysqli_error($con));
										   
										   $sel="SELECT * from debts where lender='{$a}' and receiver='{$b}';";
								$res=mysqli_query($con,$sel);
								$row=mysqli_fetch_row($res);
								if($row!=NULL)
								{
									
									$update="UPDATE debts SET amount={$res_amt} ".
									"where lender='{$a}' and receiver='{$b}';";
									mysqli_query($con,$update)
								   or die("Error in updating value".mysqli_error($con));
								}
								
								else
								{
								$insert="INSERT INTO debts VALUES ('{$a}','{$b}',{$res_amt});";
								mysqli_query($con,$insert)
								or die("Error in inserting value".mysqli_error($con));
										   
									}
								}	
						}
						
						//No previous debt by reverse
						else
						{
								$sel="SELECT * from debts where lender='{$a}' and receiver='{$b}';";
								$res=mysqli_query($con,$sel);
								$row=mysqli_fetch_row($res);
								if($row!=NULL)
								{
									
									$update="UPDATE debts SET amount={$row[2]}+{$amt} ".
									"where lender='{$a}' and receiver='{$b}';";
									mysqli_query($con,$update)
								   or die("Error in updating value".mysqli_error($con));
								}
								
								else
								{
								$insert="INSERT INTO debts VALUES ('{$a}','{$b}',{$amt});";
								mysqli_query($con,$insert)
								or die("Error in inserting value".mysqli_error($con));
								}
						}	
						
						$neg_array[$x][1]=0;
						$pos_array[$y][1] -=$amt;
						
						$x++;
						
					}
					
		
		//Case 3 Greater Negative
		else if($neg_array[$x][1] + $pos_array[$y][1] <= -1)
					{
										
						$a=$neg_array[$x][0];
						$b=$pos_array[$y][0];
						$amt=abs($pos_array[$y][1]);
						
						$sel="SELECT * from debts where lender='{$b}' and receiver='{$a}';";
						$res=mysqli_query($con,$sel);
						$row=mysqli_fetch_row($res);
						
						//if previous debt by reverse
						if($row!=NULL && $row[2]!=0)
						{
							$pending_amt=$row[2];
							
							//Simply decrease debt
							if($pending_amt>=$amt)
									{
									$update="UPDATE debts SET amount={$pending_amt}-{$amt} ".
											"where lender='{$b}' and receiver='{$a}';";
											mysqli_query($con,$update)
										   or die("Error in updating value".mysqli_error($con));
									}
							
							//Decrease and New
							else
									{
										$res_amt=$amt-$pending_amt;
										$update="UPDATE debts SET amount=0 ".
											"where lender='{$b}' and receiver='{$a}';";
											mysqli_query($con,$update)
										   or die("Error in updating value".mysqli_error($con));
										   
										   $sel="SELECT * from debts where lender='{$a}' and receiver='{$b}';";
								$res=mysqli_query($con,$sel);
								$row=mysqli_fetch_row($res);
								if($row!=NULL)
								{
									
									$update="UPDATE debts SET amount={$res_amt} ".
									"where lender='{$a}' and receiver='{$b}';";
									mysqli_query($con,$update)
								   or die("Error in updating value".mysqli_error($con));
								}
								
								else
								{
								$insert="INSERT INTO debts VALUES ('{$a}','{$b}',{$res_amt});";
								mysqli_query($con,$insert)
								or die("Error in inserting value".mysqli_error($con));	   
								}
								
							}	
						}
						
						//No previous debt by reverse
						else
						{
								$sel="SELECT * from debts where lender='{$a}' and receiver='{$b}';";
								$res=mysqli_query($con,$sel);
								$row=mysqli_fetch_row($res);
								if($row!=NULL)
								{
									
									$update="UPDATE debts SET amount={$row[2]}+{$amt} ".
									"where lender='{$a}' and receiver='{$b}';";
									mysqli_query($con,$update)
								   or die("Error in updating value".mysqli_error($con));
								}
								
								else
								{
								$insert="INSERT INTO debts VALUES ('{$a}','{$b}',{$amt});";
								mysqli_query($con,$insert)
								or die("Error in inserting value".mysqli_error($con));
								}
						}
						
						
						$pos_array[$y][1]=0;
						$neg_array[$x][1]+=$amt;
						
						$y++;		
					}
		
		//case 4 None of the above
		else 
					{
						echo"Error" ;break;
					}			
									
	}
}


header("Location:view_groups.php");  
?>
