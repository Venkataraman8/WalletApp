<?php

session_start();

if(!($_SESSION["user_name"]))
{
header("Location:index.php");
exit();
}
require "database_connection.php";

$balance=0;

$select="SELECT * from wallet where user_id =" .$_SESSION["user_id"] .";";

$result=mysqli_query($con,$select) or die(mysqli_error($con));


echo "<h1>Your Activities </h1>";
echo "<table border=5>";
echo "<tr>";
echo"<th> TYPE </th>";
echo"<th> DATE & TIME </th>";
echo"<th> TITLE </th>";
echo"<th> DESCRIPTION  </th>";
echo"<th> AMOUNT </th>";
echo"</tr>";

while($row=mysqli_fetch_row($result))
{

$type=$row[1];
$date_time=$row[2];
$title=$row[3];
$description=$row[4];
$amount=$row[5];

if($type=="E")
	$balance-=$amount;

else if($type=="I")
	$balance+=$amount;

echo "<tr>";
echo"<td>". $type."</td>";
echo"<td>". $date_time ."</td>";
echo"<td>". $title ."</td>";
echo"<td>". $description  ."</td>";
echo"<td>". $amount ."</td>";
echo"</tr>";

}

echo"</table><br/>";

echo "Balance = ".$balance."<br/>";
if($balance<500)
{
		echo"<script>";
	echo"alert('settled successfully')";
	echo"</script>";
}
echo "<a href='add_event1.php'>Add</a><br/>";
echo "<a href='remove_event1.php'>Remove</a><br/><br/><br/>";

echo "<a href='dashboard.php'>Back to DashBoard</a><br/>";
echo"<a href='index.php'>Logout</a>";




?>


<html>
<head>
<Title>View Wallet</Title>
</head>

<body>

	
</body>
</html>